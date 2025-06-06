function open_model_edit(order_id) {
  $.ajax({
    type: "POST",
    url: site_url + "/orders/get_order_edit_form/" + order_id,
    data: {},
  }).done(function (data) {
    $("#order_edit_form").html(data);
  });

  $("#edit_order").modal("toggle");
}

function on_click_search_button() {
  searched_order();
}

function searched_order() {
  var customer_mobile_no = $("#search").val();
  $.ajax({
    type: "POST",
    url: site_url + "/orders/searched_order/" + customer_mobile_no,
    data: {},
  }).done(function (data) {
    //alert(data);
    //data = jQuery.parseJSON(data);
    $("#search_order_detail").html(data);
  });
}

function update_order(order_id) {
  var edit_delivery_charges = $("#edit_delivery_charges").val();
  var edit_order_detail = $("#edit_order_detail").val();
  var order_detail_orignal = $("#order_detail_orignal").val();
  var delivery_charges_orignal = $("#delivery_charges_orignal").val();

  var order_picking_address = $("#order_picking_address").val();

  var order_drop_address = $("#order_drop_address").val();

  if (edit_delivery_charges == "" || edit_delivery_charges < 99) {
    alert("Check Order Delivery Charges. Charges not less the 150");
    return false;
  }
  if (edit_order_detail.length < 5) {
    alert("Enter Order Detail. The Order must more the 5 characters.");
    return false;
  }

  $.ajax({
    type: "POST",
    url: site_url + "/orders/edit_order_detail/",
    data: {
      order_id: order_id,
      edit_delivery_charges: edit_delivery_charges,
      edit_order_detail: edit_order_detail,
      order_detail_orignal: order_detail_orignal,
      delivery_charges_orignal: delivery_charges_orignal,
      order_picking_address: order_picking_address,
      order_drop_address: order_drop_address,
    },
  }).done(function (data) {
    $("#order_edit_form").html(data);
  });
}

function on_enter_press_search() {
  if (event.keyCode == 13) {
    searched_order();
  }
}

function print_receipt(div_id) {
  var divToPrint = document.getElementById(div_id);

  var printWin = window.open(
    "",
    "",
    "left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status=0"
  );

  printWin.document.write(divToPrint.outerHTML);
  printWin.document.close();
  printWin.focus();
  printWin.print();
  printWin.close();
}

function set_order_ready_time(time) {
  $("#order_ready_time_field").val(time);
}

