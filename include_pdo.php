<?php
$user = "root";
$pass = "root";
$con = new PDO('mysql:host=localhost', $user, $pass);

class PdoPHP{   		
      	private static $serveur='mysql:host=localhost';   		
      	private static $user='root' ;    		
      	private static $mdp='root' ;	
		private static $monPdo;
		private static $pdoPHP=null;

	private function __construct(){
    	PdoPHP::$monPdo = new PDO(PdoPHP::$serveur, PdoPHP::$user, PdoPHP::$mdp); 
		PdoPHP::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoPHP::$monPdo = null;
	}

	public  static function getPdoMyPHP(){
		if(PdoPHP::$pdoPHP==null){
			PdoPHP::$pdoPHP= new PdoPHP();
		}
		return PdoPHP::$pdoPHP;  
	}

	public function show(){
		$req = "SHOW DATABASES";
		$res = PdoPHP::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function show_table($name){
		$req = "SHOW TABLES FROM ".$name;
		$res = PdoPHP::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function explain_table($table, $bdd){
		$req = "SELECT COLUMN_NAME as 'Field', COLUMN_TYPE as 'Type', IS_NULLABLE as 'Null', COLUMN_KEY as 'Key',
					COLUMN_DEFAULT as 'Default', EXTRA as 'Extra' from INFORMATION_SCHEMA.COLUMNS where
					TABLE_NAME = '".$table."' and TABLE_SCHEMA = '".$bdd."'";
		$res = PdoPHP::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function create_bdd($name){
		$req = "CREATE DATABASE IF NOT EXISTS ".$name;
		$res = PdoPHP::$monPdo->query($req);
	}

	public function delete_line_struct($bdd, $id_table, $line){
		$req = 'ALTER TABLE '.$bdd.'.'.$id_table.' DROP '.$line;
		$res = PdoPHP::$monPdo->query($req);
	}

	public function drop_bdd($name){
		$req = "DROP DATABASE ".$name;
		$res = PdoPHP::$monPdo->query($req);
	}

	public function rename_table($bdd_color, $id_table, $new_name){
		$req = 'RENAME TABLE '.$bdd_color.'.'.$id_table.' TO '.$bdd_color.'.'.$new_name;
		$res = PdoPHP::$monPdo->query($req);
	}

	public function drop_table($bdd_color, $id_table){
		$req = 'DROP TABLE '.$bdd_color.'.'.$id_table;
		$res = PdoPHP::$monPdo->query($req);
	}

	public function insert_data($bdd, $table, $name, $value){
		$req = "INSERT INTO ".$bdd.".".$table." (";
		$i = 0;
		while (isset($name[$i]))
		{
			if (isset($name[$i + 2]))
				$req = $req.$name[$i].', ';
			else
				$req = $req.$name[$i].') VALUES ("';
			$i = $i + 2;
		}
		$i = 0;
		while (isset($value[$i]))
		{
			if (isset($value[$i + 2]))
				$req = $req.$value[$i].'", "';
			else
				$req = $req.$value[$i].'")';
			$i = $i + 2;
		}
		$res = PdoPHP::$monPdo->query($req);
	}

	public function describe_table($bdd, $table){
		$req = "DESCRIBE ".$bdd.".".$table;
		$res = PdoPHP::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function delete_value($bdd, $table, $key, $value){
		$req = "DELETE FROM ".$bdd.".".$table." WHERE ".$table.".".$key." = ".$value."";
		$res = PdoPHP::$monPdo->query($req);
	}

	public function query_sql($bdd, $req){
		$link = mysql_connect("localhost", "root", "root");
		mysql_select_db($bdd, $link);
		$result = mysql_query($req, $link);
		
		if (!$result) {
			$message  = 'Requête invalide : ' . mysql_error() . "\n";
			$message .= 'Requête complète : ' . $req;
			return $message;
		}
		else 
		{
			 while ($data = mysql_fetch_array($result))
			 {
			 	$tab[] = $data;
			 }
			 $_SESSION['name_req'] = $bdd;
			 return $tab;
		}
	}

	public function create_table($bdd, $table){
		$req = "create table if not exists ".$bdd.".".$table."
		(
			ID int NOT NULL AUTO_INCREMENT,
			Nom varchar(255) NOT NULL,
			Prenom varchar(255),
			Adresse varchar(255),
			PRIMARY KEY (ID)
		)";
		$res = PdoPHP::$monPdo->query($req);
	}

	public function count_line($bdd, $table){
		$req = "SELECT COUNT(*) as 'count' FROM ".$bdd.".".$table;
		$res = PdoPHP::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['count'];
	}
}
?>