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
$nota = $_GET["nota"];
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
$industria=$_GET["industry"];
$subindustria=$_GET["subindustry"];
$parampais=$_GET["pais"];
$ano=$_GET["ano"];
$fechaA=$_GET["fecha1"];
$fechaP=$_GET["fecha2"];
$apartir=$_GET["apartir"];
$where1 = "";
$from1="";
 $letram=strtoupper($letra);
   $letrasar= explode("_",$letram);


if($nota=="")
{//echo "no paterno<br>";
}else
{
$boolnota=1;
//$from1.=",`document_fields_link` as fnota ";
$from0= ",(select value,document_id from  `document_fields_link` where document_field_id=114 ) as fnota ";

//$where1.="AND ( fnota.document_field_id=114 AND fnota.value LIKE '%$nota%'  AND a.`document_id` = fnota.`document_id` )";

$where0="AND ( fnota.value LIKE '%$nota%'  AND b.`id` = fnota.`document_id` )";


$from2=  ",(select fcompetidor.document_id,fnombre_competidor.value from";
$from2.= " (select * from `document_fields_link` where";
$from2.= " document_field_id=142) as fcompetidor left join ";
$from2.= "(select * from `document_fields_link` where ";
$from2.= "document_field_id=92) as fnombre_competidor on ";
$from2.= "fcompetidor.value=fnombre_competidor.document_id ) as paq ";
$where2= " AND (  b.`id` = paq.`document_id` AND  paq.value like '%".$nota."%')";

$from3=", (select * from `document_fields_link` where document_field_id=113 ) as fsummary";
$where3= " AND (  b.`id` = fsummary.`document_id` AND fsummary.value like '%".$nota."%')";  
}


if($parampais=="")
{//echo "no paterno<br>";
}else
{
$boolpais=1;
//$from1.=",`document_fields_link` as fnota ";
//$from0= ",(select value,document_id from  `document_fields_link` where document_field_id=114 ) as fnota ";

//$where1.="AND ( fnota.document_field_id=114 AND fnota.value LIKE '%$nota%'  AND a.`document_id` = fnota.`document_id` )";

//$where0="AND ( fnota.value LIKE '%$nota%'  AND b.`id` = fnota.`document_id` )";


$from1.=  ",(select flugar.document_id,fpais.cinco from";
$from1.= " (select * from `document_fields_link` where";
$from1.= " document_field_id=161) as flugar left join ";
$from1.= "(select id,cinco from `Lugares`.`Lugares` where ";
$from1.= "cinco = $parampais) as fpais on ";
$from1.= "flugar.value=fpais.id ) as paisq ";
//$where2= " AND (  b.`id` = paq.`document_id` AND  paq.value = '$industria')";
$where1.= " AND (  b.`id` = paisq.`document_id` and  paisq.cinco=$parampais)";

//$from3=", (select * from `document_fields_link` where document_field_id=113 ) as fsummary";
//$where3= " AND (  b.`id` = fsummary.`document_id` AND fsummary.value like '%".$nota."%')";  
}


if($industria=="")
{//echo "no paterno<br>";
}else
{
$boolnota=1;
//$from1.=",`document_fields_link` as fnota ";
//$from0= ",(select value,document_id from  `document_fields_link` where document_field_id=114 ) as fnota ";

//$where1.="AND ( fnota.document_field_id=114 AND fnota.value LIKE '%$nota%'  AND a.`document_id` = fnota.`document_id` )";

//$where0="AND ( fnota.value LIKE '%$nota%'  AND b.`id` = fnota.`document_id` )";


$from1.=  ",(select fcompetidorind.document_id,find_competidor.value from";
$from1.= " (select * from `document_fields_link` where";
$from1.= " document_field_id=142) as fcompetidorind left join ";
$from1.= "(select * from `document_fields_link` where ";
$from1.= "document_field_id=76) as find_competidor on ";
$from1.= "fcompetidorind.value=find_competidor.document_id ) as paqind ";
//$where2= " AND (  b.`id` = paq.`document_id` AND  paq.value = '$industria')";
$where1.= " AND (  b.`id` = paqind.`document_id` AND  paqind.value = '".$industria."')";

// SubIndustria

if ($subindustria=="")
{}
else
{

$from1.=  ",(select fcompetidorsind.document_id,fsind_competidor.value from";
$from1.= " (select * from `document_fields_link` where";
$from1.= " document_field_id=142) as fcompetidorsind left join ";
$from1.= "(select * from `document_fields_link` where ";
$from1.= "document_field_id=263) as fsind_competidor on ";
$from1.= "fcompetidorsind.value=fsind_competidor.document_id ) as paqsind ";
//$where2= " AND (  b.`id` = paq.`document_id` AND  paq.value = '$industria')";
$where1.= " AND (  b.`id` = paqsind.`document_id` AND  paqsind.value = '".$subindustria."')";


}

//SubIndustria




//$from3=", (select * from `document_fields_link` where document_field_id=113 ) as fsummary";
//$where3= " AND (  b.`id` = fsummary.`document_id` AND fsummary.value like '%".$nota."%')";  
}

