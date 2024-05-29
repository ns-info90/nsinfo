<?php
/* Copyright (C) 2004-2017 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2022-2024 Nicolas SILOBRE <contact@ns-info.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    nsinfo/admin/about.php
 * \ingroup nsinfo
 * \brief   About page of module Nsinfo.
 */

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) { $i--; $j--; }
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) $res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) $res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
// Try main.inc.php using relative path
if (!$res && file_exists("../../main.inc.php")) $res = @include "../../main.inc.php";
if (!$res && file_exists("../../../main.inc.php")) $res = @include "../../../main.inc.php";
if (!$res) die("Include of main fails");

// Libraries
require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';
dol_include_once('/nsinfo/lib/nsinfo.lib.php');

// Access control
if (!$user->admin) accessforbidden();

// Parameters
$action = GETPOST('action', 'alpha');
$backtopage = GETPOST('backtopage', 'alpha');
$namemodule = GETPOST('namemodule', 'alpha');

$modM = ucfirst($namemodule);

dol_include_once('/'.$namemodule.'/lib/'.$namemodule.'.lib.php');


// Translations
$langs->loadLangs(array("errors", "admin", "nsinfo@nsinfo", "${namemodule}@${namemodule}"));

/*
 * Actions
 */

// None


/*
 * View
 */

$form = new Form($db);

$page_name = "About";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="'.($backtopage ? $backtopage : DOL_URL_ROOT.'/admin/modules.php?restore_lastsearch_values=1').'">'.$langs->trans("BackToModuleList").'</a>';

print load_fiche_titre($langs->trans($page_name), $linkback, "object_${namemodule}@${namemodule}");

// Configuration header
$namehead = $namemodule."AdminPrepareHead";
$head = $namehead();

print dol_get_fiche_head($head, 'about', $langs->trans("About"), -1, "${namemodule}@${namemodule}");

dol_include_once('/'.$namemodule.'/core/modules/mod'.ucfirst($namemodule).'.class.php');

$nameMod = "mod".$modM;
$tmpmodule = new $nameMod($db);
print '<a href="https://www.ns-info.fr" border=0 target="_blank"><img src="../img/nsinfo.png" width="200" align="right"></a>';
print '<table width="100%"><tr>' . "\n";
print '<td width="310px"><a href="https://www.ns-info.fr" border=0 target="_blank"><img src="../img/nsinfo.png" width="300" /></a></td>' . "\n";
print '<td align="left" valign="top"><p>' . $langs->trans("NSINFOAboutDesc1") .
											$langs->trans("NSINFOAboutDesc2").
											$langs->trans("NSINFOAboutDesc3").
											$langs->trans("NSINFOAboutDesc4");
if (strlen($langs->transnoentities("NSINFOAboutDesc5")) > 16) print $langs->transnoentities("NSINFOAboutDesc5");
print '</p></td>' . "\n";

print '</tr></table>' . "\n";

// Page end
dol_fiche_end();
llxFooter();
$db->close();
