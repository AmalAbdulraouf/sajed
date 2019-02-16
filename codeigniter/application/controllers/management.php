<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class management extends CI_Controller {
    #index

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == 'Arabic') {
            $this->lang->load('website', 'arabic');
            $this->config->set_item('language', 'arabic');
        } else {
            $this->lang->load('website', 'english');
        }
        $this->load->model('model_order');
    }

    public function index() {
        $this->load_main_management_page();
    }
    
    public function places_management($operation = null) {
        if ($this->check_permission('Manage Lists')) {
            $this->load->library('Grocery_CRUD');
            try {
                $crud = new grocery_CRUD();
                $crud->set_theme('datatables')
                        ->set_language('arabic')
                        //->where('deleted', 0)
                        ->set_table('places')
                        //The record name
                        ->set_subject($this->lang->line('place'))
                        ->columns('name')
//                    ->display_as('name', langCs('first_name'))
                        ->add_fields('name')
                        ->edit_fields('name')
                        ->required_fields('name')
                        ->unset_export()
                        ->unset_read()
                        ->unset_print();
                $output = $crud->render();
                $array = array
                    (
                    'name' => 'management/places_management',
                    'data' => array(
                        'output' => $output->output,
                        'js_files' => $output->js_files,
                        'css_files' => $output->css_files
                    )
                );
                $this->load->view('view_template', $array);
            } catch (Exception $e) {
                show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function colors_management($operation = null) {
        if ($this->check_permission('Manage Lists')) {
            $this->load->library('Grocery_CRUD');
            try {
                $crud = new grocery_CRUD();
                $crud->set_theme('datatables')
                        ->set_language('arabic')
                        ->where('deleted', 0)
                        ->set_table('colors')
                        //The record name
                        ->set_subject($this->lang->line('color'))
                        ->columns('color_name')
                        ->display_as('color_name', lang('first_name'))
                        ->add_fields('color_name')
                        ->edit_fields('color_name')
                        ->required_fields('color_name')
                        ->callback_delete(array($this, 'delete_color_callback'))
                        ->unset_export()
                        ->unset_read()
                        ->unset_print();
                $output = $crud->render();
                $array = array
                    (
                    'name' => 'management/colors_management',
                    'data' => array(
                        'output' => $output->output,
                        'js_files' => $output->js_files,
                        'css_files' => $output->css_files
                    )
                );
                $this->load->view('view_template', $array);
            } catch (Exception $e) {
                show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function delete_color_callback($primary_key) {
        $this->load->model('model_colors');
        return $this->model_colors->delete($primary_key);
    }

    public function reasons_management($operation = null) {
        if ($this->check_permission('Manage Lists')) {
            $this->load->library('Grocery_CRUD');
            try {
                $crud = new grocery_CRUD();
                $crud->set_theme('datatables')
                        ->set_language('arabic')
                        ->set_table('reasons')
                        //The record name
                        ->set_subject($this->lang->line('excuse'))
                        ->columns('text')
                        ->add_fields('text')
                        ->edit_fields('text')
                        ->required_fields('text')
                        ->unset_export()
                        ->unset_read()
                        ->unset_print();
                $output = $crud->render();
                $array = array
                    (
                    'name' => 'management/reasons_management',
                    'data' => array(
                        'output' => $output->output,
                        'js_files' => $output->js_files,
                        'css_files' => $output->css_files
                    )
                );
                $this->load->view('view_template', $array);
            } catch (Exception $e) {
                show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function receipt_employee_management($operation = null) {
        if ($this->check_permission('Manage Lists')) {
            $this->load->library('Grocery_CRUD');
            try {
                $crud = new grocery_CRUD();
                $crud->set_theme('datatables')
                        ->set_language('arabic')
                        //->where('deleted', 0)
                        ->set_table('receipt_employee')
                        //The record name
                        ->set_subject($this->lang->line('receipt_employee'))
                        ->columns('name', 'phone', 'email')
                        ->display_as('name', lang('first_name'))
                        ->display_as('phone', lang('phone'))
                        ->display_as('email', lang('email'))
                        ->add_fields('name', 'phone', 'email')
                        ->edit_fields('name', 'phone', 'email')
                        ->required_fields('name', 'phone', 'email')
                        ->unset_export()
                        ->unset_read()
                        ->unset_print();
                $output = $crud->render();
                $array = array
                    (
                    'name' => 'management/receipt_employee_management',
                    'data' => array(
                        'output' => $output->output,
                        'js_files' => $output->js_files,
                        'css_files' => $output->css_files
                    )
                );
                $this->load->view('view_template', $array);
            } catch (Exception $e) {
                show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function load_main_management_page() {
        if ($this->check_permission('Manage Lists')) {
            $array = array
                (
                'name' => 'management/view_main_management_page',
                'data' => null
            );
            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function load_lists_management_page() {
        if ($this->check_permission('Manage Lists')) {
            $array = array
                (
                'name' => 'management/view_lists_management_page',
                'data' => null
            );
            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    //////////////////////////////////////// brands ////////////////////////////////////////

    public function load_brands_list_management_page() {
        if ($this->check_permission('Manage Lists')) {
            $this->load->model('model_brands_and_modles');
            $brands = $this->model_brands_and_modles->get_list_of_brands();
            $view_array = array(
                'brands' => $brands
            );

            $array = array(
                'name' => 'management/view_brands_list_management_page',
                'data' => $view_array
            );
            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function delete_brand_by_id() {
        if ($this->check_permission('Manage Lists')) {
            $brand_id = $_REQUEST["brand_id"];
            $this->load->model('model_brands_and_modles');
            $this->model_brands_and_modles->delete_brand_by_id($brand_id);
            echo 'succeed';
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function update_brand_name_by_id() {
        if ($this->check_permission('Manage Lists')) {
            $brand_id = $_REQUEST["brand_id"];
            $brand_new_name = $_REQUEST["new_name"];
            $this->load->model('model_brands_and_modles');

            $result = $this->model_brands_and_modles->update_brand_name_by_id($brand_id, $brand_new_name);
            echo $result;
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function update_brand_insert_new() {
        if ($this->check_permission('Manage Lists')) {
            $brand_new_name = $_REQUEST["new_name"];
            $this->load->model('model_brands_and_modles');
            $inserted_id = $this->model_brands_and_modles->update_brand_insert_new($brand_new_name);
            echo $inserted_id;
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    //////////////////////////////////////// Models ////////////////////////////////////////

    public function load_models_list_management_page() {
        if ($this->check_permission('Manage Lists')) {
            $this->load->model('model_brands_and_modles');
            $brands = $this->model_brands_and_modles->get_list_of_brands();
            $models = $this->model_brands_and_modles->get_list_of_models_by_brand_id($brands[0]->id);
            $view_array = array(
                'brands' => $brands,
                'models' => $models
            );
            $array = array
                (
                'name' => 'management/view_models_list_management_page',
                'data' => $view_array
            );
            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function get_list_of_models_by_brand_id() {
        if ($this->check_permission('Manage Lists')) {
            $brand_id = $_REQUEST["brand_id"];
            $for_edit = $_REQUEST["for_edit"];

            $this->load->model('model_brands_and_modles');
            $models = $this->model_brands_and_modles->get_list_of_models_by_brand_id($brand_id);
            $view_array = array(
                'models' => $models,
                'for_edit' => $for_edit
            );
            $this->load->view('management/view_list_of_models_by_brand_id', $view_array);
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function get_list_of_models_by_brand_id_model_name() {
        if ($this->check_permission('Manage Lists')) {
            $model = strtolower($_GET['term']);
            $brand_id = $_REQUEST["brand_id"];
            $this->load->model('model_brands_and_modles');
            $models = $this->model_brands_and_modles->get_list_of_models_by_brand_id_model_name($brand_id, $model);
            foreach ($models as $row) {
                $current_model = $row->model;
                $row_set[] = htmlentities(stripslashes($current_model)); //build an array
            };
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function get_list_of_colors_like_name() {
        $color = strtolower($_GET['term']);
        $this->load->model('model_colors');
        $colors = $this->model_colors->get_colors_by_name_like($color);
        foreach ($colors as $row) {
            $color = $row->color_name;
            $row_set[] = htmlentities(stripslashes($color)); //build an array
        };
        echo json_encode($row_set); //format the array into json data	
    }

    public function delete_model_by_id() {
        if ($this->check_permission('Manage Lists')) {
            $model_id = $_REQUEST["model_id"];
            $this->load->model('model_brands_and_modles');
            $this->model_brands_and_modles->delete_model_by_id($model_id);
            echo 'succeed';
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function update_model_name_by_id() {
        if ($this->check_permission('Manage Lists')) {
            $model_id = $_REQUEST["model_id"];
            $model_new_name = $_REQUEST["new_name"];
            $this->load->model('model_brands_and_modles');
            if ($this->model_brands_and_modles->update_model_name_by_id($model_id, $model_new_name)) {
                echo 'succeed';
            } else {
                echo 'error happened';
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function update_models_insert_new() {
        if ($this->check_permission('Manage Lists')) {
            $model_new_name = $_REQUEST["new_name"];
            $brand_id = $_REQUEST["brand_id"];

            $this->load->model('model_brands_and_modles');
            $inserted_id = $this->model_brands_and_modles->update_models_insert_new($model_new_name, $brand_id);
            if ($inserted_id == false) {
                echo 'error happened';
            } else {
                echo $inserted_id;
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    //////////////////////////////////////// machines_types ////////////////////////////////////////

    public function load_machines_types_list_management_page() {
        if ($this->check_permission('Manage Lists')) {
            $this->load->model('model_machines_types');
            $machines_types = $this->model_machines_types->get_list_of_machines_types();
            $view_array = array(
                'machines_types' => $machines_types
            );

            $array = array
                (
                'name' => 'management/view_machines_types_list_management_page',
                'data' => $view_array
            );
            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function delete_machine_type_by_id() {
        if ($this->check_permission('Manage Lists')) {
            $machine_type_id = $_REQUEST["machine_type_id"];
            $this->load->model('model_machines_types');
            $this->model_machines_types->delete_machine_type_by_id($machine_type_id);
            echo 'succeed';
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function update_machine_type_name_by_id() {
        if ($this->check_permission('Manage Lists')) {
            $machine_type_id = $_REQUEST["machine_type_id"];
            $machine_type_new_name = $_REQUEST["new_name"];
            $this->load->model('model_machines_types');
            if ($this->model_machines_types->update_machine_type_name_by_id($machine_type_id, $machine_type_new_name)) {
                echo 'succeed';
            } else {
                echo 'error happened';
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function update_machines_types_insert_new() {
        if ($this->check_permission('Manage Lists')) {
            $machine_type_new_name = $_REQUEST["new_name"];
            $this->load->model('model_machines_types');
            $inserted_id = $this->model_machines_types->update_machines_types_insert_new($machine_type_new_name);
            if ($inserted_id == false) {
                echo 'error happened';
            } else {
                echo $inserted_id;
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    function export_customers_to_excel() {
        print'p1<br>';
        $this->load->library('phpexcel');
        print'p2<br>';

        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        print'p3<br>';

        /** Include PHPExcel */
        // require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
        // Create new PHPExcel object


        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Khaleej sys")
                ->setLastModifiedBy("Khaleej sys")
                ->setTitle("Khaleej sys")
                ->setSubject("Khaleej sys")
                ->setDescription("Khaleej sys customers")
                ->setKeywords("Khaleej sys customers")
                ->setCategory("Khaleej sys customers");

        print'p4<br>';


        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Customer Name')
                ->setCellValue('B1', 'Customer Phone')
                ->setCellValue('C1', 'Customer E-Mail');

        $this->load->model('model_contacts');
        $customers = $this->model_contacts->get_list_of_customers();
        $i = 2;
        foreach ($customers as $customer) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $customer->first_name . ' ' . $customer->last_name)
                    ->setCellValue('B' . $i, "966" . $customer->phone)
                    ->setCellValue('C' . $i, $customer->email);
            $i++;
        }

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Customers');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="customers.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        exit;
    }

    // helper functions
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