if($ano=="")
{//echo "no paterno<br>";
// Abajo poner if ningun_parametro de widget then
// y enfocarlo a fecha de captura no a fecha de evento como el comentario de abajo

//$from1.=",`document_fields_link` as fano ";
//$where1.="AND ( fano.document_field_id=109 AND (fano.value > (CURDATE()-INTERVAL 1 MONTH))  AND b.`id` = fano.`document_id` )";

}else
{
$boolano=1;
$from1.=",`document_fields_link` as fano ";
$where1.="AND ( fano.document_field_id=109 AND fano.value LIKE '".$ano."%'  AND b.`id` = fano.`document_id` )";
}

$oplog=($fechaA=="" && $fechaP=="" && $ano =="" && $nota=="" && $region=="");
$oplog=($oplog && $event=="" && $action=="" && $type=="" && $competitive=="");
$oplog=($oplog && $sustainability=="" && $reactiontype =="" &&$reactiontopic =="");
$oplog=($oplog && $consequence =="" &&  $actor =="" && $competidor =="" && $industria=="" && $parampais=="");
if($oplog)
{
//echo $oplog;
//$where1.="AND b.modified > (CURDATE()-INTERVAL 1 MONTH) ";
$where1.="AND b.modified  > (CURDATE()-INTERVAL 1 DAY) ";
}else
{
//$boolano=1;
//$from1.=",`document_fields_link` as ffechaa ";
//$where1.="AND b.modified = CURDATE() ";
}

if($fechaA=="")
{
}else
{
$boolano=1;
$from1.=",`document_fields_link` as ffechaa ";
$where1.="AND ( ffechaa.document_field_id=109 AND ffechaa.value > '$fechaA'  AND b.`id` = ffechaa.`document_id` )";
}

if($fechaP=="")
{
}else
{
$boolano=1;
$from1.=",`document_fields_link` as ffechab ";
$where1.="AND ( ffechab.document_field_id=109 AND ffechab.value < '$fechaP'  AND b.`id` = ffechab.`document_id` )";
}



if($region=="")
{//echo "no region<br>";
}else
{
$from1.=",`document_fields_link` as fregion ";

if($region=="Asia and South Pacific")
{//echo "no region<br>";
$where1.="AND ( fregion.document_field_id=110 AND ( fregion.value='Asia & South Pacific' OR fregion.value='ASIA AND SOUTH PACIFIC') AND b.`id` = fregion.`document_id` )";
}
else
if($region=="Egypt and Middle East")
{//echo "no region<br>";
$where1.="AND ( fregion.document_field_id=110 AND ( fregion.value='Egypt & Middle East' OR fregion.value='EGYPT AND MIDDLE EAST') AND b.`id` = fregion.`document_id` )";
}
else{


$where1.="AND ( fregion.document_field_id=110 AND fregion.value='".$region."' AND b.`id` = fregion.`document_id` )";
}
}

if($event=="")
{//echo "no event<br>";
}else
{

$from1.=",`document_fields_link` as fevent ";

if ($event=="Competitive Dynamic")
{
$where1.="AND ( fevent.document_field_id=136 AND (fevent.value='Yes' OR  fevent.value='YES')  AND b.`id` = fevent.`document_id` )";
} else if ($event=="Technology")
{
$where1.="AND ( fevent.document_field_id=137 AND (fevent.value='Yes' OR  fevent.value='YES')  AND b.`id` = fevent.`document_id` )";
} else if ($event=="Sustainability")
{
$where1.="AND ( fevent.document_field_id=139 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` )";
} else if ($event=="Opportunities")
{
$where1.="AND ( fevent.document_field_id=183 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` )";
} else if ($event=="Corporate")
{
$where1.="AND ( fevent.document_field_id=138 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` )";
} else if ($event=="Reactions")
{
$where1.="AND ( fevent.document_field_id=186 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` )";
}

}


