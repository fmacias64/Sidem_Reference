

<script type="text/javascript" src="/SIDEM/workspaces/sidem/flashobject-js/downloadFile/file/flashobject.js?nocache=1216750527.0"></script>
<Script language="JavaScript">

function goto(form) {
var index=form.select.selectedIndex

if (form.select.options[index].value != "0") {
location=form.select.options[index].value;}}

function goto2(form) {
var
locacion="http://proveedores.intelect.com.mx/FichasBD/branches/Sidem/control.php?action=getlistaeventb2b2";
var bool=0;


var indexregion=form.region.selectedIndex
var indexevent=form.event.selectedIndex
var indexaction=form.action.selectedIndex
var indextype=form.type.selectedIndex
var indexcompetitive=form.competitive.selectedIndex
var indexsustainability=form.sustainability.selectedIndex
var indexreactiontype=form.reactiontype.selectedIndex
var indexreactiontopic=form.reactiontopic.selectedIndex
var indexconsequence=form.consequence.selectedIndex
var indexactor=form.actor.selectedIndex


 if( form.nota.value != "0") {
locacion=locacion+"&nota="+form.nota.value;
bool=1;
}



if (form.region.options[indexregion].value != "0") {
locacion=locacion+"&region="+form.region.options[indexregion].value;
bool=1;
}

 


if (form.event.options[indexevent].value != "0") {
locacion=locacion+"&event="+form.event.options[indexevent].value;
bool=1;
}

if (form.action.options[indexaction].value != "0") {
locacion=locacion+"&action="+form.action.options[indexaction].value;
bool=1;
}

if (form.type.options[indextype].value != "0") {
locacion=locacion+"&type="+form.type.options[indextype].value;
bool=1;
}

if (form.competitive.options[indexcompetitive].value != "0") {
locacion=locacion+"&competitive="+form.competitive.options[indexcompetitive].value;
bool=1;
}
if (form.sustainability.options[indexsustainability].value != "0") {
locacion=locacion+"&sustainability="+form.sustainability.options[indexsustainability].value;
bool=1;
}
if (form.reactiontype.options[indexreactiontype].value != "0") {
locacion=locacion+"&reactiontype="+form.reactiontype.options[indexreactiontype].value;
bool=1;
}
if (form.reactiontopic.options[indexreactiontopic].value != "0") {
locacion=locacion+"&reactiontopic="+form.reactiontopic.options[indexreactiontopic].value;
bool=1;
}
if (form.consequence.options[indexconsequence].value != "0") {
locacion=locacion+"&consequence="+form.consequence.options[indexconsequence].value;
bool=1;
}
if (form.actor.options[indexactor].value != "0") {
locacion=locacion+"&actor="+form.actor.options[indexactor].value;
bool=1;
}
 if(bool=1) {
fichaslist.location=locacion}

}

function goto3(form) {
if (form != "0") {
fichas2.location=form;}}
//-->
</SCRIPT>
<table  BORDER ="1" align="center" style='text-align:center';><tr><td>


<FORM NAME="form2" >
<table><tr><td>
Note
<input id="searchGadget3" type="text" name="nota" />
</td></tr><tr><td>
Region
<SELECT id="searchGadget3" NAME="region" SIZE=\"1\">
<OPTION VALUE=""></OPTION>
<OPTION VALUE="Asia & South Pacific">Asia & South Pacific</OPTION>
<OPTION VALUE="NOAM">NOAM</OPTION>
<OPTION VALUE="SAC">SAC </OPTION>
<OPTION VALUE="Europe">Europe </OPTION>
<OPTION VALUE="CIS">CIS</OPTION>
<OPTION VALUE="Egypt & Middle East">Egypt & Middle East</OPTION>
<OPTION VALUE="Africa">Africa</OPTION>
<OPTION VALUE="Asia & South Pacific">Asia & South Pacific</OPTION>

</SELECT>

 


Event
<SELECT id="searchGadget3" NAME="event" SIZE=\"1\">
<OPTION VALUE="">Elija</OPTION>
<OPTION VALUE="Competitive Dynamic">Competitive Dynamic</OPTION>
<OPTION VALUE="Technology">Technology</OPTION>
<OPTION VALUE="Sustainability">Sustainability</OPTION>
<OPTION VALUE="Opportunities">Opportunities</OPTION>
<OPTION VALUE="Corporate">Corporate</OPTION>
<OPTION VALUE="Reactions">Reactions</OPTION>
</SELECT>

