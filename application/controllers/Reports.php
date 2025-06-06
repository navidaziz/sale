<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    // we are here

    /**
     * Default action to be called
     */
    public function index()
    {
        $this->data['title'] = 'Reports';
        $this->data['description'] = 'Report Dashboard';
        $this->data["view"] =  "reports/index";
        $this->load->view("layout", $this->data);
    }

    public function most_sale_items()
    {
        $this->data['title'] = 'Most Sale Items';
        $this->data['description'] = 'Analysis of Most Sale Items';
        $this->data["view"] =  "reports/sale/most_sale_items";
        $this->load->view("layout", $this->data);
    }

    public function most_sale_items_download()
    {
        // Define your query
        $query = "SELECT * FROM `most_sale_items`";
        // Execute the query
        $result = $this->db->query($query)->result_array();

        // Set CSV filename
        $filename = time() . 'most_sale_items_' . time() . '.csv';

        // Set headers to download the file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);

        // Open the output stream
        $output = fopen('php://output', 'w');

        // Write column headers
        if (!empty($result)) {
            // Get headers from the first row
            fputcsv($output, array_keys($result[0]));
            foreach ($result as $row) {
                fputcsv($output, $row);
            }
        }

        // Close the output stream
        fclose($output);
    }

    public function  items_sale_report()
    {
        $this->data['startdate'] = $this->input->get('start_date');
        $this->data['enddate'] = $this->input->get('end_date');
        $this->data['start_date'] = $start_date = $this->db->escape($this->input->get('start_date'));
        $this->data['end_date'] = $end_date = $this->db->escape($this->input->get('end_date'));
        $business_id = $this->session->userdata('business_id');

        $query = "SELECT si.item_name, 
                     si.cost_price, 
                     si.unit_price, 
                     si.item_discount, 
                     si.sale_price, 
                     SUM(si.sale_items) as qty, 
                     SUM(si.total_price) as 
                     net_total, 
                     si.returned, 
                     si.created_date
                     FROM `sales_items` as si 
                     WHERE DATE(`created_date`) BETWEEN " . $start_date . " and " . $end_date . " 
                     AND si.business_id = " . $business_id . "
                     GROUP BY `si`.`item_id`, si.sale_price, si.returned";
        $today_items_sale = $this->db->query($query);
        if ($today_items_sale) {
            $this->data['today_items_sales'] = $today_items_sale->result();
        }


        $query = "SELECT SUM(items_total_price) as items_price, 
                     SUM(total_tax_pay_able) as total_tax, 
                     SUM(discount) as discount, 
                     SUM(`total_payable`) as total_sale 
                     FROM `sales` 
                     WHERE DATE(`created_date`) BETWEEN " . $start_date . " and " . $end_date . "";
        $today_sale_summary = $this->db->query($query);
        if ($today_sale_summary) {
            $this->data['today_sale_summary'] = $today_sale_summary->result()[0];
        }

        $this->load->view("sale_point/items_sale_report", $this->data);
    }
    public function  day_wise_sale_report()
    {
        $this->data['startdate'] = $this->input->get('start_date');
        $this->data['enddate'] = $this->input->get('end_date');
        $this->data['start_date'] = $start_date = $this->db->escape($this->input->get('start_date'));
        $this->data['end_date'] = $end_date = $this->db->escape($this->input->get('end_date'));
        $business_id = $this->session->userdata('business_id');

        $query = "SELECT si.created_date,
                     SUM(si.cost_price*si.sale_items) as item_cost_total,
                     SUM(si.sale_price*si.sale_items) as item_sale_total
                     FROM `sales_items` as si 
                     WHERE DATE(`created_date`) BETWEEN " . $start_date . " and " . $end_date . "
                     AND si.business_id = " . $business_id . "
                     GROUP BY DATE(`created_date`)";
        $today_items_sale = $this->db->query($query);
        if ($today_items_sale) {
            $this->data['today_items_sales'] = $today_items_sale->result();
        }



        $this->load->view("sale_point/day_wise_sale_report", $this->data);
    }
}
