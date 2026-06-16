<?php

date_default_timezone_set("Pacific/Auckland");

$db_host="localhost";
$db_name="reddit_ai";
$db_user="root";
$db_pass="你的密码";

try{

    $pdo=new PDO(

        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",

        $db_user,

        $db_pass

    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}catch(Exception $e){

    die($e->getMessage());

}