<?php

require_once("../../../../config/dmsDefaults.php");


if  (1) {               

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
$notime=$_GET["notime"];
$politik=$_GET["pol"];
$fechaA=$_GET["fecha1"];

$fechaP=$_GET["fecha2"];
$apartir=$_GET["apartir"];
$where1 = "";
$from1="";
 $letram=strtoupper($letra);
   $letrasar= explode("_",$letram);




if ($politik!=""){$from1.=",`document_fields_link` as fevent ";}

if ($fechaA=="") {$fechaA="(CURDATE()-INTERVAL 1 WEEK)";}  // ex 1 DAY
if($nota=="")
{
}else
{
$boolnota=1;
$from1.= ",(select value,document_id from  `document_fields_link` where document_field_id=114 ) as fnota ";

$where1.="AND ( fnota.value LIKE '%$nota%'  AND b.`id` = fnota.`document_id` )";
}


if($parampais=="")
{// "no paterno<br>";
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
{// "no paterno<br>";
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
//$where2= " AND (  b.`id` = paqind.`document_id` AND  paqind.value = '$industria')";
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
{

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
$where1.="AND b.modified  > (CURDATE()-INTERVAL 1 WEEK) ";
}else
{

}

if($fechaA=="")
{
}else
{
$boolano=1;
$from1.=",`document_fields_link` as ffechaa ";
if ($notime==1)
{
//$where1.="AND ( ffechaa.document_field_id=109 AND ffechaa.value > '$fechaA'  AND b.`id` = ffechaa.`document_id` )";
$where1.="AND ( ffechaa.document_field_id=109 AND ffechaa.value > (CURDATE()-INTERVAL 2 DAY)  AND b.`id` = ffechaa.`document_id` )";
}
else if($notime==2)
{
//$where1.="AND ( ffechaa.document_field_id=109 AND ffechaa.value > '$fechaA'  AND b.`id` = ffechaa.`document_id` )";
$where1.="AND ( ffechaa.document_field_id=109 AND ffechaa.value > (CURDATE()-INTERVAL 1 MONTH)  AND b.`id` = ffechaa.`document_id` )";
}
else
{
$where1.="AND ( ffechaa.document_field_id=109 AND ffechaa.value >= (CURDATE()-INTERVAL 1 WEEK)  AND b.`id` = ffechaa.`document_id` )";
}
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
{// "no region<br>";
}else
{
$from1.=",`document_fields_link` as fregion ";

if($region=="Asia and South Pacific")
{// "no region<br>";
$where1.="AND ( fregion.document_field_id=110 AND ( fregion.value='Asia & South Pacific' OR fregion.value='ASIA AND SOUTH PACIFIC') AND b.`id` = fregion.`document_id` )";
}
else
if($region=="Egypt and Middle East")
{// "no region<br>";
$where1.="AND ( fregion.document_field_id=110 AND ( fregion.value='Egypt & Middle East' OR fregion.value='EGYPT AND MIDDLE EAST') AND b.`id` = fregion.`document_id` )";
}
else{


$where1.="AND ( fregion.document_field_id=110 AND fregion.value='".$region."' AND b.`id` = fregion.`document_id` )";
}
}

if($event=="")
{// "no event<br>";
}else
{

$from1.=",`document_fields_link` as fevent ";

if ($event=="Competitive Dynamic")
{
$where1.="AND ( fevent.document_field_id=136 AND  (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` )";
} else if ($event=="Technology")
{
$where1.="AND ( fevent.document_field_id=137 AND  (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` )";
} else if ($event=="Sustainability")
{
$where1.="AND ( fevent.document_field_id=139 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` )";
//$from1.=",`document_fields_link` as freactopic ";
//$where1.="AND (( fevent.document_field_id=139 AND  (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` ) OR ( freactopic.document_field_id=119 AND freactopic.value='Environment/Health' AND b.`id` = freactopic.`document_id` ) )";
} else if ($event=="Opportunities")
{
$where1.="AND ( fevent.document_field_id=183 AND  (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` )";
} else if ($event=="Corporate")
{
$where1.="AND ( fevent.document_field_id=138 AND  (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` )";
} else if ($event=="Reactions")
{
$where1.="AND ( fevent.document_field_id=186 AND  (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` )";
}

}

//*********

if($politik=="")
{
}
else
{
$where1.="AND ( ( fevent.document_field_id=273 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` AND fevent.value is not null)";
$where1.="OR ( fevent.document_field_id=276 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id`  AND fevent.value is not null)";
$where1.="OR ( fevent.document_field_id=274 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id`  AND fevent.value is not null)";
$where1.="OR ( fevent.document_field_id=275 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id`  AND fevent.value is not null))";

}



//********


if($action=="")
{// "no action<br>";
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
{// "no action<br>";
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
else if ($type=="AF. TDF(Tires)")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="AF Bio-Mass")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="AF. Indistrial Wastes")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="AF. Municipal Waste")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="NP. Low resource consumption")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="NP. Recyclers")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="NP. Low polluters / Env Quality Enchancers")
{
$where1.="AND ( ftype.document_field_id=126 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
}
else if ($type=="Training/ Education ")
{
$where1.="AND ( ftype.document_field_id=155 AND ftype.value='".$type."' AND b.`id` = ftype.`document_id` )";
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
{// "no action<br>";
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
{// "no action<br>";
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
{// "no reactiontype<br>";
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
{// "no reactiontopic<br>";
}else
{

$from1.=",`document_fields_link` as freactiontopic ";

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
$where1.="AND ( freactiontopic.document_field_id=119 AND ( freactiontopic.value='N/A') AND b.`id` = freactiontopic.`document_id` )";
}
}
//=====================

if($consequence=="")
{// "no consequence<br>";
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
{// "no actor<br>";
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
{// "no competidor<br>";
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


$where1.=")  AND b.`id` = fcompetidor.`document_id` )";
}



}




//header("Content-type: application/rss+xml");
//header("Content-Disposition: attachment; filename=report.csv");



//            Encabezado



/***
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
echo "\r\n";
echo "<?xml-stylesheet href=\"http://www.intelect.com.mx/legislativo/rss.css\" type=\"text/css\"?>"; //cambiar aqui
echo "\r\n";
echo "<rdf:RDF";
echo "\r\n";
echo "  xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"";
echo "\r\n";
echo "  xmlns:dc=\"http://purl.org/dc/elements/1.1/\"";
echo "\r\n";
echo "  xmlns=\"http://purl.org/rss/1.0/\"";
echo "\r\n";
echo "  xmlns:xhtml=\"http://www.w3.org/1999/xhtml\">";
echo "\r\n";

echo "<channel rdf:about=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss1.php\">"; 
echo "\r\n";

*/
// "    <title>Eventos Empresariales</title>";

echo "    <title>";
if ($region) {echo $region." ";}
if ($event) {echo $event;}
if ($reactiontopic=="Competitiveness" && $industria == "BUILDING MATERIALS"){echo "Antitrust";}
if ($reactiontopic=="Competitiveness" && $industria != "BUILDING MATERIALS"){echo "Antitrust in Other Industries";}
if ($reactiontopic=="Enviroment/Health"){echo "Environment Reactions";}
if ($region=="" && $event =="" && $reactiontopic != "Competitiveness" && $reactiontopic!="Enviroment/Health" ) {echo "Politics, Economics, Social and Contingencies ";}
echo "</title>";

/***
echo "\r\n";
echo "    <description>RSS 1.0 export from the B2B Events Records.</description>";
echo "\r\n";
echo "    <link>http://proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss1.php</link>"; //cambiar aqui
echo "\r\n";
echo "    <language>en_US</language>";
echo "\r\n";
echo "    <items>";
echo "\r\n";
echo "      <rdf:Seq>";
echo "\r\n";
**/
// Fin de Encabezado

//listado rdf
$busq_links="SELECT distinct b.`id` FROM (select id,modified from `documents` where `document_type_id`=55  AND `status_id`<=2) as b ".$from1." WHERE 1 ".$where1." order by b.modified DESC ";

$busq_links1 = mysql_query($busq_links);

/***

 while ($busq_links2 = mysql_fetch_row($busq_links1))
{  //while busqlinks2

echo "<rdf:li rdf:resource=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/control.php?action=getfeventb2b&amp;letra=".$busq_links2[0]."\"/>";
echo "\r\n";

}
echo "    </rdf:Seq>";
echo "\r\n";
echo "    </items>";
echo "\r\n";

echo "  </channel>";
echo "\r\n";
**/
//fin listado rdf




/***

echo "\"  Date \",";
echo "\" Region \",";   //**
echo "\" Country \",";
echo "\" City \",";   //**
echo "\" Plant \",";   //**
echo "\"Competitor \",";
echo "\" Is Competitive Dynamic ? \",";   //**
echo "\"Competitive Dynamic Action \",";   //**
echo "\"Competitive Dynamic Sector \",";   //**
echo "\"Competitive Dynamic SP \",";   //**
echo "\"It is an opportumity ? \",";   //**
echo "\"Opp. Action \",";   //**
echo "\"Opp. Type \",";   //**
echo "\" Is it Corporate ? \",";   //**
echo "\"Type Corporate Event \",";   //**
echo "\"Gross Profit \",";   //**
echo "\"Operating Income \",";   //**
echo "\"Net Revenue \",";   //**
echo "\"EBITDA \",";   //**
echo "\"Total Income \",";   //**
echo "\"Is it Sustainability ?\",";   //**
echo "\"Sustainability Action \",";   //**
echo "\"Sustainability Type \",";   //**
echo "\"Sustainability Theme \",";   //**
echo "\"Is it Technology ? \",";   //**
echo "\"Technology Action \",";   //**
echo "\"Technology Type \",";   //**
echo "\"Technology Description \",";   //**
echo "\"Is it Reaction ? \",";   //**
echo "\"Reaction Type \",";   //**
echo "\"Reaction Topic \",";   //**
echo "\"Reaction Consequence \",";   //**
echo "\"Reaction Actor \",";   //**
echo "\"Additional Capacity \",";   //**
echo "\"Amount \",";   //**
echo "\"Type of Source \",";   //**
echo "\"Summary \",";   //**
echo "\"Complete Note \",";   //**
echo "\"Related Individual \",";   //**
echo "\"Source \"";   //**
// echo "\"Event Type \",";
// echo "\"Action \",";
// echo "\"Action Type \",";
// echo "\"-3- \",";
// echo "\"-4- \",";
// echo "\"R. Individual(s) \",";
// echo "\"Institute \"";
echo "\r\n"; ***/
$insmod=0;
   
$busq_links="SELECT distinct b.`id` FROM (select id,modified from `documents` where `document_type_id`=55  AND `status_id`<=2) as b ".$from1." WHERE 1 ".$where1." order by b.modified DESC ";

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

 if ($indv_rel2[2]==273 ){
   $ispoli=$indv_rel2[3];

} 
 if ($indv_rel2[2]==274 ){
   $isecon=$indv_rel2[3];

} 
 if ($indv_rel2[2]==276 ){
   $iscont=$indv_rel2[3];

} 
 if ($indv_rel2[2]==275 ){
   $issoci=$indv_rel2[3];

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

     
}//si value es mayor a 0 arriba si no abajo

}








//**********

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
    $pnt="Technology";}
else{
    $pnt="";}

}
 if ($indv_rel2[2]==138 ){
    $corp=$indv_rel2[3];
if ($corp=="Yes"){
 $pncrp="Corporate";}
else {  $pncrp="";}

}
if ($indv_rel2[2]==139){
    $sust=$indv_rel2[3];
    if ($sust=="Yes"){
      $pnsust="Sustainability";}
else {
      $pnsust="";}
}

if ($indv_rel2[2]==186){
    $react=$indv_rel2[3];
    if ($react=="Yes"){
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
    if ($react=="Yes"){
      $col5react="React.";}
    else {
      $col5react="";}}

 if ($indv_rel2[2]==183){
    $oppo=$indv_rel2[3];
    if ($oppo=="Yes"){
      $col5oppo="Opp.";}
else {
      $col5oppo="";}}

 if ($indv_rel2[2]==139){
    $susta=$indv_rel2[3];
    if ($susta=="Yes"){
      $col5susta="Sust.";}
else {
      $col5susta="";}}

if ($indv_rel2[2]==136){
    $compe=$indv_rel2[3];
    if ($compe=="Yes"){
      $col5compe="CD.";}
else {
      $col5compe="";}}

if ($indv_rel2[2]==137){
    $techn=$indv_rel2[3];
    if ($techn=="Yes"){
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
    if ($corpo=="Yes"){
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

$pretit="";
if ($politik!=""){
if($ispoli!=""){$pretit=" -Politics- ";}
if($issoci!=""){$pretit=" -Social- ";}
if($isecon!=""){$pretit=" -Economics- ";}
if($iscont!=""){$pretit=" -Contingency- ";}
}

$storend.="<table border='1' width=651px height=60%  align='center' cellspacing='2' cellpadding='2'>";
$storend.="<tr><td><font face='Arial' size='3'><a href=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/control.php?action=getquince2&amp;letra=".$busq_links2[0]."\">";
$sumsql=str_replace('"',"'",$summarysql);
$sumsql2=txt2html($pretit." ".$sumsql);
$storend.=$sumsql2."</a></font>";
$compnsql=str_replace('"',"'",$compnotesql);

$comphtml=txt2html($compnsql);

$storend.= "<font face='Arial' size='2'>".substr($comphtml,0,200);  //ex 2
$storend.="...<a href=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/control.php?action=getquince2&amp;letra=".$busq_links2[0]."\">Ver m&aacute;s</a>";
$storend.= "</font></td></tr></table>";


}

//Fin de RSS

echo imprime_web($storend);
}

//=============>>> FUNCION ORIGINAL ==================>>>

function stri_replace( $find, $replace, $string ) {
// Case-insensitive str_replace()

  $parts = explode( strtolower($find), strtolower($string) );

  $pos = 0;

  foreach( $parts as $key=>$part ){
    $parts[ $key ] = substr($string, $pos, strlen($part));
    $pos += strlen($part) + strlen($find);
  }

  return( join( $replace, $parts ) );
}


function txt2html($txt) {
// Transforms txt in html

  //Kills double spaces and spaces inside tags.
  while( !( strpos($txt,'  ') === FALSE ) ) $txt = str_replace('  ',' ',$txt);
  $txt = str_replace(' >','>',$txt);
  $txt = str_replace('< ','<',$txt);

  //Transforms accents in html entities.
  $txt = htmlentities($txt);

  //We need some HTML entities back!
  $txt = str_replace('&quot;','"',$txt);
 $txt = str_replace("&amp;#8217;","&rsquo;",$txt);
$txt = str_replace("&amp;#8232;","&rsquo;",$txt);
  $txt = str_replace("\x92","&rsquo;",$txt);
$txt = str_replace("\x93","&quot;",$txt);
$txt = str_replace("\x94","&quot;",$txt);
$txt = str_replace("\x96","&quot;",$txt);
$txt = str_replace("\x97","&quot;",$txt);
$txt = str_replace("\x99"," ",$txt);
$txt = str_replace("\x80","Euros ",$txt);
  $txt = str_replace('&lt;','<',$txt);
  $txt = str_replace('&gt;','>',$txt);
  $txt = str_replace('&amp;','&',$txt);

  //Ajdusts links - anything starting with HTTP opens in a new window
  $txt = stri_replace("<a href=\"http://","<a target=\"_blank\" href=\"http://",$txt);
  $txt = stri_replace("<a href=http://","<a target=\"_blank\" href=http://",$txt);

  //Basic formatting
  $eol = ( strpos($txt,"\r") === FALSE ) ? "\n" : "\r\n";
  $html = '<p>'.str_replace("$eol$eol","</p><p>",$txt).'</p>';
  $html = str_replace("$eol","<br />\n",$html);
  $html = str_replace("</p>","</p>\n\n",$html);
  $html = str_replace("<p></p>","<p>&nbsp;</p>",$html);

  //Wipes <br> after block tags (for when the user includes some html in the text).
  $wipebr = Array("table","tr","td","blockquote","ul","ol","li");

  for($x = 0; $x < count($wipebr); $x++) {

    $tag = $wipebr[$x];
    $html = stri_replace("<$tag><br />","<$tag>",$html);
    $html = stri_replace("</$tag><br />","</$tag>",$html);

  }

  return $html;
}

//<<<<=================TERMINA FUNCION ORIGINAL <<<==================


function imprime_web($mistring)
{

$imphtml= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";

  $imphtml.= "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\" xml:lang=\"en\">";
    $imphtml.= "<head>";
      
  
  $imphtml.= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-15\" />";
  $imphtml.= "<meta name=\"generator\" content=\"Nuxeo CPS http://www.cps-project.org/\" />";
  $imphtml.= "<title>";

$imphtml.= "PESC";

  $imphtml.= "</title>";
  //$imphtml.= "<base href=\"http://boletin.intelect.com.mx/\" />";
  $imphtml.= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" title=\"CPSDefault styles\" href=\"default.css\" />";
  
  $imphtml.= "<!--[if IE]>";$imphtml.= "<link rel=\"stylesheet\" type=\"text/css\" href=\"msie.css\" />";
  $imphtml.= "<![endif]-->";
  $imphtml.= "<link rel=\"stylesheet\" type=\"text/css\" media=\"print\" href=\"default_print.css\" />";
  $imphtml.= "<meta http-equiv=\"imagetoolbar\" content=\"no\" />";
  
  
  
  
  
  $imphtml.= "<script type=\"text/javascript\" src=\"functions.js\">";
  $imphtml.= "</script>";

      
$imphtml.= "<meta name=\"engine\" content=\"CPSSkins 2.3\" />";
$imphtml.= "<!-- Shortcut icon -->";
$imphtml.= "<link rel=\"icon\" href=\"cpsicon.png\" type=\"image/png\" />";
$imphtml.= "<link rel=\"shortcut icon\" href=\"cpsicon.png\" type=\"image/png\" />";

$imphtml.= "<!-- CSS1 -->";
$imphtml.= "<link rel=\"Stylesheet\" type=\"text/css\" href=\"cpsskins_common.css\" />";
$imphtml.= "<link rel=\"Stylesheet\" type=\"text/css\" href=\"renderCSS.css\" />";
$imphtml.= "<!-- CSS2 -->";
$imphtml.= "<style type=\"text/css\" media=\"all\">";

$imphtml.= "@import url(cpsskins_common-css2.css);";

$imphtml.= "</style>";
$imphtml.= "<!-- JavaScript -->";
$imphtml.= "<script type=\"text/javascript\" src=\"renderJS\">";
$imphtml.= "</script>";
$imphtml.= "<script type=\"text/javascript\" src=\"cpsskins_renderJS\">";
$imphtml.= "</script>";
$imphtml.= "</head>";
    
  //  $imphtml.= "<body onload=\"setFocus();\" style=\"margin:0.5em\">";
      
  $imphtml.= "<div>";
//$imphtml.= "<a href=\"http://boletin.intelect.com.mx/accessibility\" accesskey=\"0\">";
//$imphtml.= "</a>";
//$imphtml.= "<a href=\"http://boletin.intelect.com.mx/\" accesskey=\"1\">";
//$imphtml.= "</a>";
//$imphtml.= "<a href=\"#content\" accesskey=\"2\">";
//$imphtml.= "</a>";
//$imphtml.= "<a href=\"#menu\" accesskey=\"3\">";
//$imphtml.= "</a>";
//$imphtml.= "<a href=\"http://boletin.intelect.com.mx/advanced_search_form\" accesskey=\"4\">";
//$imphtml.= "</a>";
//$imphtml.= "<a href=\"http://boletin.intelect.com.mx/\" accesskey=\"7\">";
//$imphtml.= "</a>";
//$imphtml.= "</div>";
  
    $imphtml.= "<table cellpadding=\"0\" cellspacing=\"0\" summary=\"Aviso\" style=\"width:100%;\" class=\"shapeNoBorder colorTransparent\">";
       $imphtml.= "<tr>";
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:650px\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
      $imphtml.= "</tr>";
    $imphtml.= "</table>";
  
  
    $imphtml.= "<table cellpadding=\"0\" cellspacing=\"0\" summary=\"Banner\" style=\"width:100%;\" class=\"shapeNoBorder colorTransparent\">";
       $imphtml.= "<tr>";
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:650px\">";
              
                
              
              
                
                  $imphtml.= "<div style=\"text-align: left;\" class=\"colorTransparent fontColorBlack fontShapeVerdana shapeNoBorder\">";
                    $imphtml.= "<img src=\"cenefaSIUC.jpg\" width=\"649\" height=\"147\" alt=\"1\" />";
                    
                  $imphtml.= "</div>";
                
              
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
      $imphtml.= "</tr>";
    $imphtml.= "</table>";
  
  
    $imphtml.= "<table cellpadding=\"0\" cellspacing=\"0\" summary=\"Contenido 4 a\" style=\"width:100%;\" class=\"shapeNoBorder colorTransparent\">";
       $imphtml.= "<tr>";
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          /****
            $imphtml.= "<td valign=\"top\" style=\"width:135px\" class=\"shapeNoBorder colorBlanco\">";
              
                
                  $imphtml.= "<div style=\"text-align: left;padding:0.;\" class=\"\">";
                    $imphtml.= "<table >";
                    $imphtml.= "<tr  >";
                    $imphtml.= "<td bgcolor=\"#999999\" valign=\"top\">";
                    $imphtml.= "<p style=\"width: 135px;\" >";
                    $imphtml.= "<font color=\"#ffffff\" face=\"Tahoma, Arial, Helvetica, sans-serif\" size=\"4\">"; //ex1
$imphtml.= "<a href=\"/publico/workspaces/boleblog/entorno-de-competencia7399\">";

$imphtml.= "Entorno de Competencia Nacional";

$imphtml.= "</a>";
$imphtml.= "</font>";
$imphtml.= "</p>";
$imphtml.= "</td>";
$imphtml.= "</tr>";
$imphtml.= "</table>"; 
$imphtml.= "<table >";
$imphtml.= "<tr  >";
$imphtml.= "<td bgcolor=\"#999999\" valign=\"top\">";
$imphtml.= "<p style=\"width: 135px;\" >";
$imphtml.= "<font color=\"#ffffff\" face=\"Tahoma, Arial, Helvetica, sans-serif\" size=\"4\">"; //ex 1
$imphtml.= "<a href=\"/publico/workspaces/boleblog/entorno-de-competencia\">";

$imphtml.= "Entorno de Competencia Internacional";

$imphtml.= "</font>";
$imphtml.= "</p>";
$imphtml.= "</td>";
$imphtml.= "</tr>";
$imphtml.= "</table>"; 
$imphtml.= "<table >";
$imphtml.= "<tr  >";
$imphtml.= "<td bgcolor=\"#999999\" valign=\"top\">";
$imphtml.= "<p style=\"width: 135px;\" >";
$imphtml.= "<font color=\"#ffffff\" face=\"Tahoma, Arial, Helvetica, sans-serif\" size=\"4\">"; //ex 1
$imphtml.= "<a href=\"/publico/workspaces/boleblog/corporativo-nacional-e\">";

$imphtml.= "Corporativo";

$imphtml.= "</a>";
$imphtml.= "</font>";
$imphtml.= "</p>";
$imphtml.= "</td>";
$imphtml.= "</tr>";
$imphtml.= "</table>"; 
$imphtml.= "<table >";
$imphtml.= "<tr  >";
$imphtml.= "<td bgcolor=\"#999999\" valign=\"top\">";
$imphtml.= "<p style=\"width: 135px;\" >";
$imphtml.= "<font color=\"#ffffff\" face=\"Tahoma, Arial, Helvetica, sans-serif\" size=\"4\">"; //ex1
$imphtml.= "<a href=\"/publico/workspaces/boleblog/mercados-nacional-e\">";

$imphtml.= "Finanzas";

$imphtml.= "</a>";
$imphtml.= "</font>";
$imphtml.= "</p>";
$imphtml.= "</td>";
$imphtml.= "</tr>";
$imphtml.= "</table>";
                    
                  $imphtml.= "</div>";
                
              
            $imphtml.= "</td>";
          
        
        ***/
          
            $imphtml.= "<td valign=\"top\" style=\"width:651px\" class=\"shapeNoBorder colorBlanco\">";
              
$imphtml.= $mistring;




     $imphtml.= "</td>";
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          $imphtml.= "</tr>";
$imphtml.= "</table>";
  
  
  
  
    $imphtml.= "<table cellpadding=\"0\" cellspacing=\"0\" summary=\"Footer 20\" style=\"width:100%;\" class=\"shapeNoBorder colorTransparent\">";
       $imphtml.= "<tr>";
       $imphtml.= "<td valign=\"top\" style=\"width:30%\"  class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:650px\"   class=\"shapeNoBorder colorTransparent\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\"  class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
      $imphtml.= "</tr>";
    $imphtml.= "</table>";
  
  
    $imphtml.= "<table cellpadding=\"0\" cellspacing=\"0\"  summary=\"Disclainer 21\" style=\"width:100%;\"  class=\"shapeNoBorder colorTransparent\">";
       $imphtml.= "<tr>";
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:650px\" class=\"shapeNoBorder colorGris\">";
              
                
                 // $imphtml.= "<div style=\"text-align: left;\"  class=\"colorGris\">";
                  
//$imphtml.= "  Para cancelar su suscripción, suspender temporalmente este envío, modificar sus datos o correo electrónico";
//$imphtml.= " envíe un mensaje a la dirección de correo conred@cred.com.mx indicando los detalles que desee modificar y con gusto atenderemos su petición.";
                    
                //  $imphtml.= "</div>";
                
              
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\"  class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
      $imphtml.= "</tr>";
    $imphtml.= "</table>";
  

    $imphtml.= "</body>";
  $imphtml.= "</html>";

return $imphtml;

}


?>