function open_model(order_id) {
  //alert(order_id);
  $.ajax({
    type: "POST",
    url: site_url + "/orders/get_order_by_id/" + order_id,
    data: {},
  }).done(function (data) {
    data = jQuery.parseJSON(data);
    // alert(data.mobile_number);
    var title_print = "Charges: Rs " + data.delivery_charges;
    var print_receipt =
      '<table style="font-size: 12px !important;" id="PrintOrder"><tr><td colspan="2"><h3 style="text-align: center;">' +
      title_print +
      "</h4></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Order ID:</strong></td><td> ' +
      order_id +
      " (" +
      data.order_type +
      ")<br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Customer:</strong></td><td> ' +
      data.customer_name +
      " (" +
      data.mobile_number +
      ")<br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td colspan="2" ><strong>Order Detail:</strong></td></tr><tr style="border: 1px solid gray !important;" ><td colspan="2"> ' +
      data.order_detail +
      "<br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Picking Address:</strong></td><td> <i>' +
      data.order_picking_address +
      "</i><br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Delivery Address:</strong></td><td> <i>' +
      data.order_drop_address +
      "</i><br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Reg.</strong></td><td> <i>On ' +
      data.mobile_or_call;
    print_receipt += " by " + data.userName + "";
    print_receipt += " at " + data.order_date_time + " </i><br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Order On Name:</strong></td><td> ' +
      data.orderer_name +
      "<br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Order Placed Time: </strong></td><td>' +
      data.order_place_time +
      "<br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Order Ready Time: </strong></td><td> ' +
      data.order_ready_time +
      "<br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Assigned Rider: </strong></td><td> ' +
      data.rider_name +
      "<br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Assignded Time: </strong></td><td>' +
      data.order_rider_assign_time +
      "<br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Acknowledged Time: </strong></td><td> ' +
      data.order_rider_acknowledge +
      "<br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Order Picked Time </strong></td><td> ' +
      data.order_picking_time +
      "<br /></td></tr>";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Expected Delivery Time: </strong></td><td> ' +
      data.delivery_time +
      "<br />";
    print_receipt +=
      '<tr style="border: 1px solid gray !important;" ><td><strong>Delivery Ready Time: </strong></td><td> ' +
      data.order_rider_delivery_time +
      "<br /></td></tr>";
    print_receipt +=
      '<tr><td colspan="2"><i>Print By ' +
      data.print_by +
      "  on " +
      data.print_time +
      "<i></td></tr></table>";
    $("#receipt").html(print_receipt);
    $(".order_id").val(order_id);
    $("#customer_name").html(data.customer_name);
    $("#order_name_field").val(data.customer_name);
    $("#customer_mobile_no").html(data.mobile_number);

    //order type
    if (data.order_type == "General Order") {
      $("#general_order_radio_button").prop("checked", true);
      $("#order_type").html(
        '<span class="label label-warning label-sm">' +
          data.order_type +
          "<span>"
      );
    }
    if (data.order_type == "Food Order") {
      $("#food_order_radio_button").prop("checked", true);
      $("#order_type").html(
        '<span class="label label-success  label-sm">' +
          data.order_type +
          "<span>"
      );
    }

    $("#orderId").html(" # " + order_id);

    $("#delivery_charges").html(data.delivery_charges);
    $("#deliveryCharges").val(data.delivery_charges);
    $("#order_detail").html(data.order_detail);
    $("#pickinglocation").html(data.order_picking_address);
    $("#deliverylocation").html(data.order_drop_address);
    $("#mobile_or_call").html(data.mobile_or_call);
    $("#created_by").html(data.userName);
    $("#order_date_time").html(data.order_date_time);
    $("#orderer_name").html(data.orderer_name);
    $("#order_place_time").html(data.order_place_time);
    $("#order_ready_time").html(data.order_ready_time);
    $("#rider_name").html(data.rider_name);
    $("#order_rider_assign_time").html(data.order_rider_assign_time);
    $("#order_rider_acknowledge").html(data.order_rider_acknowledge);
    $("#order_picking_time").html(data.order_picking_time);
    $("#delivery_time").html(data.delivery_time);
    $("#order_rider_delivery_time").html(data.order_rider_delivery_time);
    $("#order_status").html(data.order_status_title);

    $("#order_place_form").hide();
    $("#order_cancle_or_awating_table").hide();
    $("#order_place_form").hide();
    $("#assign_rider_deliver").show();
    $("#deliver_button").hide();
    $("#deliver_button2").hide();
    $("#assign_rider_deliver").hide();

    if (data.order_status == 1) {
      $("#order_cancle_or_awating_table").show();
      $("#order_place_form").show();
      $("#assign_rider_deliver").hide();
      $("#deliver_button2").hide();
      $("#awaiting_order_button").show();
    }

    if (data.order_status == 2) {
      $("#order_cancle_or_awating_table").show();
      $("#order_place_form").hide();
      $("#assign_rider_deliver").show();
      $("#deliver_button").hide();
      $("#deliver_button2").hide();
      $("#awaiting_order_button").show();
    }

    if (data.order_status == 6) {
      $("#order_cancle_or_awating_table").show();
      $("#order_place_form").hide();
      $("#assign_rider_deliver").show();
      $("#deliver_button").show();
      $("#deliver_button2").hide();
      $("#awaiting_order_button").hide();
    }

    if (data.order_status == 3) {
      $("#order_cancle_or_awating_table").show();
      $("#order_place_form").hide();
      $("#assign_rider_deliver").hide();
      $("#deliver_button2").show();
      $("#awaiting_order_button").show();
    }

    if (data.order_status == 2) {
      var rider_list = "";

      $("#rider_id").children("option:not(:first)").remove();
      $.ajax({
        type: "POST",
        url: site_url + "/orders/get_riders/",
        data: {},
      }).done(function (data) {
        data = jQuery.parseJSON(data);

        var rider_table_rider_row = $("#rider_table_list").DataTable();
        rider_table_rider_row.row().remove().draw();

        for (var i in data) {
          var counter = data[i];

          var rider_total_order;
          if (counter.total_order) {
            rider_total_order = counter.total_order;
          } else {
            rider_total_order = counter.status;
          }

          var last_assigned_time = "";
          if (counter.last_assigned_time) {
            last_assigned_time =
              '<abbr id="' +
              counter.lastassignedtime +
              '" class="timeago tip" title="' +
              counter.lastassignedtime +
              '" data-original-title="' +
              counter.lastassignedtime +
              '">' +
              counter.last_assigned_time +
              "</abbr>";
          } else {
            last_assigned_time = "";
          }

          rider_table_rider_row.row
            .add([
              '<input type="radio" name="rider_id" value="' +
                counter.rider_id +
                '" />',
              counter.rider_name + " <br />(" + counter.office_no + ")",
              rider_total_order,
              last_assigned_time,
              counter.order_picking_address,
              counter.order_drop_address,
              counter.total_delivery,
            ])
            .draw(false);
        }

        //$('#rider_table_list > tbody:last-child').append(rider_list);

        //alert(rider_list);
        //$('#rider_list').html(rider_list);
      });

      //$('#rider_list').html(rider_list);
    }

    //$('#customer_mobile_no').html(data.mobile_number);
    //create_items_table(data);
  });
  $("#order_view").modal("toggle");
  $("#rider_table_list").DataTable({
    paging: false,
    retrieve: true,
  });
}

