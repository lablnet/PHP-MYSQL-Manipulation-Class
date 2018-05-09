<?php
	/**
	 * PHP MYSQL Manipulation Class
	 *
	 * @author   Malik Umer Farooq <lablnet01@gmail.com>
	 * @author-profile https://www.facebook.com/malikumerfarooq01/
	 * @license MIT 
	 * @link     https://github.com/Lablnet/PHP-MYSQL-Manipulation-Class
	 *
	 */
	/**
	 * PHP class
	 * @param db-host,db-user,db-pass,db-name
	 */	 
class MYSQL
{

		/**
		 * For sotring database settings 
		 * @access private
		 */	 	
	private $settings;	
		/**
		 * For sotring database connection reference
		 * @access private
		 */	 	
	private $db;

		/**
		 * Set the values
		 *
		 * @return void
		 */	 
	public function __construct($host,$user,$pass,$db){

		$this->DbSettings($host,$user,$pass,$db);

		$this->db = self::Connection(true);

	}
		/**
		 * Unset the value for performance 
		 *
		 * @return void
		 */	 
	public function __destruct(){

		self::Connection(false);

		unset($this->db);


	}
		/**
		 * Open database connection
		 *
		 * @param $status true : false  true means open false colse
		 * 
		 * @return boolean
		 */	 
	public function Connection($status){

	    if($status === true){

	    	$setting = $this->settings;
	        

	        return $db = new PDO('mysql:host='.$setting['host'].';dbname='.$setting['db'], $setting['user'], $setting['pass']);
	    }

	    if($status === false){

	        return $db = null;

	    }

	 }


		/**
		 * Database default setting
		 *
		 * @param 
		 * $host Database host
		 * $user Database user
		 * $pass Database pass 
		 * $db Database name
		 *
		 * @return void
		 */	 	 
	public function DbSettings($host,$user,$pass,$db){

		$this->settings =  [
			'host' => $host,
			'user' => $user,
			'pass' => $pass,
			'db' => $db,
		];

		return;

	} 

