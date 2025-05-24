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
}
