<?php

// =============================================================================== //
//
// CONFIGURATION
//
// =============================================================================== //

function xenopanel2_ConfigOptions() {
    $configarray = array(
    'plan_id' => array(
    'FriendlyName' => 'Plan ID',
    'Type' => 'text',
    'Size' => '15',
    'Default' => '',
    'Description' => 'Manage packages in XenoPanel by going to Admin Dashboard > API > Module Plans Manager',
    )
  ); return $configarray;
}

// =============================================================================== //
//
// SERVER MANAGE
//
// =============================================================================== //

function xenopanel2_CreateAccount($params){

    $clientsdetails = $params["clientsdetails"];

    $api_host = $params["serverhostname"];
    $postdata['api_key'] = $params["serveraccesshash"];
    $postdata['api_user'] = $params["serverusername"];
    $postdata['product_id'] = $params["serviceid"];

    $postdata['first_name'] = $clientsdetails['firstname'];
    $postdata['last_name'] = $clientsdetails['lastname'];
    $postdata['email_address'] = $clientsdetails['email'];

    $postdata['user_id'] = $clientsdetails['userid'];
    $postdata['plan_id'] = $params['configoption1'];
    
    $postdata['get_minecraft'] = $params['customfields']['Minecraft Username'];
    $postdata['get_username'] = $params['customfields']['Username'];
    $postdata['get_default'] = $params['customfields']['Server Name'];

    $postdata['get_dedicated'] = $params['configoptions']['Dedicated IP'];
    $postdata['get_location'] = $params['configoptions']['Location'];
    $postdata['get_game'] = $params['configoptions']['Game'];
    
    $postdata['get_slots'] = $params['configoptions']['Slots'];
    $postdata['get_memory'] = $params['configoptions']['Memory'];
    $postdata['get_storage'] = $params['configoptions']['Storage'];
    $postdata['get_cpu'] = $params['configoptions']['CPU Limit'];
    
    $postdata['get_slot_change'] = $params['configoptions']['Slot Changing'];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_host."/api/v2/admin/create_server");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    $data = curl_exec($ch);
    curl_close($ch);

    if (strpos($data, 'success') !== false) {

        $data = json_decode($data, TRUE);

        $command = "updateclientproduct";
        $values["serviceid"] = $params["serviceid"];
        $values["serviceusername"] = $data['username'];
        $values["servicepassword"] = $data['password'];
        $values["dedicatedip"] = $data['ip_address'].":".$data['port'];
        $values["domain"] = $data['server_id'];

        localAPI($command, $values, $params["serverusername"]);
        $results = localAPI($command, $values, $params["serverusername"]);

        return 'success';

    } else {

        return $data;

    }
}

function xenopanel2_TerminateAccount($params) {

    $clientsdetails = $params["clientsdetails"];

    $api_host = $params["serverhostname"];
    $postdata['api_key'] = $params["serveraccesshash"];
    $postdata['api_user'] = $params["serverusername"];
    $postdata['product_id'] = $params["serviceid"];

    $postdata['first_name'] = $clientsdetails['firstname'];
    $postdata['last_name'] = $clientsdetails['lastname'];
    $postdata['email_address'] = $clientsdetails['email'];

    $postdata['user_id'] = $clientsdetails['userid'];
    $postdata['plan_id'] = $params['configoption1'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_host."/api/v2/admin/delete_server");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    $data = curl_exec($ch);
    curl_close($ch);

    if (strpos($data, 'success') !== false) {

      $command = "updateclientproduct";
      $values["serviceid"] = $params["serviceid"];
      $values["serviceusername"] = " ";
      $values["servicepassword"] = " ";
      $values["dedicatedip"] = " ";
      $values["domain"] = " ";

      localAPI($command, $values, $params["serverusername"]);
      $results = localAPI($command, $values, $params["serverusername"]);

      return 'success';

    } else {

      return $data;

    }

}

