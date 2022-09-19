CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `state` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_due` datetime NOT NULL DEFAULT current_timestamp(),
  `date_paid` datetime DEFAULT NULL,
  `state` enum('created','estimated','invoiced','paid','voided') NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `description` varchar(512) NOT NULL,
  `unit_price` decimal(5,2) NOT NULL DEFAULT 0.00,
  `quantity` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE VIEW `invoices_view` AS SELECT `invoices`.`id` AS `id`, `invoices`.`date_created` AS `date_created`, `invoices`.`date_due` AS `date_due`, `invoices`.`date_paid` AS `date_paid`, `invoices`.`state` AS `state`, `invoices`.`customer_id` AS `customer_id`, `customers`.`name` AS `customer_name`, `customers`.`address` AS `customer_address`, `customers`.`state` AS `customer_state` FROM (`invoices` join `customers` on(`invoices`.`customer_id` = `customers`.`id`))  ;

ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