Action
<SELECT id="searchGadget3" NAME="action" SIZE=\"1\">
<OPTION VALUE="">Elija</OPTION>
<OPTION VALUE="New Company">New Company</OPTION>
<OPTION VALUE="Acquisitions">Acquisitions</OPTION>
<OPTION VALUE="Expansions">Expansions</OPTION>
<OPTION VALUE="Mergers">Mergers</OPTION>
<OPTION VALUE="Upgrades">Upgrades</OPTION>
<OPTION VALUE="JV">JV</OPTION>
<OPTION VALUE="Alternative Fuels Project">Alternative Fuels Project</OPTION>
<OPTION VALUE="New Material/Processes">New Material/Processes</OPTION>
<OPTION VALUE="Projects / Loans">Projects / Loans</OPTION>
<OPTION VALUE="Organization of Forums & Events">Organization of Forums & Events</OPTION>
<OPTION VALUE="Attendance to Forums & Events">Attendance to Forums & Events</OPTION>
<OPTION VALUE="Awards Delivered">Awards Delivered</OPTION>
<OPTION VALUE="Document Publishing">Document Publishing</OPTION>
<OPTION VALUE="Foundation/Cofoundation of organism">Foundation/Cofoundation of organism</OPTION>
<OPTION VALUE="Cost Reduction">Cost Reduction</OPTION>
<OPTION VALUE="Capital Finance Raise">Capital Finance Raise</OPTION>
<OPTION VALUE="Increase Prices">Increase Prices</OPTION>
<OPTION VALUE="Volume Raise">Volume Raise</OPTION>
</SELECT>

Type
<SELECT id="searchGadget3" NAME="type" SIZE=\"1\">
<OPTION VALUE="">Elija</OPTION>
<OPTION VALUE="Cement">Cement </OPTION>
<OPTION VALUE="Concrete">Concrete</OPTION>
<OPTION VALUE="Aggregates">Aggregates</OPTION>
<OPTION VALUE="Other">Other</OPTION>
<OPTION VALUE="Quarries">Quarries</OPTION>
<OPTION VALUE="Sea Terminal">Sea Terminal</OPTION>
<OPTION VALUE="Distribution Center">Distribution Center</OPTION>
<OPTION VALUE="R&B Center">R&B Center</OPTION>
<OPTION VALUE="Non Core Related">Non Core Related</OPTION>
<OPTION VALUE="TDF(Tires)">TDF(Tires)</OPTION>
<OPTION VALUE="Bio-Mass">Bio-Mass</OPTION>
<OPTION VALUE="Industrial Wastes">Industrial Wastes</OPTION>
<OPTION VALUE="Municipal Waste">Municipal Waste</OPTION>
<OPTION VALUE="Low resource consumption">Low resource consumption</OPTION>
<OPTION VALUE="Recyclers">Recyclers</OPTION>
<OPTION VALUE="Low Polluters/Env. Quality Enhancers">Low Polluters/Env. Quality Enhancers</OPTION>
<OPTION VALUE="Training/Education">Training/Education</OPTION>
<OPTION VALUE="Business Incubator">Business Incubator</OPTION>
<OPTION VALUE="Redeployment on closure">Redeployment on closure</OPTION>
<OPTION VALUE="Infraestructure Development">Infraestructure Development</OPTION><OPTION VALUE="Housing">Housing</OPTION>
<OPTION VALUE="Natural Disaster Aid">Natural Disaster Aid</OPTION>
<OPTION VALUE="Historical Monuments Protection">Historical Monuments Protection</OPTION>
<OPTION VALUE="Safety promotion">Safety promotion</OPTION>
<OPTION VALUE="Labor Equity/Human Rights">Labor Equity/Human Rights</OPTION>
<OPTION VALUE="Sponsor of Cultural-Sport Activities">Sponsor of Cultural-Sport Activities</OPTION>
<OPTION VALUE="Stakeholders/Community Involvement">Stakeholders/Community Involvement</OPTION>
<OPTION VALUE="Biodiversity and Quarry Rehabilitation">Biodiversity and Quarry Rehabilitation</OPTION>
<OPTION VALUE="Protecting Air Quality and Mitigating Disturbances">Protecting Air Quality and Mitigating Disturbances</OPTION>
<OPTION VALUE="Water Protection">Water Protection</OPTION>
<OPTION VALUE="Reccycling Industrial by products and wastes">Reccycling Industrial by products and wastes</OPTION>
<OPTION VALUE="Energy Recovery (Electricity)">Energy Recovery (Electricity)</OPTION>

</SELECT>


</td></tr><tr><td>

Competitive
<SELECT id="searchGadget3" NAME="competitive" SIZE=\"1\">
<OPTION VALUE="">Elija</OPTION>
<OPTION VALUE="Plan">Plan</OPTION>
<OPTION VALUE="In Process">In Process</OPTION>
<OPTION VALUE="Completed">Completed</OPTION>
</SELECT>

</td></tr><tr><td>


Sustainability

<SELECT id="searchGadget3" NAME="sustainability" SIZE=\"1\">
<OPTION VALUE="">Elija</OPTION>
<OPTION VALUE="Economic">Economic</OPTION>
<OPTION VALUE="Social">Social</OPTION>
<OPTION VALUE="Enviroment">Enviroment</OPTION>
<OPTION VALUE="Sustainable">Sustainable</OPTION>


</SELECT>
</td></tr><tr><td>
Reaction Type

