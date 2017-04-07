<?php

require_once("../../../../config/dmsDefaults.php");
require_once("getipadpescf.php");



if  (1) {               

$boolnota=0;
$echoactor=0;
$letra = $_GET["letra"];
$nota = $_GET["nota"];
$region = $_GET["region"];
$event = $_GET["event"];
$action = $_GET["action2"];
$type = $_GET["type"];
$competitive = $_GET["competitive"];
$sustainability = $_GET["sustainability"];
$reactiontype = $_GET["reactiontype"];
$reactiontopic = $_GET["reactiontopic"];
$consequence = $_GET["consequence"];
$actor = $_GET["actor"];
$competidor=$_GET["competidor"];
$industria=$_GET["industry"];
$subindustria=$_GET["subindustry"];
$parampais=$_GET["pais"];
$ano=$_GET["ano"];
$notime=$_GET["notime"];

$fechaA=$_GET["fecha1"];

$fechaP=$_GET["fecha2"];
$apartir=$_GET["apartir"];
$where1 = "";
$from1="";
 $letram=strtoupper($letra);
   $letrasar= explode("_",$letram);

$titulo1.="NOAM";
$titulo2.="EUROPE";

$param1=listanotas($letra,$nota,$region,$event,$action,$type,$competitive,$sustainability,$reactiontype,$reactiontopic,$consequence,$actor,$competidor,$industria,$subindustria,$parampais,$ano,$notime,$fecha1,$fecha2,$apartir,3,"Politics",1);
$param1.=listanotas($letra,$nota,$region,$event,$action,$type,$competitive,$sustainability,$reactiontype,$reactiontopic,$consequence,$actor,$competidor,$industria,$subindustria,$parampais,$ano,$notime,$fecha1,$fecha2,$apartir,3,"Economics",3);


$param2=listanotas($letra,$nota,$region,$event,$action,$type,$competitive,$sustainability,$reactiontype,$reactiontopic,$consequence,$actor,$competidor,$industria,$subindustria,$parampais,$ano,$notime,$fecha1,$fecha2,$apartir,2,"Social",2);
$param2.=listanotas($letra,$nota,$region,$event,$action,$type,$competitive,$sustainability,$reactiontype,$reactiontopic,$consequence,$actor,$competidor,$industria,$subindustria,$parampais,$ano,$notime,$fecha1,$fecha2,$apartir,2,"Contingencies",4);

echo imprime_web2($param1,$param2);

}

//=============>>> FUNCION ORIGINAL ==================>>>

function stri_replace( $find, $replace, $string ) {
// Case-insensitive str_replace()

  $parts = explode( strtolower($find), strtolower($string) );

  $pos = 0;

  foreach( $parts as $key=>$part ){
    $parts[ $key ] = substr($string, $pos, strlen($part));
    $pos += strlen($part) + strlen($find);
  }

  return( join( $replace, $parts ) );
}


