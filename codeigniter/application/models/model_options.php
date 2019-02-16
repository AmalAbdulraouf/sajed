<?php

class Model_options extends CI_Model{
	
	public function get_all_options(){
		$query = $this->db->get('options');
		return $query->result();		
	}
	
	public function get_all_additions()
	{
		$query = $this->db->get('additions');
			return $query->result();
	}
	
	public function get_option_val($option_name){
		
		$this->db->where('option_name', $option_name);
		if($this->session->userdata('language') == 'Arabic')
		{
			$this->db->where('option_lang', 'ar');
		}
		elseif($this->session->userdata('language') == 'Arabic')
		{
			$this->db->where('option_lang', 'en');
		} 
		$query = $this->db->get('options');
		$q_result = $query->result();
		$query_result = $q_result[0];
		return $query_result;		
	}
	
	public function update($options){
		$this->db->update_batch('options', $options, 'option_name');
	}
	
	public function get_additions($option)
	{
		$this->db->select('additions.name, options_additions.value');
		$this->db->from('options_additions');
		$this->db->join('additions', 'additions.id = options_additions.add_id');
		$this->db->where('options_additions.option_name', $option);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function update_option($option, $ar_opt, $en_opt, $add)
	{
		$this->db->where('option_name', $option);
		$this->db->where('option_lang', 'ar');
		$this->db->update('options', $ar_opt);
		
		$this->db->where('option_name', $option);
		$this->db->where('option_lang', 'en');
		$this->db->update('options', $en_opt);
		
		foreach ($add as $a) 
		{
			$this->db->where('add_id', $a[0]);
			$this->db->where('option_name', $option);
			$data = array
			(
				'value' => $a[1]
			);
			$this->db->update('options_additions', $data);	
		}
		
	}
	
	//////////Emails////////
	
	public function get_all_email_options(){
		$query = $this->db->get('emails_options');
		return $query->result();		
	}

	public function get_email_additions($option)
	{
		$this->db->select('additions.name, options_additions_emails.value');
		$this->db->from('options_additions_emails');
		$this->db->join('additions', 'additions.id = options_additions_emails.add_id');
		$this->db->where('options_additions_emails.option_name', $option);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function update_email_option($option, $ar_opt, $en_opt, $add)
	{
		$this->db->where('option_name', $option);
		$this->db->where('option_lang', 'ar');
		$this->db->update('emails_options', $ar_opt);
		
		$this->db->where('option_name', $option);
		$this->db->where('option_lang', 'en');
		$this->db->update('emails_options', $en_opt);
		
		foreach ($add as $a) 
		{
			$this->db->where('add_id', $a[0]);
			$this->db->where('option_name', $option);
			$data = array
			(
				'value' => $a[1]
			);
			$this->db->update('options_additions_emails', $data);	
		}
		
	}
	
	
	
	public function get_email_option_val($option_name){
		
		$this->db->where('option_name', $option_name);
		if($this->session->userdata('language') == 'Arabic')
		{
			$this->db->where('option_lang', 'ar');
		}
		else if($this->session->userdata('language') == 'Arabic')
		{
			$this->db->where('option_lang', 'en');
		} 
		$query = $this->db->get('emails_options');
		$q_result = $query->result();
		$query_result = $q_result[0];
		return $query_result;		
	}
	
	
	
}