# PHP MYSQL Manipulation Class
#### PHP MYSQL Manipulation Class
## Feature
 - Create database.
 - Delete database.
 - Create table.
 - Delete table.
 - Insert into table.
 - Update record in table.
 - Select data form table (`Joins`,`Limits`,`OrderBy`,`Wheres` `debug`).
 - Delete record in table.
 - Count record in table.
 - Quote string.
 - Provide method for close database connection

# Simple example
    <?php
    //loading require file.
    require_once 'classes/MYSQL.php';
	open connection.
	$mysql = new MYSQL("host","user",'pass');
	//slecting records.
	$result = $mysql->Select(['table'=>'table_name','db_name'=>'db_name']);
	//closing connection.
	$mysql->Close();
	
# to-do
 - Updating tables
 - Creating table in efficient ways



