<?php

require_once("../../../../config/dmsDefaults.php");


if (checkSession()) {  //1

require_once("../../../../lib/util/sanitize.inc");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
$boolnota=0;
$echoactor=0;
$letra = $_GET["letra"];
$region = $_GET["region"];
$event = $_GET["event"];
$action = $_GET["action2"];
$type = $_GET["type"];
$competitive = $_GET["competitive"];
$sustainability = $_GET["sustainability"];
$reactiontype = $_GET["reactiontype"];
$reactiontopic = $_GET["reactiontopic"];
$consequence = $_GET["consequence"];
$actor = $_GET["actor"];
$competidor=$_GET["competidor"];

$ano=$_GET["ano"];
$apartir=$_GET["apartir"];
$where1 = "";
$from1="";
 $letram=strtoupper($letra);
   $letrasar= explode("_",$letram);
//============================Parametros individuo
$nombre = $_GET["nombre"];
$apellidop = $_GET["apellidop"];
$apellidom = $_GET["apellidom"];
$degree = $_GET["degree"];
//$organizacion=$_GET["organizacion"];
$persona=$_GET["persona"];

$nota = $_GET["nota"];
$parampais=$_GET["pais"];
$paramestado=$_GET["estado"];
$paramciudad=$_GET["ciudad"];
$organizacion=$_GET["organizacion"];
$organizacionh=$_GET["organizacion_hidden"];
$reltop=$_GET["reltoperson"];
$reltoph=$_GET["reltoperson_hidden"];
$industria=$_GET["industry"];
$subindustria=$_GET["subindustry"];
$fechaA=$_GET["fecha1"];
$fechaP=$_GET["fecha2"];
/***
echo "nombre:".$nombre."\n";
echo "ap pat: ".$apellidop."\n";
echo "ap mat: ".$apellidom."\n";
echo "degree: ".$degree."\n";
echo "organizacion :".$organizacion."\n";
echo "organizacionh :".$organizacionh."\n";
echo "reltop :".$reltop."\n";
echo "reltoph :".$reltoph."\n";
echo "industria :".$industria."\n";
echo "subindustria :".$subindustria."\n";
echo "fecha inicial :".$fechaA."\n";
echo "fecha final :".$fechaP."\n";
echo "Pais :".$parampais."\n";
echo "Estado :".$paramestado."\n";
echo "Ciudad :".$paramciudad."\n";
***/

//====================== Indiv
//============ Consulta de campos directamente asociados
//================= Nombre
if($nombre=="")
{
}else
{
$from1.= ",(select value,document_id from  `document_fields_link` where document_field_id=8) as fnombre ";

$where1.="AND ( fnombre.value LIKE '%$nombre%'  AND b.`id` = fnombre.`document_id` )";
}
//================= Apellido Paterno
if($apellidop=="")
{
}else
{
$from1.= ",(select value,document_id from  `document_fields_link` where document_field_id=21) as fapellidop ";

$where1.="AND ( fapellidop.value LIKE '%$apellidop%'  AND b.`id` = fapellidop.`document_id` )";
}
//================= Apellido Materno
if($apellidom=="")
{
}else
{
$from1.= ",(select value,document_id from  `document_fields_link` where document_field_id=22) as fapellidom ";

$where1.="AND ( fapellidom.value LIKE '%$apellidom%'  AND b.`id` = fapellidom.`document_id` )";
}

//============== Rangos de Fecha
if($fechaA=="")
{
}else
{
$boolano=1;
$from1.=",`document_fields_link` as ffechaa ";
$where1.="AND ( ffechaa.document_field_id=23 AND ffechaa.value >= '$fechaA'  AND b.`id` = ffechaa.`document_id` )";
}

if($fechaP=="")
{
}else
{
$boolano=1;
$from1.=",`document_fields_link` as ffechab ";
$where1.="AND ( ffechab.document_field_id=23 AND ffechab.value <= '$fechaP'  AND b.`id` = ffechab.`document_id` )";
}

//================== Busqueda de texto en campos de texto
if($nota=="")
{
}else
{
$from1.= ",(select value,document_id from  `document_fields_link` where document_field_id=256) as fpower ";
$from1.= ",(select value,document_id from  `document_fields_link` where document_field_id=257) as fissues ";
$from1.= ",(select value,document_id from  `document_fields_link` where document_field_id=258) as fnetwork ";
$from1.= ",(select value,document_id from  `document_fields_link` where document_field_id=255) as fmatters ";

$where1.="AND (( fpower.value LIKE '%$nota%'  AND b.`id` = fpower.`document_id` )";
$where1.="OR ( fissues.value LIKE '%$nota%'  AND b.`id` = fissues.`document_id` )";
$where1.="OR ( fnetwork.value LIKE '%$nota%'  AND b.`id` = fnetwork.`document_id` )";
$where1.="OR ( fmatters.value LIKE '%$nota%'  AND b.`id` = fmatters.`document_id` )";
}



//=========== Consulta de Entidades asociadas por enlace
//=================Organizacion, trae dato de ajax en widget javascript
if($organizacion=="" )
{
}else
{
if ($organizacionh!="")
{
$from1.= ",(select * from (select id , child_document_id   from documents where parent_document_id= $organizacionh  and status_id <=2 and document_type_id=4 UNION select id , parent_document_id   from documents where child_document_id= $organizacionh  and status_id <=2 and document_type_id=4 )  as indrel) as forganizacion ";$where1.="AND ( b.`id` = forganizacion.`child_document_id` )";
}
else
{
$from1.= ",(select * from (select emplea.id , emplea.child_document_id   from documents as emplea , document_fields_link as empres where emplea.parent_document_id= empres.document_id and empres.value like '%".$organizacion."%'  and empres.document_field_id=71 and emplea.status_id <=2 and emplea.document_type_id=4 UNION select emplea2.id , emplea2.parent_document_id   from documents as emplea2 , document_fields_link as empres2 where emplea2.child_document_id= empres2.document_id and empres2.value like '%".$organizacion."%'  and empres2.document_field_id=71 and emplea2.status_id <=2 and emplea2.document_type_id=4)  as indrel) as forganizacion ";
$where1.="AND ( b.`id` = forganizacion.`child_document_id` )";
}
}

//========== Consulta de Lugares

if ($parampais!="0" and $parampais!="" ){
if ($paramestado!=""){
if ($paramciudad!=""){
$where1.="AND ( b.`lugar` = $paramciudad  ) ";
}
else {
$where1.="AND ( b.`estado` = $paramestado  ) ";
}
}
else {
$where1.="AND ( b.`pais` = $parampais  ) ";
}
}

//=========== Consulta de atributo condicionado a un valor(ej. cementeras)  en  entidades asociadas (empresas) por enlace (trayectoria)
if($industria=="")
{
}else
{
$from1.= ", (SELECT * FROM (SELECT id, child_document_id as empre, parent_document_id as indi FROM documents";
$from1 .= " WHERE status_id <=2";
$from1.= " AND document_type_id =4 ";
$from1.= " ) AS enla ";

$from1.= " ,(SELECT document_id, value";
$from1.= " FROM document_fields_link";
$from1.= " WHERE document_field_id =76";
$from1.= " ) AS indust ";
$from1.= " where enla.empre = indust.document_id";

$from1.=" UNION";

$from1.=" SELECT * ";
$from1.=" FROM ";
$from1.=" (SELECT id, parent_document_id as empre, child_document_id as indi ";
$from1.=" FROM documents ";
$from1.=" WHERE status_id <=2 ";
$from1.=" AND document_type_id =4 ";
$from1.=" ) AS enla2, ";
$from1.=" (SELECT document_id, value ";
$from1.=" FROM document_fields_link ";
$from1.=" WHERE document_field_id =76 ";
$from1.=" ) AS indust2 ";
$from1.=" where enla2.empre = indust2.document_id ) as inind ";

$where1.=" and inind.value = '".$industria."' and inind.indi = b.id ";




//****16 abril 214

//$where1.="AND ( b.`id` = forganizacion.`child_document_id` )";
}


//====================== Empresa

$oplog=($fechaA=="" && $fechaP=="" && $nombre =="" && $nota=="" && $persona=="");
$oplog=($oplog &&( $parampais=="0" or $parampais=="") && $paramestado=="" && $paramciudad=="" && $organizacion=="");
$oplog=($oplog && $reltop=="" && $reltoph =="" &&$subindustry =="");
$oplog=($oplog && $apellidop =="" &&  $apellidom ==""  && $industria=="");
if($oplog)
{
//echo $oplog;
//$where1.="AND b.modified > (CURDATE()-INTERVAL 1 MONTH) ";
$where1.="AND b.modified > (CURDATE()-INTERVAL 1 DAY) ";
}else
{
//$boolano=1;
//$from1.=",`document_fields_link` as ffechaa ";
//$where1.="AND b.modified = CURDATE() ";
}






   echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n"; 

echo "<LEFT><a href='/FichasBD/branches/SY/control.php?action=getleb2bcsv";

if ($letra) echo "&letra=".$letra;
if ($nota) echo "&nota=".$nota;
if ($region) echo "&region=".$region;
if ($event) echo "&event=".$event;
if ($action) echo "&action=".$action;
if ($type) echo "&type=".$type;
if ($competitive) echo "&competitive=".$competitive;
if ($sustainability) echo "&sustainability=".$sustainability;
if ($reactiontype) echo "&reactiontype=".$reactiontype;
if ($reactiontopic) echo "&reactiontopic=".$reactiontopic;
if ($consequence) echo "&consequence=".$consequence;
if ($actor) echo "&actor=".$actor;
if ($competidor) echo "&competidor=".$competidor;
if ($ano) echo "&ano=".$ano;
if ($fechaA) echo "&fecha1=".$fechaA;
if ($fechaP) echo "&fecha2=".$fechaP;

echo "' target='blank' ><font size=2 face='Times'>CSV</font></a></LEFT>&nbsp;";
echo "<LEFT><a href='/FichasBD/branches/SY/control.php?action=getleb2bcsv2";

if ($letra) echo "&letra=".$letra;
if ($nota) echo "&nota=".$nota;
if ($region) echo "&region=".$region;
if ($event) echo "&event=".$event;
if ($action) echo "&action=".$action;
if ($type) echo "&type=".$type;
if ($competitive) echo "&competitive=".$competitive;
if ($sustainability) echo "&sustainability=".$sustainability;
if ($reactiontype) echo "&reactiontype=".$reactiontype;
if ($reactiontopic) echo "&reactiontopic=".$reactiontopic;
if ($consequence) echo "&consequence=".$consequence;
if ($actor) echo "&actor=".$actor;
if ($competidor) echo "&competidor=".$competidor;
if ($ano) echo "&ano=".$ano;
if ($fechaA) echo "&fecha1=".$fechaA;
if ($fechaP) echo "&fecha2=".$fechaP;

echo "' target='blank' ><font size=2 face='Times'>CSV2</font></a></LEFT>";

// quitar modificador de  curdate.... ajustar para cuando no haya parametros

$cuentasql="SELECT distinct count(*) FROM (select id,modified,lugar,estado,pais from `documents` where `document_type_id`=18  AND `status_id`<=2) as b ".$from1." WHERE 1 ".$where1;

//echo $cuentasql;
$cuentaexec = mysql_query($cuentasql);
$cuentafetch=mysql_fetch_row($cuentaexec);
echo "<center><font size=1 face='Times'>".$cuentafetch[0]." Registros Encontrados</font></center><br>";
if ($apartir) {$limite=" LIMIT ".$apartir.",30 ";} else {$limite=" LIMIT 0,30 ";}
$indicecuenta=0;
echo "<center><font size=1 face='Times'>";
while ($indicecuenta<$cuentafetch[0]) 
{
$ligaconcuenta= ($indicecuenta+1)."-";

echo "<a target=\"fichaslist\" href='/FichasBD/branches/SY/control.php?action=getleindiv";

if ($letra) echo "&letra=".$letra;
if ($nota) echo "&nota=".$nota;
if ($region) echo "&region=".$region;
if ($event) echo "&event=".$event;
if ($action) echo "&action=".$action;
if ($type) echo "&type=".$type;
if ($competitive) echo "&competitive=".$competitive;
if ($sustainability) echo "&sustainability=".$sustainability;
if ($reactiontype) echo "&reactiontype=".$reactiontype;
if ($reactiontopic) echo "&reactiontopic=".$reactiontopic;
if ($consequence) echo "&consequence=".$consequence;
if ($actor) echo "&actor=".$actor;
if ($competidor) echo "&competidor=".$competidor;
if ($ano) echo "&ano=".$ano;
if ($fechaA) echo "&fecha1=".$fechaA;
if ($fechaP) echo "&fecha2=".$fechaP;
echo "&apartir=".($indicecuenta+1);
$indicecuenta+=30;
$ligaconcuenta.= $indicecuenta."\t";
echo "' target='blank' >".$ligaconcuenta."</font></a>";




//echo $ligaconcuenta;
}
echo "</font></center>";
   
 echo "<table style='text-align: left; width:90% ; ' border='0'  cellpadding='2' cellspacing='2'><tbody>


<tr>
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='3' cellspacing='1'><font size=1 face='Times'><tbody>
<tr>
<th align='center'><font size=1 face='Arial'>Name</font></th>
<th align='center'><font size=1 face='Arial'>Last Name</font></th>
<th align='center'><font size=1 face='Arial'>Mothers Last Name</font></th>
<th align='center'><font size=1 face='Arial'>Birthdate</font></th>
<th align='center'><font size=1 face='Arial'>Gender</font></th>
<th align='center'><font size=1 face='Arial'>E-Mail</font></th>
<th align='center'><font size=1 face='Arial'>Phone Number</font></th>
<th align='center'><font size=1 face='Arial'>Citizenship</font></th>
<th align='center'><font size=1 face='Arial'>R. Individual(s)</font></th>
<th align='center'><font size=1 face='Arial'>Institute</font></th>
</tr>";
$insmod=0;
   //for($i=0; $i<count($letrasar)-1;$i++){

$busq_links="SELECT distinct b.`id` FROM (select id,modified,lugar,estado,pais from `documents` where `document_type_id`=18  AND `status_id`<=2) as b ".$from1." WHERE 1 ".$where1.$limite;

//abajo previo a insercion de selects
// $busq_links="SELECT distinct a.`document_id` FROM `document_fields_link`as a,`documents`as b ".$from1." WHERE b.`id`= a.`document_id` AND b.`document_type_id`=38 AND b.`status_id`<=2 ".$where1;

//$busq_links="SELECT a.`document_id` FROM `document_fields_link`as a,`documents`as b  WHERE a.`document_field_id`=109 AND b.`id`= a.`document_id`AND b.`status_id`<=2 AND b.`document_type_id`= 38  AND  a.`value` like '". $valor."%'";
$busq_links1 = mysql_query($busq_links);
//$busq_links2 = mysql_fetch_row($busq_links1);
//echo $busq_links;


 while ($busq_links2 = mysql_fetch_row($busq_links1))
{
 $insmod++; 
  $modd=$insmod%2;
  $red=220*$modd-255*($modd-1);
  $green=220*$modd-255*($modd-1);
  $blue=220*$modd-255*($modd-1);
$oDocument = & Document::get($busq_links2[0]);

 

 
//echo "<tr style='background-color: rgb($red, $green,$blue);'><td valign='top' height=40% align='left'>";
 
 
echo "<tr style='background-color: rgb($red, $green,$blue);'><td width=50>";
 

// Dos pasos arriba se saca el id , aqui abajo todos sus campos

$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$busq_links2[0];
$indv_rel1 = mysql_query($indv_rel);

//$indv_rel2 = mysql_fetch_row($indv_rel1);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 

  if ($indv_rel2[2]==8 ){
   $nom=$indv_rel2[3];

}
 if ($indv_rel2[2]==21 ){
   $appat=$indv_rel2[3];

}
 if ($indv_rel2[2]==22 ){
   $apmat=$indv_rel2[3];

}
 if ($indv_rel2[2]==23 ){
   $birth=$indv_rel2[3];

} 
if ($indv_rel2[2]==69 ){
   $gender=$indv_rel2[3];

} 
if ($indv_rel2[2]==58 ){
   $email=$indv_rel2[3];

} 
if ($indv_rel2[2]==57 ){
   $phone=$indv_rel2[3];

} 
if ($indv_rel2[2]==54 ){
   $citizen=$indv_rel2[3];

}
 if ($indv_rel2[2]==161) {
    $lugar=$indv_rel2[3];
if ($lugar>0){
$one="SELECT A.`dos` FROM `Lugares`.`Pais` as A , `Lugares`.`Lugares` as B WHERE A.id = B.cinco and B.id=".$lugar;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnom=$three[0];
}
else {$partnom="";}
    
}
 if ($indv_rel2[2]==109 ){
   $fech=$indv_rel2[3];

}
 if ($indv_rel2[2]==142){
   $competidor=$indv_rel2[3];
if ($competidor>0){
$one="SELECT `name` FROM `documents`  WHERE  id=".$competidor;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnomcompM=explode("_",$three[0]);
$partnomcomp=$partnomcompM[1];
}
else {$partnomcomp="";}

}
 if ($indv_rel2[2]==136 ){
    $compdyn=$indv_rel2[3];
if ($compdyn=="Yes" or $compdyn=="YES"){
 $pncd="Competitive Dynamic";}
else {
 $pncd="";}

}
if ($indv_rel2[2]==137 ){
    $tech=$indv_rel2[3];
    if ($tech=="Yes"  or $tech=="YES"){
    $pnt="Technology";}
else{
    $pnt="";}

}
 if ($indv_rel2[2]==138 ){
    $corp=$indv_rel2[3];
if ($corp=="Yes"  or $corp=="YES"){
 $pncrp="Corporate";}
else {  $pncrp="";}

}
if ($indv_rel2[2]==139){
    $sust=$indv_rel2[3];
    if ($sust=="Yes"  or $sust=="YES"){
      $pnsust="Sustainability";}
else {
      $pnsust="";}
}

if ($indv_rel2[2]==186){
    $react=$indv_rel2[3];
    if ($react=="Yes"  or $react=="YES"){
      $pnreact="Reactions";}
else {
      $pnreact="";}
}

if ($indv_rel2[2]==121){
    $react_actor=$indv_rel2[3];
}


// Ifs Columna 5

 if ($indv_rel2[2]==186){
    $react=$indv_rel2[3];
    if ($react=="Yes"  or $react=="YES"){
      $col5react="React.";}
    else {
      $col5react="";}}

 if ($indv_rel2[2]==183){
    $oppo=$indv_rel2[3];
    if ($oppo=="Yes"  or $oppo=="YES"){
      $col5oppo="Opp.";}
else {
      $col5oppo="";}}

 if ($indv_rel2[2]==139){
    $susta=$indv_rel2[3];
    if ($susta=="Yes"  or $susta=="YES"){
      $col5susta="Sust.";}
else {
      $col5susta="";}}

if ($indv_rel2[2]==136){
    $compe=$indv_rel2[3];
    if ($compe=="Yes"  or $compe=="YES"){
      $col5compe="CD.";}
else {
      $col5compe="";}}

if ($indv_rel2[2]==137){
    $techn=$indv_rel2[3];
    if ($techn=="Yes"  or $techn =="YES"){
      $col5techn="Tech.";}
else {
      $col5techn="";}}



if ($indv_rel2[2]==118){
    $rectyp=$indv_rel2[3];
   }

if ($indv_rel2[2]==127){
    $cdact=$indv_rel2[3];
   }

if ($indv_rel2[2]==122){
    $sustact=$indv_rel2[3];
   }

if ($indv_rel2[2]==125){
    $technact=$indv_rel2[3];
   }

if ($indv_rel2[2]==184){
    $oppoact=$indv_rel2[3];
   }







//Ifs Column 6

 if ($indv_rel2[2]==138){
    $corpo=$indv_rel2[3];
    if ($corpo=="Yes"  or $corpo=="YES"){
      $col6corpo="Corp.";}
    else {
      $col6corpo="";}}

if ($indv_rel2[2]==119){
    $reactop=$indv_rel2[3];
   }

if ($indv_rel2[2]==116){
    $compdinsec=$indv_rel2[3];
   }

if ($indv_rel2[2]==124){
    $sustheme=$indv_rel2[3];
   }

if ($indv_rel2[2]==126){
    $techtyp=$indv_rel2[3];
   }


if ($indv_rel2[2]==155){
    $typcorpev=$indv_rel2[3];
   }


if ($indv_rel2[2]==185){
    $opptyp=$indv_rel2[3];
   }




// Ifs Column7

 if ($indv_rel2[2]==117){
    $compdynsp=$indv_rel2[3];
    }
 
 if ($indv_rel2[2]==120){
    $reactcon=$indv_rel2[3];
    }

if ($indv_rel2[2]==163){
    $techndesc=$indv_rel2[3];
    }

 
// Columna8 

 if ($indv_rel2[2]==121){
    $reactact=$indv_rel2[3];
    }

}

 //echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='blank' ><font size=2 face='Times'>".$fech."1 ".$partnom."2 ".$partnomcomp."3 ".$pncd."4 ".$pnt."5 ".$pncrp."6 ".$pnsust."7</font></a>";

//====>>> NOMBRE
echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Arial'> ".$nom." </font></a></td>";

//====>>> APELLIDO PATERNO
echo "<td align='center'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Arial'> ".$appat." </font></a></td>";

//====>>> APELLIDO MATERNO
 echo "<td align='center'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Arial'>".$apmat."</font></a></td>";

//====>>> FECHA DE NACIMIENTO 
 echo "<td align='center'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Arial'>".$birth."</font></a></td>";

//====>>> GENDER
 echo "<td align='center'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Arial'>".$gender."</font></a></td>";

//====>>> E-MAIL
 echo "<td align='center'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Arial'>".$email."</font></a></td>";

//====>>> PHONE NUMBER
 echo "<td align='center'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Arial'>".$phone."</font></a></td>";

//====>>> CITIZENSHIP
 echo "<td align='center'><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Arial'>".$citizen."</font></a></td>";

// Competidor
 echo "<td><a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$competidor."' target='_blank' ><font size=1 face='Times'>".$partnomcomp."</font></a></td>";

// aqui va el if y se pone una tabla siempre que haya mas de un tipo  puesto
$sumadecondiciones=($pncd!="")+($pnt!="")+($pncrp!="")+($pnsust!="")+($pnreact!="");
//if $sumadecondiciones >1

// Event type

if($sumadecondiciones>1)
{
  echo "<td>";
 if ($pncd != "") echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'> ".$pncd."</font></a>"; //Competitive Dynamic
if (($pncd!="") && ($pnt!="")) $pnt = "/".$pnt;
 
if ($pnt!="") echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$pnt."</font></a>"; //Technology

if ((($pncd!="") || ($pnt!="")) && ($pncrp!=""))  $pncrp = "/".$pncrp;

if ($pncrp!="")  echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$pncrp."</font></a>"; //Corporate
if ((($pncd!="") || ($pnt!="") || ($pncrp!="")) && ($pnreact!=""))  $pnreact = "/".$pnreact;
if ($pnreact!="") echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$pnreact."</font></a>"; //Reactions

if ((($pncd!="") || ($pnt!="") || ($pncrp!="")) && ($pnsust!="") ) $pnsust = "/".$pnsust;

 if ($pnsust!="") echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$pnsust."</font></a>";
echo "</td>"; //Sustainability

}
else
{

//echo table tbody
if ($pncd != "") echo "<td><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'> ".$pncd."</font></a></td>"; //Competitive Dynamic
if ($pnt!="") echo "<td><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$pnt."</font></a></td>"; //Technology
 if ($pncrp!="") echo "<td><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$pncrp."</font></a></td>"; //Corporate
if ($pnreact!="") echo "<td><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$pnreact."</font></a></td>"; //Reactions
 if ($pnsust!="") echo "<td><a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$pnsust."</font></a></td>"; //Sustainability

if ($sumadecondiciones==0) echo "<td></td>";

}







// poner columna de opportunities y reactions

//acaba el if

// Columna 5 

/**
echo "<td>";

if ($rectyp!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5react.$rectyp." &nbsp;</font></a>";

}

if ($cdact!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5compe.$cdact."  &nbsp</font></a>";

}

if ($sustact!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5susta.$sustact."  &nbsp</font></a>";

}

if ($technact!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5techn.$technact."  &nbsp</font></a>";

}

echo "</td>";
*/

//col 6
/**
echo "<td>";

if ($reactop!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5react.$reactop." &nbsp;</font></a>";

}

if ($compdinsec!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5compe.$compdinsec."  &nbsp</font></a>";

}

if ($sustheme!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5susta.$sustheme."  &nbsp</font></a>";

}

if ($typeS!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5susta.$typeS."  &nbsp</font></a>";

}

if ($techtyp!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5techn.$techtyp."  &nbsp</font></a>";

}

if ($typcorpev!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col6corpo.$typcorpev."  &nbsp</font></a>";

}
if ($opptyp!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5oppo.$opptyp."  &nbsp</font></a>";

}
*/

//col 7
/**
echo "<td>";

if ($compdynsp!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5compe.$compdynsp." &nbsp;</font></a>";

}

if ($reactcon!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5react.$reactcon."  &nbsp</font></a>";

}

if ($techndesc!=""){
 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$col5techn.$techndesc."  &nbsp</font></a>";

}


echo "</td>";
*/
//col 8

/**
echo "<td>";


 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$busq_links2[0]."' target='_blank' ><font size=1 face='Times'>".$reactact." &nbsp;</font></a>";

echo "</td>";
*/
// Col 9 Indiv Relacionados
/**
$result3= mysql_query("select id,parent_document_id, child_document_id from documents where (parent_document_id= $busq_links2[0] or child_document_id = $busq_links2[0]) and status_id <=2 and document_type_id=43");

$indice=0;

echo "<td>";
while($row3 =  mysql_fetch_row($result3))
{


if ($row3[1]==$busq_links2[0]){$indivrel_id=$row3[2];}
else {$indivrel_id=$row3[1];}

$indiv0="SELECT value FROM document_fields_link WHERE `document_field_id` = 8 AND `document_id`= ".$indivrel_id;
$indiv1=mysql_query($indiv0);
$nom=mysql_fetch_row($indiv1);

$indiv0="SELECT value FROM document_fields_link WHERE `document_field_id` = 21 AND `document_id`= ".$indivrel_id;
$indiv1=mysql_query($indiv0);
$appat=mysql_fetch_row($indiv1);

$indiv0="SELECT value FROM document_fields_link WHERE `document_field_id` = 22 AND `document_id`= ".$indivrel_id;
$indiv1=mysql_query($indiv0);
$apmat=mysql_fetch_row($indiv1);



if ($indice>=1){
echo "/<br>";
}

 echo "<a href='/FichasBD/branches/SY/control.php?action=getficha&letra=".$indivrel_id."' target='_blank' ><font size=1 face='Times'>".$appat[0]." ".$apmat[0]." ".$nom[0]." &nbsp;</font></a>";

$indice++;

} 

echo "</td>";
*/

//Col 10
/**
$result3= mysql_query("select id, parent_document_id, child_document_id from documents where (parent_document_id= $busq_links2[0] or child_document_id = $busq_links2[0]) and status_id <=2 and document_type_id=41");


$indicemp=0;
$row3="";
echo "<td>";
while($row3 =  mysql_fetch_row($result3))
{


if ($row3[1]==$busq_links2[0]){$emprel_id=$row3[2];}
else {$emprel_id=$row3[1];}

$emp0="SELECT value FROM document_fields_link WHERE `document_field_id` = 92 AND `document_id`= ".$emprel_id;
$emp1=mysql_query($emp0);
$raz=mysql_fetch_row($emp1);

if ($indicemp>=1){
echo "/<br>";
}

 echo "<a href='/FichasBD/branches/SY/control.php?action=getfinst&letra=".$emprel_id."' target='_blank' ><font size=1 face='Times'>".$raz[0]." &nbsp;</font></a>";

$indicemp++;

} 

echo "</td>";

*/

// if boolnota
// echo con pedazo de nota

//uyuy
}

