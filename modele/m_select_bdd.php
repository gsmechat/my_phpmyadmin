<?php
	if (isset($select))
	{
		$_SESSION["bdd_color"] = $id_bdd;
		include("controleur/c_main.php");
	}
	elseif (isset($delete_struct))
	{
		$pdo->delete_line_struct($bdd_color, $id_table, $select_line);
		include("controleur/c_main.php");
	}
	elseif (isset($supp))
	{
		$pdo->drop_bdd($id_bdd);
		include("controleur/c_main.php");
	}
	elseif (isset($demande_query))
	{
		$req = $pdo->query_sql($bdd, $query_sql);
		include("controleur/c_print_req.php");
	}
?>