		/**
		 * Prepare a query to insert into db
		 *
		 * @param 
		 * $table Name of tabke 
		 * array array(); e.g:
		 *           'name' => 'new name' or $comeformvariable
		 *           'username' => 'new username' or $comeformvariable
		 *
		 * @return integar or boolean
		 */	 	 
	 public function Insert($table,$param){

	 	$db = $this->db;

		$columns = implode(',',array_keys($param));

		$values = ':'.implode(', :',array_keys($param));

		$sql = "INSERT INTO {$table} ({$columns}) values ({$values})";

		if($stmt = $db->prepare($sql)){

			foreach($param as $key => $data){

				$stmt->bindValue(':'.$key,$data);

			}
			
			$stmt->execute();

			$last =  $db->lastInsertId();

			return $last;

		}

		return false;

	}
		/**
		 * Prepare a query to Update data in database
		 * @param array $params; e.g:
		 * 'table' required name of table
		 * 'wheres' Specify id or else for updating records
		 * 'columns' => data e.g name=>new name
		 *
		 * @return boolean
		 */	 
	public function Update($params){

		if(is_array($params)){

				$db = $this->db;

				$count_rows = count($params['columns']);

				$increment      = 1;

			foreach($params['columns'] as $keys => $value) {

				for($i=1;$i<=$count_rows;$i++){

						$data[$keys] = $value;

					}

			}

			foreach($data as $keys => $values) {

				if($increment == $count_rows) {

						$columns [] = "{$keys} = '{$values}'";

				} else {

						$columns [] = "{$keys} = '{$values}'";

				}

				$increment++;

			}

			$columns  = implode(' , ', $columns);

			if(isset($params['wheres'])) {		

				if(!empty($params['wheres'])) {

						$wheres = "WHERE " . implode(' and ', array_values($params['wheres']));

				}else{

					$wheres = '';

				}
			}else{

				$wheres = '';

			}			
				$query  = "UPDATE `{$params['table']}`SET {$columns} {$wheres}";

					if(isset($params['debug']) and strtolower($params['debug']) === 'on' ){

					    	var_dump($query);

					}

					$prepare = $db->prepare($query);

					if($prepare->execute()) {

							return true;

					}			

		}else{

			return false;

		}		

	}
		/**
		 * quote the string
		 *
		 * @param $string  
		 *
		 * @return string
		 */	 
	public function Quote($string){

		return $this->db->quote($string);

	}		
		/**
		 * Prepare a query to select data from database
		 *
		 * @param array array();
		 *           'table' Names of table
		 *           'params' Names of columns which you want to select
		 *           'wheres' Specify a selection criteria to get required records
		 *            'debug' If on var_dump sql query
		 * @return boolean
		 */	 
	public function Select($params) {

		if(is_array($params)) {

				$db = $this->db;		

					if(!isset($params['params'])) {

							$columns = '*';

					} else {

					    $columns = implode(', ',array_values($params['params']));

					}				

					$wheres = '';

					if(!empty($params['wheres'])) {

					    $wheres = "WHERE " . implode(' and ', array_values($params['wheres']));

					}
					
					if(isset($params['joins'])){

						if(!empty($params['joins']))
							if(!isset($params['joins']['using'])){

							$join = " JOIN ".$params['joins']['table2'].' ON '.$params['joins']['column1'] .' = ' . $params['joins']['column2'];

						}else{

							$join = " JOIN ".$params['joins']['table2'].' Using '.$params['joins']['using'];

						}	
						
					}else{

						$join = '';

					}
					if(isset($params['limit'])){

						if(!empty($params['limit'])){
							$limit = " LIMIT ".$params['limit']['start']." OFFSET ".$params['limit']['end'];

						}else{

							$limit = '';

						}
					}else{	

						$limit = '';

					}
					if(isset($params['order_by'])){

						if(!empty($params['order_by'])){

							$order_by = " ORDER BY ". $params['order_by'];

						}else{

							$order_by = '';

						}
					}else{

						$order_by = '';

					}

					$query = "SELECT {$columns} FROM {$params['table']} {$join} {$wheres} {$order_by} {$limit} ;";

					if(isset($params['debug']) and strtolower($params['debug']) === 'on' ){

					    var_dump($query);

					}

					$prepare = $db->prepare($query);

					if($prepare->execute()) {

							$data = $prepare->fetchAll(PDO::FETCH_ASSOC);

							return $data;

					}
			}

			return false;

	}
	/**
	 * Prepare a query to delete data from database
	 *
	 * @param $params array array();
	 *           'table' Names of table
	 *           'wheres' Specify a selection criteria to get required records
	 *
	 * @return boolean
	 */	
	public function Delete($params) {

			if(is_array($params)) {

					$db = $this->db;

					if(!empty($params['wheres'])) {

							$wheres = "WHERE " . implode(' and ', array_values($params['wheres']));

					}else{

							return false;

					}
					$query = "DELETE FROM `{$params['table']}` {$wheres};";

					$prepare = $db->prepare($query);

					if($prepare->execute()) {

							return true;
					}

			}

			return false;

	}
		/**
		 * Prepare a query to count data from database
		 *
		 * @param $params array();
		 *           'table' Names of table
		 *           'columns' Names of columnswant to select
		 *           'wheres' Specify a selection 		 *       
		 * @return boolean
		 */	 	
	public function Count($params){
		
		if(is_array($params)){

			$table = $params['table'];

			$db = $this->db;

			if(isset($params['columns'])){

				$columns = implode(',',array_values($params['columns']));

			}else{

				$columns = '*';

			}

			if(!empty($params['wheres'])){

		    	$where = "WHERE " . implode(' and ', array_values($params['wheres']));

				$sql = "SELECT {$columns} FROM {$table} {$where}";

				$prepare = $db->prepare($sql);

				$prepare->execute();

				$count = $prepare->rowCount();

				return $count;

			}else{

				return false;

			}
		}else{

			return false;

		}

	}

		/**
		 * Creating database if not exists
		 *
		 * @param $name name of database
		 *
		 * @return boolean
		 */	
	public function CreateDb($name){

		if(isset($name) && !empty($name)){

			$sql = "CREATE DATABASE IF NOT EXISTS `{$name}`";

			$this->db->exec($sql);

			$this->db->exec("USE `{$name}` ");

			return true;

			
		}else{

			return false;

		}

	}

		/**
		 * Deleting database if not exists
		 *
		 * @param $name name of database
		 *
		 * @return boolean
		 */		
	public function DeleteDb($name){

		if(isset($name) && !empty($name)){

			$sql = "DROP DATABASE `{$name}` ";

			$this->db->exec($sql);

			return true;

			
		}else{

			return false;

		}

	}

		/**
		 * Deleting table if not exists
		 *
		 * @param $dbname name of database
		 * $table => $table name
		 *
		 * @return boolean
		 */	
	public function DeleteTbl($dbname,$table){

		if(isset($dbname) && !empty($dbname) && isset($table) && !empty($table)){

			$this->db->exec("USE `{$dbname}` ");	

			$sql = "DROP TABLE `{$table}` ";

			$this->db->exec($sql);

			return true;

			
		}else{

			return false;

		}

	}	

		/**
		 * Creating table
		 *
		 * @param $dbname name of database
		 * $sql => for creating tables
		 *
		 * @return boolean
		 */	
	public function CreateTbl($dbname,$sql){

		if(isset($dbname) && !empty($dbname) && isset($sql) && !empty($sql)){

			$this->db->exec("USE `{$dbname}` ");	

			$this->db->exec($sql);

			return true;

			
		}else{

			return false;

		}

	}
} 


