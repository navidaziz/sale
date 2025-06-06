<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Suppliers extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("supplier_model");
        $this->lang->load("suppliers", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {


        // $main_page = base_url() . $this->router->fetch_class() . "/view";
        // redirect($main_page);
        $business_id = $this->session->userdata("business_id");
        $where = "`suppliers`.`status` IN (0, 1) AND `suppliers`.`business_id` = '" . $business_id . "'";
        $data = $this->supplier_model->get_supplier_list($where);
        $this->data["suppliers"] = $data->suppliers;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Suppliers');
        $this->data["view"] = "suppliers/suppliers";
        $this->load->view("layout", $this->data);
    }
    //---------------------------------------------------------------

    function update_supplier_item_stock()
    {
        $inventory_id = (int) $this->input->post("inventory_id");
        $stock =  (int) $this->input->post("stock");
        $query = "UPDATE inventory SET inventory_transaction ='" . $stock . "'
        WHERE inventory_id = '" . $inventory_id . "'";
        if ($this->db->query($query)) {

            echo $stock;
        }
    }

    function update_supplier_item_cost_price()
    {
        $inventory_id = (int) $this->input->post("inventory_id");
        $item_cost_price =  (int) $this->input->post("item_cost_price");
        $query = "UPDATE inventory SET item_cost_price ='" . $item_cost_price . "'
        WHERE inventory_id = '" . $inventory_id . "'";
        if ($this->db->query($query)) {

            echo $item_cost_price;
        }
    }

    function update_supplier_item_unit_price()
    {
        $inventory_id = (int) $this->input->post("inventory_id");
        $item_unit_price =  (int) $this->input->post("item_unit_price");
        $query = "UPDATE inventory SET item_unit_price ='" . $item_unit_price . "'
        WHERE inventory_id = '" . $inventory_id . "'";
        if ($this->db->query($query)) {

            echo $item_unit_price;
        }
    }

    function remove_supplier_item($supplier_id, $supplier_invoice_id, $inventory_id, $return = false)
    {
        $inventory_id  = (int) $inventory_id;
        $query = "DELETE FROM `inventory` WHERE `inventory_id`='" . $inventory_id . "'";
        if ($this->db->query($query)) {
            $this->session->set_flashdata("msg_success", "Record Add Successfully");
        } else {
            $this->session->set_flashdata("msg_error", "Error Try Again.");
        }

        if ($return) {
            redirect("suppliers/supplier_return_view/" . $supplier_id . "/" . $supplier_invoice_id);
        } else {
            redirect("suppliers/supplier_invoice_view/" . $supplier_id . "/" . $supplier_invoice_id);
        }
    }

    function get_item_prices()
    {
        $item_id = (int) $this->input->post("item_id");
        $query = "SELECT `cost_price`,`unit_price` 
                  FROM `items` WHERE item_id = '" . $item_id . "'";
        $item_price_detail['cost_price'] = 0;
        $item_price_detail['unit_price'] = 0;
        if ($this->db->query($query)->result()) {
            $item_price_detail['cost_price'] = $this->db->query($query)->result()[0]->cost_price;
            $item_price_detail['sale_price'] = $this->db->query($query)->result()[0]->unit_price;
        }
        echo json_encode($item_price_detail);
    }


    function add_item_stocks()
    {
        $item_id = (int) $this->input->post("item_id");

        $supplier_invoice_id = $this->input->post("supplier_invoice_id");
        $batch_number = $this->input->post("batch_number");
        $cost_price = $this->input->post("cost_price");
        $unit_price = $this->input->post("unit_price");
        $supplier_id = $this->input->post("supplier_id");
        $transaction = $this->input->post("transaction");
        $date = $this->input->post("date");
        $created_by = $this->session->userdata("user_id");

        //update item enventory after first time add 
        $query = "INSERT INTO `inventory`(`item_id`, 
                                        `business_id`,  
                                          `supplier_id`,
                                          `supplier_invoice_id`, 
                                          `batch_number`, 
                                          `item_cost_price`, 
                                          `item_unit_price`, 
                                          `transaction_type`, 
                                          `inventory_transaction`,
                                          `expiry_date`,`created_by`) 
                            VALUES ('" . $item_id . "',
                                    '" . $this->session->userdata("business_id") . "', 
                                    '" . $supplier_id . "', 
                                    '" . $supplier_invoice_id . "', 
                                    '" . $batch_number . "', 
                                    '" . $cost_price . "', 
                                    '" . $unit_price . "', 
                                    'Stock In',
                                    '" . $transaction . "',
                                    '" . $date . "',
                                    '" . $created_by . "')";
        $this->db->query($query);
        $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));

        $query = "
        UPDATE `items` SET `cost_price` = '" . $cost_price . "',  
        `unit_price` = '" . $unit_price . "'
        WHERE `items`.`item_id` ='" . $item_id . "'";
        $this->db->query($query);
        redirect("suppliers/supplier_invoice_view/" . $supplier_id . "/" . $supplier_invoice_id);
    }

    function return_item_stocks()
    {


        $item_id = (int) $this->input->post("item_id");
        $transaction = $this->input->post("transaction");
        $supplier_invoice_id = $this->input->post("supplier_invoice_id");
        $batch_number = $this->input->post("batch_number");
        $cost_price = $this->input->post("cost_price");
        $unit_price = $this->input->post("unit_price");
        $supplier_id = $this->input->post("supplier_id");

        $date = $this->input->post("date");
        $created_by = $this->session->userdata("user_id");
        $remarks = $this->input->post("remarks");

        $query = "SELECT `total_quantity`, `name` FROM `all_items` WHERE `item_id`='" . $item_id . "'";
        $query_result = $this->db->query($query)->result();
        if ($query_result) {
            if ($query_result[0]->total_quantity >= $transaction) {


                //update item enventory after first time add 
                $query = "INSERT INTO `inventory`(`item_id`, 
                                              `supplier_id`,
                                              `supplier_invoice_id`, 
                                              `batch_number`, 
                                              `item_cost_price`, 
                                              `item_unit_price`, 
                                              `transaction_type`, 
                                              `inventory_transaction`,
                                              `return_date`,
                                              `created_by`,
                                              `remarks`) 
                                VALUES ('" . $item_id . "', 
                                        '" . $supplier_id . "', 
                                        '" . $supplier_invoice_id . "', 
                                        '" . $batch_number . "', 
                                        '" . $cost_price . "', 
                                        '" . $unit_price . "', 
                                        'Stock Return',
                                        '-" . $transaction . "',
                                        '" . $date . "',
                                        '" . $created_by . "',
                                        '" . $remarks . "')";

                $this->db->query($query);
                // $query = "
                // UPDATE `items` SET `cost_price` = '" . $cost_price . "',  
                // `unit_price` = '" . $unit_price . "'
                // WHERE `items`.`item_id` ='" . $item_id . "'";
                // $this->db->query($query);
                $this->session->set_flashdata("msg_success", "Record Add Successfully");
            } else {
                if ($query_result[0]->total_quantity) {
                    $this->session->set_flashdata("msg_error", $query_result[0]->name . " only " . $query_result[0]->total_quantity . " remain in stock. you can't return more then in stock value.");
                } else {
                    $this->session->set_flashdata("msg_error", $query_result[0]->name . " is not in stock");
                }
            }
        } else {
            $this->session->set_flashdata("msg_error", "Item not found");
        }

        redirect("suppliers/supplier_return_view/" . $supplier_id . "/" . $supplier_invoice_id);
    }


    public function supplier_invoice_view($supplier_id, $supplier_invoice_id)
    {
        $business_id = $this->session->userdata("business_id");
        $supplier_id = (int) $supplier_id;
        $supplier_invoice_id = (int) $supplier_invoice_id;
        $query = "SELECT * FROM `suppliers_invoices` 
                  WHERE `supplier_invoice_id` = '" . $supplier_invoice_id . "'
                  AND `business_id` = '" . $business_id . "'";
        $this->data["suppliers_invoices"] = $this->db->query($query)->result()[0];

        $this->data["items"] = $this->supplier_model->getList("items", "item_id", "name", "`items`.`status` IN (1) and `items`.`business_id` = '" . $this->session->userdata("business_id") . "'");

        $this->data["suppliers"] = $this->supplier_model->get_supplier($supplier_id, $where = array("suppliers.business_id" => $business_id));
        $this->data["title"] = $this->data["suppliers"][0]->supplier_name;
        $this->data["detail"] = "Mobile No: " . $this->data["suppliers"][0]->supplier_contact_no . " - Account No:" . $this->data["suppliers"][0]->account_number;
        $query = "SELECT inventory.*, items.name, users.userTitle FROM inventory, items, users 
                  WHERE inventory.item_id = items.item_id
                  AND inventory.created_by = users.user_id
                  AND `supplier_invoice_id` = '" . $supplier_invoice_id . "'
                  AND inventory.business_id = '" . $business_id . "'";
        $this->data['inventories'] = $this->db->query($query)->result();
        $this->data["view"] = "suppliers/supplier_invoice_view";
        $this->load->view("layout", $this->data);
    }

    public function supplier_return_view($supplier_id, $supplier_invoice_id)
    {
        $this->data['supplier_id'] =  $supplier_id = (int) $supplier_id;
        $this->data['supplier_invoice_id'] = $supplier_invoice_id = (int) $supplier_invoice_id;
        $query = "SELECT * FROM `suppliers_invoices` 
                  WHERE `supplier_invoice_id` = '" . $supplier_invoice_id . "'";
        $this->data["suppliers_invoices"] = $this->db->query($query)->result()[0];

        $this->data["items"] = $this->supplier_model->getList("items", "item_id", "name", "`items`.`status` IN (1) AND `items`.`business_id` = '" . $this->session->userdata("business_id") . "'");

        $this->data["suppliers"] = $this->supplier_model->get_supplier($supplier_id);
        $this->data["title"] = $this->data["suppliers"][0]->supplier_name;
        $this->data["detail"] = "Mobile No: " . $this->data["suppliers"][0]->supplier_contact_no . " - Account No:" . $this->data["suppliers"][0]->account_number;
        $query = "SELECT inventory.*, items.name, users.userTitle FROM inventory, items, users 
                  WHERE inventory.item_id = items.item_id
                  AND inventory.created_by = users.user_id
                  AND `supplier_invoice_id` = '" . $supplier_invoice_id . "'";
        $this->data['inventories'] = $this->db->query($query)->result();
        $this->data["view"] = "suppliers/supplier_return_view";
        $this->load->view("layout", $this->data);
    }

    public function print_supplier_return_item_lists($supplier_id, $supplier_invoice_id)
    {
        $this->data['supplier_id'] =  $supplier_id = (int) $supplier_id;
        $this->data['supplier_invoice_id'] = $supplier_invoice_id = (int) $supplier_invoice_id;
        $query = "SELECT * FROM `suppliers_invoices` 
                  WHERE `supplier_invoice_id` = '" . $supplier_invoice_id . "'";
        $this->data["suppliers_invoices"] = $this->db->query($query)->result()[0];

        $this->data["items"] = $this->supplier_model->getList("items", "item_id", "name", "`items`.`status` IN (1)");

        $this->data["suppliers"] = $this->supplier_model->get_supplier($supplier_id);
        $this->data["title"] = $this->data["suppliers"][0]->supplier_name;
        $this->data["detail"] = "Mobile No: " . $this->data["suppliers"][0]->supplier_contact_no . " - Account No:" . $this->data["suppliers"][0]->account_number;
        $query = "SELECT inventory.*, items.name, users.userTitle FROM inventory, items, users 
                  WHERE inventory.item_id = items.item_id
                  AND inventory.created_by = users.user_id
                  AND `supplier_invoice_id` = '" . $supplier_invoice_id . "'";
        $this->data['inventories'] = $this->db->query($query)->result();
        //$this->data["view"] = "suppliers/print_supplier_return_item_lists";
        $this->load->view("suppliers/print_supplier_return_item_lists", $this->data);
    }

    public function print_supplier_item_lists($supplier_id, $supplier_invoice_id)
    {
        $this->data['supplier_id'] =  $supplier_id = (int) $supplier_id;
        $this->data['supplier_invoice_id'] = $supplier_invoice_id = (int) $supplier_invoice_id;
        $query = "SELECT * FROM `suppliers_invoices` 
                  WHERE `supplier_invoice_id` = '" . $supplier_invoice_id . "'";
        $this->data["suppliers_invoices"] = $this->db->query($query)->result()[0];

        $this->data["items"] = $this->supplier_model->getList("items", "item_id", "name", "`items`.`status` IN (1)");

        $this->data["suppliers"] = $this->supplier_model->get_supplier($supplier_id);
        $this->data["title"] = $this->data["suppliers"][0]->supplier_name;
        $this->data["detail"] = "Mobile No: " . $this->data["suppliers"][0]->supplier_contact_no . " - Account No:" . $this->data["suppliers"][0]->account_number;
        $query = "SELECT inventory.*, items.name, users.userTitle FROM inventory, items, users 
                  WHERE inventory.item_id = items.item_id
                  AND inventory.created_by = users.user_id
                  AND `supplier_invoice_id` = '" . $supplier_invoice_id . "'";
        $this->data['inventories'] = $this->db->query($query)->result();
        //$this->data["view"] = "suppliers/print_supplier_return_item_lists";
        $this->load->view("suppliers/print_supplier_item_lists", $this->data);
    }
    public function print_supplier_receipt($supplier_id, $supplier_invoice_id)
    {
        $this->data['supplier_id'] =  $supplier_id = (int) $supplier_id;
        $this->data['supplier_invoice_id'] = $supplier_invoice_id = (int) $supplier_invoice_id;
        $query = "SELECT * FROM `suppliers_invoices` 
                  WHERE `supplier_invoice_id` = '" . $supplier_invoice_id . "'";
        $this->data["suppliers_invoices"] = $this->db->query($query)->result()[0];

        $this->data["items"] = $this->supplier_model->getList("items", "item_id", "name", "`items`.`status` IN (1)");

        $this->data["suppliers"] = $this->supplier_model->get_supplier($supplier_id);
        $this->data["title"] = $this->data["suppliers"][0]->supplier_name;
        $business_id = $this->session->userdata("business_id");
        $this->data["detail"] = "Mobile No: " . $this->data["suppliers"][0]->supplier_contact_no . " - Account No:" . $this->data["suppliers"][0]->account_number;
        $query = "SELECT inventory.*, items.name, items.category, users.userTitle FROM inventory, items, users 
                  WHERE inventory.item_id = items.item_id
                  AND inventory.created_by = users.user_id
                  AND `supplier_invoice_id` = '" . $supplier_invoice_id . "'
                  AND inventory.business_id = '" . $business_id . "'";
        $this->data['inventories'] = $this->db->query($query)->result();
        //$this->data["view"] = "suppliers/print_supplier_return_item_lists";
        $this->load->view("suppliers/print_supplier_receipt", $this->data);
    }

    public function print_supplier_invoices($supplier_id)
    {
        $this->data['supplier_id'] =  $supplier_id = (int) $supplier_id;
        //$this->data['supplier_invoice_id'] = $supplier_invoice_id = (int) $supplier_invoice_id;
        $supplier_id = (int) $supplier_id;
        $query = "SELECT * FROM `suppliers_invoices` 
        WHERE `supplier_id` = '" . $supplier_id . "'  ORDER BY supplier_invoice_id ASC";

        $this->data["suppliers_invoices"] = $this->db->query($query)->result();

        $this->data["items"] = $this->supplier_model->getList("items", "item_id", "name", "`items`.`status` IN (1)");

        $this->data["suppliers"] = $this->supplier_model->get_supplier($supplier_id);
        $this->data["title"] = $this->data["suppliers"][0]->supplier_name;
        $this->data["detail"] = "Mobile No: " . $this->data["suppliers"][0]->supplier_contact_no . " - Account No:" . $this->data["suppliers"][0]->account_number;

        //$this->data["view"] = "suppliers/print_supplier_return_item_lists";
        $this->load->view("suppliers/print_supplier_invoices", $this->data);
    }

    public function add_supplier_invoice()
    {
        $validation_config = array(

            array(
                "field"  =>  "supplier_invoice_number",
                "label"  =>  "Supplier Invoice Number",
                "rules"  =>  "required"
            ),
            array(
                "field"  =>  "invoice_date",
                "label"  =>  "Invoice Date",
                "rules"  =>  "required"
            ),
            array(
                "field"  =>  "supplier_id",
                "label"  =>  "Supplier Id",
                "rules"  =>  "required"
            ),


        );
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        if ($this->form_validation->run() === TRUE) {

            $supplier_invoice_number = $this->db->escape($this->input->post("supplier_invoice_number"));
            $supplier_id = (int) $this->input->post("supplier_id");
            $invoice_date = $this->db->escape($this->input->post("invoice_date"));
            $user_id = $this->session->userdata("user_id");
            $business_id = $this->session->userdata("business_id");

            $query = "SELECT COUNT(*) as total FROM
                    `suppliers_invoices` 
                    WHERE `supplier_invoice_number` = " . $supplier_invoice_number . "
                    AND `supplier_id` = '" . $supplier_id . "'";

            $supplier_invoice_number_count = $this->db->query($query)->result()[0]->total;
            if ($supplier_invoice_number_count == 0) {
                $return_receipt = $this->input->post('return_receipt');
                $query = "INSERT INTO `suppliers_invoices`
            (`supplier_invoice_number`, `business_id`, `supplier_id`, `invoice_date`, `created_by`, `return_receipt`) 
            VALUES (" . $supplier_invoice_number . ", '" . $business_id . "', '" . $supplier_id . "', 
                    " . $invoice_date . ", '" . $user_id . "', '" . $return_receipt . "')";
                if ($this->db->query($query)) {
                    $this->session->set_flashdata("msg_success", "Supplier Invoice Add Successfully");
                    redirect("suppliers/view_supplier/" . $supplier_id);
                } else {

                    $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                    redirect("suppliers/view_supplier/" . $supplier_id);
                }
            } else {
                $this->session->set_flashdata("msg_error", "Record Not Added Due to Duplicate Supplier ID Number.");
                redirect("suppliers/view_supplier/" . $supplier_id);
            }
        } else {

            $this->view_supplier($this->input->post("supplier_id"));
        }
    }

    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {

        $business_id = $this->session->userdata("business_id");
        $where = "`suppliers`.`status` IN (0, 1) AND `suppliers`.`business_id` = '" . $business_id . "'";
        $data = $this->supplier_model->get_supplier_list($where);
        $this->data["suppliers"] = $data->suppliers;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Suppliers');
        $this->data["view"] = "suppliers/suppliers";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_supplier($supplier_id)
    {

        $supplier_id = (int) $supplier_id;

        $query = 'SELECT 
            si.supplier_invoice_id,
            si.supplier_invoice_number,
            si.invoice_date,
            si.return_receipt,
            si.transport_cost,
            si.supplier_id,
            (SELECT COUNT(DISTINCT item_id) FROM inventory WHERE supplier_invoice_id = si.supplier_invoice_id) AS total_items,
            (SELECT ROUND(SUM(item_cost_price * inventory_transaction), 2) FROM inventory WHERE supplier_invoice_id = si.supplier_invoice_id) AS total_cost
            FROM 
            suppliers_invoices si
            WHERE 
            si.supplier_id = ?
            AND si.business_id = ? ';


        $this->data["supplier_invoices"] = $this->db->query($query, array($supplier_id, $this->session->userdata("business_id")))->result();
        $this->data["suppliers"] = $this->supplier_model->get_supplier($supplier_id);
        $this->data["title"] = $this->data["suppliers"][0]->supplier_name;
        $this->data["detail"] = "Mobile No: " . $this->data["suppliers"][0]->supplier_contact_no . " - Account No:" . $this->data["suppliers"][0]->account_number;
        $this->data["view"] = "suppliers/view_supplier";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`suppliers`.`status` IN (2) ";
        $data = $this->supplier_model->get_supplier_list($where);
        $this->data["suppliers"] = $data->suppliers;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Suppliers');
        $this->data["view"] = "suppliers/trashed_suppliers";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($supplier_id, $page_id = NULL)
    {

        $supplier_id = (int) $supplier_id;


        $this->supplier_model->changeStatus($supplier_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect("suppliers/view/" . $page_id);
    }

    /**
     * function to restor supplier from trash
     * @param $supplier_id integer
     */
    public function restore($supplier_id, $page_id = NULL)
    {

        $supplier_id = (int) $supplier_id;


        $this->supplier_model->changeStatus($supplier_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect("suppliers/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft supplier from trash
     * @param $supplier_id integer
     */
    public function draft($supplier_id, $page_id = NULL)
    {

        $supplier_id = (int) $supplier_id;


        $this->supplier_model->changeStatus($supplier_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect("suppliers/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish supplier from trash
     * @param $supplier_id integer
     */
    public function publish($supplier_id, $page_id = NULL)
    {

        $supplier_id = (int) $supplier_id;


        $this->supplier_model->changeStatus($supplier_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect("suppliers/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Supplier
     * @param $supplier_id integer
     */
    public function delete($supplier_id, $page_id = NULL)
    {

        $supplier_id = (int) $supplier_id;
        //$this->supplier_model->changeStatus($supplier_id, "3");

        $this->supplier_model->delete(array('supplier_id' => $supplier_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect("suppliers/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Supplier
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Supplier');
        $this->data["view"] = "suppliers/add_supplier";
        $this->load->view("layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->supplier_model->validate_form_data() === TRUE) {

            $supplier_id = $this->supplier_model->save_data();
            if ($supplier_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect("suppliers/edit/$supplier_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect("suppliers/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Supplier
     */
    public function edit($supplier_id)
    {
        $supplier_id = (int) $supplier_id;
        $this->data["supplier"] = $this->supplier_model->get($supplier_id);

        $this->data["title"] = $this->lang->line('Edit Supplier');
        $this->data["view"] = "suppliers/edit_supplier";
        $this->load->view("layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($supplier_id)
    {

        $supplier_id = (int) $supplier_id;

        if ($this->supplier_model->validate_form_data() === TRUE) {

            $supplier_id = $this->supplier_model->update_data($supplier_id);
            if ($supplier_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect("suppliers/edit/$supplier_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect("suppliers/edit/$supplier_id");
            }
        } else {
            $this->edit($supplier_id);
        }
    }


    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["suppliers"] = $this->supplier_model->getBy($where, false, "supplier_id");
        $j_array[] = array("id" => "", "value" => "supplier");
        foreach ($data["suppliers"] as $supplier) {
            $j_array[] = array("id" => $supplier->supplier_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------


    public function update_stock_form()
    {
        $this->data["title"] = $this->lang->line('Update Stock');
        $inventory = (int) $this->input->post('inventory_id');
        $query = "SELECT i.*, `items`.`name` FROM `inventory` as i 
        INNER JOIN items ON i.item_id = items.item_id
        WHERE i.`inventory_id` = ? ";
        $this->data["inventory"] = $this->db->query($query, [$inventory])->row();
        $this->load->view("suppliers/update_stock_form", $this->data);
    }

    function update_inventory_item()
    {
        $inventory_id = (int) $this->input->post("inventory_id");
        $input['item_unit_price'] = (float) $this->input->post("item_unit_price");
        $input['item_cost_price'] = (float) $this->input->post("item_cost_price");
        $input['inventory_transaction'] = $this->input->post("inventory_transaction");
        $item_id = $this->input->post("item_id");
        $business_id = $this->session->userdata("business_id");
        $query = "Update inventory SET item_unit_price = '" . $input['item_unit_price'] . "',
        item_cost_price = '" . $input['item_cost_price'] . "',
        inventory_transaction = '" . $input['inventory_transaction'] . "'
        WHERE inventory_id = '" . $inventory_id . "' 
        AND business_id = '" . $business_id . "' 
        AND item_id = '" . $item_id . "'";
        if ($this->db->query($query)) {

            $this->db->where('item_id', $item_id);
            $this->db->where('business_id', $business_id);
            $item_price['cost_price'] = $input['item_cost_price'];
            $item_price['unit_price'] = $input['item_unit_price'];
            if ($this->db->update('items', $item_price)) {
                echo 'success';
            } else {
                echo 'Error while update item cost and sale price.';
            }
        } else {
            echo 'no changes made or failed';
        }
    }

    public function add_stock_form()
    {
        $this->data["title"] = 'Add Inventory Stock';
        $this->data["items"] = $this->supplier_model->getList("items", "item_id", "name", "`items`.`status` IN (1) and `items`.`business_id` = '" . $this->session->userdata("business_id") . "'");

        $this->data['supplier_id'] = (int) $this->input->post('supplier_id');
        $this->data['supplier_invoice_id'] = (int) $this->input->post('supplier_invoice_id');
        $this->load->view("suppliers/add_stock_form", $this->data);
    }
    public function get_supplier_payment_form()
    {
        $supplier_id = (int) $this->input->post("supplier_id");
        $payment_id = (int) $this->input->post("payment_id");
        if ($payment_id == 0) {

            $input = $this->get_payment_inputs();
        } else {
            $query = "SELECT * FROM 
            supplier_payments 
            WHERE payment_id = $payment_id";
            $input = $this->db->query($query)->row();
        }

        $this->data["input"] = $input;
        $this->load->view("suppliers/get_supplier_payment_form", $this->data);
    }

    public function add_supplier_payment()
    {
        $this->form_validation->set_rules("business_id", "Business Id", "required");
        $this->form_validation->set_rules("supplier_id", "Supplier Id", "required");
        $this->form_validation->set_rules("payment_date", "Payment Date", "required");
        $this->form_validation->set_rules("payment_mode", "Payment Mode", "required");
        $this->form_validation->set_rules("amount", "Amount", "required");
        $this->form_validation->set_rules("reference_no", "Reference No", "required");
        $this->form_validation->set_rules("remarks", "Remarks", "required");
        //$this->form_validation->set_rules("created_at", "Created At", "required");

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {
            $inputs = $this->get_payment_inputs();
            $inputs->created_by = $this->session->userdata("user_id");
            $payment_id = (int) $this->input->post("payment_id");
            if ($payment_id == 0) {
                $this->db->insert("supplier_payments", $inputs);
            } else {
                $this->db->where("payment_id", $payment_id);
                $inputs->last_updated = date('Y-m-d H:i:s');
                $this->db->update("supplier_payments", $inputs);
            }
            echo "success";
        }
    }
    private function get_payment_inputs()
    {
        $input["payment_id"] = $this->input->post("payment_id");
        $input["business_id"] = $this->session->userdata("business_id");
        $input["supplier_id"] = $this->input->post("supplier_id");
        $input["payment_date"] = $this->input->post("payment_date");
        $input["payment_mode"] = $this->input->post("payment_mode");
        $input["amount"] = $this->input->post("amount");
        $input["reference_no"] = $this->input->post("reference_no");
        $input["remarks"] = $this->input->post("remarks");
        $input["created_at"] = $this->input->post("created_at");
        $inputs =  (object) $input;
        return $inputs;
    }

    public function delete_supplier_payment($payment_id)
    {
        $payment_id = (int) $payment_id;
        $business_id = $this->session->userdata("business_id");
        $this->db->where("payment_id", $payment_id);
        $this->db->where("business_id", $business_id);
        $this->db->delete("supplier_payments");
        $requested_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
        redirect($requested_url);
    }

    private function get_suppliers_invoice_inputs()
    {
        $input["supplier_invoice_id"] = $this->input->post("supplier_invoice_id");
        $input["business_id"] = $this->session->userdata("business_id");
        $input["supplier_invoice_number"] = $this->input->post("supplier_invoice_number");
        $input["supplier_id"] = $this->input->post("supplier_id");
        $input["invoice_date"] = $this->input->post("invoice_date");
        $input["return_receipt"] = $this->input->post("return_receipt");
        $input["transport_cost"] = $this->input->post("transport_cost");
        $inputs =  (object) $input;
        return $inputs;
    }

    public function get_suppliers_invoice_form()
    {
        $supplier_invoice_id = (int) $this->input->post("supplier_invoice_id");
        if ($supplier_invoice_id == 0) {

            $input = $this->get_suppliers_invoice_inputs();
        } else {
            $query = "SELECT * FROM 
            suppliers_invoices 
            WHERE supplier_invoice_id = $supplier_invoice_id";
            $input = $this->db->query($query)->row();
        }
        $this->data["input"] = $input;
        $this->load->view("suppliers/get_suppliers_invoice_form", $this->data);
    }

    public function add_suppliers_invoice()
    {
        $this->form_validation->set_rules("business_id", "Business Id", "required");
        $this->form_validation->set_rules("supplier_invoice_number", "Supplier Invoice Number", "required");
        $this->form_validation->set_rules("supplier_id", "Supplier Id", "required");
        $this->form_validation->set_rules("invoice_date", "Invoice Date", "required");
        $this->form_validation->set_rules("return_receipt", "Return Receipt", "required");
        $this->form_validation->set_rules("transport_cost", "Transport Cost", "required");

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {
            $inputs = $this->get_suppliers_invoice_inputs();
            $inputs->created_by = $this->session->userdata("user_id");
            $supplier_invoice_id = (int) $this->input->post("supplier_invoice_id");
            if ($supplier_invoice_id == 0) {
                $this->db->insert("suppliers_invoices", $inputs);
            } else {
                $this->db->where("supplier_invoice_id", $supplier_invoice_id);
                $inputs->last_updated = date('Y-m-d H:i:s');
                $this->db->update("suppliers_invoices", $inputs);
            }
            echo "success";
        }
    }
    public function delete_suppliers_invoice($supplier_invoice_id)
    {
        $business_id = $this->session->userdata("business_id");
        $supplier_invoice_id = (int) $supplier_invoice_id;
        $this->db->where("supplier_invoice_id", $supplier_invoice_id);
        $this->db->where("business_id", $business_id);
        $this->db->delete("suppliers_invoices");
        $requested_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
        redirect($requested_url);
    }
}
