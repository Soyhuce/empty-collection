<?php

use function PHPStan\Testing\assertType;

class Dummy
{
}

assertType('Illuminate\Support\Collection<int, int>', empty_collection('int', 'int'));
assertType('Illuminate\Support\Collection<int, string>', empty_collection('int', 'string'));
assertType('Illuminate\Support\Collection<string, array<string, bool>>', empty_collection('string', 'array<string, bool>'));
assertType('Illuminate\Support\Collection<int, Dummy>', empty_collection('int', Dummy::class));
assertType('Illuminate\Support\Collection<string, Dummy>', empty_collection('string', Dummy::class));
assertType('Illuminate\Support\Collection<string, Dummy>', empty_collection('string', 'Dummy'));

/** @var string $type */
assertType('Illuminate\Support\Collection<(int|string), mixed>', empty_collection('foo', $type));