function strip(html) {
  var tmp = document.createElement("DIV");
  tmp.innerHTML = html;
  return tmp.textContent || tmp.innerText || "";
}

function get_food_menu() {
  restaurant_id = $("#restaurant_id").val();

  $("#restaurant_food_menu_id").children("option:not(:first)").remove();
  if (restaurant_id) {
    $.ajax({
      type: "POST",
      url: site_url + "/restaurant_food_menus/get_food_menu/" + restaurant_id,
      data: {},
    }).done(function (data) {
      data = jQuery.parseJSON(data);
      for (var i in data) {
        var counter = data[i];
        food_menu =
          counter.restaurant_food_category +
          " | " +
          counter.restaurant_food_name +
          " | " +
          counter.restaurant_food_quantity +
          " | Rs: " +
          counter.restaurant_food_price;
        $("#restaurant_food_menu_id").append(
          $("<option>", {
            value: counter.restaurant_food_menu_id,
            text: food_menu,
          })
        );
      }

      $("#restaurant_food_menu_id").focus();

      // refresh the list
      $("select.special-flexselect").flexselect({
        hideDropdownOnEmptyInput: true,
      });
      $("select.flexselect").flexselect();
      $("input:text:enabled:first").focus();
      /*$("form").submit(function() {
            alert($(this).serialize());
            return false;
            });*/
    });
  }
}

function remove_cart_item(item_cart_id) {
  $("#r_" + item_cart_id).remove();

  $.ajax({
    type: "POST",
    url: site_url + "/restaurant_food_menus/remove_cart_item/" + item_cart_id,
    data: {},
  }).done(function (data) {
    $("#r_" + item_cart_id).remove();
    data = jQuery.parseJSON(data);
    create_items_table(data);
  });
}

function add_food_to_cart() {
  restaurant_food_menu_id = $("#restaurant_food_menu_id").val();
  //alert(restaurant_food_menu_id);
  if (restaurant_food_menu_id) {
    $.ajax({
      type: "POST",
      url:
        site_url +
        "/restaurant_food_menus/add_food_to_cart/" +
        restaurant_food_menu_id,
      data: {},
    }).done(function (data) {
      //alert(data);
      data = jQuery.parseJSON(data);
      create_items_table(data);
    });
  }
}

function icrement_cart_item_quantity(item_cart_id) {
  var restaurant_food_price = $("#restaurant_food_price_" + item_cart_id).val();
  var quantity = $("#quantity_" + item_cart_id).val();
  $("#total_" + item_cart_id).val(restaurant_food_price * quantity);
  $("#total_td_" + item_cart_id).html(restaurant_food_price * quantity);
  var total_rs = 0;
  $(".total").each(function (index, element) {
    total_rs = total_rs + parseFloat($(element).val());
  });
  $("#total_rs").html(total_rs);

  var quantity = $("#quantity_" + item_cart_id).val();
  var restaurant_food_price_ = $(
    "#restaurant_food_price_" + item_cart_id
  ).val();

  $.ajax({
    type: "POST",
    url:
      site_url +
      "/restaurant_food_menus/icrement_cart_item_quantity/" +
      item_cart_id,
    data: {
      quantity: quantity,
    },
  }).done(function (data) {
    // $('#r_'+item_cart_id).remove();
    data = jQuery.parseJSON(data);
    //create_items_table(data);
  });
}

