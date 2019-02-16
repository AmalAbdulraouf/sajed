<?php

class Model_Machines_Types extends CI_Model{
	
	function get_list_of_machines_types()
	{
		$this->db->select('id, name');
		$this->db->from('machines_types');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get();
		return($query->result());
	}
	
	function delete_machine_type_by_id($machine_id)
	{
		$this->db->where('id', $machine_id);
		$is_deleted = array
		(
			'is_deleted' => '1'
		);
		$this->db->update('machines_types', $is_deleted);
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function update_machine_type_name_by_id($machine_id, $machine_new_name)
	{
		$this->db->where('id', $machine_id);
		$name = array
		(
			'name' => $machine_new_name
		);
		$this->db->update('machines_types', $name);
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function update_machines_types_insert_new($machine_new_name)
	{
		$name = array
		(
			'name' => $machine_new_name
		);
		$this->db->insert('machines_types', $name);
		if($this->db->affected_rows() > 0){
			return $this->db->insert_id();
		}
		else{
			return false;
		}
	}
}