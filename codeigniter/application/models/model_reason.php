<?php

class Model_Reason extends CI_Model {

    public function get_all() {
        $this->db->select('*');
        $query = $this->db->get('reasons');
        return($query->result());
    }

}
