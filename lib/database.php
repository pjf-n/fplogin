<?php

class Database {

    protected $name = 'cl44-fp';
    protected $username = 'cl44-fp';
    protected $password = 'm!RR3-Nb4';
    protected $host = 'localhost';
    public $db;

    public function __construct($name = '', $username = '', $password = '', $host = '') {

        // Ideally need to check type
        if( !empty( $name ) ) {
            $this->name = $name;
        }

        // Ideally need to check type
        if( !empty( $username ) ) {
            $this->username = $username;
        }

        // Ideally need to check type
        if( !empty( $password ) ) {
            $this->password = $password;
        }

        // Ideally need to check type
        if( !empty( $host ) ) {
            $this->host = $host;
        }

        $dsn = 'mysql:dbname=' . $this->name . ';host=' . $this->host;
        $user = $this->username;
        $password = $this->password;

        try {
            $this->db = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function query( $query = '' ) {


    }
}