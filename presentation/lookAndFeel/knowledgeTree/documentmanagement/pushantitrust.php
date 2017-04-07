<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

system("/usr/bin/snapshotANTITRUST"); 

header("Location:http://webapp.intelect.com.mx/RSSOS/Competitiveness/proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss1.php@industry=BUILDING%20MATERIALS&reactiontopic=Competitiveness
");

 }

 ?>