if($action=="")
{//echo "no action<br>";
}else
{

$from1.=",`document_fields_link` as faction ";

if ($action=="New Company")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
} else if ($action=="Acquisition-Company")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
} else if ($action=="Expansion")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
} else if ($action=="Mergers")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
} else if ($action=="Upgrades")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
} else if ($action=="JV")
{
$where1.="AND ( faction.document_field_id=127 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
} else if ($action=="Alternative Fuels Project")
{
$where1.="AND ( faction.document_field_id=125 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
} else if ($action=="New Material / Processes")
{
$where1.="AND ( faction.document_field_id=125 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
}else if ($action=="Projects / Loans")
{
$where1.="AND ( faction.document_field_id=122 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
}
else if ($action=="Organization of Forums and Events")
{
$where1.="AND ( faction.document_field_id=122 AND faction.value='Organization of Forums and Events' AND b.`id` = faction.`document_id` )";
}
else if ($action=="Attendance to Forums and Events")
{
$where1.="AND ( faction.document_field_id=122 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
}
else if ($action=="Awards delivered")
{
$where1.="AND ( faction.document_field_id=122 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
}
else if ($action=="Document Publishing")
{
$where1.="AND ( faction.document_field_id=122 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
}
else if ($action=="Foundation/Cofoundation of organisms")
{
$where1.="AND ( faction.document_field_id=184 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
}else if ($action=="Cost Reduction")
{
$where1.="AND ( faction.document_field_id=184 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
}else if ($action=="Capital Finance Raise")
{
$where1.="AND ( faction.document_field_id=184 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
}else if ($action=="Increase Prices")
{
$where1.="AND ( faction.document_field_id=184 AND faction.value='".$action."' AND b.`id` = faction.`document_id` )";
}else if ($action=="Volume Raise")
{
$where1.="AND ( faction.document_field_id=116 AND faction.value='".$type."' AND b.`id` = faction.`document_id` )";
}
}

if($type=="")
{//echo "no action<br>";
}else
{

$from1.=",`document_fields_link` as ftype ";

 if ($type=="Cement")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Concrete")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Aggregates")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Other")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}

else if ($type=="Quarries")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Sea Terminal")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Distribution Center")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="RandB Center")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='R&D' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Non Core Related")
{
$where1.="AND ( ftype.document_field_id=116 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="TDF(Tires)")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Bio-Mass")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Indistrial Wastes")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Municipal Waste")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Low resource consumption")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Recyclers")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Low polluters / Env Quality Enchancers")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Training/Education")
{
$where1.="AND ( ftype.document_field_id=123 AND (ftype.value='Training/Education' or ftype.value='TRAINING / EDUCATION' ) AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Business Incubator")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Redeployment on closure")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Infraestructure Development")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Housing")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Natural Disaster Aid")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Historical Monuments Protector")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Safety promotion")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Labor Equity/Human Rights")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Sponsor of Cultural-Sport Activities")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Stakeholders/Community Involvement")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Biodiversity and Quarry Rehabilitation")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Protecting Air Quality and Mitigating Disturbances")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Water Protection")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Reccycling Industrial by products and wastes")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Energy Recovery (Electricity)")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
}
//===========================

if($competitive=="")
{//echo "no action<br>";
}else
{

$from1.=",`document_fields_link` as fcompetitive ";


if ($competitive=="Plan")
{
$where1.="AND ( fcompetitive.document_field_id=117 AND fcompetitive.value='".$competitive."' AND b.`id` = fcompetitive.`document_id` )";
}
else if ($competitive=="In Process")
{
$where1.="AND ( fcompetitive.document_field_id=117 AND fcompetitive.value='".$competitive."' AND b.`id` = fcompetitive.`document_id` )";
}
else if ($competitive=="Completed")
{
$where1.="AND ( fcompetitive.document_field_id=117 AND fcompetitive.value='".$competitive."' AND b.`id` = fcompetitive.`document_id` )";
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
$where1.="AND ( fsustainability.document_field_id=124 AND fsustainability.value='".$sustainability."' AND b.`id` = fsustainability.`document_id` )";
}
else if ($sustainability=="Social")
{
$where1.="AND ( fsustainability.document_field_id=124 AND fsustainability.value='".$sustainability."' AND b.`id` = fsustainability.`document_id` )";
}
else if ($sustainability=="Enviroment")
{
$where1.="AND ( fsustainability.document_field_id=124 AND fsustainability.value='".$sustainability."' AND b.`id` = fsustainability.`document_id` )";
}
else if ($sustainability=="Sustainable")
{
$where1.="AND ( fsustainability.document_field_id=124 AND fsustainability.value='".$sustainability."' AND b.`id` = fsustainability.`document_id` )";
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
$where1.="AND ( freactiontype.document_field_id=118 AND freactiontype.value='".$reactiontype."' AND b.`id` = freactiontype.`document_id` )";
}
else if ($reactiontype=="Negative")
{
$where1.="AND ( freactiontype.document_field_id=118 AND freactiontype.value='".$reactiontype."' AND b.`id` = freactiontype.`document_id` )";
}
else if ($reactiontype=="N/A")
{
$where1.="AND ( freactiontype.document_field_id=118 AND freactiontype.value='".$reactiontype."' AND b.`id` = freactiontype.`document_id` )";
}
}
//====================

