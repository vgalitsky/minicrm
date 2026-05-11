<?php
namespace Mtr\MiniCrm\Models\Contracts;


interface HasTablePrefixInterface
{
    /**
     * Get the table name with prefix.
     *
     * @return string
     */
    public static function tableName(): string;
}