function create_items_table(data) {
  var total_sum = 0;
  cart_list =
    '<table class="table-bordered" style="width:100%"><tr><th>Restaurant</th><th>Food Cetegory</th><th>Food Name</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr>';
  //$('#msg').html(data);
  //console.log(data);
  restaurant_names = {};
  for (var i in data) {
    var counter = data[i];
    restaurant_names[counter.restaurant_name] = counter.restaurant_address;
    cart_list =
      cart_list +
      '<tr id="r_' +
      counter.item_cart_id +
      '"><td>' +
      counter.restaurant_name +
      "</td><td>" +
      counter.restaurant_food_category +
      "</td><td>" +
      counter.restaurant_food_name +
      '</td><td><input id="restaurant_food_price_' +
      counter.item_cart_id +
      '" type="hidden" value="' +
      counter.restaurant_food_price +
      '"  />' +
      counter.restaurant_food_price +
      '</td><td><input  id="quantity_' +
      counter.item_cart_id +
      '" step="0.5" min="0"  max="99" type="number" value="' +
      counter.quantity +
      '" style="width: 52px;" onclick="icrement_cart_item_quantity(' +
      counter.item_cart_id +
      ')" onkeyup="icrement_cart_item_quantity(' +
      counter.item_cart_id +
      ')"/></td><td><input type="hidden" class="total" id="total_' +
      counter.item_cart_id +
      '" name="total[' +
      counter.item_cart_id +
      ']" value="' +
      counter.quantity * counter.restaurant_food_price +
      '" /><span id="total_td_' +
      counter.item_cart_id +
      '">' +
      counter.quantity * counter.restaurant_food_price +
      '</span></td><td><button onclick="remove_cart_item(' +
      counter.item_cart_id +
      ')" type="button" class="close">×</button></td></tr>';
    total_sum = total_sum + counter.quantity * counter.restaurant_food_price;
  }

  cart_list =
    cart_list +
    '</table><h4 class="pull-right" >Total Rs: <span id="total_rs">' +
    total_sum +
    "</span></h4>";
  $("#cart_list").html(cart_list);
  restaurantNames = "";
  /*var picking_location = $("#picking_location").magicSuggest({});
    picking_location.clear();
    for (var i in restaurant_names) {
        restaurantNames = restaurantNames + restaurant_names[i] + ', ';
        picking_location.setData([restaurant_names[i]]);
        picking_location.setValue([restaurant_names[i]]);
    }*/

  $("#pac-input2").val("");
  restaurantNames = "";
  for (var i in restaurant_names) {
    restaurantNames = restaurantNames + restaurant_names[i] + " : ";
  }

  $("#pac-input2").val(restaurantNames);

  console.log(data[0].street_number);
  $("#street_number2").val(data[0].restaurant_street_number);
  $("#route2").val(data[0].restaurant_route);
  $("#locality2").val(data[0].restaurant_city);
  $("#administrative_area_level_12").val(data[0].restaurant_province);
  $("#country2").val(data[0].restaurant_country);
  $("#latitude2").val(data[0].restaurant_longitude);
  $("#longitude2").val(data[0].restaurant_latitude);
}

function set_mobile_number_in_field(customer_mobile_no) {
  $("#customer_mobile_no").val(customer_mobile_no);
  $("#search").val(customer_mobile_no);
  get_mobile_detail();
  //searched_order();
}

function check_customer_mobile_no() {
  if (event.keyCode == 13) {
    get_mobile_detail();
  }
}

