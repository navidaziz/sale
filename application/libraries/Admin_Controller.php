<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Admin_Controller extends MY_Controller
{

    public $controller_name = "";
    public $method_name = "";


    public function __construct()
    {

        parent::__construct();


        error_reporting(-1); // show all errors
        ini_set('display_errors', 1);

        $this->load->helper("my_functions");
        $this->load->model("mr_m");
        $this->load->model("module_m");
        $this->data['controller_name'] = $this->controller_name = $this->router->fetch_class();
        $this->data['method_name'] = $this->method_name = $this->router->fetch_method();
        $this->data['menu_arr'] = $this->mr_m->roleMenu($this->session->userdata("role_id"));

        $exception_uri = array(
            "user/login",
            "user/logout",
            "login",
            "login/index",
            "login/logout",
            "login/validate_user",
            "register/signup",
            "register/index",
            "register/password_reset",
            "register/password_reset_submit"
        );
        if (!in_array(uri_string(), $exception_uri)) {
            //     //check if the user is logged in or not
            if (!$this->session->userdata('user_id') && empty($this->session->userdata('user_id'))) {

                $is_ajax = 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '');
                if ($is_ajax) {
                    echo '<div class="alert alert-danger">';
                    echo 'Please log in again as your session has expired.';
                    echo '<span style="margin-left:20px;"></span><a href="' . site_url('login') . '"> Login again</a>';
                    echo '</div>';
                    exit();
                } else {
                    redirect("login");
                }
            }

            //     //now we will check if the current module is assigned to the user or not
            //     $this->data['current_action_id'] = $current_action_id = $this->module_m->actionIdFromName($this->controller_name, $this->method_name);

            //     $allowed_modules = $this->mr_m->rightsByRole($this->session->userdata("role_id"));
            //     //$current_action_id = 1;
            //     //$allowed_modules = array();
            //     //add role homepage to allowed modules
            //     $allowed_modules[] = $this->session->userdata("role_homepage_id");

            //     if (!in_array($current_action_id, $allowed_modules)) {
            //         $is_ajax = 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '');
            //         if ($is_ajax) {
            //             echo '<div class="alert alert-danger">
            //                 <strong>Error!</strong> You are not allowed to access this module.
            //                 ' . $this->controller_name . ' - ' . $this->method_name . '
            //             </div>
            //             ';
            //             exit();
            //         } else {
            //             if (!$this->session->userdata('user_id') && empty($this->session->userdata('user_id'))) {
            //                 redirect("login");
            //             } else {
            //                 $this->session->set_flashdata('msg_error', 'You are not allowed to access this module');
            //                 // redirect($_SERVER['HTTP_REFERER']);
            //                 // session_destroy();
            //                 //redirect($this->session->userdata("role_homepage_uri"));
            //                 $module = $this->controller_name . '-' . $this->method_name;
            //                 redirect(site_url("errors/index?module=$module"));
            //             }
            //         }
            //     }
        }
    }
}
