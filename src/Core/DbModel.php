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
        $statement = Application::$app->db->prepare("INSERT INTO $tableName (".implode(',', $columns).") VALUES (".implode(',', $params).")");

        foreach($columns as $column) {
            $statement->bindValue(":$column", $this->{$column});
        }
        try{
            return $statement->execute();
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
} 