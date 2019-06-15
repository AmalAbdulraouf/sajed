<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_Manager extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('language') == 'Arabic') {
            $this->lang->load('website', 'arabic');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-ar.css">';
        } else {
            $this->lang->load('website', 'english');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-en.css">';
        }
        $this->load->model('model_order');
    }

    #index

    public function users_management($operation = null) {
        if ($this->check_permission('Manage Lists')) {
            $this->load->library('grocery_CRUD');
            try {
                $crud = new grocery_CRUD();

                $crud->set_theme('datatables')
                        ->set_table('users')
                        ->set_language(($this->session->userdata('language') == 'Arabic') ? 'arabic' : 'english')
                        ->where('Activated', 1)
                        ->set_subject($this->lang->line('user'))
                        ->columns('id', 'user_name', 'contact_id', 'Absent', 'warranty_follower', 'groups')
//                        ->order_by('user_id')
                        ->set_relation('contact_id', 'contacts', '{first_name}  {last_name}')
                        ->set_relation_n_n('groups', 'users_has_groups', 'groups', 'users_id', 'groups_id', 'name')

//                        ->set_relation('company_id', 'company', 'en_name', null, null, array('company.deleted' => 0))
                        ->display_as('id', $this->lang->line('serial_no'))
                        ->display_as('user_name', $this->lang->line('user_name'))
                        ->display_as('contact_id', $this->lang->line('first_name'))
                        ->display_as('Absent', $this->lang->line('absence'))
                        ->display_as('groups', $this->lang->line('groups'))
                        ->display_as('warranty_follower', $this->lang->line('warranty_follower'))
                        ->edit_fields('password', 'Absent', 'warranty_follower')
                        ->add_fields('name', 'username', 'phone', 'email', 'password', 'role_id', 'company_id')
                        ->required_fields('name', 'username', 'role_id')
                        ->unique_fields('user_name')
                        ->unset_jquery()
//                        ->set_rules('name', 'Name', 'required|min_length[3]|max_length[16]')
                        ->callback_before_update(array($this, 'encrypt_password_callback'))
                        ->callback_edit_field('password', array($this, '_callback_password'))
                        ->callback_column('active', array($this, '_callback_active_render'))
//                        ->callback_before_insert(array($this, 'encrypt_password_callback'))
                        ->callback_delete(array($this, 'delete_user'))
                        ->add_action($this->lang->line('delete'), base_url() . 'assets/images/close.png', '', 'delete-icon', array($this, 'delete_user_callback'))
                        ->unset_export()
                        ->unset_read()
                        ->unset_print()
                        ->unset_delete();

//                if ($operation == 'insert_validation' || $operation == 'insert' || $operation == 'add') {
//                    if ($this->current_user->role_id != ROLE::SUPPORT)
//                        throw new Permission_Denied_Exception ();
//                    $crud
//                            ->set_rules('password', 'Password', 'required|min_length[6]|max_length[30]')
//                            ->set_rules('username', 'User Name', 'required|min_length[3]|max_length[16]|is_unique[user.username]');
//                } else {
//                    $crud
//                            ->set_rules('password', 'Password', 'min_length[6]|max_length[30]');
//                }
                $output = $crud->render();

                $array = array
                    (
                    'name' => 'management/users_management',
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

    public function _callback_password($value = '', $primary_key = null) {

        return '<input type="text"  maxlength="50" value="" name="password" style="width:100%" autocomplete="false">';
    }

    function encrypt_password_callback($post_array, $primary_key) {

        if (!empty($post_array['password'])) {
            $post_array['password'] = md5($post_array['password']);
        } else {
            unset($post_array['password']);
        }

        return $post_array;
    }

    public function delete_user_callback($primary_key) {
        return site_url('/users_manager/deactivate_user/' . $primary_key);
    }

    public function index() {
        $this->load_users_page();
    }

    #Main Page

    public function load_users_page($message = "") {
        if ($this->check_permission('Manage Lists')) {
            $this->load->model('model_users');
            $users_list = $this->model_users->get_list_of_users();
            $data = array(
                'users_list' => $users_list,
                'message' => $message
            );
            $array = array
                (
                'name' => 'view_user_manager',
                'data' => $data
            );
            $this->load->view('view_template', $array);
            //$this->load->view('view_user_manager', $data);
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function load_edit_user() {
        if ($this->check_permission('Manage Lists')) {
            $this->load->model('model_users');
            $this->load->model('model_groups');
            $list_groups = $this->model_groups->get_list_of_defined_groups();
            $get_user = $_GET['user_name'];
            if (!empty($get_user)) {
                $user_name = $_GET['user_name'];
                $user_info = $this->model_users->get_user_data_by_user_name($user_name);
                $user_info = $user_info[0];

                if ($this->model_users->see_if_activated($user_name)) {
                    $user_groups_objects = $this->model_groups->get_user_groups_by_id($user_info->id);
                    $user_groups = array();
                    foreach ($user_groups_objects as $grb) {
                        $user_groups[] = $grb->id;
                    }
                    $technicians_array = $this->model_users->get_list_of_users_has_permissions('Perform Repair Action');
                    $technicians[0] = lang('not_selected');
                    foreach ($technicians_array as $tech) {
                        if ($user_info->user_name != $tech->user_name)
                            $technicians[$tech->id] = $tech->user_name;
                    }
                    $data = array(
                        'user_info' => $user_info,
                        'user_groups' => $user_groups,
                        'list_groups' => $list_groups,
                        'technicians' => $technicians
                    );
                    $this->load->view('view_edit_user', $data);
                }
            }
            else {
                $data = array
                    (
                    'list_groups' => $list_groups
                );
                $this->load->view('view_add_new_user', $data);
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function load_edit_user_by_name($user_name) {
        if ($this->check_permission('Manage Lists')) {
            $this->load->model('model_users');
            $this->load->model('model_groups');
            $list_groups = $this->model_groups->get_list_of_defined_groups();
            $user_info = $this->model_users->get_user_data_by_user_name($user_name);
            $user_info = $user_info[0];
            $user_groups = $this->model_groups->get_user_groups_by_id($user_info->id);
            $data = array
                (
                'user_info' => $user_info,
                'user_groups' => $user_groups,
                'list_groups' => $list_groups
            );
            $this->load->view('view_edit_user', $data);
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function save_new_user() {
        if ($this->check_permission('Manage Lists')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_name', 'User Name', 'required|trim|xss_clean|is_unique[users.user_name]');
            $this->form_validation->set_rules('email', 'E-Mail', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|md5|trim');
            $this->form_validation->set_rules('passwordConfirmation', 'Confirm Password', 'required|md5|trim|callback_passwords_match');
            $this->load->model('model_groups');
            $this->load->model('model_users');
            $list_groups = $this->model_groups->get_list_of_defined_groups();
            $user_info = array
                (
                'user_name' => $this->input->post('user_name'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'password' => md5($this->input->post('password')),
                'warranty_follower' => $this->input->post('warranty_follower') ? true : false,
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            );
            $contact_info = array
                (
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            );
            $user_groups = $this->input->post('user_groups');
            if ($this->form_validation->run()) {
                $this->model_users->add_new_user($contact_info, $user_info, $user_groups);
                $user_info = $this->model_users->get_user_data_by_user_name($user_info['user_name']);
                $user_info = $user_info[0];
                $data = array(
                    'user_info' => $user_info,
                    'user_groups' => $user_groups,
                    'list_groups' => $list_groups
                );
                $this->load_users_page("Changes Successfully Performed");
            } else {
                $data = array(
                    'user_info' => $user_info,
                    'user_groups' => $user_groups,
                    'list_groups' => $list_groups
                );
                $this->load_users_page(validation_errors());
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function submit_user_changes() {
        if ($this->check_permission('Manage Lists')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('email', 'E-Mail', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->load->model('model_groups');
            $list_groups = $this->model_groups->get_list_of_defined_groups();

            $posted_password = $this->input->post('password');
            if ($posted_password!='') {
                $this->form_validation->set_rules('password', 'Password', 'required|md5|trim');
//                $this->form_validation->set_rules('passwordConfirmation', 'Confirm Password', 'required|md5|trim|callback_passwords_match');
                $password = md5($posted_password);
            } else {
                $password = '';
            }

            $contact_info = array
                (
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            );
            $user_name = $this->input->post('user_name');
            $warranty_follower = $this->input->post('warranty_follower') ? true : false;
            $software = $this->input->post('software') ? true : false;
            $electronic = $this->input->post('electronic') ? true : false;
            $external = $this->input->post('external_repair') ? true : false;
            $user_groups = $this->input->post('user_groups');

            $this->load->model('model_users');
            if ($this->form_validation->run()) {
                $this->model_users->update_user($user_name, $password, $warranty_follower, $contact_info, $user_groups,$software,$electronic,$external);
                $this->load_users_page("Changes Successfully Performed");
            } else {
                $this->load_users_page(validation_errors());
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
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

    public function passwords_match() {
        if ($this->input->post('password') == $this->input->post('passwordConfirmation')) {
            return true;
        } else {
            $this->form_validation->set_message('validate_credentials', "Password's Don\'t match !");
            return false;
        }
    }

    public function deactivate_user($id) {
        if ($this->check_permission('Manage Lists')) {

            $this->load->model('model_users');
            $username = $this->model_users->get_user_name_by_id($id);
            $permissions = $this->model_users->get_user_permissions($username);
            if ($this->permission_included($permissions, 'Perform Repair Action')) {
                $this->load->model('model_order');
                $user = $this->model_users->get_user_name_by_id($id);
                $orders = $this->model_order->get_technician_tasks_by_name($user);
                if (count($orders) == 0) {
                    $this->model_users->deactivate_user($id);
                    $str = "deleted";
                    redirect("users_manager/load_users_page/" . $str);
                }
                $technicians_array = $this->model_users->get_list_of_users_has_permissions('Perform Repair Action');

                foreach ($technicians_array as $tech) {
                    if ($tech->id != $tech_id)
                        $technicians[$tech->id] = $tech->user_name;
                }

                $data = array
                    (
                    'orders' => $orders,
                    'technicians' => $technicians,
                    'technicians_array'=>$technicians_array,
                    'tech_id' => $tech_id,
                    'status' => $status,
                );

                //$this->model_users->Absence($tech_id, 1);

                $this->load->view('view_assign_orders_from', $data);
            }
            else {
                $this->model_users->deactivate_user($id);
                $str = "deleted";
                redirect("users_manager/load_users_page/" . $str);
            }
        } else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function Absence($id, $val) {
        $this->load->model('model_users');
        $this->model_users->Absence($id, $val);
        redirect('users_manager');
    }

    public function assign_all($status, $id, $alter) {
        if ($this->check_permission('Manage Lists')) {
            $this->load->model('model_users');
            $this->load->model('model_order');

            $user = $this->model_users->get_user_name_by_id($id);
            $orders = $this->model_order->get_technician_tasks_by_name($user);
            foreach ($orders as $order) {
                $this->model_order->assign_order_to_tech($this->session->userdata('user_name'), $order->id, $alter);
            }

            if ($status == "abs")
                $this->model_users->Absence($id, 1);
            else if ($status == "del")
                $this->model_users->deactivate_user($id);
        }
        else {
            redirect(base_url() . 'index.php/main_page/restricted');
        }
    }

    public function permission_included($user_permissions_array, $permission) {
        foreach ($user_permissions_array as $per) {
            if ($per->name == $permission)
                return true;
        }
        return false;
    }

}
