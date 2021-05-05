<?php

abstract class Model
{
    protected static $table;
    private static $db;

    protected static function getTable()
    {
        return self::$table ?: self::$table = self::resolveTableName();
    }

    protected static function resolveTableName()
    {
        // TODO: esとか、複数形の対応が必要
        return lcfirst(get_called_class()) . "s";
    }

    public function first($column, $value, $operator = "=")
    {
        $this->initDB();

        return self::where($column, $value, $operator)->first();
    }

    public static function where($column, $value, $operator = "=")
    {
        self::initDB();

        return self::$db->where($column, $value, $operator, self::getTable());
    }

    private static function initDB()
    {
        if (is_null(self::$db)) {
            self::$db = new DB();
        }
    }
}