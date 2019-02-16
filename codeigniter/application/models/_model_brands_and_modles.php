<?php

class Model_Brands_And_Modles extends CI_Model{
	
	function get_list_of_brands()
	{
		$this->db->select('id, name');
		$this->db->from('brands');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get();
		return($query->result());
	}
	
	function get_list_of_brands_having_models()
	{
		$this->db->select('id, name');
		$this->db->from('brands');
		$this->db->where('id in (select brands_id from models where is_deleted = 0)');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get();
		return($query->result());		
	}
	
	function delete_brand_by_id($brand_id)
	{
		$this->db->where('id', $brand_id);
		$is_deleted = array
		(
			'is_deleted' => '1'
		);
		$this->db->update('brands', $is_deleted);
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function update_brand_name_by_id($brand_id, $brand_new_name)
	{
		$this->db->where('id', $brand_id);
		$name = array
		(
			'name' => $brand_new_name
		);
		$this->db->update('brands', $name);
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function update_brand_insert_new($brand_new_name)
	{
		$name = array
		(
			'name' => $brand_new_name
		);
		$this->db->insert('brands', $name);
		if($this->db->affected_rows() > 0){
			return $this->db->insert_id();
		}
		else{
			return false;
		}
	}
	
	//////////////////////////////////////// Models ////////////////////////////////////////
	
	
	function get_list_of_models_by_brand_id($brand_id)
	{
		$this->db->select('*');
		$this->db->where('brands_id', $brand_id);
		$this->db->from('models');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get();
		return($query->result());
	}
	
	function delete_model_by_id($model_id)
	{
		$this->db->where('id', $model_id);
		$is_deleted = array
		(
			'is_deleted' => '1'
		);
		$this->db->update('models', $is_deleted);
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function update_model_name_by_id($model_id, $model_new_name)
	{
		$this->db->where('id', $model_id);
		$name = array
		(
			'model' => $model_new_name
		);
		$this->db->update('models', $name);
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function update_models_insert_new($model_new_name, $brand_id)
	{
		$name = array
		(
			'model' => $model_new_name,
			'brands_id' => $brand_id
		);
		$this->db->insert('models', $name);
		if($this->db->affected_rows() > 0){
			return $this->db->insert_id();
		}
		else{
			return false;
		}
	}
	
}