//} del for
echo "</td></tr></table></table>";

// Funcion Checaciclo
 
function checaciclo($indice,$lista,$nodo,$padre)
{
$regreso=0;

if ($indice>=1 or count($padre)>1)
 {
  for($a=0;$a<=count($padre);$a++)
  {
   if ($padre[$a]==$nodo){$regreso=1;}

   }
 for($a=1;$a<=$indice;$a++)
  {
   if ($lista[$a]['id']==$nodo){$regreso=1;}

   }
  }
return $regreso;
}

/// Funcion Ascendencia
 
function ascendencia($pfName, $nivel, &$cerradura,&$consecutivo,&$maxnivel,$extra, $fecha_org,$quien) {
	global $default;


if (checaciclo($consecutivo,$cerradura,$pfName,$quien))
    {
     // poner datos y return
               $razonsocial1= "SELECT value  FROM `document_fields_link`"
               ." WHERE `document_field_id`= 92  AND `document_id`=".$pfName;
               $razonsocial11 = mysql_query($razonsocial1);
               $razonsocial21=mysql_fetch_row($razonsocial11);
               $consecutivo++;
               $cerradura[$consecutivo]['id']=$pfName;
               $cerradura[$consecutivo]['nivel']=$nivel;
               $cerradura[$consecutivo]['nombre']=$razonsocial21[0].$extra;
               if ($nivel > $maxnivel){$maxnivel=$nivel;}
               return $cerradura;

    } else {

 if ($fecha_org != "") {$extension=" and fecha < ".$fecha_org;}
$ONE = "INSERT INTO `sidem_dev141008`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('$pfName', '100309 entre pfname". $pfName." ', 'ea', NULL);"; 
$TWO = mysql_query($ONE);
//obtenpap(n)
  
$oneeva='(SELECT * FROM `empresa_empresa` where child_id = '. $pfName  .' and matriz = \'yes\' '.$extension.' )'
       .'Union'
       .'(SELECT * FROM `empresa_empresa` where parent_id = '. $pfName  .' and matriz = \'no\'  '.$extension.' )'
       .'order by fecha desc, jv desc';
$twoeva=mysql_query($oneeva);




// si hay papas

if ($threeva=mysql_fetch_row($twoeva))
{

//$ONE = "INSERT INTO `sidem_dev141008`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('$pfName', '200409 threeva:". $threeva[0]." ".$threeva[6]." ', 'ea', NULL);"; 
//$TWO = mysql_query($ONE);
// si jv llamar ascendencia de cada participante
if ($threeva[6]=='Yes'){
             $i=0;
            $fecha_primer_jv=$threeva[7];
            // si el nodo dado corresponde al child 
            // ( ya esta validado qu son registros del padre del nodo ) 
            // --> parent es el padre de otra forma 
            if ($pfName==$threeva[2]){$jv[$i]=$threeva[1];} 
            else {$jv[$i]=$threeva[2];}
            $i++;
            while ($jointventure = mysql_fetch_row($twoeva) )
            {
               if ($fecha_primer_jv==$jointventure[7]  && $jointventure[6]=='Yes' ){
                if ($pfName==$jointventure[2]){$jv[$i]=$jointventure[1];}
                else {$jv[$i]=$jointventure[2];}
                $i++;
               } 
               else break;
      
            }
           //$storender="";
           for($j=0;$j<$i;$j++){
               
               $quien[$nivel]=$pfName;
               $storender=ascendencia($jv[$j],$nivel+1,$cerradura,$consecutivo,$maxnivel," <font size=1 face='Times'>en Joint Venture ($nivel)</font>",$fecha_org,$quien); }
               $razonsocial1= "SELECT value  FROM `document_fields_link`"
               ." WHERE `document_field_id`= 92  AND `document_id`=".$pfName;
               $razonsocial11 = mysql_query($razonsocial1);
               $razonsocial21=mysql_fetch_row($razonsocial11);
               $consecutivo++;
               $cerradura[$consecutivo]['id']=$pfName;
               $cerradura[$consecutivo]['nivel']=$nivel;
               $cerradura[$consecutivo]['nombre']=$razonsocial21[0].$extra;
               if ($nivel > $maxnivel){$maxnivel=$nivel;}
 }

//solo 1 matriz
 else if ($threeva[6]=='No' || $threeva[6]= '' || $threeva[6] == NULL  ){
           if ($pfName==$threeva[2]){$nodo=$threeva[1];} 
            else {$nodo=$threeva[2];}
 $quien[$nivel]=$pfName;
            $storender=ascendencia($nodo,$nivel+1,$cerradura,$consecutivo,$maxnivel,"",$fecha_org,$quien);
   $razonsocial0= "SELECT value  FROM `document_fields_link`"
           ." WHERE `document_field_id`= 92  AND `document_id`=".$pfName;
   $razonsocial10 = mysql_query($razonsocial0);
   $razonsocial20=mysql_fetch_row($razonsocial10);
 $consecutivo++;
               $cerradura[$consecutivo]['id']=$pfName;
               $cerradura[$consecutivo]['nivel']=$nivel;
               $cerradura[$consecutivo]['nombre']=$razonsocial20[0].$extra;
               if ($nivel>$maxnivel){$maxnivel=$nivel;}
           

}
//llamada recursiva
} else  { 

$razonsocial= "SELECT value  FROM `document_fields_link`"
           ." WHERE `document_field_id`= 92  AND `document_id`=".$pfName;
$razonsocial1 = mysql_query($razonsocial);
$razonsocial2=mysql_fetch_row($razonsocial1);
 $consecutivo++;
               $cerradura[$consecutivo]['id']=$pfName;
               $cerradura[$consecutivo]['nivel']=$nivel;
               $cerradura[$consecutivo]['nombre']=$razonsocial2[0].$extra;
               if ($nivel>$maxnivel){$maxnivel=$nivel;}
 }          
//regresa papas
return $cerradura;
} // else de checaciclo

}   //Funcion Ascendencia

