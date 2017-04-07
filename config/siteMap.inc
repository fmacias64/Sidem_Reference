<?php
/**
 * $Id: siteMap.inc,v 1.21 2005/06/13 21:31:23 nbm Exp $
 *
 * Defines site mappings- actions, pages and permissions.
 *
 * Copyright (c) 2003 Jam Warehouse http://www.jamwarehouse.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */ 
 
require_once("$default->fileSystemRoot/lib/session/SiteMap.inc");
$default->siteMap = new SiteMap(false);

// action, page, section, group with access, link text

// general pages
$default->siteMap->addPage("login", "/presentation/login.php?loginAction=login", "General", None, "");
$default->siteMap->addPage("loginForm", "/presentation/login.php?loginAction=loginForm", "General", None, "login");

// dashboard
$default->siteMap->addPage("dashboard", "/presentation/lookAndFeel/knowledgeTree/dashboardBL.php", "General", Guest, "dashboard");
// dashboard news
$default->siteMap->addPage("viewNewsItem", "/presentation/lookAndFeel/knowledgeTree/dashboard/news/displayNewsItem.php", "General", Guest, "");
$default->siteMap->addPage("viewNewsImage", "/presentation/lookAndFeel/knowledgeTree/dashboard/news/displayNewsImage.php", "General", Guest, "");

