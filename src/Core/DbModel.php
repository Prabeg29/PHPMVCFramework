<?php

namespace app\Core;

use PDOException;

abstract class DbModel extends Model {
    abstract public function tableName(): string;
    abstract public function columns(): array;

    public function save() {
        $tableName = $this->tableName();
        $columns = $this->columns();
        $params = array_map(fn($col)=>":$col", $columns);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $columns).") VALUES (".implode(',', $params).")");

        foreach($columns as $column) {
            $statement->bindValue(":$column", $this->{$column});
        }
        try{
            $statement->execute();
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function prepare($sql) {
        return Application::$app->db->pdo->prepare($sql);
    }
} 