

<SCRIPT LANGUAGE="JavaScript">
function isEmailAddress(theElement, nombre_del_elemento )
{
var s = theElement.value;
var filter=/^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
if (s.length == 0 ) return true;
if (filter.test(s))
return true;
else
alert("Ingrese una dirección de correo válida");
theElement.focus();
return false;
}
</SCRIPT>

<FORM>
<INPUT TYPE="text" NAME="TextField">
<INPUT TYPE="submit" VALUE="Enviar" ONCLICK="return isEmailAddress(TextField,'TextField' )">
</FORM>
</script>