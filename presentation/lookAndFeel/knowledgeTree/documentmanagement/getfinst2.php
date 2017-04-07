<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

$id_docactual=$_GET[idd];
$id_enlacesel=$_GET[cc];
 


require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentCollaboration.inc");
$letra = $_GET["letra"];



$id_docactual=256;
$id_enlacesel=34;



 
function ascendencia($pfName) {
	global $default;

//obtenpap(n)
  
$oneev='(SELECT * FROM `empresa_empresa` where child_id = '. $pfName  .' and matriz = \'yes\' )'
       .'Union'
       .'(SELECT * FROM `empresa_empresa` where parent_id = '. $pfName  .' and (matriz = \'no\' or matriz is NULL) )'
       .'order by fecha desc, jv desc';
$twoev=mysql_query($oneev);



// si hay papas

if ($threev=mysql_fetch_row($twoev))
{

// si jv llamar ascendencia de cada participante
if ($twoev[6]=='yes'){
}

//solo 1 matriz


//llamada recursiva
}

//regresa papas


}

 
function descendencia($pfName) {
	global $default;
}


 
function limpiaFname($pfName) {
	global $default;


$As = array("Á","À","Ä","Â");
$Es = array("É","È","Ë","Ê");
$Is = array("Í","Ì","Ï","Î");
$Os = array("Ó","Ò","Ö","Ô");
$Us = array("Ú","Ù","Ü","Û");
$Aas = array("á","à","ä","â");
$Ees = array("é","è","ë","ê");
$Iis = array("í","ì","ï","î");
$Oos = array("ó","ò","ö","ô");
$Uus = array("ú","ù","ü","û");
$simbolos = array("¡","¿","?","'","´","]","}","[","{","^","`","\\","¬","|","°","<",">",",","*","+","!","\"","#","$","%","&","(",")","=","¨","*","~",":",";");



$fName1011=$pfName;
$pfName=str_replace("/","_",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($As,"A",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Es,"E",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Is,"I",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Os,"O",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Us,"U",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Aas,"a",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Ees,"e",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Iis,"i",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Oos,"o",$fName1011);
$fName1011=$pfName;

$pfName=str_replace($Uus,"u",$fName1011);


$fName1011=$pfName;

$pfName=str_replace($simbolos,"#",$fName1011);
$fName1011=$pfName;

$pfName=str_replace("ñ","n",$fName1011);
$fName1011=$pfName;

$pfName=str_replace("Ñ","N",$fName1011);







 return $pfName;
     }



 

//=======MIKE======//
//== busqueda de todos aquellos individuos relacionados con el documento  y q su link sea de tipo individuo has individuo ==

function displayBotonEventosF($oDocument, $bEdit) {
	global $default;

	//=======>>>>  busqueda para encontrar el tipo de enlace =========>>>>

	$ONE= "SELECT A.`id` FROM `document_types_lookup` AS A, `document_types_lookup` AS B WHERE A.`enlazadoA`=B.`id` AND A.`enlazadoB`=".$oDocument->getDocumentTypeID()."  AND B.`name` LIKE 'Eventos'" ;
	$TWO = mysql_query($ONE);
	$tipoenlace = mysql_fetch_row($TWO);

 return displayButton("addDocument", "fFolderID=9&arch=2&botview=101&tipoen=".$tipoenlace[0]."&docqllama=".$oDocument->getID(), "Agregar Eventos");
     }





   $iddoc=$letra;
 echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";
 echo "<table style='text-align: left; width:80% ; ' border='0'  cellpadding='2' cellspacing='2'><tbody>

<tr>
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><font size=1 face='Times'><tbody>";

  


$iddoc = $_GET["letra"];

$oDocument = & Document::get($iddoc);
  
 
  echo "<tr><TH rowspan='1'><TH colspan='2'align='center' ><font size=1 face='Times'>Datos Inst/Organizaci&oacute;n</font></tr> <tr><td valign='top' height=40% align='left'>";

  //======= se integra la imagen del individuo a los resultados de la busqueda ======
   $docs="img/".$oDocument->getFileName();
if ($sectionName == "") {
    $sectionName = $default->siteMap->getSectionName(substr($_SERVER["PHP_SELF"], strlen($default->rootUrl), strlen($_SERVER["PHP_SELF"])));
}
 //====== busqueda para datos de cada individuo relacionados con el doc 256 =====
$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$iddoc;
$indv_rel1 = mysql_query($indv_rel);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 

 if ($indv_rel2[2]==92) {
    $nomcom=$indv_rel2[3];
    
}
 if ($indv_rel2[2]==78 ){
   $fechreg=$indv_rel2[3];

}
 if ($indv_rel2[2]==57){
   $tel=$indv_rel2[3];

}
 if ($indv_rel2[2]==71 ){
    $raz=$indv_rel2[3];

}
if ($indv_rel2[2]==91 ){
    $fechfun=$indv_rel2[3];

}
 if ($indv_rel2[2]==93 ){
    $giro=$indv_rel2[3];

}
if ($indv_rel2[2]==94){
    $site=$indv_rel2[3];

}
if ($indv_rel2[2]==95 ){
    $clav=$indv_rel2[3];

}
if ($indv_rel2[2]==18 ){
    $lug=$indv_rel2[3];

$uno="SELECT `name` FROM `documents` WHERE `id` =".$lug;
$dos=mysql_query($uno);
$tres=mysql_fetch_row($dos);

$Lug=explode(" ",$tres[0]); 
}
 

}



 echo "<font size=2 face='Times' color='blue'>Nombre  Comercial</font></td>
