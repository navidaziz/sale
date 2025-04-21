<?php


// other data functions for loading prerequisite data 

function school_types($list = true)
{
  $query = "SELECT `typeId`, `typeTitle` FROM `school_type`;";
  $list = $this->db->query($query)->result();
  if ($list == true) {
    return $list;
  }
  $data = "<option>Select</option>";
  foreach ($list as $item) {
    $data .= "<option value='" . $item->typeId . "'>" . $item->typeTitle . "</option>";
  }
  return $data;
}

function districts($list = true)
{
  $query = "SELECT `districtId`, `districtTitle` FROM `district`";
  $list = $this->db->query($query)->result();
  if ($list == true) {
    return $list;
  }
  $data = "<option>Select</option>";
  foreach ($list as $item) {
    $data .= "<option value='" . $item->districtId . "'>" . $item->districtTitle . "</option>";
  }
  return $data;
}

function gender_of_school($list = true)
{
  $query = "SELECT `genderOfbusiness_id`, `genderOfSchoolTitle` FROM `genderofschool`";
  $list = $this->db->query($query)->result();
  if ($list == true) {
    return $list;
  }
  $data = "<option>Select</option>";
  foreach ($list as $item) {
    $data .= "<option value='" . $item->genderOfbusiness_id . "'>" . $item->genderOfSchoolTitle . "</option>";
  }
  return $data;
}

function level_of_institute($list = true)
{
  $query = "SELECT `levelofInstituteId`, `levelofInstituteTitle` FROM `levelofinstitute`";
  $list = $this->db->query($query)->result();
  if ($list == true) {
    return $list;
  }
  $data = "<option>Select</option>";
  foreach ($list as $item) {
    $data .= "<option value='" . $item->levelofInstituteId . " set_select('levelofInstituteId', '" . $item->levelofInstituteId . "', TRUE); ?> >" . $item->levelofInstituteTitle . "</option>";
  }
  return $data;
}

function registration_type($list = true)
{
  $query = "SELECT `regTypeId`, `regTypeTitle` FROM `reg_type`;";
  $list = $this->db->query($query)->result();
  if ($list == true) {
    return $list;
  }
  $data = "<option>Select</option>";
  foreach ($list as $item) {
    $data .= "<option value='" . $item->regTypeId . "'>" . $item->regTypeTitle . "</option>";
  }
  return $data;
}

function tehsils($list = true)
{
  $query = "SELECT `tehsilId`, `tehsilTitle`, `district_id` FROM `tehsils`;";
  $list = $this->db->query($query)->result();
  if ($list == true) {
    return $list;
  }
  $data = "<option>Select</option>";
  foreach ($list as $item) {
    $data .= "<option value='" . $item->tehsilId . "'>" . $item->tehsilTitle . "</option>";
  }
  return $data;
}

function ucs($list = true)
{
  $query = "SELECT `ucId`, `ucTitle`, `tehsil_id` FROM `uc`;";
  $list = $this->db->query($query)->result();
  if ($list == true) {
    return $list;
  }
  $data = "<option>Select</option>";
  foreach ($list as $item) {
    $data .= "<option value='" . $item->ucId . "'>" . $item->ucTitle . "</option>";
  }
  return $data;
}

function get_session_request_status($status)
{
  switch ($status) {
    case 0:
      return "Data Entery In Progress";
      break;
    case 2:
      return "Application In Progress";
      break;
    case 3:
      return "Data Verification";
      break;
    case 4:
      return "Fowarded for Inspection Assignment";
      break;
    case 4:
      return "Inspection Pending";
      break;
    case 5:
      return "Inspection Completed";
      break;
    case 6:
      return "Decision Pending";
      break;
    case 7:
      return "<strong style=\"Color:red\">Deficiency Found</strong>";
      break;
    case 8:
      return "Challan Not Verified";
      break;
    case 1:
      return "Completed";
      break;
  }
}

