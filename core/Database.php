<?php

namespace app\core;

use PDO;

class Database {
    public PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations(){
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR.'/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach($toApplyMigrations as $migrations){
            if($migrations === '.' || $migrations === '..'){
                continue;
            }
            require_once Application::$ROOT_DIR.'/migrations/'.$migrations;
            $className = pathinfo($migrations, PATHINFO_FILENAME);
            $instance = new $className();
            echo "Applying migration $migrations";
            $instance->up();
            echo "Applied migration $migrations";
            $newMigrations[] = $migrations;
        }

        if(!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }
        else{
            echo "All migrations are applied";
        }
    }

    public function createMigrationsTable(){
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    public function getAppliedMigrations(){
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $newMigrations){
        $str = implode(',', array_map(fn($m) => "('$m')", $newMigrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
            $str
        ");
        $statement->execute();
    }
}