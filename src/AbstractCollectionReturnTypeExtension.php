<?php

namespace Soyhuce\EmptyCollection;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;

abstract class AbstractCollectionReturnTypeExtension implements DynamicFunctionReturnTypeExtension
{
    public function getTypeFromFunctionCall(
        FunctionReflection $functionReflection,
        FuncCall $functionCall,
        Scope $scope,
    ): Type {
        $keyType = $this->determineKeyType($functionCall->getArgs()[0]->value) ?? $this->defaultKeyType();
        $valueType = $this->determineValueType($functionCall->getArgs()[1]->value) ?? $this->defaultValueType();

        return new GenericObjectType($this->collection(), [$keyType, $valueType]);
    }

    abstract protected function collection(): string;

    protected function determineKeyType(Expr $value): ?Type
    {
        if (!$value instanceof String_) {
            return null;
        }

        return match ($value->value) {
            'int' => new IntegerType(),
            'string' => new StringType(),
            default => null,
        };
    }

    protected function defaultKeyType(): Type
    {
        return new BenevolentUnionType([new IntegerType(), new StringType()]);
    }

    abstract protected function determineValueType(Expr $value): ?Type;

    abstract protected function defaultValueType(): Type;
}
