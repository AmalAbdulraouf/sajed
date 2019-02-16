<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contacts extends CI_Controller {
    #index

    function __construct() {
        parent::__construct();

        $this->load->library('Grocery_CRUD');
        $this->load->model('model_contacts');
        $this->load->model('model_order');
    }

    public function search() {

        $key = $this->input->get('key');

        $customers = $this->model_contacts->search($key);

        echo json_encode(array('data' => $customers));
    }

    public function contact_rating() {
        $customer_id = $this->input->get('customer_id');
        $rate = $this->input->get('rate');
        $this->model_contacts->contact_rate($customer_id, $rate);
    }

    public function get_not_delivered() {

        $key = $this->input->get('contact_id');

        $orders = $this->model_contacts->get_not_delivered($key);

        echo json_encode(array('data' => $orders));
    }

    public function get_prev_machines() {

        $key = $this->input->get('contact_id');

        $orders = $this->model_contacts->get_prev_machines($key);

        echo json_encode(array('data' => $orders));
    }

    public function contacts_management($operation = null) {
        if ($this->session->userdata('language') == 'Arabic') {
            $this->lang->load('website', 'arabic');
        } else {
            $this->lang->load('website', 'english');
        }
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('datatables')
                    ->set_language('arabic')
                    ->where('id', 132)
                    ->set_table('contacts')
                    //The record name
                    ->set_subject($this->lang->line('customer'))
                    ->columns('id', 'first_name', 'phone', 'email', 'address', 'IDnum', 'discount', 'points', 'msg')
                    ->display_as('first_name', lang('first_name'))
                    ->display_as('last_name', lang('last_name'))
                    ->display_as('points', lang('customer_points'))
                    ->display_as('msg', lang('send_notification'))
                    ->display_as('phone', 'جوال')
                    ->display_as('phone2', 'هاتف ')
                    ->display_as('email', 'الإيميل')
                    ->display_as('IDnum', $this->lang->line('ID'))
                    ->display_as('discount', $this->lang->line('discount'))
                    ->display_as('address', 'العنوان')
                    ->display_as('age', 'العمر')
                    ->display_as('has_card', 'بطاقة العضوية')
                    ->display_as('card_discount', 'الحسم')
                    ->unset_edit_fields('contact_id')
                    ->unset_add_fields('contact_id')
                    ->callback_column('first_name', array($this, 'send_msg_button'))
                    ->unset_export()
                    ->unset_read()
                    ->unset_print();
            $output = $crud->render();
            $array = array
                (
                'name' => 'management/customers_management',
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
    }

    function send_msg_button($value, $row) {
        $row->msg = "<button "
                . "id='$row->id' "
                . "class='send_ntf ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-button-text'>"
                . "<span class='ui-button-text'>"
                . lang('send_notification') . "</span></button>";
        $row->first_name = $row->first_name . " " . $row->last_name;
        return $value;
    }

    public function send_ntf_to_customer() {
        $id = $this->input->post('contact_id');
        $message = $this->input->post('msg');
        $this->load->model('model_contacts');
        $contact = $this->model_contacts->get_by_id($id);
        $this->send_sms($message, $contact->phone);
        if ($contact->email != "")
            $this->send_email($message, $contact->email);
        echo json_encode($contact);
    }

    public function send_notification_view() {
        $array = array
            (
            'name' => 'send_notification'
        );
        $this->load->view('view_template', $array);
    }

    public function send_notification() {
        $this->load->library('form_validation');
        $this->load->model('model_contacts');
        $this->form_validation->set_rules('message_text', 'lang:message', 'xss_clean|trim|required');
        $message = $this->input->post('message_text');
        if ($this->form_validation->run() == FALSE) {
            $this->send_notification_view();
        } else {
            $contacts = $this->model_contacts->get_list_of_customers();
            foreach ($contacts as $contact) {
                $this->send_sms($message, $contact->phone);
                if ($contact->email != "")
                    $this->send_email($message, $contact->email);
            }
        }
        redirect("contacts/send_notification_view");
    }

    public function send_email($message, $email) {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'info@alkhaleejsys.com',
            'smtp_pass' => 'kh0148271711',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('Alkhaleej Computer Sys');
        $this->email->to($email);
        $this->email->subject(lang('khalij'));
        $this->email->message($message);
        $this->email->send();
        //show_error($this->email->print_debugger());
    }

    private function send_sms($message, $moblie) {
        //$message = iconv('UTF-8','WINDOWS-1256',$message);

        $message = $this->ToUnicode($message);
        //$mobile = "558585343";
        
        $_url = 'http://sms.malath.net.sa/httpSmsProvider.aspx' . "?username=" . "KHALEEJSYS" . "&password=" . "0565610236" . "&mobile=" . $moblie . "&sender=" . 'KHALEEJ SYS' . "&message=" . $message . "&unicode=U";

        //echo $_url;
        $_url = preg_replace("/ /", "%20", $_url);
        //echo '\n\n\n'.$_url.'\n\n\n';
        $result = file_get_contents($_url);
//        var_dump($_url,$moblie); die();
        ///echo $result;
        // $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        // fwrite($myfile, $_url.'\r\n');
        // fwrite($myfile, $result);
        // fclose($myfile);
    }

    private function ToUnicode($Text) {
        $Backslash = "\ ";
        $Backslash = trim($Backslash);

        $UniCode = Array
            (
            "،" => "060C",
            "؛" => "061B",
            "؟" => "061F",
            "ء" => "0621",
            "آ" => "0622",
            "أ" => "0623",
            "ؤ" => "0624",
            "إ" => "0625",
            "ئ" => "0626",
            "ا" => "0627",
            "ب" => "0628",
            "ة" => "0629",
            "ت" => "062A",
            "ث" => "062B",
            "ج" => "062C",
            "ح" => "062D",
            "خ" => "062E",
            "د" => "062F",
            "ذ" => "0630",
            "ر" => "0631",
            "ز" => "0632",
            "س" => "0633",
            "ش" => "0634",
            "ص" => "0635",
            "ض" => "0636",
            "ط" => "0637",
            "ظ" => "0638",
            "ع" => "0639",
            "غ" => "063A",
            "�?" => "0641",
            "ق" => "0642",
            "ك" => "0643",
            "ل" => "0644",
            "م" => "0645",
            "ن" => "0646",
            "ه" => "0647",
            "و" => "0648",
            "ى" => "0649",
            "ي" => "064A",
            "ـ" => "0640",
            "ً" => "064B",
            "ٌ" => "064C",
            "�?" => "064D",
            "َ" => "064E",
            "�?" => "064F",
            "�?" => "0650",
            "ّ" => "0651",
            "ْ" => "0652",
            "!" => "0021",
            '"' => "0022",
            "#" => "0023",
            "$" => "0024",
            "%" => "0025",
            "&" => "0026",
            "'" => "0027",
            "(" => "0028",
            ")" => "0029",
            "*" => "002A",
            "+" => "002B",
            "," => "002C",
            "-" => "002D",
            "." => "002E",
            "/" => "002F",
            "0" => "0030",
            "1" => "0031",
            "2" => "0032",
            "3" => "0033",
            "4" => "0034",
            "5" => "0035",
            "6" => "0036",
            "7" => "0037",
            "8" => "0038",
            "9" => "0039",
            ":" => "003A",
            ";" => "003B",
            "<" => "003C",
            "=" => "003D",
            ">" => "003E",
            "?" => "003F",
            "@" => "0040",
            "A" => "0041",
            "B" => "0042",
            "C" => "0043",
            "D" => "0044",
            "E" => "0045",
            "F" => "0046",
            "G" => "0047",
            "H" => "0048",
            "I" => "0049",
            "J" => "004A",
            "K" => "004B",
            "L" => "004C",
            "M" => "004D",
            "N" => "004E",
            "O" => "004F",
            "P" => "0050",
            "Q" => "0051",
            "R" => "0052",
            "S" => "0053",
            "T" => "0054",
            "U" => "0055",
            "V" => "0056",
            "W" => "0057",
            "X" => "0058",
            "Y" => "0059",
            "Z" => "005A",
            "[" => "005B",
            $Backslash => "005C",
            "]" => "005D",
            "^" => "005E",
            "_" => "005F",
            "`" => "0060",
            "a" => "0061",
            "b" => "0062",
            "c" => "0063",
            "d" => "0064",
            "e" => "0065",
            "f" => "0066",
            "g" => "0067",
            "h" => "0068",
            "i" => "0069",
            "j" => "006A",
            "k" => "006B",
            "l" => "006C",
            "m" => "006D",
            "n" => "006E",
            "o" => "006F",
            "p" => "0070",
            "q" => "0071",
            "r" => "0072",
            "s" => "0073",
            "t" => "0074",
            "u" => "0075",
            "v" => "0076",
            "w" => "0077",
            "x" => "0078",
            "y" => "0079",
            "z" => "007A",
            "{" => "007B",
            "|" => "007C",
            "}" => "007D",
            "~" => "007E",
            "©" => "00A9",
            "®" => "00AE",
            "÷" => "00F7",
            "×" => "00F7",
            "§" => "00A7",
            " " => "0020",
            "\n" => "000D",
            "\r" => "000A",
            "\t" => "0009",
            "é" => "00E9",
            "ç" => "00E7",
            "à" => "00E0",
            "ù" => "00F9",
            "µ" => "00B5",
            "è" => "00E8"
        );

        $Result = "";
        $StrLen = strlen($Text);
        $myfile = fopen("newfile33.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $Text . 'taher\n');
        fwrite($myfile, $code . 'taher\n');
        for ($i = 0; $i < $StrLen; $i++) {

            $currect_char = mb_substr($Text, $i, 1); // substr($Text,$i,1);

            if (array_key_exists($currect_char, $UniCode)) {
                $Result .= $UniCode[$currect_char];

                //print $UniCode[$currect_char].'<br>';
            }
            fwrite($myfile, $currect_char . ' ');
            fwrite($myfile, $UniCode[$currect_char] . "\n");
        }
        fclose($myfile);
        return $Result;
    }

}
