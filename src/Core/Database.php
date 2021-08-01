<?php

namespace app\Core;

use PDO;
use PDOException;

class Database {
    public PDO $pdo;
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';
        try{
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function applyMigrations() {
        $this->createMigrationsTable();

        $allMigrations = scandir(Application::$SRC.'/Migrations');
        $localMigrations = $this->getLocalMigrations();
        $toApplyMigrations = array_diff($allMigrations, $localMigrations);
        $toSaveMigrations = [];

        foreach($toApplyMigrations as $migration) {
            if($migration === "." || $migration === ".."){
                continue;
            }
            require_once Application::$SRC.'/Migrations/'. $migration;

            $migrationClassName = pathinfo($migration, PATHINFO_FILENAME);
            $migrationInstance = new $migrationClassName();
            $this->log("Applying Migration $migration");
            $migrationInstance->up();
            $this->log("Applied Migration $migration");

            $toSaveMigrations[] = $migration;
        }
        if(!empty($toSaveMigrations)) {
            $this->saveMigrationsToLocalDatabase($toSaveMigrations);
        }
        else {
            $this->log("All Migrations are applied");
        }
    }

    public function createMigrationsTable() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    public function getLocalMigrations() {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrationsToLocalDatabase(array $migrations) {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }

    protected function log($message) {
        echo '['.date('Y-m-d H:i:s').'] - ' . $message . PHP_EOL;
    }

    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }
}