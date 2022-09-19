<?php

require_once '../../users/init.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

include_once("../db/db.php");
session_start();

$db = new Database();

if (!isset($_POST['id'])) {
  header("Location: ../");
}

if ($_POST['date_paid'] == "") {
  $db->invoices->update($_POST['id'], [
    "state" => $_POST['state']
  ]);
} else {
  $db->invoices->update($_POST['id'], [
    "date_paid" => $_POST['date_paid'],
    "state" => $_POST['state']
  ]);
}

header("Location: ./?id=".$_POST['id']);