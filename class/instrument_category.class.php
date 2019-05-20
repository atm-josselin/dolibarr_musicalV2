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
 * \file    class/actions_musicalv2.class.php
 * \ingroup musicalv2
 * \brief   This file is an example hook overload class file
 *          Put some comments here
 */

/**
 * Class ActionsMusicalV2
 */
class InstrumentCategory extends SeedObject
{
    public $table_element = 'c_instrument_category';


    public function __construct($db)
    {
        global $conf,$langs;

        $this->db = $db;

        $this->fields=array(
            'label'=>array('type'=>'string')
            ,'defaultPrice'=>array('type'=>'double(24,2)')
            ,'active'=>array('type'=>'integer','index'=>true)
        );

        $this->init();
    }

    public function getOne($id){
        $sql = "SELECT rowid,label,defaultPrice FROM ".MAIN_DB_PREFIX.$this->table_element." WHERE rowid=".$id;
        $resql=$this->db->query($sql);
        $res = array();
        if ($resql)
        {
            $num = $this->db->num_rows($resql);
            $i = 0;
            if ($num)
            {
                $obj = $this->db->fetch_object($resql);
                if ($obj)
                {
                    $res['rowid'] = $obj->rowid;
                    $res['label'] = $obj->label;
                    $res['defaultPrice'] = $obj->defaultPrice;
                }
                $i++;
            }
        }
        return $res;
    }

    public function getArray(){
        $sql = "SELECT * FROM ".MAIN_DB_PREFIX.$this->table_element." WHERE active='1'";
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
                        $res[$obj->rowid] = $obj->label;
                    }
                    $i++;
                }
            }
        }
        return $res;
    }

    public function addData($array)
    {
        $this->db->begin();
        $sql = "INSERT INTO ".MAIN_DB_PREFIX.$this->table_element."(rowid,label,defaultPrice,active) VALUES";
        $i = 1;
        $max = count($array);
        foreach ($array as $values){
            $sql .= "(".$i.",'".$values['label']."','".$values['defaultPrice']."','1')";
            if ($i<$max)$sql.=",";
            $i++;
        }
        $this->db->query($this->db->escape($sql));
        return $this->db->commit();
    }
}
