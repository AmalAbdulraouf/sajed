<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language extends CI_Controller {

	#index
	public function index()
	{
		
	}
	
	
	public function change_language()
	{		
		$this->session->set_userdata("language", $_REQUEST["language"]);
		echo $this->session->userdata('language');
	}
	
	
}