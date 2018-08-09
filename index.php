<?php
session_start();

// $_SESSION['bdd_name'] = "";
// $_SESSION['bdd_color'] = "";
// $_SESSION['table_color'] = "";
// $_SESSION['table_select'] = "";

include("include_pdo.php");
include("vue/v_header.php");

$pdo = PdoPHP::getPdoMyPHP();

if(!isset($_REQUEST['uc'])){
      $_REQUEST['uc'] = 'main';
 	}	 
$uc = $_REQUEST['uc'];

switch($uc){
	case 'main':{
		include("controleur/c_main.php");
		break;
	}
	case 'table':{
		include("controleur/c_action_table.php");
		break;
	}
	case 'bdd':{
		include("controleur/c_action_bdd.php");
		break;
	}
	default :{
		include("controleur/c_404.php");
		break; 
	}
}
include("vue/v_footer.php");