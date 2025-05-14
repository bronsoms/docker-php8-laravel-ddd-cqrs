<?php

namespace Tests\SDK\Tools\Seeder;

use Illuminate\Support\Facades\DB;
use Faker\Generator;
use Faker\Factory;

abstract class DatabaseSeeder
{
    public static function insert(string $table, array $values): bool
    {
        return DB::table($table)->insert($values);
    }

    public static function random(): array
    {
        return static::create([]);
    }

    abstract public static function create(array $params = []): array;

    final protected static function faker(): Generator
    {
        return Factory::create();
    }
}
