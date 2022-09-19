<?php

include_once("../db/db.php");
session_start();

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
  die("Not authorised");
}

$db = new Database();

for ($i = 0; $i < sizeof($_POST['id']); $i++) {
  if ($_POST['id'][$i] == -1) {
    $db->customers->insert([
      "name" => $_POST['name'][$i],
      "address" => $_POST['address'][$i]
    ]);
    continue;
  }

  $db->customers->update($_POST['id'][$i], [
    "name" => $_POST['name'][$i],
    "address" => $_POST['address'][$i],
    "state" => in_array($_POST['id'][$i], $_POST['state']) ? "active" : "inactive"
  ]);
}

header("Location: ./");