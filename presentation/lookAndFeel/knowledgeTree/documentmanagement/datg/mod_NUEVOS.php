<?php 
  require_once('connectionManager.php'); ?>
<?php $ident = $_GET["id"]; ?>
<?php

$elesql=$_GET["sql"];
echo $elesql;
//$connectionManager=$_SESSION['BD'];

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//cambiar abajo por update

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") )  {
$insertSQL = sprintf("update Tweets set 
                      calificador=%s where Id = %s"
                    ,
                       GetSQLValueString($_POST['calificador'], "text"),
                       $ident);
echo $insertSQL;
echo "eeeeee";
  mysql_select_db($database_connectionManager, $connectionManager);
  $Result1 = mysql_query($insertSQL, $connectionManager) or die(mysql_error());


if ($_POST['Submit'])
{
  $insertGoTo = "cierra.html";
}



else if ($_POST['Submit3'])
{
  


}


else if ($_POST['Submit2'])
{
$sigueSQL="select id from Tweets where id >".$ident." limit 0,1";
mysql_select_db($database_connectionManager, $connectionManager);
  $ress = mysql_query($sigueSQL, $connectionManager) or die(mysql_error());
 $ress1 = mysql_fetch_row($ress);
$insertGoTo = "mod_NUEVOS.php";
$_SERVER['QUERY_STRING']="id=".$ress1[0];
} 

 if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>


<title>Calificaci&oacute;n Tweet</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">

<?php header("Pragma: no-cache"); ?>
<script type="text/javascript" src="/buscatweet/ajax.js"></script>

<script type="text/javascript" src="/buscatweet/ajax-dynamic-list.js"></script>

  <style type="text/css">
<!--
body {
margin-left: 0px;
margin-top: 0px;
margin-right: 0px;
margin-bottom: 0px;
}
body,td,th {
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 12px;
}
.style1 {
color: #FFFFFF;
font-weight: bold;
}
.borde {
border: 1px solid #CCCCCC;
}
#ajax_listOfOptions{
  position:absolute;  
  width:175px;  
  height:250px; 
  overflow:auto; 
  border:1px solid #317082; 
  background-color:#FFF;  
  text-align:left;
  font-size:0.9em;
  z-index:100;
}
#ajax_listOfOptions div{ 
  margin:1px;    
  padding:1px;
  cursor:pointer;
  font-size:0.9em;
}
#ajax_listOfOptions .optionDiv{ 
  
}
#ajax_listOfOptions .optionDivSelected{ 
  background-color:#317082;
  color:#FFF;
}
#ajax_listOfOptions_iframe{
  background-color:#F00;
  position:absolute;
  z-index:5;
}
-->
  </style>
</head>
<body>


<div align="center">
<form name="form1" method="post" action="<?php echo $editFormAction; ?>">
  <table class="borde" border="0" cellpadding="5" cellspacing="0"
 width="500">
    <tbody>
      <tr bgcolor="#003399">
							<td width="50%"><span class="style1">Califica Tweet<br>
<?php  mysql_select_db($database_connectionManager, $connectionManager);   $cuenta= mysql_query("select count(*) from Tweets", $connectionManager) or die(mysql_error()); $cuenta1 = mysql_fetch_row($cuenta); echo "Total de Tweets:".$cuenta1[0];
echo "  "; echo " Id de Tweet:".$ident; ?></span></td>
						</tr>

<tr><td bgcolor="#99ccff"><strong>Texto </strong></td>
						</tr>
      <tr>
							<td><h3><?php  
                                mysql_select_db($database_connectionManager, $connectionManager);  
                                $vp01= mysql_query("select `text` from Tweets where id=$ident", $connectionManager) or die(mysql_error()); 
                                $v2p01 = mysql_fetch_row($vp01); if ($v2p01[0]!="") {echo "$v2p01[0]";}
                            ?></h3></td>
						</tr>
  
      <tr>
							<td>

<table>
<thead>
<tr>
			    <th>Calificaci&oacute;n </th>
</tr>
</thead>




