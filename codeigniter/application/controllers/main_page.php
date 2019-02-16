<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main_Page extends CI_Controller {
    #index

    public function index() {
        $this->load_main_page();
    }

    public function transfer_to_main() {
        $this->session->set_userdata(array('give_attention' => 0));
        redirect();
    }

    #Main Page

    public function load_main_page() {
        if ($this->session->userdata('is_logged_in')) {
            $this->load->model('model_users');
            $user_permissions = $this->model_users->get_user_permissions($this->session->userdata('user_name'));
            $data = array(
                "user_permissions" => $user_permissions
            );
            $this->session->set_userdata($data);
            $warranty_orders = array();
            $receipt_employees = array();

            $this->load->model('model_order');
            $warranty_orders = $this->model_order->get_employee_warranty_orders($this->session->userdata('user_name'));
            $receipt_employees = $this->model_users->get_receipt_employees();

//            var_dump($warranty_orders); die();
            $this->load->view('view_main_page', array( 'warranty_orders' => $warranty_orders, 'receipt_employees' => $receipt_employees));
           //$this->load->view('new/pages/template/template', array( 'name' => 'main',  'warranty_orders' => $warranty_orders,'receipt_employees' => $receipt_employees));
        } else {
            redirect('main_page/restricted');
        }
    }

    public function restricted() {
        $this->load->view('view_restricted');
    }

    function check_permission($permission) {
        if ($this->session->userdata('is_logged_in')) {
            $user_permissions_array = $this->session->userdata('user_permissions');
            foreach ($user_permissions_array as $per) {
                if ($per->name == $permission)
                    return true;
            }
            return false;
        }
    }

}
