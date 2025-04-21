<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile_update extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		$this->load->model("user_model");
		$this->load->model("user_m");
	}
	//---------------------------------------------------------------


	/**
	 * Default action to be called
	 */
	public function index()
	{
		$this->data['title'] = "Login to dashboard";
		$this->load->view("update_profile/update_profile", $this->data);
	}
	public function update_data()
	{
		$user_id = $this->session->userdata('user_id');
		$school_input['telePhoneNumber'] = $this->input->post('telePhoneNumber');
		$school_input['schoolMobileNumber'] = $this->input->post('schoolMobileNumber');
		$school_input['principal_email'] = $this->input->post('principal_email');
		$this->db->where('user_id', $user_id);
		$this->db->update('businesses', $school_input);

		$user_input['userEmail'] = $this->input->post('userEmail');
		$user_input['profile_update'] = 1;
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $user_input);

		redirect($this->session->userdata("role_homepage_uri"));
	}
}