<td><font size=2 face='Times'>".$nomcom ."</font></td>";


echo"
<td>".displayBotonRelacInddesInst($oDocument, $bEdit) ."


".displayBotonRelacProdesdeInst($oDocument, $bEdit)."
".displayBotonRelacInstdesdeInst($oDocument, $bEdit) ."
".displayBotonRelacEventdesdeInst($oDocument, $bEdit) ."
</td>"; 

if ($_SESSION["userID"]==1){
$bEdit=1;
if(!($sectionName =="Administration")){
echo"
<td>".displayBotonEditar($oDocument, $bEdit)."
".displayCheckInOutButton($oDocument, $bEdit)."</td>"; 

	
				}	
		}

echo "
<tr><td><font size=2 face='Times' color='blue'>Raz&oacute;n Social</font></td>
<td ><font size=2 face='Times' >".$raz ."</font></td>


</tr>
<tr><td><font size=2 face='Times' color='blue'>Fecha de Registro</font></td>
<td ><font size=2 face='Times'>".$fechreg ."</font></td>
</tr>

<tr><td><font size=2 face='Times' color='blue'>Fecha de Fundaci&oacute;n</font></td>
<td ><font size=2 face='Times'>".$fechfun."</font></td>
</tr>
<tr>
<td><font size=2 face='Times' color='blue'>Giro Inicial</font></td>
<td ><font size=2 face='Times'>".$giro."</font></td>

</tr>

<tr>
<td><font size=2 face='Times' color='blue'>Telef&oacute;no</font></td>
<td><font size=2 face='Times'>".$tel ."</font></td>

</tr>

<tr>
<td><font size=2 face='Times' color='blue'>Clave Pizarra</font></td>
<td  colspan='2'><font size=2 face='Times'>".$clav."</font></td>

</tr>

<tr>
<td><font size=2 face='Times' color='blue'>Sitio Web</font></td>
<td colspan='2'><font size=2 face='Times'>".$site."</font></td>

</tr>

";
 


echo "</td></tr></table>";


//================>>>> INICIA INDIVIDUOS ===============>>>>
echo "<tr><td>";
//*** Evento

//me quede en corregir abajo
//ids de docs tipo ind has evento, que relacionen a la ficha referenciante

/*** parte comentada empieza aqui **/
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=4 and `status_id` = 1") or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
 $indice++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Individuo</center></font></thead><tbody>";
echo "<tr>";

echo "<th><font size=2 face='Times' color='blue'>Individuo</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Nacionalidad</font></th>";


// a,b,c ... todos los campos de un documento especifico
// doc es el documento enlace y con el campo comentario
//h es hijo o padre de doc, es de tipo evento y ea,eb e... son sus campos


