<?php

class Database {

    private $mysqli;

    public function __construct(){
        include_once __DIR__.'/../config/database.php';
        $this->mysqli = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );
    }

    public function connect(){

        if ($this->mysqli){
            return $this->mysqli;
        }

    }

}