<?php

require_once("../../../../config/dmsDefaults.php");


if (checkSession()) {

require_once("../../../../lib/util/sanitize.inc");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
//echo $_SESSION["userID"];
$letra = $_GET["letra"];




//=======MIKE======//
//== busqueda de todos aquellos individuos relacionados con el documento  y q su link sea de tipo individuo has individuo ==

function displayBotonEventosF($oDocument, $bEdit) {
	global $default;

	//=======>>>>  busqueda para encontrar el tipo de enlace =========>>>>

	$ONE= "SELECT A.`id` FROM `document_types_lookup` AS A, `document_types_lookup` AS B WHERE A.`enlazadoA`=B.`id` AND A.`enlazadoB`=".$oDocument->getDocumentTypeID()."  AND B.`name` LIKE ''" ;
	$TWO = mysql_query($ONE);
	$tipoenlace = mysql_fetch_row($TWO);

	/**
$dbg="update debugg set tres =" .'"'."TipoEnl ".$oDocument->getDocumentTypeID().'"'."where llave=5";
$r2 = mysql_query($dbg);
	*/

 return displayButton2("fichas2","addDocument", "fFolderID=9&arch=2&botview=102&tipoen=".$tipoenlace[0]."&docqllama=".$oDocument->getID(), "Agregar Eventos");
     }





   $letram=strtoupper($letra);
   $letrasar= explode("_",$letram);
  
   echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";    
 echo "<table style='text-align: left; width:90% ; ' border='0'  cellpadding='2' cellspacing='2'><tbody>

<tr>
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><font size=1 face='Arial'>Eventos PESC<tbody>";
$insmod=0;
   for($i=0; $i<count($letrasar)-1;$i++){

$busq_links="SELECT a.`document_id` FROM `document_fields_link`as a,`documents`as b  WHERE a.`document_field_id`=109 AND b.`id`= a.`document_id`AND b.`status_id`<=2 AND b.`document_type_id`= 55  AND  a.`value` like '". $valor."%' and cast(b.modified as date) > (CURDATE()-INTERVAL 2 WEEK) order by b.modified DESC";
$busq_links1 = mysql_query($busq_links);
//$busq_links2 = mysql_fetch_row($busq_links1);



 while ($busq_links2 = mysql_fetch_row($busq_links1))
{
 $insmod++; 
  $modd=$insmod%2;
  $red=220*$modd-255*($modd-1);
  $green=220*$modd-255*($modd-1);
  $blue=220*$modd-255*($modd-1);
$oDocument = & Document::get($busq_links2[0]);

 

  echo "<tr><td></td><td><table><tr>


<td>". displayButton2("_blank","reporte", "idd=".$busq_links2[0], "Reporte")." </td></tr>


</table></td></tr>";
//<tr><td valign='top' height=40% align='center'>";
echo "<tr style='background-color: rgb($red, $green,$blue);'><td valign='top' height=40% align='left'>";
  //======= se integra la imagen del individuo a los resultados de la busqueda ======
 
 $docs="img/".$oDocument->getFileName();
   // echo $docs;

 //==================>>>  BUSQUEDA DE CAMPOS DEL DOCUMENTO  =====================>>>>>

$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$busq_links2[0];
$indv_rel1 = mysql_query($indv_rel);
//$indv_rel2 = mysql_fetch_row($indv_rel1);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 
 if ($indv_rel2[2]==109) {
    $date=$indv_rel2[3];
    
}
 if ($indv_rel2[2]==110 ){
   $region=$indv_rel2[3];

}
if ($indv_rel2[2]==161){
 //   $zcity=$indv_rel2[3];
 $lugar=$indv_rel2[3];
if ($lugar>0){

$linkA3 = "SELECT C.`dos` FROM  `Lugares`.`Lugares` as A, `Lugares`.`Pais` as C WHERE A.`cinco` = C.`id` AND A.`id`=".$lugar;
$linkB3 = mysql_query($linkA3);
$dato3=mysql_fetch_row($linkB3);

$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$lugar;
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$lugar;
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);



$partnom=$dato1[0].",".$dato2[0].",".$dato3[0];
}
else {$partnom="";}
    
}

if ($indv_rel2[2]==164 ){
    $typeof=$indv_rel2[3];

}
 if ($indv_rel2[2]==113 ){
    $summ=$indv_rel2[3];

}
if ($indv_rel2[2]==114){
    $note=$indv_rel2[3];

}
if ($indv_rel2[2]==264 ){
    $summ0=$indv_rel2[3];

}
if ($indv_rel2[2]==273 ){
    $ispol=$indv_rel2[3];

}
if ($indv_rel2[2]==274){
    $isecon=$indv_rel2[3];

}
if ($indv_rel2[2]==275){
    $issocial=$indv_rel2[3];

}
if ($indv_rel2[2]==276 ){
    $iscont=$indv_rel2[3];

}
if ($indv_rel2[2]==82 ){
    $source=$indv_rel2[3];

}



//================= 


}

 echo "<a href='/FichasBD/branches/SY/control.php?action=getfeventpesc&letra=".$busq_links2[0]."' target='fichas2' ><font size=2 face='Arial'>".$date." ".$region."</font></a>



";
}
}