if($reactiontopic=="")
{//echo "no reactiontopic<br>";
}else
{

$from1.=",`document_fields_link` as freactiontopic ";
/****
 if ($reactiontopic=="Enviroment/Health")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND freactiontopic.value='".$reactiontopic."' AND b.`id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="Labor/Security within org")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND freactiontopic.value='".$reactiontopic."' AND b.`id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="Competitiveness")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND freactiontopic.value='".$reactiontopic."' AND b.`id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="Social Resp. community")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND freactiontopic.value='".$reactiontopic."' AND b.`id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="N/A")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND freactiontopic.value='".$reactiontopic."' AND b.`id` = freactiontopic.`document_id` )";
}
****/

if ($reactiontopic=="Enviroment/Health" || $reactiontopic=="ENVIRONMENT/HEALTH" )
{
$where1.="AND ( freactiontopic.document_field_id=119 AND ( freactiontopic.value='Enviroment/Health' OR freactiontopic.value='ENVIRONMENT/HEALTH' ) AND b.`id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="Labor/Security within org" || $reactiontopic=="LABOR/SECURITY WITHIN ORG" )
{
$where1.="AND ( freactiontopic.document_field_id=119 AND ( freactiontopic.value='Labor/Security within org' OR freactiontopic.value='LABOR/SECURITY WITHIN ORG' )  AND b.`id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="Competitiveness" || $reactiontopic=="COMPETITIVENESS")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND ( freactiontopic.value='Competitiveness' OR freactiontopic.value='COMPETITIVENESS' )  AND b.`id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="Social Resp. community" || $reactiontopic=="SOCIAL RESPONSIBILITY WITH COMMUNITY" )
{
$where1.="AND ( freactiontopic.document_field_id=119 AND ( freactiontopic.value='Social Resp. community' OR freactiontopic.value='SOCIAL RESPONSIBILITY WITH COMMUNITY' ) AND b.`id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="ETHICS / LICIT" )
{
$where1.="AND ( freactiontopic.document_field_id=119 AND ( freactiontopic.value='ETHICS / LICIT' ) AND b.`id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="PERFORMANCE")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND ( freactiontopic.value='PERFORMANCE') AND b.`id` = freactiontopic.`document_id` )";
}
else if ($reactiontopic=="N/A")
{
$where1.="AND ( freactiontopic.document_field_id=119 AND ( freactiontopic.value='N/A' ) AND b.`id` = freactiontopic.`document_id` )";
}

}
//=====================

if($consequence=="")
{//echo "no consequence<br>";
}else
{

$from1.=",`document_fields_link` as fconsequence ";

if ($consequence=="CLOSURES")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="DOWNGRADE")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="EXPROPIATION")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="FINES")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="INVESTIGATION")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="LAWSUITS")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="OPPOSITION / ACCUSATION")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="PROTEST / DEMOSTRATIONS")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="RECOGNITION")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="RECOMMENDATION")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="RESTRICTIONS")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="UPGRADE")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="WARNING")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
else if ($consequence=="N/A")
{
$where1.="AND ( fconsequence.document_field_id=120 AND fconsequence.value='".$consequence."' AND b.`id` = fconsequence.`document_id` )";
}
}
//=========================

if($actor=="")
{//echo "no actor<br>";
}else
{
$echoactor=1;
$from1.=",`document_fields_link` as factor ";

 if ($actor=="Community")
{
$where1.="AND ( factor.document_field_id=121 AND factor.value='".$actor."' AND b.`id` = factor.`document_id` )";
}
else if ($actor=="NGO/Media")
{
$where1.="AND ( factor.document_field_id=121 AND factor.value='".$actor."' AND b.`id` = factor.`document_id` )";
}
else if ($actor=="Government")
{
$where1.="AND ( factor.document_field_id=121 AND factor.value='".$actor."' AND b.`id` = factor.`document_id` )";
}
else if ($actor=="Other Competitors")
{
$where1.="AND ( factor.document_field_id=121 AND factor.value='".$actor."' AND b.`id` = factor.`document_id` )";
}

else if ($actor=="N/A")
{
$where1.="AND ( factor.document_field_id=121 AND factor.value='".$actor."' AND b.`id` = factor.`document_id` )";
}
}



