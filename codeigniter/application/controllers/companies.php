<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Companies extends CI_Controller {
    #index

    function __construct() {
        parent::__construct();

        $this->load->library('Grocery_CRUD');
        $this->load->model('model_companies');
        $this->load->model('model_order');
    }

    public function search() {

        $key = $this->input->get('key');

        $companies = $this->model_companies->search($key);

        echo json_encode(array('data' => $companies));
    }

    public function get_not_delivered() {

        $key = $this->input->get('company_id');

        $orders = $this->model_companies->get_not_delivered($key);

        echo json_encode(array('data' => $orders));
    }

    public function get_prev_machines() {

        $key = $this->input->get('company_id');

        $orders = $this->model_companies->get_prev_machines($key);

        echo json_encode(array('data' => $orders));
    }

    public function companies_management($operation = null) {

        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('datatables')
                    ->set_language('arabic')
                    ->set_table('company')
                    ->set_subject($this->lang->line('customer'))
                    ->where('deleted', 0)
                    ->columns('company_id', 'name', 'email', 'address', 'delegates')
                    ->display_as('name', $this->lang->line('first_name'))
                    ->display_as('email', 'البريد الالكتروني')
                    ->display_as('address', 'العنوان')
                    ->display_as('delegates', 'المندوبين')
                    ->set_relation_n_n('delegates', 'company_delegate', 'contacts', 'company_id', 'contact_id', 'first_name', null)
                    ->unset_edit_fields('deleted')
                    ->unset_add_fields('deleted')
//                    ->unset_read_fields('deleted')
//                    //Set rules to fields to check in add and edit operations
//                    ->set_rules('phone2', 'هاتف', 'exact_length[10]')
//                    ->set_rules('phone', 'جوال 1', 'required|exact_length[10]')
//                    ->set_rules('name', ' الاسم', 'required')
//                    //This callback escapes the auto delete of the CRUD , and runs only the callback
//                    ->callback_delete(array($this, 'delete_customers'))
//                    ->callback_edit_field('phone2', array($this, '_callback_phone'))
//                    ->callback_column('has_card', array($this, '_callback_card_render'))
//                    ->callback_column('card_discount', array($this, '_callback_discount_render'))
//                    //Unset the export button and don't let the customer to use this functionality.
                    ->unset_export()
                    ->unset_read()
                    //Unset the print button and don't let the customer to use this functionality
                    ->unset_print()
                    ->unset_add();
            $output = $crud->render();
            $array = array
                (
                'name' => 'management/companies_management',
                'data' => array(
                    'output' => $output->output,
                    'js_files' => $output->js_files,
                    'css_files' => $output->css_files
                )
            );
            $this->load->view('view_template', $array);
//            $this->load->view('customers_management.php', array(
//                'output' => $output->output,
//                'js_files' => $output->js_files,
//                'css_files' => $output->css_files
//                    )
//            );
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

}
