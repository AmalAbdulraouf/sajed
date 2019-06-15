<?php

class Model_contacts extends CI_Model {

    public function get_list_of_customers() {
        $this->db->select('DISTINCT(phone)');
        $this->db->from('contacts')->where('length(phone)', 8)->group_by('phone');
        $query = $this->db->get()->result();
        foreach ($query as $phone) {
            $info = $this->db->select('first_name, last_name, email')
                            ->from('contacts')
                            ->where('phone', $phone->phone)
                            ->order_by('id', 'ASC')
                            ->limit(1)
                            ->get()->row();
            $phone->first_name = $info->first_name;
            $phone->last_name = $info->last_name;
            $phone->email = $info->email;
        }
        return($query);
    }

//    public function get_not_delivered($id) {
//        return $this->db->select('orders.*')
//                ->where('current_status_id !=', 6)
//                ->where('customer_id', $id)
//                ->get()->result();
//    }

    public function search($query) {
        $q = "select DISTINCT contacts.*, company_delegate.company_delegate_id, company.name as company_name, company.company_id as company_id"
                . ' from contacts'
                . ' left join company_delegate on company_delegate.contact_id = contacts.id '
                . ' left join company on company_delegate.company_id = company.company_id ';
        if (count($query) < 3) {
            $q .= " where contacts.first_name like '%$query%' OR "
                    . "contacts.last_name like '%$query%' OR "
                    . "contacts.phone like '%$query%' OR "
                    . "contacts.id like '%$query%'";
        } else {
            $q .= " where match(contacts.first_name) AGAINST ('$query*' In Boolean mode ) OR "
                    . "match(contacts.last_name) AGAINST ('$query*' In Boolean mode ) OR "
                    . "match(contacts.phone) AGAINST ('$query*' In Boolean mode ) OR "
                    . "match(contacts.id) AGAINST ('$query*' In Boolean mode )";
        }
        return $this->db->query($q)->result();
    }

    public function get_not_delivered($id) {
//        $this->load->model('model_users');
//        $user = $this->model_users->get_user_data_by_user_name($user_name);
//        $user_id = $user[0]->id;

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
				) assignment_actions";

        $this->db->select('orders.id, brands.name, models.model, contacts.first_name, contacts.last_name, orders.fault_description');
        $this->db->DISTINCT();
        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id');
        $this->db->join('models', 'models.id = machines.models_id');
        $this->db->join('brands', 'brands.id = models.brands_id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join("$order_assignment", 'assignment_actions.orders_id = orders.id');
        $this->db->where('orders.current_status_id', '2');
        $this->db->where('orders.customer_id', $id);
        $this->db->where('actions.categories_id', '2');
        // $this->db->where('actions.target_use', $user_id);
        $query = $this->db->get();
        return($query->result());
    }

    public function get_prev_machines($id) {
//        $this->load->model('model_users');
//        $user = $this->model_users->get_user_data_by_user_name($user_name);
//        $user_id = $user[0]->id;

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
				) assignment_actions";

        $this->db->select('orders.Notes,orders.under_warranty,orders.color_id,'
                . ' colors.color_name, orders.billDate,orders.billNumber,'
                . 'machines.machines_types_id,machines.id,machines.faults, '
                . 'orders.under_warranty, orders.billNumber, orders.billDate, brands.name, brands.id as brand_id,'
                . ' models.model, contacts.first_name, contacts.last_name, orders.fault_description, '
                . 'machines.serial_number, machines.image');
        $this->db->DISTINCT();
        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id');
        $this->db->join('models', 'models.id = machines.models_id');
        $this->db->join('brands', 'brands.id = models.brands_id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join('colors', 'orders.color_id = colors.id');
        $this->db->join("$order_assignment", 'assignment_actions.orders_id = orders.id');
//        $this->db->where('orders.current_status_id', '2');
        $this->db->where('orders.customer_id', $id);
//        $this->db->where('actions.categories_id', '2');
        // $this->db->where('actions.target_use', $user_id);
        $query = $this->db->get();
        return($query->result());
    }

    public function get_by_id($id) {
        return $this->db->select("*")
                        ->from('contacts')
                        ->where('id', $id)
                        ->get()->row();
    }

    public function contact_rate($customer_id, $rate) {
        $this->db->where('id', $customer_id)->update('contacts', array('rate' => $rate));
    }

}