function get_last_link($school_session_id)
{
  $ci = &get_instance();
  $query = "SELECT * FROM `forms_process` WHERE  `forms_process`.`school_id` = $school_session_id";
  $page_link = 'section_b';
  $form_stauts = $ci->db->query($query)->result()[0];
  if (
    $form_stauts->form_b_status == 1
    and $form_stauts->form_c_status == 1
    and $form_stauts->form_d_status == 1
    and $form_stauts->form_e_status == 1
    and $form_stauts->form_f_status == 1
    and $form_stauts->form_g_status == 1
    and $form_stauts->form_h_status == 1
  ) {
    $page_link = 'submit_bank_challan';
  } else {
    $page_link = 'section_b';
  }

  if ($form_stauts->form_b_status == 1) {
    $page_link = 'section_c';
  }
  if ($form_stauts->form_c_status == 1) {
    $page_link = 'section_d';
  }
  if ($form_stauts->form_d_status == 1) {
    $page_link = 'section_e';
  }
  if ($form_stauts->form_e_status == 1) {
    $page_link = 'section_f';
  }
  if ($form_stauts->form_f_status == 1) {
    $page_link = 'section_g';
  }
  if ($form_stauts->form_g_status == 1) {
    $page_link = 'section_h';
  }
  if ($form_stauts->form_h_status == 1) {
    $page_link = 'submit_bank_challan';
  }
  return  $page_link;
  // $page_link = 'submit_bank_challan';
  // if ($form_stauts->form_b_status == 0) {
  //   $page_link = 'section_b';
  // }
  // if ($form_stauts->form_c_status == 0) {
  //   $page_link = 'section_c';
  // }
  // if ($form_stauts->form_d_status == 0) {
  //   $page_link = 'section_d';
  // }
  // if ($form_stauts->form_e_status == 0) {
  //   $page_link = 'section_e';
  // }
  // if ($form_stauts->form_f_status == 0) {
  //   $page_link = 'section_f';
  // }
  // if ($form_stauts->form_g_status == 0) {
  //   $page_link = 'section_g';
  // }
  // if ($form_stauts->form_h_status == 0) {
  //   $page_link = 'section_h';
  // }
}

function get_registration_detail($school_id)
{
  $ci = &get_instance();
  $query = "SELECT
                           `reg_type`.`regTypeTitle`
                           , `school_type`.`typeTitle`
                           , `levelofinstitute`.`levelofInstituteTitle`
                           , `gender`.`genderTitle`
                           , `school`.`status`
                           , `school`.`status_type`
                           , `school`.`session_year_id`
                           , `school`.`business_id` as school_id
                           , `school`.`businesses_id`
                           , `school`.`status`
                           , `school`.`isRejected`
                           ,`session_year`.`sessionYearTitle`
                       FROM `reg_type`,
                       `school`,
                       `school_type`,
                       `levelofinstitute`,
                       `gender`,
                       `session_year`  
                       WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
                       AND `school_type`.`typeId` = `school`.`school_type_id`
                       AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                       AND `gender`.`genderId` = `school`.`gender_type_id`
                       AND `session_year`.`sessionYearId` = `school`.`session_year_id`
                       AND school.`businesses_id`= '" . $school_id . "'
                       AND `school`.`reg_type_id` = 1";
  $reg_detail =   $ci->db->query($query)->result()[0];
  return $reg_detail;
}


function timeago($time)
{
  $time_difference = time() - $time;

  if ($time_difference < 1) {
    return 'less than 1 second ago';
  }
  $condition = array(
    //12 * 30 * 24 * 60 * 60 =>  'year',
    //             30 * 24 * 60 * 60       =>  'month',
    24 * 60 * 60            =>  'day',
    // 60 * 60                 =>  'hour',
    // 60                      =>  'minute',
    // 1                       =>  'second'
  );

  foreach ($condition as $secs => $str) {
    $d = $time_difference / $secs;

    if ($d >= 1) {
      $t = round($d);
      //return '' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
      return $t;
    }
  }
}

function timeago2($time)
{
  $time_difference = time() - $time;

  if ($time_difference < 1) {
    return 'less than 1 second ago';
  }
  $condition = array(
    12 * 30 * 24 * 60 * 60 =>  'year',
    30 * 24 * 60 * 60       =>  'month',
    24 * 60 * 60            =>  'day',
    60 * 60                 =>  'hour',
    60                      =>  'minute',
    1                       =>  'second'
  );

  foreach ($condition as $secs => $str) {
    $d = $time_difference / $secs;

    if ($d >= 1) {
      $t = round($d);
      return '' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
    }
  }
}
function file_status($file_status)
{

  switch ($file_status) {
    case '1':
      echo "New";
      break;

    case '3':
      echo "Pending due to previous";
      break;
    case '4':
      echo "Marked to operation Wing";
      break;
    case '5':
      echo "Financial deficient";
      break;
    case '10':
      echo "Marked as completed";
      break;

    default:

      break;
  }
}
