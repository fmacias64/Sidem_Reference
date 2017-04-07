<?php

require_once("../../../../config/dmsDefaults.php");



if (checkSession()) {
$va=system('sh /usr/local/bolevb2b_scripts/actedgr.sc',$retval);
echo $retval;
echo $va;

 }

 ?>