//****************************
 
function checahijo($pfName, $supuesto, &$padresjv, $fecha_org) {
	global $default;

$valorfuncion=0;

if ($fecha_org != "") {$extension=" and fecha < ".$fecha_org;}
  
$oneeva='(SELECT * FROM `empresa_empresa` where child_id = '. $pfName  .' and matriz = \'yes\' '.$extension.' )'
       .'Union'
       .'(SELECT * FROM `empresa_empresa` where parent_id = '. $pfName  .' and matriz = \'no\'  '.$extension.' )'
       .'order by fecha desc, jv desc';
$twoeva=mysql_query($oneeva);




if ($threeva=mysql_fetch_row($twoeva))
{
if ($threeva[6]=='Yes'){
             $i=0;
            $fecha_primer_jv=$threeva[7];
            if ($pfName==$threeva[2]){$jv[$i]=$threeva[1];} 
            else {$jv[$i]=$threeva[2];}
            if ($supuesto==$threeva[2] or $supuesto==$threeva[1]){$valorfuncion=1;}
            else {$padresjv.=$jv[$i];}
             $i++;
            while ($jointventure = mysql_fetch_row($twoeva) )
            {

  if ($fecha_primer_jv==$jointventure[7]  && $jointventure[6]=='Yes' ){
                if ($pfName==$jointventure[2]){$jv[$i]=$jointventure[1];}
                else {$jv[$i]=$jointventure[2];}
 if ($supuesto==$jointventure[2] or $supuesto==$jointventure[1]){$valorfuncion=1;}
            else{$padresjv.=$jv[$i];}
                $i++;
               } 
               else break;
      
            }
 }
 else if ($threeva[6]=='No' || $threeva[6]= '' || $threeva[6] == NULL  ){
           if ($pfName==$threeva[2]){$nodo=$threeva[1];} 
            else {$nodo=$threeva[2];}
           if ($supuesto==$threeva[2] or $supuesto==$threeva[1]){$valorfuncion=1;}
            else{$padresjv.=$jv[$i];}
        
}
} 


return $valorfuncion;


} //Funcion Checa Hijo



