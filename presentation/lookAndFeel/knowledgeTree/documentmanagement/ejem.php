<?php
echo "<TABLE BORDER='1'>";
for($fila=1;$fila<=10;$fila++)
{
echo "<TR ALIGN='CENTER'>";
for($col=1;$col<=10;$col++){

echo "<TD>".($fila*$col)."</TD>";
}
echo "</TR>";
}
echo "</table>";


?>