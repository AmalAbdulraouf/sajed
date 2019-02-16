<?php

class Model_Place extends CI_Model {

    public function get_all() {
        $this->db->select('*');
        $query = $this->db->get('places');
        return($query->result());
    }

}
