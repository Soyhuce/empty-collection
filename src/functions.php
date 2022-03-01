<?php

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

if (!function_exists('empty_collection')) {
    function empty_collection(string $key, string $type): Collection
    {
        return new Collection();
    }
}

if (!function_exists('empty_eloquent_collection')) {
    function empty_eloquent_collection(string $key, string $type): EloquentCollection
    {
        return new EloquentCollection();
    }
}
