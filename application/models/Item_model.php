<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Item_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "items";
        $this->pk = "item_id";
        $this->status = "status";
        $this->order = "order";
    }





    public function save_data($image_field = NULL)
    {
        $inputs = array();

        $inputs["name"]  =  $this->input->post("name");

        $inputs["category"]  =  $this->input->post("category");

        $inputs["item_code_no"]  =  $this->input->post("item_code_no");

        $inputs["description"]  =  $this->input->post("description");

        $inputs["cost_price"]  =  $this->input->post("cost_price");

        $inputs["unit_price"]  =  $this->input->post("unit_price");

        $inputs["unit"]  =  $this->input->post("unit");

        $inputs["record_level"]  =  $this->input->post("record_level");

        $inputs["location"]  =  $this->input->post("location");
        $inputs["business_id"]  =  $this->session->userdata("business_id");

        return $this->item_model->save($inputs);
    }

    public function update_data($item_id, $image_field = NULL)
    {
        $inputs = array();

        $inputs["name"]  =  $this->input->post("name");

        $inputs["category"]  =  $this->input->post("category");

        $inputs["item_code_no"]  =  $this->input->post("item_code_no");

        $inputs["description"]  =  $this->input->post("description");

        $inputs["cost_price"]  =  $this->input->post("cost_price");

        $inputs["unit_price"]  =  $this->input->post("unit_price");

        $inputs["unit"]  =  $this->input->post("unit");

        $inputs["record_level"]  =  $this->input->post("record_level");

        $inputs["location"]  =  $this->input->post("location");
        $inputs["discount"]  =  $this->input->post("discount");

        $where = array(
            'item_id' => $item_id,
            'business_id' => $this->session->userdata("business_id")
        );
        $this->db->where($where);
        $this->db->update('items', $inputs);
        return $item_id;
    }

    //----------------------------------------------------------------
    public function get_item_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array("items.*");
        $join_table = array();
        if (!is_null($where_condition)) {
            $where = $where_condition;
        } else {
            $where = "";
        }

        if ($pagination) {
            //configure the pagination
            $this->load->library("pagination");

            if ($public) {
                $config['per_page'] = 10;
                $config['uri_segment'] = 3;
                $this->item_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->item_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url($this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->item_model->joinGet($fields, "items", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->items = $this->item_model->joinGet($fields, "items", $join_table, $where);
            return $data;
        } else {
            return $this->item_model->joinGet($fields, "items", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_item($item_id)
    {

        $fields = array("items.*");
        $join_table = array();
        $where = "items.item_id = '" . $item_id . "' AND 
        items.business_id = '" . $this->session->userdata("business_id") . "'";

        return $this->item_model->joinGet($fields, "items", $join_table, $where, FALSE, TRUE);
    }
}
