<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {


$id_docactual=$_GET[idd];
$id_enlacesel=$_GET[cc];
 

//============================>>
$one= "SELECT  `enlazadoA`, `enlazadoB`  FROM `document_types_lookup` WHERE `id` =".$id_enlacesel;
$two = mysql_query($one);
$tipodocs_enlazados = mysql_fetch_row($two);


//===========================>>
$tres= "SELECT `document_type_id`  FROM `documents` WHERE `id` =".$id_docactual;
$cuatro = mysql_query($tres);
$tipo_docactual = mysql_fetch_row($cuatro);


//==========================>>
 if ($tipo_docactual[0] == $tipodocs_enlazados[0]){
//desplegar enlazadoB
 
   
 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 
  
//while fetch row
while ($enlaceB=mysql_fetch_row($linkB)){

       echo "obj.options[obj.options.length] = new Option('$enlaceB[0] $enlaceB[1]','$enlaceB[1]');\n";

}
 
//echo "obj.options[obj.options.length] = new Option('uno ','1001');\n";
 }
 
 elseif ($tipo_docactual[0] == $tipodocs_enlazados[1]){
//desplegar enlazadoA
$LinkA2 = "SELECT `name`, `id` FROM  `documents` WHERE  `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[0];
$LinkB2 = mysql_query($LinkA2);


while ($enlaceA=mysql_fetch_row($LinkB2)){


       echo "obj.options[obj.options.length] = new Option('$enlaceA[0] $enlaceA[1]','$enlaceA[1]');\n";

}
 
//echo "obj.options[obj.options.length] = new Option('dos $tipodocs_enlazados[0] ','1002');\n";

 }
 
else{
   echo "obj.options[obj.options.length] = new Option('Opcion no valida para este tipo de enlace','2');\n";
echo "ERROR";

}



}
 ?>