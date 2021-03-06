<?php
/**
 * $Id: tableMappings.inc,v 1.4 2005/06/13 21:31:23 nbm Exp $
 *
 * Stores the table mappings.
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
 
// Table mappings
// session information
$default->sessions_table = "active_sessions";
//data types table
$default->data_types_table ="data_types";
// document type fields
$default->document_fields_table = "document_fields";

//---------------------
// links document abajo se cambio por la tabla de documentos
$default->document_fields_link_table = "documents";

// document subscriptions
$default->document_subscriptions_table = "document_subscriptions";
// document transaction types
$default->transaction_types_table = "document_transaction_types_lookup";
// document transactions
$default->document_transactions_table = "document_transactions";
// links document types to document type fields
$default->document_type_fields_table = "document_type_fields_link";
// document type information
$default->document_types_table = "document_types_lookup";
// stores documents
$default->documents_table = "documents";
//link folders to doc types
$default->folder_doctypes_table = "folder_doctypes_link";
// stores folder subscriptions
$default->folder_subscriptions_table = "folder_subscriptions";
// stores folders
$default->folders_table = "folders";
// links folders to users (and roles) for approval collaboration
$default->folders_user_roles_table = "folders_users_roles_link";
// stores approval collaboration information- approval roles mapped to folders with order
$default->groups_folders_approval_table = "groups_folders_approval_link";
// links groups to folders
$default->groups_folders_table = "groups_folders_link";
// stores group information
$default->groups_table = "groups_lookup";
// links groups to units
$default->groups_units_table = "groups_units_link";
// links
$default->quicklinks_table = "links";
// Table with metadata
$default->metadata_table = "metadata_lookup";
// Table with mime info
$default->mimetypes_table = "mime_types";
// dashboard news table
$default->news_table = "news";
// organisation information
$default->organisations_table = "organisations_lookup";
// stores role information (name and access)
$default->roles_table = "roles";
// sitemap access classes
$default->site_access_table = "site_access_lookup";
// sitemap sections
$default->site_sections_table = "site_sections_lookup";
// sitemap definition
$default->sitemap_table = "sitemap";
// stores default system settings
$default->system_settings_table = "system_settings";
// Table with discussion threads 
$default->discussion_threads_table = "discussion_threads";
// Table with discussion comments
$default->discussion_comments_table = "discussion_comments";
// Table with unit information
$default->units_table = "units_lookup";
// Table with unit organisation link tables
$default->units_organisations_table = "units_organisations_link";
// Table with user info
$default->users_table = "users";
// links groups to users
$default->users_groups_table = "users_groups_link";
// Table with web documents info for web publishing
$default->web_documents_table = "web_documents";
// Table with web documents info for web publishing
$default->web_documents_status_table = "web_documents_status_lookup";
// stores websites for web publishing
$default->web_sites_table = "web_sites";
//stores help text
$default->help_table = "help";
$default->document_text_table = "document_text";
$default->dependant_document_template_table = "dependant_document_template";
$default->dependant_document_instance_table = "dependant_document_instance";
$default->document_link_table = "document_link";
// archive settings
$default->document_archiving_table = "document_archiving_link";
$default->archiving_type_lookup_table = "archiving_type_lookup";
$default->archiving_settings_table = "archiving_settings";
$default->time_period_table = "time_period";
$default->time_unit_lookup_table = "time_unit_lookup";
$default->archive_restoration_table = "archive_restoration_request";
$default->status_table = "status_lookup";
$default->search_permissions_table = "search_document_user_link";

//----------------------------
//Abajo otra modificacion que unifica tablas con enlaces, un enlace es una tabla

$default->document_link_types_table = "document_types_lookup";
$default->upgrades_table = "upgrades";
?>
