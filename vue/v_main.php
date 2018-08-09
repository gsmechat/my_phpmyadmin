<?php
$show_bdd2 = $con->query('SHOW DATABASES');
?>
<!------------------------------------------------------ MENU DROITE ---------------------------------------------------------->

<ul id="slide-out" class="side-nav fixed">
	<ul class="collapsible" data-collapsible="accordion">
		<?php 

		$j = count($show_bdd);
		$i = 0;
		while ($i < $j)
		{
			echo '
			<li>
			<div class="collapsible-header"><i class="material-icons">playlist_add</i>'.$show_bdd[$i]["Database"].'</div>';
			
			$show_table = $pdo->show_table($show_bdd[$i]["Database"]);
			$l = count($show_table);									
			$k = 0;														

			while ($l > $k)
			{
				echo '
				<div class="collapsible-body"><p>'.$show_table[$k][0].'</p></div>';
				$k++;
			}

			echo '
			</li>
			';
			$i++;
		}
		?>
	</ul>
</ul>
<a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
<div class="container">
	<!------------------------------------------------------ FIN MENU DROITE ---------------------------------------------------------->
	<!------------------------------------------------------ LISTE BDD ---------------------------------------------------------->
	<div id="bdd" class="col s12">
		<form method="POST" action='index.php?uc=bdd&act=add_bdd'>
			<div class="row">
				<div class="input-field col s12">
					<input id="first_name2" type="text" name="bdd_name" class="validate">
					<label class="active" for="first_name2">Création d’une base de données</label>
				</div>
				<div class="right-align">
					<button style="margin-right: 15px;" class="btn waves-effect waves-light" type="submit" name="action">Submit
						<i class="material-icons right">send</i>
					</button>
				</div>
			</div>
		</form>
		<table class="bordered striped centered">
			<thead>
				<tr>
					<th data-field="id">Nom BDD</th>
					<th data-field="nb_table">Nombre de table</th>
					<th data-field="date_crea">Date création</th>
					<th data-field="date_crea">Espace mémoire</th>
					<th data-field="price">&nbsp</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($result = $show_bdd2->fetch())
				{							
					$nb_table_bdd = $con->query("SELECT COUNT(*) as 'count' FROM information_schema.tables WHERE table_schema = '".$result['Database']."'");
					while($result2 = $nb_table_bdd->fetch())
					{
						$nb_table = $result2["count"];
						break;
					}
					$date_create_bdd = $con->query("SELECT create_time as 'create' FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = '".$result['Database']."'");
					while($result3 = $date_create_bdd->fetch())
					{
						$date_table = $result3["create"];
						break;
					}
					$size_table_bdd = $con->query("SELECT table_name AS `Table`, round(((data_length + index_length) / 1024), 2) `size` FROM information_schema.TABLES WHERE table_schema = '".$result['Database']."'");
					$size_bdd = 0;
					while($result4 = $size_table_bdd->fetch())
					{
						$size_bdd = $size_bdd + $result4["size"];
					}
					if (!isset($_SESSION["bdd_color"]))
						$_SESSION["bdd_color"] = "";
					if($_SESSION["bdd_color"] == $result["Database"])
					{
						echo '<tr style = background-color:yellow>';
						$_SESSION['bdd_name'] = $result["Database"];
						//$_SESSION['table_name'] = "";
					}
					else
						echo '<tr>';
					echo '
					<td>'.$result["Database"].'</td>
					<td>'.$nb_table.'</td>
					<td>'.$date_table.'</td>
					<td>'.$size_bdd.' Kio</td>
					<td style="text-align: right;">
					<form method=POST action=index.php?uc=bdd&act=select_bdd>
					<input type=hidden name="id_bdd" value='.$result["Database"].'>
					<button class="btn waves-effect waves-light" name="select" value="select" >SELECT
					<i class="material-icons right">open_in_new</i>
					</button>
					<button class="btn waves-effect waves-light red darken-4" name="supp" value="supp" onclick=return(confirm("Supprimer?"))>SUPP
					<i class="material-icons right">delete</i>
					</button>
					</form>
					</td>
					</tr>
					';
				}
				?>
			</tbody>
		</table>
	</div>
	<!------------------------------------------------------ FIN LISTE BDD ---------------------------------------------------------->
	<!------------------------------------------------------ AERA REQUETE ---------------------------------------------------------->
	<div id="req_SQL" class="col s12">
		<?php
		if ($_SESSION['bdd_name'] != "")
		{
			?>
			<div class="row">
				<div class="col s12">
					<div class="row">
						<form method="POST" action="index.php?uc=bdd&act=query">
							<input type="hidden" name="bdd" value= <?php echo $_SESSION['bdd_name'] ?> ></input>
							<div class="input-field col s12">
								<textarea id="textarea1" name="query_sql" class="materialize-textarea"></textarea>
								<label for="textarea1">Requéte SQL</label>
							</div>
						</div>
						<div class="row right-align">	
							<button style="margin-right: 15px;" class="btn waves-effect waves-light" type="submit" name="query" value="query">Submit
								<i class="material-icons right">send</i>
							</button>
						</div>
					</div>
				</form>
			</div>
			<?php
		}
		?>
	</div>
	<!------------------------------------------------------ FIN AERA REQUETE ---------------------------------------------------------->
	<!------------------------------------------------------ EDIT BDD ---------------------------------------------------------->
	<div id="edit_bdd" class="col s12">
		<?php
		if ($_SESSION['bdd_color'] != "")
		{
			?>
			<div class="row">
			<!-- <form method="POST" action="index.php?uc=action_bdd">
				<div class="input-field col s6">
					<input id="name" type="text" class="validate" name="name_bdd" required>
					<label for="name"><?php echo $_SESSION['bdd_name']; ?></label>
				</div>
				<div class="input-field col s6">
					&nbsp
				</div>
				<div class="right-align">
					<button style="margin-right: 15px;" class="btn waves-effect waves-light" type="submit" name="action">Valider
						<i class="material-icons right">send</i>
					</button>
				</div>
			</form> -->
			<form method="POST" action="index.php?uc=table&act=create">
				<?php echo '<input type=hidden name=bdd value='.$_SESSION['bdd_name'].'></input>'; ?>
				<div class="input-field col s12">
					<input id="name" type="text" name="new_table" class="validate">
					<label for="name">Nom nouvelle table</label>
				</div>
				<table class="bordered striped centered" id="tab2">
					<thead>
						<tr>
							<th data-field="name">Nom</th>
							<th data-field="type">Type</th>
							<th data-field="val">Valeur</th>
							<th data-field="defaut">Defaut</th>
							<th data-field="inter_class">InterClassement</th>
							<th data-field="att">Attributs</th>
							<th data-field="null">NULL</th>
							<th data-field="index">Index</th>
						</tr>
					</thead>

					<tbody>
						<tr id="addr0">
							<td>
								<input id="name" type="text" class="validate">
							</td>
							<td>
								<select>
									<option value="" disabled selected>Type</option>
									<option value="1">Option 1</option>
									<option value="2">Option 2</option>
									<option value="3">Option 3</option>
								</select>
							</td>
							<td>
								<input id="name" type="number" min="1" class="validate">
							</td>
							<td>
								<select>
									<option value="" disabled selected>Défaut</option>
									<option value="1">Option 1</option>
									<option value="2">Option 2</option>
									<option value="3">Option 3</option>
								</select>
							</td>
							<td>
								<select>
									<option value="" disabled selected>InterClass</option>
									<option value="1">Option 1</option>
									<option value="2">Option 2</option>
									<option value="3">Option 3</option>
								</select>
							</td>
							<td>
								<select>
									<option value="" disabled selected>Attributs</option>
									<option value="1">Option 1</option>
									<option value="2">Option 2</option>
									<option value="3">Option 3</option>
								</select>
							</td>
							<td>
								<input type="checkbox" id="test5" />
								<label for="test5"></label>

							</td>
							<td>
								<select>
									<option value="" disabled selected>Index</option>
									<option value="1">Option 1</option>
									<option value="2">Option 2</option>
									<option value="3">Option 3</option>
								</select>
							</td>
						</tr>
					</tbody>
				</table>
				<br>
				<div class="right-align">
					<a id="add_row" class="btn waves-effect waves-light #2196f3 blue">Add Row</a>
					<button style="margin-right: 15px;" class="btn waves-effect waves-light" type="submit" name="action">Valider
						<i class="material-icons right">send</i>
					</button>
				</div>
			</form>
		</div>
		<table class="bordered striped centered">
			<thead>
				<tr>
					<th data-field="id">Table</th>
					<th data-field="id">Nombre de ligne(s)</th>
					<th data-field="price">&nbsp</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$show_table_bdd = $con->query('SHOW TABLES FROM `'.$_SESSION['bdd_name'].'`');
				if($show_table_bdd != false){
					while ($result = $show_table_bdd->fetch())
					{
						$_SESSION['table_select'] = $result["Tables_in_".strtolower($_SESSION['bdd_name'])];
						if($_SESSION["table_color"] == $_SESSION['table_select'])
						{
							echo '<tr style = background-color:yellow>';
						}
						else
							echo '<tr>';
						echo '
						<form method=POST action=index.php?uc=table&act=select_table>
						<td><input name=new_name placeholder='.$result["Tables_in_".strtolower($_SESSION['bdd_name']).""].'></input></td>
						<td>'.$pdo->count_line($_SESSION['bdd_name'], $_SESSION['table_select']).'</td>	
						<td style="text-align: right;">
						<input type=hidden name="id_table" value='.$result["Tables_in_".strtolower($_SESSION['bdd_name']).""].'>
						<input type=hidden name="bdd_color" value='.$_SESSION['bdd_name'].'>
						<button class="btn waves-effect waves-light" name="select" value="select_edit">SELECT
						<i class="material-icons right">open_in_new</i>
						</button>
						<button class="btn waves-effect waves-light orange darken-4" name=rename value=rename_table>RENAME
						<i class="material-icons right">clear_all</i>
						</button>
						<button class="btn waves-effect waves-light red darken-4" name=delete value=delete_table onclick=return(confirm("Supprimer?"))>SUPP
						<i class="material-icons right">delete</i>
						</button>
						</form>
						</td>
						</tr>
						';
					}
				}
				?>
			</tbody>
		</table>
	</div>
	<?php

}

