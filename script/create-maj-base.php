<?php
/*
 * Script créant et vérifiant que les champs requis s'ajoutent bien
 */

if(!defined('INC_FROM_DOLIBARR')) {
	define('INC_FROM_CRON_SCRIPT', true);

	require('../config.php');
} else {
	global $db;
}


/* uncomment


dol_include_once('/musicalv2/class/musicalv2.class.php');

$o=new MusicalV2($db);
$o->init_db_by_vars();
*/
