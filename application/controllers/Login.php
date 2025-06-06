<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		//$this->load->model("user_model");
		$this->load->model("user_m");
		//$this->lang->load("users", 'english');
		//$this->lang->load("system", 'english');

		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------


	/**
	 * Default action to be called
	 */
	public function index()
	{

		//$this->data['captcha'] = $this->captcha(); 
		//check if the user is already logedin
		if ($this->user_m->loggedIn() == TRUE) {

			$homepage_path = $this->session->userdata('role_homepage_uri');
			redirect($homepage_path);
		}


		$this->data['title'] = "Login to dashboard";
		$this->load->view("login/login", $this->data);
	}


	public function validate_user()
	{


		if ($this->user_m->loggedIn() == TRUE) {
			$homepage_path = $this->session->userdata('role_homepage_uri');
			redirect($homepage_path);
		}

		//load other models
		$this->load->model("role_m");
		$this->load->model("module_m");

		$validations = array(
			array(
				'field' =>  'userName',
				'label' =>  'User Name',
				'rules' =>  'required'
			),

			array(
				'field' =>  'userPassword',
				'label' =>  'Password',
				'rules' =>  'required'
			),


			// array(
			// 	'field' =>  'g-recaptcha-response',
			// 	'label' =>  'g-recaptcha-response',
			// 	'rules' =>  'required'
			// ),

		);
		$this->form_validation->set_rules($validations);

		if ($this->form_validation->run() === TRUE) {
			$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));

			$secret = '6Leuqa4ZAAAAACHxncAMn6I8ULX2Rf3R6hT7NhjP';

			$credential = array(
				'secret' => $secret,
				'response' => $this->input->post('g-recaptcha-response')
			);

			$verify = curl_init();
			curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($verify, CURLOPT_POST, true);
			curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
			curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($verify);

			$status = json_decode($response, true);

			// if ($status['success'] != 1) {
			// 	$this->session->set_flashdata('msg', 'Captcha error, Please try again.');
			// 	redirect("login");
			// }

			$input_values = array(
				'userName' => $this->input->post("userName"),
				'userPassword' => trim($this->input->post("userPassword"))
			);

			$user = $this->user_m->getBy($input_values, TRUE);
			//var_dump($input_values);
			//var_dump($user);

			//	exit();
			// $query = "SELECT * FROM users WHERE userName='" . $this->input->post("userName") . "' AND '" . trim($this->input->post("userPassword")) . "'";
			// $user = $this->db->query($query)->result()[0];


			if ($user) {


				//
				$role_homepage_id = $this->role_m->getCol("role_homepage", $user->role_id);
				$role_homepage_parent_id = $this->module_m->getCol("parent_id", $role_homepage_id);

				//now create homepage path
				$homepage_path = "";
				if ($role_homepage_parent_id != 0) {
					$homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_parent_id) . "/";
				}
				$homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_id);

				$fields = "roles.*";
				$join  = array();
				$where = "roles.role_id = $user->role_id";
				$role = $roles = $this->role_m->joinGet($fields, "roles", $join, $where);
				$query = "SELECT * FROM businesses WHERE user_id = '" . $user->user_id . "'";
				$business = $this->db->query($query)->row();
				$this->session->set_flashdata('msg_success', "<strong>" . $user->userName . '</strong><br/><i>Welcome to QUCIK SALE MIS.</i>');

				$user_data = array(
					"user_id" => $user->user_id,
					"userName" => $user->userName,
					"userEmail" => $user->userEmail,
					"gender" => $user->gender,
					"role_homepage_id" => $role_homepage_id,
					"role_homepage_uri" => $homepage_path,
					"role_id" => $user->role_id,
					"logged_in" => TRUE,
					'cnic' => $user->cnic,
					'createdDate' => $user->createdDate,
					'user_type' => $user->user_type,
					'business_id' => $business->business_id,
					'business_name' => $business->name,
					'business_category' => $business->category
				);
				$this->session->set_userdata($user_data);
				if ($business) {
					redirect($homepage_path);
				} else {
					$this->session->set_userdata('role_homepage_uri', 'update_account');
					redirect('update_account');
				}
			} else {

				$this->data['title'] = "Login to dashboard";
				$this->load->view("login/login", $this->data);
			}
		}
	}

	public function logout()
	{
		$this->user_m->logout();
		redirect("login");
	}
}