function xenopanel2_ChangePackage($params) {

    $clientsdetails = $params["clientsdetails"];

    $api_host = $params["serverhostname"];
    $postdata['api_key'] = $params["serveraccesshash"];
    $postdata['api_user'] = $params["serverusername"];
    $postdata['product_id'] = $params["serviceid"];

    $postdata['first_name'] = $clientsdetails['firstname'];
    $postdata['last_name'] = $clientsdetails['lastname'];
    $postdata['email_address'] = $clientsdetails['email'];

    $postdata['user_id'] = $clientsdetails['userid'];
    $postdata['plan_id'] = $params['configoption1'];
    
    $postdata['get_minecraft'] = $params['customfields']['Minecraft Username'];
    $postdata['get_username'] = $params['customfields']['Username'];
    $postdata['get_default'] = $params['customfields']['Server Name'];

    $postdata['get_dedicated'] = $params['configoptions']['Dedicated IP'];
    $postdata['get_location'] = $params['configoptions']['Location'];
    $postdata['get_game'] = $params['configoptions']['Game'];
    
    $postdata['get_slots'] = $params['configoptions']['Slots'];
    $postdata['get_memory'] = $params['configoptions']['Memory'];
    $postdata['get_storage'] = $params['configoptions']['Storage'];
    $postdata['get_cpu'] = $params['configoptions']['CPU Limit'];
    
    $postdata['get_slot_change'] = $params['configoptions']['Slot Changing'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_host."/api/v2/admin/upgrade_server");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    $data = curl_exec($ch);
    curl_close($ch);

    if (strpos($data, 'success') !== false) {

      return 'success';

    } else {

      return $data;

    }

}

function xenopanel2_SuspendAccount($params) {

    $clientsdetails = $params["clientsdetails"];

    $api_host = $params["serverhostname"];
    $postdata['api_key'] = $params["serveraccesshash"];
    $postdata['api_user'] = $params["serverusername"];
    $postdata['product_id'] = $params["serviceid"];

    $postdata['first_name'] = $clientsdetails['firstname'];
    $postdata['last_name'] = $clientsdetails['lastname'];
    $postdata['email_address'] = $clientsdetails['email'];

    $postdata['user_id'] = $clientsdetails['userid'];
    $postdata['plan_id'] = $params['configoption1'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_host."/api/v2/admin/suspend_server");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    $data = curl_exec($ch);
    curl_close($ch);

    if (strpos($data, 'success') !== false) {

      return 'success';

    } else {

      return $data;

    }

}

function xenopanel2_UnSuspendAccount($params) {

    $clientsdetails = $params["clientsdetails"];

    $api_host = $params["serverhostname"];
    $postdata['api_key'] = $params["serveraccesshash"];
    $postdata['api_user'] = $params["serverusername"];
    $postdata['product_id'] = $params["serviceid"];

    $postdata['first_name'] = $clientsdetails['firstname'];
    $postdata['last_name'] = $clientsdetails['lastname'];
    $postdata['email_address'] = $clientsdetails['email'];

    $postdata['user_id'] = $clientsdetails['userid'];
    $postdata['plan_id'] = $params['configoption1'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_host."/api/v2/admin/unsuspend_server");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    $data = curl_exec($ch);
    curl_close($ch);

    if (strpos($data, 'success') !== false) {

      return 'success';

    } else {

      return $data;

    }

}

function xenopanel2_TestConnection(array $params){

    $postdata['api_key'] = $params["serveraccesshash"];
    $postdata['api_user'] = $params["serverusername"];
    $api_host = $params["serverhostname"];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_host."/api/v2/admin/test_connection");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    $data = curl_exec($ch);
    curl_close($ch);

    if (strpos($data, 'success') !== false) {

      $success = true;
      $errorMsg = '';
      return array(
        'success' => $success,
        'error' => $errorMsg,
       );

    } else {

      $data = json_decode($data, TRUE);

      $success = false;
      $errorMsg = '';
      return array(
        'success' => $success,
        'error' => $data['failed'],
      );

    }

}

// =============================================================================== //
//
// CONTROL FUNCTIONS
//
// =============================================================================== //

function xenopanel2_info($params) {

    $clientsdetails = $params["clientsdetails"];

    $api_host = $params["serverhostname"];
    $postdata['api_key'] = $params["serveraccesshash"];
    $postdata['api_user'] = $params["serverusername"];
    $postdata['product_id'] = $params["serviceid"];

    $postdata['first_name'] = $clientsdetails['firstname'];
    $postdata['last_name'] = $clientsdetails['lastname'];
    $postdata['email_address'] = $clientsdetails['email'];

    $postdata['user_id'] = $clientsdetails['userid'];
    $postdata['plan_id'] = $params['configoption1'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_host."/api/v2/admin/info_server");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;

}

function xenopanel2_AdminCustomButtonArray() {
    $buttonarray = array(
      "Server Details" => 'info'
    );
    return $buttonarray;
}

?>
