<?php
require_once("../../../../config/dmsDefaults.php");


require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/DocumentCollaboration.inc");


$iddoc = $_GET["iddoc"];
$oDocument = & Document::get($iddoc);
 
//$default->rootUrl

//documento de pruebas 14599

if (checkSession()) {
  $noalcache=time();
echo "\n";
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";
echo "\n";
echo "<html xml:lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\"><head>";
echo "\n";
echo "\n";
  echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\">";

  echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">";
echo "\n";
  echo "<meta http-equiv=\"Cache-control\" content=\"no-cache\">";
echo "\n";
  echo "<meta http-equiv=\"Cache-control\" content=\"must-revalidate\">";
echo "\n";
  echo "<meta http-equiv=\"Cache-control\" content=\"max-age=0\">";
echo "\n";
echo "<title>MINDMAPS</title>";
echo "\n";							    echo "<script type=\"text/javascript\" src=\"flashobject.js\"></script>";
echo "<style type=\"text/css\">";
	
echo "\n";							    echo "	/* hide from ie on mac \*/";
echo "	html {";
echo "\n";
  echo "		height: 100%;";
echo "\n";
echo "		overflow: hidden;";
echo "\n";
echo "	}";
	echo "\n";
echo "	#flashcontent {";
echo "\n";
  echo "		height: 100%;";
echo "\n";
echo "	}";
echo "\n";
echo "	/* end hide */";
echo "\n";

echo "	body {";
echo "\n";
  echo "		height: 100%;";
echo "\n";
echo "		margin: 0;";
echo "\n";
echo "		padding: 0;";
echo "\n";
echo "		background-color: #9999ff;";
echo "\n";
echo "	}";
echo "\n";

echo "</style>";
echo "\n";
echo "</head><body>";
echo "\n";
	
echo "	<div id=\"flashcontent\">";
echo "\n";
echo "		 Flash plugin or Javascript are turned off.";
echo "\n";
echo "		 Activate both  and reload to view the mindmap";
echo "\n";
echo "	</div>";
echo "\n";

// revisar http://www.newtriks.com/?p=134
	
echo "	<script type=\"text/javascript\">";
echo "\n";
echo "		// <![CDATA[";
echo "\n";
echo "		var fo = new FlashObject(\"Main.swf\", \"Main\", \"100%\", \"100%\", 6, \"#9999ff\");";
echo "\n";
echo "		fo.addParam(\"quality\", \"high\");";
echo "\n";
echo "		fo.addParam(\"bgcolor\", \"#ffffff\");";
echo "\n";
 echo "		fo.addVariable(\"initLoadFile\", \"".$default->rootUrl."/Documents/Root Folder/Default Unit/SIDEM/Mindmaps/".$oDocument->getFileName()."?nocache".$noalcache."\");";
//echo "		fo.addVariable(\"initLoadFile\", \"../../../../control.php?action=getmindmap&letra=802\");";
//echo "		fo.addVariable(\"initLoadFile\", \"getmindmap.php?letra=802\");";

echo "\n";
//echo "        	fo.addVariable(\"initLoadFile\", \"uno.php\");";
//echo "        	fo.addVariable(\"initLoadFile\", \"dos.php\");";
echo "\n";
echo "		fo.addVariable(\"openUrl\", \"_self\");";
echo "\n";
echo "		fo.write(\"flashcontent\");";
echo "\n";
echo "		// ]]>";
echo "\n";
echo "	</script>";
echo "\n";
echo "</body></html>";
echo "\n";

	


 }


 ?>