$result3= mysql_query("SELECT a.document_id, a.value,ea.value,eb.value,ec.value,ed.value, h.name,h.id, ee.value FROM `document_fields_link` as a,`document_fields_link` as ea,`document_fields_link` as eb,`document_fields_link` as ec ,`document_fields_link` as ed ,`document_fields_link` as ee, `documents` as doc ,`documents` as h WHERE doc.`id` = a.`document_id` and a.`document_field_id`=29 AND ea.`document_id`=eb.`document_id` AND ea.`document_id`=ec.`document_id` AND ea.`document_id`=ed.`document_id`  AND ea.`document_field_id`=8 AND eb.`document_field_id`=21 AND ec.`document_field_id`=22 AND ed.`document_field_id`=23 AND ee.`document_field_id`=54 AND ee.`document_id`=ea.`document_id` AND (((h.`id` = doc.`parent_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=18) or ((h.`id` = doc.`child_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=18))  and doc.`document_type_id`=4 and doc.`status_id` = 1 and ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) order by eb.value desc ") or die("deadw"); 



while($row3 =  mysql_fetch_row($result3))
{
  
/**
subindice
0
1       a  comentario            4
2	ea Tipo de Evento        6
3	eb Fecha de Registro ord 1
4	ec Titulo de Evento      2
5	ed Lugar                 3
	g 
6       h evento       
7       ee fuente                5
*/

if ($row3[7]>0){
$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$row3[7];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$Lug=explode(" ",$threev1[0]);
} else {$Lug=explode("_"," _N/A_ _ _ ");}
echo "<tr>";

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$row3[7] ."' target='fichas2' >".$row3[2] ." ".$row3[3] ." ".$row3[4] ."</font></a></td>";
echo "<td ><font size=2 face='Times'>".$row3[8] ."</font></td>";
echo "</tr>";


} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA INDIVIDUOS <<<<=============


//================>>>> INICIA EVENTOSB2B ===============>>>>
echo "<tr><td>";
$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=41 and `status_id` = 1") or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
 $indice++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Evento Empresarial</center></font></thead><tbody>";
echo "<tr>";


echo "<th><font size=2 face='Times' color='blue'>Fecha de Registro</font></td>";
echo "<th><font size=2 face='Times' color='blue'>T&iacute;tulo de Evento</font></th>";
echo "<th><font size=2 face='Times' color='blue'>Tipo de Evento</font></td>";

// a,b,c ... todos los campos de un documento especifico
// doc es el documento enlace y con el campo comentario
//h es hijo o padre de doc, es de tipo evento y ea,eb e... son sus campos



$result3= mysql_query("SELECT a.document_id, a.value,ea.value,eb.value,ec.value,ed.value, h.name,h.id, ee.value,ef.value,eg.value,eh.value,ei.value,ej.value,ek.value,el.value,em.value,en.value,eo.value,ep.value,eq.value,er.value,es.value,et.value,eu.value,ev.value,ew.value,ex.value  FROM `document_fields_link` as a,`document_fields_link` as ea,`document_fields_link` as eb,`document_fields_link` as ec ,`document_fields_link` as ed ,`document_fields_link` as ee,`document_fields_link` as ef,`document_fields_link` as eg,`document_fields_link` as eh,`document_fields_link` as ei,`document_fields_link` as ej,`document_fields_link` as ek,`document_fields_link` as el,`document_fields_link` as em,`document_fields_link` as en,`document_fields_link` as eo,`document_fields_link` as ep,`document_fields_link` as eq,`document_fields_link` as er,`document_fields_link` as es,`document_fields_link` as et,`document_fields_link` as eu,`document_fields_link` as ev,`document_fields_link` as ew,`document_fields_link` as ex, `documents` as doc ,`documents` as h WHERE doc.`id` = a.`document_id` and a.`document_field_id`=8 AND ea.`document_id`=eb.`document_id` AND ea.`document_id`=ec.`document_id` AND ea.`document_id`=ed.`document_id`  AND ee.`document_id`=ea.`document_id` AND ea.`document_id`=ef.`document_id`  AND ea.`document_id`=eg.`document_id`  AND ea.`document_id`=eh.`document_id`  AND ea.`document_id`=ei.`document_id`  AND ea.`document_id`=ej.`document_id`  AND ea.`document_id`=ek.`document_id`  AND ea.`document_id`=el.`document_id`  AND ea.`document_id`=em.`document_id`  AND ea.`document_id`=en.`document_id`  AND ea.`document_id`=eo.`document_id`  AND ea.`document_id`=ep.`document_id`  AND ea.`document_id`=eq.`document_id`  AND ea.`document_id`=er.`document_id`  AND ea.`document_id`=es.`document_id`  AND ea.`document_id`=et.`document_id`  AND ea.`document_id`=eu.`document_id`  AND ea.`document_id`=ev.`document_id`  AND ea.`document_id`=ew.`document_id` AND ea.`document_id`=ex.`document_id`  AND ea.`document_field_id`=118 AND eb.`document_field_id`=117 AND ec.`document_field_id`=131 AND ed.`document_field_id`=130 AND ee.`document_field_id`=127 AND ef.`document_field_id`=119 AND eg.`document_field_id`=120 AND eh.`document_field_id`=75 AND ei.`document_field_id`=115 AND ej.`document_field_id`=114 AND ek.`document_field_id`=113 AND el.`document_field_id`=128 AND em.`document_field_id`=111 AND en.`document_field_id`=109 AND eo.`document_field_id`=110 AND ep.`document_field_id`=116 AND eq.`document_field_id`=129 AND er.`document_field_id`=121 AND es.`document_field_id`=122 AND et.`document_field_id`=123 AND eu.`document_field_id`=124 AND ev.`document_field_id`=125 AND ew.`document_field_id`=126 AND ex.`document_field_id`=132 AND (((h.`id` = doc.`parent_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=38) or ((h.`id` = doc.`child_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=38))  and doc.`document_type_id`=41 and doc.`status_id` = 1 and ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) order by eb.value desc ") or die("deadw"); 


