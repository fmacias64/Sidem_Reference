<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

system("/usr/bin/snapshotEUROPE"); 

header("Location:http://webapp.intelect.com.mx/RSSOS/Europe/proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss1.php@industry=BUILDING%20MATERIALS&region=Europe");

 }

 ?>