<?php

class Model_companies extends CI_Model {

    public function search($query) {
        $q = "select DISTINCT company.*"
                . ' from company ';
        if (count($query) < 3) {
            $q .= " where company.name like '%$query%'";
        } else {
            $q.=" where match(company.name) AGAINST ('$query*' In Boolean mode )";
        }
        return $this->db->query($q)->result();
    }

    public function add_new_company($company) {
        $this->db->insert('company', $company);
        return($this->db->insert_id());
    }

    public function add_company_delegate($info) {
        $this->db->insert('company_delegate', $info);
        return($this->db->insert_id());
    }

    public function get_not_delivered($id) {
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
        $this->db->join('company_delegate', 'company_delegate.contact_id = orders.customer_id');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join("$order_assignment", 'assignment_actions.orders_id = orders.id');
        $this->db->where('orders.current_status_id', '2');        
        $this->db->where('orders.company', '1');
        $this->db->where('company_delegate.company_id', $id);
        $this->db->where('actions.categories_id', '2');
        // $this->db->where('actions.target_use', $user_id);
        $query = $this->db->get();
        return($query->result());
    }

    public function get_prev_machines($id) {
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

        $this->db->select('machines.faults,orders.Notes,orders.under_warranty,orders.color_id, colors.color_name, orders.billDate,orders.billNumber,'
                . 'machines.machines_types_id,machines.id,'
                . ' orders.under_warranty, orders.billNumber, orders.billDate, brands.name, brands.id as brand_id,'
                . ' models.model, contacts.first_name, contacts.last_name, orders.fault_description,'
                . ' machines.serial_number, machines.serial_number, machines.image');
        $this->db->DISTINCT();
        $this->db->from('orders');
        $this->db->join('machines', 'orders.machines_id = machines.id');
        $this->db->join('models', 'models.id = machines.models_id');
        $this->db->join('brands', 'brands.id = models.brands_id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->join('colors', 'orders.color_id = colors.id');
        $this->db->join('company_delegate', 'company_delegate.contact_id = orders.customer_id');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join("$order_assignment", 'assignment_actions.orders_id = orders.id');
//        $this->db->where('orders.current_status_id', '2');        
        $this->db->where('orders.company', '1');
        $this->db->where('company_delegate.company_id', $id);
//        $this->db->where('actions.categories_id', '2');
        // $this->db->where('actions.target_use', $user_id);
        $query = $this->db->get();
        return($query->result());
    }

}
