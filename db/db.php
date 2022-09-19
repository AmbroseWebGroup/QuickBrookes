<?php

include_once(dirname(__FILE__)."/helpers.php");
include_once(dirname(__FILE__)."/invoices.php");
include_once(dirname(__FILE__)."/items.php");
include_once(dirname(__FILE__)."/customers.php");

class Database extends PDO {

  private $db_name;
  private $host;
  private $username;
  private $password;

  public $invoices;
  public $items;
  public $customers;

  public function __construct() {
    $credentials = json_decode(file_get_contents(dirname(__FILE__)."/credentials.json"),false);

    $this->db_name = $credentials->db_name;
    $this->host = $credentials->host;
    $this->username = $credentials->username;
    $this->password = $credentials->password;

    parent::__construct('mysql:dbname='.$this->db_name.';host='.$this->host, $this->username, $this->password);

    $this->invoices = new Invoices($this);
    $this->items = new Items($this);
    $this->customers = new Customers($this);
  }
}
