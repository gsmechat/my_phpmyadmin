<div class="container">
<div class="row">
<?php
	if (is_array($req) == "TRUE")
	{
		$i = count($req);
		$k = 0;
		echo '<table class="centered striped"><tbody>';
		while ($k < $i)
		{
			$j = count($req[$k]) / 2;
			$l = 0;
			echo "<tr>";
			while ($l < $j)
			{
				echo '<td class="collection-item">'.$req[$k][$l]."</td>";
				$l = $l + 1;
			}
			echo "</tr>";
			$k = $k + 1;
		}
		echo "</tbody>
      </table>";
	}else{
		echo $req;
	}
?>
	<div class="right-align">
		<br>
		<a href="index.php?uc=main" class="waves-effect waves-light btn"><i class="material-icons left">Send</i>Retour</a>
	</div>
</div>
</div>