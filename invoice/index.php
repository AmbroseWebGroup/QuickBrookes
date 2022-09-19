<?php

require_once '../../users/init.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

include_once("../db/db.php");
session_start();

$db = new Database();

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
  <link rel="stylesheet" href="../css/invoice.css" />
  <title>QuickBrookes | Invoice <?php echo formatInvoiceNumber($invoice['id']) ?></title>
</head>
<body>
  <header>
    <a href="https://platform.ambroseweb.co.uk"><img src="https://ambroseweb.co.uk/imgs/awg-rectangle-logo.png" alt="Ambrose Web Logo" /></a>
    <h1>QuickBrookes</h1>
  </header>

  <div class="back-arrow">
    <a href="../"><img src="../imgs/arrow-left.png" alt="Back Arrow" /></a>
  </div>

  <form action="./update.php" method="post">
    <fieldset class="details">
      <legend>Invoice Details</legend>

      <label for="date_created">Invoice</label>
      <input type="text" name="invoice_number" value="<?php echo formatInvoiceNumber($invoice['id']) ?>" readonly />
      <input type="hidden" name="id" value="<?php echo $invoice['id'] ?>" />

      <label for="date_created">Creation Date</label>
      <input type="date" name="date_created" value="<?php echo formatDate($invoice['date_created']) ?>" readonly />

      <label for="date_due">Due Date</label>
      <input type="date" name="date_due" value="<?php echo formatDate($invoice['date_due']) ?>" readonly />

      <label for="date_paid">Date Paid</label>
      <input type="date" name="date_paid" value="<?php echo formatDate($invoice['date_paid']) ?>" />

      <label for="customer">Customer</label>
      <input type="text" name="customer_name" value="<?php echo $invoice['customer_name'] ?>" readonly />

      <label for="state">State</label>
      <select name="state">
        <option value="created" <?php if ($invoice['state'] == 'created') {echo 'selected';} ?>>
          Created
        </option>
        <option value="estimated" <?php if ($invoice['state'] == 'estimated') {echo 'selected';} ?>>
          Estimated
        </option>
        <option value="invoiced" <?php if ($invoice['state'] == 'invoiced') {echo 'selected';} ?>>
          Invoiced
        </option>
        <option value="paid" <?php if ($invoice['state'] == 'paid') {echo 'selected';} ?>>
          Paid
        </option>
        <option value="voided" <?php if ($invoice['state'] == 'voided') {echo 'selected';} ?>>
          Voided
        </option>
      </select>
    </fieldset>

    <fieldset class="items">
      <legend>Invoice Items</legend>
      <table>
        <thead>
          <tr>
            <th style="width: 100%;">Description</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item) { ?>
            <tr>
              <td>
                <input type="text" class="description" value="<?php echo $item['description'] ?>" readonly />
              </td>
              <td>
                <input
                  type="text"
                  class="unit_price"
                  value="<?php echo formatCurrency($item['unit_price']) ?>"
                  readonly
                />
              </td>
              <td>
                <input
                  type="text"
                  class="quantity"
                  value="<?php echo $item['quantity'] ?>"
                  readonly
                />
              </td>
              <td>
                <input type="text" value="<?php echo formatCurrency($item['unit_price'] * $item['quantity']) ?>" class="price" readonly />
              </td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3">Total</td>
            <td>
              <input type="text" class="total" value="<?php echo formatCurrency($total) ?>" readonly />
            </td>
          </tr>
        </tfoot>
      </table>
    </fieldset>
    <fieldset class="buttons">
      <button type="submit">Save</button>
      <button type="button" onclick="document.location.href = '../print?id=<?php echo $invoice['id'] ?>'">Print</button>
    </fieldset>
  </form>

</body>
</html>
