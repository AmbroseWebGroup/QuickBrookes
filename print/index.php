<?php

require_once '../../users/init.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

include_once("../db/db.php");
session_start();

$db = new Database();

if (!isset($_GET['id'])) {
  header("Location: ../");
}

$invoice = $db->invoices->selectById($_GET['id']);
if ($invoice === -1) {
  header("Location: ../");
}

$items = $db->items->selectAllByInvoiceId($invoice['id']);

$total = 0;
foreach ($items as $item) {
  $total += $item['unit_price'] * $item['quantity'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/master.css" />
  <link rel="stylesheet" href="../css/print.css" />
  <script src="../js/print.js" charset="utf-8"></script>
  <title>Invoice <?php echo formatInvoiceNumber($invoice['id']) ?></title>
</head>
<body>
  <div class="templates">
    <h2>Select a Template:</h2>
    <button onclick="selectTemplate('estimate')">Estimate</button>
    <button onclick="selectTemplate('invoice')">Invoice</button>
    <button onclick="selectTemplate('receipt')">Receipt</button>
  </div>
  <div class="container">
    <section class="header">
      <img src="https://ambroseweb.co.uk/imgs/awg-rectangle-logo.png" alt="Ambrose Web Logo" id="logo" />
      <h1>Invoice</h1>
    </section>
    <section class="details">
      <div>
        <span class="address-head">Issued to:</span>
        <strong><?php echo $invoice['customer_name'] ?></strong><br>
        <?php
          echo join(
            "<br>", array_filter(
              explode(",", $invoice['customer_address'])
            )
          );
        ?>
      </div>
      <div>
        <span class="address-head">Payable to:</span>
        <strong>Ambrose Web</strong><br>
        34 Buckhaft Road<br>
        Cinderford<br>
        GL14 3DU
      </div>
      <div class="right">
        <span>Invoice no:</span> <p><?php echo formatInvoiceNumber($invoice['id']) ?></p>
        <span>Issued:</span> <p><?php echo formatDate($invoice['date_created']) ?></p>
        <span class="not-estimate">Due:</span> <p class="not-estimate"><?php echo formatDate($invoice['date_due']) ?></p>
        <span class="only-receipt">Paid:</span> <p class="only-receipt"><?php echo formatDate($invoice['date_paid']) ?></p>
      </div>
    </section>
    <section class="items">
      <table>
        <thead>
          <th style="width:100%">Description</th>
          <th>Unit Price</th>
          <th>Quantity</th>
          <th>Price</th>
        </thead>
        <tbody>
          <?php foreach ($items as $item) { ?>
            <tr>
              <td>
                <p class="description"><?php echo $item['description'] ?></p>
              </td>
              <td>
                <p class="unit_price"><?php echo formatCurrency($item['unit_price']) ?></p>
              </td>
              <td>
                <p class="quantity"><?php echo $item['quantity'] ?></p>
              </td>
              <td>
                <p class="price"><?php echo formatCurrency($item['unit_price'] * $item['quantity']) ?></p>
              </td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3">Subtotal</td>
            <td class="subtotal"><?php echo formatCurrency($total) ?></td>
          </tr>
          <tr>
            <td colspan="3">Discount (0%)</td>
            <td class="discount">£ 0.00</td>
          </tr>
          <tr>
            <td colspan="3">Total</td>
            <td class="total"><?php echo formatCurrency($total) ?></td>
          </tr>
        </tfoot>
      </table>
    </section>
    <section class="footer">
      <p class="not-estimate">This document is requesting payment for the products and services listed above on the "Issued" date. The total amount is due to be paid by the "Due" date in full. If the amount is not paid by the "Due" date listed, a surcharge may be incurred for belated payment and administration fees. The payment is valid via any of the following payment methods in any combination:</p>
      <p class="only-estimate">This document is an estimatation of the payment amount requested when providing the products and services listed above. The prices displayed in this document are not gauranteed and are subject to change with availability, market fluctuations and other factors. When you agree to being happy with the information given above, an invoice will be sent listing the final prices for products and services.<br><strong>THIS DOCUMENT IS NOT REQUESTING PAYMENT</strong></p>
      <ul class="not-estimate">
        <li>Cash payment</li>
        <li>BACS payment:<br>Cobain Ambrose, A/N: 66252407, S/C: 60-15-26</li>
      </ul>
      <img src="https://ambroseweb.co.uk/imgs/awg-rectangle-logo.png" />
      <p>Ambrose Web &copy; 2022</p>
    </section>
  </div>
</body>
</html>