<?php

class Invoices {

  private $conn;

  public function __construct($_conn) {
    $this->conn = $_conn;
  }

  public function selectAll($_limit=-1) {
    $sql = "SELECT * FROM `invoices_view` ORDER BY `date_created` DESC";
    $sql .= $_limit === -1 ? "" : "LIMIT ".$_limit;
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insert($_params) {
    $sql = "INSERT INTO `invoices` (";
    $sql .= join(", ", array_keys($_params));
    $sql .= ") VALUES (";
    $sql .= ":".join(", :", array_keys($_params));
    $sql .= ")";

    $stmt = $this->conn->prepare($sql);
    $params = [];
    foreach ($_params as $key => $value) {
      $params[":".$key] = $value;
    }
    $stmt->execute($params);
    return $this->conn->lastInsertId();
  }

  function selectById($_id) {
    $sql = "SELECT * FROM `invoices_view` WHERE `id`=:id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      ":id" => $_id
    ]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      return $row;
    }
    return -1;
  }

  function update($_id, $_params) {
    $sql = "UPDATE `invoices` SET ";

    $sql .= join(", ", array_map(function ($_value) {
      return "`$_value` = :$_value";
    }, array_keys($_params)));

    $sql .= " WHERE `id` = :id;";


    $stmt = $this->conn->prepare($sql);
    $params = [":id" => $_id];
    foreach ($_params as $key => $value) {
      $params[":".$key] = $value;
    }
    $stmt->execute($params);
  }
}
