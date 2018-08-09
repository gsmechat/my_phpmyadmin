$(document).ready(function(){
	$('ul.tabs').tabs();
});

$(document).ready(function() {
    $('select').material_select();
  });

var j = 0;
 $(document).ready(function(){
      var i=1;
      if (j == 0){
      //$('#addr'+i).html("<td><input name='name"+i+"' type='text' placeholder='Name' class='form-control input-md'  /> </td><td><input  name='mail"+i+"' type='text' placeholder='Mail'  class='form-control input-md'></td><td><input  name='mobile"+i+"' type='text' placeholder='Mobile'  class='form-control input-md'></td>");
      $('#addr'+i).html("<td><input type='text' name='name"+i+"'  placeholder='Nom' class='form-control'/></td><td><input type='text' name='prenom"+i+"' placeholder='Prenom' class='form-control'/></td><td><input type='text' name='DateNaiss"+i+"' placeholder='Date de naissance' class='form-control'/></td><td><input type='text' name='lien"+i+"' placeholder='Lien' class='form-control'/></td><td><input type='text' name='droit"+i+"' placeholder='Droit' class='form-control'/></td><td><a onclick=supp_row('addr"+i+"') class='btn btn-primary btn-primary addr"+i+" addrr'>Supprimer</a></td>");       
        $('#tab2').append('<tr id="addr'+(i+1)+'"></tr>');
      i++; 
      j++;
      }
     $("#add_row").click(function(){
      //$('#addr'+i).html("<td><input name='name"+i+"' type='text' placeholder='Name' class='form-control input-md'  /> </td><td><input  name='mail"+i+"' type='text' placeholder='Mail'  class='form-control input-md'></td><td><input  name='mobile"+i+"' type='text' placeholder='Mobile'  class='form-control input-md'></td>");
    	$('#addr'+i).html("<td><input type='text' name='name"+i+"'  placeholder='Nom' class='form-control'/></td><td><input type='text' name='prenom"+i+"' placeholder='Prenom' class='form-control'/></td><td><input type='text' name='DateNaiss"+i+"' placeholder='Date de naissance' class='form-control'/></td><td><input type='text' name='lien"+i+"' placeholder='Lien' class='form-control'/></td><td><input type='text' name='droit"+i+"' placeholder='Droit' class='form-control'/></td><td><a onclick=supp_row('addr"+i+"') class='btn btn-primary btn-primary addr"+i+" addrr'>Supprimer</a></td>");				
      	$('#tab2').append('<tr id="addr'+(i+1)+'"></tr>');
      i++; 
  });
});