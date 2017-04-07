<?php

require_once("../../../../config/dmsDefaults.php");


if (checkSession()) {  //1

require_once("../../../../lib/util/sanitize.inc");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");

$letra = $_GET["letra"];
$nota = $_GET["nota"];
$region = $_GET["region"];
$event = $_GET["event"];
$action = $_GET["action"];
$type = $_GET["type"];
$competitive = $_GET["competitive"];
$sustainability = $_GET["sustainability"];
$reactiontype = $_GET["reactiontype"];
$reactiontopic = $_GET["reactiontopic"];
$consequence = $_GET["consequence"];
$actor = $_GET["actor"];
$where1 = "";
$from1="";
 $letram=strtoupper($letra);
   $letrasar= explode("_",$letram);


if($nota=="")
{//echo "no paterno<br>";
}else
{
$from1.=",`document_fields_link` as fnota ";
$where1.="AND ( fnota.document_field_id=114 AND fnota.value LIKE '%$nota%'  AND a.`document_id` = fnota.`document_id` )";
}

if($region=="")
{//echo "no region<br>";
}else
{

$from1.=",`document_fields_link` as fregion ";
$where1.="AND ( fregion.document_field_id=110 AND fregion.value='".$region."' AND a.`document_id` = fregion.`document_id` )";
}

if($event=="")
{//echo "no event<br>";
}else
{

$from1.=",`document_fields_link` as fevent ";

if ($event=="Competitive Dynamic")
{
$where1.="AND ( fevent.document_field_id=136 AND fevent.value='Yes' AND a.`document_id` = fevent.`document_id` )";
} else if ($event=="Technology")
{
$where1.="AND ( fevent.document_field_id=137 AND fevent.value='Yes' AND a.`document_id` = fevent.`document_id` )";
} else if ($event=="Sustainablility")
{
$where1.="AND ( fevent.document_field_id=139 AND fevent.value='Yes' AND a.`document_id` = fevent.`document_id` )";
} else if ($event=="Opportunities")
{
$where1.="AND ( fevent.document_field_id=183 AND fevent.value='Yes' AND a.`document_id` = fevent.`document_id` )";
} else if ($event=="Corporate")
{
$where1.="AND ( fevent.document_field_id=138 AND fevent.value='Yes' AND a.`document_id` = fevent.`document_id` )";
} else if ($event=="Reactions")
{
$where1.="AND ( fevent.document_field_id=186 AND fevent.value='Yes' AND a.`document_id` = fevent.`document_id` )";
}

}


if($action=="")
{//echo "no action<br>";
}else
{

$from1.=",`document_fields_link` as faction ";

if ($event=="New Company")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
} else if ($action=="Acquisitions")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
} else if ($action=="Expansions")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
} else if ($action=="Mergers")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
} else if ($action=="Upgrades")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
} else if ($action=="JV")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
} else if ($action=="Alternative Fuels Project")
{
$where1.="AND ( faction.document_field_id=125 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
} else if ($action=="New Material / Processes")
{
$where1.="AND ( faction.document_field_id=125 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
}else if ($action=="Projects / Loans")
{
$where1.="AND ( faction.document_field_id=122 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
}
else if ($action=="Organization of Forums & Events")
{
$where1.="AND ( faction.document_field_id=122 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
}
else if ($action=="Attendance to Forums & Events")
{
$where1.="AND ( faction.document_field_id=122 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
}
else if ($action=="Awards delivered")
{
$where1.="AND ( faction.document_field_id=122 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
}
else if ($action=="Document Publishing")
{
$where1.="AND ( faction.document_field_id=122 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
}
else if ($action=="Foundation/Cofoundation of organisms")
{
$where1.="AND ( faction.document_field_id=184 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
}else if ($action=="Cost Reduction")
{
$where1.="AND ( faction.document_field_id=184 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
}else if ($action=="Capital Finance Raise")
{
$where1.="AND ( faction.document_field_id=184 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
}else if ($action=="Increase Prices")
{
$where1.="AND ( faction.document_field_id=184 AND faction.value='".$event."' AND a.`document_id` = faction.`document_id` )";
}else if ($action=="Volume Raise")
{
$where1.="AND ( faction.document_field_id=116 AND faction.value='".$type."' AND a.`document_id` = faction.`document_id` )";
}

if($type=="")
{//echo "no action<br>";
}else
{

$from1.=",`document_fields_link` as ftype ";

 if ($type=="Cement")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Concrete")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Aggregates")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Other")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}

