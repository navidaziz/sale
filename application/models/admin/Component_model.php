<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Component_model extends MY_Model
{

	public function __construct()
	{

		parent::__construct();
		$this->table = "components";
		$this->pk = "component_id";
		$this->status = "status";
		$this->order = "order";
	}

	public function validate_form_data()
	{
		$validation_config = array(

			array(
				"field"  =>  "project_id",
				"label"  =>  "Project Id",
				"rules"  =>  "required"
			),

			array(
				"field"  =>  "component_name",
				"label"  =>  "Component Name",
				"rules"  =>  "required"
			),

			array(
				"field"  =>  "component_detail",
				"label"  =>  "Component Detail",
				"rules"  =>  "required"
			),

		);
		//set and run the validation
		$this->form_validation->set_rules($validation_config);
		return $this->form_validation->run();
	}

	public function save_data($image_field = NULL)
	{
		$inputs = array();

		$inputs["project_id"]  =  $this->input->post("project_id");

		$inputs["component_name"]  =  $this->input->post("component_name");

		$inputs["component_detail"]  =  $this->input->post("component_detail");

		return $this->component_model->save($inputs);
	}

	public function update_data($component_id, $image_field = NULL)
	{
		$inputs = array();

		$inputs["project_id"]  =  $this->input->post("project_id");

		$inputs["component_name"]  =  $this->input->post("component_name");

		$inputs["component_detail"]  =  $this->input->post("component_detail");

		return $this->component_model->save($inputs, $component_id);
	}

	//----------------------------------------------------------------
	public function get_component_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
	{
		$data = (object) array();
		$fields = array(
			"components.*",
			"projects.project_name"
		);
		$join_table = array(
			"projects" => "projects.project_id = components.project_id",
		);
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
				$this->component_model->uri_segment = $this->uri->segment(3);
				$config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
			} else {
				$this->component_model->uri_segment = $this->uri->segment(4);
				$config["base_url"]  = base_url($this->uri->segment(2) . "/" . $this->uri->segment(3));
			}
			$config["total_rows"] = $this->component_model->joinGet($fields, "components", $join_table, $where, true);
			$this->pagination->initialize($config);
			$data->pagination = $this->pagination->create_links();
			$data->components = $this->component_model->joinGet($fields, "components", $join_table, $where);
			return $data;
		} else {
			return $this->component_model->joinGet($fields, "components", $join_table, $where, FALSE, TRUE);
		}
	}

	public function get_component($component_id)
	{

		$fields = array(
			"components.*",
			"projects.project_name"
		);
		$join_table = array(
			"projects" => "projects.project_id = components.project_id",
		);
		$where = "components.component_id = $component_id";

		return $this->component_model->joinGet($fields, "components", $join_table, $where, FALSE, TRUE);
	}
}
