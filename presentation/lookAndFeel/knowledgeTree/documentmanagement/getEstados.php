<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {


$id_docactual=$_GET[idd];
$id_enlacesel=$_GET[cc];
 

//=======>>>> Select q busca el contenido de pais..

$uno1="SELECT B.`name`,B.`id` FROM `document_fields_link`as A, `documents` as B WHERE A.`document_id`= B.`id` AND B.`document_type_id`=36 AND A.`value`=383 AND  A.`document_field_id`=". $id_docactual;
$uno2= mysql_query($uno1);
$uno3 =mysql_fetch_row($uno2);



//==========================>>
 

$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$pais[1];
$linkB = mysql_query($linkA);
 
  
//while fetch row
while ($enlaceB=mysql_fetch_row($linkB)){

       echo "obj.options[obj.options.length] = new Option('$enlaceB[0] $enlaceB[1]','$enlaceB[1]');\n";

}
 
 ?>