<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

system("/usr/bin/snapshotASIA"); 

header("Location:http://webapp.intelect.com.mx/RSSOS/ASIA/proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss1.php@industry=BUILDING%20MATERIALS&region=Asia%20and%20South%20Pacific
");

 }

 ?>