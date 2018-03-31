<?php
class Kranti_CustomerOrderCancel_Model_Resource_CustomerOrderCancel_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        /**
         *   Initialize the model collection. In the configuration file
         *   Tag <myarticles> / File Articles.php 
         */
       $this->_init('customerordercancel/customerordercancel');
   }
}