while($row3 =  mysql_fetch_row($result3))
{
  
/**
subindice
0
1       a  comentario            4
2	ea Tipo de Evento        6
3	eb Fecha de Registro ord 1
4	ec Titulo de Evento      2
5	ed Lugar                 3
	g 
6       h evento       
7       ee fuente                5
*/


echo "<tr>";

echo "<td ><font size=2 face='Times'>".$row3[0] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$row3[1] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$row3[2] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$row3[3] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$row3[4] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$row3[5] ."</font></td>";

echo "</tr>";


} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA EVENTOSB2B <<<<=============

//================>>>> INICIA PRODUCTOS ===============>>>>
echo "<tr><td>";


$resulta= mysql_query("SELECT id FROM `documents` WHERE ((`parent_document_id`= $iddoc)  or ( `child_document_id`= $iddoc)) and `document_type_id`=40 and `status_id` = 1") or die("deadind1"); 
$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 
 $indice++; 
}
 

// Si indice es mayor a 0 existe trayectoria
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Productos</center></font></thead><tbody>";
echo "<tr>";

echo "<th><font size=2 face='Times' color='blue'>Producto</font></td>";
echo "<th><font size=2 face='Times' color='blue'>Descripci&oacute;n</font></th>";

// a,b,c ... todos los campos de un documento especifico
// doc es el documento enlace y con el campo comentario
//h es hijo o padre de doc, es de tipo evento y ea,eb e... son sus campos



$result3= mysql_query("SELECT a.document_id, a.value,ea.value,eb.value,ec.value,ed.value, h.name,h.id, ee.value,h.id  FROM `document_fields_link` as a,`document_fields_link` as ea,`document_fields_link` as eb,`document_fields_link` as ec ,`document_fields_link` as ed ,`document_fields_link` as ee, `documents` as doc ,`documents` as h WHERE doc.`id` = a.`document_id` and a.`document_field_id`=8 AND ea.`document_id`=eb.`document_id` AND ea.`document_id`=ec.`document_id` AND ea.`document_id`=ed.`document_id`  AND ea.`document_field_id`=8 AND eb.`document_field_id`=8 AND ec.`document_field_id`=6 AND ed.`document_field_id`=8 AND ee.`document_field_id`=6 AND ee.`document_id`=ea.`document_id` AND (((h.`id` = doc.`parent_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=39) or ((h.`id` = doc.`child_document_id` AND ea.`document_id`=h.`id`) and h.`document_type_id`=39))  and doc.`document_type_id`=40 and doc.`status_id` = 1 and ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) order by eb.value desc ") or die("deadw"); 

