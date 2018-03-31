<?php
//die('Setup');
$installer = $this;
$installer->startSetup();
$installer->run("CREATE TABLE Kranti_CustomerOrderCancel(
      `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `orderId` INT(11) NOT NULL,
      `orderTotal` double NOT NULL,
      `orderStatusLabel` VARCHAR(255) NOT NULL,
      `Apimessage` VARCHAR(255) NOT NULL,
      PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
$installer->endSetup();