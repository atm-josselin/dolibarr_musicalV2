<?php
/* Copyright (C) 2003      Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2012 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@capnetworks.com>
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
 * 	\defgroup   musicalv2     Module MusicalV2
 *  \brief      Example of a module descriptor.
 *				Such a file must be copied into htdocs/musicalv2/core/modules directory.
 *  \file       htdocs/musicalv2/core/modules/modMusicalV2.class.php
 *  \ingroup    musicalv2
 *  \brief      Description and activation file for module MusicalV2
 */
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';


/**
 *  Description and activation class for module MusicalV2
 */
class modMusicalV2 extends DolibarrModules
{
	/**
	 *   Constructor. Define names, constants, directories, boxes, permissions
	 *
	 *   @param      DoliDB		$db      Database handler
	 */
	function __construct($db)
	{
        global $langs,$conf;

        $this->db = $db;

		$this->editor_name = 'ATM-Consulting';
		$this->editor_url = 'https://www.atm-consulting.fr';

		// Id for module (must be unique).
		// Use here a free id (See in Home -> System information -> Dolibarr for list of used modules id).
		$this->numero = 500505; // 104000 to 104999 for ATM CONSULTING
		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'musicalv2';

		// Family can be 'crm','financial','hr','projects','products','ecm','technic','other'
		// It is used to group modules in module setup page
		$this->family = "ATM";
		// Module label (no space allowed), used if translation string 'ModuleXXXName' not found (where XXX is value of numeric property 'numero' of module)
		$this->name = preg_replace('/^mod/i','',get_class($this));
		// Module description, used if translation string 'ModuleXXXDesc' not found (where XXX is value of numeric property 'numero' of module)
		$this->description = "Description of module MusicalV2";
		// Possible values for version are: 'development', 'experimental', 'dolibarr' or version
		$this->version = '1.0.0';
		// Key used in llx_const table to save module status enabled/disabled (where MYMODULE is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Where to store the module in setup page (0=common,1=interface,2=others,3=very specific)
		$this->special = 0;
		// Name of image file used for this module.
		// If file is in theme/yourtheme/img directory under name object_pictovalue.png, use this->picto='pictovalue'
		// If file is in module/img directory under name object_pictovalue.png, use this->picto='pictovalue@module'
		$this->picto='musicalv2@musicalv2';

		// Defined all module parts (triggers, login, substitutions, menus, css, etc...)
		// for default path (eg: /musicalv2/core/xxxxx) (0=disable, 1=enable)
		// for specific path of parts (eg: /musicalv2/core/modules/barcode)
		// for specific css file (eg: /musicalv2/css/musicalv2.css.php)
		$this->module_parts = array(
		                        	'triggers' => 1,                                 	// Set this to 1 if module has its own trigger directory (core/triggers)
									'login' => 0,                                    	// Set this to 1 if module has its own login method directory (core/login)
									'substitutions' => 0,                            	// Set this to 1 if module has its own substitution function file (core/substitutions)
									'menus' => 0,                                    	// Set this to 1 if module has its own menus handler directory (core/menus)
									'theme' => 0,                                    	// Set this to 1 if module has its own theme directory (theme)
		                        	'tpl' => 0,                                      	// Set this to 1 if module overwrite template dir (core/tpl)
									'barcode' => 0,                                  	// Set this to 1 if module has its own barcode directory (core/modules/barcode)
									'models' => 1,                                   	// Set this to 1 if module has its own models directory (core/modules/xxx)
									'css' => array('/musicalv2/css/musicalv2.css.php'),	// Set this to relative path of css file if module has its own css file
	 								'js' => array('/musicalv2/js/musicalv2.js'),          // Set this to relative path of js file if module must load a js on all pages
									'hooks' => array('productcard','propalcard'),  	// Set here all hooks context managed by module
		                        );

		// Data directories to create when module is enabled.
		// Example: this->dirs = array("/musicalv2/temp");
		$this->dirs = array();

		// Config pages. Put here list of php page, stored into musicalv2/admin directory, to use to setup module.
		$this->config_page_url = array("musicalv2_setup.php@musicalv2");

		// Dependencies
		$this->hidden = false;			// A condition to hide module
		$this->depends = array();		// List of modules id that must be enabled if this module is enabled
		$this->requiredby = array();	// List of modules id to disable if this one is disabled
		$this->conflictwith = array();	// List of modules id this module is in conflict with
		$this->phpmin = array(5,0);					// Minimum version of PHP required by module
		$this->need_dolibarr_version = array(3,0);	// Minimum version of Dolibarr required by module
		$this->langfiles = array("musicalv2@musicalv2");

		// Constants
		// List of particular constants to add when module is enabled (key, 'chaine', value, desc, visible, 'current' or 'allentities', deleteonunactive)
		// Example: $this->const=array(0=>array('MYMODULE_MYNEWCONST1','chaine','myvalue','This is a constant to add',1),
		//                             1=>array('MYMODULE_MYNEWCONST2','chaine','myvalue','This is another constant to add',0, 'current', 1)
		// );
		$this->const = array();

		// Array to add new pages in new tabs
		// Example: $this->tabs = array('objecttype:+tabname1:Title1:musicalv2@musicalv2:$user->rights->musicalv2->read:/musicalv2/mynewtab1.php?id=__ID__',  	// To add a new tab identified by code tabname1
        //                              'objecttype:+tabname2:Title2:musicalv2@musicalv2:$user->rights->othermodule->read:/musicalv2/mynewtab2.php?id=__ID__',  	// To add another new tab identified by code tabname2
        //                              'objecttype:-tabname:NU:conditiontoremove');                                                     						// To remove an existing tab identified by code tabname
		// where objecttype can be
		// 'categories_x'	  to add a tab in category view (replace 'x' by type of category (0=product, 1=supplier, 2=customer, 3=member)
		// 'contact'          to add a tab in contact view
		// 'contract'         to add a tab in contract view
		// 'group'            to add a tab in group view
		// 'intervention'     to add a tab in intervention view
		// 'invoice'          to add a tab in customer invoice view
		// 'invoice_supplier' to add a tab in supplier invoice view
		// 'member'           to add a tab in fundation member view
		// 'opensurveypoll'	  to add a tab in opensurvey poll view
		// 'order'            to add a tab in customer order view
		// 'order_supplier'   to add a tab in supplier order view
		// 'payment'		  to add a tab in payment view
		// 'payment_supplier' to add a tab in supplier payment view
		// 'product'          to add a tab in product view
		// 'propal'           to add a tab in propal view
		// 'project'          to add a tab in project view
		// 'stock'            to add a tab in stock view
		// 'thirdparty'       to add a tab in third party view
		// 'user'             to add a tab in user view
        $this->tabs = array();

        // Dictionaries
	    if (! isset($conf->musicalv2->enabled))
        {
        	$conf->musicalv2=new stdClass();
        	$conf->musicalv2->enabled=0;
        }

        // Dictionaries
        $this->dictionaries=array(
            'langs'=>'mylangfile@musical',
            'tabname'=>array(MAIN_DB_PREFIX."c_instrument_category"),		                                                // List of tables we want to see into dictonnary editor
            'tablib'=>array("Catégories Instruments"),						                                                        // Label of tables
            'tabsql'=>array('SELECT label, defaultPrice, rowid, active FROM '.MAIN_DB_PREFIX.'c_instrument_category'),      // Request to select fields
            'tabsqlsort'=>array("label ASC"),														                                // Sort order
            'tabfield'=>array("label,defaultPrice"),														                        // List of fields (result of select to show dictionary)
            'tabfieldvalue'=>array("label,defaultPrice"),														                    // List of fields (list of fields to edit a record)
            'tabfieldinsert'=>array("label,defaultPrice"),														                    // List of fields (list of fields for insert)
            'tabrowid'=>array('rowid'),																                                // Name of columns with primary key (try to always name it 'rowid')
            'tabcond'=>array($conf->musicalv2->enabled)											                                	// Condition to show each dictionary
        );

        // Boxes
		// Add here list of php file(s) stored in core/boxes that contains class to show a box.
        $this->boxes = array();			// List of boxes
		// Example:
		//$this->boxes=array(array(0=>array('file'=>'myboxa.php','note'=>'','enabledbydefaulton'=>'Home'),1=>array('file'=>'myboxb.php','note'=>''),2=>array('file'=>'myboxc.php','note'=>'')););

		// Permissions
		$this->rights = array();		// Permission array used by this module

		$r=0;
		// Add here list of permission defined by an id, a label, a boolean and two constant strings.
        $this->rights[$r][0] = $this->numero . $r; 	// Permission id (must not be already used)
        $this->rights[$r][1] = 'Read instrument';	    // Permission label
        $this->rights[$r][3] = 1; 					    // Permission by default for new user (0/1)
        $this->rights[$r][4] = 'level1';				// In php code, permission will be checked by test if ($user->rights->permkey->level1->level2)
        $this->rights[$r][5] = 'level2';				// In php code, permission will be checked by test if ($user->rights->permkey->level1->level2)
        $r++;
        $this->rights[$r][0] = $this->numero . $r;	// Permission id (must not be already used)
        $this->rights[$r][1] = 'read MusicalV2';	// Permission label
        $this->rights[$r][3] = 1; 					// Permission by default for new user (0/1)
        $this->rights[$r][4] = 'read';				// In php code, permission will be checked by test if ($user->rights->permkey->level1->level2)
        $this->rights[$r][5] = '';				    // In php code, permission will be checked by test if ($user->rights->permkey->level1->level2)
        $r++;
        $this->rights[$r][0] = $this->numero . $r;	// Permission id (must not be already used)
        $this->rights[$r][1] = 'write Musical'; 	// Permission label
        $this->rights[$r][3] = 1; 					// Permission by default for new user (0/1)
        $this->rights[$r][4] = 'write';				// In php code, permission will be checked by test if ($user->rights->permkey->level1->level2)
        $this->rights[$r][5] = '';				    // In php code, permission will be checked by test if ($user->rights->permkey->level1->level2)

		// Main menu entries
		$this->menu = array();			// List of menus to add
		$r=0;

		// Add here entries to declare new menus

        /* TOP MENU */
        $this->menu[$r]=array(	'fk_menu'=>'fk_mainmenu=musicalv2',		// Put 0 if this is a single top menu or keep fk_mainmenu to give an entry on left
            'type'=>'top',			                // This is a Top menu entry
            'titre'=>'MusicalV2 ',
            'mainmenu'=>'musicalv2',
            'leftmenu'=>'musicalv2_left',			// This is the name of left menu for the next entries
            'url'=>'/musicalv2/list.php',
            'langs'=>'musicalv2@musicalv2',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
            'position'=>80,
            'enabled'=>'$conf->musicalv2->enabled',	// Define condition to show or hide menu entry. Use '$conf->musicalv2->enabled' if entry must be visible if module is enabled.
            'perms'=>'1',			                // Use 'perms'=>'$user->rights->musicalv2->level1->level2' if you want your menu with a permission rules
            'target'=>'',
            'user'=>2);				                // 0=Menu for internal users, 1=external users, 2=both
        $r++;

        /* LEFT MENU */

        //Example to declare a Left Menu entry into an existing Top menu entry:
        $this->menu[$r]=array(	'fk_menu'=>'fk_mainmenu=musicalv2,fk_leftmenu=musicalv2_left',    // Use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
                                        'type'=>'left',			                // This is a Left menu entry
                                        'titre'=>'Create a Musical',
                                        'mainmenu'=>'musicalv2',
                                        'leftmenu'=>'',			// Goes into left menu previously created by the mainmenu
                                        'url'=>'/musicalv2/card.php?action=create',
                                        'langs'=>'musicalv2@musicalv2',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
                                        'position'=>100,
                                        'enabled'=>'$conf->musicalv2->enabled',  // Define condition to show or hide menu entry. Use '$conf->musicalv2->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
                                        'perms'=>'1',			                // Use 'perms'=>'$user->rights->musicalv2->level1->level2' if you want your menu with a permission rules
                                        'target'=>'',
                                        'user'=>2);
        $r++;

        //Example to declare a Left Menu entry into an existing Top menu entry:
        $this->menu[$r]=array(	'fk_menu'=>'fk_mainmenu=musicalv2,fk_leftmenu=musicalv2_left',    // Use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
                                    'type'=>'left',			                // This is a Left menu entry
                                    'titre'=>'List of Musical',
                                    'mainmenu'=>'musicalv2',
                                    'leftmenu'=>'',			// Goes into left menu previously created by the mainmenu
                                    'url'=>'/musicalv2/list.php',
                                    'langs'=>'musicalv2@musicalv2',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
                                    'position'=>101,
                                    'enabled'=>'$conf->musicalv2->enabled',  // Define condition to show or hide menu entry. Use '$conf->musicalv2->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
                                    'perms'=>'1',			                // Use 'perms'=>'$user->rights->musicalv2->level1->level2' if you want your menu with a permission rules
                                    'target'=>'',
                                    'user'=>2);				                // 0=Menu for internal users, 1=external users, 2=both
	}

	/**
	 *		Function called when module is enabled.
	 *		The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *		It also creates data directories
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
	 */
	function init($options='')
	{
		$sql = array();
		
		define('INC_FROM_DOLIBARR',true);

		require dol_buildpath('/musicalv2/script/create-maj-base.php');

		$result=$this->_load_tables('/musicalv2/sql/');

		return $this->_init($sql, $options);
	}

	/**
	 *		Function called when module is disabled.
	 *      Remove from database constants, boxes and permissions from Dolibarr database.
	 *		Data directories are not deleted
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
	 */
	function remove($options='')
	{
		$sql = array();

		return $this->_remove($sql, $options);
	}

}
