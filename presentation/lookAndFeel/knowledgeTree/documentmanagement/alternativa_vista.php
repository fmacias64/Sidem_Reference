

/***

$nvosql.="SELECT `sidem210708`.`documents`.`id` AS `id` ,  `sidem210708`.`documents`.`parent_document_id` AS `parent_id` ,  `sidem210708`.`documents`.`child_document_id` AS `child_id` ,  `aquired`.`value` AS `aquired` ,  `jvparth`.`value` AS `jvparth` ,  `coment`.`value` AS `coment` ,  `fechreg`.`value` AS `fechreg` ,  `seller`.`value` AS `seller` ,  `merger`.`value` AS `merger` ,  `created`.`value` AS `created` ,  `related`.`value` AS `related`";
$nvosql.="FROM `sidem210708`.`documents`";
$nvosql.="LEFT JOIN (SELECT `sidem210708`.`documents`.`id` AS `id` ,  `sidem210708`.`documents`.`parent_document_id` AS `parent_id` ,  `sidem210708`.`documents`.`child_document_id` AS `child_id` ,  `aquired`.`value` AS `aquired` ,  `jvparth`.`value` AS `jvparth` ,  `coment`.`value` AS `coment` ,  `fechreg`.`value` AS `fechreg` ,  `seller`.`value` AS `seller` ,  `merger`.`value` AS `merger` ,  `created`.`value` AS `created` ,  `related`.`value` AS `related`";
$nvosql.="FROM `sidem210708`.`documents`
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *";
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =165
$nvosql.=") AS `aquired` ON (
$nvosql.="`sidem210708`.`documents`.`id` = `aquired`.`document_id`
$nvosql.=")


$nvosql.="left join (select * from `sidem210708`.`document_fields_link` where `document_field_id` = 168 ) as `jvparth` on (`sidem210708`.`documents`.`id` = `jvparth`.`document_id`)




$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =12
$nvosql.=") AS `coment` ON ( `sidem210708`.`documents`.`id` = `coment`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =78
$nvosql.=") AS `fechreg` ON ( `sidem210708`.`documents`.`id` = `fechreg`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =170
$nvosql.=") AS `seller` ON ( `sidem210708`.`documents`.`id` = `seller`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =169
$nvosql.=") AS `merger` ON ( `sidem210708`.`documents`.`id` = `merger`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =167
$nvosql.=") AS `created` ON ( `sidem210708`.`documents`.`id` = `created`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =166
$nvosql.=") AS `related` ON ( `sidem210708`.`documents`.`id` = `related`.`docume`created`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =166
$nvosql.=") AS `related` ON ( `sidem210708`.`documents`.`id` = `related`.`document_id` )
$nvosql.="WHERE (
$nvosql.="(
$nvosql.="`sidem210708`.`documents`.`document_type_id` =41
$nvosql.=")
$nvosql.="AND (
$nvosql.="`sidem210708`.`documents`.`status_id` =1
$nvosql.=")
$nvosql.=")SELECT `sidem210708`.`documents`.`id` AS `id` ,  `sidem210708`.`documents`.`parent_document_id` AS `parent_id` ,  `sidem210708`.`documents`.`child_document_id` AS `child_id` ,  `aquired`.`value` AS `aquired` ,  `jvparth`.`value` AS `jvparth` ,  `coment`.`value` AS `coment` ,  `fechreg`.`value` AS `fechreg` ,  `seller`.`value` AS `seller` ,  `merger`.`value` AS `merger` ,  `created`.`value` AS `created` ,  `related`.`value` AS `related`
$nvosql.="FROM `sidem210708`.`documents`
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =165
$nvosql.=") AS `aquired` ON (
$nvosql.="`sidem210708`.`documents`.`id` = `aquired`.`document_id`
$nvosql.=")


$nvosql.="left join (select * from `sidem210708`.`document_fields_link` where `document_field_id` = 168 ) as `jvparth` on (`sidem210708`.`documents`.`id` = `jvparth`.`document_id`)




$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =12
$nvosql.=") AS `coment` ON ( `sidem210708`.`documents`.`id` = `coment`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =78
$nvosql.=") AS `fechreg` ON ( `sidem210708`.`documents`.`id` = `fechreg`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =170
$nvosql.=") AS `seller` ON ( `sidem210708`.`documents`.`id` = `seller`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =169
$nvosql.=") AS `merger` ON ( `sidem210708`.`documents`.`id` = `merger`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =167
$nvosql.=") AS `created` ON ( `sidem210708`.`documents`.`id` = `created`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="SELECT *
$nvosql.="FROM `sidem210708`.`document_fields_link`
$nvosql.="WHERE `document_field_id` =166
$nvosql.=") AS `related` ON ( `sidem210708`.`documents`.`id` = `related`.`docume`created`.`document_id` )
$nvosql.="LEFT JOIN (

$nvosql.="WHERE (
$nvosql.="(
$nvosql.="`sidem210708`.`documents`.`document_type_id` =41
$nvosql.=")
$nvosql.="AND (
$nvosql.="`sidem210708`.`documents`.`status_id` =1
$nvosql.=") AND (parent_id= $busq_links2[0] or child_id = $busq_links2[0])
$nvosql.=")



**/

