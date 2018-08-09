<?php
$action = $_REQUEST['act'];

switch($action){
	case 'add_bdd':{
		$name_bdd = $_REQUEST["bdd_name"];
		include('modele/m_add_bdd.php');
		break;
	}
	case 'select_bdd':{ 
		if(isset($_POST['select']))
		{
		 	$select = $_POST['select'];
		 	$id_bdd = $_REQUEST['id_bdd'];
		}
		if(isset($_POST['supp']))
		{
			$supp = $_POST['supp'];
		 	$id_bdd = $_REQUEST['id_bdd'];
		}
		include("modele/m_select_bdd.php");
		break;
	}
	case 'struct':{
		if(isset($_POST['delete_struct']))
		{
		 	$delete_struct = $_POST['delete_struct'];
			$id_table = $_REQUEST['id_table'];
			$bdd_color = $_REQUEST['bdd_color'];
			$select_line = $_REQUEST['select_line'];
		}
		include("modele/m_select_bdd.php");
		break;
	}
	case 'query':{
		$demande_query = $_REQUEST['query'];
		$query_sql = $_REQUEST['query_sql'];
		$bdd = $_REQUEST['bdd'];
		include("modele/m_select_bdd.php");
		break;
	}
}
?>