<?php
require_once 'vendor/autoload.php';

use ShopExpress\ApiClient\ApiClient;




$page = (int) $_GET['page'];
$per_page = (int) $_GET['perpage'];

$start = $page * $per_page;

$api = new ApiClient(
    'lNwzuV_Gb',
    'admin',
    'http://newshop.kupikupi.org/adm/api'
);

echo $api->get('orders', ['start' => $start, 'limit' => $per_page])->getBody();