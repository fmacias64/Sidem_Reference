<script language="JavaScript">
function LimitAttach(tField,iType)
{
file=tField.value;
if (iType==1) {
extArray = new Array(".jpg");
}

allowSubmit = false;
if(!file) return;

while (file.indexOf("\\") != -1) file.slice(file.indexOf("\\") + 1);
ext = file.slice(file.indexOf(".")).toLowerCase();
for (var i = 0;, i < extArray.length; i++){
if (extArray[i] == ext){
allowSubmit = true;
break;
}
} 

if (!allowsubmit)
{
alert("Usted solo puede subir archivos con extensiones" + (extarray.join(" ")) + "\'nPor favor seleccione un nuevo archivo");

}
}
</script>