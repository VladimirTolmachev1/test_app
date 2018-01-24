<?php

class DB{
    function DB(){
    }

    /**
     * Connect to DB using PDO driver
     *
     * @return bool|PDO
     */
    function connect(){
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS,
                array(
                    PDO::ATTR_PERSISTENT => true
                )
            );

            return $pdo;

        } catch (PDOException $e) {
            print "PDO connection error!: " . $e->getMessage() . "<br/>";
            return false;
        }
    }
}