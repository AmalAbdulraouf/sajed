<?php

class Model_Order extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('model_companies');
        date_default_timezone_set('Asia/Riyadh');
    }

    public function get_list_of_accessories_categories() {
        $this->db->select('*');
        $query = $this->db->get('accessories_categories');
        return($query->result());
    }

    public function get_list_of_brands() {
        $this->db->select('*');
        $query = $this->db->get('brands');
        return($query->result());
    }

    public function get_list_of_models() {
        $this->db->select('*');
        $query = $this->db->get('models');
        return($query->result());
    }

    public function get_list_of_machines_types() {
        $this->db->select('*');
        $query = $this->db->get('machines_types');
        return($query->result());
    }

    public function get_faults_list() {
        $this->db->select('*');
        $query = $this->db->get('faults');
        return($query->result());
    }

    public function save_new_order($user_name, $order_info, $contact_info, $company, $machine, $machines, $accessories_array) {
        $this->load->model('model_users');
        $query = $this->model_users->get_user_data_by_user_name($user_name);
        $user_id = $query[0]->id;

        if (!empty($contact_info['id'])) {
            $customer_id = $contact_info['id'];
            $this->db->where('id', $customer_id);
            $this->db->update('contacts', $contact_info);
        } else {
            $customer_id = $this->model_users->add_new_contact($contact_info);

            if ($company != null) {
                if (!empty($company['id'])) {
                    $company_id = $company['id'];
                } else {
                    $company_id = $this->model_companies->add_new_company($company);
                }
                $this->model_companies->add_company_delegate(array(
                    'company_id' => $company_id,
                    'contact_id' => $customer_id
                        )
                );
            }
        }

        if ($machine != null) {
            $this->db->update('machines', $machines, array('id' => $machine));
            $machines_id = $machine;
        } else {
            $this->db->insert('machines', $machines);
            $machines_id = $this->db->insert_id();
        }
        $order_info['customer_id'] = $customer_id;
        $order_info['machines_id'] = $machines_id;
        $order_info['visite_date'] = $this->prepareDate($order_info['visite_date']);
        $order_info['company'] = ($company != null);
        $this->db->insert('orders', $order_info);
        $order_id = $this->db->insert_id();

        if ($accessories_array['notes'] != "") {

            $accessories_array['orders_id'] = $order_id;
            $this->db->insert('accessories', $accessories_array);
        }
        date_default_timezone_set('Asia/Riyadh');
        $actions = array
            (
            'description' => 'Recieved',
            'date' => date("Y-m-d H:i:s", time()),
            'orders_id' => $order_id,
            'categories_id' => 1,
            'status_id' => 1,
            'users_id' => $user_id
        );

        $this->db->insert('actions', $actions);


        return $order_id;
    }

    public function get_list_of_non_assigned_machines() {
        $this->db->select('orders.id, brands.name, models.model, contacts.first_name, contacts.last_name, orders.fault_description');
        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id');
        $this->db->join('models', 'models.id = machines.models_id');
        $this->db->join('brands', 'brands.id = models.brands_id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->where('orders.current_status_id', '0');
        $query = $this->db->get();
        return($query->result());
    }

    public function assign_order_to_tech($assigner_name, $order_id, $technician) {
        $this->load->model('model_users');
        $assigner = $this->model_users->get_user_data_by_user_name($assigner_name);
        $assigner_id = $assigner[0]->id;

        $this->db->select('current_status_id');
        $this->db->where('id', $order_id);
        $current_status = $this->db->get('orders');
        $current_status = $current_status->result();
        $current_status = $current_status[0]->current_status_id;

        if ($current_status < 2) {
            $current_status = 2;
            $data = array
                (
                'current_status_id' => $current_status
            );
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data);
        }

        $description = $this->model_users->get_user_name_by_id($technician);
        $current = $this->get_current_status($order_id);
        if ($current_status == 2 && $current->description == $description) {
            return;
        }
        date_default_timezone_set('Asia/Riyadh');
        $data = array
            (
            'orders_id' => $order_id,
            'description' => $description,
            'users_id' => $assigner_id,
            'target_user' => $technician,
            'status_id' => 2,
            'categories_id' => 2,
            'date' => date("Y-m-d H:i:s", time())
        );

        $this->db->insert('actions', $data);
    }

    public function get_technician_tasks_by_name($user_name) {
        $this->load->model('model_users');
        $user = $this->model_users->get_user_data_by_user_name($user_name);
        $user_id = $user[0]->id;

        $order_assignment = "(SELECT ac1.* 
			FROM `actions` as ac1 
			INNER JOIN 
				( 
					SELECT `orders_id`, MAX(`date`) as max_date 
					FROM `actions` 
						 
						WHERE categories_id = 2 GROUP BY `orders_id` 
				) ac2 
				ON ac1.`orders_id` = ac2.`orders_id` 
				AND ac1.`date` = ac2.max_date 
				and target_user =" . $user_id . "
		
				) assignment_actions";

        $this->db->select('orders.id, brands.name, models.model, contacts.first_name, contacts.last_name, orders.fault_description,new_software,software,electronic,external_repair');
        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id');
        $this->db->join('models', 'models.id = machines.models_id');
        $this->db->join('brands', 'brands.id = models.brands_id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join("$order_assignment", 'assignment_actions.orders_id = orders.id');
        $this->db->where('orders.current_status_id', '2');
        $this->db->where('actions.categories_id', '2');
        // $this->db->where('actions.target_use', $user_id);
        $query = $this->db->get();
        return($query->result());
    }

    public function get_technician_tasks_by_name2($user_name) {
        $this->load->model('model_users');
        $user = $this->model_users->get_user_data_by_user_name($user_name);
        $user_id = $user[0]->id;

        $order_assignment = "(SELECT ac1.* 
			FROM `actions` as ac1 
			INNER JOIN 
				( 
					SELECT `orders_id`, MAX(`date`) as max_date 
					FROM `actions` 
						 
						WHERE categories_id = 2 GROUP BY `orders_id` 
				) ac2 
				ON ac1.`orders_id` = ac2.`orders_id` 
				AND ac1.`date` = ac2.max_date 
				and target_user =" . $user_id . "
		
				) assignment_actions";

        $this->db->select('orders.id, orders.fault_description, orders.last_excuse_id');
        $this->db->from('orders');
        $this->db->join("$order_assignment", 'assignment_actions.orders_id = orders.id');
        $this->db->where('orders.current_status_id', '2');
        // $this->db->where('actions.target_use', $user_id);
        $query = $this->db->get();
        return($query->result());
    }

    public function search_orders_by_id($order_id) {
        $this->db->select('orders.id, brands.name, models.model, contacts.first_name, contacts.last_name, orders.fault_description');
        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id');
        $this->db->join('models', 'models.id = machines.models_id');
        $this->db->join('brands', 'brands.id = models.brands_id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->where("orders.id = '$order_id' or machines.serial_number = '$order_id'");
        $query = $this->db->get();
        return($query->result());
    }

    public function search_orders_by_filters($customer_id, $date_from, $date_to, $delivered_or_not) {
        $this->db->query('set sql_mode="";');
        $date_from = $this->prepareDateFrom($date_from);
        $date_to = $this->prepareDateTo($date_to);
        $this->db->select('orders.id, brands.name, models.model, contacts.first_name, contacts.last_name, orders.fault_description');
        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id');
        $this->db->join('models', 'models.id = machines.models_id');
        $this->db->join('brands', 'brands.id = models.brands_id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        if ($customer_id != "") {
            $this->db->where('orders.customer_id', $customer_id);
        }
        if ($date_from != "") {
            $this->db->where("actions.date >=  \"$date_from\"");
        }
        if ($date_to != "") {
            $this->db->where("actions.date <=  \"$date_to\"");
        }
        if ($delivered_or_not == 'search_delivered') {
            $this->db->where("current_status_id", 6);
        } else if ($delivered_or_not == 'search_undelivered') {
            $this->db->where("current_status_id !=", 6);
        }

        $this->db->group_by("orders.id");
        $query = $this->db->get();
        return($query->result());
    }

    public function get_order_info($order_id) {
        $this->db->select('orders.canceled,orders.state_after_repairing,orders.new_machine_serial_number,orders.out_of_warranty_reason,orders.back_date,orders.distructed,contacts.points as customer_points, orders.sent,warranty_sent.*,orders.warranty_period,orders.company,orders.visite_date, orders.visite_cost,
            orders.color_id,orders.software,orders.electronic,machines.image, machines.faults, 
            contacts.rate as contact_rate,orders.company,company.company_id, company.name as company_name,orders.id, brands.name as brand_name, models.model as model_name, 
		contacts.first_name as contact_fname, contacts.last_name as contact_lname, orders.discount,
		contacts.phone as contact_phone, contacts.email as contact_email, contacts.address as contact_address,
		orders.fault_description, orders.under_warranty, orders.estimated_cost, orders.examine_cost, orders.examine_date, orders.delivery_date, orders.allow_losing_data,
		machines.serial_number, orders.machines_id, actions.status_id, colors.color_name, machines_types.name as machine_type, orders.customer_id, orders.notes,
		orders.external_repair, orders.Receipt, orders.receipt_name, orders.IDnum, orders.repair_cost, orders.spare_parts_cost,
	    orders.customer_id, orders.machines_id, orders.billDate, orders.billNumber,
            company.discount as company_discount, contacts.discount as contact_discount,receipt_employee.name as receipt_employee_name,new_software');

        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id', 'left');
        $this->db->join('machines_types', 'machines_types.id = machines.machines_types_id', 'left');
        $this->db->join('models', 'models.id = machines.models_id', 'left');
        $this->db->join('brands', 'brands.id = models.brands_id', 'left');
        $this->db->join('contacts', 'contacts.id = orders.customer_id', 'left');
        $this->db->join('actions', 'actions.orders_id = orders.id', 'left');
        $this->db->join('warranty_sent', 'warranty_sent.warranty_sent_id = orders.sent', 'left');
        $this->db->join('receipt_employee', 'receipt_employee.receipt_employee_id = warranty_sent.receipt_employee_id', 'left');
        $this->db->join('colors', 'colors.id = orders.color_id', 'left');
        $this->db->join('company_delegate', 'company_delegate.contact_id = orders.customer_id', 'left');
        $this->db->join('company', 'company.company_id = company_delegate.company_id', 'left');
        $this->db->where("orders.id = '$order_id'");
        $this->db->order_by("(orders.id = '$order_id') desc, " . 'actions.date desc, actions.status_id desc');

        $query = $this->db->get();
        $order_basic_info = $query->result();
        $order_basic_info[0]->warranty_times = $this->db->select("count(orders.id) as times")
                        ->from('orders')
                        ->where('orders.machines_id', $order_basic_info[0]->machines_id)
//                        ->where('orders.id !=', $order_basic_info[0]->id)
                        ->where('orders.under_warranty', 1)
                        ->get()->row()->times;
        $order_basic_info[0]->temporary_device = $this->db->select(
                                "machines.*, machines_types.name as machine_type,"
                                . "brands.name as brand, models.model as model,"
                                . "colors.color_name as color")
                        ->from('order_temporary_device')
                        ->join('machines', 'machines.id = order_temporary_device.machine_id')
                        ->join('models', 'models.id = machines.models_id', 'left')
                        ->join('brands', 'brands.id = models.brands_id', 'left')
                        ->join('colors', 'colors.id = machines.color_id', 'left')
                        ->join('machines_types', 'machines_types.id = machines.machines_types_id', 'left')
                        ->where('order_temporary_device.order_id', $order_basic_info[0]->id)
                        ->get()->row();
        $this->db->select('accessories.notes');
        $this->db->from('orders');
        $this->db->join('accessories', 'accessories.orders_id = orders.id');
        $this->db->where('orders.id', $order_id);
        $query = $this->db->get();
        $accessories = $query->result();
        $accessories = $accessories[0];

        $this->db->select('actions.description, actions.repair_cost, actions.spare_parts_cost, actions.target_user, actions.date, actions_categories.name, actions.categories_id, users.user_name');
        $this->db->from('orders');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join('actions_categories', 'actions_categories.id = actions.categories_id', 'left');
        $this->db->join('users', 'users.id = actions.users_id', 'left');
        $this->db->where('orders.id', $order_id);
        $query = $this->db->get();
        $actions = $query->result();

        $current_status = $this->get_current_status($order_id);

        $order_info = array
            (
            'order_basic_info' => $order_basic_info,
            'accessories' => $accessories,
            'actions' => $actions,
            'current_status' => $current_status
        );

        return $order_info;
    }

    public function set_to_ready_under_warranty($order_id, $state, $reason, $serial_number, $place, $date) {
        $this->load->model('model_users');
        $user = $this->model_users->get_user_data_by_user_name($this->session->userdata('user_name'));
        $user_id = $user[0]->id;
        date_default_timezone_set('Asia/Riyadh');
        $my_date = date("Y-m-d H:i:s", time());
        $desc = "";
        if ($state == 1)
            $desc = "repaired " . $date;
        else if ($state == 2)
            $desc = "out_of_warranty " . $date;
        else if ($state == 3)
            $desc = "replaced " . $date;
        $data = array
            (
            'orders_id' => $order_id,
            'users_id' => $user_id,
            'description' => $date,
            'repair_cost' => 0,
            'spare_parts_cost' => 0,
            'date' => $my_date,
            'categories_id' => 13,
            'status_id' => 5,
        );
        $this->db->insert('actions', $data);
        $data = array
            (
            'orders_id' => $order_id,
            'users_id' => $user_id,
            'description' => $place,
            'repair_cost' => 0,
            'spare_parts_cost' => 0,
            'date' => $my_date,
            'categories_id' => 7,
            'status_id' => 5,
        );
        $this->db->insert('actions', $data);
        $order_array = array
            (
            'current_status_id' => 5,
            'state_after_repairing' => $state,
            'out_of_warranty_reason' => $reason,
            'new_machine_serial_number' => $serial_number,
            'back_date' => $date == "" ? null : $date
        );
        $this->db->where('id', $order_id);
        $this->db->update('orders', $order_array);
    }

    public function perform_repair_action($user_name, $order_id, $rep_cost, $parts_cost, $description, $status_id, $categories_id) {
        $this->load->model('model_users');
        $user = $this->model_users->get_user_data_by_user_name($user_name);
        $user_id = $user[0]->id;
        date_default_timezone_set('Asia/Riyadh');
        $my_date = date("Y-m-d H:i:s", time());
        $data = array
            (
            'orders_id' => $order_id,
            'users_id' => $user_id,
            'description' => $description,
            'repair_cost' => $rep_cost,
            'spare_parts_cost' => $parts_cost,
            'date' => $my_date,
            'categories_id' => $categories_id,
            'status_id' => $status_id,
        );
        //echo "amal";
        $this->db->insert('actions', $data);

        $order_array = array
            (
            'current_status_id' => $status_id
        );

        if ($status_id == 2) {
            $this->db->where('id', $order_id);
            $order = $this->db->get('orders');
            $order = $order->result_array();

            $order_array ['repair_cost'] = $order[0]['repair_cost'] + $rep_cost;
            $order_array ['spare_parts_cost'] = $order[0]['spare_parts_cost'] + $parts_cost;
            $order_array ['examine_cost'] = 0;
        }

        $this->db->where('id', $order_id);
        $this->db->update('orders', $order_array);

        return $my_date;
    }

    public function set_order_closed($user_name, $order_id, $cost, $receipt, $IDnum, $receipt_name, $discount, $points) {
        $this->load->model('model_users');
        $user = $this->model_users->get_user_data_by_user_name($user_name);
        $user_id = $user[0]->id;

        $this->db->where('id', $order_id);
        $costs = $this->db->get('orders');
        $costs = $costs->result();
        date_default_timezone_set('Asia/Riyadh');
        $my_date = date("Y-m-d H:i:s", time());
        $action_data = array
            (
            'orders_id' => $order_id,
            'users_id' => $user_id,
            'description' => "",
            'date' => $my_date,
            'categories_id' => '5',
            'repair_cost' => $costs[0]->repair_cost,
            'spare_parts_cost' => $costs[0]->spare_parts_cost,
            'status_id' => '6'
        );

        $data = array
            (
            'current_status_id' => 6,
            'Receipt' => $receipt,
            'receipt_name' => $receipt_name,
            'IDnum' => $IDnum,
            'discount' => $discount,
            'points' => $points
        );

        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);

        if ($receipt == 0) {
            $this->db->where('id', $costs[0]->customer_id);
            $up = array('IDnum' => $IDnum);
            $this->db->update('contacts', $up);
            $action_data['description'] = lang('No Receipt') . lang('ID') . $IDnum;
        }
        $this->db->insert('actions', $action_data);
        return $my_date;
    }

    public function search_contacts($searchword) {
        $searchword_nosapaces = $string = preg_replace('/\s+/', '', $searchword);

        $this->db->select('*');
        $this->db->from('contacts');

        $this->db->where('id', $searchword);
        $this->db->or_where('concat(first_name,last_name) LIKE', '%' . $searchword_nosapaces . '%');
        $this->db->or_where('phone LIKE', '%' . $searchword_nosapaces . '%');
        //$this->db->or_like("concat(first_name,last_name)", $searchword_nosapaces);
        //$this->db->or_like('first_name', $searchword);
        //$this->db->or_like('last_name', $searchword);
        //$this->db->or_like('phone', $searchword);

        $this->db->order_by("(id = '$searchword') desc");

        $query = $this->db->get();
        $contacts = $query->result();
        return $contacts;
    }

    public function save_temporary_device($order_id, $machines) {
        $this->db->insert('machines', $machines);
        $machine_id = $this->db->insert_id();
        $this->db->insert('order_temporary_device', array('machine_id' => $machine_id, 'order_id' => $order_id));
    }

    public function get_last_order_tech($order_id) {
        $this->db->select('target_user');
        $this->db->from('actions');
        $this->db->where('orders_id', $order_id);
        $this->db->where('categories_id', 2);
        $this->db->order_by('date', "desc");
        $this->db->limit(1);
        $query = $this->db->get();
        $query_result = $query->result();
        if (count($query_result) > 0) {
            $this->db->select('user_name');
            $this->db->from('users');
            $this->db->where('id', $query_result[0]->target_user);
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result[0]->user_name;
        } else {
            return false;
        }
    }

    public function get_current_status($order_id) {
        $this->db->select('actions.status_id, status.name, actions.categories_id, actions.target_user');
        $this->db->from('actions');
        $this->db->join('status', 'status.id = actions.status_id');
        $this->db->where('orders_id', $order_id);
        $this->db->order_by('actions.date desc, actions.status_id desc, actions.id desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result[0];
    }

    public function get_current_status_examining($order_id) {
        $this->db->select('actions.status_id, status.name');
        $this->db->from('actions');
        $this->db->join('status', 'status.id = actions.status_id');
        $this->db->where('orders_id', $order_id);
        $this->db->order_by('actions.date desc, actions.status_id desc');
        $this->db->limit(2);
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result[0];
    }

    // Helper Functions

    public function prepareDateFrom($date_from) {
        if ($date_from != "") {
            return(date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date_from))));
        } else {
            return "";
        }
    }

    public function prepareDateTo($date_to) {
        if ($date_to != "") {
            return(date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date_to . ' 23:59:59'))));
        } else {
            return "";
        }
    }

    public function prepareDate($date_to) {
        if ($date_to == null)
            return null;
        if ($date_to != "" || $date_to != "0" || $date != null) {
            return(date('Y-m-d', strtotime(str_replace('-', '/', $date_to))));
        } else {
            return $date_to;
        }
    }

    public function edit_order($order_id, $user_name, $order_info, $contact_info, $machines, $accessories) {

        $this->load->model('model_users');
        $query = $this->model_users->get_user_data_by_user_name($user_name);
        $user_id = $query[0]->id;
        $this->db->where('orders_id', $order_id);
        $this->db->delete('accessories');
        if ($accessories['notes'] != "") {

            $accessories_array['orders_id'] = $order_id;
            $accessories_array['notes'] = $accessories['notes'];
            $accessories_array['category_id'] = $accessories['category_id'];
            $this->db->insert('accessories', $accessories_array);
        }

        $this->db->where('id', $machines['id']);
        $this->db->update('machines', $machines);
        $machines_id = $machines['id'];

        $this->db->where('id', $contact_info['id']);
        $this->db->update('contacts', $contact_info);

        $order_info['machines_id'] = $machines_id;

        $this->db->where('id', $order_id);
        $this->db->update('orders', $order_info);



        return $order_id;
    }

    public function delete_order($order_id) {
        $this->db->where('orders_id', $order_id);
        $this->db->delete('accessories');
        $this->db->where('orders_id', $order_id);
        $this->db->delete('actions');
        $this->db->where('id', $order_id);
        $q = $this->db->get('orders');
        $q = $q->row();
        $this->db->where('id', $q->machines_id);
        $this->db->delete('machines');
        $this->db->where('id', $order_id);
        $this->db->delete('orders');
    }

    public function get_machine_and_brand_name($order_id) {

        $this->db->where('id', $order_id);
        $this->db->select('machines_id');
        $machine_id = $this->db->get('orders');
        $machine_id = $machine_id->result_array();

        $this->db->where('id', $machine_id[0]['machines_id']);
        $machine_info = $this->db->get('machines');
        $machine_info = $machine_info->result_array();

        $this->db->where('id', $machine_info[0]['machines_types_id']);
        $this->db->select('name');
        $machine_name = $this->db->get('machines_types');
        $machine_name = $machine_name->result_array();


        $this->db->where('id', $machine_info[0]['brands_id']);
        $this->db->select('name');
        $brand_name = $this->db->get('brands');
        $brand_name = $brand_name->result_array();

        $result['machine']['name'] = $machine_name[0]['name'];
        $result['machine']['id'] = $machine_info[0]['machines_types_id'];
        $result['brand']['name'] = $brand_name[0]['name'];
        $result['brand']['id'] = $machine_info[0]['brands_id'];

        return $result;
    }

    public function new_action($data) {
        $this->db->insert('actions', $data);
    }

    public function get_orders_assigned_to_technician($tech_id) {
        $this->db->where('target_user', $tech_id);
        $this->db->where('categories_id', 2);
        $orders = $this->db->get('actions');
        $orders = $orders->result();

        $counter = 0;
        foreach ($orders as $order) {
            $current = $this->get_current_status($order->orders_id);
            if ($current->status_id == 2 && $current->target_user == $tech_id) {
                $this->db->select('orders.id, brands.name, models.model, contacts.first_name, contacts.last_name, orders.fault_description');
                $this->db->from('orders');
                $this->db->join('machines', 'orders.machines_id = machines.id');
                $this->db->join('models', 'models.id = machines.models_id');
                $this->db->join('brands', 'brands.id = models.brands_id');
                $this->db->join('contacts', 'contacts.id = orders.customer_id');
                $this->db->where('orders.id', $order->orders_id);
                $query = $this->db->get();
                $qury = $query->row();
                $orders[$counter] = $query;
            } else {
                $orders[$counter] = NULL;
            }
            $counter++;
        }

        return $orders;
    }

    public function transfer_to_examining($assigner_name, $saved_order_id, $technician) {
        $this->load->model('model_users');
        $assigner = $this->model_users->get_user_data_by_user_name($assigner_name);
        $assigner_id = $assigner[0]->id;
        date_default_timezone_set('Asia/Riyadh');
        $data = array
            (
            'orders_id' => $saved_order_id,
            'description' => 'Examining',
            'users_id' => $assigner_id,
            'target_user' => $technician,
            'status_id' => 2,
            'categories_id' => 9,
            'date' => date("Y-m-d H:i:s", time())
        );

        $this->db->insert('actions', $data);
    }

    public function order_examined($order_id, $fault, $date, $cost) {
        $this->load->model('model_users');
        $assigner = $this->model_users->get_user_data_by_user_name($this->session->userdata('user_name'));
        $assigner_id = $assigner[0]->id;
        date_default_timezone_set('Asia/Riyadh');
        $data = array
            (
            'orders_id' => $order_id,
            'description' => 'Examined',
            'users_id' => $assigner_id,
            'target_user' => $assigner_id,
            'status_id' => 2,
            'categories_id' => 2,
            'date' => date("Y-m-d H:i:s", time())
        );

        $this->db->insert('actions', $data);

        $data2 = array
            (
            'fault_description' => $fault,
            'delivery_date' => $date,
            'examine_date' => 0,
            'estimated_cost' => $cost
        );

        $this->db->where('id', $order_id);
        $this->db->update('orders', $data2);
    }

    public function get_list_of_assigned_machines() {
        $this->db->select('orders.id, brands.name, models.model, contacts.first_name, contacts.last_name, orders.fault_description');
        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id');
        $this->db->join('models', 'models.id = machines.models_id');
        $this->db->join('brands', 'brands.id = models.brands_id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->where('orders.current_status_id', '2');
        $query = $this->db->get();
        return($query->result());
    }

    public function get_order_for_option($order_id, $option) {
        $this->db->_protect_identifiers = false;
        $this->db->query("SET sql_mode = ''");
        if ($option == 'send_sms_on_receive') {
            $this->db->select('under_warranty, examine_date, examine_cost as examining_cost, delivery_date, estimated_cost as cost_estimation, id as order_number');
        } else if ($option == 'send_sms_on_cancelled') {
            $this->db->select('under_warranty, examine_cost as examining_cost,  id as order_number');
        } else {
            $this->db->select('under_warranty, examine_cost as examining_cost, spare_parts_cost, repair_cost, sum(spare_parts_cost + repair_cost) as total_cost, id as order_number');
        }

        $this->db->where('id', $order_id);
        $query = $this->db->get('orders');
        $query = $query->result_array();
        return $query[0];
    }

    public function get_order_for_email_option($order_id, $option) {
        $this->db->query("SET sql_mode = ''");
        if ($option == 'send_email_on_receive') {
            $this->db->select('under_warranty, examine_date, examine_cost as examining_cost, delivery_date, estimated_cost as cost_estimation, id as order_number');
        } else if ($option == 'send_email_on_cancelled') {
            $this->db->select('under_warranty, examine_cost as examining_cost,  id as order_number');
        } else {
            $this->db->select('under_warranty, examine_cost as examining_cost, spare_parts_cost, repair_cost, sum(spare_parts_cost + repair_cost) as total_cost, id as order_number');
        }

        $this->db->where('id', $order_id);
        $query = $this->db->get('orders');
        $query = $query->result_array();
        return $query[0];
    }

    public function send_message_to_customer_action($order_id, $customer_phone, $message) {

        $this->load->model('model_users');
        $assigner = $this->model_users->get_user_data_by_user_name($this->session->userdata('user_name'));
        $assigner_id = $assigner[0]->id;
        date_default_timezone_set('Asia/Riyadh');
        $data = array
            (
            'orders_id' => $order_id,
            'description' => $message,
            'users_id' => $assigner_id,
            'target_user' => $assigner_id,
            'status_id' => 2,
            'categories_id' => 10,
            'date' => date("Y-m-d H:i:s", time())
        );

        $this->db->insert('actions', $data);
    }

    public function update_place($order_id, $place) {
        $this->db->where('id', $order_id);
        $this->db->update('orders', array('place' => $place));
    }

    public function get_orders_assigned_to_technician_from_more_24($tech) {

        $this->load->model('model_users');
        $orders = $this->get_technician_tasks_by_name2($tech);
        $tech_id = $this->model_users->get_user_data_by_user_name($tech);
        $tech_id = $tech_id[0]->id;
        foreach ($orders as $order) {

            $last = $this->get_last_order_tech_excuse($tech_id, $order->id);
            if ($last == true && $this->assigned_from_24($order->id, $tech_id)) {
                $result[] = array('id' => $order->id, 'fault' => $order->fault_description);
            }
        }
        return $result;
    }

    public function get_last_order_tech_excuse($tech_id, $order_id) {
        $this->db->select('date as Date');
        $this->db->from('excuses');
        $this->db->where('tech_id', $tech_id);
        $this->db->where('order_id', $order_id);
        $this->db->order_by('id desc');
        $this->db->limit(1);
        $result = $this->db->get();
        $result = $result->result();
        if ($result == null) {
            return true;
        }

        $date = $result[0]->Date;
        date_default_timezone_set('Asia/Riyadh');
        $date1 = new DateTime($date);

        $today = new DateTime(date("Y-m-d H:i:s", time()));
        $diff = $today->diff($date1);
        $hours = $diff->h;
        $hours = $hours + ($diff->days * 24);
        $day = date('w', $today);
        if ($day == '6') {
            if ($hours > 48) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($hours > 24) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function last_tech_excuse($id) {
        $this->db->select('date as Date');
        $this->db->from('excuses');
        $this->db->where('tech_id', $id);
        $this->db->order_by('date desc');
        $this->db->limit(1);
        $result = $this->db->get();
        $result = $result->result();
        if ($result == null) {
            return true;
        }
        $date = $result[0]->Date;
        $date = new DateTime($date);
        date_default_timezone_set('Asia/Riyadh');
        $today = new DateTime(date("Y-m-d H:i:s", time()));
        $diff = $today->diff($date);
        $hours = $diff->h;
        $hours = $hours + ($diff->days * 24);
        if ($hours > 24) {
            return true;
        } else {
            return false;
        }
    }

    public function give_excuse($exc, $order_id) {
        $this->load->model('model_users');
        $tech_id = $this->model_users->get_user_data_by_user_name($this->session->userdata('user_name'));
        $tech_id = $tech_id[0]->id;
        date_default_timezone_set('Asia/Riyadh');
        $data = array
            (
            'order_id' => $order_id,
            'tech_id' => $tech_id,
            'excuse' => $exc,
            'date' => date("Y-m-d H:i:s", time())
        );
        $this->db->insert('excuses', $data);
        $last = $this->db->insert_id();
        $this->db->where('id', $order_id);
        $this->db->update('orders', array('last_excuse_id' => $last));
    }

    public function assigned_from_24($order_id, $tech) {
        $this->db->select('date as Date');
        $this->db->from('actions');
        $this->db->where('orders_id', $order_id);
        $this->db->where('target_user', $tech);
        $this->db->where('categories_id', 2);
        //	$this->db->order_by('date desc');
        //$this->db->limit(1);
        $result = $this->db->get();
        $result = $result->result();
        $date = $result[0]->Date;
        $date = new DateTime($date);
        $std = new DateTime('2015-09-21 00:00:00');
        date_default_timezone_set('Asia/Riyadh');
        if ($date > $std) {
            $today = new DateTime(date("Y-m-d H:i:s", time()));
            $diff = $today->diff($date);
            $hours = $diff->h;
            $hours = $hours + ($diff->days * 24);
            if ($hours > 24) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function search_order_id($query) {
        $q = "SELECT `orders`.id as order_id, `orders`.machines_id "
                . "from `orders` "
                . "join `machines` "
                . "on `machines`.id = `orders`.machines_id";
        if (count($query) < 3) {
            $q .= " where `orders`.id like '%$query%' OR "
                    . "`machines`.serial_number like '%$query%'";
        } else {
            $q .= " where match(`orders`.id) AGAINST ('$query*' In Boolean mode ) OR "
                    . "match(`machines`.serial_number) AGAINST ('$query*' In Boolean mode )";
        }
        return $this->db->query($q)->result();
    }

    public function search_order_by_phone($q) {
        $this->db->select('orders.id, brands.name, models.model, contacts.first_name, contacts.last_name, orders.fault_description, current_status_id, status.name as state');
        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id');
        $this->db->join('models', 'models.id = machines.models_id');
        $this->db->join('brands', 'brands.id = models.brands_id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->join('status', 'orders.current_status_id = status.id');
//        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->where('contacts.phone', $q);
        $this->db->or_where('concat(5,contacts.phone)', $q);
        $this->db->or_where('concat(9665,contacts.phone)', $q);
        $this->db->or_where('concat(966,contacts.phone)', $q);

        $query = $this->db->get();
        return($query->result());
    }

    public function search_order_by_filters($id, $name, $phone, $serial, $type, $brand, $model, $color) {
        if (
                $phone == '' &&
                $name == '' &&
                $serial == '' &&
                $type == 0 &&
                $brand == 0 &&
                $model == 0 &&
                $color == 0
        )
            return array();
        $this->db->select('orders.id, brands.name, models.model, contacts.first_name, contacts.last_name, orders.fault_description, current_status_id, status.name as state');
        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id');
        $this->db->join('models', 'models.id = machines.models_id');
        $this->db->join('brands', 'brands.id = models.brands_id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->join('status', 'orders.current_status_id = status.id');
//        $this->db->join('actions', 'actions.orders_id = orders.id');
//        $this->db->where('orders.id',"");
        if ($phone != '') {
//            $this->db->where('concat(5,contacts.phone)', $q);
//            $this->db->where('concat(9665,contacts.phone)', $q);
            $this->db->where('(concat(966,contacts.phone)="' . $q . ' or concat(9665,contacts.phone)="' . $q . ' or concat(5,contacts.phone)="' . $q . '")');
        }
        if ($name != '') {
            $this->db->where('(contacts.first_name="' . $name . '" or contacts.last_name="' . $name . '" or concat(contacts.first_name,contacts.last_name)="' . $name . '")');
//            $this->db->where('contacts.last_name', $name);
//            $this->db->where('concat(contacts.first_name,contacts.last_name)', $name);
        }
        if ($serial != '') {
            $this->db->where("machines.serial_number like '%" . $serial . "%'");
        }
        if ($type != 0) {
            $this->db->where('machines.machines_types_id', $type);
        }
        if ($brand != 0) {
            $this->db->where('machines.brands_id', $brand);
        }
        if ($model != 0) {
            $this->db->where('machines.models_id', $model);
        }
        if ($color != 0) {
            $this->db->where('machines.color_id', $color);
        }

        $query = $this->db->get();
        return($query->result());
    }

    public function save_call_action($order_id, $agreed, $date) {
        $this->load->model('model_users');
        $assigner = $this->model_users->get_user_data_by_user_name($this->session->userdata('user_name'));
        $assigner_id = $assigner[0]->id;
        $this->db->insert('actions', array(
            'description' => $agreed . " " . $date,
            'orders_id' => $order_id,
            'status_id' => 2,
            'target_user' => $assigner_id,
            'users_id' => $assigner_id,
            'categories_id' => 11
        ));
    }

    public function get_order_place($q, $s) {
        $this->db->select('actions.description');
        $this->db->from('orders');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->where('orders.id', $q);
        $this->db->where('actions.status_id', $s);
        $query = $this->db->get();
        return($query->row());
    }

    public function set_distructed($user_name, $order_id) {
        $this->load->model('model_users');
        $user = $this->model_users->get_user_data_by_user_name($user_name);
        $user_id = $user[0]->id;

        $this->db->where('id', $order_id);
        $costs = $this->db->get('orders');
        $costs = $costs->result();

        date_default_timezone_set('Asia/Riyadh');
        $my_date = date("Y-m-d H:i:s", time());
        $action_data = array
            (
            'orders_id' => $order_id,
            'users_id' => $user_id,
            'description' => "",
            'date' => $my_date,
            'categories_id' => '12',
            'status_id' => '6'
        );
        $data = array
            (
            'current_status_id' => 6,
            'distructed' => 1
        );

        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);

        $this->db->insert('actions', $action_data);
        return $my_date;
    }

    public function get_employee_warranty_orders($user_name) {
        $this->load->model('model_users');
        $user = $this->model_users->get_user_data_by_user_name($user_name);
//        var_dump($user[0]->warranty_follower);die()
        if ($user[0]->warranty_follower) {
            $user_id = $user[0]->id;
            return $this->db->select("orders.*,warranty_sent.*")
                            ->from('orders')
                            ->join('actions', 'actions.orders_id = orders.id')
                            ->join('warranty_sent', 'warranty_sent.warranty_sent_id = orders.sent', 'left')
                            ->where('orders.under_warranty', 1)
                            ->where('actions.categories_id', 1)
//                            ->where('actions.users_id', $user_id)
                            ->where('current_status_id !=', 6)
                            ->where('(shipping_company is null or '
                                    . 'bill_of_lading is null or '
                                    . 'received_date is null or '
                                    . 'arrived_receipt_number is null or '
                                    . 'agent_name is null or '
                                    . 'receipt_employee_id is null or '
                                    . 'shipping_company = "" or '
                                    . 'bill_of_lading = "" or '
                                    . 'received_date = "" or '
                                    . 'arrived_receipt_number = "" or '
                                    . 'agent_name = "" or '
                                    . 'receipt_employee_id = "")')
                            ->get()->result();
        } else {
            return array();
        }
    }

    public function set_receipt_info(
    $order_id, $shipping_company, $bill_of_lading, $agent_name, $received_date, $arrived_receipt_number, $receipt_employee
    ) {
        $s = $this->db
                        ->select('*')
                        ->from('orders')
                        ->join('warranty_sent', 'warranty_sent.warranty_sent_id = orders.sent')
                        ->where('orders.id', $order_id)
                        ->get()->row();
        if ($s) {
            $this->db->where('warranty_sent_id', $s->sent)
                    ->update('warranty_sent', array(
                        'shipping_company' => $shipping_company,
                        'bill_of_lading' => $bill_of_lading,
                        'agent_name' => $agent_name,
                        'received_date' => $this->prepareDate($received_date),
                        'arrived_receipt_number' => $arrived_receipt_number,
                        'receipt_employee_id' => $receipt_employee
                            )
            );
        } else {
            $this->db->insert('warranty_sent', array(
                'shipping_company' => $shipping_company,
                'bill_of_lading' => $bill_of_lading,
                'agent_name' => $agent_name,
                'received_date' => $this->prepareDate($received_date),
                'arrived_receipt_number' => $arrived_receipt_number,
                'receipt_employee_id' => $receipt_employee
                    )
            );
            $sent = $this->db->insert_id();
            $this->db->where('id', $order_id)
                    ->update('orders', array('sent' => $sent));
        }
        return $this->db->select("orders.*,warranty_sent.*")
                        ->from('orders')
                        ->join('actions', 'actions.orders_id = orders.id')
                        ->join('warranty_sent', 'warranty_sent.warranty_sent_id = orders.sent', 'left')
                        ->where('orders.under_warranty', 1)
                        ->where('actions.categories_id', 1)
                        ->where('orders.id', $order_id)
                        ->where('(shipping_company is null or '
                                . 'bill_of_lading is null or '
                                . 'received_date is null or '
                                . 'arrived_receipt_number is null or '
                                . 'agent_name is null or '
                                . 'receipt_employee_id is null or '
                                . 'shipping_company = "" or '
                                . 'bill_of_lading = "" or '
                                . 'received_date = "" or '
                                . 'arrived_receipt_number = "" or '
                                . 'agent_name = "" or '
                                . 'receipt_employee_id = "")')
                        ->get()->row();
    }

    public function cancel($order_id,$reason,$user_name) {
        $this->load->model('model_users');
        $user = $this->model_users->get_user_data_by_user_name($user_name);
        $user_id = $user[0]->id;
        date_default_timezone_set('Asia/Riyadh');
        $my_date = date("Y-m-d H:i:s", time());
        $data = array
            (
            'orders_id' => $order_id,
            'users_id' => $user_id,
            'description' => lang('cancel_order').": ".$reason,
            'repair_cost' => 0,
            'spare_parts_cost' => 0,
            'date' => $my_date,
            'categories_id' => 4,
            'status_id' => 4,
        );
        //echo "amal";
        $this->db->insert('actions', $data);
        $this->db->where('id', $order_id)
                ->update('orders', array('canceled' => 1, 'current_status_id' => 4));
    }

}
