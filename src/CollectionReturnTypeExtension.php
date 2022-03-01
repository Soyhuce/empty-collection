<?php

namespace Soyhuce\EmptyCollection;

use Illuminate\Support\Collection;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\NameScope;
use PHPStan\Analyser\Scope;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;

class CollectionReturnTypeExtension extends AbstractCollectionReturnTypeExtension
{
    public function __construct(protected TypeNodeResolver $typeNodeResolver)
    {
    }

    public function isFunctionSupported(FunctionReflection $functionReflection): bool
    {
        return $functionReflection->getName() === 'empty_collection';
    }

    protected function collection(): string
    {
        return Collection::class;
    }

    protected function determineValueType(Expr $value): ?Type
    {
        if ($value instanceof ClassConstFetch) {
            return new ObjectType($value->class);
        }

        if (!$value instanceof String_) {
            return null;
        }

        $lexer = new Lexer();
        $typeParser = new TypeParser(new ConstExprParser());
        $tokens = new TokenIterator($lexer->tokenize($value->value));
        $typeNode = $typeParser->parse($tokens);

        return $this->typeNodeResolver->resolve($typeNode, new NameScope(null, []));
    }

    protected function defaultValueType(): Type
    {
        return new MixedType();
    }
}
