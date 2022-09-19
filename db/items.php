<?php

class Items {

  private $conn;

  public function __construct($_conn) {
    $this->conn = $_conn;
  }

  public function selectAllByInvoiceId($_id, $_limit=-1) {
    $sql = "SELECT * FROM `items` WHERE `invoice_id`=:id";
    $sql .= $_limit === -1 ? "" : "LIMIT ".$_limit;
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([":id" => $_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insert($_params) {
    $sql = "INSERT INTO `items` (";
    $sql .= join(", ", array_keys($_params));
    $sql .= ") VALUES (";
    $sql .= ":".join(", :", array_keys($_params));
    $sql .= ")";

    $stmt = $this->conn->prepare($sql);
    $params = [];
    foreach ($_params as $key => $value) {
      $params[":".$key] = $value;
    }
    $stmt->execute($_params);
    return $this->conn->lastInsertId();
  }
}
