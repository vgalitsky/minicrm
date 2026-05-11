<?php

namespace Mtr\MiniCrm\Models\Attributes;

use Illuminate\Support\Str;

trait HasTablePrefix
{
    protected const TABLE_PREFIX = 'minicrm_';

    /**
     * {@inheritDoc}
     */
    public static function tableName(): string
    {
        $modelClass = class_basename(static::class);

        return sprintf(
            '%s%s',
            static::TABLE_PREFIX,
            Str::snake(Str::plural($modelClass))
        );
    }

    /**
     * Override the getTable method to return the table name with prefix.
     * {@inheritDoc}
     */
    public function getTable(): string
    {
        return static::tableName();
    }
}