?>
<!------------------------------------------------------ FIN EDIT BDD---------------------------------------------------------->
<!------------------------------------------------------ STRUCTURE BDD ---------------------------------------------------------->
<div id="struct_bdd" class="col s12">
	<div class="row">
			<!-- <div class="input-field col s6">
				<input id="name" type="text" class="validate">
				<label for="name">Nom nouvelle table</label>
			</div>
			<div class="input-field col s6">
				<input id="nb" type="number" min= 0 class="validate">
				<label for="nb">Nombre de colonnes</label>
			</div>
			<div class="right-align">
				<button style="margin-right: 15px;" class="btn waves-effect waves-light" type="submit" name="action">Valider
					<i class="material-icons right">send</i>
				</button>
			</div> -->
		</div>
		<table class="bordered striped centered">
			<thead>
				<tr>
					<th data-field="id">#</th>
					<th data-field="name">Nom</th>
					<th data-field="type">Type</th>
					<th data-field="inter_class">NULL</th>
					<th data-field="att">Clée</th>
					<th data-field="null">Defaut</th>
					<th data-field="defaut">Extra</th>
				</tr>
			</thead>

			<tbody>
				<?php
				
				$i = 0;
				$explain_table = $pdo->explain_table($_SESSION['table_table'], $_SESSION['bdd_name']);
				$j = count($explain_table);
				
				while ($i < $j)
				{
					echo '
					<tr>
					<td>'.$i.'</td>
					<td>'.$explain_table[$i]['Field'].'</td>
					<td>'.$explain_table[$i]['Type'].'</td>
					<td>'.$explain_table[$i]['Null'].'</td>
					<td>'.$explain_table[$i]['Key'].'</td>
					<td>'.$explain_table[$i]['Default'].'</td>
					<td>'.$explain_table[$i]['Extra'].'</td>
					<td style="text-align: right;">
					<form method=POST action=index.php?uc=bdd&act=struct>
					<input type=hidden name="id_table" value='.$_SESSION['table_table'].'>
					<input type=hidden name="bdd_color" value='.$_SESSION['bdd_name'].'>
					<input type=hidden name="select_line" value='.$explain_table[$i]['Field'].'>
					<button class="btn waves-effect waves-light light-green darken-3">MODIF
					<i class="material-icons right">open_in_new</i>
					</button>
					<button class="btn waves-effect waves-light red darken-4" name="delete_struct" value="delete_struct" onclick=return(confirm("Supprimer?"))>SUPP
					<i class="material-icons right">delete</i>
					</button>
					</form>
					</td>
					</tr>
					';
					
					$i = $i + 1;
				}
				?>
			</tbody>
		</table>
		<br>
		
	</div>
	<!------------------------------------------------------ FIN STRUCTURE BDD ---------------------------------------------------------->
	<!------------------------------------------------------ AFFICHE BDD ---------------------------------------------------------->
	<div id="data_bdd" class="col s12">
		<table class="bordered striped centered">
			<thead>
				<?php
				$explain_table = $con->query("select COLUMN_NAME as 'Field', COLUMN_TYPE as 'Type', IS_NULLABLE as 'Null', COLUMN_KEY as 'Key',
					COLUMN_DEFAULT as 'Default', EXTRA as 'Extra' from INFORMATION_SCHEMA.COLUMNS where
					TABLE_NAME = '".$_SESSION['table_color']."' and TABLE_SCHEMA = '".$_SESSION['bdd_name']."'");
				echo "<tr>";
				while ($result = $explain_table->fetch())
					echo '<th data-field="price">'.$result['Field'].'</th>';
				?>
				<th data-field="price">&nbsp</th>
			</tr>
		</thead>

		<tbody>
			<?php
			$select_data = $con->query("SELECT * FROM ".$_SESSION['bdd_name'].".".$_SESSION['table_color']."");
			if($select_data != false){
				echo "<form method=POST action=index.php?uc=table&act=delete_value>";
				while($result = $select_data->fetch())
				{
					echo '<tr>';
					$j = -1;
					$primary_key = $pdo->describe_table($_SESSION['bdd_name'], $_SESSION['table_color']);
					foreach ($primary_key as $val) {
						$j = $j + 1;
						if ($val[3] == "PRI")
						{
							$primary_key = $val[0];
							break;
						}
						else
						{
							$primary_key = 0;
						}
					}
					//echo "nbr= ".$j;
					$i = 0;
					echo "<input type=hidden name=primary_key value=".$primary_key."></input>";
					echo "<input type=hidden name=database value=".$_SESSION['bdd_name']."></input>";
					echo "<input type=hidden name=table_select value=".$_SESSION['table_color']."></input>";
					while (isset($result[$i]))
					{
						echo '<td>'.$result[$i].'</td>';
						$i++;
					}
					?>
					<td style="text-align: right; width: 200px;">
						<button  style="width: 145px; margin-bottom:10px;" class="btn waves-effect waves-light light-green darken-3">MODIF
							<i class="material-icons right">open_in_new</i>
						</button>
						<button style="width: 145px; margin-bottom:10px;" name="value_pk" value=<?php echo $result[$j]; ?> class="btn waves-effect waves-light red darken-4" onclick=return(confirm("Supprimer?"))>SUPP
							<i class="material-icons right">delete</i>
						</button>
					</td>
				</tr>
				<?php } 
				
				?>
			</form>
		</tbody>
	</table>
	<br><br>
	<table class="bordered striped centered">
		<thead>
			<tr>
				<th data-field="name">Nom</th>
				<th data-field="type">Type</th>
				<th data-field="inter_class">NULL</th>
				<th data-field="att">Valeur</th>
			</tr>
		</thead>

		<tbody>
			<?php
			
			$i = 0;
			$explain_table = $pdo->explain_table($_SESSION['table_table'], $_SESSION['bdd_name']);
			$j = count($explain_table);
			echo "<form method=POST action=index.php?uc=table&act=add_value&bdd=".$_SESSION['bdd_name']."&table=".$_SESSION['table_table'].">";
			while ($i < $j)
			{
				echo '
				<tr>
				<td>'.$explain_table[$i]['Field'].'</td>
				<td>'.$explain_table[$i]['Type'].'</td>
				<td>'.$explain_table[$i]['Null'].'</td>';
				
				if ($explain_table[$i]['Extra'] != "auto_increment")
				{
					echo '<input type=hidden name='.$i.' value='.$explain_table[$i]['Field'].'></input>';
					echo '<td><input name='.$explain_table[$i]['Field'].'></input></td>';
				}
				else
					echo '<td><input name='.$explain_table[$i]['Field'].' disabled></input></td>
				</tr>
				';
				
				$i = $i + 1;
			}
			?>
		</tbody>
	</table>
	<br>
	<div class="right-align">
		<button style="margin-right: 15px;" class="btn waves-effect waves-light" type="submit">Valider
			<i class="material-icons right">send</i>
		</button>
	</div>
</form>
<br><br><br>
<?php } ?>

	<!-- <table class="bordered striped centered">
		<thead>
			<tr>
				<th data-field="id">Colonne</th>
				<th data-field="price">Type</th>
				<th data-field="price">Valeur</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>Id</td>
				<td>int(255)</td>
				<td>
					<div class="input-field">
						<input id="last_name" type="number" class="validate">
						<label for="last_name">1</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>Marque</td>
				<td>varchar(255)</td>
				<td>
					<div class="input-field">
						<input id="last_name" type="text" class="validate">
						<label for="last_name">Lenovo</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>Model</td>
				<td>varchar(255)</td>
				<td>
					<div class="input-field">
						<input id="last_name" type="text" class="validate">
						<label for="last_name">N34-s</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>Prix produit</td>
				<td>float(255)</td>
				<td>
					<div class="input-field">
						<input id="last_name" type="number" class="validate">
						<label for="last_name">20 €</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>Categorie</td>
				<td>varchar(255)</td>
				<td>
					<div class="input-field">
						<input id="last_name" type="text" class="validate">
						<label for="last_name">Ordinateur</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>Descriptif</td>
				<td>varchar(255)</td>
				<td>
					<div class="input-field">
						<textarea id="textarea1" class="materialize-textarea"></textarea>
						<label for="textarea1">"Sed ut perspiciatis und?"ed ut perspiciatis und?"ed ut perspiciatis und?"ed ut persd?"ed ut perspiciatis und?"ed ut perspiciatis und?"ed ut perspiciatis und?""Sed ut perspiciatis und?"ed ut perspiciatis und?"ed ut perspiciatis und?"kkkkkk</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>Img</td>
				<td>varchar(255)</td>
				<td>
					<div class="input-field">
						<input id="last_name" type="text" class="validate">
						<label for="last_name">Une image</label>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<div class="right-align">
		<button style="margin-right: 15px;" class="btn waves-effect waves-light" type="submit" name="action">Valider
			<i class="material-icons right">send</i>
		</button>
	</div> -->
</div>
<!------------------------------------------------------ FIN AFFICHE BDD ---------------------------------------------------------->
</div>