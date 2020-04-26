<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: a.kader
 * Date: 24-Feb-20
 * Time: 10:58 AM
 */

class Competitor_analysis_model extends CI_Model
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

    public function getCompetitorData($month, $year, $category_id, $zone_id,$bu)
    {
        $q = $this->db->get_where('competitor_analysis', array('month' => $month, 'year' => $year, 'category_id' => $category_id,'zone_code'=>$zone_id, 'business_unit' => $bu), 1);
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

    public function getCompanyByName($name)
    {
        $q = $this->db->get_where('companies', array('name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }


    public function addCompetitorAnalysis($data)
    {
        if ($this->db->insert_batch('competitor_analysis', $data)) {
            return true;
        }
        return false;
    }


    public function deleteCompetitorAnalysis($id)
    {
        if ($this->db->delete('competitor_analysis', array('reference_no' => $id))) return true;
        else return FALSE;
    }


    public function competitor_details($ref)
    {
        $this->db->select('competitor_analysis.*,users.*,categories.name as nam,competitor_analysis.company as comp_name')
            ->join('categories', 'competitor_analysis.category_id=categories.id', 'left')
            ->join('users', 'users.id=competitor_analysis.created_by', 'left')->order_by('competitor_analysis.zone_name','asc')->group_by('competitor_analysis.zone_name,competitor_analysis.category_id');
        $q = $this->db->get_where('competitor_analysis', array('reference_no' => $ref));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

}