<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//class Add_school extends Admin_Controller
class Update_account extends MY_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		$this->load->model("user_model");
		$this->load->model("user_m");
		//$this->lang->load("users", 'english');
		//$this->lang->load("system", 'english');

		//$this->output->enable_profiler(TRUE);
		// $user_id = $this->session->userdata('user_id');

		// $query = "SELECT `businesses`.`business_id` FROM `businesses` WHERE user_id = '" . $user_id . "'";
		// $school_result = $this->db->query($query)->result();
		// if ($school_result) {
		// 	$this->session->set_userdata('role_homepage_uri', 'sale_point');
		// 	redirect('sale_point');
		// }
	}
	//---------------------------------------------------------------


	/**
	 * Default action to be called
	 */
	public function index()
	{


		$user_id = $this->session->userdata('user_id');

		$query = "SELECT * FROM `businesses` WHERE user_id = '" . $user_id . "'";
		$business = $this->db->query($query)->row();
		//var_dump($business);
		if ($business) {
			$business = $business;
		} else {
			$business = $this->get_inputs();
		}
		$this->data['input'] = $business;
		$this->data['title'] = "Update Account";
		$this->load->view("update_account/update_account", $this->data);
	}



	public function update_account()
	{
		$this->form_validation->set_rules("name", "Name", "required");
		$this->form_validation->set_rules("type", "Type", "required");
		$this->form_validation->set_rules("category", "Category", "required");
		$this->form_validation->set_rules("contact_no", "Contact No", "required");
		$this->form_validation->set_rules("city", "City", "required");
		$this->form_validation->set_rules("district", "District", "required");
		$this->form_validation->set_rules("latitude", "Latitude", "required");
		$this->form_validation->set_rules("longitude", "Longitude", "required");
		//$this->form_validation->set_rules("is_verified", "Is Verified", "required");

		if ($this->form_validation->run() == FALSE) {
			echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
			exit();
		} else {
			$inputs = $this->get_inputs();
			$inputs->created_by = $this->session->userdata("user_id");

			$business_id = (int) $this->input->post("business_id");
			if ($business_id == 0) {
				$inputs->user_id = $this->session->userdata("user_id");
				$this->db->insert("businesses", $inputs);
				$business_id = $this->db->insert_id();
			} else {
				$this->db->where("business_id", $business_id);
				$inputs->last_updated = date('Y-m-d H:i:s');
				$this->db->update("businesses", $inputs);
			}
			$query = "SELECT * FROM businesses WHERE user_id = '" . $this->session->userdata("user_id") . "'";
			$business = $this->db->query($query)->row();

			$user_data = array(
				'business_id' => $business->business_id,
				'business_name' => $business->name,
				'business_category' => $business->category
			);
			$this->session->set_userdata($user_data);
			echo "success";
		}
	}

	private function get_inputs()
	{
		$input["business_id"] = $this->input->post("business_id");
		$input["name"] = $this->input->post("name");
		$input["type"] = $this->input->post("type");
		$input["category"] = $this->input->post("category");
		$input["contact_no"] = $this->input->post("contact_no");
		$input["city"] = $this->input->post("city");
		$input["district"] = $this->input->post("district");
		$input["latitude"] = $this->input->post("latitude");
		$input["longitude"] = $this->input->post("longitude");
		//$input["is_verified"] = $this->input->post("is_verified");
		$inputs =  (object) $input;
		return $inputs;
	}

	public function process_data()
	{
		$user_id = $this->session->userdata('user_id');
		$woner_data['userName'] = $this->input->post('userName');
		$woner_data['contactNumber'] = $this->input->post('contactNumber');
		$woner_data['cnic'] = $this->input->post('cnic');
		$woner_data['gender'] = $this->input->post('gender');
		$woner_data['address'] = $this->input->post('owner_address');
		$owners = $this->input->post("owners");

		$this->db->where('user_id', $user_id);
		$this->db->update('users', $woner_data);

		$school_data = $this->input->post();

		// $level_ids = $this->input->post("level_of_school_id");
		// $school_data['primary_level'] = 0;
		// $school_data['middle_level'] = 0;
		// $school_data['high_level'] = 0;
		// $school_data['h_sec_college_level'] = 0;
		// foreach ($level_ids as $level_id) {
		// 	if ($level_id == 1) {
		// 		$school_data['primary_level'] = 1;
		// 	}
		// 	if ($level_id == 2) {
		// 		$school_data['middle_level'] = 1;
		// 	}
		// 	if ($level_id == 3) {
		// 		$school_data['high_level'] = 1;
		// 	}
		// 	if ($level_id == 4) {
		// 		$school_data['h_sec_college_level'] = 1;
		// 	}
		// 	if ($level_id == 5) {
		// 		$school_data['academy'] = 1;
		// 	}
		// }

		//unset($school_data['level_of_school_id']);
		$school_data['user_id'] = $user_id;
		unset($school_data['owners']);
		unset($school_data['userName']);
		unset($school_data['contactNumber']);
		unset($school_data['cnic']);
		unset($school_data['gender']);
		unset($school_data['owner_address']);

		unset($school_data['type_of_institute_id']);

		unset($school_data['banka_acount_details']);
		unset($school_data['accountTitle']);
		unset($school_data['bankAccountNumber']);
		unset($school_data['bankBranchAddress']);
		unset($school_data['bankBranchCode']);
		unset($school_data['bankAccountName']);

		if ($school_data['uc_id'] != 0) {
			unset($school_data['uc_text']);
		}
		if ($school_data['biseRegister'] == 'No') {
			unset($school_data['biseregistrationNumber']);
			unset($school_data['primaryRegDate']);
			unset($school_data['middleRegDate']);
			unset($school_data['highRegDate']);
			unset($school_data['interRegDate']);
		}

		if ($school_data['biseAffiliated'] == 'No') {
			unset($school_data['bise_id']);
			unset($school_data['otherBiseName']);
		} else {
			if ($school_data['bise_id'] != 10) {
				unset($school_data['otherBiseName']);
			}
		}
		$year = $this->input->post('e_year');
		unset($school_data['e_year']);
		$month =  $this->input->post('e_month');
		unset($school_data['e_month']);
		$school_data['yearOfEstiblishment'] = $year . "-" . $month;
		//$school_data['level_of_school_id'] = max($level_ids);
		$this->db->insert('businesses', $school_data);
		$school_id = $this->db->insert_id();

		if ($school_data['biseRegister'] == 'Yes') {

			$bise_verification['school_id'] =  $school_id;
			$bise_verification['registration_number'] =  $school_data['biseregistrationNumber'];
			$bise_verification['tdr_amount'] =  0;
			$bise_verification['bise_id'] =  $school_data['bise_id'];
			$this->db->insert('bise_verification_requests', $bise_verification);
		}

		if ($school_data['banka_acount_details'] == 'Yes') {
			$bank_data['accountTitle'] = $this->input->post('accountTitle');
			$bank_data['bankAccountNumber'] = $this->input->post('bankAccountNumber');
			$bank_data['bankBranchAddress'] = $this->input->post('bankBranchAddress');
			$bank_data['bankBranchCode'] = $this->input->post('bankBranchCode');
			$bank_data['bankAccountName'] = $this->input->post('bankAccountName');
			$bank_data['school_id'] = $school_id;
			$this->db->insert('bank_account', $bank_data);
		}

		$owner['owner_name'] = $this->input->post('userName');
		$owner['owner_father_name'] = '';
		$owner['owner_contact_no'] = $this->input->post('contactNumber');
		$owner['owner_cnic'] = $this->input->post('cnic');
		$owner['gender'] = $this->input->post('gender');
		$owner['address'] = $this->input->post('owner_address');
		$owner['status'] = 1;
		$owner['school_id'] = $school_id;
		$this->db->insert('school_owners', $owner);


		//var_dump($owners);
		if ($owners) {
			foreach ($owners as $index => $owner) {
				$owner_input['owner_name'] = $owner['owner_name'];
				$owner_input['owner_father_name'] = '';
				$owner_input['owner_contact_no'] = $owner['owner_contact_no'];
				$owner_input['owner_cnic'] = $owner['owner_cnic'];
				$owner_input['gender'] = $owner['gender'];
				$owner_input['address'] = $owner['owner_address'];
				$owner_input['status'] = 1;
				$owner_input['school_id'] = $school_id;
				$this->db->insert('school_owners', $owner_input);
			}
		}


		$this->session->set_userdata('role_homepage_uri', 'sale_point');
		redirect('sale_point');

		# code...
	}
}
