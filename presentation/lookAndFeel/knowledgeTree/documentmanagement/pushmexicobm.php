<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

system("/usr/bin/snapshotMEXICOBM"); 

header("Location:http://webapp.intelect.com.mx/RSSOS/MEXICOBM/proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss1.php@industry=BUILDING%20MATERIALS&pais=138&notime=1");

 }

 ?>