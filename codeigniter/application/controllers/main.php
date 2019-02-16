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

}
