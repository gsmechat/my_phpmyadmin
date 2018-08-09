<?php
$action = $_REQUEST['act'];

switch($action){
	case 'select_table':{
		if (isset($_REQUEST['select']))
		{
			$_SESSION['table_table'] = $_REQUEST['id_table'];
			$select = $_REQUEST['select'];
			$id_table = $_REQUEST['id_table'];
			$bdd_color = $_REQUEST['bdd_color'];
		}
		if (isset($_REQUEST['rename']))
		{
			$rename = $_REQUEST['rename'];
		 	$new_name = $_REQUEST['new_name'];
		 	$id_table = $_REQUEST['id_table'];
		 	$bdd_color = $_REQUEST['bdd_color'];
		}
		if (isset($_REQUEST['delete']))
		{
			$delete = $_REQUEST['delete'];
		 	$id_table = $_REQUEST['id_table'];
		 	$bdd_color = $_REQUEST['bdd_color'];
		}
		include('modele/m_select_table.php');
		break;
	}
	case 'add_value':{
		$bdd = $_GET['bdd'];
		$table = $_GET['table'];
		$i = 0;
		$j = 0;
		foreach ($_POST as $val)
		{
			if ($i % 2 == 0)
				$name[$i] = $val;
			else
				$value[$i - 1] = $val;
			$i = $i + 1;
		}
		$pdo->insert_data($bdd, $table, $name, $value);
		include('modele/m_select_table.php');
		break;
	}
	case 'delete_value':{
		$primary_key = $_REQUEST["primary_key"];
		$value_pk = $_REQUEST["value_pk"];
		echo $value_pk;
		$bdd = $_REQUEST['database'];
		$table = $_REQUEST['table_select'];
		$pdo->delete_value($bdd, $table, $primary_key, $value_pk);
		include('controleur/c_main.php');
		break;
	}
	case 'create':{
		$bdd = $_REQUEST['bdd'];
		$table = $_REQUEST['new_table'];
		$pdo->create_table($bdd, $table);
		include('controleur/c_main.php');
		break;
	}
}
?>