function txt2html($txt) {
// Transforms txt in html

  //Kills double spaces and spaces inside tags.
  while( !( strpos($txt,'  ') === FALSE ) ) $txt = str_replace('  ',' ',$txt);
  $txt = str_replace(' >','>',$txt);
  $txt = str_replace('< ','<',$txt);

  //Transforms accents in html entities.
  $txt = htmlentities($txt);

  //We need some HTML entities back!
  $txt = str_replace('&quot;','"',$txt);
 $txt = str_replace("&amp;#8217;","&rsquo;",$txt);
$txt = str_replace("&amp;#8232;","&rsquo;",$txt);
  $txt = str_replace("\x92","&rsquo;",$txt);
$txt = str_replace("\x93","&quot;",$txt);
$txt = str_replace("\x94","&quot;",$txt);
$txt = str_replace("\x96","&quot;",$txt);
$txt = str_replace("\x97","&quot;",$txt);
$txt = str_replace("\x99"," ",$txt);
$txt = str_replace("\x80","Euros ",$txt);
  $txt = str_replace('&lt;','<',$txt);
  $txt = str_replace('&gt;','>',$txt);
  $txt = str_replace('&amp;','&',$txt);

  //Ajdusts links - anything starting with HTTP opens in a new window
  $txt = stri_replace("<a href=\"http://","<a target=\"_blank\" href=\"http://",$txt);
  $txt = stri_replace("<a href=http://","<a target=\"_blank\" href=http://",$txt);

  //Basic formatting
  $eol = ( strpos($txt,"\r") === FALSE ) ? "\n" : "\r\n";
  $html = '<p>'.str_replace("$eol$eol","</p><p>",$txt).'</p>';
  $html = str_replace("$eol","<br />\n",$html);
  $html = str_replace("</p>","</p>\n\n",$html);
  $html = str_replace("<p></p>","<p>&nbsp;</p>",$html);

  //Wipes <br> after block tags (for when the user includes some html in the text).
  $wipebr = Array("table","tr","td","blockquote","ul","ol","li");

  for($x = 0; $x < count($wipebr); $x++) {

    $tag = $wipebr[$x];
    $html = stri_replace("<$tag><br />","<$tag>",$html);
    $html = stri_replace("</$tag><br />","</$tag>",$html);

  }

  return $html;
}

//<<<<=================TERMINA FUNCION ORIGINAL <<<==================


