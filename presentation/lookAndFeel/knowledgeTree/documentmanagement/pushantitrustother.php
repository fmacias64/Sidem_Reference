<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {

system("/usr/bin/snapshotANTITRUSTOTHER"); 

header("Location:http://webapp.intelect.com.mx/RSSOS/Competitiv/proveedores.intelect.com.mx/FichasBD/branches/SY/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss1.php@reactiontopic=Competitiveness");

 }

 ?>