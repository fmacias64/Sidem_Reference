<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

system("/usr/bin/snapshotTOTAL"); 

header("Location:http://webapp.intelect.com.mx/RSSOS/Total/proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss1.php");

 }

 ?>