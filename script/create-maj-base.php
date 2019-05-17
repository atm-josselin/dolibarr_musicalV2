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

dol_include_once('/musicalv2/class/musicalv2.class.php');
dol_include_once('/musicalv2/class/instrument_category.class.php');

$o=new MusicalV2($db);
$o->init_db_by_vars();

$datas = array(
    '1' => array(
        'label' => 'Bois',
        'defaultPrice' => '180',
        'active' => '1',
    ),
    '2' => array(
        'label' => 'Cuivre',
        'defaultPrice' => '252.36',
        'active' => '1',
    ),
    '3' => array(
        'label' => 'Corde',
        'defaultPrice' => '156852.05',
        'active' => '1',
    ),
    '4' => array(
        'label' => 'Clavier',
        'defaultPrice' => '0.56',
        'active' => '1',
    ),
);

$c = new InstrumentCategory($db);
$c->init_db_by_vars();
$c->addData($datas);