function imprime_web($mistring)
{

$imphtml= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";

  $imphtml.= "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\" xml:lang=\"en\">";
    $imphtml.= "<head>";
      
  
  $imphtml.= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-15\" />";
  $imphtml.= "<meta name=\"generator\" content=\"Nuxeo CPS http://www.cps-project.org/\" />";
  $imphtml.= "<title>";

$imphtml.= "SIUC";

  $imphtml.= "</title>";
  //$imphtml.= "<base href=\"http://boletin.intelect.com.mx/\" />";
  $imphtml.= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" title=\"CPSDefault styles\" href=\"default.css\" />";
  
  $imphtml.= "<!--[if IE]>";$imphtml.= "<link rel=\"stylesheet\" type=\"text/css\" href=\"msie.css\" />";
  $imphtml.= "<![endif]-->";
  $imphtml.= "<link rel=\"stylesheet\" type=\"text/css\" media=\"print\" href=\"default_print.css\" />";
  $imphtml.= "<meta http-equiv=\"imagetoolbar\" content=\"no\" />";
  
  
  
  
  
  $imphtml.= "<script type=\"text/javascript\" src=\"functions.js\">";
  $imphtml.= "</script>";

      
$imphtml.= "<meta name=\"engine\" content=\"CPSSkins 2.3\" />";
$imphtml.= "<!-- Shortcut icon -->";
$imphtml.= "<link rel=\"icon\" href=\"cpsicon.png\" type=\"image/png\" />";
$imphtml.= "<link rel=\"shortcut icon\" href=\"cpsicon.png\" type=\"image/png\" />";

$imphtml.= "<!-- CSS1 -->";
$imphtml.= "<link rel=\"Stylesheet\" type=\"text/css\" href=\"cpsskins_common.css\" />";
$imphtml.= "<link rel=\"Stylesheet\" type=\"text/css\" href=\"renderCSS.css\" />";
$imphtml.= "<!-- CSS2 -->";
$imphtml.= "<style type=\"text/css\" media=\"all\">";

$imphtml.= "@import url(cpsskins_common-css2.css);";

$imphtml.= "</style>";
$imphtml.= "<!-- JavaScript -->";
$imphtml.= "<script type=\"text/javascript\" src=\"renderJS\">";
$imphtml.= "</script>";
$imphtml.= "<script type=\"text/javascript\" src=\"cpsskins_renderJS\">";
$imphtml.= "</script>";
$imphtml.= "</head>";
    
  //  $imphtml.= "<body onload=\"setFocus();\" style=\"margin:0.5em\">";
      
  $imphtml.= "<div>";
//$imphtml.= "<a href=\"http://boletin.intelect.com.mx/accessibility\" accesskey=\"0\">";
//$imphtml.= "</a>";
//$imphtml.= "<a href=\"http://boletin.intelect.com.mx/\" accesskey=\"1\">";
//$imphtml.= "</a>";
//$imphtml.= "<a href=\"#content\" accesskey=\"2\">";
//$imphtml.= "</a>";
//$imphtml.= "<a href=\"#menu\" accesskey=\"3\">";
//$imphtml.= "</a>";
//$imphtml.= "<a href=\"http://boletin.intelect.com.mx/advanced_search_form\" accesskey=\"4\">";
//$imphtml.= "</a>";
//$imphtml.= "<a href=\"http://boletin.intelect.com.mx/\" accesskey=\"7\">";
//$imphtml.= "</a>";
//$imphtml.= "</div>";
  
    $imphtml.= "<table cellpadding=\"0\" cellspacing=\"0\" summary=\"Aviso\" style=\"width:100%;\" class=\"shapeNoBorder colorTransparent\">";
       $imphtml.= "<tr>";
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:650px\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
      $imphtml.= "</tr>";
    $imphtml.= "</table>";
  
  
    $imphtml.= "<table cellpadding=\"0\" cellspacing=\"0\" summary=\"Banner\" style=\"width:100%;\" class=\"shapeNoBorder colorTransparent\">";
       $imphtml.= "<tr>";
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:650px\">";
              
                
              
              
                
                  $imphtml.= "<div style=\"text-align: left;\" class=\"colorTransparent fontColorBlack fontShapeVerdana shapeNoBorder\">";
                    //$imphtml.= "<img src=\"cenefaDMQ2.jpg\" width=\"649\" height=\"147\" alt=\"1\" />";
                    
                  $imphtml.= "</div>";
                
              
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
      $imphtml.= "</tr>";
    $imphtml.= "</table>";
  
  
    $imphtml.= "<table cellpadding=\"0\" cellspacing=\"0\" summary=\"Contenido 4 a\" style=\"width:100%;\" class=\"shapeNoBorder colorTransparent\">";
       $imphtml.= "<tr>";
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
            $imphtml.= "<td valign=\"top\" style=\"width:651px\" class=\"shapeNoBorder colorBlanco\">";
              
$imphtml.= $mistring;




     $imphtml.= "</td>";
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          $imphtml.= "</tr>";
$imphtml.= "</table>";
  
  
  
  
    $imphtml.= "<table cellpadding=\"0\" cellspacing=\"0\" summary=\"Footer 20\" style=\"width:100%;\" class=\"shapeNoBorder colorTransparent\">";
       $imphtml.= "<tr>";
       $imphtml.= "<td valign=\"top\" style=\"width:30%\"  class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:650px\"   class=\"shapeNoBorder colorTransparent\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\"  class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
      $imphtml.= "</tr>";
    $imphtml.= "</table>";
  
  
    $imphtml.= "<table cellpadding=\"0\" cellspacing=\"0\"  summary=\"Disclainer 21\" style=\"width:100%;\"  class=\"shapeNoBorder colorTransparent\">";
       $imphtml.= "<tr>";
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\" class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:650px\" class=\"shapeNoBorder colorGris\">";
              
                
                 // $imphtml.= "<div style=\"text-align: left;\"  class=\"colorGris\">";
                  
//$imphtml.= "  Para cancelar su suscripción, suspender temporalmente este envío, modificar sus datos o correo electrónico";
//$imphtml.= " envíe un mensaje a la dirección de correo conred@cred.com.mx indicando los detalles que desee modificar y con gusto atenderemos su petición.";
                    
                //  $imphtml.= "</div>";
                
              
            $imphtml.= "</td>";
          
        
        
          
            $imphtml.= "<td valign=\"top\" style=\"width:30%\"  class=\"shapeNoBorder colorGris\">";
            $imphtml.= "</td>";
          
        
      $imphtml.= "</tr>";
    $imphtml.= "</table>";
  

    $imphtml.= "</body>";
  $imphtml.= "</html>";

return $imphtml;

}


?>