function get_mobile_detail() {
  var customer_mobile_no = $("#customer_mobile_no").val();

  $.ajax({
    type: "POST",
    url: site_url + "/orders/check_customer_detail/" + customer_mobile_no,
    data: {},
  }).done(function (data) {
    //alert(data);
    data = jQuery.parseJSON(data);

    if (data.found) {
      $("#customer_name").val(data.customer_name);
      $("#comment").val(data.comment);
      $("#customer_id").val(data.customer_id);

      /* var picking_location = $("#picking_location").magicSuggest({});
            picking_location.setData(data.customer_locations);

            var delivery_location = $("#delivery_location").magicSuggest({});
            delivery_location.setData(data.customer_locations);*/

      customer_locations = data.customer_locations;
      var picking_location_suggestion = "";
      var delivery_location_suggestion = "";
      for (var i in customer_locations) {
        var customer_location = customer_locations[i];

        console.log(customer_locations);
        picking_location_suggestion =
          picking_location_suggestion +
          '<span class="ms-sel-item"> ' +
          customer_location.name +
          ' <i class="fa fa-check" onclick="add_to_picking_location(\'' +
          customer_location.id +
          "')\"></i> </span>";
        delivery_location_suggestion =
          delivery_location_suggestion +
          '<span class="ms-sel-item"> ' +
          customer_location.name +
          ' <i class="fa fa-check" onclick="add_to_delivery_location(\'' +
          customer_location.id +
          "')\"></i> </span>";
      }
      $("#picking_location_suggestion").html(picking_location_suggestion);
      $("#picking_location_suggestion").show();
      $("#delivery_location_suggestion").html(delivery_location_suggestion);
      $("#delivery_location_suggestion").show();
    } else {
      //alert();
      $("#customer_name").val("");
      $("#comment").val("");
      $("#customer_id").val("0");

      $("#picking_location_suggestion").html("");
      $("#picking_location_suggestion").hide();
      $("#delivery_location_suggestion").html("");
      $("#delivery_location_suggestion").hide();
    }
  });
}

function add_to_delivery_location(location_id) {
  $.ajax({
    type: "POST",
    url: site_url + "/orders/customer_location_detail/" + location_id,
    data: {},
  }).done(function (data) {
    data = jQuery.parseJSON(data);
    location_information = data;
    $("#pac-input").val(location_information.location_address);
    $("#street_number").val(location_information.street_number);
    $("#route").val(location_information.route);
    $("#locality").val(location_information.city);
    $("#administrative_area_level_1").val(location_information.province);
    $("#country").val(location_information.country);
    $("#postal_code").val(location_information.postal_code);
    $("#latitude").val(location_information.latitude);
    $("#longitude").val(location_information.longitude);

    console.log(location_information);
  });
  /*var delivery_location = $("#delivery_location").magicSuggest({});
    var address = [delivery_location_suggestion];
    delivery_location.setValue(address);*/
}

function add_to_picking_location(location_id) {
  $.ajax({
    type: "POST",
    url: site_url + "/orders/customer_location_detail/" + location_id,
    data: {},
  }).done(function (data) {
    data = jQuery.parseJSON(data);
    location_information = data;
    $("#pac-input2").val(location_information.location_address);
    $("#street_number2").val(location_information.street_number);
    $("#route2").val(location_information.route);
    $("#locality2").val(location_information.city);
    $("#administrative_area_level_12").val(location_information.province);
    $("#country2").val(location_information.country);
    $("#postal_code2").val(location_information.postal_code);
    $("#latitude2").val(location_information.latitude);
    $("#longitude2").val(location_information.longitude);

    console.log(location_information);
  });

  //get location detail

  /*var picking_location = $("#picking_location").magicSuggest({});
    var address = [picking_location_suggestion];
    picking_location.setValue(address);*/
}

function add_delivery_charges(add_delivery_charges) {
  $("#delivery_charges").val(add_delivery_charges);
}

function add_delivery_time(add_delivery_time) {
  $("#delivery_time").val(add_delivery_time);
}

function show_pre_oreder_options() {
  var check = document.getElementById("pre_order").checked;

  if (check) {
    $(".preorder").show();
  } else {
    $(".preorder").hide();
    $("#orderer_name").val("");
    $("#order_ready_time").val("");
  }
}

function add_order_ready_time(add_order_ready_time) {
  $("#order_ready_time").val(add_order_ready_time);
}

function set_extra(extra) {
  var extra_value = $("#extra").val();
  $("#extra").val(extra_value + " " + extra + ", ");
}

function get_all_mobile_numbers() {
  $.ajax({
    type: "POST",
    url: site_url + "/orders/get_mobiles_numbers/",
    data: {},
  }).done(function (data) {
    //alert(data);
    data = jQuery.parseJSON(data);
    //alert(data);
    var mobile_numbers =
      '<li style="color:red; cursor:pointer" onclick="get_all_mobile_numbers()"> <strong>Live Mobile No.</strong> </li>';
    for (var i in data) {
      var counter = data[i];
      mobile_numbers +=
        "<li> <a href=\"javascript:set_mobile_number_in_field('" +
        counter.caller_id +
        '\');" ><i class="fa fa-mobile" aria-hidden="true"></i>  ' +
        counter.caller_id +
        "</a></li>";
    }
    $("#mobile_numbers").html(mobile_numbers);
  });
}
