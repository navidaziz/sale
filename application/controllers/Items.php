<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Items extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("item_model");
        $this->lang->load("items", 'english');
        $this->lang->load("system", 'english');

        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {
        $main_page = base_url() .  $this->router->fetch_class() . "/view";
        redirect($main_page);
    }
    //---------------------------------------------------------------

    public function update_cost_price()
    {
        $item_id = (int) $this->input->post("item_id");
        $cost_price =  (float) $this->input->post("cost_price");
        $profit_percetage = "12";
        $sale_price = round(($cost_price * (100 + $profit_percetage) / 100), 2);
        $query = "UPDATE items SET cost_price ='" . $cost_price . "'
        WHERE item_id = '" . $item_id . "'";
        if ($this->db->query($query)) {

            echo $cost_price;
        }
    }

    public function update_unit_price()
    {
        $item_id = (int) $this->input->post("item_id");
        $unit_price =  (float) $this->input->post("unit_price");
        $query = "UPDATE items SET unit_price ='" . $unit_price . "'
        WHERE item_id = '" . $item_id . "'";
        if ($this->db->query($query)) {

            echo $unit_price;
        }
    }




    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {

        $item_category = $this->input->get('category');
        //$where = "`items`.`status` IN (0, 1) ";
        //$data = $this->item_model->get_item_list($where);
        //$this->data["items"] = $data->items;
        //$this->data["pagination"] = $data->pagination;
        if ($item_category) {
            $this->data['item_category'] = $this->input->get('category');
        }
        $business_id = $this->session->userdata("business_id");
        $query = "SELECT * FROM all_items WHERE `status` IN (0, 1) 
        AND business_id = '" . $business_id . "'";

        if ($item_category) {
            $query .= " AND category = '" . $item_category . "'";
        }
        $query .= " ORDER BY category, name ASC";



        $this->data["items"] = $this->db->query($query)->result();


        $this->data["title"] = $this->lang->line('Items');
        $this->data["view"] =  "items/items";
        $this->load->view("layout", $this->data);
    }


    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_item($item_id)
    {


        $item_id = (int) $item_id;
        $business_id = $this->session->userdata("business_id");
        $query = "SELECT COUNT(*) as total FROM items 
        WHERE item_id = '" . $item_id . "' 
        AND business_id = '" . $business_id . "'";

        if ($this->db->query($query)->row()->total > 0) {
            $this->data["items"] = $this->item_model->get_item($item_id);

            if ($this->data["items"][0]->item_code_no) {
                //I'm just using rand() function for data example
                //$data = [];
                $code = rand(10000, 99999);

                //load library
                $this->load->library('zend');
                //load in folder Zend
                $this->zend->load('Zend/Barcode');
                //generate barcode
                $imageResource = Zend_Barcode::factory('code128', 'image', array('text' => $this->data["items"][0]->item_code_no), array())->draw();
                imagepng($imageResource, 'barcodes/' . $this->data["items"][0]->item_code_no . '.png');

                $this->data['barcode'] = site_url('barcodes/' . $this->data["items"][0]->item_code_no . '.png');
            } else {
                $this->data['barcode'] = NULL;
            }

            $this->data["title"] = $this->lang->line('Item Details');
            $this->data["view"] =  "items/view_item";
            $this->load->view("layout", $this->data);
        } else {
            echo "You are not allowed";
        }
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {
        $business_id = $this->session->userdata("business_id");
        $where = "`items`.`status` IN (2) AND business_id = '" . $business_id . "'";
        $data = $this->item_model->get_item_list($where);
        $this->data["items"] = $data->items;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Items');
        $this->data["view"] =  "items/trashed_items";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($item_id, $page_id = NULL)
    {

        $item_id = (int) $item_id;
        $business_id = $this->session->userdata("business_id");
        $query = "SELECT COUNT(*) as total FROM items 
        WHERE item_id = '" . $item_id . "' 
        AND business_id = '" . $business_id . "'";

        if ($this->db->query($query)->row()->total > 0) {
            $this->item_model->changeStatus($item_id, "2");
            $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
            redirect("items/view/" . $page_id);
        } else {
            echo "You are not allowed";
        }
    }

    /**
     * function to restor item from trash
     * @param $item_id integer
     */
    public function restore($item_id, $page_id = NULL)
    {
        $item_id = (int) $item_id;
        $business_id = $this->session->userdata("business_id");
        $query = "SELECT COUNT(*) as total FROM items 
        WHERE item_id = '" . $item_id . "' 
        AND business_id = '" . $business_id . "'";

        if ($this->db->query($query)->row()->total > 0) {
            $this->item_model->changeStatus($item_id, "1");
            $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
            redirect("items/trashed/" . $page_id);
        } else {
            echo "You are not allowed";
        }
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft item from trash
     * @param $item_id integer
     */
    public function draft($item_id, $page_id = NULL)
    {

        $item_id = (int) $item_id;
        $business_id = $this->session->userdata("business_id");
        $query = "SELECT COUNT(*) as total FROM items 
        WHERE item_id = '" . $item_id . "' 
        AND business_id = '" . $business_id . "'";

        if ($this->db->query($query)->row()->total > 0) {

            $this->item_model->changeStatus($item_id, "0");
            $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
            redirect("items/view/" . $page_id);
        } else {
            echo "You are not allowed";
        }
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish item from trash
     * @param $item_id integer
     */
    public function publish($item_id, $page_id = NULL)
    {
        $item_id = (int) $item_id;
        $business_id = $this->session->userdata("business_id");
        $query = "SELECT COUNT(*) as total FROM items 
        WHERE item_id = '" . $item_id . "' 
        AND business_id = '" . $business_id . "'";

        if ($this->db->query($query)->row()->total > 0) {
            $this->item_model->changeStatus($item_id, "1");
            $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
            redirect("items/view/" . $page_id);
        } else {
            echo "You are not allowed";
        }
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Item
     * @param $item_id integer
     */
    public function delete($item_id, $page_id = NULL)
    {
        $item_id = (int) $item_id;
        $business_id = $this->session->userdata("business_id");
        $query = "SELECT COUNT(*) as total FROM items 
        WHERE item_id = '" . $item_id . "' 
        AND business_id = '" . $business_id . "'";

        if ($this->db->query($query)->row()->total > 0) {
            $this->item_model->changeStatus($item_id, "3");

            //$this->item_model->delete(array('item_id' => $item_id));
            $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
            redirect("items/trashed/" . $page_id);
        } else {
            echo "You are not allowed";
        }
    }
    //----------------------------------------------------



    /**
     * function to add new Item
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Item');
        $this->data["view"] =  "items/add_item";
        $this->load->view("layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {

        if ($this->validate_form_data() === TRUE) {

            $item_id = $this->item_model->save_data();
            if ($item_id) {
                $cost_price = $this->input->post("cost_price");
                $unit_price = $this->input->post("unit_price");
                $supplier_id = $this->input->post("supplier_id");
                $created_by = $this->session->userdata("user_id");
                $business_id = $this->session->userdata("business_id");
                if ($this->input->post("stock")) {
                    $stock = $this->input->post("stock");
                } else {
                    $stock = 0;
                }
                $date = date('Y-m-d', time());

                $supplier_id = 0;
                $query = "SELECT supplier_id, count(*) as total FROM `suppliers` WHERE business_id = ? LIMIT 1";
                $result = $this->db->query($query, [$business_id])->row();
                if ($result->total == 0) {
                    //echo "need to add supplier";
                    // Create new supplier for opening stock
                    $supplier_data = [
                        'business_id' => $business_id,
                        'supplier_name' => 'Opening Stock',
                        'supplier_contact_no' => '0000000000000',
                        'company_name' => 'Opening Stock',
                        'account_number' => NULL
                    ];
                    $this->db->insert('suppliers', $supplier_data);
                    $supplier_id = $this->db->insert_id();
                } else {
                    $supplier_id = $result->supplier_id;
                }

                $supplier_invoice_id = 0;
                // Optionally get the latest invoice if needed
                $query = "SELECT supplier_invoice_id, count(*) as total FROM `suppliers_invoices` 
                    WHERE supplier_id = ? and business_id = ? ORDER BY invoice_date DESC LIMIT 1";
                $invoice_result = $this->db->query($query, [$supplier_id, $business_id])->row();

                if ($invoice_result->total == 0) {
                    $invoice_data = [
                        'business_id' => $business_id,
                        'supplier_invoice_number' => '1',
                        'supplier_id' => $supplier_id,
                        'return_receipt' => 1,
                        'created_by' => $created_by,
                        'invoice_date' => date('Y-m-d')
                    ];

                    $this->db->insert('suppliers_invoices', $invoice_data);
                    $supplier_invoice_id = $this->db->insert_id();
                } else {
                    $supplier_invoice_id = $invoice_result->supplier_invoice_id;
                }


                if ($supplier_id != 0 and $supplier_invoice_id != 0) {
                    //update item enventory after first time add 
                    $query = "INSERT INTO `inventory`(`business_id`, `item_id`, `supplier_id`, `supplier_invoice_id`, `item_cost_price`, `item_unit_price`, `transaction_type`, `inventory_transaction`,`created_by`, `expiry_date`) 
                            VALUES ('" . $business_id . "', '" . $item_id . "', '" . $supplier_id . "', '" . $supplier_invoice_id . "', '" . $cost_price . "', '" . $unit_price . "', 'Item Created','" . $stock . "','" . $created_by . "', '" . $date . "')";
                    $this->db->query($query);



                    $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                    redirect("items/edit/$item_id");
                } else {
                    echo 'Opening stock not added';
                }
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect("items/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Item
     */
    public function edit($item_id)
    {
        $item_id = (int) $item_id;
        $this->data["item"] = $this->item_model->get($item_id);

        $this->data["title"] = $this->lang->line('Edit Item');
        $this->data["view"] =  "items/edit_item";
        $this->load->view("layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($item_id)
    {

        $item_id = (int) $item_id;

        if ($this->validate_form_data(true) === TRUE) {

            $item_id = $this->item_model->update_data($item_id);
            if ($item_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect("items/edit/$item_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect("items/edit/$item_id");
            }
        } else {
            $this->edit($item_id);
        }
    }

    function get_item_detail()
    {
        $item_id = (int) $this->input->post("item_id");
        $this->data['item_id'] = $item_id;
        $business_id = $this->session->userdata("business_id");
        $query = "SELECT * FROM all_items WHERE item_id = '" . $item_id . "'
        AND business_id = '" . $business_id . "'";
        $this->data["items"] = $this->db->query($query)->result();
        $this->data["suppliers"] = $this->item_model->getList("suppliers", "supplier_id", "supplier_name", "`suppliers`.`status` IN (1)");

        $query = "SELECT inventory.*, items.name, users.userName FROM inventory, items, users 
                  WHERE inventory.item_id = items.item_id
                  AND inventory.created_by = users.user_id
                  AND inventory.item_id = '" . $item_id . "'
                  ORDER BY inventory.inventory_id DESC";
        $this->data['inventories'] = $this->db->query($query)->result();
        $this->data["title"] = $this->lang->line('Item Details');





        $this->load->view("items/item_detail", $this->data);
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
                                          `supplier_id`,
                                          `supplier_invoice_id`, 
                                          `batch_number`, 
                                          `item_cost_price`, 
                                          `item_unit_price`, 
                                          `transaction_type`, 
                                          `inventory_transaction`,
                                          `expiry_date`,`created_by`) 
                            VALUES ('" . $item_id . "', 
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
        $query = "
        UPDATE `items` SET `cost_price` = '" . $cost_price . "',  
        `unit_price` = '" . $unit_price . "'
        WHERE `items`.`item_id` ='" . $item_id . "'";
        $this->db->query($query);
        $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
        redirect("items/view");
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
                $query = "
                UPDATE `items` SET `cost_price` = '" . $cost_price . "',  
                `unit_price` = '" . $unit_price . "'
                WHERE `items`.`item_id` ='" . $item_id . "'";
                $this->db->query($query);
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

        redirect("items/view/");
    }


    public function unique_bar_code()
    {

        $item_code_no = $this->input->post('item_code_no');
        if ($item_code_no != "") {
            if ($this->input->post("item_id")) {
                $item_id = (int) $this->input->post("item_id");
                $query = "select count(*)  as total from items where item_code_no='" . $item_code_no . "'
            and item_id!='" . $item_id . "'";
            } else {
                $query = "select count(*) as total from items where item_code_no='" . $item_code_no . "'";
            }

            $check = $this->db->query($query)->result();

            // var_dump($check);

            if ($check[0]->total > 0) {

                $this->form_validation->set_message('unique_bar_code', 'The Barcode  " ' . $item_code_no . ' " is already assigned to another item.');
                return FALSE;
            }
            return TRUE;
        } else {
            return TRUE;
        }
    }


    public function get_item_form()
    {
        $item_id = (int) $this->input->post("item_id");
        if ($item_id == 0) {

            $input = $this->get_inputs();
        } else {
            $query = "SELECT * FROM 
            items 
            WHERE item_id = $item_id";
            $input = $this->db->query($query)->row();
        }
        $this->data["input"] = $input;
        $this->load->view("items/get_item_form", $this->data);
    }

    private function get_inputs()
    {
        $input["item_id"] = $this->input->post("item_id");

        $input["name"] = $this->input->post("name");
        $input["item_code_no"] = $this->input->post("item_code_no");
        $input["category"] = $this->input->post("category");
        $input["description"] = $this->input->post("description");
        $input["cost_price"] = $this->input->post("cost_price");
        $input["unit_price"] = $this->input->post("unit_price");
        $input["discount"] = $this->input->post("discount");
        $input["unit"] = $this->input->post("unit");
        $input["record_level"] = $this->input->post("record_level");
        $input["location"] = $this->input->post("location");
        $inputs =  (object) $input;
        return $inputs;
    }


    public function add_item()
    {
        $business_id = $this->session->userdata("business_id");
        $created_by = $this->session->userdata("user_id");
        $item_id = (int) $this->input->post("item_id");
        $supplier_id = 0;
        $query = "SELECT supplier_id, count(*) as total FROM `suppliers` WHERE business_id = ? LIMIT 1";
        $result = $this->db->query($query, [$business_id])->row();
        if ($result->total == 0) {
            echo "need to add supplier";
            // Create new supplier for opening stock
            $supplier_data = [
                'business_id' => $business_id,
                'supplier_name' => 'Opening Stock',
                'supplier_contact_no' => '0000000000000',
                'company_name' => 'Opening Stock',
                'account_number' => NULL
            ];
            $this->db->insert('suppliers', $supplier_data);
            $supplier_id = $this->db->insert_id();
        } else {
            $supplier_id = $result->supplier_id;
        }

        $supplier_invoice_id = 0;
        // Optionally get the latest invoice if needed
        $query = "SELECT supplier_invoice_id, count(*) as total FROM `suppliers_invoices` 
                    WHERE supplier_id = ? and business_id = ? ORDER BY invoice_date DESC LIMIT 1";
        $invoice_result = $this->db->query($query, [$supplier_id, $business_id])->row();

        if ($invoice_result->total == 0) {
            $invoice_data = [
                'business_id' => $business_id,
                'supplier_invoice_number' => '1',
                'supplier_id' => $supplier_id,
                'return_receipt' => 1,
                'created_by' => $created_by,
                'invoice_date' => date('Y-m-d')
            ];

            $this->db->insert('suppliers_invoices', $invoice_data);
            $supplier_invoice_id = $this->db->insert_id();
        } else {
            $supplier_invoice_id = $invoice_result->supplier_invoice_id;
        }



        //$this->form_validation->set_rules("business_id", "Business Id", "required");
        $this->form_validation->set_rules("name", "Name", "required");
        // $this->form_validation->set_rules("item_code_no", "Item Code No", "required");
        $this->form_validation->set_rules("category", "Category", "required");
        //$this->form_validation->set_rules("description", "Description", "required");
        $this->form_validation->set_rules("cost_price", "Cost Price", "required");
        $this->form_validation->set_rules("unit_price", "Unit Price", "required");
        //$this->form_validation->set_rules("discount", "Discount", "required");
        //$this->form_validation->set_rules("unit", "Unit", "required");
        //$this->form_validation->set_rules("record_level", "Reorder Level", "required");
        //$this->form_validation->set_rules("location", "Location", "required");

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {

            if ($item_id == 0) {
                $query = "SELECT COUNT(*) as total FROM items WHERE items.name = ? and business_id = ?";
                $item_name = $this->db->query($query, [$this->input->post('name'), $business_id])->row();
                if ($item_name->total > 0) {
                    echo "Item Name Duplicate. Try with other name.";
                    exit();
                }



                if ($this->input->post("stock")) {
                    $stock = $this->input->post("stock");
                } else {
                    $stock = 0;
                }
                $date = date('Y-m-d', time());
                $inputs = $this->get_inputs();
                $inputs->created_by = $this->session->userdata("user_id");
                $inputs->business_id = $this->session->userdata("business_id");
                $inputs->discount = 0;
                $inputs->record_level = 5;
                $inputs->location = NULL;
                $this->db->insert("items", $inputs);
                $item_id = $this->db->insert_id();

                if ($supplier_id != 0 and $supplier_invoice_id != 0 and $item_id != 0 and $stock != 0) {
                    //update item enventory after first time add 
                    $query = "INSERT INTO `inventory`(`business_id`, `item_id`, `supplier_id`, `supplier_invoice_id`, `item_cost_price`, `item_unit_price`, `transaction_type`, `inventory_transaction`,`created_by`, `expiry_date`) 
                            VALUES ('" . $business_id . "', '" . $item_id . "', '" . $supplier_id . "', '" . $supplier_invoice_id . "', '" . $inputs->cost_price . "', '" . $inputs->unit_price . "', 'Item Created','" . $stock . "','" . $created_by . "', '" . $date . "')";
                    $this->db->query($query);
                }
                $this->db->where("item_id", $item_id);
                $item_code['item_code_no'] = $business_id . "" . $item_id;
                $this->db->update("items", $item_code);
                echo 'success';
            } else {
                $query = "SELECT COUNT(*) as total FROM items WHERE items.name = ? and business_id = ?
                AND items.item_id != ?  ";
                $item_name = $this->db->query($query, [$this->input->post('name'), $business_id, $item_id])->row();
                if ($item_name->total > 0) {
                    echo "Item Name Duplicate. Try with other name.";
                    exit();
                }
                $inputs = $this->get_inputs();
                $this->db->where("item_id", $item_id);
                $this->db->where("business_id", $this->session->userdata("business_id"));
                $inputs->last_updated = date('Y-m-d H:i:s');
                $this->db->update("items", $inputs);

                echo 'success';
            }
        }
    }

    public function validate_form_data($operation = false)
    {

        $business_id = $this->session->userdata("business_id");

        // Add custom validation rule for duplicate item name
        $this->form_validation->set_rules('name', 'Name', [
            'required',
            // Add callback to check for duplicate name
            function ($value) use ($business_id) {
                $query = "SELECT COUNT(*) as total FROM items WHERE items.name = ? AND items.business_id = ?";
                $result = $this->db->query($query, [$value, $business_id])->row();

                if ($result->total > 0) {
                    $this->form_validation->set_message('name', 'Duplicate Item Name. Try Again with different name');
                    return FALSE;
                }
                return TRUE;
            }
        ]);


        $validation_config = array(

            array(
                "field"  =>  "name",
                "label"  =>  "Name",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "category",
                "label"  =>  "Category",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "cost_price",
                "label"  =>  "Cost Price",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "unit_price",
                "label"  =>  "Unit Price",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "record_level",
                "label"  =>  "Reorder Level",
                "rules"  =>  "required"
            ),
            array(
                "field"  =>  "description",
                "label"  =>  "Discription",
                "rules"  =>  ""
            ),
            array(
                "field"  =>  "unit",
                "label"  =>  "Unit",
                "rules"  =>  ""
            ),
            array(
                "field"  =>  "location",
                "label"  =>  "Location",
                "rules"  =>  ""
            ),


        );
        //if ($operation) {
        $validation_config[] = array(
            "field"  =>  "item_code_no",
            "label"  =>  "Item Code No",
            "rules"  =>  "callback_unique_bar_code"
        );
        // }
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        return $this->form_validation->run();
    }
}
