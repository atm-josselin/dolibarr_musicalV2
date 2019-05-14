<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *	\file		lib/musicalv2.lib.php
 *	\ingroup	musicalv2
 *	\brief		This file is an example module library
 *				Put some comments here
 */

function musicalv2AdminPrepareHead()
{
    global $langs, $conf;

    $langs->load("musicalv2@musicalv2");

    $h = 0;
    $head = array();

    $head[$h][0] = dol_buildpath("/musicalv2/admin/musicalv2_setup.php", 1);
    $head[$h][1] = $langs->trans("Parameters");
    $head[$h][2] = 'settings';
    $h++;
    $head[$h][0] = dol_buildpath("/musicalv2/admin/musicalv2_about.php", 1);
    $head[$h][1] = $langs->trans("About");
    $head[$h][2] = 'about';
    $h++;
    $head[$h][0] = dol_buildpath("/musicalv2/admin/musicalv2_extrafields.php", 1);
    $head[$h][1] = $langs->trans("ExtraFields");
    $head[$h][2] = 'extrafields';
    $h++;

    // Show more tabs from modules
    // Entries must be declared in modules descriptor with line
    //$this->tabs = array(
    //	'entity:+tabname:Title:@musicalv2:/musicalv2/mypage.php?id=__ID__'
    //); // to add new tab
    //$this->tabs = array(
    //	'entity:-tabname:Title:@musicalv2:/musicalv2/mypage.php?id=__ID__'
    //); // to remove a tab
    complete_head_from_modules($conf, $langs, $object, $head, $h, 'musicalv2');

    return $head;
}

/**
 * Return array of tabs to used on pages for third parties cards.
 *
 * @param 	MusicalV2	$object		Object company shown
 * @return 	array				Array of tabs
 */
function musicalv2_prepare_head(MusicalV2 $object)
{
    global $db, $langs, $conf, $user;
    $h = 0;
    $head = array();
    $head[$h][0] = dol_buildpath('/musicalv2/card.php', 1).'?id='.$object->id;
    $head[$h][1] = $langs->trans("MusicalV2Card");
    $head[$h][2] = 'card';
    $h++;
	
	// Show more tabs from modules
    // Entries must be declared in modules descriptor with line
    // $this->tabs = array('entity:+tabname:Title:@musicalv2:/musicalv2/mypage.php?id=__ID__');   to add new tab
    // $this->tabs = array('entity:-tabname:Title:@musicalv2:/musicalv2/mypage.php?id=__ID__');   to remove a tab
    complete_head_from_modules($conf,$langs,$object,$head,$h,'musicalv2');
	
	return $head;
}

function getFormConfirmMusicalV2(&$PDOdb, &$form, &$object, $action)
{
    global $langs,$conf,$user;

    $formconfirm = '';

    if ($action == 'validate' && !empty($user->rights->musicalv2->write))
    {
        $text = $langs->trans('ConfirmValidateMusicalV2', $object->ref);
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('ValidateMusicalV2'), $text, 'confirm_validate', '', 0, 1);
    }
    elseif ($action == 'delete' && !empty($user->rights->musicalv2->write))
    {
        $text = $langs->trans('ConfirmDeleteMusicalV2');
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('DeleteMusicalV2'), $text, 'confirm_delete', '', 0, 1);
    }
    elseif ($action == 'clone' && !empty($user->rights->musicalv2->write))
    {
        $text = $langs->trans('ConfirmCloneMusicalV2', $object->ref);
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('CloneMusicalV2'), $text, 'confirm_clone', '', 0, 1);
    }

    return $formconfirm;
}