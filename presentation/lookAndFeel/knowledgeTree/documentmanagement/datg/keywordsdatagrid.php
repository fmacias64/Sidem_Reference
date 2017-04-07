<?php
  //require_once './libraries/common.inc.php';
 
require 'class.eyemysqladap.inc.php';
require 'class.eyedatagrid2.inc.php';

// Load the database adapter
$db = new EyeMySQLAdap('localhost', 'dms', 'djw9281js', 'TwitterEmpresa');

// Load the datagrid class
$x = new EyeDataGrid($db);

// Set the query
$x->setQuery("*", "keycuenta", "", "1");

//$x->showCreateButton("window.open('http://tweets.intelect.com.mx/buscatweet/datagrid/ins_ciclo.php','Nuevo','width=820,height=800,scrollbars=YES')",EyeDataGrid::TYPE_ONCLICK ,'Keyword +'  );


//$x->addRowSelect("window.open('http://tweets.intelect.com.mx/buscatweet/datagrid/mod_ciclo.php?id=%id%','Edita','width=820,height=800,scrollbars=YES')");
//$x->addStandardControl(EyeDataGrid::STDCTRL_EDIT,"window.open('http://tweets.intelect.com.mx/buscatweet/datagrid/mod_ciclo.php?id=%id%','Edita','width=820,height=800,scrollbars=YES')");
//$x->addStandardControl(EyeDataGrid::STDCTRL_DELETE,"window.open('http://tweets.intelect.com.mx/buscatweet/borrakeyword.php?keyword=%keyword%','Borra','width=820,height=800,scrollbars=YES')");

//$x->addCustomControl(EyeDataGrid::CUSCTRL_TEXT,"javascript:ajax_loadContent('news1','/buscatweet/archive.php?keyword=%keyword%')",EyeDataGrid::TYPE_HREF,  " ' Desplazar: %keyword% '");

$x->addCustomControl(EyeDataGrid::CUSCTRL_TEXT,"window.open('/buscatweet/predesplazakeyword.php?keyword=%keyword%','Desplaza','width=420,height=400,scrollbars=YES')",EyeDataGrid::TYPE_ONCLICK,  "<img src='arrow.gif'/>");
// Allows filters
$x->allowFilters();
$x->setResultsPerPage(50);
// Change headers text
$x->setColumnHeader('FirstName', 'First Name');
$x->setColumnHeader('LastName', 'Last Name');
//$x->setLimit(0, 50);
// Hide ID Column
$x->hideColumn('id');
$x->hideColumn('id_str');
$x->hideColumn('created_at');
//$x->hideColumn('from_usr_id_str');
$x->hideColumn('geo');
$x->hideColumn('iso_language_code');
$x->hideColumn('metadata_result_type');
$x->hideColumn('profile_image_url');
$x->hideColumn('source');
$x->hideColumn('level');
$x->hideColumn('to_usr_id_str');
//$x->setColumnType('calificador', EyeDataGrid::TYPE_ARRAY, array('-1' => 'Falta','Back' => '#c3daf9', 'Fore' => 'black')); // Convert db values to something better
// Change column type
$x->setColumnType('FeciniOpe', EyeDataGrid::TYPE_DATE, 'M d, Y', true); // Change the date format
$x->setColumnType('Gender', EyeDataGrid::TYPE_ARRAY, array('m' => 'Male', 'f' => 'Female')); // Convert db values to something better
//$x->setColumnType('calificador', EyeDataGrid::TYPE_PERCENT, false, array('Back' => '#c3daf9', 'Fore' => 'black'));
?>
<html>
<head>
<title>Keywords</title>
<link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
<script type="text/javascript" src="/buscatweet/ajax.js"></script>

<script type="text/javascript" src="/buscatweet/ajax-dynamic-content.js"></script>

<script type="text/javascript">
<!-- var ajax = new sack();
function getAjaxFile(fileName)
{
  ajax.requestFile = fileName;
  ajax.onCompletion = showContent;
  ajax.onLoading = showWaitMessage;
  ajax.runAJAX();
} 
//-->
</script>

<h1>Keywords</h1>
<p>Instrucciones:</p>
<ul>
	<li>Al lado del encabezado de la columna se ve el icono parecido a un alfiler</li>
	<li>Oprimir sobre el y poner un criterio de busqueda en la caja de texto que surje.</li>
<li>Luego oprimir "filtrar"</li>

<li>Se puede utilizar el caracter * como comodi&iacute;n</li>
<li>As&iacute; *ARD* da como resultado las columnas con RICARDO, EDUARDO, CARDENAS etc..</li>
<li>Oprimir sobre el encabezado , ordena ascendente o descendente esa columna</li>
</ul>
<?php
// Print the table
$x->printTable();
?>
<DIV id="news1"></DIV>

</body>
</html>