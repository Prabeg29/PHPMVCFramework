<?php

namespace app\Core\DB;

use PDOException;
use app\Core\Model;
use app\Core\Application;

abstract class DbModel extends Model {
    abstract public static function tableName(): string;
    abstract public function columns(): array;
    abstract public function primaryKey(): string;

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

    public static function findOne($value) {
        $tableName = static::tableName();
        $attributes = array_keys($value);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($value as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        try{
            $statement->execute();
            return $statement->fetchObject(static::class);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
} 