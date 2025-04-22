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

        $this->load->model("admin/water_user_association_model");
        //$this->output->enable_profiler(TRUE);
    }

    public function index()
    {

        $this->data["title"] = 'Reporting Dashbaord';
        $this->data["description"] = 'KP-IAIP  Reporting Dashbaord';
        $this->data["view"] = ADMIN_DIR . "reports/index";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }


    public function get_schemes_summary()
    {
        $scheme_status = $this->input->post('scheme_status');
        $this->data["scheme_status"] = $scheme_status . ' Schemes Summary';
        if ($scheme_status == 'Ongoing') {
            $this->load->view(ADMIN_DIR . "reports/schemes/get_ongoing_schemes_summary", $this->data);
        }
        if ($scheme_status == 'Completed') {
            $this->load->view(ADMIN_DIR . "reports/schemes/get_completed_schemes_summary", $this->data);
        }
    }

    public function schemes_summary_report()
    {
        $this->data["title"] = 'Schemes Dashboard';
        $this->data["description"] = 'Ongoing and Completed';
        $this->data["view"] = ADMIN_DIR . "reports/schemes/schemes_summary_report";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function completed_intervention_summary()
    {
        $this->data["title"] = 'Completed Schemes';
        $this->data["description"] = 'Completed Intervention Summary Report';
        $this->data["view"] = ADMIN_DIR . "reports/schemes/completed_intervention_summary";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function district_fy_wise_completed_schemes()
    {
        $this->data["title"] = 'Completed Schemes';
        $this->data["description"] = 'District and FY Wise Completed Schemes';
        $this->data["view"] = ADMIN_DIR . "reports/schemes/district_fy_wise_completed_schemes";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function get_district_categories_fy_avg()
    {
        $this->data['district_id'] = $district_id = $this->input->post('district_id');
        $this->data["title"] = 'AVG Cost';
        $query = "SELECT district_name FROM districts WHERE district_id = ?";
        $district = $this->db->query($query, [$district_id])->row();
        $this->data["description"] = 'District ' . $district->district_name . ' Categories and Financial Year Wise AVG Cost';
        $this->load->view(ADMIN_DIR . "reports/schemes/get_district_categories_fy_avg", $this->data);
    }

    public function category_fy_avg_cost()
    {

        $this->data["title"] = 'AVG Cost';
        $this->data["description"] = 'Category and Financial Year Wise AVG Cost';
        $this->data["view"] = ADMIN_DIR . "reports/schemes/category_fy_avg_cost";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function district_components_avg_cost()
    {

        $this->data["title"] = 'AVG Cost';
        $this->data["description"] = 'District Wise Components AVG Cost';
        $this->data["view"] = ADMIN_DIR . "reports/schemes/district_components_avg_cost";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function district_sub_components_avg_cost()
    {

        $this->data["title"] = 'AVG Cost';
        $this->data["description"] = 'District Wise Sub Components AVG Cost';
        $this->data["view"] = ADMIN_DIR . "reports/schemes/district_sub_components_avg_cost";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    public function district_categories_avg_cost()
    {

        $this->data["title"] = 'AVG Cost';
        $this->data["description"] = 'District Wise Categories AVG Cost';
        $this->data["view"] = ADMIN_DIR . "reports/schemes/district_categories_avg_cost";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }


    public function export_filter_expenses()
    {

        $this->data["title"] = 'Custom Financial Report';
        $this->data["description"] = 'Custom Financial With Different Filter Option';
        $this->data["view"] = ADMIN_DIR . "reports/export_filter_expenses";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function district_wise_taxes()
    {
        $this->data["title"] = 'District Wise Taxes';
        $this->data["description"] = 'District Wise Taxes';
        $this->data["view"] = ADMIN_DIR . "reports/district_wise_taxes";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function ledger($fy_id)
    {

        $this->data['fy_id'] = (int) $fy_id;
        $this->data["title"] = 'Ledger Report';
        $this->data["description"] = 'Financial Year Wise ledger';
        $this->data["view"] = ADMIN_DIR . "reports/ledger/ledger";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    public function ledger_combined()
    {
        $this->data["title"] = 'Ledger Report';
        $this->data["description"] = 'Financial Year Wise ledger';
        $this->data["view"] = ADMIN_DIR . "reports/ledger/ledger_combined";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }




    public function cc_q_f_targe_and_expense_report()
    {

        $this->data["title"] = 'Annual Budget and Expense';
        $this->data["description"] = 'Annual Budget and Expense Breakdown by Component Category';
        $this->data["view"] = ADMIN_DIR . "reports/chart_of_accounts/cc_q_f_targe_and_expense_report";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }



    public function fy_w_expense_summary()
    {

        $this->data["title"] = 'FY Wise Expense Summary';
        $this->data["description"] = 'Upto Now';
        $this->data["view"] = ADMIN_DIR . "reports/fund_utilization/fy_w_expense_summary";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    public function get_scheme_list()
    {
        $scheme_status = $this->input->post('scheme_status');
        $this->data["title"] = $scheme_status . ' Scheme List';
        $query = "SELECT * FROM scheme_lists WHERE scheme_status = ?";
        $this->data['schemes'] = $this->db->query($query, [$scheme_status])->result();
        $this->data["description"] = 'Scheme List';
        $this->load->view(ADMIN_DIR . "reports/schemes/get_scheme_list", $this->data);
    }

    public function print_scheme($scheme_id)
    {

        $scheme_id = (int) $scheme_id;
        $this->data["scheme_id"] = $scheme_id;
        $this->load->view(ADMIN_DIR . "expenses/print_scheme_detail", $this->data);
    }


    public function budget_u_summary()
    {

        $this->data["title"] = 'Receipts Vs Expenditures Summary';
        $this->data["description"] = 'Upto Now';
        $this->data["view"] = ADMIN_DIR . "reports/fund_utilization/budget_u_summary";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }


    public function f_released_by_wb()
    {

        $this->data["title"] = 'Funds Released By World Bank';
        $this->data["description"] = 'Upto Now';
        $this->data["view"] = ADMIN_DIR . "reports/fund_utilization/f_released_by_wb";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function f_released_by_fd()
    {

        $this->data["title"] = 'Funds Released By Finance Department';
        $this->data["description"] = 'Upto Now';
        $this->data["view"] = ADMIN_DIR . "reports/fund_utilization/f_released_by_fd";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function real_time_financial_proress_reprot()
    {

        $this->data["title"] = 'Financial Progress - Realtime';
        $this->data["description"] = 'Realtime Financial Progress Summary Report';
        $this->data["view"] = ADMIN_DIR . "reports/fund_utilization/real_time_financial_proress_reprot";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function financial_summary_report()
    {

        $this->data["title"] = 'Financial Reconciliation Summary Report';
        $this->data["description"] = 'Over All Financial Years';
        $this->data["view"] = ADMIN_DIR . "reports/fund_utilization/financial_summary_report";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }




    // public function region_district_wise_expense_report()
    // {
    //     $this->data["title"] = 'Region / District Wise Expense Report';
    //     $this->data["description"] = 'Filter By: ';
    //     $this->data['f_regions_array'] = NULL;
    //     $this->data['f_financial_years_array'] = NULL;
    //     $this->data['f_purpose_array'] = NULL;
    //     $purpose_query = '';
    //     if ($this->input->post('purpose')) {
    //         $this->data['f_purpose_array'] = $f_purpose = $this->input->post('purpose'); // Assuming regions is an array
    //         $pupose = implode("','", $f_purpose);
    //         $purpose_query = " AND e.purpose IN('$pupose') ";
    //     }

    //     $fy_query = '';
    //     if ($this->input->post('financial_years')) {
    //         $this->data['f_financial_years_array'] = $f_fy = $this->input->post('financial_years'); // Assuming regions is an array
    //         $ffy = implode("','", $f_fy);
    //         $fy_query = " AND e.financial_year IN('$ffy') ";
    //     }

    //     if ($this->input->post('regions')) {
    //         $this->data['f_regions_array'] = $f_regions = $this->input->post('regions'); // Assuming regions is an array
    //         $regions = implode("','", $f_regions); // Surround each region with quotes and comma separated
    //         $query = "SELECT region FROM districts WHERE region IN ('$regions') GROUP BY region";
    //     } else {
    //         $query = "SELECT region FROM districts GROUP BY region";
    //     }
    //     $regions = $this->db->query($query)->result();

    //     foreach ($regions as $region) {
    //         $query = "SELECT 
    //         COUNT(0) as total,
    //         SUM(gross_pay) as gross_pay,
    //         SUM(whit_tax) as whit_tax,
    //         SUM(whst_tax) as whst_tax,
    //         SUM(st_duty_tax) as st_duty_tax,
    //         SUM(rdp_tax) as rdp_tax,
    //         SUM(kpra_tax) as kpra_tax,
    //         SUM(misc_deduction) as misc_deduction,
    //         SUM(gross_pay) as gross_pay
    //         FROM expenses as e 
    //         INNER JOIN districts as d ON (d.district_id = e.district_id)
    //         WHERE d.region = '" . $region->region . "'
    //         " . $purpose_query . "
    //         " . $fy_query . " ";
    //         $region->expenses = $this->db->query($query)->row();
    //         //get district 
    //         $query = "SELECT district_name, 
    //         COUNT(0) as total,
    //         SUM(gross_pay) as gross_pay,
    //         SUM(whit_tax) as whit_tax,
    //         SUM(whst_tax) as whst_tax,
    //         SUM(st_duty_tax) as st_duty_tax,
    //         SUM(rdp_tax) as rdp_tax,
    //         SUM(kpra_tax) as kpra_tax,
    //         SUM(misc_deduction) as misc_deduction,
    //         SUM(gross_pay) as gross_pay
    //         FROM expenses as e 
    //         INNER JOIN districts as d ON (d.district_id = e.district_id)
    //         WHERE d.region = '" . $region->region . "'
    //         " . $purpose_query . "
    //         " . $fy_query . "
    //         GROUP BY d.district_id
    //         ORDER BY d.district_name";
    //         $region->districts = $this->db->query($query)->result();
    //     }
    //     $this->data['regions'] = $regions;
    //     $this->data["view"] = ADMIN_DIR . "reports/region_district_wise_expense_report";
    //     $this->load->view(ADMIN_DIR . "layout", $this->data);
    // }

    public function region_district_wise_expense_report()
    {
        $this->data["title"] = 'Region / District Wise Expense Report';
        $this->data["description"] = 'Filter By: ';
        $this->data['f_regions_array'] = NULL;
        $this->data['f_financial_years_array'] = NULL;
        $this->data['f_purpose_array'] = NULL;
        $this->data['f_start_date'] = NULL;
        $this->data['f_end_date'] = NULL;

        // Handling Purpose
        if ($this->input->post('purpose')) {
            $this->data['f_purpose_array'] = $this->input->post('purpose');
            $purpose_query = "AND e.purpose IN ('" . implode("','", $this->data['f_purpose_array']) . "') ";
        } else {
            $purpose_query = '';
        }




        //Hadling By Start and end date
        $fy_query = '';
        if ($this->input->post('start_date') and $this->input->post('end_date')) {
            $this->data['f_start_date'] = $start_date =  $this->input->post('start_date');
            $this->data['f_end_date'] = $end_date = $this->input->post('end_date');

            $fy_query = "AND e.date BETWEEN " . $this->db->escape($start_date) . " AND " . $this->db->escape($end_date);
        } else {
            // Handling Financial Years
            if ($this->input->post('financial_years')) {
                $this->data['f_financial_years_array'] = $this->input->post('financial_years');
                $fy_query = "AND e.financial_year IN ('" . implode("','", $this->data['f_financial_years_array']) . "') ";
            } else {
                $fy_query = '';
            }
        }


        // Handling Regions
        if ($this->input->post('regions')) {
            $this->data['f_regions_array'] = $this->input->post('regions');
            $regions = implode("','", $this->data['f_regions_array']);
            $query = "SELECT region FROM districts WHERE region IN ('$regions') GROUP BY region";
        } else {
            $query = "SELECT region FROM districts GROUP BY region";
        }

        $regions = $this->db->query($query)->result();

        foreach ($regions as $region) {
            $query = "SELECT 
            COUNT(0) as total,
            SUM(gross_pay) as gross_pay,
            SUM(whit_tax) as whit_tax,
            SUM(whst_tax) as whst_tax,
            SUM(st_duty_tax) as st_duty_tax,
            SUM(rdp_tax) as rdp_tax,
            SUM(kpra_tax) as kpra_tax,
            SUM(misc_deduction) as misc_deduction,
            SUM(net_pay) as net_pay
            FROM expenses as e 
            INNER JOIN districts as d ON (d.district_id = e.district_id)
            WHERE d.region = '" . $region->region . "'
            $purpose_query
            $fy_query";
            $region->expenses = $this->db->query($query)->row();



            $query = "SELECT * FROM districts as d WHERE d.region = '" . $region->region . "'";
            $districts = $this->db->query($query)->result();
            foreach ($districts as $district) {
                $query = "SELECT COUNT(0) as total,
            SUM(gross_pay) as gross_pay,
            SUM(whit_tax) as whit_tax,
            SUM(whst_tax) as whst_tax,
            SUM(st_duty_tax) as st_duty_tax,
            SUM(rdp_tax) as rdp_tax,
            SUM(kpra_tax) as kpra_tax,
            SUM(misc_deduction) as misc_deduction,
            SUM(net_pay) as net_pay
            FROM expenses as e 
            WHERE e.district_id = '" . $district->district_id . "'
            $purpose_query
            $fy_query";
                $district->expenses = $this->db->query($query)->row();
            }
            $region->districts = $districts;
        }

        $this->data['regions'] = $regions;
        $this->data["view"] = ADMIN_DIR . "reports/region_district_wise_expense_report";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    public function region_district_wise_component_expense_report()
    {
        $this->data["title"] = 'Region / District Components Wise Expense Report';
        $this->data["description"] = 'Filter By: ';
        $this->data['f_regions_array'] = NULL;
        $this->data['f_financial_years_array'] = NULL;
        $this->data['f_purpose_array'] = NULL;
        $this->data['f_start_date'] = NULL;
        $this->data['f_end_date'] = NULL;
        $purpose_query = '';
        $fy_query = '';

        // Get component categories
        $query = "SELECT component_category_id, category FROM component_categories";
        $this->data['component_categories'] = $component_categories = $this->db->query($query)->result();

        if ($this->input->post('regions')) {
            $regions = $this->input->post('regions');
            $placeholders = rtrim(str_repeat('?, ', count($regions)), ', '); // Prepare placeholders for parameterized query
            $query = "SELECT region FROM districts WHERE region IN ($placeholders) GROUP BY region";
            $regions = $this->db->query($query, $regions)->result();
        } else {
            $query = "SELECT region FROM districts GROUP BY region";
            $regions = $this->db->query($query)->result();
        }

        foreach ($regions as $region) {
            // Get component categories for the region
            $query = "SELECT component_category_id, category FROM component_categories";
            $component_categories = $this->db->query($query)->result();
            foreach ($component_categories as $component_category) {
                $query = "SELECT COUNT(0) as total,
            SUM(net_pay) as net_pay
            FROM expenses as e 
            INNER JOIN districts as d ON (d.district_id = e.district_id)
            WHERE d.region = ? 
            AND e.component_category_id = ?
            $purpose_query
            $fy_query";
                $expense_result = $this->db->query($query, array($region->region, $component_category->component_category_id))->row();
                $component_category->expenses = $expense_result;
            }
            $region->component_categories = $component_categories;

            // Get districts for the region
            $query = "SELECT * FROM districts as d WHERE d.region = ?";
            $districts = $this->db->query($query, $region->region)->result();
            foreach ($districts as $district) {
                // Get component categories for the district
                $query = "SELECT component_category_id, category FROM component_categories";
                $component_categories = $this->db->query($query)->result();
                foreach ($component_categories as $component_category) {
                    $query = "SELECT COUNT(0) as total,
                SUM(net_pay) as net_pay
                FROM expenses as e 
                WHERE e.component_category_id = ? 
                AND e.district_id = ?
                $purpose_query
                $fy_query";
                    $expense_result = $this->db->query($query, array($component_category->component_category_id, $district->district_id))->row();
                    $component_category->expenses = $expense_result;
                }
                $district->component_categories = $component_categories;
            }
            $region->districts = $districts;
        }

        $this->data['regions'] = $regions;


        $this->data["view"] = ADMIN_DIR . "reports/region_district_wise_component_expense_report";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function financial_statement()
    {
        $this->data["title"] = 'Financial Statement';
        $this->data["description"] = 'Filter By: ';
        $this->data['f_regions_array'] = NULL;
        $this->data['f_financial_years_array'] = NULL;
        $this->data['f_purpose_array'] = NULL;
        $this->data['f_start_date'] = NULL;
        $this->data['f_end_date'] = NULL;
        $purpose_query = '';
        $fy_query = '';

        // Fetch all financial years
        $query = "SELECT * FROM `financial_years`";
        $this->data['financial_years']  = $financial_years = $this->db->query($query)->result();

        // Fetch all components
        $query = "SELECT * FROM components";
        $components = $this->db->query($query)->result();

        foreach ($components as $component) {
            // Fetch component categories for the current component
            $query = "SELECT * FROM `component_categories` WHERE component_id = ?";
            $component_categories = $this->db->query($query, array($component->component_id))->result();

            foreach ($component_categories as $component_category) {
                foreach ($financial_years as $financial_year) {
                    // Fetch the total expenses for the current component category and financial year
                    $query = "SELECT SUM(net_pay) as total
                      FROM expenses
                      WHERE component_category_id = ? 
                      AND financial_year_id = ?";
                    $expenses = $this->db->query($query, array($component_category->component_category_id, $financial_year->financial_year_id))->row();

                    // If expenses are found, assign the total to the financial year, otherwise set it to 0
                    $component_category->financial_years[$financial_year->financial_year_id] = $expenses->total > 0 ? $expenses->total : '0.0';
                }

                // Assign the component categories to the component's sub_components property
                if (!isset($component->sub_components)) {
                    $component->sub_components = array();
                }
                $component->sub_components[] = $component_category;
            }
            foreach ($financial_years as $financial_year) {
                // Fetch the total expenses for the current component category and financial year
                $query = "SELECT SUM(net_pay) as total
                  FROM expenses
                  INNER JOIN component_categories as cc ON(cc.component_category_id = expenses.component_category_id)
                  WHERE financial_year_id = ?
                  AND cc.component_id = ?";
                $expenses = $this->db->query($query, array($financial_year->financial_year_id, $component->component_id))->row();

                // If expenses are found, assign the total to the financial year, otherwise set it to 0
                $component->financial_years[$financial_year->financial_year_id] = $expenses->total > 0 ? $expenses->total : '0.0';
            }
        }

        $this->data['components'] = $components;


        $this->data["view"] = ADMIN_DIR . "reports/chart_of_accounts/financial_statement";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    public function components_wise_financial_statement()
    {
        $this->data["title"] = 'Components Wise Financial Statement';
        $this->data["description"] = 'Chart of Account';
        // Fetch all financial years
        $query = "SELECT * FROM `financial_years`";
        $this->data['financial_years']  = $financial_years = $this->db->query($query)->result();
        // Fetch all components
        $query = "SELECT * FROM components";
        $components = $this->db->query($query)->result();
        foreach ($components as $component) {
            foreach ($financial_years as $financial_year) {
                // Fetch the total expenses for the current component category and financial year
                $query = "SELECT SUM(gross_pay) as total
                        FROM expenses
                        INNER JOIN component_categories as cc ON(cc.component_category_id = expenses.component_category_id)
                        INNER JOIN sub_components as sc ON(sc.sub_component_id = cc.sub_component_id)
                        INNER JOIN components as c ON(c.component_id = sc.component_id)
                        WHERE expenses.financial_year_id = ?
                        AND c.component_id = ? ";
                $expenses = $this->db->query($query, array($financial_year->financial_year_id, $component->component_id))->row();

                // If expenses are found, assign the total to the financial year, otherwise set it to 0
                $component->financial_years[$financial_year->financial_year_id] = $expenses->total > 0 ? $expenses->total : '0.0';
            }
        }
        $this->data['components'] = $components;
        $this->data["view"] = ADMIN_DIR . "reports/chart_of_accounts/components_wise_financial_statement";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    public function sub_financial_statement()
    {
        $this->data["title"] = 'Sub Components Wise Financial Statement';
        $this->data["description"] = 'Chart of Account';
        // Fetch all financial years
        $query = "SELECT * FROM `financial_years`";
        $this->data['financial_years']  = $financial_years = $this->db->query($query)->result();
        // Fetch all components
        $query = "SELECT * FROM components";
        $components = $this->db->query($query)->result();
        foreach ($components as $component) {
            // Fetch component categories for the current component
            $query = "SELECT * FROM `sub_components` WHERE component_id = ?";
            $sub_components = $this->db->query($query, array($component->component_id))->result();

            foreach ($sub_components as $sub_component) {
                foreach ($financial_years as $financial_year) {
                    // Fetch the total expenses for the current component category and financial year

                    $query = "SELECT SUM(gross_pay) as total
                        FROM expenses
                        INNER JOIN component_categories as cc ON(cc.component_category_id = expenses.component_category_id)
                        INNER JOIN sub_components as sc ON(sc.sub_component_id = cc.sub_component_id)
                        INNER JOIN components as c ON(c.component_id = sc.component_id)
                        WHERE expenses.financial_year_id = ?
                        AND c.component_id = ?
                        AND sc.sub_component_id = ? ";
                    $expenses = $this->db->query($query, array($financial_year->financial_year_id, $component->component_id, $sub_component->sub_component_id))->row();

                    // If expenses are found, assign the total to the financial year, otherwise set it to 0
                    $sub_component->financial_years[$financial_year->financial_year_id] = $expenses->total > 0 ? $expenses->total : '0.0';
                }

                // Assign the component categories to the component's sub_components property
                if (!isset($component->sub_components)) {
                    $component->sub_components = array();
                }
                $component->sub_components[] = $sub_component;
            }
            foreach ($financial_years as $financial_year) {
                // Fetch the total expenses for the current component category and financial year
                $query = "SELECT SUM(gross_pay) as total
                        FROM expenses
                        INNER JOIN component_categories as cc ON(cc.component_category_id = expenses.component_category_id)
                        INNER JOIN sub_components as sc ON(sc.sub_component_id = cc.sub_component_id)
                        INNER JOIN components as c ON(c.component_id = sc.component_id)
                        WHERE expenses.financial_year_id = ?
                        AND c.component_id = ? ";
                $expenses = $this->db->query($query, array($financial_year->financial_year_id, $component->component_id))->row();

                // If expenses are found, assign the total to the financial year, otherwise set it to 0
                $component->financial_years[$financial_year->financial_year_id] = $expenses->total > 0 ? $expenses->total : '0.0';
            }
        }

        $this->data['components'] = $components;
        $this->data["view"] = ADMIN_DIR . "reports/chart_of_accounts/sub_components_financial_statement";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }


    public function component_cetrgory_statment()
    {
        $this->data["title"] = 'Sub Components Wise Financial Statement';
        $this->data["description"] = 'Chart of Account';
        // Fetch all financial years
        $query = "SELECT * FROM `financial_years`";
        $this->data['financial_years']  = $financial_years = $this->db->query($query)->result();
        // Fetch all components
        $query = "SELECT * FROM components";
        $components = $this->db->query($query)->result();
        foreach ($components as $component) {
            // Fetch component categories for the current component
            $query = "SELECT * FROM `sub_components` WHERE component_id = ?";
            $sub_components = $this->db->query($query, array($component->component_id))->result();

            foreach ($sub_components as $sub_component) {

                //get components categories ....

                $query = "SELECT * FROM `component_categories` WHERE sub_component_id = ?";
                $component_categories = $this->db->query($query, array($sub_component->sub_component_id))->result();
                foreach ($component_categories as $component_category) {
                    foreach ($financial_years as $financial_year) {
                        // Fetch the total expenses for the current component category and financial year
                        $query = "SELECT SUM(gross_pay) as total
                            FROM expenses
                            INNER JOIN component_categories as cc ON(cc.component_category_id = expenses.component_category_id)
                            INNER JOIN sub_components as sc ON(sc.sub_component_id = cc.sub_component_id)
                            INNER JOIN components as c ON(c.component_id = sc.component_id)
                            WHERE expenses.financial_year_id = ?
                            AND c.component_id = ?
                            AND sc.sub_component_id = ?
                            AND cc.component_category_id = ? ";
                        $expenses = $this->db->query($query, array($financial_year->financial_year_id, $component->component_id, $sub_component->sub_component_id, $component_category->component_category_id))->row();
                        $component_category->financial_years[$financial_year->financial_year_id] = $expenses->total > 0 ? $expenses->total : '0.0';
                    }
                    if (!isset($sub_component->component_categories)) {
                        $sub_component->component_categories = array();
                    }
                    $sub_component->component_categories[] = $component_category;
                }


                // components categories end here .......
                foreach ($financial_years as $financial_year) {
                    // Fetch the total expenses for the current component category and financial year

                    $query = "SELECT SUM(gross_pay) as total
                        FROM expenses
                        INNER JOIN component_categories as cc ON(cc.component_category_id = expenses.component_category_id)
                        INNER JOIN sub_components as sc ON(sc.sub_component_id = cc.sub_component_id)
                        INNER JOIN components as c ON(c.component_id = sc.component_id)
                        WHERE expenses.financial_year_id = ?
                        AND c.component_id = ?
                        AND sc.sub_component_id = ? ";
                    $expenses = $this->db->query($query, array($financial_year->financial_year_id, $component->component_id, $sub_component->sub_component_id))->row();

                    // If expenses are found, assign the total to the financial year, otherwise set it to 0
                    $sub_component->financial_years[$financial_year->financial_year_id] = $expenses->total > 0 ? $expenses->total : '0.0';
                }

                // Assign the component categories to the component's sub_components property
                if (!isset($component->sub_components)) {
                    $component->sub_components = array();
                }
                $component->sub_components[] = $sub_component;
            }

            //for components only......
            foreach ($financial_years as $financial_year) {
                // Fetch the total expenses for the current component category and financial year
                $query = "SELECT SUM(gross_pay) as total
                        FROM expenses
                        INNER JOIN component_categories as cc ON(cc.component_category_id = expenses.component_category_id)
                        INNER JOIN sub_components as sc ON(sc.sub_component_id = cc.sub_component_id)
                        INNER JOIN components as c ON(c.component_id = sc.component_id)
                        WHERE expenses.financial_year_id = ?
                        AND c.component_id = ? ";
                $expenses = $this->db->query($query, array($financial_year->financial_year_id, $component->component_id))->row();

                // If expenses are found, assign the total to the financial year, otherwise set it to 0
                $component->financial_years[$financial_year->financial_year_id] = $expenses->total > 0 ? $expenses->total : '0.0';
            }
        }

        $this->data['components'] = $components;
        $this->data["view"] = ADMIN_DIR . "reports/chart_of_accounts/category_financial_statement";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function test_component_cetrgory_statment()
    {
        $this->data["title"] = 'Component Category Wise Financial Statement';
        $this->data["description"] = 'Chart of Accounts';
        // Fetch all financial years
        $query = "SELECT * FROM `financial_years`";
        $this->data['financial_years']  = $financial_years = $this->db->query($query)->result();
        // Fetch all components
        $query = "SELECT * FROM components";
        $components = $this->db->query($query)->result();
        // Fetch component categories for the current component
        $query = "SELECT * FROM `sub_components` WHERE component_id = ?";
        $sub_components = $this->db->query($query, array($component->component_id))->result();

        foreach ($sub_components as $sub_component) {
            foreach ($financial_years as $financial_year) {
                // Fetch the total expenses for the current component category and financial year
                $query = "SELECT SUM(gross_pay) as total
                        FROM expenses
                        INNER JOIN component_categories as cc ON(cc.component_category_id = expenses.component_category_id)
                        INNER JOIN sub_components as sc ON(sc.sub_component_id = cc.sub_component_id)
                        INNER JOIN components as c ON(c.component_id = sc.component_id)
                        WHERE expenses.financial_year_id = ?
                        AND c.component_id = ?
                        AND sc.sub_component_id = ? ";
                $expenses = $this->db->query($query, array($financial_year->financial_year_id, $component->component_id, $sub_component->sub_component_id))->row();

                // If expenses are found, assign the total to the financial year, otherwise set it to 0
                $sub_component->financial_years[$financial_year->financial_year_id] = $expenses->total > 0 ? $expenses->total : '0.0';
            }

            $query = "SELECT * FROM `component_categories` WHERE sub_component_id = ?";
            $component_categories = $this->db->query($query, array($sub_component->sub_component_id))->result();
            foreach ($component_categories as $component_category) {
                foreach ($financial_years as $financial_year) {
                    // Fetch the total expenses for the current component category and financial year
                    $query = "SELECT SUM(gross_pay) as total
                            FROM expenses
                            INNER JOIN component_categories as cc ON(cc.component_category_id = expenses.component_category_id)
                            INNER JOIN sub_components as sc ON(sc.sub_component_id = cc.sub_component_id)
                            INNER JOIN components as c ON(c.component_id = sc.component_id)
                            WHERE expenses.financial_year_id = ?
                            AND c.component_id = ?
                            AND sc.sub_component_id = ?
                            AND cc.component_category_id = ? ";
                    $expenses = $this->db->query($query, array($financial_year->financial_year_id, $component->component_id, $sub_component->sub_component_id, $component_category->component_category_id))->row();
                    $component_category->financial_years[$financial_year->financial_year_id] = $expenses->total > 0 ? $expenses->total : '0.0';
                }
                if (!isset($sub_component->component_categories)) {
                    $sub_component->component_categories = array();
                }
                $sub_component->component_categories[] = $component_category;
            }
            // Assign the component categories to the component's sub_components property
            if (!isset($component->sub_components)) {
                $component->sub_components = array();
            }
            $component->sub_components[] = $sub_component;
        }



        $this->data['components'] = $components;


        $this->data["view"] = ADMIN_DIR . "reports/category_financial_statement";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }



    public function export_expenses()
    {
        // Define your query
        $query = "SELECT
            e.expense_id as EXPENSE_ID,
            fy.financial_year as FY, 
            d.region as REGION,
            d.district_name as DISTRICT,
            e.purpose as PURPOSE, 
            cc.category as CATEGORY,
            cc.category_detail as CATEGORY_DETAIL, 
            s.scheme_name as SCHEME_NAME,
            s.scheme_code as SCHEME_CODE,
            wua.wua_registration_no as WUA_REG_NO,
            wua.wua_name as WUA_NAME,
            e.voucher_number as VOUCHER_NO,
            e.cheque as CHEQUE,   
            e.date as `DATE`,
            e.payee_name as PAYEE_NAME,
            e.gross_pay as GROSS_PAY,
            e.whit_tax as WHIT_TAX,
            e.whst_tax as WHST_TAX,
            e.st_duty_tax as ST_DUTY_TAX,
            e.rdp_tax as RDP_TAX,
            e.kpra_tax as KPRA_TAX,
            e.gur_ret as GUR_RET,
            e.misc_deduction as MISC_DEDUCTION,
            e.net_pay as NET_PAY
            FROM 
                expenses AS e
            INNER JOIN 
                financial_years AS fy ON fy.financial_year_id = e.financial_year_id
            INNER JOIN 
                districts AS d ON d.district_id = e.district_id
            LEFT JOIN 
                component_categories AS cc ON cc.component_category_id = e.component_category_id
            LEFT JOIN 
                schemes AS s ON(s.scheme_id = e.scheme_id)
            LEFT JOIN 
                water_user_associations as wua on(wua.water_user_association_id = s.water_user_association_id)";

        // Execute the query
        $result = $this->db->query($query)->result_array();

        // Set CSV filename
        $filename = time() . 'exported_data.csv';

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



    public function export_reconciliation_expenses()
    {
        // Define your query
        //wua.wua_registration_no as WUA_REG_NO,
        //wua.wua_name as WUA_NAME,
        //e.voucher_number as VOUCHER_NO,
        $query = "SELECT
                fy.financial_year AS FY,
                e.expense_id AS T_ID,
                d.region AS REGION,
                d.district_name AS DISTRICT,
                e.cheque AS CHEQUE,   
                e.date AS `DATE`,
                DATE_FORMAT(e.date, '%b') AS `MONTH`,
                s.scheme_code AS SCHEME_CODE,
                s.scheme_name AS SCHEME_NAME,
                e.payee_name AS PAYEE_NAME,
                c.component_name AS COMPONENT_NAME,
                sc.sub_component_name AS SUB_COMPONENT_NAME,
                cc.category AS CATEGORY,
                cc.category_detail AS CATEGORY_DETAIL, 
                s.sanctioned_cost AS SANCTIONED_COST,
                e.gross_pay AS GROSS_PAY,
                e.whit_tax AS WHIT_TAX,
                e.whst_tax AS WHST_TAX,
                e.st_duty_tax AS ST_DUTY_TAX,
                e.rdp_tax AS RDP_TAX,
                e.kpra_tax AS KPRA_TAX,
                e.gur_ret AS GUR_RET,
                e.misc_deduction AS MISC_DEDUCTION,
                e.net_pay AS NET_PAY,
                s.completion_cost AS COMPLETION_COST,
                s.lining_length AS LINE_LENGTH,
                e.installment AS INSTALLMENT,
                (
                    CASE
                        WHEN s.sanctioned_cost IS NULL OR s.sanctioned_cost = 0 THEN NULL
                        ELSE 
                            CONCAT(
                                ROUND(
                                    ((e.gross_pay + e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction + e.net_pay) * 100) / s.sanctioned_cost,
                                    2
                                ),
                                '%'
                            )
                    END
                ) AS `STATUS`,
                e.purpose AS PURPOSE,
                e.remarks AS REMARKS,
                (e.gross_pay - (e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction + e.net_pay)) as  RECONCILIATION
                                

            FROM 
                expenses AS e
            INNER JOIN 
                financial_years AS fy ON fy.financial_year_id = e.financial_year_id
            INNER JOIN 
                districts AS d ON d.district_id = e.district_id
            LEFT JOIN 
                component_categories AS cc ON cc.component_category_id = e.component_category_id
            LEFT JOIN 
                sub_components AS sc ON sc.sub_component_id = cc.sub_component_id
            LEFT JOIN 
                components AS c ON c.component_id = sc.component_id    
            LEFT JOIN 
                schemes AS s ON s.scheme_id = e.scheme_id
            LEFT JOIN 
                water_user_associations AS wua ON wua.water_user_association_id = s.water_user_association_id
                ORDER BY e.expense_id ASC;";

        // Execute the query
        $result = $this->db->query($query)->result_array();

        // Set CSV filename
        $filename = 'expenses_reconciliation_report_' . time() . '.csv';

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


    public function export_reconciliation_expenses2()
    {
        // Define your query
        //wua.wua_registration_no as WUA_REG_NO,
        //wua.wua_name as WUA_NAME,
        //e.voucher_number as VOUCHER_NO,
        $query = "SELECT
    fy.financial_year AS FY,
    e.expense_id AS T_ID,
    d.region AS REGION,
    d.district_name AS DISTRICT,
    e.cheque AS CHEQUE,   
    e.date AS `DATE`,
    DATE_FORMAT(e.date, '%b') AS `MONTH`,
    s.scheme_code AS SCHEME_CODE,
    s.scheme_name AS SCHEME_NAME,
    e.payee_name AS PAYEE_NAME,
    c.component_name AS COMPONENT_NAME,
    sc.sub_component_name AS SUB_COMPONENT_NAME,
    cc.category AS CATEGORY,
    cc.category_detail AS CATEGORY_DETAIL, 
    s.approved_cost as APPROVED_COST,
    s.completion_cost as COMPLETION_COST,
    CASE 
        WHEN e.installment = 'Final' THEN s.completion_cost
        WHEN e.installment IN ('1st', '1st_2nd') THEN s.approved_cost
        WHEN e.installment = '2nd' THEN 0
        ELSE NULL
    END AS SANCTIONED_COST,

    e.gross_pay AS GROSS_PAY,
    e.whit_tax AS WHIT_TAX,
    e.whst_tax AS WHST_TAX,
    e.st_duty_tax AS ST_DUTY_TAX,
    e.rdp_tax AS RDP_TAX,
    e.kpra_tax AS KPRA_TAX,
    e.gur_ret AS GUR_RET,
    e.misc_deduction AS MISC_DEDUCTION,
    e.net_pay AS NET_PAY,
    s.completion_cost AS COMPLETION_COST,
    s.lining_length AS LINE_LENGTH,
    e.installment AS INSTALLMENT,

    CASE 
        WHEN s.sanctioned_cost IS NULL OR s.sanctioned_cost = 0 THEN NULL
        ELSE 
            CONCAT(
                ROUND(
                    ((e.gross_pay + e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction + e.net_pay) * 100) / s.sanctioned_cost,
                    2
                ),
                '%'
            )
    END AS `STATUS`,

    e.purpose AS PURPOSE,
    e.remarks AS REMARKS,

    (e.gross_pay - (e.whit_tax + e.whst_tax + e.st_duty_tax + e.rdp_tax + e.kpra_tax + e.gur_ret + e.misc_deduction + e.net_pay)) AS RECONCILIATION

FROM 
    expenses AS e
INNER JOIN 
    financial_years AS fy ON fy.financial_year_id = e.financial_year_id
INNER JOIN 
    districts AS d ON d.district_id = e.district_id
LEFT JOIN 
    component_categories AS cc ON cc.component_category_id = e.component_category_id
LEFT JOIN 
    sub_components AS sc ON sc.sub_component_id = cc.sub_component_id
LEFT JOIN 
    components AS c ON c.component_id = sc.component_id    
LEFT JOIN 
    schemes AS s ON s.scheme_id = e.scheme_id
LEFT JOIN 
    water_user_associations AS wua ON wua.water_user_association_id = s.water_user_association_id

ORDER BY e.expense_id ASC;
";

        // Execute the query
        $result = $this->db->query($query)->result_array();

        // Set CSV filename
        $filename = 'expenses_reconciliation_report_' . time() . '.csv';

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



    public function export_wua_data()
    {
        // Define your query
        $query = "SELECT 
        `water_user_association_id` AS `WUA_ID`,
        `wua_name` AS `WUA_NAME`, 
        `wua_registration_no` AS `WUA_REG_NO`, 
        `wua_registration_date` AS `WUA_REG_DATE`, 
        `file_number` AS `FILE_NUMBER`,
        d.district_name AS `DISTRICT_NAME`, 
        `tehsil_name` AS `TEHSIL_NAME`, 
        `union_council` AS `UNION_COUNCIL`, 
        `address` AS `ADDRESS`,
        `cm_name` AS `CM_NAME`, 
        `cm_father_name` AS `CM_FATHER_NAME`, 
        `cm_gender` AS `CM_GENDER`, 
        `cm_cnic` AS `CM_CNIC`, 
        `cm_contact_no` AS `CM_CONTACT_NO`, 
        `bank_account_title` AS `BANK_ACCOUNT_TITLE`, 
        `bank_account_number` AS `BANK_ACCOUNT_NUMBER`, 
        `bank_name` AS `BANK_NAME`, 
        `bank_branch_code` AS `BANK_BRANCH_CODE` 
        FROM 
        `water_user_associations` 
        INNER JOIN 
        districts AS d 
        ON 
        (d.district_id = water_user_associations.district_id);
        ";

        // Execute the query
        $result = $this->db->query($query)->result_array();

        // Set CSV filename
        $filename = "WUA-data-" . time() . '.csv';

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

    public function export_scheme_data()
    {
        // Define your query
        $query = "
        SELECT 
        s.scheme_id AS `SCHEME_ID`, 
        s.scheme_code AS `SCHEME_CODE`, 
        s.scheme_name AS `SCHEME_NAME`, 
        s.scheme_status AS `SCHEME_STATUS`,
        fy.financial_year AS `FINANCIAL_YEAR`, 
        wua.wua_name AS `WUA_NAME`, 
        wua.wua_registration_no AS `WUA_REGISTRATION_NO`,
        cc.category AS `CATEGORY`, 
        cc.category_detail AS `CATEGORY_DETAIL`, 
        sc.sub_component_name AS `SUB_COMPONENT_NAME`, 
        sc.sub_component_detail AS `SUB_COMPONENT_DETAIL`, 
        c.component_name AS `COMPONENT_NAME`, 
        c.component_detail AS `COMPONENT_DETAIL`, 
        d.district_name AS `DISTRICT_NAME`, 
        d.region AS `REGION`, 
        s.tehsil AS `TEHSIL`, 
        s.uc AS `UC`, 
        s.villege AS `VILLAGE`, 
        s.na AS `NA`, 
        s.pk AS `PK`, 
        s.latitude AS `LATITUDE`, 
        s.longitude AS `LONGITUDE`, 
        s.beneficiaries AS `BENEFICIARIES`, 
        s.male_beneficiaries AS `MALE_BENEFICIARIES`, 
        s.female_beneficiaries AS `FEMALE_BENEFICIARIES`, 
        s.registration_date AS `REGISTRATION_DATE`, 
        s.top_date AS `TOP_DATE`, 
        s.survey_date AS `SURVEY_DATE`, 
        s.design_date AS `DESIGN_DATE`, 
        s.feasibility_date AS `FEASIBILITY_DATE`, 
        s.work_order_date AS `WORK_ORDER_DATE`, 
        s.scheme_initiation_date AS `SCHEME_INITIATION_DATE`, 
        s.estimated_cost_date AS `ESTIMATED_COST_DATE`,
        s.approval_date AS `APPROVAL_DATE`, 
        s.revised_cost_date AS `REVISED_COST_DATE`, 
        s.technical_sanction_date AS `TECHNICAL_SANCTION_DATE`, 
        s.completion_date AS `COMPLETION_DATE`, 
        s.verified_by_tpv AS `VERIFIED_BY_TPV`, 
        s.verification_by_tpv_date AS `VERIFICATION_BY_TPV_DATE`, 
        s.funding_source AS `FUNDING_SOURCE`, 
        s.water_source AS `WATER_SOURCE`, 
        s.cca AS `CCA`, 
        s.acca AS `ACCA`, 
        s.gca AS `GCA`, 
        s.pre_water_losses AS `PRE_WATER_LOSSES`, 
        s.pre_additional AS `PRE_ADDITIONAL`, 
        s.post_water_losses AS `POST_WATER_LOSSES`, 
        s.saving_water_losses AS `SAVING_WATER_LOSSES`, 
        s.total_lenght AS `TOTAL_LENGTH`, 
        s.lining_length AS `LINING_LENGTH`, 
        s.lwh AS `LWH`, 
        s.length AS `LENGTH`, 
        s.width AS `WIDTH`, 
        s.height AS `HEIGHT`, 
        s.type_of_lining AS `TYPE_OF_LINING`, 
        s.nacca_pannel AS `NACCA_PANEL`, 
        s.culvert AS `CULVERT`, 
        s.risers_pipe AS `RISERS_PIPE`, 
        s.risers_pond AS `RISERS_POND`, 
        s.design_discharge AS `DESIGN_DISCHARGE`, 
        s.others AS `OTHERS`,
        s.estimated_cost AS `ESTIMATED_COST`,
        s.approved_cost AS `APPROVED_COST`, 
        s.revised_cost AS `REVISED_COST`,
        s.completion_cost AS `COMPLETION_COST`,  
        s.sanctioned_cost AS `SANCTIONED_COST`, 
        SUM(e.gross_pay) as `TOTAL_PAID`,
         SUM(e.gross_pay-e.net_pay) as `DEDUCTION`,
        SUM(e.net_pay) as `NET_PAID`,
        COUNT(e.expense_id) as `PAYMENT_COUNT`,
        GROUP_CONCAT(e.cheque ORDER BY e.installment SEPARATOR ', ') AS `cheques`,
        SUM(CASE WHEN e.installment = '1st' THEN e.gross_pay END) AS `1st`,
        SUM(CASE WHEN e.installment = '2nd' THEN e.gross_pay END) AS `2nd`,
        SUM(CASE WHEN e.installment = '1st_2nd' THEN e.gross_pay END) AS `1st_2nd`,
        SUM(CASE WHEN e.installment NOT IN ('1st', '2nd', '1st_2nd', 'Final' ) THEN e.gross_pay END) AS `OTHER`,
        SUM(CASE WHEN e.installment = 'Final' THEN e.gross_pay END) AS `FINAL`
        FROM schemes AS s
        INNER JOIN districts AS d ON(d.district_id = s.district_id)
        INNER JOIN financial_years AS fy ON(fy.financial_year_id = s.financial_year_id)
        INNER JOIN component_categories AS cc ON(cc.component_category_id = s.component_category_id)
        INNER JOIN sub_components AS sc ON(sc.sub_component_id = cc.sub_component_id)
        INNER JOIN components AS c ON(c.component_id = sc.component_id)
        INNER JOIN water_user_associations AS wua ON(wua.water_user_association_id = s.water_user_association_id)
        LEFT JOIN expenses e ON s.scheme_id = e.scheme_id  
        GROUP BY s.scheme_id
        ORDER BY `SCHEME_ID` ASC";

        // Execute the query
        $result = $this->db->query($query)->result_array();

        // Set CSV filename
        $filename = "Schemes-data-" . time() . '.csv';

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


    public function export_scheme_list_by_status($scheme_status = NULL)
    {
        // Define your query
        $query = "SELECT 
        `region` as REGION, 
        `district_name` as DISTRICT, 
        `financial_year` as FY,
        `scheme_code` as SCHEME_CODE,
        `scheme_name` as SCHEME_NAME,
        `component_category` as CATEGORY,
        `scheme_status` as STATUS, 
        `approvel_date` as APPROVEL_DATE,
        `sanctioned_cost` as SANCTIONED_COST, 
        `payment_count` as PAYMENT_COUNT,
        `cheques` as CHEQUES,
        `total_paid` as TOTAL_PAID, 
        `deduction` as DEDUCTION,
        `net_paid` as NET_PAID, 
        `first` as `ICR-I`, 
        `second` as `ICR-II`,
        `first_second` as  `ICR-I&II`, 
        `other` as `other`, 
        `final` as `FCR`, 
        `remaining` as `BALANCE`
        FROM `scheme_lists` ";
        if ($scheme_status) {
            $query .= " WHERE `scheme_lists`.`scheme_status` IN (?)";
            // Execute the query
            $result = $this->db->query($query, [$scheme_status])->result_array();
        } else {
            $result = $this->db->query($query)->result_array();
        }

        // Set CSV filename
        $filename = "Schemes-data-" . time() . '.csv';

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

    public function export_scheme_list_ongoing()
    {
        // Define your query
        $query = "SELECT 
        `region` as REGION, 
        `district_name` as DISTRICT, 
        `financial_year` as FY,
        `scheme_code` as SCHEME_CODE,
        `scheme_name` as SCHEME_NAME,
        `component_category` as CATEGORY,
        `scheme_status` as STATUS, 
        `approvel_date` as APPROVEL_DATE,
        `sanctioned_cost` as SANCTIONED_COST, 
        `payment_count` as PAYMENT_COUNT,
        `cheques` as CHEQUES,
        `total_paid` as TOTAL_PAID, 
        `deduction` as DEDUCTION,
        `net_paid` as NET_PAID, 
        `first` as `ICR-I`, 
        `second` as `ICR-II`,
        `first_second` as  `ICR-I&II`, 
        `other` as `other`, 
        `final` as `FCR`, 
        `remaining` as `BALANCE`
        FROM `scheme_lists`
        WHERE `scheme_lists`.`scheme_status` IN ('Ongoing', 'ICR-I', 'ICR-II', 'ICR-I&II')";
        $result = $this->db->query($query)->result_array();
        // Set CSV filename
        $filename = "Schemes-data-" . time() . '.csv';

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

    public function download_payment_notesheet_csv($payment_notesheet_id = NULL)
    {


        if ($payment_notesheet_id) {
            $this->download_payment_notesheet_single_csv($payment_notesheet_id);
            exit();
        }


        $filename = "FRC_All_" . time() . ".csv";
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        // Open the output stream
        $output = fopen("php://output", "w");

        // Write the CSV headers
        fputcsv($output, [
            // '#',
            // 'RFP CODE',
            'TRAKING ID',
            'FRP DATE',
            'DISTRICT NAME',
            'SCHEME CODE',
            'SCHEME NAME',
            'Title of Account',
            'CATEGORY',
            'SANCTIONED COST',
            'ICR-I',
            'ICR-II',
            'ICR-I&II',
            'Others',
            'Final',
            'TOTAL PROGRESIVE',
            'REMAINING',
            'PAYMENT TYPE',
            'GROSS-Rs',
            'WHIT',
            'WHST',
            'KPRA',
            'St.Duty',
            'RDP',
            'Gur.Ret',
            'Misc.Dedu.',
            'Net-Rs',
            'Status'
        ]);


        // Fetch schemes under each category
        $query = "
            SELECT 
            pn.id,
            pn.payment_notesheet_code,
            pn.puc_date,
            pn.puc_tracking_id,
            d.district_name,
            s.scheme_id,
            s.scheme_status,
            s.scheme_code,
            s.scheme_name,
            COALESCE(e.payee_name, wua.bank_account_title) as title_of_account,
            cc.category,
            s.sanctioned_cost,
            SUM(CASE WHEN e.installment = '1st' THEN e.gross_pay END) AS `1st`,
            SUM(CASE WHEN e.installment = '2nd' THEN e.gross_pay END) AS `2nd`,
            SUM(CASE WHEN e.installment = '1st_2nd' THEN e.gross_pay END) AS `1st_2nd`,
            SUM(CASE WHEN e.installment NOT IN ('1st', '2nd', '1st_2nd', 'Final') THEN e.gross_pay END) AS `other`,
            SUM(CASE WHEN e.installment = 'Final' THEN e.gross_pay END) AS `final`,
            SUM(e.gross_pay) as total_paid,
            (s.sanctioned_cost - SUM(e.gross_pay)) as remaining,
            pns.payment_type,
            pns.payment_amount,
            pns.whit,
            pns.whst,
            pns.st_duty,
            pns.rdp, pns.kpra, pns.gur_ret, pns.misc_deduction,
            pns.net_pay
            FROM 
                schemes s
                INNER JOIN component_categories as cc ON cc.component_category_id = s.component_category_id
                INNER JOIN payment_notesheet_schemes as pns ON(pns.scheme_id = s.scheme_id)
                INNER JOIN payment_notesheets pn ON pn.id = pns.payment_notesheet_id
                INNER JOIN districts AS d ON(d.district_id = s.district_id)
                LEFT JOIN expenses e ON s.scheme_id = e.scheme_id
                INNER JOIN water_user_associations as wua ON wua.water_user_association_id = s.water_user_association_id";
        if ($payment_notesheet_id) {
            $query .= " WHERE pns.payment_notesheet_id = '" . $payment_notesheet_id . "'";
        }
        $query .= " GROUP BY s.scheme_id";

        $schemes = $this->db->query($query)->result();
        $count = 1;
        foreach ($schemes as $scheme) {


            fputcsv($output, [
                // $count++,
                // $scheme->payment_notesheet_code,
                $scheme->puc_tracking_id,
                $scheme->puc_date,
                $scheme->district_name,
                $scheme->scheme_code,
                $scheme->scheme_name,
                $scheme->title_of_account,
                $scheme->category,
                number_format($scheme->sanctioned_cost, 0),
                number_format($scheme->{'1st'}, 0),
                number_format($scheme->{'2nd'}, 0),
                number_format($scheme->{'1st_2nd'}, 0),
                number_format($scheme->{'other'}, 0),
                number_format($scheme->{'final'}, 0),
                number_format($scheme->total_paid, 0),
                number_format($scheme->remaining, 0),
                $scheme->payment_type,
                number_format($scheme->payment_amount, 2),
                number_format($scheme->whit, 2),
                number_format($scheme->whst, 2),
                number_format($scheme->kpra, 2),
                number_format($scheme->st_duty, 2),
                number_format($scheme->rdp, 2),

                number_format($scheme->gur_ret, 2),
                number_format($scheme->misc_deduction, 2),
                number_format($scheme->net_pay, 2),
                $scheme->scheme_status
                //,
            ]);
        }

        // Close the output stream
        fclose($output);
    }

    public function download_payment_notesheet_single_csv($payment_notesheet_id)
    {


        // Set headers to download the file as CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=FRC_' . $payment_notesheet_id . '_' . time() . '.csv');

        // Open the output stream
        $output = fopen('php://output', 'w');

        // Fetch data from the database
        $query = "
            SELECT 
                cc.component_category_id,
                cc.category,
                cc.category_detail
            FROM 
                schemes s
                INNER JOIN component_categories as cc ON cc.component_category_id = s.component_category_id
                INNER JOIN payment_notesheet_schemes as pns ON(pns.scheme_id = s.scheme_id)
                WHERE pns.payment_notesheet_id = '" . $payment_notesheet_id . "'  
                GROUP BY cc.component_category_id  ";
        $catrgories = $this->db->query($query)->result();

        // Write the CSV headers


        // Add the merged title row



        fputcsv($output, [

            'TRAKING ID',
            'FRP DATE',
            'DISTRICT NAME',
            'SCHEME CODE',
            'SCHEME NAME',
            'Title of Account',
            'CATEGORY',
            'SANCTIONED COST',
            'ICR-I',
            'ICR-II',
            'ICR-I&II',
            'Others',
            'Final',
            'TOTAL PROGRESIVE',
            'REMAINING',
            'PAYMENT TYPE',
            'GROSS-Rs',
            'WHIT',
            'WHST',
            'KPRA',
            'St.Duty',
            'RDP',
            'Gur.Ret',
            'Misc.Dedu.',
            'Net-Rs',
            'Status'
        ]);

        $count = 1;
        $gtotal = [
            'sanctioned_cost' => 0,
            '1st' => 0,
            '2nd' => 0,
            '1st_2nd' => 0,
            'other' => 0,
            'final' => 0,
            'total_paid' => 0,
            'remaining' => 0,
            'payment_amount' => 0,
            'whit' => 0,
            'whst' => 0,
            'st_duty' => 0,
            'rdp' => 0,
            'kpra' => 0,
            'gur_ret' => 0,
            'misc_deduction' => 0,
            'net_pay' => 0,
        ];

        foreach ($catrgories as $catrgory) {
            $query = "
        SELECT 
            pn.id,
            pn.payment_notesheet_code,
            pn.puc_date,
            pn.puc_tracking_id,
            d.district_name,
            s.scheme_id,
            s.scheme_status,
            s.scheme_code,
            s.scheme_name,
            e.payee_name,
            fy.financial_year,
            cc.category,
            wua.bank_account_title,
            pns.id as pns_id,
            pns.payment_amount,
            pns.whit,
            pns.whst,
            pns.st_duty,
            pns.rdp, pns.kpra, pns.gur_ret, pns.misc_deduction,
            pns.net_pay,
            pns.payment_type, 
            s.lining_length,
            SUM(e.gross_pay) as `total_paid`,
            COUNT(e.expense_id) as `payment_count`,
            (s.sanctioned_cost) as `sanctioned_cost`,
            SUM(CASE WHEN e.installment = '1st' THEN e.gross_pay END) AS `1st`,
            SUM(CASE WHEN e.installment = '2nd' THEN e.gross_pay END) AS `2nd`,
            SUM(CASE WHEN e.installment = '1st_2nd' THEN e.gross_pay END) AS `1st_2nd`,
            SUM(CASE WHEN e.installment = 'Final' THEN e.gross_pay END) AS `final`,
            SUM(CASE WHEN e.installment NOT IN ('1st','2nd', '1st_2nd', 'Final') THEN e.gross_pay END) AS `other`,
            GROUP_CONCAT(e.cheque ORDER BY e.installment SEPARATOR ', ') AS `cheques`
        FROM 
            schemes s
            INNER JOIN component_categories as cc ON cc.component_category_id = s.component_category_id
            INNER JOIN payment_notesheet_schemes as pns ON(pns.scheme_id = s.scheme_id)
            INNER JOIN financial_years as fy ON(fy.financial_year_id = s.financial_year_id)
            LEFT JOIN expenses e ON s.scheme_id = e.scheme_id
            INNER JOIN payment_notesheets pn ON pn.id = pns.payment_notesheet_id
            INNER JOIN districts AS d ON(d.district_id = s.district_id)
            INNER JOIN water_user_associations as wua ON(wua.water_user_association_id = s.water_user_association_id)
            WHERE pns.payment_notesheet_id = '" . $payment_notesheet_id . "'
            AND s.component_category_id ='" . $catrgory->component_category_id . "'
        GROUP BY 
            s.scheme_id, s.scheme_name
        ORDER BY id ASC    
    ";
            $schemes = $this->db->query($query)->result();
            $subtotal = [
                'sanctioned_cost' => 0,
                '1st' => 0,
                '2nd' => 0,
                '1st_2nd' => 0,
                'other' => 0,
                'final' => 0,
                'total_paid' => 0,
                'remaining' => 0,
                'payment_amount' => 0,
                'whit' => 0,
                'whst' => 0,
                'st_duty' => 0,
                'rdp' => 0,
                'kpra' => 0,
                'gur_ret' => 0,
                'misc_deduction' => 0,
                'net_pay' => 0,
            ];


            if (!empty($schemes)) {
                foreach ($schemes as $scheme) {

                    $total_paid = ($scheme->total_paid + $scheme->payment_amount);
                    $remaining = ($scheme->sanctioned_cost - $total_paid);
                    $account_title = '';
                    if ($scheme->payee_name) {
                        $account_title = $scheme->payee_name;
                    } else {
                        $account_title = $scheme->bank_account_title;
                    }
                    // Write the row data to the CSV
                    fputcsv($output, [
                        //$count++,
                        // $scheme->payment_notesheet_code,
                        $scheme->puc_tracking_id,
                        $scheme->puc_date,
                        $scheme->district_name,
                        $scheme->scheme_code,
                        $scheme->scheme_name,
                        $account_title,
                        $scheme->category,
                        number_format($scheme->sanctioned_cost, 0),
                        number_format($scheme->{'1st'}, 0),
                        number_format($scheme->{'2nd'}, 0),
                        number_format($scheme->{'1st_2nd'}, 0),
                        number_format($scheme->{'other'}, 0),
                        number_format($scheme->{'final'}, 0),
                        number_format($total_paid, 0),
                        number_format($remaining, 0),
                        $scheme->payment_type,
                        number_format($scheme->payment_amount, 0),
                        number_format($scheme->whit, 0),
                        number_format($scheme->whst, 0),
                        number_format($scheme->kpra, 2),
                        number_format($scheme->st_duty, 2),
                        number_format($scheme->rdp, 2),
                        number_format($scheme->gur_ret, 2),
                        number_format($scheme->misc_deduction, 2),
                        number_format($scheme->net_pay, 0),
                        $scheme->scheme_status
                    ]);

                    // Update subtotal and grand total
                    $subtotal['sanctioned_cost'] += $scheme->sanctioned_cost;
                    $subtotal['1st'] += $scheme->{'1st'};
                    $subtotal['2nd'] += $scheme->{'2nd'};
                    $subtotal['1st_2nd'] += $scheme->{'1st_2nd'};
                    $subtotal['other'] += $scheme->{'other'};
                    $subtotal['final'] += $scheme->{'final'};
                    $subtotal['total_paid'] += $total_paid;
                    $subtotal['remaining'] += $remaining;
                    $subtotal['payment_amount'] += $scheme->payment_amount;
                    $subtotal['whit'] += $scheme->whit;
                    $subtotal['whst'] += $scheme->whst;
                    $subtotal['st_duty'] += $scheme->st_duty;
                    $subtotal['rdp'] += $scheme->rdp;
                    $subtotal['kpra'] += $scheme->kpra;
                    $subtotal['gur_ret'] += $scheme->gur_ret;
                    $subtotal['misc_deduction'] += $scheme->misc_deduction;
                    $subtotal['net_pay'] += $scheme->net_pay;

                    $gtotal['sanctioned_cost'] += $scheme->sanctioned_cost;
                    $gtotal['1st'] += $scheme->{'1st'};
                    $gtotal['2nd'] += $scheme->{'2nd'};
                    $gtotal['1st_2nd'] += $scheme->{'1st_2nd'};
                    $gtotal['other'] += $scheme->{'other'};
                    $gtotal['final'] += $scheme->{'final'};
                    $gtotal['total_paid'] += $total_paid;
                    $gtotal['remaining'] += $remaining;
                    $gtotal['payment_amount'] += $scheme->payment_amount;
                    $gtotal['whit'] += $scheme->whit;
                    $gtotal['whst'] += $scheme->whst;
                    $gtotal['st_duty'] += $scheme->st_duty;
                    $gtotal['rdp'] += $scheme->rdp;
                    $gtotal['kpra'] += $scheme->kpra;
                    $gtotal['gur_ret'] += $scheme->gur_ret;
                    $gtotal['misc_deduction'] += $scheme->misc_deduction;
                    $gtotal['net_pay'] += $scheme->net_pay;
                }

                // Write the subtotal row
                fputcsv($output, [
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    'Sub Total',
                    number_format($subtotal['sanctioned_cost'], 0),
                    number_format($subtotal['1st'], 0),
                    number_format($subtotal['2nd'], 0),
                    number_format($subtotal['1st_2nd'], 0),
                    number_format($subtotal['other'], 0),
                    number_format($subtotal['final'], 0),
                    number_format($subtotal['total_paid'], 0),
                    number_format($subtotal['remaining'], 0),
                    '',
                    number_format($subtotal['payment_amount'], 0),
                    number_format($subtotal['whit'], 0),
                    number_format($subtotal['whst'], 0),
                    number_format($subtotal['kpra'], 0),
                    number_format($subtotal['st_duty'], 0),
                    number_format($subtotal['rdp'], 0),
                    number_format($subtotal['gur_ret'], 0),
                    number_format($subtotal['misc_deduction'], 0),
                    number_format($subtotal['net_pay'], 0)
                ]);
            }
        }

        // Write the grand total row
        fputcsv($output, [
            '',
            '',
            '',
            '',
            '',
            '',
            'Total',
            number_format($gtotal['sanctioned_cost'], 0),
            number_format($gtotal['1st'], 0),
            number_format($gtotal['2nd'], 0),
            number_format($gtotal['1st_2nd'], 0),
            number_format($gtotal['other'], 0),
            number_format($gtotal['final'], 0),
            number_format($gtotal['total_paid'], 0),
            number_format($gtotal['remaining'], 0),
            '',
            number_format($gtotal['payment_amount'], 0),
            number_format($gtotal['whit'], 0),
            number_format($gtotal['whst'], 0),
            number_format($gtotal['kpra'], 0),
            number_format($gtotal['st_duty'], 0),
            number_format($gtotal['rdp'], 0),
            number_format($gtotal['gur_ret'], 0),
            number_format($gtotal['misc_deduction'], 0),
            number_format($gtotal['net_pay'], 0)
        ]);

        // Close the output stream
        fclose($output);
        exit;
    }




    public function export_venders_taxes()
    {
        // Define your query
        $query = "SELECT vou.tracking_id, vou.voucher_id,  d.district_name, s.scheme_code, s.scheme_name, cc.category,
        `ven`.`vendor_id`, `ven`.`Vendor_Type`, `ven`.`TaxPayer_NTN`, `ven`.`TaxPayer_CNIC`, `ven`.`TaxPayer_Name`, `ven`.`TaxPayer_City`, `ven`.`TaxPayer_Address`, `ven`.`TaxPayer_Status`, `ven`.`TaxPayer_Business_Name`, `ven`.`Focal_Person`, `ven`.`Contact_No`, `ven`.`industery`, `ven`.`business_category`, `ven`.`nature_of_business`, `ven`.`registration_no`, 
        `vi`.`invoice_id`, `vi`.`invoice_date`, `vi`.`nature_of_payment`, `vi`.`payment_section_code`, `vi`.`invoice_gross_total`, 
        `vi`.`st_charged`, `vi`.`sst_charged`, `vi`.`whit_tax`,  `vi`.`whst_tax`, `vi`.`st_duty_tax`, `vi`.`kpra_tax`, `vi`.`rdp_tax`, `vi`.`misc_deduction` FROM `vendors_taxes` as vi  
        INNER JOIN vendors as ven ON(ven.vendor_id = vi.vendor_id)
        INNER JOIN vouchers as vou ON(vou.voucher_id = vi.voucher_id)
        LEFT JOIN schemes as s ON(s.scheme_id = vi.scheme_id)  
        LEFT JOIN districts as d ON(d.district_id = s.district_id)
        LEFT JOIN component_categories as cc ON(cc.component_category_id = s.component_category_id)
        ORDER BY `vi`.`scheme_id` DESC;";
        $result = $this->db->query($query)->result_array();
        // Set CSV filename
        $filename = "vender_taxes_" . time() . '.csv';

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


    public function schemes_filter()
    {
        $this->data["title"] = 'Scheme Filter Report';
        $this->data["description"] = 'Scheme Filter Report';
        $this->data["view"] = ADMIN_DIR . "reports/schemes_filter/schemes_filter_list";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }

    public function schemes_filter_list()
    {
        $query = "
        SELECT 
            s.scheme_id,
            s.scheme_code,
            s.scheme_name,
            s.scheme_status,
            d.district_name,
            d.region,
            s.approval_date,
            s.completion_date,
            e.payee_name,
            fy.financial_year,
            cc.category,
            s.lining_length,
            s.sanctioned_cost,
            SUM(e.gross_pay) AS total_paid,
            COUNT(e.expense_id) AS payment_count,
            SUM(CASE WHEN e.installment = '1st' THEN e.gross_pay ELSE 0 END) AS `1st`,
            SUM(CASE WHEN e.installment = '2nd' THEN e.gross_pay ELSE 0 END) AS `2nd`,
            SUM(CASE WHEN e.installment = '1st_2nd' THEN e.gross_pay ELSE 0 END) AS `1st_2nd`,
            SUM(CASE WHEN e.installment = 'Final' THEN e.gross_pay ELSE 0 END) AS `final`,
            SUM(CASE WHEN e.installment NOT IN ('1st','2nd','1st_2nd','Final') THEN e.gross_pay ELSE 0 END) AS `other`,
            GROUP_CONCAT(e.cheque ORDER BY e.installment SEPARATOR ', ') AS cheques
        FROM 
            schemes s
            INNER JOIN component_categories cc ON cc.component_category_id = s.component_category_id
            INNER JOIN financial_years fy ON fy.financial_year_id = s.financial_year_id
            LEFT JOIN expenses e ON s.scheme_id = e.scheme_id
            INNER JOIN districts d ON d.district_id = s.district_id
        WHERE 1 = 1
    ";

        $params = [];

        // Helper to add dynamic filters
        $addFilter = function ($field, $inputKey) use (&$query, &$params) {
            $values = $this->input->post($inputKey);
            if ($values) {
                if (!is_array($values)) $values = [$values];
                $placeholders = implode(',', array_fill(0, count($values), '?'));
                $query .= " AND $field IN ($placeholders)";
                $params = array_merge($params, $values);
            }
        };

        // Apply filters
        $addFilter('s.financial_year_id', 'financial_year_ids');
        $addFilter('s.district_id', 'district_ids');
        $addFilter('d.region', 'regions');
        $addFilter('s.scheme_status', 'scheme_status');
        $addFilter('s.component_category_id', 'component_category_ids');
        $addFilter('s.scheme_code', 'scheme_codes');
        $addFilter('s.scheme_name', 'scheme_names');
        $addFilter('s.scheme_id', 'scheme_ids');


        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $date_filter_by = $this->input->post('date_filter_by');

        // Sanitize column name to prevent SQL injection
        $allowed_columns = ['approval_date', 'completion_date']; // whitelist
        if (in_array($date_filter_by, $allowed_columns)) {
            $date_filter = 's.' . $date_filter_by;
        } else {
            $date_filter = 's.approval_date'; // default
        }

        // Now apply the filter
        if ($start_date && !$end_date) {
            $query .= " AND DATE($date_filter) >= ?";
            $params[] = $start_date;
        } elseif (!$start_date && $end_date) {
            $query .= " AND DATE($date_filter) <= ?";
            $params[] = $end_date;
        } elseif ($start_date && $end_date) {
            $query .= " AND DATE($date_filter) BETWEEN ? AND ?";
            $params[] = $start_date;
            $params[] = $end_date;
        }


        // Group by scheme_id (important for aggregation)
        $query .= " GROUP BY s.scheme_id";

        try {
            $results = $this->db->query($query, $params)->result();
            echo json_encode(['success' => true, 'data' => $results]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Query error',
                'error' => $e->getMessage()
            ]);
        }
        exit();
    }
}
