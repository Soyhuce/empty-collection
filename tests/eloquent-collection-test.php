<?php

use Illuminate\Database\Eloquent\Model;
use function PHPStan\Testing\assertType;

class DummyModel extends Model
{
}

assertType('Illuminate\Database\Eloquent\Collection<int, DummyModel>', empty_eloquent_collection('int', DummyModel::class));
assertType('Illuminate\Database\Eloquent\Collection<string, DummyModel>', empty_eloquent_collection('string', DummyModel::class));
assertType('Illuminate\Database\Eloquent\Collection<string, Illuminate\Database\Eloquent\Model>', empty_eloquent_collection('string', 'Foo'));
