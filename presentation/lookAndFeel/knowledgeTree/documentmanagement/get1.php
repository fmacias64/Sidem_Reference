
<?php

require_once("../../../../config/dmsDefaults.php");



echo '<form name="loginForm" action="http://www.intelect.com.mx:82/~FichasBD/branches/fichas_alpha/presentation/login.php" method="post">';
echo "\n";   
echo '    	<input type="hidden" name="fUserName" value="admin" size="35"></td>';
echo "\n";    
 echo '   <input type="hidden" name="fPassword" size="35" value="admin">';
echo "\n";    
   echo ' <input type="hidden" name="redirect" value="/"/>';
echo "\n";   
echo ' <input type="hidden" name="loginAction" value="login">';
echo "\n";
    echo '<input type="hidden" name="cookietestinput" value="E1X0PDYR85CAI4U5">';
echo "\n";
echo '<script type="text/javascript">';
echo "\n"; 
echo 'return submitenter(this,event);';
echo "\n";
echo '</script>';
echo "\n";
echo '</form>';
echo 'hols';

?>