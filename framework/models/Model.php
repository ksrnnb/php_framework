<?php

abstract class Model
{
    protected static $table;
    private static $db;

    // relation
    public function __get($name)
    {
        if (method_exists($this, $name)) {
            $this->$name();
        }
    }

    public function hasOne($class, $me_id = "", $to_id = "")
    {
        // TODO: 実装
        // $class::where();
    }

    public function hasMany($class, $me_id = "", $to_id = "")
    {
        // TODO: 実装
        // $class::where();
    }

    public function belongsTo($class, $me_id = "", $to_id = "")
    {
        // TODO: 実装
        // $class::where();
    }

    protected static function getTable()
    {
        return self::$table ?: self::$table = self::resolveTableName();
    }

    public static function first($column, $value, $operator = "=")
    {
        self::initDB();

        return self::where($column, $value, $operator)->first();
    }

    public static function where($column, $value, $operator = "=")
    {
        self::initDB();

        return self::$db->where($column, $value, $operator, get_called_class());
    }

    private static function initDB()
    {
        if (is_null(self::$db)) {
            self::$db = new DB();
        }
    }
}