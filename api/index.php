<?php

require('./secrets.php');

if($secrets['debug']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = file_get_contents('php://input');

    if (json_decode($data)->status) {
        $ch = curl_init($secrets['mailchimpUrl']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic '.base64_encode('user:' . $secrets['mailchimpApiKey']),
            'Content-Length: ' . strlen($data)),
        );
        $result = curl_exec($ch);
        echo $result;
    }
    /*
    id: "8a184b9452cba6316850f743bdde0876"
    email_address: "rrd@1108.cc"
    unique_email_id: "bcbdee60f6"
    web_id: 316941813
    email_type: "html"
    status: "subscribed"
    merge_fields: {}
    stats: {avg_open_rate: 0.25, avg_click_rate: 0.05,…}
    avg_open_rate: 0.25
    avg_click_rate: 0.05
    ecommerce_data: {total_revenue: 8554, number_of_orders: 2, currency_code: "USD"}
    total_revenue: 8554
    number_of_orders: 2
    currency_code: "USD"
    ip_signup: "188.93.203.160"
    timestamp_signup: "2017-06-10T10:07:56+00:00"
    ip_opt: "188.93.203.160"
    timestamp_opt: "2020-02-22T13:34:19+00:00"
    member_rating: 4
    last_changed: "2020-02-22T13:34:19+00:00"
    language: ""
    vip: false
    email_client: "Gmail"
    location: {latitude: 46.6037, longitude: 17.6277, gmtoff: 0, dstoff: 0, country_code: "HU", timezone: ""}
    marketing_permissions: [{marketing_permission_id: "bb56c8bbd1", text: "Elfogadom", enabled: false}]
    0: {marketing_permission_id: "bb56c8bbd1", text: "Elfogadom", enabled: false}
    source: "Krisna-völgy webáruház"
    tags_count: 0
    tags: []
    list_id: "20fdc26fb9"
    */
}