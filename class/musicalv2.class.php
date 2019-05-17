<?php

if (!class_exists('SeedObject'))
{
	/**
	 * Needed if $form->showLinkedObjectBlock() is call
	 */
	define('INC_FROM_DOLIBARR', true);
	require_once dirname(__FILE__).'/../config.php';
}


class MusicalV2 extends SeedObject
{
	public $table_element = 'musicalv2';

	public $element = 'musicalv2';

    public $isextrafieldmanaged = 1; // enable extrafields

	public function __construct($db)
	{
		global $conf,$langs;

		$this->db = $db;

        $this->fields=array(
            'ref'=>array('type'=>'string','index'=>true)
            ,'label'=>array('type'=>'string')
            ,'serial'=>array('type'=>'string')
            ,'price'=>array('type'=>'double(24,2)') // date, integer, string, float, array, text
            ,'entity'=>array('type'=>'integer','index'=>true)
            ,'fk_product'=>array('type' => 'integer')
        );

		$this->init();

		$this->entity = $conf->entity;
	}

	public function save($addprov=false)
	{
		global $user,$langs;

        if($this->ref == '')
        {
            setEventMessages($langs->trans("ErrorFieldRequired",$langs->transnoentitiesnoconv('Ref')), null, 'errors');
            header('Location: '.dol_buildpath('/musicalv2/card.php', 1).'?id='.$this->id.'&action=edit');
            exit;
        }
        else {
            $res = $this->id>0 ? $this->updateCommon($user) : parent::createCommon($user);

            if ($addprov || !empty($this->is_clone))
            {
                $wc = $this->withChild;
                $this->withChild = false;
                $res = $this->id>0 ? $this->updateCommon($user) : parent::createCommon($user);
                $this->withChild = $wc;
            }

            return $res;
        }
	}


	public function loadBy($value, $field, $annexe = false)
	{
		$res = parent::loadBy($value, $field, $annexe);

		return $res;
	}

	public function load($id, $ref, $loadChild = true)
	{
		global $db;

		$res = parent::fetchCommon($id, $ref);

		if ($loadChild) $this->fetchObjectLinked();

		return $res;
	}

	public function delete(User &$user)
	{
		$this->deleteObjectLinked();
        $this->deleteCommon($user);
	}

	public function getNumero()
	{
		if (preg_match('', $this->id) || empty($this->id))
		{
			return $this->getNextNumero();
		}

		return $this->id;
	}

	private function getNextNumero()
	{
		global $db,$conf;

		require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';

		$mask = !empty($conf->global->MYMODULE_REF_MASK) ? $conf->global->MYMODULE_REF_MASK : 'MM{yy}{mm}-{0000}';
		$numero = get_next_value($db, $mask, 'musicalv2', 'id');

		return $numero;
	}

	public function getNomUrl($withpicto=0, $get_params='')
	{
		global $langs;

        $result='';
        $label = '<u>' . $langs->trans("ShowMusicalV2") . '</u>';
        if (! empty($this->ref)) $label.= '<br><b>'.$langs->trans('Ref').':</b> '.$this->ref;

        $linkclose = '" title="'.dol_escape_htmltag($label, 1).'" class="classfortooltip">';
        $link = '<a href="'.dol_buildpath('/musicalv2/card.php', 1).'?id='.$this->id. $get_params .$linkclose;

        $linkend='</a>';

        $picto='generic';

        if ($withpicto) $result.=($link.img_object($label, $picto, 'class="classfortooltip"').$linkend);
        if ($withpicto && $withpicto != 2) $result.=' ';

        $result.=$link.$this->ref.$linkend;

        return $result;
	}

	public static function getStaticNomUrl($id, $withpicto=0)
	{
		global $db;

		$object = new MusicalV2($db);
		$object->load($id, '',false);

		return $object->getNomUrl($withpicto);
	}
}


/*
class MusicalV2Det extends TObjetStd
{
	public $table_element = 'musicalv2det';

	public $element = 'musicalv2det';

	public function __construct($db)
	{
		global $conf,$langs;

		$this->db = $db;

		$this->init();

		$this->user = null;
	}


}
*/