if($competidor=="")
{//echo "no competidor<br>";
}else
{
$echocompetidor=1;
$from1.=",`document_fields_link` as fcompetidor ";

if ($competidor=="1581")
{
$where1.="AND (  fcompetidor.document_field_id=142 AND ( fcompetidor.value='1581'";
$where1.=" OR fcompetidor.value='1587'";  
$where1.=" OR fcompetidor.value='1640'";
$where1.=" OR fcompetidor.value='1641'";
$where1.=" OR fcompetidor.value='1655'";
$where1.=" OR fcompetidor.value='2300'";
$where1.=" OR fcompetidor.value='2301'";
$where1.=" OR fcompetidor.value='3238'";
//  la union $where1.=" OR fcompetidor.value='3170'";
$where1.=" OR fcompetidor.value='3192'";
//la union $where1.=" OR fcompetidor.value='3184'";
$where1.=" OR fcompetidor.value='3116'";
$where1.=" OR fcompetidor.value='3113'";
$where1.=" OR fcompetidor.value='3102'";
$where1.=" OR fcompetidor.value='3065'";
$where1.=" OR fcompetidor.value='3143'";


$where1.=")  AND b.`id` = fcompetidor.`document_id` )";
}
else if ($competidor=="3089")
{
$where1.="AND (  fcompetidor.document_field_id=142 AND ( fcompetidor.value='3089'";
$where1.=" OR fcompetidor.value='3122'";  
$where1.=" OR fcompetidor.value='3157'";
$where1.=" OR fcompetidor.value='3159'";
$where1.=" OR fcompetidor.value='3175'";
$where1.=" OR fcompetidor.value='3217'";
$where1.=" OR fcompetidor.value='3224'";
$where1.=" OR fcompetidor.value='3227'";
$where1.=" OR fcompetidor.value='3170'";
$where1.=" OR fcompetidor.value='3231'";
$where1.=" OR fcompetidor.value='3184'";
/**** faltan 4
$where1.=" OR fcompetidor.value='311'";
$where1.=" OR fcompetidor.value='3113'";
$where1.=" OR fcompetidor.value='3102'";
$where1.=" OR fcompetidor.value='3065'";
*****/

$where1.=")  AND b.`id` = fcompetidor.`document_id` )";
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

header("Content-type: application/vnd.ms-excel; charset=utf-8");

header("Content-Disposition: attachment; filename=report.csv");


/***
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
**/
echo "\"  Date \",";
echo "\" Region \",";   //**
echo "\" Country \",";
echo "\" City \",";   //**
echo "\" Plant \",";   //**
echo "\"Competitor \",";
//0511 echo "\" Is Competitive Dynamic ? \",";   //**
//0511 echo "\"Competitive Dynamic Action \",";   //**
//0511 echo "\"Competitive Dynamic Sector \",";   //**
//0511 echo "\"Competitive Dynamic SP \",";   //**
//0511 echo "\"It is an opportumity ? \",";   //**
//0511 echo "\"Opp. Action \",";   //**
//0511 echo "\"Opp. Type \",";   //**
//0511 echo "\" Is it Corporate ? \",";   //**
//0511 echo "\"Type Corporate Event \",";   //**
//0511 echo "\"Gross Profit \",";   //**
//0511 echo "\"Operating Income \",";   //**
//0511 echo "\"Net Revenue \",";   //**
//0511 echo "\"EBITDA \",";   //**
//0511 echo "\"Total Income \",";   //**
//0511 echo "\"Is it Sustainability ?\",";   //**
//0511 echo "\"Sustainability Action \",";   //**
//0511 echo "\"Sustainability Type \",";   //**
//0511 echo "\"Sustainability Theme \",";   //**
//0511 echo "\"Is it Technology ? \",";   //**
//0511 echo "\"Technology Action \",";   //**
//0511 echo "\"Technology Type \",";   //**
//0511 echo "\"Technology Description \",";   //**
//0511 echo "\"Is it Reaction ? \",";   //**
//0511 echo "\"Reaction Type \",";   //**
//0511 echo "\"Reaction Topic \",";   //**
//0511 echo "\"Reaction Consequence \",";   //**
//0511 echo "\"Reaction Actor \",";   //**
echo "\"Additional Capacity \",";   //**
echo "\"Amount \",";   //**
echo "\"Type of Source \",";   //**
echo "\"Summary \",";   //**
echo "\"Complete Note \",";   //**
echo "\"Related Individual \",";   //**
echo "\"Source \",";   //**
echo "\"Event Type \",";
echo "\"Action \",";
echo "\"Action Type \",";
echo "\"-3- \",";
echo "\"-4- \",";
echo "\"R. Individual(s) \",";
echo "\"Institute \"";
echo "\r\n";
$insmod=0;
   
//$busq_links="SELECT distinct b.`id` FROM (select id,modified from `documents` where `document_type_id`=38  AND `status_id`<=2) as b ".$from1." WHERE 1 ".$where1;


if ($nota=="")
{
$busq_links="SELECT distinct b.`id` FROM (select id,modified from `documents` where `document_type_id`=38  AND `status_id`<=2) as b ".$from1." WHERE 1 ".$where1.$limite;
}
else
{
$busq_links="SELECT distinct funion.id FROM ( ";
$busq_links.="(select distinct b.id from (select id,modified from `documents` where `document_type_id`=38  AND `status_id`<=2) as b ".$from0.$from1." WHERE 1 ".$where1.$where0." )";
$busq_links.= " UNION ( select distinct b.id from (select id,modified from `documents` where `document_type_id`=38  AND `status_id`<=2) as b ".$from2.$from1." WHERE 1 ".$where1.$where2." )" ;
$busq_links.= " UNION ( select distinct b.id from (select id,modified from `documents` where `document_type_id`=38  AND `status_id`<=2) as b ".$from3.$from1." WHERE 1 ".$where1.$where3." )) as funion  where 1".$limite;
//echo $cuentasql;
//echo $busq_links;

}


$busq_links1 = mysql_query($busq_links);

//echo $busq_links;

 while ($busq_links2 = mysql_fetch_row($busq_links1))
{  //while busqlinks2
 $insmod++; 
  $modd=$insmod%2;
  $red=220*$modd-255*($modd-1);
  $green=220*$modd-255*($modd-1);
  $blue=220*$modd-255*($modd-1);
$oDocument = & Document::get($busq_links2[0]);

 

 



$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND `document_id`=".$busq_links2[0];
$indv_rel1 = mysql_query($indv_rel);


 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{  //whileinvrel

 

  if ($indv_rel2[2]==155 ){
   $typeCD=$indv_rel2[3];

}
 if ($indv_rel2[2]==126 ){
   $typeT=$indv_rel2[3];

}
 if ($indv_rel2[2]==123 ){
   $typeS=$indv_rel2[3];

}
 if ($indv_rel2[2]==185 ){
   $typeOpp=$indv_rel2[3];

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
$one="SELECT value  FROM `document_fields_link`"
     ." WHERE `document_field_id`= 92  AND `document_id`=".$competidor;
$two=mysql_query($one);
$three=mysql_fetch_row($two);
$partnomcomp=$three[0];
}
else {$partnomcomp="";}

}

//**********

 if ($indv_rel2[2]==110){
   $regsql=$indv_rel2[3];
//region

}

 if ($indv_rel2[2]==152){
   $plansql=$indv_rel2[3];
//planta

}

 if ($indv_rel2[2]==116){
   $cdsecsql=$indv_rel2[3];
//cdsect

}
 if ($indv_rel2[2]==117){
   $cdspsql=$indv_rel2[3];
//cdsect

}
if ($indv_rel2[2]==185){
   $opptypsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==155){
   $typcorpevsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==103){
   $grosprofsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==104){
   $opincomsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==105){
   $netrevsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==106){
   $ebitdasql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==102){
   $totincomesql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==123){
   $sustypsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==124){
   $susthemesql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==126){
   $techtypsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==163){
   $techdescsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==119){
   $reactopsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==120){
   $reactconssql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==150){
   $addcapsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==149){
   $amountsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==164){
   $typesourcsql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==113){
   $summarysql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==114){
   $compnotesql=$indv_rel2[3];
//cdsect
}
if ($indv_rel2[2]==115){
   $sourcesql=$indv_rel2[3];
//cdsect
}

if ($indv_rel2[2]==130){
   $relatedind=$indv_rel2[3];
//cdsect
if ($relatedind>0){
$nom_rel= "SELECT value FROM `document_fields_link` WHERE `document_field_id`= 8  AND `document_id`=".$relatedind;
$nom_rel1 = mysql_query($nom_rel);
$nom=mysql_fetch_row($nom_rel1);
$ap_rel= "SELECT value FROM `document_fields_link` WHERE `document_field_id`= 21  AND `document_id`=".$relatedind;
$ap_rel1 = mysql_query($ap_rel);
$ap=mysql_fetch_row($ap_rel1);
$am_rel= "SELECT value FROM `document_fields_link` WHERE `document_field_id`= 22  AND `document_id`=".$relatedind;
$am_rel1 = mysql_query($am_rel);
$am=mysql_fetch_row($am_rel1);
$relindsql=$nom[0]." ".$ap[0]." ".$am[0];
}
}

if ($indv_rel2[2]==114){
   $compnotesql=$indv_rel2[3];
//cdsect
}


if ($indv_rel2[2]==161 ){ //ciudad
    $lug=$indv_rel2[3];
$bandtipo=0;
if($indv_rel2[3]>0)
{


$linkA2 = "SELECT B.`dos` FROM   `Lugares`.`Lugares` as A, `Lugares`.`Estado` as B WHERE A.`cuatro` = B.`id` AND A.`id`=".$indv_rel2[3];
$linkB2 = mysql_query($linkA2);
$dato2=mysql_fetch_row($linkB2);

$linkA1 = "SELECT `dos`  FROM   `Lugares`.`Lugares` WHERE `id`=".$indv_rel2[3];
$linkB1 = mysql_query($linkA1);

$dato1=mysql_fetch_row($linkB1);
//$sToRender .= "<SELECT  ID=\"%s\" NAME=\"%s\"   SIZE=\"1\">";
 $LugToRender = "$dato1[0] / $dato2[0]";

     //  $extra.="<tr><td><font size=2 face='Times' color='blue'>$explparam[2]</font></td><td colspan='2' align='justify'><font size=2 face='Times'>".$sToRender."</font></td></tr>";

//$sToRender.="<input type='text' size='20' name='%s' value='%s' maxlength='12' />";

//return sprintf($sToRender,$this->sFormName, $this->sFormName,$this->sValue, $this->sFormName);
}//si value es mayor a 0 arriba si no abajo

}








//**********

 if ($indv_rel2[2]==136 ){
    $compdyn=$indv_rel2[3];
if ($compdyn=="Yes" || $compdyn=="YES"){
 $pncd="Competitive Dynamic";}
else {
 $pncd="";}

}
if ($indv_rel2[2]==137 ){
    $tech=$indv_rel2[3];
    if ($tech=="Yes" || $tech=="YES"){
    $pnt="Technology";}
else{
    $pnt="";}

}
 if ($indv_rel2[2]==138 ){
    $corp=$indv_rel2[3];
if ($corp=="Yes" || $corp=="YES"){
 $pncrp="Corporate";}
else {  $pncrp="";}

}
if ($indv_rel2[2]==139){
    $sust=$indv_rel2[3];
    if ($sust=="Yes" || $sust=="YES" ){
      $pnsust="Sustainability";}
else {
      $pnsust="";}
}

if ($indv_rel2[2]==186){
    $react=$indv_rel2[3];
    if ($react=="Yes" || $react=="YES"){
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
    if ($react=="Yes" || $react=="YES"){
      $col5react="React.";}
    else {
      $col5react="";}}

 if ($indv_rel2[2]==183){
    $oppo=$indv_rel2[3];
    if ($oppo=="Yes" || $oppo=="YES" ){
      $col5oppo="Opp.";}
else {
      $col5oppo="";}}

 if ($indv_rel2[2]==139){
    $susta=$indv_rel2[3];
    if ($susta=="Yes" || $susta=="YES"){
      $col5susta="Sust.";}
else {
      $col5susta="";}}

if ($indv_rel2[2]==136){
    $compe=$indv_rel2[3];
    if ($compe=="Yes" || $compe=="YES"){
      $col5compe="CD.";}
else {
      $col5compe="";}}

if ($indv_rel2[2]==137){
    $techn=$indv_rel2[3];
    if ($techn=="Yes" || $techn=="YES"){
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
    if ($corpo=="Yes" || $corpo=="YES" ){
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


echo "\"".$fech."\",";
echo "\"".$regsql."\","; //**
 echo "\"".$partnom."\",";
echo "\"".$LugToRender."\","; //**
echo "\"".$plansql."\","; //**
 echo "\"".$partnomcomp."\",";

//0511 echo "\"".$compe."\","; //**
//0511 echo "\"".$cdact."\","; //**
//0511 echo "\"".$cdsecsql."\","; //** cdsecsql
//0511 echo "\"".$cdspsql."\","; //**
//0511 echo "\"".$oppo."\","; //**
//0511 echo "\"".$oppoact."\","; //**
//0511 echo "\"".$optypsql."\","; //**
//0511 echo "\"".$corp."\","; //** is corp
//0511 echo "\"".$typcorpevsql."\","; //**
//0511 echo "\"".$grosprofsql."\","; //**
//0511 echo "\"".$opincomsql."\","; //**
//0511 echo "\"".$netrevsql."\","; //**
//0511 echo "\"".$ebitdasql."\","; //**
//0511 echo "\"".$totincomesql."\","; //**
//0511 echo "\"".$susta."\","; //** is sust
//0511 echo "\"".$sustact."\","; //**
//0511 echo "\"".$sustypsql."\","; //**
//0511 echo "\"".$susthemesql."\","; //**
//0511 echo "\"".$techn."\","; //** is tech
//0511 echo "\"".$technact."\","; //**
//0511 echo "\"".$techtypsql."\","; //**
//0511 echo "\"".$techdescsql."\","; //**
//0511 echo "\"".$react."\","; //** is react 
//0511 echo "\"".$rectyp."\","; //**
//0511 echo "\"".$reactopsql."\","; //**
//0511 echo "\"".$reactconssql."\","; //**
//0511 echo "\"".$react_actor."\","; //**
echo "\"".$addcapsql."\","; //**
echo "\"".$amountsql."\","; //**
echo "\"".$typesourcsql."\","; //**
$sumsql=str_replace('"',"'",$summarysql);
//$summsql=str_replace(",","commma",$sumsql);
echo "\"".$sumsql."\","; //**
$compnsql=str_replace('"',"'",$compnotesql);
//$complnsql=str_replace(",","commma",$compnsql);
echo "\"".$compnsql."\","; //**
echo "\"".$relindsql."\","; //**
echo "\"".$sourcesql."\","; //**

$sumadecondiciones=0;
// aqui va el if y se pone una tabla siempre que haya mas de un tipo  puesto
$sumadecondiciones=($pncd!="")+($pnt!="")+($pncrp!="")+($pnsust!="")+($pnreact!="");
//if $sumadecondiciones >1

if($sumadecondiciones>1)
{
echo "\"";
 if ($pncd != "")  {echo $pncd;}//Competitive Dynamic

if (($pncd!="") && ($pnt!="")) {$pnt = "/".$pnt;}
 
if ($pncd!="")  {echo $pnt;} //Technology

if ((($pncd!="") || ($pnt!="")) && ($pncrp!=""))  {$pncrp = "/".$pncrp;}

if ($pncrp!="")   {echo $pncrp;} //Corporate
if ((($pncd!="") || ($pnt!="") || ($pncrp!="")) && ($pnreact!=""))  {$pnreact = "/".$pnreact;}
if ($pnreact!="") {echo $pnreact;} //Reactions

if ((($pncd!="") || ($pnt!="") || ($pncrp!="")) && ($pnsust!="") ) {$pnsust = "/".$pnsust;}

 if ($pnsust!="") {echo $pnsust;}
echo "\","; //Sustainability
}
else
{

//echo table tbody
 echo "\"".$pncd; //Competitive Dynamic

 echo $pnt; //Technology
 echo $pncrp; //Corporate
echo $pnreact; //Reactions
 echo $pnsust."\","; //Sustainability
}
// poner columna de opportunities y reactions

//acaba el if


//Col 5
 echo "\"";
if ($rectyp!=""){
 echo $col5react.$rectyp." - ";

}

if ($cdact!=""){
 echo $col5compe.$cdact." - ";

}

if ($sustact!=""){
 echo $col5susta.$sustact." - ";

}

if ($technact!=""){
 echo $col5techn.$technact." - ";

}

echo "\",";

//Col 6

 echo "\"";

if ($reactop!=""){
 echo $col5react.$reactop." - ";

}

if ($compdinsec!=""){
 echo $col5compe.$compdinsec." - ";

}

if ($sustheme!=""){
 echo $col5susta.$sustheme." - ";

}


if ($typeS!=""){
 echo $col5susta.$typeS." - ";

}

if ($techtyp!=""){
 echo $col5techn.$techtyp." - ";

}

if ($typcorpev!=""){
 echo $col6corpo.$typcorpev." - ";

}
if ($opptyp!=""){
 echo $col5oppo.$opptyp." - ";

}

echo "\",";


//

// Col 7

 echo "\"";

if ($compdynsp!=""){
 echo $col5compe.$compdynsp;

}

if ($reactcon!=""){
 echo $col5react.$reactcon;

}

if ($techndesc!=""){
 echo $col5techn.$techndesc;

}


echo "\",";

//col 8


 echo "\"";


 echo $reactact;

echo "\",";

// Col 9 Indiv Relacionados

//$result3= mysql_query("select id,parent_document_id, child_document_id from documents where parent_document_id= $busq_links2[0] or child_document_id = $busq_links2[0]");
$result3= mysql_query("select id,parent_document_id, child_document_id from documents where (parent_document_id= $busq_links2[0] or child_document_id = $busq_links2[0]) and status_id <=2 and document_type_id=43");

$indice=0;

echo "\"";

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
echo " - ";
}

 echo $appat[0]." ".$apmat[0]." ".$nom[0];

$indice++;

} //del while


echo "\",";

//Col 10

$result3= mysql_query("select id,parent_document_id, child_document_id from documents where parent_document_id= $busq_links2[0] or child_document_id = $busq_links2[0]");

$indicemp=0;

 echo "\"";

while($row3 =  mysql_fetch_row($result3))
{


if ($row3[1]==$busq_links2[0]){$emprel_id=$row3[2];}
else {$emprel_id=$row3[1];}

$emp0="SELECT value FROM document_fields_link WHERE `document_field_id` = 92 AND `document_id`= ".$emprel_id;
$emp1=mysql_query($emp0);
$raz=mysql_fetch_row($emp1);

if ($indicemp>=1){
echo " - ";
}

 echo $raz[0];

$indicemp++;

} //del while

echo "\"\r\n"; //??????????????????





//






// if boolnota
// echo con pedazo de nota

//uyuy
}

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
