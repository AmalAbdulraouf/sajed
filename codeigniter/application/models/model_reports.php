<?php

class Model_Reports extends CI_Model {

    function __construct() {
        $this->db->query("SET sql_mode = ''");
    }

    public function get_data_cash_summery_report($date_from, $date_to) {

        $this->db->select('count(id) as received_count');
        $this->db->from('actions');
        $this->db->where('categories_id = "1"');
        $date_from = $this->prepareDateFrom($date_from);
        $date_to = $this->prepareDateTo($date_to);
        if ($date_from != "") {
            $this->db->where("actions.date >=  \"$date_from\"");
        }
        if ($date_to != "") {
            $this->db->where("actions.date <=  \"$date_to\"");
        }
        $query = $this->db->get();
        $received_count = $query->result();
        $received_count = $received_count[0]->received_count;



        $this->db->select('count(id) as delivered_count');
        $this->db->from('actions');
        $this->db->where('status_id = "6"');
        $this->db->where('categories_id = "5"');
        if ($date_from != "") {
            $this->db->where("actions.date >=  \"$date_from\"");
        }
        if ($date_to != "") {
            $this->db->where("actions.date <=  \"$date_to\"");
        }
        $query = $this->db->get();
        $delivered_count = $query->result();
        $delivered_count = $delivered_count[0]->delivered_count;


        $this->db->select('count(id) as repaired_count');
        $this->db->from('actions');
        $this->db->where('status_id = "5"');
        $this->db->where('categories_id = "7"');
        if ($date_from != "") {
            $this->db->where("actions.date >=  \"$date_from\"");
        }
        if ($date_to != "") {
            $this->db->where("actions.date <=  \"$date_to\"");
        }
        $query = $this->db->get();
        $repaired_count = $query->result();
        $repaired_count = $repaired_count[0]->repaired_count;


        $this->db->select('count(id) as cancelled_count');
        $this->db->from('actions');
        $this->db->where('status_id = "4"');
        $this->db->where('categories_id = "4"');
        if ($date_from != "") {
            $this->db->where("actions.date >=  \"$date_from\"");
        }
        if ($date_to != "") {
            $this->db->where("actions.date <=  \"$date_to\"");
        }
        $query = $this->db->get();
        $cancelled_count = $query->result();
        $cancelled_count = $cancelled_count[0]->cancelled_count;

        $this->db->select(
                '
			sum(orders.spare_parts_cost) as spare_cost,
			sum(orders.repair_cost) as repair_cost, 
			sum(orders.repair_cost + orders.spare_parts_cost + orders.examine_cost) as cash, 
			users.user_name, 
			count(actions.id) as orders_count, 
			sum(orders.examine_cost) as examine_cost, users.id
		');
        $this->db->from('users');
        $this->db->join('actions', 'actions.users_id = users.id');
        $this->db->join('orders', 'orders.id = actions.orders_id');
        if ($date_from != "") {
            $this->db->where("actions.date >=  \"$date_from\"");
        }
        if ($date_to != "") {
            $this->db->where("actions.date <=  \"$date_to\"");
        }
        $this->db->where("actions.status_id = '6'");
        //$this->db->where("orders.current_status_id = '6'");
        $this->db->group_by("users.user_name");
        $query = $this->db->get();
        $cash_details = $query->result();



        $this->db->select('sum(actions.spare_parts_cost) as spare_cost,sum(actions.repair_cost) as repair_cost, sum(actions.repair_cost + actions.spare_parts_cost + orders.examine_cost) as cash, count(actions.id) as orders_count, sum(orders.examine_cost) as examine_cost');
        $this->db->from('actions');
        $this->db->join('orders', 'orders.id = actions.orders_id');
        if ($date_from != "") {
            $this->db->where("actions.date >=  \"$date_from\"");
        }
        if ($date_to != "") {
            $this->db->where("actions.date <=  \"$date_to\"");
        }
        $this->db->where("actions.status_id = '6'");
        $query = $this->db->get();
        $total_cash = $query->result();
        $total_cash = $total_cash[0];

        $results = array
            (
            'received_count' => $received_count,
            'delivered_count' => $delivered_count,
            'repaired_count' => $repaired_count,
            'cancelled_count' => $cancelled_count,
            'cash_details' => $cash_details,
            'total_cash' => $total_cash
        );

        return $results;
    }

    public function get_data_technicians_accomplishment($date_from, $date_to) {
        $date_time_filter_string = "";

        $date_from = $this->prepareDateFrom($date_from);
        $date_to = $this->prepareDateTo($date_to);

        //if($date_from != "")
        //{
        //	$date_time_filter_string .= " and actions.date >= \"$date_from\" ";
        //}
        //if($date_to != "")
        //{
        //	$date_time_filter_string .= " and actions.date <= \"$date_to\" ";
        //}
        //$this->db->select('users.user_name');
        //$this->db->select("(select count(*) from actions where actions.status_id = 4 and  actions.categories_id = 4 and actions.users_id = masterTb.users_id $date_time_filter_string) as cancelled_count");
        //$this->db->select("(select count(*) from actions where actions.status_id = 5 and actions.categories_id = 7 and actions.users_id = masterTb.users_id $date_time_filter_string) as done_count");
        //$this->db->select("(select count(*) from actions where actions.categories_id = 3 and actions.users_id = masterTb.users_id $date_time_filter_string) as repair_actions_count");
        //$this->db->from('actions masterTb');
        //$this->db->join('users', 'masterTb.users_id = users.id');
        //if($date_from != "")
        //{
        //	$this->db->where("masterTb.date >=  \"$date_from\"");
        //}
        //	if($date_to != "")
        //{
        //	$this->db->where("masterTb.date <=  \"$date_to\"");
        //}
        //$this->db->group_by('users.user_name');
        $query = "
			select 
				users_id
				,count(actions.id) as Count
				,status_id
				,users.user_name
				,sum(actions.spare_parts_cost) as spare_cost
				,sum(actions.repair_cost) as repair_cost
				,sum(actions.repair_cost + actions.spare_parts_cost + orders.examine_cost) as cash
				,sum(orders.examine_cost) as examine_cost
			 
			from actions
			join orders on orders.id = actions.orders_id
			join users on users.id = actions.users_id 
				where 
					( 
						(actions.status_id = 4 and actions.categories_id = 4) 
						OR (actions.status_id = 5 and actions.categories_id = 7) 
						OR (actions.categories_id = 3)
						 
					) 
					and `actions`.`date` >= '$date_from' 
					and `actions`.`date` <= '$date_to'
			group by `actions`.`users_id`, `categories_id`
		";

        $query2 = $this->db->query($query);
        $results = $query2->result();




        $query = "
		SELECT 
	assignments.technician, sum((TIMESTAMPDIFF(MINUTE, assigned_date , ready_date ))) / count(assignments.orders_id) as average_time,
	sum(assignments.repair_cost) as repair_cost
FROM
    (
		(
			SELECT 
				 actions.`orders_id`,
				`date` AS assigned_date,
				actions.repair_cost,
				`target_user` AS technician
			FROM
				actions
			WHERE
				categories_id = 2
		) assignments
        join  
        (
			SELECT 
				actions.`orders_id`,
				`date` AS ready_date,
				actions.repair_cost,
				users_id AS technician
			FROM
				actions
			WHERE
				categories_id = 7
		) closes
        on 
			closes.orders_id = assignments.orders_id 
			and
			closes.technician = assignments.technician
			and closes.ready_date >= '$date_from'
			and closes.ready_date <= '$date_to'
			and assignments.assigned_date <= '$date_to'
	)  
    group by technician
     
		";

        $average = $this->db->query($query);
        $average = $average->result();
        $query = "
			select 
				users_id
				,count(actions.id) as Count
				,status_id
				,users.user_name
				,sum(actions.spare_parts_cost) as spare_cost
				,sum(actions.repair_cost) as repair_cost
				,sum(actions.repair_cost + actions.spare_parts_cost + orders.examine_cost) as cash
				,sum(orders.examine_cost) as examine_cost
			 
			from     actions
	join orders on orders.id = actions.orders_id
	join users on users.id = actions.users_id 
	where 
	categories_id = 5 and
				`actions`.`date` >= '$date_from' 
				and `actions`.`date` <= '$date_to'
	 and `actions`.users_id = actions.users_id
	group by actions.users_id
		";


        $result2 = $this->db->query($query);
        $result2 = $result2->result();
        $data = array('report_results' => $results, 'average' => $average, 'final_result' => $result2);
        return $data;
    }

    public function get_data_done_work_by_machine_type($date_from, $date_to) {
        $this->db->select('MT.name as machine_type');
        $cat_array = array(
            'recieved_count' => 1,
            'cancelled_count' => 4,
            'delivered_count' => 5,
            'repaired_count' => 7
        );

        $date_from = $this->prepareDateFrom($date_from);
        $date_to = $this->prepareDateTo($date_to);

        foreach (array_keys($cat_array) as $category) {
            $query_txt = "
				(select count(actions.id) from actions 
					left join actions_categories on actions.categories_id = actions_categories.id
					left join orders on orders.id = actions.orders_id
					left join machines on machines.id = orders.machines_id
					left join machines_types on machines.machines_types_id = machines_types.id
					where actions.categories_id = $cat_array[$category] and machines_types.id = MT.id";

            if ($date_from != "") {
                $query_txt = $query_txt . (" and actions.date >=  \"$date_from\"");
            }
            if ($date_to != "") {
                $query_txt = $query_txt . (" and actions.date  <=  \"$date_to\"");
            }
            $query_txt = $query_txt . ") as $category";
            $this->db->select($query_txt);
        }
        $this->db->from('machines_types MT');
        $this->db->group_by('MT.name');
        $query = $this->db->get();
        $results = $query->result();
        return($results);
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

    public function load_non_delivered_orders($date_from) {
        $date_from = $this->prepareDateFrom($date_from);
        $this->db->select('orders.id, orders.fault_description, actions.date ');
        $this->db->from('orders');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->where('orders.current_status_id !=', 6);
        $this->db->where('actions.status_id', 1);
        $this->db->where('actions.date >=', $date_from);
        $result = $this->db->get();
        return($result->result());
    }

    public function search_excuses_by_order_id($order_id) {
        $this->db->select('excuses.order_id, users.user_name, excuses.excuse, excuses.date');
        $this->db->from('excuses');
        $this->db->join('users', 'users.id = excuses.tech_id');
        $this->db->where('excuses.order_id', $order_id);
        $this->db->order_by('excuses.date desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return($query->result());
    }

    public function order_all_excuses($order_id) {
        $this->db->select('excuses.order_id, users.user_name, excuses.excuse, excuses.date');
        $this->db->from('excuses');
        $this->db->join('users', 'users.id = excuses.tech_id');
        $this->db->where('excuses.order_id', $order_id);
        $this->db->order_by('excuses.date desc');
        $query = $this->db->get();
        return($query->result());
    }

    public function search_orders_excuses_by_filters($tech_id, $date_from, $date_to, $delivered_or_not) {
        $this->load->model('model_order');
        $date_from = $this->model_order->prepareDateFrom($date_from);
        $date_to = $this->model_order->prepareDateTo($date_to);
        $this->db->select('excuses.order_id, users.user_name, excuses.excuse, excuses.date');
        $this->db->from('excuses');
        $this->db->join('users', 'users.id = excuses.tech_id');
        $this->db->join('orders', 'orders.id = excuses.order_id');
        if ($tech_id != 0) {
            $this->db->where('excuses.tech_id', $tech_id);
        }
        if ($date_from != "") {
            $this->db->where("excuses.date >=  \"$date_from\"");
        }
        if ($date_to != "") {
            $this->db->where("excuses.date <=  \"$date_to\"");
        }
        if ($delivered_or_not == 'search_delivered') {
            $this->db->where("orders.current_status_id", 6);
        } else if ($delivered_or_not == 'search_undelivered') {
            $this->db->where("orders.current_status_id !=", 6);
        }

        $this->db->group_by("excuses.order_id");
        //$this->db->order_by('date desc');
        $this->db->where('excuses.id = orders.last_excuse_id');
        //$this->db->limit(1);
        $query = $this->db->get();
        return($query->result());
    }

    public function all_order_excuses($order) {
        $this->db->select('excuses.order_id, users.user_name, excuses.excuse, excuses.date');
        $this->db->from('excuses');
        $this->db->join('users', 'users.id = excuses.tech_id');
        $this->db->join('orders', 'orders.id = excuses.order_id');
        $this->db->where('order_id', $order);
        //$this->db->order_by('date desc');
        //$this->db->where('excuses.id = orders.last_excuse_id');
        $exc = $this->db->get();
        return ($exc->result());
    }

    public function get_delivered_report($start_date, $end_date, $sWhere, $sOrder, $sLimit) {
        $this->db->_protect_identifiers = false;
        $this->db->select('orders.software,orders.electronic,orders.external_repair,orders.under_warranty,orders.id as order_id, orders.fault_description, actions.date ,orders.repair_cost,orders.spare_parts_cost,(orders.repair_cost+orders.spare_parts_cost) as total');
        $this->db->from('orders');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->where('orders.current_status_id', 6);
        $this->db->where('actions.categories_id', 5);
        if ($sWhere != "")
            $this->db->where($sWhere, '', false);
        else {
            $this->db->where('date(actions.date) >=', $start_date);
            $this->db->where('date(actions.date) <=', $end_date);
        }
        $this->db->order_by($sOrder . ' ' . $sLimit);
        $result = $this->db->get();
        return($result->result());
    }

    public function ready_not_delivered($start_date, $end_date, $sWhere, $sOrder, $sLimit) {
        $this->db->_protect_identifiers = false;
        $this->db->select('orders.software,orders.electronic,orders.external_repair,orders.id as order_id, orders.fault_description, '
                . 'TIMESTAMPDIFF(DAY,actions.date,CURRENT_TIMESTAMP) as date ,orders.repair_cost,'
                . 'actions.description as place,orders.spare_parts_cost,'
                . 'concat(contacts.first_name," ", contacts.last_name) as contact_name,contacts.phone,'
                . '(orders.repair_cost+orders.spare_parts_cost) as total');
        $this->db->from('orders');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->where('orders.current_status_id', 5);
        $this->db->where('actions.categories_id', 7);
        if ($sWhere != "")
            $this->db->where($sWhere, '', false);
        else {
            $this->db->where('date(actions.date) >=', $start_date);
            $this->db->where('date(actions.date) <=', $end_date);
        }
        $this->db->order_by($sOrder . ' ' . $sLimit);
        $result = $this->db->get();
        return($result->result());
    }

    public function warranty_not_delivered($start_date, $end_date, $sWhere, $sOrder, $sLimit) {
        $this->db->_protect_identifiers = false;
        $this->db->select('orders.software,orders.electronic,orders.external_repair,orders.id as order_id, orders.fault_description, '
                . 'TIMESTAMPDIFF(DAY,actions.date,CURRENT_TIMESTAMP) as date ,orders.repair_cost,'
                . 'actions.description as place,orders.spare_parts_cost,'
                . 'concat(contacts.first_name," ", contacts.last_name) as contact_name,contacts.phone,'
                . '(orders.repair_cost+orders.spare_parts_cost) as total');
        $this->db->from('orders');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->where('orders.current_status_id', 5);
        $this->db->where('orders.under_warranty', 1);
        $this->db->where('actions.categories_id', 7);
        if ($sWhere != "")
            $this->db->where($sWhere, '', false);
        else {
            $this->db->where('date(actions.date) >=', $start_date);
            $this->db->where('date(actions.date) <=', $end_date);
        }
        $this->db->order_by($sOrder . ' ' . $sLimit);
        $result = $this->db->get();
        return($result->result());
    }

    public function cancelled_not_delivered($start_date, $end_date, $sWhere, $sOrder, $sLimit) {
        $this->db->_protect_identifiers = false;
        $this->db->select('orders.software,orders.electronic,orders.external_repair,orders.id as order_id, orders.fault_description, '
                . 'TIMESTAMPDIFF(DAY,actions.date,CURRENT_TIMESTAMP) as date ,orders.repair_cost,'
                . 'actions.description as place,orders.spare_parts_cost,'
                . 'concat(contacts.first_name," ", contacts.last_name) as contact_name,contacts.phone,'
                . '(orders.repair_cost+orders.spare_parts_cost) as total');
        $this->db->from('orders');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->where('orders.current_status_id', 4);
        $this->db->where('actions.categories_id', 4);
        if ($sWhere != "")
            $this->db->where($sWhere, '', false);
        else {
            $this->db->where('date(actions.date) >=', $start_date);
            $this->db->where('date(actions.date) <=', $end_date);
        }
        $this->db->order_by($sOrder . ' ' . $sLimit);
        $result = $this->db->get();
        return($result->result());
    }

    public function orders_report($start_date, $end_date, $sWhere, $sOrder, $sLimit) {
        $this->db->_protect_identifiers = false;
        $this->db->select(''
                . 'brands.name as brand, machines.serial_number, models.model as model, machines_types.name as machine_type,'
                . 'concat(contacts.first_name, " ",contacts.last_name) as customer_name, contacts.phone as phone,'
                . 'orders.software,orders.electronic,orders.external_repair,orders.id as order_id, status.name as state, actions.date ,orders.repair_cost,orders.spare_parts_cost,(orders.repair_cost+orders.spare_parts_cost) as total');
        $this->db->from('orders');
        $this->db->join('machines', 'machines.id = orders.machines_id');
        $this->db->join('machines_types', 'machines_types.id = machines.machines_types_id');
        $this->db->join('brands', 'brands.id = machines.brands_id');
        $this->db->join('models', 'machines.models_id = models.id');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join('contacts', 'orders.customer_id = contacts.id');
        $this->db->join('status', 'orders.current_status_id = status.id');
        $this->db->where('actions.status_id', 1);

        if ($sWhere != "")
            $this->db->where($sWhere, '', false);
        else {
            $this->db->where('date(actions.date) >=', $start_date);
            $this->db->where('date(actions.date) <=', $end_date);
        }
        $this->db->group_by('orders.id');
        $this->db->order_by($sOrder . ' ' . $sLimit);
        $result = $this->db->get();
        return($result->result());
    }

    public function services_report($start_date, $end_date, $sWhere, $sOrder, $sLimit) {
        $this->db->_protect_identifiers = false;
        $this->db->select(''
                . 'count(orders.id) as total_orders, '
                . 'orders.software,orders.electronic,orders.external_repair,sum(orders.repair_cost) as repair_cost, '
                . 'sum(orders.spare_parts_cost) as spare_parts_cost, (orders.repair_cost+orders.spare_parts_cost) as total');
        $this->db->from('orders');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join('status', 'orders.current_status_id = status.id');
        $this->db->where('actions.status_id', 6);

        if ($sWhere != "")
            $this->db->where($sWhere, '', false);
        else {
            $this->db->where('date(actions.date) >=', $start_date);
            $this->db->where('date(actions.date) <=', $end_date);
        }
        $this->db->group_by('orders.software');
        $this->db->group_by('orders.electronic');
        $this->db->group_by('orders.external_repair');
        $this->db->group_by('orders.under_warranty');
        $this->db->order_by($sOrder . ' ' . $sLimit);
        $result = $this->db->get();
        return($result->result());
    }

    public function warranty_sent_machines($start_date, $end_date, $sWhere, $sOrder, $sLimit) {
        $this->db->_protect_identifiers = false;
        $this->db->select('orders.software,orders.electronic,orders.external_repair,orders.under_warranty,orders.id as order_id, orders.fault_description, '
                . 'TIMESTAMPDIFF(DAY,actions.date,CURRENT_TIMESTAMP) as date ,orders.repair_cost,'
                . 'actions.description as place,orders.spare_parts_cost,'
                . 'concat(contacts.first_name," ", contacts.last_name) as contact_name,contacts.phone,'
                . '(orders.repair_cost+orders.spare_parts_cost) as total');
        $this->db->from('orders');
        $this->db->join('actions', 'actions.orders_id = orders.id');
        $this->db->join('contacts', 'contacts.id = orders.customer_id');
        $this->db->where('orders.sent', 1);
        $this->db->where('orders.current_status_id <', 5);
        $this->db->where('orders.under_warranty', 1);
//        $this->db->where('actions.categories_id', 7);
        if ($sWhere != "")
            $this->db->where($sWhere, '', false);
        else {
            $this->db->where('date(actions.date) >=', $start_date);
            $this->db->where('date(actions.date) <=', $end_date);
        }
        $this->db->order_by($sOrder . ' ' . $sLimit);
        $result = $this->db->get();
        return($result->result());
    }

}