<tr bgcolor="#f4f4f4">
							<td>Califique Tweet 1-6</td>
						</tr>
      <tr bgcolor="#f4f4f4">
        <td>
        <select id="calificador" name="calificador" size="1">
        <option value="">Elija</option>
        <option value="1"  <?php  
                                mysql_select_db($database_connectionManager, $connectionManager);  
                                $vp01= mysql_query("select calificador from Tweets where id=$ident", $connectionManager) or die(mysql_error()); 
                                $v2p01 = mysql_fetch_row($vp01); if ($v2p01[0]==1) {echo "selected=\"true\"";}
                            ?>
  >1</option>
        <option value="2"  <?php  
                                if ($v2p01[0]==2) {echo "selected=\"true\"";}
                            ?>
  >2</option>
        <option value="3"
                           <?php  
                             if ($v2p01[0]==3) {echo "selected=\"true\"";}
                            ?>
   >3</option>
        <option value="4"
                             <?php  
                              if ($v2p01[0]==4) {echo "selected=\"true\"";}
                            ?>
>4</option>
        <option value="5"
                            <?php  
                               if ($v2p01[0]==5) {echo "selected=\"true\"";}
                            ?>
>5</option>
 <option value="6"
                            <?php  
                               if ($v2p01[0]==6) {echo "selected=\"true\"";}
                            ?>
>6</option>

<option value="7"
                            <?php  
                               if ($v2p01[0]==7) {echo "selected=\"true\"";}
                            ?>
>7</option>

<option value="8"
                            <?php  
								   if ($v2p01[0]==8) {echo "selected=\"true\"";}
                            ?>
>8</option>
<option value="9"
                            <?php  
                               if ($v2p01[0]==9) {echo "selected=\"true\"";}
                            ?>
>9</option>
<option value="10"
                            <?php  
                               if ($v2p01[0]==10) {echo "selected=\"true\"";}
                            ?>
>10</option>
<option value="11"
                            <?php  
                               if ($v2p01[0]==11) {echo "selected=\"true\"";}
                            ?>
>11</option>
<option value="12"
                            <?php  
                               if ($v2p01[0]==12) {echo "selected=\"true\"";}
                            ?>
>12</option>
<option value="13"
                            <?php  
                               if ($v2p01[0]==13) {echo "selected=\"true\"";}
                            ?>
>13</option>
<option value="14"
                            <?php  
                               if ($v2p01[0]==14) {echo "selected=\"true\"";}
                            ?>
>14</option>
<option value="15"
                            <?php  
                               if ($v2p01[0]==15) {echo "selected=\"true\"";}
                            ?>
>15</option>
<option value="16"
                            <?php  
                               if ($v2p01[0]==16) {echo "selected=\"true\"";}
                            ?>
>16</option>
<option value="17"
                            <?php  
                               if ($v2p01[0]==17) {echo "selected=\"true\"";}
                            ?>
>17</option>
<option value="18"
                            <?php  
                               if ($v2p01[0]==18) {echo "selected=\"true\"";}
                            ?>
>18</option>
<option value="19"
                            <?php  
                               if ($v2p01[0]==19) {echo "selected=\"true\"";}
                            ?>
>19</option>
<option value="20"
                            <?php  
                               if ($v2p01[0]==20) {echo "selected=\"true\"";}
                            ?>
>20</option>
        </select>
        </td></tr>




</table>
</td>
						</tr>
 

<tr>

<td>
<table>
<tbody>
<tr>

<td> 
<input type="button"  id="Atras" value="Anterior" onClick="history.go(-1)">
</td>

<td>
<input name="Submit0" id="Submit0" value="Aplicar" type="submit">
</td>
<td>
<input name="Submit" id="Submit" value="Guardar y Cerrar" type="submit">
</td>
<td>
<input name="Submit2" id="Submit2" value="Guardar y Siguiente" type="submit">
</td>

<?php

$sigueSQL="select id from Tweets where Id >".$ident." limit 0,1";
mysql_select_db($database_connectionManager, $connectionManager);
  $ress = mysql_query($sigueSQL, $connectionManager) or die(mysql_error());
 $ress1 = mysql_fetch_row($ress);

//<a href="http://webapp.intelect.com.mx/datagrid/mod3.php?id='.$ress1[0].'" ">Siguiente</a>

echo '
<td> 

<input type="button" value="Siguiente" Name="Siguiente" onClick="window.location=\'/oportunidad/datagrid/mod_NUEVOS.php?id='.$ress1[0].' \'">


</td>';

?>


</tr>
</tbody>
</table>
</td>
</tr>
         </tbody>
  </table>
  <input name="MM_insert" value="form1" type="hidden"> </form>
</div>
</body>
</html>





