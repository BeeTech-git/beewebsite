<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Header_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_count($table='',$catid='') {
        $array = array('is_active' => 1, 'id' => $catid);
    	$this->db->where($array);
		$this->db->from($table);

        return $this->db->count_all_results();
    }
    
	public function getBasicInfo()
	{
		$sql = $this->db->query('SELECT * FROM basicinfo ORDER BY id ASC');
		$res = $sql->result();
		$result = array();
		foreach($res as $key)
		{
		    $info = $key->info;
    		$val = $key->val;
    		$result[$info] = $val;
		}
        return $result;
	}
    
	public function getAboutInfo($page='')
	{
    	$this->db->select('*');
		$this->db->from('page_contents');
		$this->db->where('page', $page);
		$query = $this->db->get();
        $res = $query->result();
		
		$result = array();
		foreach($res as $key)
		{
		    $info = $key->info;
    		$val = $key->val;
    		$result[$info] = $val;
		}
        return $result;
	}
    
	public function getCategories($catid='')
	{
        if($catid != '')
        {
            $this->db->select('category');
            $this->db->from('category');
            $array = array('active' => 1, 'id' => $catid);
            $this->db->where($array); 
            $query = $this->db->get();
            $res = $query->result();
		    $result = array();
    		foreach($res as $key)
    		{
        		$val = $key->category;
    		    $result['category'] = $val;
    		}
            return $result;
        } else {
            $this->db->select('*');
            $this->db->from('category');
            $this->db->where('active', 1);
            $this->db->order_by('priority','asc');
            $query = $this->db->get();
    
            return $query->result();
        }
	}

	public function mailDetails($name='',$email='',$phone='',$message='')
	{
		$data = array(
            'name'=>$name,
            'email'=>$email,
            'phone'=>$phone,
            'message'=>$message
        );
        $this->db->insert('maildetails',$data);
	}
	
    public function getFunctionn($table='',$catid='',$limit='',$start='') {

    	$this->db->select('*');
		$this->db->from($table);
        if($table=='products'){
            if($catid != '')
                $array = array('is_active' => 1, 'id' => $catid);
            else
                $array = array('is_active' => 1);
            $this->db->where($array); 
        }
		$this->db->order_by('priority','asc');
		if($limit!='')
            $this->db->limit($limit, $start);
        $query = $this->db->get();

        return $query->result();
    }

}
