<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

system("/usr/bin/snapshotEGYPT"); 

header("Location:http://webapp.intelect.com.mx/RSSOS/EGYPT/proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss1.php@industry=BUILDING%20MATERIALS&region=Egypt%20and%20Middle%20East");

 }

 ?>