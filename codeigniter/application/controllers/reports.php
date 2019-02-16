<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class reports extends CI_Controller {

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

    #index

    public function index() {
        $this->load_main_reports_page();
    }

    public function load_main_reports_page() {
        if ($this->check_permission('View Reports')) {
            $array = array
                (
                'name' => 'reports/view_main_reports_page',
                'data' => null
            );
           // $this->load->view('new/pages/template/template', $array);

            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function load_cash_summery_report() {
        if ($this->check_permission('View Reports')) {
            $array = array
                (
                'name' => 'reports/view_cash_summery_report',
                'data' => null
            );
            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function load_technicians_accomplishment() {
        if ($this->check_permission('View Reports')) {
            $array = array
                (
                'name' => 'reports/view_technicians_accomplishment_report',
                'data' => null
            );
            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function load_data_done_work_by_machine_type() {
        if ($this->check_permission('View Reports')) {
            $array = array
                (
                'name' => 'reports/view_data_done_work_by_machine_type_report',
                'data' => null
            );
            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function get_data_cash_summery_report() {
        if ($this->check_permission('View Reports')) {
            $date_from = $_REQUEST["date_from"];
            $date_to = $_REQUEST["date_to"];

            $this->load->model('model_reports');
            $report_results = $this->model_reports->get_data_cash_summery_report($date_from, $date_to);
            $this->load->view('reports/view_cash_summery_report_results', $report_results);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function get_data_technicians_accomplishment() {
        if ($this->check_permission('View Reports')) {
            $date_from = $_REQUEST["date_from"];
            $date_to = $_REQUEST["date_to"];

            $this->load->model('model_reports');
            $report_results = $this->model_reports->get_data_technicians_accomplishment($date_from, $date_to);
            $this->load->view('reports/view_technicians_accomplishment_report_results', $report_results);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function get_data_done_work_by_machine_type() {
        if ($this->check_permission('View Reports')) {
            $date_from = $_REQUEST["date_from"];
            $date_to = $_REQUEST["date_to"];

            $this->load->model('model_reports');
            $report_data = $this->model_reports->get_data_done_work_by_machine_type($date_from, $date_to);
            $report_results = array
                (
                'report_results' => $report_data
            );
            $this->load->view('reports/view_data_done_work_by_machine_type_report_results', $report_results);
        } else {
            redirect(base_url() . 'index.php');
        }
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

    public function load_non_delivered_orders_page() {
        if ($this->check_permission('View Reports')) {
            $array = array
                (
                'name' => 'reports/view_not_delivered_orders_report',
                'data' => null
            );
            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function load_non_delivered_orders() {
        if ($this->check_permission('View Reports')) {
            $this->load->model('model_reports');
            $date_from = $_REQUEST["date_from"];
            $report_results = $this->model_reports->load_non_delivered_orders($date_from);
            $data = array
                (
                'report_results' => $report_results
            );
            $this->load->view('reports/view_not_delivered_orders_report_results', $data);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function technicians_excuses() {
        if ($this->check_permission('View Reports')) {
            $this->load->model('model_users');
            $technicians_array = $this->model_users->get_list_of_users_has_permissions('Perform Repair Action');
            $technicians[0] = lang('all');
            foreach ($technicians_array as $tech) {
                $technicians[$tech->id] = $tech->user_name;
            }
            $array = array
                (
                'name' => 'reports/view_technicians_excuses_report',
                'data' => null,
                'technicians' => $technicians
            );
            $this->load->view('view_template', $array);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function search_excuses_by_order_id() {
        if ($this->session->userdata('is_logged_in')) {
            $order_id = $_REQUEST["order_id"];
            $this->load->model('model_reports');
            $orders = $this->model_reports->search_excuses_by_order_id($order_id);

            $data = array
                (
                'orders' => $orders,
            );

            $this->load->view('reports/view_technicians_excuses_report_result', $data);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function order_all_excuses() {
        if ($this->session->userdata('is_logged_in')) {
            $order_id = $_GET["order_id"];
            $this->load->model('model_reports');
            $orders = $this->model_reports->order_all_excuses($order_id);

            $data = array
                (
                'orders_result' => $orders,
            );

            $this->load->view('reports/view_order_excuses_report_result', $data);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function search_orders_excuses_by_filters() {
        if ($this->session->userdata('is_logged_in')) {
            $tech_id = $_REQUEST["tech_id"];
            $date_from = $_REQUEST["date_from"];
            $date_to = $_REQUEST["date_to"];
            $delivered_or_not = $_REQUEST["delivered_or_not"];


            $this->load->model('model_reports');
            $orders = $this->model_reports->search_orders_excuses_by_filters($tech_id, $date_from, $date_to, $delivered_or_not);

            $data = array
                (
                'orders' => $orders
            );
            $this->load->view('reports/view_technicians_excuses_report_result', $data);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function all_order_excuses() {
        $this->load->model('model_reports');
        $order = $_GET['order_id'];
        $excuses = $this->model_reports->all_order_excuses($order);
        $excuses = array('excuses' => $excuses);
        $this->load->view('reports/view_all_order_excuses_report_result', $excuses);
    }

    public function delivered_orders_view() {
        if ($this->check_permission('View Reports')) {
            $this->load->view('view_template', array('name' => 'reports/delivered_orders_view'));
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function delivered_orders() {
        if ($this->check_permission('View Reports')) {
            $this->load->model('model_reports');
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $aColumns = array('order_id', 'total');
            $whereColumns = array('orders.id', '(orders.repair_cost+orders.spare_parts_cost)');
            $sWhere = "";
            if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
                $sWhere = " (";
                for ($i = 0; $i < count($whereColumns); $i++) {
                    $sWhere .= "" . $whereColumns[$i] . " LIKE '%" . filter_input(INPUT_GET, 'sSearch') . "%' OR ";
                }
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')';
            }

            $sOrder = "";
            if (isset($_GET['iSortCol_0'])) {
                $sOrder = "";
                for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                    if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                        $sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
                                ($_GET['sSortDir_' . $i] === 'desc' ? 'desc' : 'asc') . ", ";
                    }
                }

                $sOrder = substr_replace($sOrder, "", -2);
                if ($sOrder == "ORDER BY") {
                    $sOrder = "";
                }
            }
            $sLimit = "";
            if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
                $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                        intval($_GET['iDisplayLength']);
            }
            $bills = $this->model_reports->get_delivered_report($start_date, $end_date, $sWhere, $sOrder, $sLimit);
            $output = array("aaData" => array()
            );
            foreach ($bills as $aRow) {
                $services = array();
                if ($aRow->software != 0)
                    $services[] = "software";
                if ($aRow->electronic != 0)
                    $services[] = "electronic";
                if ($aRow->external_repair != 0)
                    $services[] = "external";
                if ($aRow->under_warranty != 0)
                    $services[] = "warranty";
                $row = array();
                $row[] = $aRow->order_id;
                $row[] = implode(", ", $services);
                $row[] = $aRow->repair_cost;
                $row[] = $aRow->spare_parts_cost;
                $row[] = $aRow->total;
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function orders_report_view() {
        if ($this->check_permission('View Reports')) {
            $this->load->view('view_template', array('name' => 'reports/orders_report_view'));
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function orders_report() {
        if ($this->check_permission('View Reports')) {
            $this->load->model('model_reports');
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $aColumns = array('order_id', 'total');
            $whereColumns = array('orders.id', '(orders.repair_cost+orders.spare_parts_cost)', 'status.name',
                'models.model', 'brands.name', 'machines_types.name', 'machines.serial_number',
                'contacts.first_name', 'contacts.last_name', 'contacts.phone');
            $sWhere = "";
            if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
                $sWhere = " (";
                for ($i = 0; $i < count($whereColumns); $i++) {
                    $sWhere .= "" . $whereColumns[$i] . " LIKE '%" . filter_input(INPUT_GET, 'sSearch') . "%' OR ";
                }
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')';
            }

            $sOrder = "";
            if (isset($_GET['iSortCol_0'])) {
                $sOrder = "";
                for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                    if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                        $sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
                                ($_GET['sSortDir_' . $i] === 'desc' ? 'desc' : 'asc') . ", ";
                    }
                }

                $sOrder = substr_replace($sOrder, "", -2);
                if ($sOrder == "ORDER BY") {
                    $sOrder = "";
                }
            }
            $sLimit = "";
            if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
                $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                        intval($_GET['iDisplayLength']);
            }
            $bills = $this->model_reports->orders_report($start_date, $end_date, $sWhere, $sOrder, $sLimit);
            $output = array("aaData" => array()
            );
            foreach ($bills as $aRow) {
                $row = array();
                $row[] = $aRow->order_id;
                $row[] = $aRow->customer_name;
                $row[] = $aRow->phone;
                $row[] = $aRow->machine_type;
                $row[] = $aRow->brand;
                $row[] = $aRow->model;
                $row[] = $aRow->serial_number;
                $row[] = $aRow->total;
                $row[] = $aRow->state;
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function services_report_view() {
        if ($this->check_permission('View Reports')) {
            $this->load->view('view_template', array('name' => 'reports/services_report_view'));
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function services_report() {
        if ($this->check_permission('View Reports')) {
            $this->load->model('model_reports');
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $aColumns = array('orders.spare_parts_cost', 'order.repair_cost', 'total');
            $whereColumns = array('(orders.repair_cost+orders.spare_parts_cost)');
            $sWhere = "";
            if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
                $sWhere = " (";
                for ($i = 0; $i < count($whereColumns); $i++) {
                    $sWhere .= "" . $whereColumns[$i] . " LIKE '%" . filter_input(INPUT_GET, 'sSearch') . "%' OR ";
                }
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')';
            }

            $sOrder = "";
            if (isset($_GET['iSortCol_0'])) {
                $sOrder = "";
                for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                    if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                        $sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
                                ($_GET['sSortDir_' . $i] === 'desc' ? 'desc' : 'asc') . ", ";
                    }
                }

                $sOrder = substr_replace($sOrder, "", -2);
                if ($sOrder == "ORDER BY") {
                    $sOrder = "";
                }
            }
            $sLimit = "";
            if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
                $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                        intval($_GET['iDisplayLength']);
            }
            $bills = $this->model_reports->services_report($start_date, $end_date, $sWhere, $sOrder, $sLimit);
            $output = array("aaData" => array()
            );
            foreach ($bills as $aRow) {
                $services = array();
                if ($aRow->software != 0)
                    $services[] = "software";
                if ($aRow->electronic != 0)
                    $services[] = "electronic";
                if ($aRow->external_repair != 0)
                    $services[] = "external";
                if ($aRow->under_warranty != 0)
                    $services[] = "warranty";
                $row = array();
                $row[] = implode(", ", $services);
                $row[] = $aRow->total_orders;
                $row[] = $aRow->repair_cost;
                $row[] = $aRow->spare_parts_cost;
                $row[] = $aRow->total;
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function report_view($report) {
        if ($this->check_permission('View Reports')) {
            $this->load->view('view_template', array('name' => 'reports/' . $report));
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function ready_not_delivered() {
        if ($this->check_permission('View Reports')) {
            $this->load->model('model_reports');
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $aColumns = array('order_id', 'total');
            $whereColumns = array('orders.id', '(orders.repair_cost+orders.spare_parts_cost)');
            $sWhere = "";
            if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
                $sWhere = " (";
                for ($i = 0; $i < count($whereColumns); $i++) {
                    $sWhere .= "" . $whereColumns[$i] . " LIKE '%" . filter_input(INPUT_GET, 'sSearch') . "%' OR ";
                }
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')';
            }

            $sOrder = "";
            if (isset($_GET['iSortCol_0'])) {
                $sOrder = "";
                for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                    if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                        $sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
                                ($_GET['sSortDir_' . $i] === 'desc' ? 'desc' : 'asc') . ", ";
                    }
                }

                $sOrder = substr_replace($sOrder, "", -2);
                if ($sOrder == "ORDER BY") {
                    $sOrder = "";
                }
            }
            $sLimit = "";
            if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
                $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                        intval($_GET['iDisplayLength']);
            }
            $bills = $this->model_reports->ready_not_delivered($start_date, $end_date, $sWhere, $sOrder, $sLimit);
            $output = array("aaData" => array()
            );
            foreach ($bills as $aRow) {
                $services = array();
                if ($aRow->software != 0)
                    $services[] = "software";
                if ($aRow->electronic != 0)
                    $services[] = "electronic";
                if ($aRow->external_repair != 0)
                    $services[] = "external";
                if ($aRow->under_warranty != 0)
                    $services[] = "warranty";
                $row = array();
                $row[] = $aRow->order_id;
                $row[] = implode(", ", $services);
                $row[] = $aRow->contact_name;
                $row[] = $aRow->phone;
                $row[] = $aRow->total;
                $row[] = $aRow->date . " " . $this->lang->line('day');
                $row[] = $aRow->place;
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function cancelled_not_delivered() {
        if ($this->check_permission('View Reports')) {
            $this->load->model('model_reports');
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $aColumns = array('order_id', 'total');
            $whereColumns = array('orders.id', '(orders.repair_cost+orders.spare_parts_cost)');
            $sWhere = "";
            if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
                $sWhere = " (";
                for ($i = 0; $i < count($whereColumns); $i++) {
                    $sWhere .= "" . $whereColumns[$i] . " LIKE '%" . filter_input(INPUT_GET, 'sSearch') . "%' OR ";
                }
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')';
            }

            $sOrder = "";
            if (isset($_GET['iSortCol_0'])) {
                $sOrder = "";
                for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                    if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                        $sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
                                ($_GET['sSortDir_' . $i] === 'desc' ? 'desc' : 'asc') . ", ";
                    }
                }

                $sOrder = substr_replace($sOrder, "", -2);
                if ($sOrder == "ORDER BY") {
                    $sOrder = "";
                }
            }
            $sLimit = "";
            if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
                $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                        intval($_GET['iDisplayLength']);
            }
            $bills = $this->model_reports->cancelled_not_delivered($start_date, $end_date, $sWhere, $sOrder, $sLimit);
            $output = array("aaData" => array()
            );
            foreach ($bills as $aRow) {
                $services = array();
                if ($aRow->software != 0)
                    $services[] = "software";
                if ($aRow->electronic != 0)
                    $services[] = "electronic";
                if ($aRow->external_repair != 0)
                    $services[] = "external";
                if ($aRow->under_warranty != 0)
                    $services[] = "warranty";

                $row = array();
                $row[] = $aRow->order_id;
                $row[] = implode(", ", $services);
                $row[] = $aRow->contact_name;
                $row[] = $aRow->phone;
                $row[] = $aRow->total;
                $row[] = $aRow->date . " " . $this->lang->line('day');
                $row[] = $aRow->place;
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function warranty_not_delivered() {
        if ($this->check_permission('View Reports')) {
            $this->load->model('model_reports');
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $aColumns = array('order_id', 'total');
            $whereColumns = array('orders.id', '(orders.repair_cost+orders.spare_parts_cost)');
            $sWhere = "";
            if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
                $sWhere = " (";
                for ($i = 0; $i < count($whereColumns); $i++) {
                    $sWhere .= "" . $whereColumns[$i] . " LIKE '%" . filter_input(INPUT_GET, 'sSearch') . "%' OR ";
                }
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')';
            }

            $sOrder = "";
            if (isset($_GET['iSortCol_0'])) {
                $sOrder = "";
                for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                    if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                        $sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
                                ($_GET['sSortDir_' . $i] === 'desc' ? 'desc' : 'asc') . ", ";
                    }
                }

                $sOrder = substr_replace($sOrder, "", -2);
                if ($sOrder == "ORDER BY") {
                    $sOrder = "";
                }
            }
            $sLimit = "";
            if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
                $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                        intval($_GET['iDisplayLength']);
            }

            $bills = $this->model_reports->warranty_not_delivered($start_date, $end_date, $sWhere, $sOrder, $sLimit);
            $output = array("aaData" => array()
            );
            foreach ($bills as $aRow) {
                $services = array();
                if ($aRow->software != 0)
                    $services[] = "software";
                if ($aRow->electronic != 0)
                    $services[] = "electronic";
                if ($aRow->external_repair != 0)
                    $services[] = "external";
                if ($aRow->under_warranty != 0)
                    $services[] = "warranty";

                $row = array();
                $row[] = $aRow->order_id;
                $row[] = implode(", ", $services);
                $row[] = $aRow->contact_name;
                $row[] = $aRow->phone;
                $row[] = $aRow->total;
                $row[] = $aRow->date . " " . $this->lang->line('day');
                $row[] = $aRow->place;
                $output['aaData'][] = $row;
            }

            echo json_encode($output);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

    public function warranty_sent_machines() {
        if ($this->check_permission('View Reports')) {
            $this->load->model('model_reports');
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $aColumns = array('order_id', 'total');
            $whereColumns = array('orders.id', '(orders.repair_cost+orders.spare_parts_cost)');
            $sWhere = "";
            if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
                $sWhere = " (";
                for ($i = 0; $i < count($whereColumns); $i++) {
                    $sWhere .= "" . $whereColumns[$i] . " LIKE '%" . filter_input(INPUT_GET, 'sSearch') . "%' OR ";
                }
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')';
            }

            $sOrder = "";
            if (isset($_GET['iSortCol_0'])) {
                $sOrder = "";
                for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                    if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                        $sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
                                ($_GET['sSortDir_' . $i] === 'desc' ? 'desc' : 'asc') . ", ";
                    }
                }

                $sOrder = substr_replace($sOrder, "", -2);
                if ($sOrder == "ORDER BY") {
                    $sOrder = "";
                }
            }
            $sLimit = "";
            if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
                $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                        intval($_GET['iDisplayLength']);
            }
            $bills = $this->model_reports->warranty_sent_machines($start_date, $end_date, $sWhere, $sOrder, $sLimit);
            $output = array("aaData" => array()
            );
            foreach ($bills as $aRow) {
                $services = array();
                if ($aRow->software != 0)
                    $services[] = "software";
                if ($aRow->electronic != 0)
                    $services[] = "electronic";
                if ($aRow->external_repair != 0)
                    $services[] = "external";
                if ($aRow->under_warranty != 0)
                    $services[] = "warranty";
                $row = array();
                $row[] = $aRow->order_id;
                $row[] = implode(", ", $services);
                $row[] = $aRow->contact_name;
                $row[] = $aRow->phone;
                $row[] = $aRow->total;
                $row[] = $aRow->date . " " . $this->lang->line('day');
                $row[] = $aRow->place;
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
        } else {
            redirect(base_url() . 'index.php');
        }
    }

}
