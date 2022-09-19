<?php

require_once '../../users/init.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

include_once("../db/db.php");
session_start();

$db = new Database();

$customers = $db->customers->selectAll("");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/master.css" />
  <link rel="stylesheet" href="../css/customers.css" />
  <script type="text/javascript">
    function addRow() {
      if (document.getElementsByClassName("new-company").length>0) return;
      let newElt = document.createElement("tr");
      newElt.innerHTML = `<td class="new-company"><input type="number" name="id[]" value="-1" readonly class="id"/></td><td><input type="text" name="name[]" value="" class="name"/></td><td><input type="text" name="address[]" value="" class="address"/></td>`;
      document.getElementsByTagName("tbody")[0].appendChild(newElt);
    }
  </script>
  <title>QuickBrookes | Customers</title>
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
    <table>
      <thead>
        <th>ID (fixed)</th>
        <th>Name</th>
        <th style="width:100%">Address</th>
        <th>Active</th>
      </thead>
      <tbody>
        <?php foreach ($customers as $customer) { ?>
          <tr>
            <td>
              <input type="number" value="<?php echo $customer['id'] ?>" readonly class="id" />
              <input type="hidden" name="id[]" value="<?php echo $customer['id'] ?>" />
            </td>
            <td>
              <input type="text" name="name[]" value="<?php echo $customer['name'] ?>" class="name" />
            </td>
            <td>
              <input type="text" name="address[]" value="<?php echo $customer['address'] ?>" class="address" />
            </td>
            <td>
              <input type="checkbox" name="state[]" value="<?php echo $customer['id'] ?>" <?php echo $customer['state']=="active" ? "checked" : "" ?> class="state" />
            </td>
          </tr>
        <?php } ?>
      </tbody>
      <tr class="add-row">
        <td colspan="4">
          <button type="button" onclick="addRow()">Add</button>
        </td>
      </tr>
    </table>
    <button type="submit">Save</button>
  </form>
</body>
</html>