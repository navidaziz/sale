<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Expenses extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("expense_model");
        $this->lang->load("expenses", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {
        $main_page = base_url() . $this->router->fetch_class() . "/view";
        redirect($main_page);
    }
    //---------------------------------------------------------------


    public function all_expenses()
    {

        $query = "SELECT count(expense_title) as total, expense_title FROM `expenses` GROUP BY expense_title order BY total DESC";
        $expenses = $this->db->query($query)->result();
        echo "<table width=\"100\" border=\"1\">";
        foreach ($expenses as $expense) {
            echo "<tr>";
            echo "<td >" . $expense->expense_title . "</td>";
            $query = "SELECT `expenses`.`expense_amount`, `expenses`.`created_date` FROM `expenses` 
                        WHERE `expenses`.`expense_title` = '" . $expense->expense_title . "'";
            $expense_lists = $this->db->query($query)->result();
            foreach ($expense_lists as $expense_list) {
                echo "<td title=\"" . date('d M, y', strtotime($expense_list->created_date)) . "\">" . $expense_list->expense_amount . "</td>";
            }

            echo "</tr>";
        }
        echo "</table>";

        // AND MONTH(`expenses`.`created_date`) = MONTH(CURRENT_TIMESTAMP)
        //                 AND YEAR(`expenses`.`created_date`) = YEAR(CURRENT_TIMESTAMP)


    }



    public function search_expenses()
    {
        $start_date = $this->input->post("start_date");
        $end_date = $this->input->post("end_date");
        $where = "`expenses`.`status` IN (0, 1) AND DATE(`expenses`.`created_date`) BETWEEN '" . $start_date . "' AND '" . $end_date . "'";
        $expenses = $this->expense_model->get_expense_list($where, false);

        $query = "Select sum(`expense_amount`) as total_expenses FROM `expenses` WHERE `expenses`.`status` IN (0, 1) AND DATE(`expenses`.`created_date`) BETWEEN '" . $start_date . "' AND '" . $end_date . "'";
        $result = $this->db->query($query);
        $total_expenses = $result->result()[0]->total_expenses;
        $this->data['total_expenses'] = $total_expenses;


        $this->data['expenses'] = $expenses;
        $this->data["title"] = "Search Result";
        $this->data["view"] = "expenses/expnense_search";
        $this->load->view("layout", $this->data);
    }


    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {

        $business_id = $this->session->userdata("business_id");

        $this->data["expense_types"] = $this->expense_model->getList("expense_types", "expense_type_id", "expense_type", $where = "business_id = $business_id");
        $today = date("Y-m-d", time());

        $where = "`expenses`.`status` IN (0, 1) 
        AND `expenses`.business_id = '" . $business_id . "'
        AND DATE(`expenses`.`created_date`) = '" . $today . "'";
        $data = $this->expense_model->get_expense_list($where);


        $query = "Select sum(`expense_amount`) as total_expenses FROM `expenses`
        WHERE `expenses`.`status` IN (0, 1) 
        AND business_id = '" . $business_id . "'
         AND DATE(`expenses`.`created_date`) = '" . $today . "'";
        $result = $this->db->query($query);
        $total_expenses = $result->result()[0]->total_expenses;
        $this->data['total_expenses'] = $total_expenses;

        $this->data["expenses"] = $data->expenses;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Expenses');
        $this->data["view"] = "expenses/expenses";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_expense($expense_id)
    {

        $expense_id = (int) $expense_id;

        $this->data["expenses"] = $this->expense_model->get_expense($expense_id);
        $this->data["title"] = $this->lang->line('Expense Details');
        $this->data["view"] = "expenses/view_expense";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`expenses`.`status` IN (2) ";
        $data = $this->expense_model->get_expense_list($where);
        $this->data["expenses"] = $data->expenses;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Expenses');
        $this->data["view"] = "expenses/trashed_expenses";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($expense_id, $page_id = NULL)
    {

        $expense_id = (int) $expense_id;


        $this->expense_model->changeStatus($expense_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect("expenses/view/" . $page_id);
    }

    /**
     * function to restor expense from trash
     * @param $expense_id integer
     */
    public function restore($expense_id, $page_id = NULL)
    {

        $expense_id = (int) $expense_id;


        $this->expense_model->changeStatus($expense_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect("expenses/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft expense from trash
     * @param $expense_id integer
     */
    public function draft($expense_id, $page_id = NULL)
    {

        $expense_id = (int) $expense_id;


        $this->expense_model->changeStatus($expense_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect("expenses/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish expense from trash
     * @param $expense_id integer
     */
    public function publish($expense_id, $page_id = NULL)
    {

        $expense_id = (int) $expense_id;


        $this->expense_model->changeStatus($expense_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect("expenses/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Expense
     * @param $expense_id integer
     */
    public function delete($expense_id, $page_id = NULL)
    {

        $expense_id = (int) $expense_id;
        //$this->expense_model->changeStatus($expense_id, "3");
        //Remove file....
        $expenses = $this->expense_model->get_expense($expense_id);
        $file_path = $expenses[0]->expense_attachment;
        $this->expense_model->delete_file($file_path);
        $this->expense_model->delete(array('expense_id' => $expense_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect("expenses/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Expense
     */
    public function add()
    {

        $this->data["expense_types"] = $this->expense_model->getList("EXPENSE_TYPES", "expense_type_id", "expense_type", $where = "");

        $this->data["title"] = $this->lang->line('Add New Expense');
        $this->data["view"] = "expenses/add_expense";
        $this->load->view("layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->expense_model->validate_form_data() === TRUE) {

            if ($this->upload_file("expense_attachment")) {
                $_POST['expense_attachment'] = $this->data["upload_data"]["file_name"];
            }

            $expense_id = $this->expense_model->save_data();
            if ($expense_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect("expenses/view");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect("expenses/view");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Expense
     */
    public function edit($expense_id)
    {
        $expense_id = (int) $expense_id;
        $this->data["expense"] = $this->expense_model->get($expense_id);

        $this->data["expense_types"] = $this->expense_model->getList("EXPENSE_TYPES", "expense_type_id", "expense_type", $where = "");

        $this->data["title"] = $this->lang->line('Edit Expense');
        $this->data["view"] = "expenses/edit_expense";
        $this->load->view("layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($expense_id)
    {

        $expense_id = (int) $expense_id;

        if ($this->expense_model->validate_form_data() === TRUE) {

            if ($this->upload_file("expense_attachment")) {
                $_POST["expense_attachment"] = $this->data["upload_data"]["file_name"];
            }

            $expense_id = $this->expense_model->update_data($expense_id);
            if ($expense_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect("expenses/edit/$expense_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect("expenses/edit/$expense_id");
            }
        } else {
            $this->edit($expense_id);
        }
    }


    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["expenses"] = $this->expense_model->getBy($where, false, "expense_id");
        $j_array[] = array("id" => "", "value" => "expense");
        foreach ($data["expenses"] as $expense) {
            $j_array[] = array("id" => $expense->expense_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

    public function get_expense_type_form()
    {
        $expense_type_id = (int) $this->input->post("expense_type_id");
        if ($expense_type_id == 0) {

            $input = $this->get_inputs();
        } else {
            $query = "SELECT * FROM 
            expense_types 
            WHERE expense_type_id = $expense_type_id";
            $input = $this->db->query($query)->row();
        }
        $this->data["input"] = $input;
        $this->load->view("expenses/get_expense_type_form", $this->data);
    }

    private function get_inputs()
    {
        $input["expense_type_id"] = $this->input->post("expense_type_id");
        $input["expense_type"] = $this->input->post("expense_type");
        $inputs =  (object) $input;
        return $inputs;
    }
    public function add_expense_type()
    {
        //$this->form_validation->set_rules("business_id", "Business Id", "required");
        $this->form_validation->set_rules("expense_type", "Expense Type", "required");

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {
            $inputs = $this->get_inputs();

            $inputs->business_id  = $this->session->userdata("business_id");
            $inputs->created_by = $this->session->userdata("user_id");
            $expense_type_id = (int) $this->input->post("expense_type_id");
            if ($expense_type_id == 0) {
                $this->db->insert("expense_types", $inputs);
            } else {
                $this->db->where("expense_type_id", $expense_type_id);
                $inputs->last_updated = date('Y-m-d H:i:s');
                $this->db->update("expense_types", $inputs);
            }
            echo "success";
        }
    }
}
