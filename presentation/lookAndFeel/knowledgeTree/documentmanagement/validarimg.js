
function LimitAttach(tField,iType) 
{
file=tField.value;
if (iType==1) { 
extArray = new Array(".jpg");
}
if (iType==2) {
extArray = new Array(".swf");
}
if (iType==3) {
extArray = new Array(".exe",".sit",".zip",".tar",".swf",".mov",".hqx",".ra",".wmf",".mp3",".qt",".med",".et");
}
if (iType==4) {
extArray = new Array(".mov",".ra",".wmf",".mp3",".qt",".med",".et",".wav");
}
if (iType==5) {
extArray = new Array(".html",".htm",".shtml");
}
if (iType==6) {
extArray = new Array(".doc",".xls",".ppt");
}
if (iType==7) {
extArray = new Array(".txt",".htm",".html",".pdf",".swf");
}

allowSubmit = false;
if (!file) return;

while (file.indexOf("\\") != -1) file = file.slice(file.indexOf("\\") + 1);
ext = file.slice(file.indexOf(".")).toLowerCase();
for (var i = 0; i < extArray.length; i++) {
if (extArray[i] == ext) {
allowSubmit = true;
break;
}
} 

if (!allowSubmit) 
{
alert("Usted s\u00F3lo puede subir archivos con extensiones " + (extArray.join(" ")) + "\nPor favor seleccione un nuevo archivo");
}
} 