<SELECT id="searchGadget3" NAME="reactiontype" SIZE=\"1\">
<OPTION VALUE="">Elija</OPTION>
<OPTION VALUE="Positive">Positive</OPTION>
<OPTION VALUE="Negative">Negative</OPTION>
<OPTION VALUE="N/A">N/A</OPTION>


</SELECT>
</td></tr><tr><td>


Reaction Topic
<SELECT id="searchGadget3" NAME="reactiontopic" SIZE=\"1\">
<OPTION VALUE="">Elija</OPTION>
<OPTION VALUE="Enviroment/Health">Enviroment/Health</OPTION>
<OPTION VALUE=""Labor/Security withing org">"Labor/Security withing org</OPTION>
<OPTION VALUE="Competitiveness">Competitiveness</OPTION>
<OPTION VALUE="Social Resp. community">Social Resp. community</OPTION>
<OPTION VALUE="N/A">N/A</OPTION>

</SELECT>
</td></tr><tr><td>

Reaction Consequence

<SELECT id="searchGadget3" NAME="consequence" SIZE=\"1\">
<OPTION VALUE="">Elija</OPTION>
<OPTION VALUE="Natiolization">Natiolization</OPTION>
<OPTION VALUE="Closures">Closures</OPTION>
<OPTION VALUE="Fines">Fines</OPTION>
<OPTION VALUE="Lawsults">Lawsults</OPTION>
<OPTION VALUE="Protests">Protests</OPTION>
<OPTION VALUE="Restrictions">Restrictions</OPTION>
<OPTION VALUE="Opposition">Opposition</OPTION>
<OPTION VALUE="Support">Support</OPTION>
<OPTION VALUE="Recognition">Recognition</OPTION>
<OPTION VALUE="NA">N/A</OPTION>
</SELECT>

</td></tr><tr><td>

Reaction Actor
<SELECT id="searchGadget3" NAME="actor" SIZE=\"1\">
<OPTION VALUE="">Elija</OPTION>
<OPTION VALUE="Community">Community</OPTION>
<OPTION VALUE="NGO/Media">NGO/Media</OPTION>
<OPTION VALUE="Government">Government</OPTION>
<OPTION VALUE="Other Competitors">Other Competitors</OPTION>
<OPTION VALUE=""N/A">"N/A</OPTION>
</SELECT>


<input type="button" value="Consultar"
onclick="goto2(this.form)">
</td></tr>
</table>
</FORM>


</td><td>
<table width="50" border="0" cellspacing="1">
<tr>


<td>
<div id="bot_salir" >
<a href="">Salir</a>
</div></td>
</tr>
 </table>
</td>
<tr>
<td>
<p align="center" style='text-align:center';>
<a target="fichaslist"
 href="http://proveedores.intelect.com.mx/FichasBD/branches/Sidem/control.php?
action=getlistaeventb2b2&amp;letra=a_b_c_d_e_f_g_h_i_j_k_l_m_n_o_p_q_r_s_t_u_v
_w_x_y_z_">
Todos
</a>
</p>
</td>
</tr>
</table>

<table>
<tr>
<td>
<iframe name="fichaslist"
src ="http://proveedores.intelect.com.mx/FichasBD/branches/Sidem/control.php?
action=getlistaeventb2b&letra=a_b_c_d_e_f_g_h_i_j_k_l_m_n_o_p_q_r_s_t_u_v_w_x_y_
z_"
width="275" height="400" frameborder=0>
</iframe>
</td>
<td>

<iframe name="fichas2" src="http://proveedores.intelect.com.mx/FichasBD/branches/fichas_cps/mapsis.html"
width="450" height="400" frameborder=0>
</iframe>


</td>

</tr>
</table>

 


<script type="text/javascript">
   var fo = new FlashObject("/SIDEM/workspaces/sidem/botones/addeventemp-swf/downloadFile/file/addeventemp.swf?nocache=1225299888.3", "bot_indv", "100", "20", "6", "#e7e7e7");
    fo.addParam("menu","false");
    fo.addParam("quality","best");
    fo.addParam("salign","LT");
    fo.addParam("scale","noscale");
    fo.addParam("wmode","window");
    fo.write("bot_indv");
</script>


<script type="text/javascript">
   var fo = new FlashObject("/SIDEM/workspaces/sidem/botones/reportegral-swf/downloadFile/file/reportegral.swf?nocache=1216742459.33", "bot_repg", "100", "20", "6", "#e7e7e7");
    fo.addParam("menu","false");
    fo.addParam("quality","best");
    fo.addParam("salign","LT");
    fo.addParam("scale","noscale");
    fo.addParam("wmode","window");
    fo.write("bot_repg");
</script>

<script type="text/javascript">
   var fo = new FlashObject("/SIDEM/workspaces/sidem/botones/salir-swf/downloadFile/file/salir.swf?nocache=1221156804.16", "bot_salir", "80", "20", "6", "#e7e7e7");
    fo.addParam("menu","false");
    fo.addParam("quality","best");
    fo.addParam("salign","LT");
    fo.addParam("scale","noscale");
    fo.addParam("wmode","window");
    fo.write("bot_salir");
</script>
