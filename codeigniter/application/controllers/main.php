<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {
    #index

    public function index() {
        $this->login();
    }

    #Login

    public function login() {


        $current_language = $this->session->userdata('language');
        if (empty($current_language)) {
            $this->session->set_userdata("language", 'Arabic');
        }

        if ($this->session->userdata('is_logged_in')) {
            redirect('main_page');
        } else {
            $this->load->view('view_login');
        }
    }

    public function login_validation() {
        $this->load->model('model_reason');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_name', 'User Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|md5|trim|callback_validate_credentials');
        if ($this->form_validation->run()) {
            if ($this->session->userdata('give_attention') == 0)
                redirect('../index.php/main_page');
        }
        else {
            $this->load->view('view_login');
        }
    }

    public function validate_credentials() {
        $this->load->model('model_users');

        if ($this->model_users->can_log_in()) {
            $data = array(
                'user_name' => $this->input->post('user_name'),
                'is_logged_in' => 1,
                'language' => $this->session->userdata('language')
            );
            $this->session->set_userdata($data);
            return true;
        } else {
            $this->form_validation->set_message('validate_credentials', "Invalid User Name or Password");
            return false;
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('main/login');
    }

    public function get_data() {
        $this->load->model('model_order');
        $this->load->model('model_colors');
        $this->load->model('model_brands_and_modles');
        $brands_array = $this->model_brands_and_modles->get_list_of_brands_having_models();
        $brands[0] = $this->lang->line('not_selected');
        foreach ($brands_array as $br) {
            $brands[$br->id] = $br->name;
        }
        $models = $this->model_brands_and_modles->get_list_of_models_by_brand_id($brands[0]->id);
        $machines_types_array = $this->model_order->get_list_of_machines_types();
        $machines_types[0] = $this->lang->line('not_selected');
        foreach ($machines_types_array as $machine) {
            $machines_types[$machine->id] = $machine->name;
        }

        $colors_array = $this->model_colors->get_list_of_colors();
//            var_dump($colors_array);            die();
        $colors[0] = $this->lang->line('not_selected');
        foreach ($colors_array as $color) {
            $colors[$color->id] = $color->color_name;
        }
        $data = array
            (
            'models' => $models,
            'brands' => $brands,
            'colors' => $colors,
            'machines_types' => $machines_types
        );
        echo json_encode(array('data' => $data));
    }

}
