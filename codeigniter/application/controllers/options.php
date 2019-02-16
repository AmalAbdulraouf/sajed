<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class options extends CI_Controller {

    function __construct() {

        parent::__construct();
$this->load->model('model_order');
        if ($this->session->userdata('language') == 'Arabic') {
            $this->lang->load('website', 'arabic');
            $this->config->set_item('language', 'arabic');
        } else {
            $this->lang->load('website', 'english');
        }
        if (!$this->session->userdata('is_logged_in')) {
            redirect(base_url() . 'index.php');
        }
    }

    #index

    public function index() {
        
    }

    public function SMS_options() {
        $array = array
            (
            'name' => 'view_view_SMS_options',
            'data' => array()
        );
        $this->load->view('view_template', $array);
    }

    public function get_sms($option) {
        $this->load->model('model_options');
        $options = $this->model_options->get_all_options();
        $additions = $this->model_options->get_additions($option);
        $data = array(
            'option' => $option,
            'options' => $options,
            'additions' => $additions
        );

        $array = array
            (
            'name' => 'view_view_sms',
            'data' => $data
        );

        $this->load->view('view_template', $array);
    }

    public function update_option($option) {
        $this->load->model('model_options');

        $en_opt = array
            (
            'option_text' => $this->input->post('en_text'),
            'option_value' => $this->get_chkBox_status($option),
        );

        $en_opt = array
            (
            'option_text' => $this->input->post('en_text'),
            'option_value' => $this->get_chkBox_status($option),
        );

        $ar_opt = array
            (
            'option_text' => $this->input->post('ar_text'),
            'option_value' => $this->get_chkBox_status($option),
        );

        if ($option == 'send_sms_on_receive') {
            $add = array
                (
                array(1, $this->get_chkBox_status('examine_date')),
                array(2, $this->get_chkBox_status('examining_cost')),
                array(3, $this->get_chkBox_status('delivery_date')),
                array(4, $this->get_chkBox_status('cost_estimation')),
                array(5, $this->get_chkBox_status('order_number')),
                array(14, $this->get_chkBox_status('recieve_date'))
            );
        } else if ($option == 'send_sms_on_done') {
            $add = array
                (
                array(8, $this->get_chkBox_status('total_cost')),
                array(7, $this->get_chkBox_status('spare_parts_cost')),
                array(6, $this->get_chkBox_status('repair_cost')),
                array(5, $this->get_chkBox_status('order_number')),
            );
        } else if ($option == 'send_sms_on_deliver') {
            $add = array
                (
                array(8, $this->get_chkBox_status('total_cost')),
                array(7, $this->get_chkBox_status('spare_parts_cost')),
                array(6, $this->get_chkBox_status('repair_cost')),
                array(5, $this->get_chkBox_status('order_number')),
                array(18, $this->get_chkBox_status('deliver_date'))
            );
        } else if ($option == 'send_sms_on_cancelled') {
            $add = array
                (
                array(5, $this->get_chkBox_status('order_number')),
                array(2, $this->get_chkBox_status('examining_cost'))
            );
        }

        $this->model_options->update_option($option, $ar_opt, $en_opt, $add);

        redirect('options/SMS_options');
    }

    private function get_chkBox_status($chkBox_name) {
        if ($this->input->post($chkBox_name)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_options() {
        $options = array(
            array(
                'option_name' => 'send_sms_on_receive',
                'option_value' => $this->input->post('send_sms_on_receive') ? '1' : '0'
            ),
            array(
                'option_name' => 'send_sms_on_done',
                'option_value' => $this->input->post('send_sms_on_done') ? '1' : '0'
            ),
            array(
                'option_name' => 'send_sms_on_deliver',
                'option_value' => $this->input->post('send_sms_on_deliver') ? '1' : '0')
        );
        $this->load->model('model_options');
        $this->model_options->update($options);
        redirect(base_url() . 'index.php/options/SMS_options');
    }

    ///////////////Emails///////////////

    public function email_options() {

        $array = array
            (
            'name' => 'view_view_email_options',
            'data' => null
        );
        $this->load->view('view_template', $array);
    }

    public function get_email($option) {
        $this->load->model('model_options');
        $options = $this->model_options->get_all_email_options();
        $additions = $this->model_options->get_email_additions($option);
        $data = array(
            'option' => $option,
            'options' => $options,
            'additions' => $additions
        );
        $array = array
            (
            'name' => 'view_view_email',
            'data' => $data
        );

        $this->load->view('view_template', $array);
    }

    public function update_email_option($option) {
        $this->load->model('model_options');

        $en_opt = array
            (
            'option_text' => $this->input->post('en_text'),
            'option_value' => $this->get_chkBox_status($option),
        );


        $ar_opt = array
            (
            'option_text' => $this->input->post('ar_text'),
            'option_value' => $this->get_chkBox_status($option),
        );

        if ($option == 'send_email_on_receive') {
            $add = array
                (
                array(1, $this->get_chkBox_status('examine_date')),
                array(2, $this->get_chkBox_status('examining_cost')),
                array(3, $this->get_chkBox_status('delivery_date')),
                array(4, $this->get_chkBox_status('cost_estimation')),
                array(5, $this->get_chkBox_status('order_number')),
                array(14, $this->get_chkBox_status('recieve_date'))
            );
        } else if ($option == 'send_email_on_done') {
            $add = array
                (
                array(8, $this->get_chkBox_status('total_cost')),
                array(7, $this->get_chkBox_status('spare_parts_cost')),
                array(6, $this->get_chkBox_status('repair_cost')),
                array(5, $this->get_chkBox_status('order_number')),
            );
        } else if ($option == 'send_email_on_deliver') {
            $add = array
                (
                array(8, $this->get_chkBox_status('total_cost')),
                array(7, $this->get_chkBox_status('spare_parts_cost')),
                array(6, $this->get_chkBox_status('repair_cost')),
                array(5, $this->get_chkBox_status('order_number')),
                array(18, $this->get_chkBox_status('deliver_date'))
            );
        } else if ($option == 'send_email_on_cancelled') {
            $add = array
                (
                array(5, $this->get_chkBox_status('order_number')),
                array(2, $this->get_chkBox_status('examining_cost'))
            );
        }

        $this->model_options->update_email_option($option, $ar_opt, $en_opt, $add);

        redirect('options/email_options');
    }

}
