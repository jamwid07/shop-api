<?php
error_reporting(E_ALL);
require 'vendor/autoload.php';

use ShopExpress\ApiClient\ApiClient;


$api = new ApiClient(
    'lNwzuV_Gb',
    'admin',
    'http://newshop.kupikupi.org/adm/api'
);

$resp = $api->get('orders', ['start' => 0, 'limit' => 10])->getBody();
$resp = json_decode($resp);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop API</title>
    <style>
        .container {
            max-width: 1400px;
            margin: 10px auto;
        }
        .orders {
            border: 1px solid black;
        }
        th {
            border-bottom: 1px solid black
        }
        td, th {
            padding: 3px;
        }
        .nav {
            margin-top: 10px;
            float: left;
        }
    </style>
</head>
<body>
<div class="container">
    <table class="orders" cellspacing="0">
        <tr>
            <th>Order ID</th>
            <th>FIO</th>
            <th>Summ</th>
        </tr>
<?php
    foreach ($resp->orders as $order) {
        echo '<tr><td>'
        . $order->order_id . '</td><td>'
        . $order->fio . '</td><td>'
        . $order->summ . '</td><td>'
        . '</td></tr>';
    }
?>
    </table>
    <div class="nav">
        <button id="prev" disabled>prev</button>
        <button id="next">next</button>
    </div>
</div>
<script src="jquery.js"></script>
<script>
  let page = 0;
  let perpage = 10;
  let total = <?= $resp->total ?>

  $(document).ready(function () {

      function getContent(page) {
        $.get('/page.php?page=' + page + '&perpage=' + perpage)
          .done(function (raw) {
            let data = JSON.parse(raw);
            let orders = data.orders;
            let table = $('table.orders');
            table.html(
              "        <tr>\n" +
              "            <th>Order ID</th>\n" +
              "            <th>FIO</th>\n" +
              "            <th>Summ</th>\n" +
              "        </tr>\n")
            for (i = 0; i < perpage; i++) {
              row = "<tr><td>" + orders[i].order_id + "</td>"
                + "<td>" + orders[i].fio + "</td>"
                + "<td>" + orders[i].summ + "</td></tr>";
              table.append(row);
            }
          })
      }
      $('#next').on('click', function () {
        page++;
        getContent(page);
        $('#prev').removeAttr('disabled');
        if ((page+1)*perpage > total) {
          $(this).attr('disabled', true);
        }
      })
      $('#prev').on('click', function () {
        page--;
        getContent(page);
        if (page === 0) {
          $(this).attr('disabled', true)
        }
        if ($('#next').attr('disabled') == 'disabled') {
          $('#next').removeAttr('disabled');
        }
      })
      let table = $('table');
    })
</script>
</body>
</html>
