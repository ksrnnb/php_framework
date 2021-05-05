<?php

class DB
{
    private $sql;
    private $pdo;
    private $modelName;
    private $columns;
    private $table;

    // TODO: 環境変数にする
    private $host = 'db';
    private $dbname = 'framework';
    private $username = 'root';
    private $password = 'password';

    public function __construct()
    {
        $this->connectDatabase();
    }

    private function connectDatabase()
    {
        $this->pdo = new PDO(
            "mysql:host={$this->host};dbname={$this->dbname}",
            $this->username,
            $this->password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
    }

    // TODO: nullに対応
    public function first()
    {
        $result = $this->run();
        $models = $this->resolveModels($result);

        return (new Collection($models))->first();
    }

    // TODO: nullに対応
    public function where($column, $value, $operator = "=", $model_name = null)
    {
        if ($model_name) {
            $this->modelName = $model_name;
            $this->table = $this->resolveTableName();
        }

        if (is_null($this->sql)) {
            $this->sql = "SELECT * FROM {$this->table} WHERE $column $operator :$column";
        } else {
            $this->sql .= " AND $column $operator :$column";
        }

        $this->columns[$column] = $value;
        return $this;
    }

    private function resolveTableName()
    {
        // TODO: esなどへの対応
        return lcfirst($this->modelName) . "s";
    }

    private function run()
    {
        $sth = $this->pdo->prepare($this->sql);
        
        foreach ($this->columns as $column => $value) {
            $sth->bindValue(":$column", $value, $this->resolveType($value));
        }

        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_CLASS);
    }

    public function get()
    {
        $result = $this->run();
        $models = $this->resolveModels($result);

        return new Collection($models);
    }

    private function resolveType($value)
    {
        $types = [
            'int' => PDO::PARAM_INT,
            'bool' => PDO::PARAM_BOOL,
            'string' => PDO::PARAM_STR,
        ];

        return $types[gettype($value)];
    }

    /**
     * 配列の要素を連想配列からモデルへ
     */
    private function resolveModels($properties)
    {
        $resolved = [];
        foreach ($properties as $property) {
            $resolved[] = $this->resolveModel($property);
        }

        return $resolved;
    }

    /**
     * 連想配列からモデルへ
     */
    private function resolveModel($property)
    {
        $class = $this->modelName;

        $model = new $class();
        foreach ($property as $key => $value) {
            $model->$key = $value;
        }

        return $model;
    }
}