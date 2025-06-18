<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sale_point extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		$this->load->model("supplier_model");
		//$this->lang->load("suppliers", 'english');
		$this->lang->load("system", 'english');
		$this->load->model("item_model");
		//$this->lang->load("items", 'english');
		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------


	/**
	 * Default action to be called
	 */
	public function index()
	{
		$business_id = $this->session->userdata("business_id");
		$query = "SELECT `name`, `item_code_no` FROM all_items WHERE `status` IN (1) 
		AND business_id = '" . $business_id . "'";
		$this->data['sale_items'] = $this->db->query($query)->result();
		//var_dump($this->data['sale_items']);
		$this->data["view"] = "sale_point/home";
		$this->data["user_items_list"] = $this->get_user_items_list();
		$this->data["items_sale_summary"] = $this->items_sale_summary();

		$this->load->view("layout", $this->data);
	}

	public function  print_stock_report()
	{
		$query = "SELECT * FROM all_items WHERE `status` IN (0, 1)";
		$this->data["items"] = $this->db->query($query)->result();

		$this->load->view("sale_point/print_stock_report", $this->data);
	}



	public function get_sale_reports()
	{
		$query = "SELECT SUM(items_total_price) as items_price, 
                     SUM(total_tax_pay_able) as total_tax, 
                     SUM(discount) as discount, 
                     SUM(`total_payable`) as total_sale 
                     FROM `sales` 
                     WHERE 
					 business_id = '" . $this->session->userdata("business_id") . "'
					 AND DATE(created_date) = DATE(NOW())";
		$today_sale_summary = $this->db->query($query);
		if ($today_sale_summary) {
			$this->data['today_sale_summary'] = $today_sale_summary->row();
		}


		$query = "SELECT SUM(items_total_price) as items_price, 
                     SUM(total_tax_pay_able) as total_tax, 
                     SUM(discount) as discount, 
                     SUM(`total_payable`) as total_sale 
                     FROM `sales` 
                     WHERE 
					 business_id = '" . $this->session->userdata("business_id") . "'
					 AND MONTH(created_date) = MONTH(NOW())
					 AND YEAR(created_date) = YEAR(NOW())";
		$current_month_sale_summary = $this->db->query($query);
		if ($current_month_sale_summary) {
			$this->data['current_month_sale_summary'] = $current_month_sale_summary->row();
		}

		$query = "SELECT 
		SUM(quantity * sale_price) AS total_sale,
		SUM(quantity * (sale_price - cost_price)) AS total_profit
		FROM 
		sales_items
		WHERE 
		business_id = '" . $this->session->userdata("business_id") . "'
		AND DATE(created_date) = CURDATE();
		";
		$this->data['today_sale_profit'] = $this->db->query($query)->row();



		$query = "SELECT 
		SUM(quantity * sale_price) AS total_sale,
		SUM(quantity * (sale_price - cost_price)) AS total_profit
		FROM 
		sales_items
		WHERE 
		business_id = '" . $this->session->userdata("business_id") . "'
		 AND MONTH(created_date) = MONTH(NOW())
		AND YEAR(created_date) = YEAR(NOW())";
		$this->data['current_month_sale_profit'] = $this->db->query($query)->row();

		$this->load->view("sale_point/sale_reports", $this->data);
	}

	public function receipt_list()
	{

		$search = $this->db->escape($this->input->post("search"));

		$query = "SELECT * FROM `sales` WHERE `sales`.sale_id = " . $search . "";
		if ($this->db->query($query)->result()) {
			echo "<h4>Search Result</h4>";
			$this->data['sales'] = $this->db->query($query)->result();
			$this->load->view("sale_point/receipt_lists", $this->data);
		} else {
			echo '<div id="error_message_sale" class="alert alert-danger" role="alert">
      <strong style="color:white">Search not found. try again</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>';
		}
	}

	public function get_search_item()
	{
		$search_item = $this->db->escape($this->input->post("search_item"));
		$query = "SELECT `item_id`, `total_quantity`, `name`, `cost_price`, `unit_price`, `discount`, `sale_price`  FROM all_items 
                  WHERE (`name` = " . $search_item . " OR `item_code_no` = " . $search_item . ")";

		if ($this->db->query($query)->result()) {

			if ($this->db->query($query)->result()[0]->total_quantity > 0 or 1 == 1) {

				$item_id = $this->db->query($query)->result()[0]->item_id;
				$item_detail = $this->db->query($query)->result()[0];
				$user_id = $this->session->userdata("user_id");
				$business_id = $this->session->userdata("business_id");

				$query = "SELECT SUM(`quantity`) as total FROM `sales_item_users` 
                      WHERE `item_id`='" . $item_id . "'
                      AND `user_id` = '" . $user_id . "'
					  AND `business_id` = '" . $business_id . "'";
				$item_count =  $this->db->query($query)->result()[0]->total;

				if ($item_count < 1) {
					$query = "INSERT INTO `sales_item_users`(`item_id`, `business_id`, `cost_price`, `unit_price`, `discount`, `sale_price`, `quantity`, `user_id`) 
                          VALUES ('" . $item_id . "', '" . $business_id . "', '" . $item_detail->cost_price . "', '" . $item_detail->unit_price . "', 
                                  '" . $item_detail->discount . "', '" . ($item_detail->sale_price) . "', '1','" . $user_id . "')";
					$this->db->query($query);
				} else {
					$item_count++;
					$query = "UPDATE `sales_item_users` 
                          SET `quantity`='" . $item_count . "' 
                          WHERE `item_id`='" . $item_id . "'
                          AND `user_id` = '" . $user_id . "'
						  AND `business_id` = '" . $business_id . "'
						  AND dated = '" . date('Y-m-d H:i:s') . "'";
					$this->db->query($query);
				}
			} else {
				echo '
        <div id="error_message_sale" class="alert alert-danger" role="alert">
    <strong style="color:white"> <i>' . $search_item . '</i></strong> Out of Stock.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
			}
		} else {
			echo '
      <div id="error_message_sale" class="alert alert-danger" role="alert">
  <strong style="color:white"> <i>' . $search_item . '</i> Item Not Found!</strong> Try again with different name.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
		}

		echo $this->get_user_items_list();
	}

	function get_user_items()
	{
		$user_id = $this->session->userdata("user_id");
		$business_id = $this->session->userdata("business_id");
		$query = "SELECT `id`,
            LOWER(`all_items`.`name`) AS `name`,
            LOWER(`all_items`.`category`) AS `category`,
            `sales_item_users`.`unit_price`,
            `sales_item_users`.`cost_price`,
            `sales_item_users`.`discount`,
            `sales_item_users`.`sale_price`,
            `all_items`.`total_quantity`,
            `sales_item_users`.`quantity`, 
            `sales_item_users`.`item_id`,
            `sales_item_users`.`user_id`,
			`all_items`.`item_code_no`,
            (`sales_item_users`.`sale_price`*`sales_item_users`.`quantity`) as `total_price`  
          FROM
            `all_items`,
            `sales_item_users` 
          WHERE `all_items`.`item_id` = `sales_item_users`.`item_id`
          AND  `sales_item_users`.`user_id` = '" . $user_id . "'
		  
		  AND `sales_item_users`.`business_id` = '" . $business_id . "'
		  ORDER BY `sales_item_users`.`dated` DESC
		  ";
		//AND `all_items`.`business_id` = '" . $business_id . "'
		return $this->db->query($query)->result();
	}
	function get_user_items_list()
	{
		$sales_items_user_lists = $this->get_user_items();

		$user_item_list = '<table class="table table2 table-striped" style="font-size:10px">';
		$user_item_list .= '<tr>
                <th>#</th>
                <th>Stock</th>
				 <th>Code</th>
                <th>Name</th>
                
                <th>Price</th>
                <th>Discount</th>
                <th>Sale Price</th>
                <th >Quantity</th>
                <th>Total</th>
              </tr>';
		$count = 1;
		foreach ($sales_items_user_lists as $sales_items_user_list) {
			$user_item_list .= '<tr><td>' . $count++ . '</td>';
			if ($sales_items_user_list->total_quantity >= 0) {
				$user_item_list .= '<th>' . $sales_items_user_list->total_quantity . '</th>';
			} else {
				$user_item_list .= '<td style="color:red">' . $sales_items_user_list->total_quantity . '</td>';
			}

			$user_item_list .= '
			<th>' . ucwords($sales_items_user_list->name) . '</th>
			<th>' . $sales_items_user_list->item_code_no . '</th>
                   
                    <th><input min="' . $sales_items_user_list->cost_price . '" id="user_item_unit_price_' . $sales_items_user_list->id . '" enterkeyhint="go"  onkeydown="update_user_item_unit_price(\'' . $sales_items_user_list->id . '\')" type="number" name="unit_price" value="' . $sales_items_user_list->unit_price . '" style="width:60px" /></th>
					</th>
                    <th>
                    <input min="' . $sales_items_user_list->unit_price . '" id="user_item_discount_' . $sales_items_user_list->id . '" enterkeyhint="go"  onkeydown="update_user_item_discount(\'' . $sales_items_user_list->id . '\')" type="number" name="discount" value="' . $sales_items_user_list->discount . '" style="width:60px" /></th>
                   
                    <th>' . $sales_items_user_list->sale_price . '</th>
                    <th><input id="user_item_' . $sales_items_user_list->id . '" enterkeyhint="go"  onkeydown="update_user_item_quantity(\'' . $sales_items_user_list->id . '\')" type="number" name="quantity" value="' . $sales_items_user_list->quantity . '" style="width:60px" /></th>
                    <th>' . $sales_items_user_list->total_price . '</th>

                  </tr>';
		}
		return $user_item_list .= '</table>';
	}

	public function items_sale_summary()
	{
		$user_id = $this->session->userdata("user_id");
		$business_id = $this->session->userdata("business_id");
		// Fetch user sale summary
		$sales_items_summary = $this->db
			->where('business_id', $business_id)
			->where('user_id', $user_id)
			->get('user_sale_summary')
			->row();

		if (!$sales_items_summary) {
			$sales_items_summary = (object) [
				'items_total' => "0.00",
				'total_discount' => "0.00",
				'total_price' => "0.00",
				'total_tax_pay_able' => "0.00",
				'pay_able' => "0.00"
			];
		}

		// Fetch taxes
		$taxes = $this->db->where('status', 1)->get('taxes')->result();
		$tax_ids = implode(',', array_column($taxes, 'tax_id'));

		// Build HTML summary
		$sale_summary = '';


		foreach ($taxes as $tax) {
			$sale_summary .= '<p>' . $tax->name . ' - ' . round($tax->tax_percentage, 2) . '% - ' . (($sales_items_summary->total_price * $tax->tax_percentage) / 100) . '</p>';
		}
		$sale_summary .= '
<div class="table-responsive" style="margin-top: 5px;">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Item Total</th>
                <th>Discount</th>
                <th>Total</th>
				 <th>Tax</th>
                <th>Total Payable</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>' . $sales_items_summary->total_price . '</td>
                <td>' . $sales_items_summary->total_discount . '</td>
                <td>' . $sales_items_summary->items_total . '</td>
				 <td>' . $sales_items_summary->total_tax_pay_able . '</td>
                <td>' . $sales_items_summary->pay_able . '
				 <input type="hidden" name="tax_ids" id="tax_ids" value="' . $tax_ids . '" />
                    <input type="hidden" name="pay_able_total" id="pay_able_total" value="' . $sales_items_summary->pay_able . '" />
                </td>
				</tr>
        </tbody>
    </table>
</div>';


		return $sale_summary;
	}


	function user_items_sale_summary()
	{
		echo $this->items_sale_summary();
	}

	public function update_user_item_quantity()
	{
		$id = (int) $this->input->post("user_item_id");

		$quantity = (int) $this->input->post("item_quantity");
		if ($quantity == 0) {
			$query = "DELETE FROM `sales_item_users` 
            WHERE id='" . $id . "'";
			$this->db->query($query);
		} else {
			$query = "SELECT
                `sales_item_users`.`quantity`
                , `all_items`.`total_quantity`,
                 `all_items`.`name`, 
                 `all_items`.`category`
            FROM `all_items`,
            `sales_item_users`
            WHERE `all_items`.`item_id` = `sales_item_users`.`item_id`
            AND `sales_item_users`.`id` ='" . $id . "'";
			$item = $this->db->query($query)->result()[0];

			$query = "SELECT `quantity` FROM `sales_item_users` WHERE id='" . $id . "'";

			$item_session = $this->db->query($query)->result()[0]->quantity;

			if (($item->total_quantity + $item_session) >= $quantity or 1 == 1) {
				$query = "UPDATE `sales_item_users` SET `quantity`='" . $quantity . "',  dated = '" . date('Y-m-d H:i:s') . "'
        WHERE id='" . $id . "' ";
				$this->db->query($query);
			} else {
				echo '
        <div id="error_message_sale" class="alert alert-danger" role="alert">
          <strong style="color:white"> <i>" ' . $item->name . ' "</i> only ' . $item->total_quantity . ' left in stock. try with ' . $item->total_quantity . '</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
			}
		}

		echo $this->get_user_items_list();
	}

	public function update_user_item_discount()
	{
		$id = (int) $this->input->post("user_item_id");
		$query = "select item_id from sales_item_users where id='" . $id . "'";
		$item_id = $this->db->query($query)->result()[0]->item_id;
		$query = "select sale_price from all_items where item_id='" . $item_id . "'";
		$sale_price = $this->db->query($query)->result()[0]->sale_price;
		$discount = (float) $this->input->post("item_discount");


		$query = "UPDATE `sales_item_users` SET `discount`='" . $discount . "',
		`sale_price`='" . ($sale_price - $discount) . "'
			WHERE id='" . $id . "' ";
		$this->db->query($query);


		echo $this->get_user_items_list();
	}

	public function update_user_item_unit_price()
	{
		$user_item_id = (int) $this->input->post("user_item_id");
		$unit_price = $this->input->post("unit_price");
		$query = "select * from sales_item_users where id='" . $user_item_id . "'";
		$sales_item_users = $this->db->query($query)->row();
		$input['unit_price'] =  $unit_price;
		$input['discount'] =  $sales_item_users->discount;
		$input['sale_price'] = $unit_price - $sales_item_users->discount;
		$this->db->where('id', $user_item_id);
		$this->db->update('sales_item_users', $input);
		echo $this->get_user_items_list();
	}

	public function add_sale_data()
	{

		$payment_type = $this->input->post('payment_type');
		$remarks = $this->input->post('remarks');
		$discount = $this->input->post('discount');
		$cash_amount = $this->input->post('cash_amount');
		$customer_name = $this->input->post('customer_name');
		$customer_mobile_no = $this->input->post('customer_mobile_no');
		$pay_able_total = $this->input->post('pay_able_total');
		$cash_back = $this->input->post('cash_back');
		$tax_ids = $this->input->post('tax_ids');
		$business_id = $this->session->userdata("business_id");
		$user_id = $this->session->userdata("user_id");
		$query = "SELECT * FROM `user_sale_summary` as `uss`
                  WHERE `uss`.`user_id` = '" . $user_id . "'
				  AND uss.business_id = '" . $business_id . "'";
		$sales_items_summary = $this->db->query($query)->row();
		if ($sales_items_summary) {

			$query = "INSERT INTO `sales`(
			`business_id`,
			`customer_mobile_no`, 
                                      `customer_name`, 
                                      `items_price`, 
                                      `items_discounts`, 
                                      `items_total_price`, 
                                      `total_tax_pay_able`, 
                                      `items_total_price_including_tax`, 
                                      `discount`, 
                                      `total_payable`, 
                                      `cash_amount`,
                                      `cash_back`,
                                      `payment_type`, 
                                      `remarks`,
                                      `created_by`) 
                             VALUES (
							 '" . $business_id . "',
							 '" . $customer_mobile_no . "',
                                     '" . $customer_name . "',
                                     '" . $sales_items_summary->items_total . "',
                                     '" . $sales_items_summary->total_discount . "',
                                     '" . $sales_items_summary->total_price . "',
                                     '" . $sales_items_summary->tax_total_percentage . "',
                                     '" . $sales_items_summary->pay_able . "',
                                     '" . $discount . "',
                                     '" . $pay_able_total . "',
                                     '" . $cash_amount . "',
                                     '" . $cash_back . "',
                                     '" . $payment_type . "',
                                     '" . $remarks . "',
                                     '" . $user_id . "'
                                            )";
			$this->db->query($query);
			$sale_id = $this->db->insert_id();
			if ($sale_id) {
				$sales_items_user_lists = $this->get_user_items();
				foreach ($sales_items_user_lists as $sales_items_user_list) {
					$query = "INSERT INTO `sales_items`(
					`business_id`,
					`sale_id`, 
                                              `item_id`, 
                                              `item_name`, 
                                              `cost_price`, 
                                              `unit_price`, 
                                              `item_discount`,
                                              `sale_items`,  
                                              `quantity`, 
                                              `sale_price`, 
                                              `total_price`, 
                                              `created_by`
                                              ) 
                                     VALUES (
									 '" . $business_id . "',
									 '" . $sale_id . "',
                                             '" . $sales_items_user_list->item_id . "',
                                             '" . $sales_items_user_list->name . "',
                                             '" . $sales_items_user_list->cost_price . "',
                                             '" . $sales_items_user_list->unit_price . "',
                                             '" . $sales_items_user_list->discount . "',
                                             '" . $sales_items_user_list->quantity . "',
                                             '" . $sales_items_user_list->quantity . "',
                                             '" . $sales_items_user_list->sale_price . "',
                                             '" . $sales_items_user_list->total_price . "',
                                             '" . $user_id . "' 
                                              )";
					$this->db->query($query);
				}

				if ($tax_ids) {
					$query = "SELECT * FROM taxes WHERE `status`=1 
					AND business_id = '" . $business_id . "'
					AND tax_id IN(" . trim($tax_ids, ',') . ")";
					$taxes = $this->db->query($query)->result();
					foreach ($taxes as $tax) {
						$query = "INSERT INTO `sale_taxes` (`business_id`,`sale_id`, `tax_id`, `tax_name`, `tax_percentage`)
                              VALUES (
							  '" . $business_id . "',
							  '" . $sale_id . "', 
                                      '" . $tax->tax_id . "',
                                      '" . $tax->name . "',
                                      '" . $tax->tax_percentage . "' )";
						$this->db->query($query);
					}
				}
			}
			$query = "DELETE FROM `sales_item_users` 
				WHERE `user_id` = '" . $user_id . "' 
				AND business_id = '" . $business_id . "'
				";
			$this->db->query($query);
			echo 'success';
			//$this->print_receipt($sale_id);
		}
	}

	function print_receipt($sale_id)
	{

		$sale_id = (int) $sale_id;
		$business_id = $this->session->userdata("business_id");
		$query = "SELECT `sales`.*, `users`.`userName` FROM `sales`,`users`  
              WHERE `sales`.`created_by` = `users`.`user_id`
              AND `sale_id` = '" . $sale_id . "'
			  AND sales.business_id = '" . $business_id . "'";
		$this->data['sale'] = $this->db->query($query)->result();
		if (!$this->data['sale']) {
			echo "Receipt ID Not Found.";
			exit();
		} else {
			$this->data['sale'] = $this->db->query($query)->result()[0];
		}
		$query = "SELECT * FROM `sales_items` 
              WHERE `sale_id` = '" . $sale_id . "'
			  AND business_id = '" . $business_id . "'";
		$this->data['sale_items'] = $this->db->query($query)->result();
		$query = "SELECT * FROM `sale_taxes` 
              WHERE `sale_id` = '" . $sale_id . "'
			  AND sale_taxes.business_id = '" . $business_id . "'";
		$this->data['sale_taxes'] = $this->db->query($query)->result();
		$this->load->view("sale_point/print_recepit", $this->data);
	}

	public function get_sale_receipts()
	{
		$this->data['tital'] = 'Return Item Form';
		$query = "SELECT * FROM `sales` WHERE DATE(created_date) = DATE(NOW()) ORDER BY sale_id DESC";
		$this->data['sales'] = $this->db->query($query)->result();

		$this->load->view("sale_point/get_sale_receipts", $this->data);
	}

	public function search_by_receipt_no()
	{
		$sale_id  = (int) $this->input->post('receipt_no');

		$query = "SELECT `sales`.*, `users`.`userName` FROM `sales`,`users`  
              WHERE `sales`.`created_by` = `users`.`user_id`
              AND `sale_id` = '" . $sale_id . "'";
		$this->data['sale'] = $this->db->query($query)->result();
		if (!$this->data['sale']) {
			echo "Receipt ID Not Found.";
			exit();
		} else {
			$this->data['sale'] = $this->db->query($query)->result()[0];
		}
		$query = "SELECT * FROM `sales_items` 
              WHERE `sale_id` = '" . $sale_id . "'";
		$this->data['sale_items'] = $this->db->query($query)->result();
		$query = "SELECT * FROM `sale_taxes` 
              WHERE `sale_id` = '" . $sale_id . "'";
		$this->data['sale_taxes'] = $this->db->query($query)->result();
		$this->load->view("sale_point/return_items", $this->data);
	}

	public function return_sale_item()
	{

		$sale_item_id  = (int) $this->input->post('sale_item_id');
		$total_items_returns  = (int) $this->input->post('total_items_returns');

		$query = "SELECT * FROM `sales_items` 
              WHERE `sale_item_id` = '" . $sale_item_id . "'";
		if ($this->db->query($query)->result()) {
			$sale_item = $this->db->query($query)->result()[0];
			if ($total_items_returns <= $sale_item->sale_items) {

				$quantity = $sale_item->sale_items - $total_items_returns;
				$total_price = $quantity * $sale_item->sale_price;
				$query = "UPDATE `sales_items` 
                          SET `return_items` = '" . $total_items_returns . "',
                          `quantity` = '" . $quantity . "',
                          `total_price` = '" . $total_price . "'
                          WHERE `sale_item_id` = '" . $sale_item_id . "'";
				if ($this->db->query($query)) {

					$query = "SELECT 
          `sales_items`.`sale_id` AS `sale_id`,
          SUM(
            `all_items`.`unit_price` * `sales_items`.`quantity`
          ) AS `items_total`,
          SUM(
            `all_items`.`unit_price` * `sales_items`.`quantity`
          ) - SUM(
            `all_items`.`sale_price` * `sales_items`.`quantity`
          ) AS `total_discount`,
          SUM(
            `all_items`.`sale_price` * `sales_items`.`quantity`
          ) AS `total_price`,
          IF(
            (SELECT 
              SUM(
                `taxes`.`tax_percentage`
              ) 
            FROM
              `taxes` 
            WHERE `taxes`.`status` = 1) IS NULL,
            0,
            (SELECT 
              SUM(
                `taxes`.`tax_percentage`
              ) 
            FROM
              `taxes` 
            WHERE `taxes`.`status` = 1)
          ) AS `tax_total_percentage`,
          ROUND(
            IF(
              (SELECT 
                SUM(
                  `taxes`.`tax_percentage`
                ) 
              FROM
                `taxes` 
              WHERE `taxes`.`status` = 1) IS NULL,
              0,
              (SELECT 
                SUM(
                  `taxes`.`tax_percentage`
                ) 
              FROM
                `taxes` 
              WHERE `taxes`.`status` = 1)
            ) * SUM(
              `all_items`.`sale_price` * `sales_items`.`quantity`
            ) / 100,
            2
          ) AS `total_tax_pay_able`,
          ROUND(
            IF(
              (SELECT 
                SUM(
                  `taxes`.`tax_percentage`
                ) 
              FROM
                `taxes` 
              WHERE `taxes`.`status` = 1) IS NULL,
              0,
              (SELECT 
                SUM(
                  `taxes`.`tax_percentage`
                ) 
              FROM
                `taxes` 
              WHERE `taxes`.`status` = 1)
            ) * SUM(
              `all_items`.`sale_price` * `sales_items`.`quantity`
            ) / 100,
            2
          ) + SUM(
            `all_items`.`sale_price` * `sales_items`.`quantity`
          ) AS `pay_able` 
        FROM
          (
            `all_items` 
            JOIN `sales_items`
          ) 
        WHERE `all_items`.`item_id` = `sales_items`.`item_id` 
        AND `sales_items`.`sale_id` = '" . $sale_item->sale_id . "'";
					$sales_items_summary = $this->db->query($query)->result()[0];


					$query = "UPDATE `sales` SET  `items_price` = '" . $sales_items_summary->items_total . "',
                                      `items_discounts` = '" . $sales_items_summary->total_discount . "',
                                      `items_total_price` = '" . $sales_items_summary->total_price . "',
                                      `total_tax_pay_able` =  '" . $sales_items_summary->tax_total_percentage . "',
                                      `items_total_price_including_tax` = '" . $sales_items_summary->pay_able . "'
                                      WHERE `sales`.`sale_id` = '" . $sale_item->sale_id . "'";
					$this->db->query($query);



					$_POST['receipt_no'] = $sale_item->sale_id;

					$this->search_by_receipt_no();
				}
			} else {
				echo "Sale Items are less than return items.";
			}
		} else {
			echo "Sale Item not found.";
		}
	}

	public function get_items_by_category()
	{
		$category = $this->input->post('category');

		// Add wildcard for LIKE if needed
		$like_category = '%' . $category . '%';
		$business_id = $this->session->userdata("business_id");
		$query = 'SELECT * FROM all_items WHERE category LIKE ? 
		AND business_id = ?
		AND status IN (1) ORDER BY `name` ASC';
		$category_items_list = $this->db->query($query, [$like_category, $business_id])->result();
		echo '<ul class="list-group">';
		foreach ($category_items_list as $item) {
			if ($item->total_stock < 1) {
				$stock = ' color:red; text-decoration: line-through; ';
			} else {
				$stock = '';
			}
			$item_name = htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');
			echo '<li class="list-group-item" style="' . $stock . '" onclick="addItems(\'' . $item_name . '\')">
            <strong>' . htmlspecialchars($item->item_code_no, ENT_QUOTES, 'UTF-8') . '</strong> - ' . $item_name . '
			- ' . $item->total_stock . '
          </li>';
		}
		echo '</ul>';
	}
}
