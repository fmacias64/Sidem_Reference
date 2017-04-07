<?php

require_once("../../../../config/dmsDefaults.php");

require_once("getipadpescf.php");
require_once("../../../../lib/util/sanitize.inc");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");

function listanotas($letra,$nota,$region,$event,$action,$type,$competitive,$sustainability,$reactiontype,$reactiontopic,$consequence,$actor,$competidor,$industria,$subindustria,$parampais,$ano,$notime,$fecha1,$fecha2,$apartir,$cuantos,$titulo,$elque) 
{ 
$cuenta =0;
$storend="";
$imphtml2.="";
$boolnota=0;
$echoactor=0;
$where1 = "";
$from1="";
 $letram=strtoupper($letra);
   $letrasar= explode("_",$letram);

$politik="";
$economic="";
$disasters="";
$social="";
$pretit="";

if ($elque==1){$politik="1";}
if ($elque==2){$social="1";}
if ($elque==3){$economic="1";}
if ($elque==4){$disasters="1";}


if ($politik!="" or $social!="" or $economic!="" or $disasters!=""){$from1.=",`document_fields_link` as fevent ";}

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
{
}else
{
$boolpais=1;


$from1.=  ",(select flugar.document_id,fpais.cinco from";
$from1.= " (select * from `document_fields_link` where";
$from1.= " document_field_id=161) as flugar left join ";
$from1.= "(select id,cinco from `Lugares`.`Lugares` where ";
$from1.= "cinco = $parampais) as fpais on ";
$from1.= "flugar.value=fpais.id ) as paisq ";
$where1.= " AND (  b.`id` = paisq.`document_id` and  paisq.cinco=$parampais)";

}


if($industria=="")
{
}else
{
$boolnota=1;


$from1.=  ",(select fcompetidorind.document_id,find_competidor.value from";
$from1.= " (select * from `document_fields_link` where";
$from1.= " document_field_id=142) as fcompetidorind left join ";
$from1.= "(select * from `document_fields_link` where ";
$from1.= "document_field_id=76) as find_competidor on ";
$from1.= "fcompetidorind.value=find_competidor.document_id ) as paqind ";
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
$where1.= " AND (  b.`id` = paqsind.`document_id` AND  paqsind.value = '".$subindustria."')";


}

//SubIndustria




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
$where1.="AND ( ffechaa.document_field_id=109 AND ffechaa.value > (CURDATE()-INTERVAL 2 WEEK)  AND b.`id` = ffechaa.`document_id` )";
}
else if($notime==2)
{
$where1.="AND ( ffechaa.document_field_id=109 AND ffechaa.value > (CURDATE()-INTERVAL 2 DAY)  AND b.`id` = ffechaa.`document_id` )";
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
{
}else
{
$from1.=",`document_fields_link` as fregion ";

if($region=="Asia and South Pacific")
{
$where1.="AND ( fregion.document_field_id=110 AND ( fregion.value='Asia & South Pacific' OR fregion.value='ASIA AND SOUTH PACIFIC') AND b.`id` = fregion.`document_id` )";
}
else
if($region=="Egypt and Middle East")
{
$where1.="AND ( fregion.document_field_id=110 AND ( fregion.value='Egypt & Middle East' OR fregion.value='EGYPT AND MIDDLE EAST') AND b.`id` = fregion.`document_id` )";
}
else{


$where1.="AND ( fregion.document_field_id=110 AND fregion.value='".$region."' AND b.`id` = fregion.`document_id` )";
}
}

if($event=="")
{
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
$where1.="AND ( fevent.document_field_id=273 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id` AND fevent.value is not null)";
}

if ( $social=="" )
{
}
else
{
$where1.="AND ( fevent.document_field_id=275 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id`  AND fevent.value is not null)";

}

if ( $economic=="")
{
}
else
{
$where1.="AND ( fevent.document_field_id=274 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id`  AND fevent.value is not null)";

}

if ($disasters=="")
{
}
else
{
$where1.="AND ( fevent.document_field_id=276 AND (fevent.value='Yes' OR  fevent.value='YES') AND b.`id` = fevent.`document_id`  AND fevent.value is not null)";

}



//********


if($action=="")
{
}else
{//else

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
{
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

if($competitive=="")
{
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
if($sustainability=="")
{
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

if($reactiontype=="")
{
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
{
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

if($consequence=="")
{
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
{
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
$where1.=" OR fcompetidor.value='3192'";
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


$unstr= "    <title> eee ";
if ($region) {$unstr.= $region." ";}
if ($event) {$unstr.=$event;}
if ($reactiontopic=="Competitiveness" && $industria == "BUILDING MATERIALS"){$unstr.= "Antitrust";}
if ($reactiontopic=="Competitiveness" && $industria != "BUILDING MATERIALS"){$unstr.= "Antitrust in Other Industries";}
if ($reactiontopic=="Enviroment/Health"){$unstr.= "Environment Reactions";}
if ($region=="" && $event =="" && $reactiontopic != "Competitiveness" && $reactiontopic!="Enviroment/Health" ) {$unstr.= "Beverages, Food and Tobacco";}
$unstr.= "</title>";

$busq_links="SELECT distinct b.id FROM (select id,modified from documents where document_type_id = 38 AND status_id <= 2 ) as b ".$from1." WHERE 1 ".$where1." order by b.modified DESC";


$otrostr=$busq_links;
$busq_links1 = mysql_query($busq_links);
//return $otrostr;

$insmod=0;


//$imphtml2.= "					busqlinks ".$busq_links." cuenta,cuantos ".$cuenta.",".$cuantos;

 while (($busq_links2 = mysql_fetch_row($busq_links1)) && ($cuenta <= $cuantos) )
{  //while busqlinks2

if ($cuenta==0)
{ 

$preliga.= "<a href='http://proveedores.intelect.com.mx/FichasBD/branches/SY/control.php?action=getipadpescl";

if ($letra) $preliga.= "&letra=".$letra;
if ($nota) $preliga.= "&nota=".$nota;
if ($region) $preliga.= "&region=".$region;
if ($event) $preliga.= "&event=".$event;
if ($action) $preliga.= "&action=".$action;
if ($type) $preliga.= "&type=".$type;
if ($competitive) $preliga.= "&competitive=".$competitive;
if ($sustainability) $preliga.= "&sustainability=".$sustainability;
if ($reactiontype) $preliga.= "&reactiontype=".$reactiontype;
if ($reactiontopic) $preliga.= "&reactiontopic=".$reactiontopic;
if ($consequence) $preliga.= "&consequence=".$consequence;
if ($actor) $preliga.= "&actor=".$actor;
if ($competidor) $preliga.= "&competidor=".$competidor;

if ($industria) $preliga.= "&industry=".$industria;
if ($subindustria) $preliga.= "&subindustry=".$subindustria;
if ($parampais) $preliga.= "&pais=".$parampais;
if ($notime) $preliga.= "&notime=".$notime;
if ($apartir) $preliga.= "&apartir=".$apartir;
if ($cuantos) $preliga.= "&cuantos=".$cuantos;
if ($titulo) $preliga.= "&titulo=".$titulo;
if ($elque) $preliga.= "&elque=".$elque;


if ($ano) $preliga.= "&ano=".$ano;
if ($fecha1) $preliga.= "&fecha1=".$fecha1;
if ($fecha2) $preliga.= "&fecha2=".$fecha2;

$preliga.= "' >";





$imphtml2.="<center><h1>".$preliga.$titulo."</a></h1></center>";
$imphtml2.= "					<div style=\"clear: both;\">&nbsp;</div>";
}
$cuenta++; 
$insmod++; 
  $modd=$insmod%2;
  $red=220*$modd-255*($modd-1);
  $green=220*$modd-255*($modd-1);
  $blue=220*$modd-255*($modd-1);
$oDocument = & Document::get($busq_links2[0]);

 

 



$indv_rel= "SELECT * FROM `document_fields_link` WHERE `document_field_id`<> 1  AND (document_field_id=161 or document_field_id=109 or document_field_id=142 or document_field_id=164  or document_field_id=113 or document_field_id=115 or document_field_id=114 or document_field_id=273 or document_field_id=274 or document_field_id=276 or document_field_id=275) AND `document_id`=".$busq_links2[0];
$indv_rel1 = mysql_query($indv_rel);


 while ($indv_rel2 = mysql_fetch_row($indv_rel1))
{  //whileinvrel

 
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


if ($indv_rel2[2]==164){
   $typesourcsql=$indv_rel2[3];
}
if ($indv_rel2[2]==113){
   $summarysql=$indv_rel2[3];
}

if ($indv_rel2[2]==115){
   $sourcesql=$indv_rel2[3];
}


if ($indv_rel2[2]==114){
   $compnotesql=$indv_rel2[3];
}

}


$pretit="";
if ($politik!=""){
if($ispoli!=""){$pretit=" -Politics- ";}
}
if ($social!=""){
if($issoci!=""){$pretit=" -Social- ";}
}
if ($economic!=""){
if($isecon!=""){$pretit=" -Economics- ";}
}
if ($disasters!=""){
if($iscont!=""){$pretit=" -Contingency- ";}
}

$sumsql=str_replace('"',"'",$summarysql);
$sumsql2=txt2html($pretit." ".$sumsql);


//$imphtml2.=$indv_rel;
$imphtml2.="	<div class=\"post\">";
 $imphtml2.= "					<h2 class=\"title\">".$fech."&nbsp;&nbsp;<a href=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/control.php?action=getipadpesc2&amp;letra=".$busq_links2[0]."
\">".$sumsql2." </a></h2>";

 $imphtml2.= "					<div class=\"entry\">";
 $imphtml2.= "					<span class=\"posted\"><a href=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/control.php?action=getipadpesc2&amp;letra=".$busq_links2[0]."\">Read More</a>    </span>";

 $imphtml2.= "					</div>"; 
 $imphtml2.= "				</div>";





if ($politik!=""){
if($ispoli!=""){$pretit.=" -Politics- ";}
}
if ($social!=""){
if($issoci!=""){$pretit.=" -Social- ";}
}
if ($economic!=""){
if($isecon!=""){$pretit.=" -Economics- ";}
}
if ($disasters!=""){
if($iscont!=""){$pretit.=" -Contingency- ";}
}

$storend.="<table border='0'>";
//$storend.="<tr><td>".$otrostr."</td></tr>";
$storend.="<tr><td><font face='Arial' size='5'><a href=\"http://proveedores.intelect.com.mx/FichasBD/branches/SY/control.php?action=getipadpesc2&amp;letra=".$busq_links2[0]."\">";
$sumsql=str_replace('"',"'",$summarysql);
$sumsql2=txt2html($pretit." el pretite ".$sumsql);
$storend.="dsdsdsd</a></font>";

$storend.= "</td></tr></table>";



}

return $imphtml2;
}



function imprime_web2($mistring,$mistring2)
{


 $imphtml.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";
 $imphtml.= "<!--";
 $imphtml.= "Design by Free CSS Templates";
 $imphtml.= "http://www.freecsstemplates.org";
 $imphtml.= "Released for free under a Creative Commons Attribution 2.5 License";

 $imphtml.= "Name       : Impeccable   ";
 $imphtml.= "Description: A two-column, fixed-width design with dark color scheme.";
 $imphtml.= "Version    : 1.0";
 $imphtml.= "Released   : 20101129";

 $imphtml.= "-->";
 $imphtml.= "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
 $imphtml.= "<head>";

 $imphtml.= "<meta name=\"keywords\" content=\"\" />";
 $imphtml.= "<meta name=\"description\" content=\"\" />";
 $imphtml.= "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />";
 $imphtml.= "<title>Impeccable    by Free CSS Templates</title>";
 $imphtml.= "<link href=\"styleipadpesc.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
 $imphtml.= "</head>";
 $imphtml.= "<body>";
 $imphtml.= "<div id=\"wrapper\">";
 $imphtml.= "<div id=\"page\">";
 $imphtml.= "	<div id=\"page-bgtop\">";
 $imphtml.= "		<div id=\"page-bgbtm\">";
 $imphtml.= "			<div id=\"content\">";
$imphtml.="$mistring";

 //$imphtml.= "				<div style=\"clear: both;\">&nbsp;</div>";
 $imphtml.= "			</div>";
 $imphtml.= "			<!-- end #content -->";
 $imphtml.= "			<div class=\"content\" id=\"sidebar\">";
 

//******
//*****

$imphtml.=$mistring2;
 
$imphtml.= "			</div>";
 $imphtml.= "			<!-- end #sidebar -->";
 $imphtml.= "			";
 //$imphtml.= "			<div id=\"footer\">";
 //$imphtml.= "				<p>Copyright (c) 2010 Sitename.com. All rights reserved. Design by <a href=\"http://www.freecsstemplates.org/\"> CSS Templates</a>.</p>";
 //$imphtml.= "			</div>";
 $imphtml.= "		</div>";
 $imphtml.= "	</div>";
 $imphtml.= "	<!-- end #page -->";
 $imphtml.= "</div>";
 $imphtml.= "<!-- end #footer -->";
 $imphtml.= "</body>";
 $imphtml.= "</html>";
//return $imphtml;


//******************
return $imphtml;

}
?>
