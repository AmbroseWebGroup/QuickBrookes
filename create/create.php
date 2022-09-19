<?php

include_once("../db/db.php");
session_start();

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
  header("Location: ../");
}

$db = new Database();

$invoiceId = $db->invoices->insert([
  "date_created" => $_POST["date_created"],
  "date_due" => date('Y-m-d', strtotime($_POST['date_created']. ' + '.$_POST['due_period'].' days')),
  "customer_id" => $_POST['customer_id'],
  "state" => "created"
]);

for ($i = 0; $i < sizeof($_POST['description']); $i++) {
  $db->items->insert([
    "invoice_id" => $invoiceId,
    "description" => $_POST['description'][$i],
    "unit_price" => $_POST['unit_price'][$i],
    "quantity" => $_POST['quantity'][$i]
  ]);
}

header("Location: ../");