<?php
	if(isset($select))
	{
		$_SESSION["table_color"] = $id_table;
		$_SESSION["bdd_color"] = $bdd_color;
	}
	else if(isset($rename) && $new_name != "")
		$pdo->rename_table($bdd_color, $id_table, $new_name);
	else if(isset($delete))
		$pdo->drop_table($bdd_color, $id_table);
	include("controleur/c_main.php");
?>