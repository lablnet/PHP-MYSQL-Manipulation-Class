<?php 
require_once 'classes/MYSQL.php';

$mysql = new MYSQL("localhost","root",'');

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
//$id = $mysql->Insert('users','PHP',['first_name'=>'Malik Uner','last_name'=> 'Farooq','email'=> 'lablnet01@gmail.com']);

/* updating database */
//$id = 1;
//$mysql->Update(['table'=>'users','db_name'=>'PHP','columns'=>['first_name' => 'Malik Umer'],'wheres'=>['id ='. 1]]);

/* selecting values */
$result = $mysql->Select(['table'=>'users','db_name'=>'PHP','wheres'=>['email ='. $mysql->Quote('lablnet01@gmail.com')]]);

print_r($result);

/* deleting the records */
//$mysql->Delete(['table'=>'users','db_name'=>'PHP','wheres'=>['id ='. 9]]);

/* Counting the records */
//echo $mysql->Count(['table'=>'users','db_name'=>'PHP','wheres'=>['id ='. 9]]);

//Close the connection its recommended to clsoe connection
$mysql->Close();