//********************************

 
function descendencia($pfName,&$hijoslegit,&$consecutivo,$nivel,&$maxnivel,$extra,$fecha_org,$quien) {
	global $default;

//sacar todos los hijos en array de hijos

if (checaciclo($consecutivo,$hijoslegit,$pfName,$quien))
    {
     // poner datos y return
                return $hijoslegit;

    } else {




if ($fecha_org != "") {$extension=" and fecha < ".$fecha_org;}
//$ONE = "INSERT INTO `sidem_dev141008`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('$pfName', '100309 entre pfname". $pfName." ', 'ea', NULL);"; 
//$TWO = mysql_query($ONE);

$oneeva='(SELECT * FROM `empresa_empresa` where child_id = '. $pfName  .' and matriz = \'no\' '.$extension.' )'
       .'Union'
       .'(SELECT * FROM `empresa_empresa` where parent_id = '. $pfName  .' and matriz = \'yes\'  '.$extension.' )'
       .'order by fecha desc, jv desc';
$twoeva=mysql_query($oneeva);

     while ($hijos = mysql_fetch_row($twoeva) )
            {
  if ($pfName==$hijos[2]){$hijo=$hijos[1];}
            else {$hijo.=$hijos[2];}
$padresjv="";
 if (checahijo($hijo,$pfName,$padresjv,$fecha_org))
     { 
               $razonsocial1= "SELECT value  FROM `document_fields_link`"
                              ." WHERE `document_field_id`= 92  AND `document_id`=".$hijo;
               $razonsocial11 = mysql_query($razonsocial1);
               $razonsocial21 =  mysql_fetch_row($razonsocial11);
               $consecutivo++;
               $hijoslegit[$consecutivo]['id']=$hijo;
               $hijoslegit[$consecutivo]['nivel']=$nivel;
               $hijoslegit[$consecutivo]['nombre']=$razonsocial21[0].$extra;
               if ($nivel > $maxnivel){$maxnivel=$nivel;}
         //pon datos
        //llamada recursiva
               $storender=descendencia($hijo,$hijoslegit,$consecutivo,$nivel+1,$maxnivel,$extra,$fecha_org,$pfName);
     }

             }

return $hijoslegit;
} // del else de checaciclo
} //Funcion Descendencia





