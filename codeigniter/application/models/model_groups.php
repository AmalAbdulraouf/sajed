<?php

class Model_Groups extends CI_Model{
	
	public function get_list_of_defined_groups()
	{
		$this->db->select('*');
		$query = $this->db->get('groups');
		return($query->result());
	}
	
	public function get_user_groups_by_id($user_id)
	{
		$this->db->select('*');
		$this->db->from('groups');
		$this->db->join('users_has_groups', 'groups.id = users_has_groups.groups_id');
		$this->db->where('users_has_groups.users_id', $user_id);
		$query = $this->db->get();
		
		// $query = $this->db->get('groups'); 		
		// $query_string = "CALL get_user_groups_by_id($user_id)";
		// $query = $this->db->query($query_string);
		// mysqli_next_result($this->db->conn_id); 
		return($query->result());
	}	
}