else if ($type=="Quarries")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Sea Terminal")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Distribution Center")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="R&D Center")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Non Core Related")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="AF. TDF(Tires)")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="AF Bio-Mass")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="AF. Indistrial Wastes")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="AF. Municipal Waste")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="NP. Low resource consumption")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="NP. Recyclers")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="NP. Low polluters / Env Quality Enchancers")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Training/ Education ")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Business Incubator")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Redeployment on closure")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Infraestructure Development")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Housing")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Natural Disaster Aid")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Historical Monuments Protector")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Safety promotion")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Labor Equity/Human Rights")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Sponsor of Cultural-Sport Activities")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Stakeholders/Community Involvement")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Biodiversity and Quarry Rehabilitation")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Protecting Air Quality and Mitigating Disturbances")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Water Protection")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Reccycling Industrial by products and wastes")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
else if ($type=="Energy Recovery (Electricity)")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND a.`document_id` = ftype.`document_id` )";
}
}
//===========================

if($competitive=="")
{//echo "no action<br>";
}else
{

$from1.=",`document_fields_link` as faction ";


if ($competitive=="Plan")
{
$where1.="AND ( fcompetitive.document_field_id=117 AND fcompetitive.value='".$competitive."' AND a.`document_id` = fcompetitive.`document_id` )";
}
else if ($competitive=="In Process")
{
$where1.="AND ( fcompetitive.document_field_id=117 AND fcompetitive.value='".$competitive."' AND a.`document_id` = fcompetitive.`document_id` )";
}
else if ($competitive=="Completed")
{
$where1.="AND ( fcompetitive.document_field_id=117 AND fcompetitive.value='".$competitive."' AND a.`document_id` = fcompetitive.`document_id` )";
}
}
//======================
if($sustainability=="")
{//echo "no action<br>";
}else
{

$from1.=",`document_fields_link` as fsustainability ";
if ($sustainability=="Economic")
{
$where1.="AND ( fsustainability.document_field_id=124 AND fsustainability.value='".$sustainability."' AND a.`document_id` = fsustainability.`document_id` )";
}
else if ($sustainability=="Social")
{
$where1.="AND ( fsustainability.document_field_id=124 AND fsustainability.value='".$sustainability."' AND a.`document_id` = fsustainability.`document_id` )";
}
else if ($sustainability=="Enviroment")
{
$where1.="AND ( fsustainability.document_field_id=124 AND fsustainability.value='".$sustainability."' AND a.`document_id` = fsustainability.`document_id` )";
}
else if ($sustainability=="Sustainable")
{
$where1.="AND ( fsustainability.document_field_id=124 AND fsustainability.value='".$sustainability."' AND a.`document_id` = fsustainability.`document_id` )";
}
}
//================

if($reactiontype=="")
{//echo "no reactiontype<br>";
}else
{

$from1.=",`document_fields_link` as freactiontype ";

 if ($reactiontype=="Positive")
{
$where1.="AND ( freactiontype.document_field_id=118 AND freactiontype.value='".$rereactiontypetype."' AND a.`document_id` = freactiontype.`document_id` )";
}
else if ($reactiontype=="Negative")
{
$where1.="AND ( freactiontype.document_field_id=118 AND freactiontype.value='".$rereactiontypetype."' AND a.`document_id` = freactiontype.`document_id` )";
}
else if ($reactiontype=="N/A")
{
$where1.="AND ( freactiontype.document_field_id=118 AND freactiontype.value='".$rereactiontypetype."' AND a.`document_id` = freactiontype.`document_id` )";
}
}
//====================

if($reactiontopic=="")
{//echo "no reactiontopic<br>";
}else
{

$from1.=",`document_fields_link` as freactiontopic ";

 if ($reactiontopic=="Enviroment/Health")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND freactiontopic.value='".$reactiontopic."' AND a.`document_id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="Labor/Security withing org")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND freactiontopic.value='".$reactiontopic."' AND a.`document_id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="Competitiveness")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND freactiontopic.value='".$reactiontopic."' AND a.`document_id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="Social Resp. community")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND freactiontopic.value='".$reactiontopic."' AND a.`document_id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="N/A")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND freactiontopic.value='".$reactiontopic."' AND a.`document_id` = freactiontopic.`document_id` )";
}
}
//=====================

if($consequence=="")
{//echo "no consequence<br>";
}else
{

$from1.=",`document_fields_link` as fconsequence ";

if ($consequence=="Natiolization")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND a.`document_id` = fconsequence.`document_id` )";
}
else if ($consequence=="Closures")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND a.`document_id` = fconsequence.`document_id` )";
}
else if ($consequence=="Fines")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND a.`document_id` = fconsequence.`document_id` )";
}
else if ($consequence=="Lawsults")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND a.`document_id` = fconsequence.`document_id` )";
}
else if ($consequence=="Protests")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND a.`document_id` = fconsequence.`document_id` )";
}
else if ($consequence=="Restrictions")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND a.`document_id` = fconsequence.`document_id` )";
}
else if ($consequence=="Opposition")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND a.`document_id` = fconsequence.`document_id` )";
}
else if ($consequence=="Support")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND a.`document_id` = fconsequence.`document_id` )";
}
else if ($consequence=="Recognition")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND a.`document_id` = fconsequence.`document_id` )";
}
else if ($consequence=="N/A")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND a.`document_id` = fconsequence.`document_id` )";
}
}
//=========================