function jerarquizadas($idarelacionar)
{
$cerradura="";
$nivel=0;
$maxnivel=0;
$fecha_org="'2010-03-22'";
$espacio="";
$consecutivo=0;
 $quien[$nivel]=$iddoc;
$miarreglo = ascendencia($idarelacionar,$nivel,$cerradura,$consecutivo,$maxnivel," Nodo origen",$fecha_org,$quien);

$maxnivel2=0;
$fecha_org2="'2010-03-22'";
$espacio2="";
$hijoslegit2="";
$consecutivo2=0;
$miarreglo2 = descendencia($idarelacionar,$hijoslegit2,$consecutivo2,$nivel2, $maxnivel2,"*",$fecha_org2,0);

for($a=$consecutivo+1;$a<=$consecutivo+$consecutivo2;$a++)
{


$ONE = "INSERT INTO `sidem_dev141008`.`debugg` (`llave`, `uno`, `dos`, `tres`) VALUES ('linea935 getleb', ' a:". $a." consecutivo".$consecutivo." consecutivo2".$consecutivo2." ', 'ea', NULL);"; 
$TWO = mysql_query($ONE);

$miarreglo[$a]=$miarreglo2[$a-$consecutivo];
}
return $miarreglo;
}  //Funcion


} //1
?>
