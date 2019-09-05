<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: a.kader
 * Date: 04-Sep-19
 * Time: 2:18 PM
 */

class Sales_target_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllZones()
    {
        $q = $this->db->get("zones");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllCategory()
    {
        $q = $this->db->get("zones");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getZoneTarget($month, $year, $category_id, $bu)
    {
        $q = $this->db->get_where('zones_target', array('month' => $month, 'year' => $year, 'category_id' => $category_id, 'business_unit' => $bu), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getZoneByCode($id)
    {
        $q = $this->db->get_where('zones', array('code' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addZoneTarget($data)
    {
        if ($this->db->insert_batch('zones_target', $data)) {
            return true;
        }
        return false;
    }


    public function deleteZoneTarget($id)
    {
        if ($this->db->delete('zones_target', array('reference_no' => $id))) return true;
        else return FALSE;
    }



    public function getAllTargetDetails($ref)
    {
        $this->db->select('zones_target.*,users.*,categories.name as nam')
            ->join('categories', 'zones_target.category_id=categories.id', 'left')
            ->join('users', 'users.id=zones_target.created_by', 'left')->order_by('zones_target.zone_name','asc');
        $q = $this->db->get_where('zones_target', array('reference_no' => $ref));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

}