echo "</td></tr></table></table>";

/**
<a href='/FichasBD/branches/fichas_cps/control.php?action=logout' target='fichas2'>SALIR</A></font>


<table align='right' style='text-align: left; width:20% ;' border='1'  cellpadding='2' cellspacing='2'>
<tr><td></table>";


<iframe src='http://www.intelect.com.mx:82/~FichasBD/branches/fichas_cps' name='fichas2' width='500' height='500' scrolling='auto' frameborder='1' transparency></iframe></td></tr></tbody></tbody></table>


<TABLE BORDER='1' cellspacing='1' cellpadding='2' width='10%'>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=15' target='fichas2'>INDIVIDUO</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=15&arch=18' target='fichas2'>AGREGAR INDIVIDUO</A><br>
</td>
</tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=10' target='fichas2'>DOMICILIO</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=10&arch=9' target='fichas2'>AGREGAR DOMICILIO</A><br>
</td></tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=9' target='fichas2'>EVENTOS</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=9&arch=2' target='fichas2'>AGREGAR EVENTOS</A><br>
</td>
</tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=13' target='fichas2'>FINANZAS</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=13&arch=14' target='fichas2'>AGREGAR FINANZAS</A><br>
</td>
</tr>


<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=14' target='fichas2'>PREFERENCIAS</A><br>

</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=14&arch=16' target='fichas2'>AGREGAR PREFERENCIAS</A><br>
</td>
</tr>

<tr>
<td>

<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=11' target='fichas2'>EMPRESA MATRIZ</A><br>

</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=11&arch=11' target='fichas2'>AGREGAR EMPRESA</A><br>
</td>
</tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=17' target='fichas2'>LUGARES</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=17&arch=23' target='fichas2'>AGREGAR LUGARES</A><br>
</td>
</tr>
<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=16' target='fichas2'>INSTITUTO/ORG</A><br>

</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=16&arch=22' target='fichas2'>AGREGAR INSTITUTO/ORG</A><br>
</td>
</tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=browse&fFolderID=37' target='fichas2'>MULTIMEDIA</A><br>
</td>
<td>
<a href='../../../../control.php?action=addDocument&fFolderID=37&arch=33' target='fichas2'>AGREGAR MULTIMEDIA</A><br>
</td>
</tr>

<tr>
<td>
<a href='/~FichasBD/branches/fichas_cps/control.php?action=logout' target='fichas2'>SALIR</A><br>
</td>
</tr>

</table>
</font>
</table>";
*/


//===========>>  Busqueda de nombres de documento de Individuo   =========>>
//======== busqueda de todos aquellos documentos q sean de tipo individuo =======
/**
$bus_one="SELECT `name`,`document_type_id`  FROM `documents` WHERE `document_type_id`=18";
$bus_two = mysql_query($bus_one);


echo "<table style='text-align: left; width:100% ;background-color: rgb(220, 220,220);' border='1'  cellpadding='2' cellspacing='2'><tbody><tr>
      <td><table align='left' width=20% style='text-align: left; width: ;' border='1'  cellpadding='2' cellspacing='2'><tbody>";

 while($busq_doc_indv = mysql_fetch_row($bus_two))
   {



 echo "<tr><td style='background-color: rgb(190,190,190);'>".$busq_doc_indv[0]."<br/></td></tr>";
 
   }
echo "</td></tr></table><table align='right' style='text-align: left; width:20% ;' border='1'  cellpadding='2' cellspacing='2'>
<tr><td><iframe src='http://www.google.com.mx' name='' width='450' height='500' scrolling='auto' frameborder='1' transparency></iframe></td></tr></tbody></tbody></table>


</table>";
*/

// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 

//while fetch row
//while ($enlaceB=mysql_fetch_row($linkB)){

  //  echo "obj.options[obj.options.length] = new Option('$enlaceB[0] $enlaceB[1]','$enlaceB[1]');\n";

//}
 
}
 
 elseif ($tipo_docactual[0] == $tipodocs_enlazados[1]){
//desplegar enlazadoA
$LinkA2 = "SELECT `name`, `id` FROM  `documents` WHERE  `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[0];
$LinkB2 = mysql_query($LinkA2);


while ($enlaceA=mysql_fetch_row($LinkB2)){


  //  echo "obj.options[obj.options.length] = new Option('$enlaceA[0] $enlaceA[1]','$enlaceA[1]');\n";

}
 }
//;  $sessionID = $session->destroy($userDetails["userID"]);




?>