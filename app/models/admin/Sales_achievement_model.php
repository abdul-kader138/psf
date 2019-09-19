<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: a.kader
 * Date: 16-Sep-19
 * Time: 3:40 PM
 */

class Sales_achievement_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getSalesOfficerAchievement($month, $year, $category_id, $zone_id,$bu,$user_id)
    {
        $q = $this->db->get_where('sales_officer_achievement', array('month' => $month, 'year' => $year, 'category_id' => $category_id, 'business_unit' => $bu,'user_code'=>$user_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }


    public function getUserByCode($id)
    {
        $q = $this->db->get_where('users', array('username' => $id), 1);
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

    public function addSalesOfficerAchv($data)
    {
        if ($this->db->insert_batch('sales_officer_achievement', $data)) {
            return true;
        }
        return false;
    }


    public function deleteZoneAchv($id)
    {
        if ($this->db->delete('sales_officer_achievement', array('reference_no' => $id))) return true;
        else return FALSE;
    }

    public function getAllOfficersTargetDetails($ref)
    {
        $this->db->select('sales_officer_achievement.*,users.*,categories.name as nam,zones.name as zname')
            ->join('categories', 'sales_officer_achievement.category_id=categories.id', 'left')
            ->join('zones', 'sales_officer_achievement.zone_id=zones.id', 'left')
            ->join('users', 'users.username=sales_officer_achievement.user_code', 'left')->order_by('sales_officer_achievement.id','asc');
        $q = $this->db->get_where('sales_officer_achievement', array('reference_no' => $ref));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

}