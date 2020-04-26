<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 22-Apr-20
 * Time: 9:08 PM
 */

class Farmer_analysis_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function addFarmerAnalysisInfo($data)
    {
        if ($this->db->insert('farmer_analysis', $data)) {
            $cid = $this->db->insert_id();
            return $cid;
        }
        return false;
    }


    public function getAnalysisById($id)
    {
        $q = $this->db->get_where('farmer_analysis', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getZoneById($id)
    {
        $q = $this->db->get_where('zones', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getUserById($id)
    {
        $q = $this->db->get_where('users', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }


    public function deleteAnalysis($id)
    {
        if ($this->db->delete('farmer_analysis', array('id' => $id)))  return true;
        else return FALSE;
    }

    public function getUsersByID($id)
    {
        $q = $this->db->get_where('users', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }


    public function updateStatus($id, $data,$note)
    {

        $this->db->where('id', $id);
        if ($this->db->update("farmer_analysis", array('verified_note'=>$note,'verified_status'=>$data))) {
            return true;
        } else {
            return false;
        }
    }
}