if($actor=="")
{//echo "no actor<br>";
}else
{

$from1.=",`document_fields_link` as factor ";

 if ($actor=="Community")
{
$where1.="AND ( factor.document_field_id=121 AND factor.value='".$actor."' AND a.`document_id` = factor.`document_id` )";
}
else if ($actor=="NGO/Media")
{
$where1.="AND ( factor.document_field_id=121 AND factor.value='".$actor."' AND a.`document_id` = factor.`document_id` )";
}
else if ($actor=="Government")
{
$where1.="AND ( factor.document_field_id=121 AND factor.value='".$actor."' AND a.`document_id` = factor.`document_id` )";
}
else if ($actor=="Other Competitors")
{
$where1.="AND ( factor.document_field_id=121 AND factor.value='".$actor."' AND a.`document_id` = factor.`document_id` )";
}

else if ($actor=="N/A")
{
$where1.="AND ( factor.document_field_id=121 AND factor.value='".$actor."' AND a.`document_id` = factor.`document_id` )";
}
}
}

function displayBotonEventosF($oDocument, $bEdit) {
	global $default;

	//=======>>>>  busqueda para encontrar el tipo de enlace =========>>>>

	$ONE= "SELECT A.`id` FROM `document_types_lookup` AS A, `document_types_lookup` AS B WHERE A.`enlazadoA`=B.`id` AND A.`enlazadoB`=".$oDocument->getDocumentTypeID()."  AND B.`name` LIKE ''" ;
	$TWO = mysql_query($ONE);
	$tipoenlace = mysql_fetch_row($TWO);


 return displayButton2("fichas2","addDocument", "fFolderID=9&arch=2&botview=102&tipoen=".$tipoenlace[0]."&docqllama=".$oDocument->getID(), "Agregar Eventos");
     }




   echo "<link rel=\"stylesheet\" href=\"$default->uiUrl/stylesheet.php\">\n";    
 echo "<table style='text-align: left; width:90% ; ' border='0'  cellpadding='2' cellspacing='2'><tbody>

<tr>
    <td><table width=100% height=60%  align='left' style='text-align: left' ; ' border='0'  cellpadding='2' cellspacing='2'><font size=1 face='Times'><tbody>";
$insmod=0;
   //for($i=0; $i<count($letrasar)-1;$i++){

$busq_links="SELECT distinct a.`document_id` FROM `document_fields_link`as a,`documents`as b ".$from1." WHERE b.`id`= a.`document_id` AND b.`document_type_id`=38 AND b.`status_id`<=2 ".$where1;

//$busq_links="SELECT a.`document_id` FROM `document_fields_link`as a,`documents`as b  WHERE a.`document_field_id`=109 AND b.`id`= a.`document_id`AND b.`status_id`<=2 AND b.`document_type_id`= 38  AND  a.`value` like '". $valor."%'";
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

 

 
echo "<tr style='background-color: rgb($red, $green,$blue);'><td valign='top' height=40% align='left'>";
 



$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$busq_links2[0];
$indv_rel1 = mysql_query($indv_rel);

//$indv_rel2 = mysql_fetch_row($indv_rel1);

 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{

 

  // echo  "<a href='http://www.intelect.com.mx:82/~FichasBD/branches/fichas_cps/control.php?action=viewDocument&fDocumentID=".$busq_links2[0]."' target='fichas2' ><font size=2 face='Times'>". $indv_rel2[3]."</font></a>";
 
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
if ($compdyn=="Yes"){
 $pncd="Competitive Dynamic";}
else {
 $pncd="";}

}
if ($indv_rel2[2]==137 ){
    $tech=$indv_rel2[3];
    if ($tech=="Yes"){
    $pnt=" & Technology";}
else{
    $pnt="";}

}
 if ($indv_rel2[2]==138 ){
    $corp=$indv_rel2[3];
if ($corp=="Yes"){
 $pncrp="& Corporate";}
else {  $pncrp="";}

}
if ($indv_rel2[2]==139){
    $sust=$indv_rel2[3];
    if ($sust=="Yes"){
      $pnsust="& Sustainability";}
else {
      $pnsust="";}
}
}



 echo "<a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$busq_links2[0]."' target='fichas2' ><font size=2 face='Times'>".$fech."</font></a>


</td>

<td>

 echo "<a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$busq_links2[0]."' target='fichas2' ><font size=2 face='Times'>".$partnom." ".$partnomcomp." ".$pncd." ".$pnt." ".$pncrp." ".$pnsust."</font></a>

</td>

<td>

 echo "<a href='/FichasBD/branches/SY/control.php?action=getfeventb2b&letra=".$busq_links2[0]."' target='fichas2' ><font size=2 face='Times'>Ir a Evento Empresarial</font></a>



";
}

//} del for
echo "</td></tr></table></table>";

 
} //1
?>
