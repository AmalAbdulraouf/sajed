<?php

class Model_users extends CI_Model {

    public $user_name;
    public $first_name;
    public $last_name;
    public $phone;
    public $address;
    public $email;
    public $contacts_id;

    public function can_log_in() {
        $this->db->where('user_name', $this->input->post('user_name'));
        $this->db->where('password', md5($this->input->post('password')));
        $this->db->where('Activated', 1);

        $query = $this->db->get('users');

        if ($query->num_rows == 1) {
            $query = $query->result();
            $this->load->model('model_order');
            $user_permissions_array = $this->get_user_permissions($this->input->post('user_name'));
            if ($this->check_permission('Perform Repair Action', $user_permissions_array) && $this->input->post('user_name') != "admin") {
                $data = array(
                    'user_name' => $this->input->post('user_name'),
                    'is_logged_in' => 1,
                    'language' => $this->session->userdata('language')
                );
                $this->session->set_userdata($data);
                $orders = $this->model_order->get_orders_assigned_to_technician_from_more_24($this->input->post('user_name'));
                $this->session->set_userdata(array('give_attention' => count($orders)));
                $orders = array('orders' => $orders);
                $array = array
                    (
                    'name' => 'view_technician_attentions',
                    'data' => $orders
                );
                $this->load->view('view_template', $array);
            } else {
                $this->session->set_userdata(array('give_attention' => 0));
            }

            return true;
        } else {
            return false;
        }
    }

    function check_permission($permission, $user_permissions_array) {

        foreach ($user_permissions_array as $per) {
            if ($per->name == $permission)
                return true;
        }
        return false;
    }

    public function get_user_permissions($user_name) {
        $this->db->select('permissions.name');
        $this->db->from('users');
        $this->db->join('users_has_groups', 'users.id = users_has_groups.users_id');
        $this->db->join('groups', 'groups.id = users_has_groups.groups_id');
        $this->db->join('groups_has_permissions', 'groups.id = groups_has_permissions.groups_id');
        $this->db->join('permissions', 'permissions.id = groups_has_permissions.permissions_id');
        $this->db->where('users.user_name', $user_name);
        $query = $this->db->get();
        return($query->result());
    }

    public function get_list_of_users() {
        $this->db->select('id, user_name');
        $this->db->where('Activated', 1);

        //$this->db->where('user_name', $this->session->userdata('user_name'));
        $query = $this->db->get('users');
        return($query->result());
    }

    public function get_user_name_by_id($user_id) {
        $this->db->select('user_name');
        $this->db->from('users');
        $this->db->where('users.id', $user_id);
        $query = $this->db->get();
        $query_result = $query->result();
        $usr_name = $query_result[0]->user_name;
        return $usr_name;
    }

    public function get_user_data_by_id($user_id) {
        $query_string = "CALL get_user_data_by_id($user_id)";
        $query = $this->db->query($query_string);
        mysqli_next_result($this->db->conn_id);
        return($query->result());
    }

    public function get_user_data_by_user_name($user_name) {
        $this->db->select('warranty_follower, users.id, users.user_name, users.contact_id as contacts_id, users.Absent, contacts.first_name, contacts.last_name, contacts.phone, contacts.address, contacts.email');
        $this->db->from('users');
        $this->db->join('contacts', 'users.contact_id = contacts.id');
        $this->db->where('users.user_name', $user_name);
        $query = $this->db->get();
        return ($query->result());
    }

    public function update_user_info($user_info, $user_groups) {
        $query_string = "CALL update_user_info($user_info[0]->user_name, $user_info[0]->user_name, $user_info[0]->first_name, $user_info[0]->last_name, $user_info[0]->phone, $user_info[0]->address, $user_info[0]->email)";
        $this->db->query($query_string);
        mysqli_next_result($this->db->conn_id);

        $query_string = "CALL clear_user_from_groups($user_info[0]->user_name)";
        $query = $this->db->query($query_string);
        mysqli_next_result($this->db->conn_id);

        foreach ($user_groups as $group) {
            
        }

        return($query->result());
    }

