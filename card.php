<?php

require 'config.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/functions.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.form.class.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
dol_include_once('/musicalv2/class/musicalv2.class.php');
dol_include_once('/musicalv2/lib/musicalv2.lib.php');
dol_include_once('/musicalv2/class/instrument_category.class.php');
dol_include_once('/musicalv2/class/instrument_category_links.class.php');

if(empty($user->rights->musicalv2->read)) accessforbidden();

$langs->load('musicalv2@musicalv2');

$action = GETPOST('action');
$id = GETPOST('id', 'int');
$ref = GETPOST('ref');

$mode = 'view';
if (empty($user->rights->musicalv2->write)) $mode = 'view'; // Force 'view' mode if can't edit object
else if ($action == 'create' || $action == 'edit') $mode = 'edit';

$object = new MusicalV2($db);
$instrument_categories = new InstrumentCategory($db);
$category_links = new InstrumentCategoryLinks($db);

$object->load($id, '');

$hookmanager->initHooks(array('musicalv2card', 'globalcard'));

/*
 * Actions
 */

$parameters = array('id' => $id, 'ref' => $ref, 'mode' => $mode);
$reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action); // Note that $action and $object may have been modified by some
if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
// Si vide alors le comportement n'est pas remplacé
if (empty($reshook))
{
	$error = 0;
	switch ($action) {
		case 'save':
			$object->setValues($_REQUEST); // Set standard attributes

			if ($error > 0)
			{
				$mode = 'edit';
				break;
			}

			$object->save(empty($object->ref));

			header('Location: '.dol_buildpath('/musicalv2/card.php', 1).'?id='.$object->id);
			exit;

			break;
		case 'confirm_clone':
			$object->cloneObject();
			header('Location: '.dol_buildpath('/musicalv2/card.php', 1).'?id='.$object->id);
			exit;
			break;

		case 'modif':
			break;

		case 'confirm_validate':

			header('Location: '.dol_buildpath('/musicalv2/card.php', 1).'?id='.$object->id);
			exit;
			break;
		case 'confirm_delete':
			if (!empty($user->rights->musicalv2->write)) $object->delete($user);

			header('Location: '.dol_buildpath('/musicalv2/list.php', 1));
			exit;
			break;
		// link from llx_element_element
		case 'dellink':
			$object->generic->deleteObjectLinked(null, '', null, '', GETPOST('dellinkid'));
			header('Location: '.dol_buildpath('/musicalv2/card.php', 1).'?id='.$object->id);
			exit;
			break;
	}
}

if(isset($_GET['fk_product'])){
    $prodId = GETPOST('fk_product','int');
    $product = new Product($db);
    $product->fetch($prodId);
    $object->label = $product->label;
    $object->ref = $product->ref;
    $object->price = $product->price;
    $object->fk_product = $product->id;
}

$prodRef = '';

if (!empty($object->fk_product) && $mode=='view'){
    if ($object->fk_product > 0){
        $product = new Product($db);
        $product->fetch($object->fk_product);
        $prodRef = $product->getNomUrl(1,'','');
    }
}

/**
 * View
 */

$title=$langs->trans("MusicalV2");
llxHeader('',$title);

if ($action == 'create' && $mode == 'edit')
{
	echo load_fiche_titre($langs->trans("NewMusicalV2"));
	dol_fiche_head();
}
else
{
	$head = musicalv2_prepare_head($object);
	$picto = 'generic';
	dol_fiche_head($head, 'card', $langs->trans("MusicalV2"), 0, $picto);
}

$formcore = new TFormCore;
$formcore->Set_typeaff($mode);

$form = new Form($db);

$formconfirm = getFormConfirmMusicalV2($PDOdb, $form, $object, $action);
if (!empty($formconfirm)) echo $formconfirm;

$TBS=new TTemplateTBS();
$TBS->TBS->protect=false;
$TBS->TBS->noerr=true;

if ($mode == 'edit') echo $formcore->begin_form($_SERVER['PHP_SELF'], 'form_musicalv2');

$cat = $category_links->getProductCategory($object->id);

$linkback = '<a href="'.dol_buildpath('/musicalv2/list.php', 1).'">' . $langs->trans("BackToList") . '</a>';
print $TBS->render('tpl/card.tpl.php'
	,array() // Block
	,array(
		'object'=>$object
		,'view' => array(
			'mode' => $mode
			,'action' => 'save'
			,'urlcard' => dol_buildpath('/musicalv2/card.php', 1)
			,'urllist' => dol_buildpath('/musicalv2/list.php', 1)
			,'showLabel'    => $formcore->texte('', 'label', $object->label, 80, 255)
            ,'showRef'      => $formcore->texte('', 'ref', $object->ref, 80, 255)
            ,'showSerial'   => $formcore->texte('', 'serial', $object->serial, 80, 255)
            ,'showPrice'    => $formcore->texte('','price', price($object->price),80,255,'','','')
            ,'showProduct'  =>
                $mode == 'view'
                ? $formcore->zonetexte('','fk_product', $prodRef , 1, 1)
                : $formcore->hidden('fk_product',$object->fk_product)
            ,'showCategory' => (
                $mode == 'view'
                ? $cat['label']
                : $form->selectarray('category',$instrument_categories->getArray(),$cat['id'],'1','')
		    )
        )
		,'langs' => $langs
		,'user' => $user
		,'conf' => $conf
	)
);

if ($mode == 'edit') echo $formcore->end_form();

llxFooter();
$db->close();
