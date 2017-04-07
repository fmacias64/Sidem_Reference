<?php

require_once("../../../../config/dmsDefaults.php");


if (checkSession()) {

require_once("../../../../lib/util/sanitize.inc");
require_once("../../../Html.inc");
require_once("$default->fileSystemRoot/lib/documentmanagement/Document.inc");
require_once("$default->fileSystemRoot/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewUI.inc");

echo $_SESSION["userID"];


echo '
<HTML>
<BODY>

<form action="/FichasBD/branches/SY/control.php?action=getup1" method="post" enctype="multipart/form-data">
<input  name="archivo" type="file" size="35" />
<input name="enviar" type="submit" value="Upload File" />
<input name="action" type="hidden" value="Upload" />
</form>

</body>
</HTML
>


';


 }





?>