while($row3 =  mysql_fetch_row($result3))
{
  
/**
subindice
0
1       a  comentario            4
2	ea Tipo de Evento        6
3	eb Fecha de Registro ord 1
4	ec Titulo de Evento      2
5	ed Lugar                 3
	g 
6       h evento       
7       ee fuente                5
*/


echo "<tr>";

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfprod&letra=".$row3[7] ."' target='fichas2' >".$row3[2] ."</font></td>";
echo "<td ><font size=2 face='Times'>".$row3[4] ."</font></td>";

echo "</tr>";


} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice



//=================<<<< TERMINA PRODUCTOS <<<<=============


//================>>>> INICIA INSTITUTO ===============>>>>
echo "<tr><td>";


$resulta= mysql_query("SELECT a.`id` FROM `documents` as a ,`document_fields_link` as b WHERE b.`document_id` = a.`id` AND b.`document_field_id` = 171 AND ((a.`parent_document_id`= $iddoc)  or ( a.`child_document_id`= $iddoc)) and a.`document_type_id`=46 and a.`status_id` = 1 order by b.`value`") or die("deadw1");

$indice=0;
while ($row =  mysql_fetch_row($resulta)) 
{ 

 $indice++; 
}
 
if($indice>0)
{
echo "<tr><td>";
echo "<table width=100% height=50%  align='left' style='text-align: left' ; ' border='1'  cellpadding='2' cellspacing='2'><thead><font size=2 face='Times'  color='blue'><center>Instituto</center></font></thead><tbody>";
echo "<tr>";

echo "<th><font size=2 face='Times' color='blue'>Instituto</font></td>";
//echo "<th><font size=2 face='Times' color='blue'></font></th>";

echo "</tr>";





$res0= mysql_query("SELECT a.document_id, a.value, b.value, c.value, d.value, a.id, f.value, h.name,h.id, g.value FROM `document_fields_link` as a , `document_fields_link` as b , `document_fields_link` as c, `document_fields_link` as d , `document_fields_link` as f, `document_fields_link` as g  ,`documents` as doc ,`documents` as h  WHERE a.`document_id` = b.`document_id` and b.`document_id` = c.`document_id` and a.`document_id` = d.`document_id` and a.`document_id` = f.`document_id` and a.`document_id` = g.`document_id` and  a.`document_field_id` = 78 and b.`document_field_id` = 57 and c.`document_field_id` = 92 and d.`document_field_id` = 91  and f.`document_field_id` = 71 and g.`document_field_id` = 94 and doc.`id` = a.`document_id`  and (((h.`id` = doc.`parent_document_id`) and doc.`parent_document_id`<> $iddoc) or ((h.`id` = doc.`child_document_id`)and doc.`child_document_id`<> $iddoc))  and h.`document_type_id`=22 and a.`document_id`=doc.id  AND ((doc.`parent_document_id`= $iddoc)  or ( doc.`child_document_id`= $iddoc)) and doc.`document_type_id`=46 and doc.`status_id` = 1 order by d.value desc,h.name desc ") or die("deadw"); 



while($row0 =  mysql_fetch_row($res0))
{
  
/**



if ($lug>0){
$oneev1="SELECT `name` FROM `documents` WHERE `id` =".$row3[5];
$twoev1=mysql_query($oneev1);
$threev1=mysql_fetch_row($twoev1);

$Lug=explode(" ",$threev1[0]);
} else {$Lug=explode("_"," _N/A_ _ _ ");}
echo "<tr>";

echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$row3[7] ."' target='fichas2' >".$row3[2] ." ".$row3[3] ." ".$row3[4] ."</font></a></td>";
*/
echo "<td ><font size=2 face='Times'><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$row0[7] ."' target='fichas2' >".$row0[3] ."</font></td>";
echo "</tr>";


} // cierre del for}




echo "</tr></tbody></table></td></tr>";

}  // fin de indice






//=================<<<< TERMINA INSTITUTO <<<<=============


echo "</table>";


// SELECT * FROM `documents` WHERE `document_type_id`=2

//===============>>  Termina busqueda  =========>>

 
//abajo 1-hacer select name, id  from documents where tipo-doc = $tipodocs_enlazados[1]
$linkA = "SELECT `name`, `id` FROM  `documents` WHERE `status_id`= 1 AND `document_type_id`=".$tipodocs_enlazados[1];
$linkB = mysql_query($linkA);
 


 
 


 


 }

 ?>