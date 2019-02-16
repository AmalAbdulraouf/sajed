<meta charset="utf-8">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('language') == 'Arabic')
		{
			$this->lang->load('website', 'arabic');
			echo '<link rel="stylesheet" type="text/css" href="'.base_url().'resources/style-ar.css">';
		}
		else
		{
			$this->lang->load('website', 'english');
			echo '<link rel="stylesheet" type="text/css" href="'.base_url().'resources/style-en.css">';
		}
	}
	
	#index
	public function index()
	{
		
	}
	
	#Main Page
	
	
	public function view_order()
	{
		$just_received = $_GET['just_received'];
		$order_id = $_GET['order_id'];
		if(empty($just_received )){
			$just_received = 0;
		}
		$this->load->model('model_order');
		$order_info = $this->model_order->get_order_info($order_id);
		$order_technician = $this->model_order->get_last_order_tech($order_info['order_basic_info']->id);
		
		$this->load->model('model_users');
		$user_permissions = $this->model_users->get_user_permissions($this->session->userdata('user_name'));
		
		$data = array
		(
			'order_info' => $order_info,
			'user_permissions' => $user_permissions,
			'order_technician' => $order_technician,
			'just_received' => $just_received
		);
		
		$array = array
		(
			'name' => 'view_view_order',
			'data' => $data
		);
		$this->load->view('view_template', $array);	
	}
	
	public function add_new_order()
	{
		if($this->check_permission('Receive an order'))
		{
			
			$this->load->model('model_order');
			$this->load->model('model_users');
			$this->load->model('model_brands_and_modles');
			
			$accessories_categories = $this->model_order->get_list_of_accessories_categories();
			$brands_array = $this->model_brands_and_modles->get_list_of_brands_having_models();
			$brands[0] = lang('not_selected');
			foreach ($brands_array as $br) 
			{
				$brands[$br->id] = $br ->name;			
			}
			$models = $this->model_brands_and_modles->get_list_of_models_by_brand_id($brands[0]->id);
			$machines_types_array = $this->model_order->get_list_of_machines_types();
			$machines_types[0] = lang('not_selected');
			foreach ($machines_types_array as $machine) 
			{
				$machines_types[$machine->id] = $machine ->name;			
			}
			$technicians_array = $this->model_users->get_list_of_users_has_permissions('Perform Repair Action');
			
			$technicians[0] = lang('not_selected');
			foreach ($technicians_array as $tech) 
			{
				$technicians[$tech->id] = $tech ->user_name;			
			}
			
			$data = array
			(
				'models' => $models,
				'brands' => $brands,
				'machines_types' => $machines_types,
				'accessories_categories' => $accessories_categories,
				'technicians' => $technicians
			);
			
			$array = array
			(
				'name' => 'view_add_new_order',
				'data' => $data
			);
			
			$this->load->view('view_template', $array);
		}
		else
		{
			redirect(base_url().'index.php/main_page/restricted');
		}
	}
	
		private function check_validations2()
	{
		
		if($this->session->userdata('language') == 'Arabic'){
			$this->lang->load('website', 'arabic');
			$this->config->set_item('language', 'arabic');
		}
		else{
			$this->lang->load('website', 'english');
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('brands', 'lang:brands', 'required|callback_chk_brand');
		$this->form_validation->set_rules('machine_type', 'lang:machine_type', 'required|callback_chk_machine_type');
		
		$posted_accessories = $this->input->post('accessories');
		
		foreach($posted_accessories as $cat){
			$my_cat = 'cat_'.$cat;
			$this->form_validation->set_rules($my_cat, $my_cat, 'xss_clean');
		}
		$this->form_validation->set_rules('billNumber', 'lang:billNumber', 'numeric');
		$this->form_validation->set_rules('billDate', 'lang:billDate', '');
		$this->form_validation->set_rules('first_name', 'lang:full_name', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('last_name', 'lang:last_name', 'trim|greater_than[3]|xss_clean');
		$this->form_validation->set_rules('email', 'lang:email', 'valid_email');
		//$this->form_validation->set_rules('phone', 'lang:phone', 'trim|required|numeric|exact_length[9]');

		if($this->get_chkBox_status('external_repair'))
			$this->form_validation->set_rules('address', 'lang:address', 'xss_clean|required');
		else {
			$this->form_validation->set_rules('address', 'lang:address', 'xss_clean');
		}
		$this->form_validation->set_rules('customer_id', 'customer_id', 'xss_clean');
			
		$this->form_validation->set_rules('models', 'lang:models', 'trim|required');
		$this->form_validation->set_rules('serial_number', 'lang:serial_no', 'trim|required');
		$this->form_validation->set_rules('notes', 'lang:notes', 'xss_clean');
		$this->form_validation->set_rules('fault_description', 'lang:fault_description', 'trim|required');
		
		
		if(!$this->get_chkBox_status('under_warranty'))
			if ($this->get_chkBox_status('examine_date')){
				$this->form_validation->set_rules('expected_examine_date', 'lang:examine_date', 'trim|numeric|required');
				$this->form_validation->set_rules('examine_cost', 'lang:examining_cost', 'trim|numeric|required');
			}
			else if ($this->get_chkBox_status('delivery_date'))
			{
				$this->form_validation->set_rules('expected_delivery_date', 'lang:delivery_Date', 'trim|numeric|required');
				$this->form_validation->set_rules('cost_estimation', 'lang:cost_estimation', 'trim|numeric|required');
			} 
		else 
		{
			if ($this->get_chkBox_status('examine_date')){
				$this->form_validation->set_rules('expected_examine_date', 'lang:examine_date', 'trim|numeric|required');
				$this->form_validation->set_rules('examine_cost', 'lang:examining_cost', 'trim|numeric');
		
			}
			else {
				$this->form_validation->set_rules('expected_delivery_date', 'lang:delivery_Date', 'trim|numeric|required');
				$this->form_validation->set_rules('cost_estimation', 'lang:cost_estimation', 'trim|numeric');
			}
		}
		
		$this->form_validation->set_rules('fault_description', 'lang:fault_description', 'trim|required');
		$this->form_validation->set_rules('technician','technician','callback_chk_order_assigned_to_tech');
		
		if ($this->form_validation->run() == FALSE)
		{
			return false;
		}
		return true;
	}
	
	private function check_validations()
	{
		
		if($this->session->userdata('language') == 'Arabic'){
			$this->lang->load('website', 'arabic');
			$this->config->set_item('language', 'arabic');
		}
		else{
			$this->lang->load('website', 'english');
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('brands', 'lang:brands', 'required|callback_chk_brand');
		$this->form_validation->set_rules('machine_type', 'lang:machine_type', 'required|callback_chk_machine_type');
		$this->form_validation->set_rules('billNumber', 'lang:billNumber', 'numeric');
		$this->form_validation->set_rules('billDate', 'lang:billDate', '');
		
		$posted_accessories = $this->input->post('accessories');
		
		foreach($posted_accessories as $cat){
			$my_cat = 'cat_'.$cat;
			$this->form_validation->set_rules($my_cat, $my_cat, 'xss_clean');
		}
		
		if($this->input->post('customer_id') == ""){
			$this->form_validation->set_rules('first_name', 'lang:full_name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('last_name', 'lang:last_name', 'trim|greater_than[3]|xss_clean');
			$this->form_validation->set_rules('email', 'lang:email', 'valid_email');
			$this->form_validation->set_rules('phone', 'lang:phone', 'trim|required|numeric|exact_length[9]');
			if($this->input->post('external_repair') == '1')
				$this->form_validation->set_rules('address', 'lang:address', 'xss_clean|required');
			else 
				$this->form_validation->set_rules('address', 'lang:address', 'xss_clean');
		}
		else{
			$this->form_validation->set_rules('customer_id', 'customer_id', 'xss_clean');
		}
			
		$this->form_validation->set_rules('models', 'lang:models', 'trim|required');
		$this->form_validation->set_rules('serial_number', 'lang:serial_no', 'trim|required');
		$this->form_validation->set_rules('notes', 'lang:notes', 'xss_clean');
		$this->form_validation->set_rules('fault_description', 'lang:fault_description', 'trim|required');
		
		if(!$this->get_chkBox_status('under_warranty'))
			if ($this->get_chkBox_status('examine_date')){
				$this->form_validation->set_rules('expected_examine_date', 'lang:examine_date', 'trim|numeric|required');
				$this->form_validation->set_rules('examine_cost', 'lang:examining_cost', 'trim|numeric|required');
			}
			else if ($this->get_chkBox_status('delivery_date'))
			{
				$this->form_validation->set_rules('expected_delivery_date', 'lang:delivery_Date', 'trim|numeric|required');
				$this->form_validation->set_rules('cost_estimation', 'lang:cost_estimation', 'trim|numeric|required');
			} 
		else 
		{
			if ($this->get_chkBox_status('examine_date')){
				$this->form_validation->set_rules('expected_examine_date', 'lang:examine_date', 'trim|numeric|required');
				$this->form_validation->set_rules('examine_cost', 'lang:examining_cost', 'trim|numeric');
		
			}
			else {
				$this->form_validation->set_rules('expected_delivery_date', 'lang:delivery_Date', 'trim|numeric|required');
				$this->form_validation->set_rules('cost_estimation', 'lang:cost_estimation', 'trim|numeric');
			}
		}
		
		
		$this->form_validation->set_rules('technician','technician','callback_chk_order_assigned_to_tech');
		
		if ($this->form_validation->run() == FALSE)
		{
			return false;
		}
		return true;
	}
	
	public function save_new_order()
	{
		if($this->check_validations() == false){
			$this->load->model('model_brands_and_modles');
			$this->load->model('model_order');
			$this->load->model('model_users');
			
			$brands_array = $this->model_brands_and_modles->get_list_of_brands_having_models();
			$brands[0] = lang('not_selected');
			foreach ($brands_array as $br) 
			{
				$brands[$br->id] = $br ->name;			
			}
			$models = $this->model_brands_and_modles->get_list_of_models_by_brand_id($brands[0]->id);
			$machines_types_array = $this->model_order->get_list_of_machines_types();
			$machines_types[0] = lang('not_selected');
			foreach ($machines_types_array as $machine) 
			{
				$machines_types[$machine->id] = $machine ->name;			
			}
			$accessories_categories = $this->model_order->get_list_of_accessories_categories();
			
			$technicians_array = $this->model_users->get_list_of_users_has_permissions('Perform Repair Action');
			$technicians[0] = lang('not_selected');
			foreach ($technicians_array as $tech) 
			{
				$technicians[$tech->id] = $tech ->user_name;			
			}
			
			$data = array(
				'models' => $models,
				'brands' => $brands,
				'machines_types' => $machines_types,
				'accessories_categories' => $accessories_categories,
				'technicians' => $technicians
			);
			$array = array
			(
				'name' => 'view_add_new_order',
				'data' => $data
			);
			
			$this->load->view('view_template', $array);
			return;
		}
		if($this->check_permission('Receive an order'))
		{
			$this->load->model('model_users');		
			if($this->input->post('customer_id') == "")
			{		
				$contact_info = array
				(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'address' => $this->input->post('address')
				);
				$email = $this->input->post('email');
			}
			else 
			{
				$contact_info = array
				(
					'id' => $this->input->post('customer_id')
				);
				$data = $this->model_users->get_contact_email($contact_info['id']);
				$email = $data->email;	
			}

			$posted_accessories = $this->input->post('accessories');
			if(!empty($posted_accessories))
			{
				foreach ($this->input->post('accessories') as $accessory) 
				{
					$accessories_array['notes'] = $this->input->post('cat_'.$accessory);
					$accessories_array['category_id'] = $accessory;
					$accessories[] = $accessories_array;
				}	
			}
			else 
			{
				$accessories = 0;
			}
			
			$this->load->model('model_brands_and_modles');
			$brands_id = $this->input->post('brands');
			$model_name = $this->input->post('models');
			
			$model_id = $this->model_brands_and_modles->get_model_id_for_save_order($model_name, $brands_id);
			
			$machines = array
			(
				'machines_types_id' => $this->input->post('machine_type'),
				'models_id' => $model_id,
				'brands_id' => $brands_id,
				'serial_number' => $this->input->post('serial_number')
			);
			 
				
			$under_warranty = $this->get_chkBox_status('under_warranty');
			$billDate = null;
			$billNumber = null;
			$allow_losing_data = $this->get_chkBox_status('allow_losing_data');
			
			if($under_warranty)
			{
				if($this->input->post('billNumber') != '')
				{
					$billNumber = $this->input->post('billNumber');
				}
				
				if($this->input->post('billDate') != '')
				{
					$billDate = $this->todate($this->input->post('billDate'));
				}
						
				if ($this->get_chkBox_status('examine_date'))
				{
					$examine_date = $this->input->post('expected_examine_date');
					$delivery_date = 0;
				}
				else if ($this->get_chkBox_status('delivery_date'))
				{
					$examine_date = 0;
					$delivery_date = $this->input->post('expected_delivery_date');
				} 
				$examine_cost = 0;
				$estimated_cost = 0;
			}
			else 
			{
					if ($this->get_chkBox_status('examine_date'))
					{
						$examine_date = $this->input->post('expected_examine_date');
						$examine_cost = $this->input->post('examine_cost');
						$delivery_date = 0;
						$estimated_cost = 0;			
					}
					else if ($this->get_chkBox_status('delivery_date'))
					{
						$examine_date = 0;
						$delivery_date = $this->input->post('expected_delivery_date');
						$estimated_cost = $this->input->post('cost_estimation');
						$examine_cost = 0;
					}
				}
			
			$this->load->model('model_colors');
			$color_name = $this->input->post('colors');
			$color_id = $this->model_colors->get_color_id_for_save_order($color_name);
			$order_info = array
			(
				'under_warranty' => $under_warranty,
				'allow_losing_data' => $allow_losing_data,
				'current_status_id' => 0,
				'fault_description' => $this->input->post('fault_description'),
				'notes' => $this->input->post('notes'),
				'color_id' => $color_id,
				'examine_date' => $examine_date,
				'delivery_date' => $delivery_date,
				'examine_cost' => $examine_cost,
				'estimated_cost' => $estimated_cost,
				'billDate' => $billDate,
				'billNumber' => $billNumber
			);
			
			
			if($this->input->post('external_repair') == '1')
			{
				$order_info['external_repair'] = 1;
			}else
				$order_info['external_repair'] = 0;
			
			$user_name = $this->session->userdata('user_name');
			
			$this->load->model('model_order');
			$saved_order_id = $this->model_order->save_new_order($user_name, $order_info, $contact_info, $machines, $accessories);
			
			$technician= $this->input->post('technician');	
			$assigner_name = $this->session->userdata('user_name');
			
			$this->model_order->assign_order_to_tech($assigner_name, $saved_order_id, $technician);
			
			if($examine_date != 0)
			{
				
				$this->model_order->transfer_to_examining($assigner_name, $saved_order_id, $technician);
			}

			$moblie = $this->input->post('phone');
			$this->send_message_on_receive($saved_order_id, $moblie);
			
			if($email != '')
				$this->send_email_on_receive($saved_order_id, $email);

			redirect(base_url().'index.php/order/view_order?order_id='.$saved_order_id.'&just_received=1');
		}
		else
		{
			
			redirect(base_url().'index.php/main_page/restricted');
		}
	}
	
	
	public function assign_orders_to_technicians()
	{
		if($this->check_permission('Assign orders to technicians'))
		{
			$this->load->model('model_order');
			$orders = $this->model_order->get_list_of_non_assigned_machines();
			$this->load->model('model_users');
			$technicians_array = $this->model_users->get_list_of_users_has_permissions('Perform Repair Action');
			
			foreach ($technicians_array as $tech) 
			{
				$technicians[$tech->id] = $tech ->user_name;			
			}
			
			$data = array
			(
				'orders' => $orders,
				'technicians' => $technicians
			);
			
			$this->load->view('view_assign_orders', $data);
		}
		else
		{
			redirect(base_url().'index.php/main_page/restricted');
		}
	}
	
	public function load_search_orders()
	{
		if($this->session->userdata('is_logged_in'))
		{
				$array = array
			(
				'name' => 'view_search_orders',
				'data' =>null
			);
			$this->load->view('view_template', $array);
		}
		else
		{
			redirect(base_url().'index.php');
		}
	}
	
	public function search_orders_by_id()
	{
		if($this->session->userdata('is_logged_in'))
		{
			$order_id = $_REQUEST["order_id"];
			$this->load->model('model_order');
			$orders = $this->model_order->search_orders_by_id($order_id);
			
			$data = array
			(
				'orders' => $orders,
			);
			
			$this->load->view('view_search_orders_results', $data);
		}
		else
		{
			redirect(base_url().'index.php');
		}
	}
	
	public function search_orders_by_filters()
	{
		if($this->session->userdata('is_logged_in'))
		{
			$customer_id = $_REQUEST["customer_id"];
			$date_from = $_REQUEST["date_from"];
			$date_to = $_REQUEST["date_to"];
			$delivered_or_not = $_REQUEST["delivered_or_not"];
			
			
			$this->load->model('model_order');
			$orders = $this->model_order->search_orders_by_filters($customer_id, $date_from, $date_to, $delivered_or_not);
			
			$data = array
			(
				'orders' => $orders
			);
			$this->load->view('view_search_orders_results', $data);
		}
		else
		{
			redirect(base_url().'index.php');
		}
	}
	
	public function assign_order_to_tech()
	{
		if($this->check_permission('Assign orders to technicians'))
		{
			$technician= $_REQUEST["technician"];	
			$order_id = $_REQUEST["order_id"];
			$assigner_name = $this->session->userdata('user_name');
			$this->load->model('model_order');
			$this->model_order->assign_order_to_tech($assigner_name, $order_id, $technician);
			echo 'Succeed!';
		}
		else
		{
			redirect(base_url().'index.php/main_page/restricted');
		}
	}
	
	public function technician_tasks()
	{
		if($this->check_permission('Perform Repair Action'))
		{
			$user_name = $this->session->userdata('user_name');
			$this->load->model('model_order');
			$orders = $this->model_order->get_technician_tasks_by_name($user_name);
			
			$data = array
			(
				'orders' => $orders
			);
			
			$array = array
			(
				'name' => 'view_technician_tasks',
				'data' => $data
			);
			
			
			$this->load->view('view_template', $array);
		}
		else
		{
			redirect(base_url().'index.php/main_page/restricted');
		}
	}
	
	public function perform_repair_action()
	{
		if($this->check_permission('Perform Repair Action'))
		{
			$rep_cost= $_REQUEST["rep_cost"];
			$parts_cost= $_REQUEST["parts_cost"];	
			$description = $_REQUEST["description"];
			$categories_id = $_REQUEST["categories_id"];
			$status_id = $_REQUEST["status_id"];
			$order_id = $_REQUEST["order_id"];
			$moblie = $_REQUEST["customer_mobile"];
			$email = $_REQUEST["email"];
			$place = $_REQUEST["place"];
			$user_name = $this->session->userdata('user_name');
			$this->load->model('model_order');
			if($status_id == '5' || $status_id == '4')
			{
				$this->model_order->update_place($order_id, $place);
				$description = $place;
			}
			$date = $this->model_order->perform_repair_action($user_name, $order_id, $rep_cost, $parts_cost, $description, $status_id, $categories_id);
			if($status_id == '5')
			{
				$this->send_message_on_done($order_id, $moblie);
				if($email!= '')
					$this->send_email_on_done($order_id, $email);
			}
			else if ($status_id == '4')
			{
				$this->send_message_on_cancelled($order_id, $moblie);
				if($email!= '')
					$this->send_email_on_cancelled($order_id, $email);
			}
			echo "<td>".$date."</td><td>".$user_name."</td>";
		}
		else
		{
			redirect(base_url().'index.php/main_page/restricted');
		}
	}
	
	public function set_order_closed()
	{
		if($this->check_permission('Receive an order'))
		{
			$cost= $_REQUEST["cost"];	
			$order_id = $_REQUEST["order_id"];
			$moblie = $_REQUEST["phone"];
			$user_name = $this->session->userdata('user_name');
			$receipt = $_REQUEST["Receipt"];
			$IDnum = $_REQUEST["ID"];
			$email = $_REQUEST["email"];
			$this->load->model('model_order');
			$date = $this->model_order->set_order_closed($user_name, $order_id, $cost, $receipt, $IDnum);
			$this->send_message_on_deliver($order_id, $moblie);
			if($email != '')
				$this->send_email_on_deliver($order_id, $email);
			echo '<div class="validated"> Order is Closed </div>';
		}
		else
		{
			redirect(base_url().'index.php/main_page/restricted');
		}
	}
	
	public function search_contacts()
	{
		if($this->session->userdata('is_logged_in'))
		{
			$searchword = $_POST['searchword'];
			$this->load->model('model_order');
			$contacts = $this->model_order->search_contacts($searchword);
			
			foreach ($contacts as $row) 
			{				
				$fname=$row->first_name;
				$lname=$row->last_name;
				
				$re_fname='<b>'.$searchword.'</b>';
				$re_lname='<b>'.$searchword.'</b>';
				
				$final_fname = str_ireplace($searchword, $re_fname, $fname);
				
				$final_lname = str_ireplace($searchword, $re_lname, $lname);
				
				echo '<div class="display_box" id="display_box" align="left">';
				echo "<div id=\"name\">$final_fname&nbsp;$final_lname<br/></div>";
				echo '<span id = "phone" style="font-size:9px; color:#999999">'.$row->phone.'</span>';
				echo '<span id = "address" style="visibility:hidden; ">'.$row->address.'</span>';
				echo '<span id = "id" style="visibility:hidden; ">'.$row->id.'</span></div>';
			}
		}
		else
		{
			redirect(base_url().'index.php');
		}
	}	
	
	
	// helper functions
	
	public function chk_order_assigned_to_tech()
	{
		if ($this->input->post('technician') == 0)
		{
			$this->form_validation->set_message('chk_order_assigned_to_tech', lang('please_assign_to_tech'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function chk_brand()
	{
		if ($this->input->post('brands') == 0)
		{
			$this->form_validation->set_message('chk_brand', lang('brand required'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function chk_machine_type()
	{
		if ($this->input->post('machine_type') == 0)
		{
			$this->form_validation->set_message('chk_machine_type', lang('machine type required'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function check_permission($permission)
	{
		if($this->session->userdata('is_logged_in'))
		{
			$user_permissions_array = $this->session->userdata('user_permissions');
			foreach($user_permissions_array as $per)
			{			
				if($per->name == $permission)
					return true;
			}
			return false;
		}
	}
	
	private function get_chkBox_status($chkBox_name)
	{
		if($this->input->post($chkBox_name))
		{
			return 1;
		}
		else 
		{
			return 0;
	
		}
	}
	
	private function send_message_on_receive($order_mun, $moblie)
	{
		$this->load->model('model_options');
		$opt_val = $this->model_options->get_option_val('send_sms_on_receive');
		if($opt_val->option_value != '1'){
			return;
		}
		
		$message = $opt_val->option_text;
		
		$order = $this->model_order->get_order_for_option($order_mun, 'send_sms_on_receive');
		$order['recieve_date'] = date("Y-m-d H:i:s", time());
		$additions = $this->model_options->get_additions('send_sms_on_receive');
		
		foreach ($additions as $add) 
		{
			if($add->value == 1)
			{
				if($add->name == "examining_cost" || $add->name == "examine_date")
				{
					if($order['examining_date'] != 0)
					{
						if($add->name == "examining_cost") 
						{
							
							if($order['uner_warranty'] == 0)
								$message = $message."<br>".lang($add->name)." ".$order[$add->name];
						}
						else {
							$message = $message."<br>".lang($add->name)." ".lang('during')." ".$order[$add->name].lang('day');
						}
					}
				}
				else if($add->name == "cost_estimation" || $add->name == "delivery_date")
				{
					if($order['delivery_date'] != 0)
					{
						if($add->name == "cost_estimation") 
						{
							if($order['uner_warranty'] == 0)
								$message = $message."<br>".lang($add->name)." ".$order[$add->name];
						}
						else {
							$message = $message."<br>".lang($add->name)." ".lang('during')." ".$order[$add->name].lang('day');
						}
					}
				}
				else
					$message = $message."<br>".lang($add->name)." ".$order[$add->name];
			}
			
		}
		$this->send_sms($message, $moblie);

	}
	
	private function send_message_on_cancelled($order_mun, $moblie)
	{
		$this->load->model('model_options');
		$opt_val = $this->model_options->get_option_val('send_sms_on_cancelled');
		if($opt_val->option_value != '1'){
			return;
		}
		
		$message = $opt_val->option_text;
		
		$order = $this->model_order->get_order_for_option($order_mun, 'send_sms_on_cancelled');
		$additions = $this->model_options->get_additions('send_sms_on_cancelled');
		
		foreach ($additions as $add) 
		{
			if($add->value == 1)
			{
				if($add->name == "examining_cost")
				{
					if($order['uner_warranty'] == 0 && $order['examining_cost'] != 0)
						$message = $message."<br>".lang($add->name)." ".$order[$add->name];
					
				}
				else
					$message = $message."<br>".lang($add->name)." ".$order[$add->name];
			}
			
		}
		$this->send_sms($message, $moblie);

	}
	
	
	private function send_message_on_deliver($order_mun, $moblie)
	{
		
		$this->load->model('model_options');
		$opt_val = $this->model_options->get_option_val('send_sms_on_deliver');
		if($opt_val->option_value != '1'){
			return;
		}
		
		$message = $opt_val->option_text;
		
		$order = $this->model_order->get_order_for_option($order_mun, 'send_sms_on_deliver');
		$additions = $this->model_options->get_additions('send_sms_on_deliver');
		$order['deliver_date'] = date("Y-m-d H:i:s", time());
		foreach ($additions as $add) 
		{
			if($add->value == 1)
			{
				if($add->name == "spare_parts_cost" || $add->name == "repair_cost" || $add->name == "total_cost")
				{
					if($order['under_warranty'] == 0)
					{
						$message = $message."<br>".lang($add->name)." ".$order[$add->name];
					}
				}
				else
					$message = $message."<br>".lang($add->name)." ".$order[$add->name];
			}
			
		}
	
		$this->send_sms($message, $moblie);
	}
	
	
	private function send_message_on_done($order_mun, $moblie)
	{
		
		$this->load->model('model_options');
		$opt_val = $this->model_options->get_option_val('send_sms_on_done');
		if($opt_val->option_value != '1'){
			return;
		}
		
		$message = $opt_val->option_text;
		
		$order = $this->model_order->get_order_for_option($order_mun, 'send_sms_on_done');
		$additions = $this->model_options->get_additions('send_sms_on_done');
		foreach ($additions as $add) 
		{
			if($add->value == 1)
			{
				if($add->name == "spare_parts_cost" || $add->name == "repair_cost" || $add->name == "total_cost")
				{
					if($order['under_warranty'] == 0)
					{
						if($order[$add->name] != 0)
							$message = $message."<br>".lang($add->name)." ".$order[$add->name];
						else {
							if($add->name = 'total_cost')
								$message = $message."<br>".lang('examining_cost')." ".$order['examining_cost'];
						}
					}
				}
				else
					$message = $message."<br>".lang($add->name)." ".$order[$add->name];
			}
			
		}
		$this->send_sms($message, $moblie);
	}
	
	
	private function send_sms($message, $moblie)
	{
		//$message = iconv('UTF-8','WINDOWS-1256',$message);
	//	ECHO $message;
		$message = $this->ToUnicode($message);
		$_url  = 'http://sms.malath.net.sa/httpSmsProvider.aspx'."?username="."KHALEEJSYS"."&password="."0565610236"."&mobile=".'966'.$moblie."&sender=".'KHALEEJ SYS'."&message=".$message."&unicode=U";
		
		//echo $_url;
		//echo $message;
		$_url = preg_replace("/ /", "%20", $_url);
		$result = file_get_contents($_url);
		//echo $result;
		// $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
		// fwrite($myfile, $_url.'\r\n');
		// fwrite($myfile, $result);
		// fclose($myfile);
	}
	
	private function send_sms2($message, $moblie)
	{
		$this->load->library('malath_sms');
		
		$DTT_SMS = new Malath_SMS("KHALEEJSYS","0565610236",'UTF-8');
        //$Credits = $DTT_SMS->GetCredits();
		//$SenderName = $DTT_SMS->GetSenders();
		$SmS_Msg = $message;
		echo $message;
        $Originator = "KHALEEJ SYS";
		
        $Send = $DTT_SMS->Send_SMS($moblie,$Originator,$SmS_Msg);
        /*
         echo $DTT_SMS->StrLen($SmS_Msg);
         echo '<br />';
         echo $DTT_SMS->Count_MSG($SmS_Msg);
        */
		//$message = iconv('UTF-8','WINDOWS-1256',$message);
		//$message = $this->ToUnicode($message);
	//	$_url  = 'http://sms.malath.net.sa/httpSmsProvider.aspx'."?username="."KHALEEJSYS"."&password="."0565610236"."&mobile=".'966'.$moblie."&sender=".'KHALEEJ SYS'."&message=".$message."&unicode=U";
		
		//echo $_url;
		////$_url = preg_replace("/ /", "%20", $_url);
		//$result = file_get_contents($_url);
		//echo $result;
		// $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
		// fwrite($myfile, $_url.'\r\n');
		// fwrite($myfile, $result);
		// fclose($myfile);
	}
	
	private function ToUnicode($Text) 
	{
		$Backslash = "\ ";
		$Backslash = trim($Backslash);

		$UniCode = Array
		(
		    "�" => "060C",
		    "�" => "061B",
		    "�" => "061F",
		    "�" => "0621",
		    "�" => "0622",
		    "�" => "0623",
		    "�" => "0624",
		    "�" => "0625",
		    "�" => "0626",
		    "�" => "0627",
		    "�" => "0628",
		    "�" => "0629",
		    "�" => "062A",
		    "�" => "062B",
		    "�" => "062C",
		    "�" => "062D",
		    "�" => "062E",
		    "�" => "062F",
		    "�" => "0630",
		    "�" => "0631",
		    "�" => "0632",
		    "�" => "0633",
		    "�" => "0634",
		    "�" => "0635",
		    "�" => "0636",
		    "�" => "0637",
		    "�" => "0638",
		    "�" => "0639",
		    "�" => "063A",
		    "�" => "0641",
		    "�" => "0642",
		    "�" => "0643",
		    "�" => "0644",
		    "�" => "0645",
		    "�" => "0646",
		    "�" => "0647",
		    "�" => "0648",
		    "�" => "0649",
		    "�" => "064A",
		    "�" => "0640",
		    "�" => "064B",
		    "�" => "064C",
		    "�" => "064D",
		    "�" => "064E",
		    "�" => "064F",
		    "�" => "0650",
		    "�" => "0651",
		    "�" => "0652",
		    "!" => "0021",
		    '"' => "0022",
		    "#" => "0023",
		    "$" => "0024",
		    "%" => "0025",
		    "&" => "0026",
		    "'" => "0027",
		    "(" => "0028",
		    ")" => "0029",
		    "*" => "002A",
		    "+" => "002B",
		    "," => "002C",
		    "-" => "002D",
		    "." => "002E",
		    "/" => "002F",
		    "0" => "0030",
		    "1" => "0031",
		    "2" => "0032",
		    "3" => "0033",
		    "4" => "0034",
		    "5" => "0035",
		    "6" => "0036",
		    "7" => "0037",
		    "8" => "0038",
		    "9" => "0039",
		    ":" => "003A",
		    ";" => "003B",
		    "<" => "003C",
		    "=" => "003D",
		    ">" => "003E",
		    "?" => "003F",
		    "@" => "0040",
		    "A" => "0041",
		    "B" => "0042",
		    "C" => "0043",
		    "D" => "0044",
		    "E" => "0045",
		    "F" => "0046",
		    "G" => "0047",
		    "H" => "0048",
		    "I" => "0049",
		    "J" => "004A",
		    "K" => "004B",
		    "L" => "004C",
		    "M" => "004D",
		    "N" => "004E",
		    "O" => "004F",
		    "P" => "0050",
		    "Q" => "0051",
		    "R" => "0052",
		    "S" => "0053",
		    "T" => "0054",
		    "U" => "0055",
		    "V" => "0056",
		    "W" => "0057",
		    "X" => "0058",
		    "Y" => "0059",
		    "Z" => "005A",
		    "[" => "005B",
		    $Backslash => "005C",
		    "]" => "005D",
		    "^" => "005E",
		    "_" => "005F",
		    "`" => "0060",
		    "a" => "0061",
		    "b" => "0062",
		    "c" => "0063",
		    "d" => "0064",
		    "e" => "0065",
		    "f" => "0066",
		    "g" => "0067",
		    "h" => "0068",
		    "i" => "0069",
		    "j" => "006A",
		    "k" => "006B",
		    "l" => "006C",
		    "m" => "006D",
		    "n" => "006E",
		    "o" => "006F",
		    "p" => "0070",
		    "q" => "0071",
		    "r" => "0072",
		    "s" => "0073",
		    "t" => "0074",
		    "u" => "0075",
		    "v" => "0076",
		    "w" => "0077",
		    "x" => "0078",
		    "y" => "0079",
		    "z" => "007A",
		    "{" => "007B",
		    "|" => "007C",
		    "}" => "007D",
		    "~" => "007E",
		    "�" => "00A9",
		    "�" => "00AE",
		    "�" => "00F7",
		    "�" => "00F7",
		    "�" => "00A7",
		    " " => "0020",
		    "\n" => "000D",
			"\r" => "000A",
		    "\t" => "0009",
		    "�" => "00E9",
		    "�" => "00E7",
		    "�" => "00E0",
		    "�" => "00F9",
		    "�" => "00B5",
		    "�" => "00E8"
		);

		$Result="";
		$StrLen = strlen($Text);
		//$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
		// fwrite($myfile, $Text .' ');
		for($i=0;$i<$StrLen;$i++){

			$currect_char = mb_substr($Text,$i,1);
			
			if(array_key_exists($currect_char,$UniCode)){
				$Result .= $UniCode[$currect_char];
				
				// fwrite($myfile, $currect_char .' ');
				// fwrite($myfile, $UniCode[$currect_char].'\r\n');
				
				//print $UniCode[$currect_char].'<br>';
			}
		}
		// fclose($myfile);
		return $Result;
		
	}


	public function edit_order()
	{
		$this->session->set_userdata(array('edited' => false));
		$order_id = $this->input->post('order_id');
		if($this->check_validations2() == false)
		{
			//$response['error'] = 'Error message!';
			//$response['data'] = validation_errors() ;
			//echo validation_errors();
			//header( 'Content-Type: application/json' );
			//echo json_encode( $response );
			$this->edit_order_page($order_id);
			//return;
		}
		else {
			$this->session->set_userdata(array('edited'=> true));
			if($this->check_permission('Modify an order'))
			{
				
				$this->load->model('model_order');
				
				$contact_info = array
				(
					'id' => $this->input->post('customer_id'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'address' => $this->input->post('address'),
					'IDnum' => $this->input->post('IDnum')
				);
	
				$posted_accessories = $this->input->post('accessories');
				if(!empty($posted_accessories))
				{
					foreach ($this->input->post('accessories') as $accessory) 
					{
						$accessories_array['notes'] = $this->input->post('cat_'.$accessory);
						$accessories_array['category_id'] = $accessory;
						$accessories[] = $accessories_array;
					}	
				}
		
				
				$posted_accessories = $this->input->post('accessories1');
				if(!empty($posted_accessories))
				{
					foreach ($this->input->post('accessories1') as $accessory) 
					{
						$accessories_array['notes'] = $this->input->post('cat_'.$accessory);
						$accessories_array['category_id'] = $accessory;
						$accessories[] = $accessories_array;
					}	
				}
			
				$this->load->model('model_brands_and_modles');
				$brands_id = $this->input->post('brands');
				$model_name = $this->input->post('models');
				
				$model_id = $this->model_brands_and_modles->get_model_id_for_save_order($model_name, $brands_id);
				
				$machines = array
				(
					'id' => $this->input->post('machine_id'),
					'machines_types_id' => $this->input->post('machine_type'),
					'models_id' => $model_id,
					'brands_id' => $brands_id,
					'serial_number' => $this->input->post('serial_number')
				);
						
				$under_warranty = $this->input->post('under_warranty');
				$allow_losing_data = $this->get_chkBox_status('allow_losing_data');
				$billNumber = null;
				$billDate = null;
			
				if($under_warranty == 1)
				{
					if($this->input->post('billNumber') != '')
					{
						$billNumber = $this->input->post('billNumber');
					}
					
					if($this->input->post('billDate') != '')
					{
						$billDate = $this->todate($this->input->post('billDate'));
					}
							
					if ($this->get_chkBox_status('examine_date'))
					{
						$examine_date = $this->input->post('expected_examine_date');
						$delivery_date = 0;
					}
					else if ($this->get_chkBox_status('delivery_date'))
					{
						$examine_date = 0;
						$delivery_date = $this->input->post('expected_delivery_date');
					} 
					$examine_cost = 0;
					$estimated_cost = 0;
				}
				else 
				{
						if ($this->get_chkBox_status('examine_date'))
						{
							$examine_date = $this->input->post('expected_examine_date');
							$examine_cost = $this->input->post('examine_cost');
							$delivery_date = 0;
							$estimated_cost = 0;			
						}
						else if ($this->get_chkBox_status('delivery_date'))
						{
							$examine_date = 0;
							$delivery_date = $this->input->post('expected_delivery_date');
							$estimated_cost = $this->input->post('cost_estimation');
							$examine_cost = 0;
						}
					}
				
				$external_repair = $this->get_chkBox_status('external_repair');
	
				$this->load->model('model_colors');
				$color_name = $this->input->post('colors');
				$color_id = $this->model_colors->get_color_id_for_save_order($color_name);
				
				$order_info = array
				(
					'examine_date' => $examine_date,
					'delivery_date' => $delivery_date,
					'examine_cost' => $examine_cost,
					'estimated_cost' => $estimated_cost,
					'external_repair' => $external_repair,
					'under_warranty' => $under_warranty,
					'allow_losing_data' => $allow_losing_data,
					'fault_description' => $this->input->post('fault_description'),
					'notes' => $this->input->post('notes'),
					'color_id' => $color_id,
					'billDate' => $billDate,
					'billNumber' => $billNumber
				);
				
				$user_name = $this->session->userdata('user_name');
				
				$this->load->model('model_order');
				$saved_order_id = $this->model_order->edit_order($order_id,$user_name, $order_info, $contact_info, $machines, $accessories);
				
				$technician= $this->input->post('technician');	
				$assigner_name = $this->session->userdata('user_name');
			
				
				$current = $this->model_order-> get_current_status($order_id);
				$query = $this->model_users->get_user_data_by_user_name($user_name);
				$user_id = $query[0]->id;
				if($current->target_user != $technician && $current->target_user != NULL)
					$this->model_order->assign_order_to_tech($assigner_name, $order_id, $technician);
				
				$data = array
				(
					'orders_id' => $order_id,
					'description' =>  lang('edited'),
					'users_id' => $user_id,
					'target_user' => $technician,
					'status_id' => $current->status_id,
					'categories_id' => 8,
					'date' => date("Y-m-d H:i:s", time())
				);
				
				$this->model_order->new_action($data);
				
				
	
				redirect(base_url().'index.php/order/view_order?order_id='.$saved_order_id);
				}
			}
			
	}
	
	
	
	public function edit_order_page($order_id)
	{
		if($this->check_permission('Modify an order'))
		{
			$this->load->model('model_order');
			$this->load->model('model_users');
			$this->load->model('model_brands_and_modles');	
			$accessories_categories = $this->model_order->get_list_of_accessories_categories();
			
			$brand_machine = $this->model_order->get_machine_and_brand_name($order_id);
			$brands_array = $this->model_brands_and_modles->get_list_of_brands_having_models();
			$brand = $brand_machine['brand']['name'];
			$brands[$brand_machine['brand']['id']] = $brand;
			foreach ($brands_array as $br) 
			{
				$brands[$br->id] = $br->name;			
			}
			
			$models = $this->model_brands_and_modles->get_list_of_models_by_brand_id($brands[0]->id);
			$machines_types_array = $this->model_order->get_list_of_machines_types();
			$machine_type = $brand_machine['machine']['name'];
			$machines_types[$brand_machine['machine']['id']] = $machine_type;
			foreach ($machines_types_array as $type) 
			{
				$machines_types[$type->id] = $type->name;			
			}
			
			
			$order_technician = $this->model_order->get_last_order_tech($order_id);
			$order_info = $this->model_order->get_order_info($order_id);
			$technicians_array = $this->model_users->get_list_of_users_has_permissions('Perform Repair Action');	
	
			foreach ($technicians_array as $tech) 
			{
				if ($tech ->user_name == $order_technician)
					$technicians[$tech->id] = $tech ->user_name;			
			}
			foreach ($technicians_array as $tech) 
			{
				$technicians[$tech->id] = $tech ->user_name;			
			}
			
			$this->load->model('model_users');
			$user_permissions = $this->model_users->get_user_permissions($this->session->userdata('user_name'));
			$data = array
			(
				'order_info' => $order_info,
				'user_permissions' => $user_permissions,
				'order_technician' => $order_technician,
				'models' => $models,
				'brands' => $brands,
				'machines_types' => $machines_types,
				'accessories_categories' => $accessories_categories,
				'technicians' => $technicians
			);
			
			$array = array(
				'name' => 'view_edit_order',
				'data' => $data
			);		
			$this->load->view('view_template', $array);
		}
		else
		{
			redirect(base_url().'index.php/main_page/restricted');
		}
	}
	
	public function delete_order($order_id)
	{
		$this->load->model('model_order');
		$this->model_order->delete_order($order_id);
		
	}
	
	public function header($value='')
	{
		$this->load->view('view_main_page');	
	}
	
	
	public function order_examined($order_id, $fault, $date, $cost)
	{
		$fault = urldecode($fault);
		$this->load->model('model_order');
		$this->model_order->order_examined($order_id, $fault, $date, $cost);
	}
	
	
	public function transfer_to_another_tech($status, $tech_id)
	{
			$this->load->model('model_order');
			$this->load->model('model_users');
			$user =$this->model_users->get_user_name_by_id($tech_id);
			$orders = $this->model_order->get_technician_tasks_by_name($user);
		
			$technicians_array = $this->model_users->get_list_of_users_has_permissions('Perform Repair Action');
			
			foreach ($technicians_array as $tech) 
			{
				if($tech->id != $tech_id)
					$technicians[$tech->id] = $tech ->user_name;			
			}
			

			$data = array
			(
				'orders' => $orders,
				'technicians' => $technicians,
				'tech_id' => $tech_id,
				'status' => $status,
			);
			
			//$this->model_users->Absence($tech_id, 1);
			
			$this->load->view('view_assign_orders_from', $data);
	}
	
	
		
	public function edit_order_page2($order_id)
	{
		if($this->check_permission('Modify an order'))
		{
			$this->load->model('model_order');
			$this->load->model('model_users');
			$this->load->model('model_brands_and_modles');	
			$accessories_categories = $this->model_order->get_list_of_accessories_categories();
			
			$brand = $this->input->post('brands');
			$brands_array = $this->model_brands_and_modles->get_list_of_brands_having_models();
			$brand_name = $this->model_brands_and_modles->get_brand_name_by_id($brand);
			$brands[$brand] = $brand_name[0]['name'];
			foreach ($brands_array as $br) 
			{
				$brands[$br->id] = $br->name;			
			}
			
			$models = $this->model_brands_and_modles->get_list_of_models_by_brand_id($brands);
			$machines_types_array = $this->model_order->get_list_of_machines_types();
			$machine_type = $brand_machine['machine']['name'];
			$machines_types[$brand_machine['machine']['id']] = $machine_type;
			foreach ($machines_types_array as $type) 
			{
				$machines_types[$type->id] = $type->name;			
			}
			
			
			$order_technician = $this->input->post('technician');
			$order_info = $this->model_order->get_order_info($order_id);
			$technicians_array = $this->model_users->get_list_of_users_has_permissions('Perform Repair Action');	
	
			foreach ($technicians_array as $tech) 
			{
				if ($tech ->user_name == $order_technician)
					$technicians[$tech->id] = $tech ->user_name;			
			}
			foreach ($technicians_array as $tech) 
			{
				$technicians[$tech->id] = $tech ->user_name;			
			}
			
			$this->load->model('model_users');
			$user_permissions = $this->model_users->get_user_permissions($this->session->userdata('user_name'));
			$data = array
			(
				'order_info' => $order_info,
				'user_permissions' => $user_permissions,
				'order_technician' => $order_technician,
				'models' => $models,
				'brands' => $brands,
				'machines_types' => $machines_types,
				'accessories_categories' => $accessories_categories,
				'technicians' => $technicians
			);		
			$this->load->view('view_edit_order', $data);
		}
		else
		{
			redirect(base_url().'index.php/main_page/restricted');
		}
	}


	private function send_email_on_deliver($order_mun, $email)
	{
		
		$this->load->model('model_options');
		$opt_val = $this->model_options->get_email_option_val('send_email_on_deliver');
		if($opt_val->option_value != '1'){
			return;
		}
		
		$message = $opt_val->option_text;
		
		$order = $this->model_order->get_order_for_email_option($order_mun, 'send_email_on_deliver');
		$additions = $this->model_options->get_email_additions('send_email_on_deliver');
		$order['deliver_date'] = date("Y-m-d H:i:s", time());
		foreach ($additions as $add) 
		{
			if($add->value == 1)
			{
				if($add->name == "spare_parts_cost" || $add->name == "repair_cost" || $add->name == "total_cost")
				{
					if($order['under_warranty'] == 0)
					{
						if($order[$add->name] != 0)
							$message = $message."<br>".lang($add->name)." ".$order[$add->name];
						else 
						{
							if($add->name == 'total_cost' && $order['examining_cost'] != 0)
								$message = $message."<br>".lang('examining_cost')." ".$order['examining_cost'];
						}
					}
				}
				else
					$message = $message."<br>".lang($add->name)." ".$order[$add->name];
			}
			
		}
		$this->send_email($message, $email);
	}
	
	private function send_email_on_receive($order_mun, $email)
	{
		$this->load->model('model_options');
		$opt_val = $this->model_options->get_email_option_val('send_email_on_receive');
		if($opt_val->option_value != '1'){
			return;
		}
		
		$message = $opt_val->option_text;
		
		$order = $this->model_order->get_order_for_email_option($order_mun, 'send_email_on_receive');
		$order['recieve_date'] = date("Y-m-d H:i:s", time());
		$additions = $this->model_options->get_email_additions('send_email_on_receive');
		
		foreach ($additions as $add) 
		{
			if($add->value == 1)
			{
				if($add->name == "examining_cost" || $add->name == "examine_date")
				{
					if($order['examining_date'] != 0)
					{
						if($add->name == "examining_cost") 
						{
							if($order['uner_warranty'] == 0)
								$message = $message."<br>".lang($add->name)." ".$order[$add->name];
						}
						else 
						{
							$message = $message."<br>".lang($add->name)." ".lang('during')." ".$order[$add->name].lang('day');
						}
					}
				}
				else if($add->name == "cost_estimation" || $add->name == "delivery_date")
				{
					if($order['delivery_date'] != 0)
					{
						if($add->name == "cost_estimation") 
						{
							if($order['uner_warranty'] == 0)
								$message = $message."<br>".lang($add->name)." ".$order[$add->name];
						}
						else 
						{
							$message = $message."<br>".lang($add->name)." ".lang('during')." ".$order[$add->name]." ".lang('day');
						}
					}
				}
				else
					$message = $message."<br>".lang($add->name)." ".$order[$add->name];
			}
			
		}
		$this->send_email($message, $email);

	}
	
	private function send_email_on_done($order_mun, $email)
	{
		
		$this->load->model('model_options');
		$opt_val = $this->model_options->get_email_option_val('send_email_on_done');
		if($opt_val->option_value != '1')
		{
			return;
		}
		
		$message = $opt_val->option_text;
		
		$order = $this->model_order->get_order_for_email_option($order_mun, 'send_email_on_done');
		$additions = $this->model_options->get_email_additions('send_email_on_done');
		foreach ($additions as $add) 
		{
			if($add->value == 1)
			{
				if($add->name == "spare_parts_cost" || $add->name == "repair_cost" || $add->name == "total_cost")
				{
					if($order['under_warranty'] == 0  )
					{
						if($order[$add->name] != 0)
							$message = $message."<br>".lang($add->name)." ".$order[$add->name];
						else {
							if($add->name == 'total_cost')
								$message = $message."<br>".lang('examining_cost')." ".$order['examining_cost'];
						}
					}
				}
				else
					$message = $message."<br>".lang($add->name)." ".$order[$add->name];
			}
			
		}
		$this->send_email($message, $email);
	}
	
	
	
	private function send_email_on_cancelled($order_mun, $email)
	{
		$this->load->model('model_options');
		$opt_val = $this->model_options->get_email_option_val('send_email_on_cancelled');
		if($opt_val->option_value != '1')
		{
			return;
		}
		
		$message = $opt_val->option_text;
		
		$order = $this->model_order->get_order_for_email_option($order_mun, 'send_email_on_cancelled');
		$additions = $this->model_options->get_email_additions('send_email_on_cancelled');
		
		foreach ($additions as $add) 
		{
			if($add->value == 1)
			{
				if($add->name == "examining_cost")
				{
					if($order['uner_warranty'] == 0 && $order['examining_cost'] != 0)
						$message = $message."<br>".lang($add->name)." ".$order[$add->name];
					
				}
				else
					$message = $message."<br>".lang($add->name)." ".$order[$add->name];
			}
			
		}
		$this->send_email($message, $email);

	}
	
	public function send_email($message, $email)
	{
			$config = array(
				'protocol'=>'smtp',
				'smtp_host'=>'ssl://smtp.googlemail.com',
				'smtp_port'=>465,
				'smtp_user'=>'khalijcomputers@gmail.com',
				'smtp_pass'=>'123khalij123',
				'mailtype'=>'html',
				'charset'=>'utf-8',
				'wordwrap'=>TRUE
			);
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			$this->email->from('khalijcomputers@gmail.com', 'KhalijComputers Company');
			$this->email->to($email);
			$this->email->subject(lang('khalij'));
			$this->email->message($message);
			$this->email->send();
    
	}
	
	
	public function load_message_page($order_id, $customer_phone, $message='')
	{
		$data = array
		(
			'order_id' => $order_id, 
			'customer_phone' => $customer_phone, 
			'message' => $message
		);
		
		$array =array
		(
			'name' => 'view_message_form',
			'data' => $data
		);
		$this->load->view('view_template',$array);
	}
	
	public function send_message_to_customer($order_id, $customer_phone)
	{
		$this->load->library('form_validation');
		$this->load->model('model_order');
		$this->form_validation->set_rules('message_text', 'lang:message', 'xss_clean|trim|required');
		$message = $this->input->post('message_text');
		if($this->form_validation->run() == FALSE)
		{
			$this->load_message_page($order_id, $customer_phone, $message);
		}
		else {
			
			$this->send_sms($message, $customer_phone);
			$this->model_order->send_message_to_customer_action($order_id, $customer_phone, $message);
		}
		redirect("order/view_order?order_id=".$order_id);
		//$this->send_message_on_receive($order_id, $customer_phone);
		//$this->send_email('hi', 'amalabdulraouf@gmail.com');
	}
	
	public function myUrlEncode($string) 
	{
	    $entities = array('%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
	    $replacements = array(' ', '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
	    return str_replace($entities, $replacements, urlencode($string));
	}
	
	public function todate($date)
	{
		if($date != "")
		{
			return(date('Y-m-d', strtotime(str_replace('-', '/', $date))));
		}
		else 
		{
			return "";	
		}
	}
	
	public function search_order_barcode()
	{
		$order = $this->input->post('BarCode');
		//$order = intval(substr($order, 3, strlen($order )-6));
		//var_dump($order); die();
		redirect('order/view_order?order_id='.$order);
	}
	
	public function give_attentions()
	{
		//$this->load->model('model_user');
		$this->load->model('model_order');
		$orders = $this->model_order->get_orders_assigned_to_technician_from_more_24($this->session->userdata('user_name'));
		$orders = array('orders'=>$orders);
		$array = array
		(
			'name' => 'view_technician_attentions',
			'data' => $orders
		);
		$this->load->view('view_template', $array);
		
	}
	
	public function give_excuse($exc, $order_id)
	{
		$exc = urldecode($exc);
		$this->load->model('model_order');
		$count = $this->session->userdata('give_attention');
		$count = $count -1;
		$this->session->unset_userdata(array('give_attention'=> 0));
		$this->session->set_userdata(array('give_attention'=> $count));
		$this->model_order->give_excuse($exc, $order_id);

	}	
}