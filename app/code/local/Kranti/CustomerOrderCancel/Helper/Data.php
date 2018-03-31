<?php
/**
 * @category    Kranti
 * @package     Kranti_CustomerOrderCancel
 * @copyright   Copyright (c) 2013 Kranti (http://www.kranti.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Kranti_CustomerOrderCancel_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Check if order can be canceled by customer
     *
     * @param Mage_Sales_Model_Order $order
     * @return bool
     */
    public function canCancel(Mage_Sales_Model_Order $order)
    {

        // If Magento decides that this order cannot be canceled
        if(!$order->canCancel()) {
            return false;
        }

// Else... return true
         return true;
    }

      public function GetRequest(Mage_Sales_Model_Order $order)
    {
      $requestUrl = Mage::getStoreConfig('sales/cancelOrder/get', $storeId);
      $ch = curl_init($requestUrl);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   
      $result = curl_exec($ch);
       return $result; 
  

}
      public function PostRequest(Mage_Sales_Model_Order $order)
    {
       
    $adminUrl=Mage::getStoreConfig('sales/cancelOrder/post', $storeId);
    return $adminUrl;

     }
    

         
        
    





}