    public function add_new_user($contact_info, $user_info, $user_groups) {
        $this->db->insert('contacts', $contact_info);
        $contact_id = $this->db->insert_id();
        $this->db->where('id', $contact_id);
        $this->db->update('contacts', array('contact_id' => $contact_id));


        $user_data = array
            (
            'user_name' => $user_info['user_name'],
            'password' => $user_info['password'],
            'warranty_follower' => $user_info['warranty_follower'],
            'contact_id' => $contact_id
        );
        $this->db->insert('users', $user_data);
        $user_id = $this->db->insert_id();

        if ($user_info['warranty_follower']) {
            $this->db->where('id !=', $user_id)
                    ->update('users', array
                        (
                        'warranty_follower' => false
                            )
            );
        }

        foreach ($user_groups as $grb) {
            $users_has_groups = array
                (
                'users_id' => $user_id,
                'groups_id' => $grb
            );
            $this->db->insert('users_has_groups', $users_has_groups);
        }
    }

    public function add_new_contact($contact_info) {
        $this->db->insert('contacts', $contact_info);
        return($this->db->insert_id());
    }

    public function edit_contact($contact_info) {
        $this->db->where('id', $contact_info['id']);
        $this->db->update('contacts', $contact_info);
        return($this->db->update_id());
    }

    public function update_user($user_name, $password, $warranty_follower, $contact_info, $user_groups) {
        $this->db->select('id, contact_id as contacts_id');
        $this->db->where('user_name', $user_name);
        $query = $this->db->get('users');
        $query_res = $query->result();

        $contact_id = $query_res[0]->contacts_id;
        $user_id = $query_res[0]->id;

        $this->db->where('id', $contact_id);
        $this->db->update('contacts', $contact_info);
//        if ($warranty_follower) {
//            $this->db->update('users', array
//                (
//                'warranty_follower' => false
//                    )
//            );
//        }
        $user_pass = array
            (
            'warranty_follower' => $warranty_follower,
        );
        if ($password != '') {
            $user_pass['password'] = $password;
        }
        $this->db->where('user_name', $user_name);
        $this->db->update('users', $user_pass);

        $this->db->where('users_id', $user_id);
        $this->db->delete('users_has_groups');
        foreach ($user_groups as $grb) {
            $users_has_groups = array
                (
                'users_id' => $user_id,
                'groups_id' => $grb
            );
            $this->db->insert('users_has_groups', $users_has_groups);
        }
    }

    public function get_list_of_users_has_permissions($permission_name) {
        $this->db->select('users.user_name, users.id');
        $this->db->from('users');
        $this->db->where('users.Activated', 1);
        $this->db->where('users.Absent', 0);
        $this->db->join('users_has_groups', 'users.id = users_has_groups.users_id');
        $this->db->join('groups', 'groups.id = users_has_groups.groups_id');
        $this->db->join('groups_has_permissions', 'groups.id = groups_has_permissions.groups_id');
        $this->db->join('permissions', 'permissions.id = groups_has_permissions.permissions_id');
        $this->db->where('permissions.name', $permission_name);
        $query = $this->db->get();
        return($query->result());
    }

    public function see_if_activated($name) {
        $this->db->where('user_name', $name);
        $query = $this->db->get('users');
        $res = $query->result_array();
        return $res[0]['Activated'];
    }

    public function deactivate_user($id) {

        $this->db->where('id', $id);
        $this->db->update('users', array('Activated' => 0));
    }

    public function Absence($tech_id, $val) {
        $this->db->where('id', $tech_id);
        $this->db->update('users', array('Absent' => $val));
    }

    public function get_contact_email($id) {
        //echo "amal22222";
        $this->db->select('email, phone');
        $this->db->from('contacts');
        $this->db->where('id', $id);
        $res = $this->db->get();
        $res = $res->result();
        return $res[0];
    }

    public function get_receipt_employees() {
        return $this->db->select('*')
                        ->from('receipt_employee')
                        ->get()->result();
    }

}
