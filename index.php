<?php

require_once '../users/init.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

include_once("./db/db.php");
session_start();

$db = new Database();
$invoices = $db->invoices->selectAll();
$_invoices = [];
foreach ($invoices as $invoice) {
  $dt = new DateTime($invoice['date_created']);
  $invoice['date_created'] = $dt->format("d/m/Y");
  array_push($_invoices, $invoice);
}
$invoices = $_invoices;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/master.css" />
  <link rel="stylesheet" href="./css/index.css" />
  <title>QuickBrookes | Home</title>
</head>
<body>
  <header>
    <a href="https://platform.ambroseweb.co.uk"><img src="https://ambroseweb.co.uk/imgs/awg-rectangle-logo.png" alt="Ambrose Web Logo" /></a>
    <h1>QuickBrookes</h1>
  </header>
  <nav>
    <a href="./create/">Create New</a>
    <a href="#">Advanced Search</a>
    <a href="./customers/">Manage Customers</a>
  </nav>
  <ul class="key">
    <span class="created">Created</span>
    <span class="estimated">Estimated</span>
    <span class="invoiced">Invoiced</span>
    <span class="paid">Paid</span>
    <span class="voided">Voided</span>
  </ul>
  <ul class="invoices">
    <?php foreach ($invoices as $invoice) { ?>
      <li>
        <span
          class="inv-state <?php echo $invoice['state'] ?>"
        ></span>
        <span class="inv-number"><?php echo sprintf('%04d', $invoice['id']); ?></span>
        <span class="inv-customer">
          <?php echo $invoice['customer_name'] ?>
        </span>
        <span class="inv-date">
          <?php echo $invoice['date_created'] ?>
        </span>
        <button type="button" name="button" onclick="document.location.href='./invoice/?id=<?php echo $invoice['id']; ?>'">Open</button>
      </li>
    <?php } ?>
  </ul>
</body>
</html>