//pages for manage documents section
$default->siteMap->addDefaultPage("browse", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/browseBL.php", "Manage Documents", Guest, _("browse documents"));
$default->siteMap->addDefaultPage("templateBrowse", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/templateDocumentBrowseBL.php", "Manage Documents", Guest, _("browse documents"));
$default->siteMap->addPage("viewDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewBL.php", "Manage Documents", Guest, _("View Document"), false);
$default->siteMap->addPage("downloadDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/downloadBL.php", "Manage Documents", Guest, "Download Document", false);
$default->siteMap->addPage("deleteDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/deleteDocumentBL.php", "Manage Documents", User, "Delete document", false);
$default->siteMap->addPage("moveDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/moveDocumentBL.php", "Manage Documents", User, "Move document", false);
$default->siteMap->addPage("viewHistory", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/viewHistoryBL.php", "Manage Documents", User, "View Document History", false);
$default->siteMap->addPage("modifyDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/modifyBL.php", "Manage Documents", User, "Modify Document", false);
$default->siteMap->addPage("emailDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/emailBL.php", "Manage Documents", User, "Email A Document", false);
$default->siteMap->addPage("modifyDocumentGenericMetaData", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/modifyGenericMetaDataBL.php", "Manage Documents", User, "Modify Document Generic MetaData", false);
$default->siteMap->addPage("archiveDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/archiving/archiveDocumentBL.php", "Manage Documents", User, "Archive Document", false);
$default->siteMap->addPage("addDocumentArchiveSettings", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/archiving/addArchiveSettingsBL.php", "Manage Documents", User, "Add Document Archive Settings", false);
$default->siteMap->addPage("modifyDocumentArchiveSettings", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/archiving/modifyArchiveSettingsBL.php", "Manage Documents", User, "Modify Document Archive Settings", false);
$default->siteMap->addPage("requestDocumentRestore", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/archiving/requestDocumentRestoreBL.php", "Manage Documents", User, "Request Document Restoration", false);

$default->siteMap->addPage("addDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/addDocumentBL.php", "Manage Documents", User, _("Add A Document"));
$default->siteMap->addPage("bulkUpload", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/bulkUploadBL.php", "Manage Documents", User, _("Bulk Upload"));

// folder management
$default->siteMap->addPage("addFolder", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/addFolderBL.php", "Manage Documents", User, _("Add A Folder"));
$default->siteMap->addPage("addFolderDocType", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/addFolderDocTypeBL.php", "Manage Documents", User, "");
$default->siteMap->addPage("deleteFolderDocType", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/deleteFolderDocTypeBL.php", "Manage Documents", User, "");
$default->siteMap->addPage("editFolder", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/editBL.php", "Manage Documents", User, _("Modify Folder Properties"));
$default->siteMap->addPage("copyFolderPermissions", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/copyInheritedPermissionsBL.php", "Manage Documents", User, _("Copy Inherited Folder Permissions"), false);
$default->siteMap->addPage("modifyFolderData", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/modifyFolderDataBL.php", "Manage Documents", User, "Modify Folder Data", false);
$default->siteMap->addPage("deleteFolder", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/deleteFolderBL.php", "Manage Documents", User, _("Delete Current Folder"));


// folder access
$default->siteMap->addPage("addGroupFolderLink", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/addGroupFolderLinkBL.php", "Manage Documents", User, "Add Folder Access", false);
$default->siteMap->addPage("modifyGroupFolderLink", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/editGroupFolderLinkBL.php", "Manage Documents", User, "Edit Folder Access", false);
$default->siteMap->addPage("deleteGroupFolderLink", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/deleteGroupFolderLinkBL.php", "Manage Documents", User, "Delete Folder Access", false);

// document actions
$default->siteMap->addPage("modifyDocumentTypeMetaData", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/modifySpecificMetaDataBL.php", "Manage Documents", User, "");
$default->siteMap->addPage("modifyDocumentRouting", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/collaborationBL.php", "Manage Documents", User, "");
$default->siteMap->addPage("collaborationStepReject", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/collaborationRollbackBL.php", "Manage Documents", User, "");
$default->siteMap->addPage("modifyFolderCollaboration", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/collaborationBL.php", "Manage Documents", User, "", false);
$default->siteMap->addPage("addFolderCollaboration", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/addFolderCollaborationBL.php", "Manage Documents", User, "", false);
$default->siteMap->addPage("deleteFolderCollaboration", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/deleteFolderCollaborationBL.php", "Manage Documents", User, "", false);
$default->siteMap->addPage("viewDependantDocument", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/viewDependantDocumentsBL.php", "Manage Documents", User, "", false);
$default->siteMap->addPage("deleteDependantDocument", "/presentation/lookAndFeel/knowledgeTree/foldermanagement/deleteDependantDocumentBL.php", "Manage Documents", User, "", false);
$default->siteMap->addPage("removeDocumentLink", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/removeDocumentLinkBL.php", "Manage Documents", User, "", false);
$default->siteMap->addPage("addDocumentLink", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/addDocumentLinkBL.php", "Manage Documents", User, "", false);
$default->siteMap->addPage("createDependantDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/createDependantDocumentBL.php", "Manage Documents", User, "", false);
$default->siteMap->addPage("escalateDependantDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/escalateDependantDocumentBL.php", "Manage Documents", User, "", false);

$default->siteMap->addPage("addSubscription", "/presentation/lookAndFeel/knowledgeTree/subscriptions/addSubscriptionBL.php", "Manage Documents", User, _("Add Folder Subscription"));
$default->siteMap->addPage("removeSubscription", "/presentation/lookAndFeel/knowledgeTree/subscriptions/removeSubscriptionBL.php", "Manage Documents", User, _("Remove Folder Subscription"));

// check in / check out
$default->siteMap->addPage("checkOutDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/checkOutDocumentBL.php", "Manage Documents", User, "Check Out Document", false);
$default->siteMap->addPage("checkInDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/checkInDocumentBL.php", "Manage Documents", User, "Check In Document", false);

$default->siteMap->addSectionColour("Manage Documents", "td", "BDDFE0");
$default->siteMap->addSectionColour("Manage Documents", "th", "57AFAE");

// web documents
$default->siteMap->addPage("webDocument", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/webDocumentBL.php", "Manage Documents", Guest, "View Web Document", false);

// category management
$default->siteMap->addPage("manageCategories", "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/editDocFieldBL.php?fDocFieldID=1", "Manage Categories", SysAdmin, _("Manage Categories"));
$default->siteMap->addSectionColour("Manage Categories", "td", "BDDFE0");
$default->siteMap->addSectionColour("Manage Categories", "th", "57AFAE");
// document type management
$default->siteMap->addPage("manageDocumentTypes", "/control.php?action=doctype", "Manage Document Types", SysAdmin, _("Manage Document Types"));
$default->siteMap->addSectionColour("Manage Document Types", "td", "BDDFE0");
$default->siteMap->addSectionColour("Manage Document Types", "th", "57AFAE");

// pages for administration section
$default->siteMap->addDefaultPage("administration", "/presentation/lookAndFeel/knowledgeTree/administration/admin.php", "Administration", UnitAdmin, _("Administration"));

$default->siteMap->addPage("userManagement", "/presentation/lookAndFeel/knowledgeTree/administration/usermanagement/listUsersBL.php", "Administration", UnitAdmin, _("User Management"), true, 1);
$default->siteMap->addPage("userPasswordManagement", "/presentation/lookAndFeel/knowledgeTree/administration/usermanagement/passwordManagementBL.php", "Administration", SysAdmin, _("User Management"), false, 1);
$default->siteMap->addPage("groupManagement", "/presentation/lookAndFeel/knowledgeTree/administration/groupmanagement/listGroupsBL.php", "Administration", UnitAdmin, _("Group Management"), true, 2);
$default->siteMap->addPage("unitManagement", "/presentation/lookAndFeel/knowledgeTree/administration/unitmanagement/listUnitsBL.php", "Administration", SysAdmin, _("Unit Management"), true, 3);
$default->siteMap->addPage("orgManagement", "/presentation/lookAndFeel/knowledgeTree/administration/orgmanagement/listOrgBL.php", "Administration", SysAdmin, _("Organisation Management"), true, 4);

$default->siteMap->addPage("doctype", "/presentation/lookAndFeel/knowledgeTree/administration/doctypemanagement/listDocTypesBL.php", "Administration", SysAdmin, _("Document Type Management"), true, 5);
$default->siteMap->addPage("docfield", "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/listDocFieldsBL.php", "Administration", SysAdmin, _("Document Field Management"), true, 6);

$default->siteMap->addPage("archivedDocuments", "/presentation/lookAndFeel/knowledgeTree/administration/documentmanagement/manageArchivedDocumentsBL.php", "Administration", UnitAdmin, _("Restore Archived Documents"), true, 7);
$default->siteMap->addPage("deletedDocuments", "/presentation/lookAndFeel/knowledgeTree/administration/documentmanagement/listDeletedDocumentsBL.php", "Administration", UnitAdmin, _("Deleted Documents"), true, 8);
$default->siteMap->addPage("doccheckoutManagement", "/presentation/lookAndFeel/knowledgeTree/administration/doccheckoutmanagement/listDocumentsBL.php", "Administration", UnitAdmin, _("Document Checkout Management"), true, 9);

$default->siteMap->addPage("newsManagement", "/presentation/lookAndFeel/knowledgeTree/administration/news/listNewsBL.php", "Administration", SysAdmin, _("Dashboard News Management"), true, 10);
$default->siteMap->addPage("linkManagement", "/presentation/lookAndFeel/knowledgeTree/administration/linkmanagement/listLinksBL.php", "Administration", SysAdmin, _("QuickLink Management"), true, 11);

$default->siteMap->addPage("roleManagement", "/presentation/lookAndFeel/knowledgeTree/administration/rolemanagement/listRolesBL.php", "Administration", SysAdmin, _("Role Management"), true, 12);
$default->siteMap->addPage("websiteManagement", "/presentation/lookAndFeel/knowledgeTree/administration/websitemanagement/listWebsitesBL.php", "Administration", SysAdmin, _("Website Management"), true, 13);

$default->siteMap->addPage("systemAdministration", "/presentation/lookAndFeel/knowledgeTree/administration/systemsettings/systemSettingsBL.php", "Administration", SysAdmin, _("System Settings"), true, 14);

$default->siteMap->addPage("browseAdministration", "/presentation/lookAndFeel/knowledgeTree/administration/browsemanagement/editBrowserBL.php", "Administration", SysAdmin, _("Browse Management"), true, 15);

$default->siteMap->addPage("docLinkManagement", "/presentation/lookAndFeel/knowledgeTree/administration/doclinkmanagement/listLinkTypesBL.php", "Administration", SysAdmin, _("Link Type Management"), true, 16);

//==================>>>>> Archivos anexados para el Dynamic List ==============>>>>>>

$default->siteMap->addPage("getCities", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getCities.php", "Manage Documents", User, _("GetCities"));
$default->siteMap->addPage("GetLugaresList", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/GetLugaresList.php", "Manage Documents", User, _("GetLugaresList"));
$default->siteMap->addPage("getEstados", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getEstados.php", "Manage Documents", User, _("GetEstados"));
$default->siteMap->addPage("getLugares", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getLugares.php", "Manage Documents", User, _("GetLugares"));
$default->siteMap->addPage("getconsulta", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getconsulta.php", "Manage Documents", User, _("Getconsulta"));

$default->siteMap->addPage("get4", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/get4.php", "Manage Documents", User, _("Get4"));

$default->siteMap->addPage("getup1", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getup1.php", "Manage Documents", User, _("getup1"));

$default->siteMap->addPage("getuphtml", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getuphtml.php", "Manage Documents", User, _("getuphtml"));

$default->siteMap->addPage("getlista", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlista.php", "Manage Documents", User, _("GetLista"));
$default->siteMap->addPage("getinserta", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getinserta.php", "Manage Documents", User, _("GetInseta"));
$default->siteMap->addPage("getficha", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getficha.php", "Manage Documents", User, _("Getficha"));

$default->siteMap->addPage("fetchedit", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/fetchedit.php", "Manage Documents", User, _("fetchedit"));

//=======================>>>> AREA ARCHIVOS PUSH.PHP =============>>>>
$default->siteMap->addPage("pushafrica", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushafrica.php", "Manage Documents", User, _("pushafrica"));
$default->siteMap->addPage("pushegypt", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushegypt.php", "Manage Documents", User, _("pushegypt"));

$default->siteMap->addPage("pushasia", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushasia.php", "Manage Documents", User, _("pushasia"));

$default->siteMap->addPage("pushsac", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushsac.php", "Manage Documents", User, _("pushsac"));

$default->siteMap->addPage("pusheurope", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pusheurope.php", "Manage Documents", User, _("pusheurope"));
$default->siteMap->addPage("pushsustainability", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushsustainability.php", "Manage Documents", User, _("pushsustainability"));

$default->siteMap->addPage("pushtechnology", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushtechnology.php", "Manage Documents", User, _("pushtechnology"));

$default->siteMap->addPage("pushcorporate", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushcorporate.php", "Manage Documents", User, _("pushcorporate"));

$default->siteMap->addPage("pushantitrust", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushantitrust.php", "Manage Documents", User, _("pushantitrust"));

$default->siteMap->addPage("pushantitrustother", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushantitrustother.php", "Manage Documents", User, _("pushantitrustother"));

$default->siteMap->addPage("pushnoam", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushnoam.php", "Manage Documents", User, _("pushnoam"));

$default->siteMap->addPage("pushtotal", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushtotal.php", "Manage Documents", User, _("pushtotal"));

$default->siteMap->addPage("pushgcorporate", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushgcorporate.php", "Manage Documents", User, _("pushgcorporate"));

$default->siteMap->addPage("pushmexicobm", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/pushmexicobm.php", "Manage Documents", User, _("pushmexicobm"));
//<<<<======================= TERMINA AREA PUSH.PHP <<<<=====================
//<<<<=======================  AREA SYSADM <<<<=====================
$default->siteMap->addPage("backzopes156", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/backzopes156.php", "Manage Documents", User, _("backzopes156"));
//<<<<=======================  Termina AREA SYSADM <<<<=====================

$default->siteMap->addPage("getword", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getword.php", "Manage Documents", User, _("getword"));
$default->siteMap->addPage("getwordsummwidg", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getwordsummwidg.php", "Manage Documents", User, _("getwordsummwidg"));

$default->siteMap->addPage("html2doc", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/html2doc.php", "Manage Documents", User, _("html2doc"));
$default->siteMap->addPage("dynlist", "/ajax-dynamic-list.php", "Manage Documents", User, _("Dynlist"));
//==============<<< Termina archivos anexados para el dynamic list <<<<=================
$default->siteMap->addPage("getindivevento", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getindivevento.php", "Manage Documents", User, _("getindivevento"));

$default->siteMap->addPage("getfev_w", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfev_w.php", "Manage Documents", User, _("getfev_w"));

$default->siteMap->addPage("getlistevent", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlistevent.php", "Manage Documents", User, _("getlistevent"));

$default->siteMap->addPage("getlisteventpesc", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlisteventpesc.php", "Manage Documents", User, _("getlisteventpesc"));

$default->siteMap->addPage("getfeventpesc_inst", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfeventpesc_inst.php", "Manage Documents", User, _("getfeventpesc_inst"));

$default->siteMap->addPage("getfeventpesc_indv", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfeventpesc_indv.php", "Manage Documents", User, _("getfeventpesc_indv"));

$default->siteMap->addPage("getlistdomic", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlistdomic.php", "Manage Documents", User, _("getlistdomic"));
$default->siteMap->addPage("getlistlug", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlistlug.php", "Manage Documents", User, _("getlistlug"));
$default->siteMap->addPage("getfLug", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfLug.php", "Manage Documents", User, _("getfLug"));

$default->siteMap->addPage("getlistprefe", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlistprefe.php", "Manage Documents", User, _("getlistprefe"));

$default->siteMap->addPage("getfeventpesc", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfeventpesc.php", "Manage Documents", User, _("getfeventpesc"));

$default->siteMap->addPage("getfeventb2b", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfeventb2b.php", "Manage Documents", User, _("getfeventb2b"));

$default->siteMap->addPage("getfeventb2b_indv", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfeventb2b_indv.php", "Manage Documents", User, _("getfeventb2b_indv"));
 $default->siteMap->addPage("getfeventb2b_inst", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfeventb2b_inst.php", "Manage Documents", User, _("getfeventb2b_inst"));


$default->siteMap->addPage("getleb2b2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getleb2b2.php", "Manage Documents", User, _("getleb2b2"));
$default->siteMap->addPage("getleindiv", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getleindiv.php", "Manage Documents", User, _("getleindiv"));
$default->siteMap->addPage("getrss1", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss1.php", "Manage Documents", User, _("getrss1"));

$default->siteMap->addPage("getrss2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getrss2.php", "Manage Documents", User, _("getrss2"));

$default->siteMap->addPage("gethtml1", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/gethtml1.php", "Manage Documents", User, _("gethtml1"));


$default->siteMap->addPage("gethtml2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/gethtml2.php", "Manage Documents", User, _("gethtml2"));


$default->siteMap->addPage("getsiuc", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getsiuc.php", "Manage Documents", User, _("getsiuc"));

$default->siteMap->addPage("getsiuc2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getsiuc2.php", "Manage Documents", User, _("getsiuc2"));



$default->siteMap->addPage("getquince", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getquince.php", "Manage Documents", User, _("getquince"));

$default->siteMap->addPage("getquince2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getquince2.php", "Manage Documents", User, _("getquince2"));


$default->siteMap->addPage("getdomq", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getdomq.php", "Manage Documents", User, _("getdomq"));

$default->siteMap->addPage("getdomq2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getdomq2.php", "Manage Documents", User, _("getdomq2"));

$default->siteMap->addPage("getpernod", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getpernod.php", "Manage Documents", User, _("getpernod"));

$default->siteMap->addPage("getpernodl", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getpernodl.php", "Manage Documents", User, _("getpernodl"));

$default->siteMap->addPage("getpernodf", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getpernodf.php", "Manage Documents", User, _("getpernodf"));



$default->siteMap->addPage("getpernod2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getpernod2.php", "Manage Documents", User, _("getpernod2"));

$default->siteMap->addPage("getipadpesc", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getipadpesc.php", "Manage Documents", User, _("getipadpesc"));

$default->siteMap->addPage("getipadpescl", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getipadpescl.php", "Manage Documents", User, _("getipadpescl"));

$default->siteMap->addPage("getipadpescf", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getipadpescf.php", "Manage Documents", User, _("getipadpescf"));



$default->siteMap->addPage("getipadpesc2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getipadpesc2.php", "Manage Documents", User, _("getipadpesc2"));


$default->siteMap->addPage("getsium", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getsium.php", "Manage Documents", User, _("getsium"));

$default->siteMap->addPage("getsium2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getsium2.php", "Manage Documents", User, _("getsium2"));

$default->siteMap->addPage("getleb2bmod", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getleb2bmod.php", "Manage Documents", User, _("getleb2bmod"));


$default->siteMap->addPage("getleb2bcsv", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getleb2bcsv.php", "Manage Documents", User, _("getleb2bcsv"));

$default->siteMap->addPage("getleb2bcsv2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getleb2bcsv2.php", "Manage Documents", User, _("getleb2bcsv2"));

$default->siteMap->addPage("getfindv_indv", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfindv_indv.php", "Manage Documents", User, _("getfindv_indv"));

$default->siteMap->addPage("getftray_indv", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getftray_indv.php", "Manage Documents", User, _("getftray_indv"));

$default->siteMap->addPage("getfevent_indv", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfevent_indv.php", "Manage Documents", User, _("getfevent_indv"));

$default->siteMap->addPage("getfpref_indv", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfpref_indv.php", "Manage Documents", User, _("getfpref_indv"));

$default->siteMap->addPage("getlisteventb2b", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlisteventb2b.php", "Manage Documents", User, _("getlisteventb2b"));


$default->siteMap->addPage("mindmaps", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/mindmaps.php", "Manage Documents", User, _("mindmaps"));

$default->siteMap->addPage("modifymindmap", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/modifyMindMap.php", "Manage Documents", User, _("modifymindmap"));

$default->siteMap->addPage("getmultimedia", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getmultimedia.php", "Manage Documents", User, _("getmultimedia"));


$default->siteMap->addPage("getfprod", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfprod.php", "Manage Documents", User, _("getfprod"));

$default->siteMap->addPage("getlistprod", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlistprod.php", "Manage Documents", User, _("getlistprod"));

$default->siteMap->addPage("getfinst", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfinst.php", "Manage Documents", User, _("getfinst"));

$default->siteMap->addPage("getfinst2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfinst2.php", "Manage Documents", User, _("getfinst"));

$default->siteMap->addPage("getfindv_domic", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfindv_domic.php", "Manage Documents", User, _("getfindv_domic"));

$default->siteMap->addPage("getfeventem_indv", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfeventem_indv.php", "Manage Documents", User, _("getfeventem_indv"));

$default->siteMap->addPage("getlistfin", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlistfin.php", "Manage Documents", User, _("getlistfin"));

$default->siteMap->addPage("getfinanzas", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfinanzas.php", "Manage Documents", User, _("getfinanzas"));

$default->siteMap->addPage("getlistInst", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlistInst.php", "Manage Documents", User, _("getlistInst"));
$default->siteMap->addPage("getlistInst2", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlistInst2.php", "Manage Documents", User, _("getlistInst2"));
$default->siteMap->addPage("getlistmult", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getlistmult.php", "Manage Documents", User, _("getlistmult"));
$default->siteMap->addPage("getfmult", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfmult.php", "Manage Documents", User, _("getfmult"));

$default->siteMap->addPage("getfprefe", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfprefe.php", "Manage Documents", User, _("getfprefe"));

$default->siteMap->addPage("getfevento", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfevento.php", "Manage Documents", User, _("getfevento"));
$default->siteMap->addPage("getfDomic", "/presentation/lookAndFeel/knowledgeTree/documentmanagement/getfDomic.php", "Manage Documents", User, _("getfDomic"));
//==================>>>>> se dio de alta reporte para sidem ==============>>>>>>
$default->siteMap->addPage("reporte", "/presentation/lookAndFeel/knowledgeTree/reportes/reporte_contactos.php", "Manage Documents", User, _("reporte"));

//==================>>>>> se dio de alta reporte general para sidem ==============>>>>>>
$default->siteMap->addPage("reporteg", "/presentation/lookAndFeel/knowledgeTree/reportes/reporte_general.php", "Manage Documents", User, _("reporte"));

//==================>>>>> Archivos anexados para Calendar ==============>>>>>>

$default->siteMap->addPage("calendario", "/calendar/datepicker.php", "Manage Documents", User, _("Calendario"));

//==============<<< Termina archivos anexados para el calendar <<<<=================

$default->siteMap->addSectionColour("Administration", "th", "056DCE");
$default->siteMap->addSectionColour("Administration", "td", "6699FF");

// user management
$default->siteMap->addDefaultPage("editUserGroups", "/presentation/lookAndFeel/knowledgeTree/administration/usermanagement/editUserGroupsBL.php", "Administration", UnitAdmin, "Edit User Groups", false);
$default->siteMap->addPage("listUsers", "/presentation/lookAndFeel/knowledgeTree/administration/usermanagement/listUsersBL.php", "Administration", UnitAdmin, "List Users", false);
$default->siteMap->addPage("addUser", "/presentation/lookAndFeel/knowledgeTree/administration/usermanagement/addUserBL.php", "Administration", SysAdmin, "Add User", false);
$default->siteMap->addDefaultPage("editUser", "/presentation/lookAndFeel/knowledgeTree/administration/usermanagement/editUserBL.php", "Administration", UnitAdmin, _("Edit User Properties"));
$default->siteMap->addDefaultPage("removeUser", "/presentation/lookAndFeel/knowledgeTree/administration/usermanagement/removeUserBL.php", "Administration", SysAdmin, "Remove User from System", false);

// group management
$default->siteMap->addDefaultPage("editGroupUnit", "/presentation/lookAndFeel/knowledgeTree/administration/groupmanagement/editGroupUnitBL.php", "Administration", UnitAdmin, "editGroupUnit", false);
$default->siteMap->addPage("listGroups", "/presentation/lookAndFeel/knowledgeTree/administration/groupmanagement/listGroupsBL.php", "Administration", UnitAdmin, "List Groups", false);
$default->siteMap->addPage("addGroup", "/presentation/lookAndFeel/knowledgeTree/administration/groupmanagement/addGroupBL.php", "Administration", UnitAdmin, "Add A Group", false);
$default->siteMap->addDefaultPage("editGroup", "/presentation/lookAndFeel/knowledgeTree/administration/groupmanagement/editGroupBL.php", "Administration", UnitAdmin, "Edit Group Properties", false);
$default->siteMap->addDefaultPage("editGroupSuccess", "/presentation/lookAndFeel/knowledgeTree/administration/groupmanagement/editGroupSuccess.php", "Administration", UnitAdmin, "Updated Group Successfully", false);
$default->siteMap->addDefaultPage("removeGroup", "/presentation/lookAndFeel/knowledgeTree/administration/groupmanagement/removeGroupBL.php", "Administration", UnitAdmin, "Remove a Group", false);
$default->siteMap->addDefaultPage("assignGroupToUnit", "/presentation/lookAndFeel/knowledgeTree/administration/groupmanagement/assignGroupToUnitBL.php", "Administration", UnitAdmin, "Assign Group to Unit", false);
$default->siteMap->addDefaultPage("removeGroupFromUnit", "/presentation/lookAndFeel/knowledgeTree/administration/groupmanagement/removeGroupFromUnitBL.php", "Administration", UnitAdmin, "Remove Group From Unit", false);
$default->siteMap->addDefaultPage("editGroupUsers", "/presentation/lookAndFeel/knowledgeTree/administration/groupmanagement/editGroupUsersBL.php", "Administration", UnitAdmin, "Edit Users's Group", false);

// Unit management
$default->siteMap->addPage("listUnits", "/presentation/lookAndFeel/knowledgeTree/administration/unitmanagement/listUnitsBL.php", "Administration", SysAdmin, "List Units", false);
$default->siteMap->addDefaultPage("editUnitOrg", "/presentation/lookAndFeel/knowledgeTree/administration/unitmanagement/editUnitOrgBL.php", "Administration", SysAdmin, "Edit Unit Organisations", false);
$default->siteMap->addDefaultPage("addUnitToOrg", "/presentation/lookAndFeel/knowledgeTree/administration/unitmanagement/addUnitToOrgBL.php", "Administration", SysAdmin, "Add Unit to Organisations", false);
$default->siteMap->addDefaultPage("removeUnitFromOrg", "/presentation/lookAndFeel/knowledgeTree/administration/unitmanagement/removeUnitFromOrgBL.php", "Administration", SysAdmin, "Remove Unit from Organisations", false);
$default->siteMap->addPage("addUnit", "/presentation/lookAndFeel/knowledgeTree/administration/unitmanagement/addUnitBL.php", "Administration", SysAdmin, "Add A Unit", false);
$default->siteMap->addDefaultPage("editUnit", "/presentation/lookAndFeel/knowledgeTree/administration/unitmanagement/editUnitBL.php", "Administration", SysAdmin, "Edit Unit Properties", false);
$default->siteMap->addPage("addUnitSuccess", "/presentation/lookAndFeel/knowledgeTree/administration/unitmanagement/addUnitSuccess.php", "Administration", SysAdmin, "Unit added Successfully", false);
$default->siteMap->addDefaultPage("removeUnit", "/presentation/lookAndFeel/knowledgeTree/administration/unitmanagement/removeUnitBL.php", "Administration", SysAdmin, "Remove a Unit", false);

// Organisation management
$default->siteMap->addPage("listOrg", "/presentation/lookAndFeel/knowledgeTree/administration/orgmanagement/listOrgBL.php", "Administration", SysAdmin, "List Organisations", false);
$default->siteMap->addPage("addOrg", "/presentation/lookAndFeel/knowledgeTree/administration/orgmanagement/addOrgBL.php", "Administration", SysAdmin, "Add An Organisation", false);
$default->siteMap->addDefaultPage("editOrg", "/presentation/lookAndFeel/knowledgeTree/administration/orgmanagement/editOrgBL.php", "Administration", SysAdmin, "Edit Organisation Properties", false);
$default->siteMap->addPage("addOrgSuccess", "/presentation/lookAndFeel/knowledgeTree/administration/orgmanagement/addOrgSuccess.php", "Administration", SysAdmin, "Organisation added Successfully", false);
$default->siteMap->addDefaultPage("removeOrg", "/presentation/lookAndFeel/knowledgeTree/administration/orgmanagement/removeOrgBL.php", "Administration", SysAdmin, "Remove an Organisation", false);

// document type stuff
$default->siteMap->addDefaultPage("addDocTypeFieldsLink", "/presentation/lookAndFeel/knowledgeTree/administration/doctypemanagement/addDocTypeFieldsLinkBL.php", "Administration", SysAdmin, "Add a Document Type to Fields Link", false);
$default->siteMap->addPage("addDocType", "/presentation/lookAndFeel/knowledgeTree/administration/doctypemanagement/addDocTypeBL.php", "Administration", SysAdmin, "Add a Document Type", false);
$default->siteMap->addPage("addDocTypeSuccess", "/presentation/lookAndFeel/knowledgeTree/administration/doctypemanagement/addDocTypeSuccess.php", "Administration", SysAdmin, "Add a Document Type success", false);
$default->siteMap->addDefaultPage("editDocType", "/presentation/lookAndFeel/knowledgeTree/administration/doctypemanagement/editDocTypeBL.php", "Administration", SysAdmin, "Edit a Document Type", false);
$default->siteMap->addDefaultPage("editDocTypeFields", "/presentation/lookAndFeel/knowledgeTree/administration/doctypemanagement/editDocTypeFieldsBL.php", "Administration", SysAdmin, "Edit Document Type Fields", false);
$default->siteMap->addPage("listDocTypes", "/presentation/lookAndFeel/knowledgeTree/administration/doctypemanagement/listDocTypesBL.php", "Administration", SysAdmin, "List Document Types", false);
$default->siteMap->addDefaultPage("removeDocType", "/presentation/lookAndFeel/knowledgeTree/administration/doctypemanagement/removeDocTypeBL.php", "Administration", SysAdmin, "Remove a Document Type", false);

// doc field stuff
$default->siteMap->addPage("listDocFields", "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/listDocFieldsBL.php", "Administration", SysAdmin, "List Document Fields", false);
$default->siteMap->addPage("addDocField", "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/addDocFieldBL.php", "Administration", SysAdmin, "Add a Document Field", false);
$default->siteMap->addPage("addDocFieldSuccess", "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/addDocFieldSuccess.php", "Administration", SysAdmin, "Add a Document Field success", false);
$default->siteMap->addDefaultPage("editDocField", "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/editDocFieldBL.php", "Administration", SysAdmin, "Edit a Document Field", false);
$default->siteMap->addDefaultPage("removeDocField", "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/removeDocFieldBL.php", "Administration", SysAdmin, "Remove a Document Field", false);
$default->siteMap->addDefaultPage("editDocFieldLookups", "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/editDocFieldLookupsBL.php", "Administration", SysAdmin, "Edit Document Field Lookups", false);
//metadata
$default->siteMap->addDefaultPage("editMetadataForField", "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/metadatamanagement/editMetaDataBL.php", "Administration", SysAdmin, "Edit Document Field Lookups", false);
$default->siteMap->addDefaultPage("addMetaDataForField",  "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/metadatamanagement/addMetaDataBL.php", "Administration", SysAdmin, "Add Document Field Lookups", false);
$default->siteMap->addDefaultPage("removeMetaDataFromField",  "/presentation/lookAndFeel/knowledgeTree/administration/docfieldmanagement/metadatamanagement/removeMetaDataBL.php", "Administration", SysAdmin, "Remove Document Field Lookups", false);

// deleted documents
$default->siteMap->addPage("expungeDeletedDocuments", "/presentation/lookAndFeel/knowledgeTree/administration/documentmanagement/expungeDeletedDocumentsBL.php", "Administration", UnitAdmin, "Expunge Deleted Documents", false);
$default->siteMap->addPage("restoreDeletedDocument", "/presentation/lookAndFeel/knowledgeTree/administration/documentmanagement/restoreDeletedDocumentBL.php", "Administration", UnitAdmin, "Restore Deleted Document", false);

// document checkout management
$default->siteMap->addPage("listDocs", "/presentation/lookAndFeel/knowledgeTree/administration/doccheckoutmanagement/listDocumentsBL.php", "Administration", UnitAdmin, "List Documents", false);
$default->siteMap->addPage("editDocCheckout", "/presentation/lookAndFeel/knowledgeTree/administration/doccheckoutmanagement/editDocCheckoutBL.php", "Administration", UnitAdmin, "Edit Document Checkout", false);

// news management
$default->siteMap->addPage("listNews", "/presentation/lookAndFeel/knowledgeTree/administration/news/listNewsBL.php", "Administration", SysAdmin, "List News Items", false);
$default->siteMap->addPage("addNews", "/presentation/lookAndFeel/knowledgeTree/administration/news/addNewsBL.php", "Administration", SysAdmin, "Add A News Item", false);
$default->siteMap->addPage("editNews", "/presentation/lookAndFeel/knowledgeTree/administration/news/editNewsBL.php", "Administration", SysAdmin, "", false);
$default->siteMap->addPage("previewNews", "/presentation/lookAndFeel/knowledgeTree/administration/news/previewNewsBL.php", "Administration", SysAdmin, "", false);
$default->siteMap->addPage("removeNews", "/presentation/lookAndFeel/knowledgeTree/administration/news/removeNewsBL.php", "Administration", SysAdmin, "", false);

// link management
$default->siteMap->addPage("listLinks", "/presentation/lookAndFeel/knowledgeTree/administration/linkmanagement/listLinksBL.php", "Administration", SysAdmin, "List Links", false);
$default->siteMap->addPage("addLink", "/presentation/lookAndFeel/knowledgeTree/administration/linkmanagement/addLinkBL.php", "Administration", SysAdmin, "Add A Link", false);
$default->siteMap->addPage("addLinkSuccess", "/presentation/lookAndFeel/knowledgeTree/administration/linkmanagement/addLinkSuccess.php", "Administration", SysAdmin, "Add A Link Success ", false);
$default->siteMap->addDefaultPage("editLink", "/presentation/lookAndFeel/knowledgeTree/administration/linkmanagement/editLinkBL.php", "Administration", SysAdmin, "Edit Link Properties", false);
$default->siteMap->addDefaultPage("removeLink", "/presentation/lookAndFeel/knowledgeTree/administration/linkmanagement/removeLinkBL.php", "Administration", SysAdmin, "Remove a Link", false);

// rolemanagement
$default->siteMap->addPage("listRoles", "/presentation/lookAndFeel/knowledgeTree/administration/rolemanagement/listRolesBL.php", "Administration", SysAdmin, "List Roles", false);
$default->siteMap->addPage("addRole", "/presentation/lookAndFeel/knowledgeTree/administration/rolemanagement/addRoleBL.php", "Administration", SysAdmin, "Add New Role", false);
$default->siteMap->addDefaultPage("editRole", "/presentation/lookAndFeel/knowledgeTree/administration/rolemanagement/editRoleBL.php", "Administration", SysAdmin, "Edit Role Properties", false);
$default->siteMap->addDefaultPage("editRoleSuccess", "/presentation/lookAndFeel/knowledgeTree/administration/rolemanagement/editRoleSuccess.php", "Administration", SysAdmin, "Edit Role Properties", false);
$default->siteMap->addDefaultPage("removeRole", "/presentation/lookAndFeel/knowledgeTree/administration/rolemanagement/removeRoleBL.php", "Administration", SysAdmin, "Remove a Role", false);

//website management
$default->siteMap->addPage("listWebsites", "/presentation/lookAndFeel/knowledgeTree/administration/websitemanagement/listWebsitesBL.php", "Administration", SysAdmin, "List Websites", false);
$default->siteMap->addPage("addWebsite", "/presentation/lookAndFeel/knowledgeTree/administration/websitemanagement/addWebsiteBL.php", "Administration", SysAdmin, "Add a Website", false);
$default->siteMap->addPage("addWebsiteSuccess", "/presentation/lookAndFeel/knowledgeTree/administration/websitemanagement/addWebsiteSuccess.php", "Administration", SysAdmin, "Add A Website Success ",false);
$default->siteMap->addDefaultPage("editWebSite", "/presentation/lookAndFeel/knowledgeTree/administration/websitemanagement/editWebsiteBL.php", "Administration", SysAdmin, "Edit Website", false);
$default->siteMap->addDefaultPage("removeWebSite", "/presentation/lookAndFeel/knowledgeTree/administration/websitemanagement/removeWebsiteBL.php", "Administration", SysAdmin, "Remove a Website", false);

// pages for subscriptions section
$default->siteMap->addDefaultPage("manageSubscriptions", "/presentation/lookAndFeel/knowledgeTree/subscriptions/manageSubscriptionsBL.php", "Subscriptions", User, _("Manage Subscriptions"));
$default->siteMap->addPage("viewAlert", "/presentation/lookAndFeel/knowledgeTree/subscriptions/viewAlertBL.php", "Subscriptions", User, "Subscriptions", false);

$default->siteMap->addSectionColour("Subscriptions", "th", "FFC602");

// pages for advanced search section
$default->siteMap->addDefaultPage("advancedSearch", "/presentation/lookAndFeel/knowledgeTree/search/advancedSearchBL.php", "Advanced Search", Guest, _("Advanced Search"), true);
$default->siteMap->addPage("standardSearch", "/presentation/lookAndFeel/knowledgeTree/search/standardSearchBL.php", "Standard Search", Guest, _("Standard Search"), false);

$default->siteMap->addSectionColour("Advanced Search", "th", "A1571B");
$default->siteMap->addSectionColour("Standard Search", "th", "A1571B");

// pages for prefs section
$default->siteMap->addDefaultPage("preferences", "/presentation/lookAndFeel/knowledgeTree/preferences/editUserPrefsBL.php", "Preferences", User, _("Preferences"));
$default->siteMap->addPage("editPrefsSuccess", "/presentation/lookAndFeel/knowledgeTree/preferences/editPrefsSuccess.php", "Preferences", User, "Preferences", false);
$default->siteMap->addPage("changeUserPassword", "/presentation/lookAndFeel/knowledgeTree/preferences/passwordManagementBL.php", "Preferences", User, "Preferences", false);
$default->siteMap->addSectionColour("Preferences", "th", "F87308");
$default->siteMap->addSectionColour("Preferences", "td", "FEE3CE");

// pages for Help section
$default->siteMap->addDefaultPage("help", "/presentation/lookAndFeel/knowledgeTree/help.php", "Help", Guest, _("Help"));

// pages for logout section section
$default->siteMap->addDefaultPage("logout", "/presentation/logout.php", "Logout", Guest, _("Logout"));

// pages for discussion threads
$default->siteMap->addDefaultPage("viewDiscussion", "/presentation/lookAndFeel/knowledgeTree/discussions/viewDiscussionBL.php", "Discussion Threads", User, false); 
$default->siteMap->addDefaultPage("viewComment", "/presentation/lookAndFeel/knowledgeTree/discussions/viewCommentBL.php", "Discussion Threads", User, false);
$default->siteMap->addDefaultPage("addComment", "/presentation/lookAndFeel/knowledgeTree/discussions/addCommentBL.php", "Discussion Threads", User, false); 

$default->siteMap->addSectionColour("Discussion Threads", "td", "BDDFE0");
$default->siteMap->addSectionColour("Discussion Threads", "th", "57AFAE");

// Document link management
$default->siteMap->addPage("listLinkTypes", "/presentation/lookAndFeel/knowledgeTree/administration/doclinkmanagement/listLinkTypesBL.php", "Administration", SysAdmin, "List Link Types", false);
$default->siteMap->addPage("addLinkType", "/presentation/lookAndFeel/knowledgeTree/administration/doclinkmanagement/addLinkTypeBL.php", "Administration", SysAdmin, "Add A Link Type", false);
$default->siteMap->addPage("addLinkTypeSuccess", "/presentation/lookAndFeel/knowledgeTree/administration/doclinkmanagement/addLinkTypeSuccess.php", "Administration", SysAdmin, "Add A Link Type Success ", false);
$default->siteMap->addDefaultPage("editLinkType", "/presentation/lookAndFeel/knowledgeTree/administration/doclinkmanagement/editLinkTypeBL.php", "Administration", SysAdmin, _("Edit Link Type Properties"), false);
$default->siteMap->addDefaultPage("removeLinkType", "/presentation/lookAndFeel/knowledgeTree/administration/doclinkmanagement/removeLinkTypeBL.php", "Administration", SysAdmin, _("Remove a Link Type"), false);

?>
