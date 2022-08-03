<?php

class Database {
    protected $connection;
    private $ip = 'localhost';
    private $name = 'billing';
    private $username = 'root';
    private $password = '';

    function __construct() {
        try {
            $this->connection = new PDO("mysql:host={$this->ip};",$this->username,$this->password);
            $this->connection->exec("CREATE DATABASE IF NOT EXISTS $this->name");
            $this->connection->exec("use $this->name");
            $this->connection->exec("CREATE TABLE IF NOT EXISTS users(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                firstname VARCHAR(255) NULL,
                lastname VARCHAR(255) NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(60) NOT NULL,
                createdAt VARCHAR(50) NOT NULL,
                services INT(11) DEFAULT 0,
                confirmed INT(11) DEFAULT 0,
                confirmation_code VARCHAR(50),
                ip_address VARCHAR(50),
                is_banned INT(11) DEFAULT 0
            )");

            $this->connection->exec("CREATE TABLE IF NOT EXISTS packages(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                package_name VARCHAR(255) NOT NULL,
                package_price FLOAT NOT NULL,
                package_description TEXT,
                package_image TEXT
            )");

            $this->connection->exec("CREATE TABLE IF NOT EXISTS services(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                package_name VARCHAR(255) NOT NULL,
                createdAt VARCHAR(50) NOT NULL,
                domain TEXT NOT NULL,
                user VARCHAR(255) NOT NULL,
                cpanel_username VARCHAR(255) NOT NULL,
                cpanel_password VARCHAR(255) NOT NULL
            )");

            $this->connection->exec("CREATE TABLE IF NOT EXISTS modules(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                module_name VARCHAR(50) NOT NULL,
                module_link TEXT NOT NULL,
                module_username TEXT NOT NULL,
                api_key TEXT NOT NULL
            )");

            $this->connection->exec("use $this->name");
        } catch(PDOException $err) {
            echo $err;
        }
    }
}