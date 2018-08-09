<?php
	if(isset($name_bdd))
		$pdo->create_bdd($name_bdd);
	include("controleur/c_main.php");
?>