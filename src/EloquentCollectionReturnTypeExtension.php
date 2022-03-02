<?php

namespace Soyhuce\EmptyCollection;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

class EloquentCollectionReturnTypeExtension extends AbstractCollectionReturnTypeExtension
{
    public function isFunctionSupported(FunctionReflection $functionReflection): bool
    {
        return $functionReflection->getName() === 'empty_eloquent_collection';
    }

    protected function collection(): string
    {
        return EloquentCollection::class;
    }

    protected function determineValueType(Expr $value): ?Type
    {
        if (!$value instanceof ClassConstFetch) {
            return null;
        }

        return new ObjectType($value->class);
    }

    protected function defaultValueType(): Type
    {
        return new ObjectType(Model::class);
    }
}
