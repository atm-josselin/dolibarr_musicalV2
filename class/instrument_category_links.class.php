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
 * \file    class/instrument_category_links.class.php
 * \ingroup musicalv2
 * \brief   This file is an example hook overload class file
 *          Put some comments here
 */

/**
 * Class InsturmentCategoryLinks
 */
class InstrumentCategoryLinks extends SeedObject
{
    public $table_element = 'instrument_category_links';

    public function __construct($db)
    {
        global $conf,$langs;

        $this->db = $db;

        $this->fields=array(
            'fk_rowInstrument'=>array('type'=>'integer', 'index'=> true)
            ,'fk_rowCategory'=>array('type'=>'integer')
        );

        $this->init();
    }

    public function getProductCategory($id){
        $sql = "SELECT cat.rowid, cat.label FROM ".MAIN_DB_PREFIX.$this->table_element." lnk LEFT JOIN llx_c_instrument_category cat ON lnk.fk_rowCategory=cat.rowid WHERE lnk.fk_rowInstrument = ".$id;
        $resql=$this->db->query($sql);
        $res = array();
        if ($resql)
        {
            $num = $this->db->num_rows($resql);
            $i = 0;
            if ($num)
            {
                while ($i < $num)
                {
                    $obj = $this->db->fetch_object($resql);
                    if ($obj)
                    {
                        $res['id'] = $obj->rowid;
                        $res['label'] = $obj->label;
                    }
                    $i++;
                }
            }
        }
        return $res;
    }

    public function deleteLinks($id){


    }

    public function alreadyAsCategory($id){
        $resql=$this->db->query("SELECT * FROM ".MAIN_DB_PREFIX.$this->table_element." WHERE fk_rowInstrument=".$id);
        if ($resql)
        {
            $num = $this->db->num_rows($resql);
            if ($num == 1)
            {
                return true;
            }
        }
        return false;
    }

    public function updateCategory($objId, $catId){
        $this->db->begin();
        if ($this->alreadyAsCategory($objId)){
            $sql = "UPDATE ".MAIN_DB_PREFIX.$this->table_element." SET ";
            $sql .= "fk_rowCategory = '".$catId."'";
            $sql .= " WHERE fk_rowInstrument = '".$objId."'";
        }
        else {
            $sql = "INSERT INTO ".MAIN_DB_PREFIX.$this->table_element."(fk_rowCategory,fk_rowInstrument) VALUES ";
            $sql .= "('".$catId."','".$objId."')";
        }
        $this->db->query($sql);
        $this->db->commit();
    }
}