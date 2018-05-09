<?php 
require_once 'classes/MYSQL.php';

$mysql = new MYSQL("localhost","root",'','php');

/* Creating tables */
//$mysql->CreateDb("PHP");

/* deleting database */
//$mysql->DeleteDb("PHP");

/* creating table */
/*$mysql->CreateTbl("PHP","CREATE TABLE users(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    email VARCHAR(70) NOT NULL UNIQUE
)");*/

/* deleting table */
//$mysql->DeleteTbl("PHP","users");

/* inserting records */
//$id = $mysql->Insert('users',['first_name'=>'Malik Uner','last_name'=> 'Farooq','email'=> 'lablnet01@gmail.com']);

/* updating database */
//$id = 1;
//$mysql->Update(['table'=>'users','columns'=>['first_name' => 'Malik Umer'],'wheres'=>['id ='. $id]]);

/* selecting values */
$result = $mysql->Select(['table'=>'users','wheres'=>['id ='. 1]]);

print_r($result);

/* deleting the records */
//$mysql->Delete(['table'=>'users','wheres'=>['id ='. 7]]);

/* Counting the records */
//echo $mysql->Count(['table'=>'users','wheres'=>['id ='. 1]]);
