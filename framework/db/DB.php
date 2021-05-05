<?php

class DB
{
    private $sql;
    private $pdo;
    private $columns;
    private $table;
    private $result;

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
        $this->run();

        return (new Collection($this->result, $this->model))->first();
    }

    // TODO: nullに対応
    public function where($column, $value, $operator = "=", $model = null)
    {
        if ($model) {
            $this->table = $this->resolveTableName($model);
            $this->model = $model;
        }

        if (is_null($this->sql)) {
            $this->sql = "SELECT * FROM {$this->table} WHERE $column $operator :$column";
        } else {
            $this->sql .= " AND $column $operator :$column";
        }

        $this->columns[$column] = $value;
        return $this;
    }

    private function resolveTableName($model)
    {
        // TODO: esなどへの対応
        return lcfirst($model) . "s";
    }

    private function run()
    {
        $sth = $this->pdo->prepare($this->sql);
        
        foreach ($this->columns as $column => $value) {
            $sth->bindValue(":$column", $value, $this->resolveType($value));
        }

        $sth->execute();
        $this->result = $sth->fetchAll(PDO::FETCH_CLASS);
    }

    public function get()
    {
        $this->run();
        return new Collection($this->result, $this->model);
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
}