<?php

class Model_colors extends CI_Model {

    public function add_new_color($color_name) {
        $name = array
            (
            'color_name' => $color_name
        );
        $this->db->insert('colors', $name);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
    }

    public function get_colors_by_name_like($color_name) {
        $this->db->select('*');
        $this->db->like('color_name', $color_name);
        $this->db->from('colors');
        $query = $this->db->get();
        return($query->result());
    }

    public function get_color_id_by_name($color_name) {
        $this->db->select('id');
        $this->db->where('color_name', $color_name);
        $this->db->from('colors');
        $query = $this->db->get();
        $query_result = ($query->result());
        if (count($query_result) > 0) {
            return $query_result[0]->id;
        } else {
            return -1;
        }
    }

    function get_color_id_for_save_order($color_name) {
        $color_id = $this->get_color_id_by_name($color_name);
        if ($color_id != -1) {
            return $color_id;
        } else {
            $color_id = $this->add_new_color($color_name);
            return $color_id;
        }
    }

    function get_list_of_colors() {
        $this->db->select('id, color_name');
        $this->db->from('colors');
        $this->db->where('deleted', '0');
        $query = $this->db->get();
        return($query->result());
    }

    function delete($id) {
        return $this->db->update('colors', array('deleted' => 1), array('id' => $id));
    }

}
