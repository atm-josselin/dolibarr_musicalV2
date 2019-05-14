<?php
/* Copyright (C) 2001-2002	Rodolphe Quiedeville	<rodolphe@quiedeville.org>
 * Copyright (C) 2003		Jean-Louis Bergamo		<jlb@j1b.org>
 * Copyright (C) 2004-2011	Laurent Destailleur		<eldy@users.sourceforge.net>
 * Copyright (C) 2012		Regis Houssin			<regis.houssin@inodbox.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *      \file       admin/musicalv2_extrafields.php
 *		\ingroup    musicalv2
 *		\brief      Page to setup extra fields of musicalv2
 */

$res = @include("../../main.inc.php"); // From htdocs directory
if (! $res) {
    $res = @include("../../../main.inc.php"); // From "custom" directory
}


/*
 * Config of extrafield page for MusicalV2
 */
require_once '../lib/musicalv2.lib.php';
require_once '../class/musicalv2.class.php';
$langs->loadLangs(array("musicalv2@musicalv2", "admin", "other"));

$musicalv2 = new MusicalV2($db);
$elementtype=$musicalv2->table_element;  //Must be the $table_element of the class that manage extrafield

// Page title and texts elements
$textobject=$langs->transnoentitiesnoconv("MusicalV2");
$help_url='EN:Help MusicalV2|FR:Aide MusicalV2';
$pageTitle = $langs->trans("MusicalV2ExtrafieldPage");

// Configuration header
$head = musicalv2AdminPrepareHead();



/*
 *  Include of extrafield page
 */

require_once dol_buildpath('abricot/tpl/extrafields_setup.tpl.php'); // use this kind of call for variables scope
