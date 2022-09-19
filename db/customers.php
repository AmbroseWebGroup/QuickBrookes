<?php

class Customers {

  private $conn;

  public function __construct($_conn) {
    $this->conn = $_conn;
  }

  public function selectAll($_state='active', $_limit=-1) {
    $sql = "SELECT * FROM `customers`";
    $sql .= $_state=='active' ? " WHERE `state`='active'" : "";
    $sql .= $_limit === -1 ? "" : "LIMIT ".$_limit;
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insert($_params) {
    $sql = "INSERT INTO `customers` (";
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

  function update($_id, $_params) {
    $sql = "UPDATE `customers` SET ";

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
