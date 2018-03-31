<?php
/**
 *
 * @copyright   Copyright (c) 2013 Kranti (http://www.Kranti.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Kranti_CustomerOrderCancel_OrderController extends Mage_Core_Controller_Front_Action {

    /**
     * Cancel order on customer request
     */
    public function cancelAction()
    {

        // Retrieve order_id passed by clicking on "Cancel Order" in customer account
        $orderId = $this->getRequest()->getParam('order_id');

        // Load Mage_Sales_Model_Order object
        $order = Mage::getModel('sales/order')->load($orderId);
         $orderPrice  = $order->getGrandTotal();
         $orderStatusLabel=$order->getStatusLabel();
    // print_r( $orderPrice );

//parameters can be change according to requirment
    $data = array("orderId" => "$orderId","orderTotal" => "$orderPrice");
//encoding php dta supportated to json suporated data
$data_string = json_encode($data);                       
$ch = curl_init(Mage::helper('customerordercancel')->PostRequest($order)); 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); //post method                                                                    
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string)));
    $token = curl_exec($ch);
     //Conectivity with dataBase
  $resource = Mage::getSingleton('core/resource');
  // Retrieve the write connection
  $writeConnection = $resource->getConnection('core_write');
  $query="INSERT INTO `Kranti_CustomerOrderCancel`(`orderId`, `orderTotal`, `orderStatusLabel`, `Apimessage`) VALUES ('$orderId','$orderPrice','$orderStatusLabel','$token')";
      $writeConnection->query($query);




        $session = Mage::getSingleton('catalog/session');
        // $result= Mage::getModel('Kranti_CustomerOrderCancel/observer')->GetRequest($observer);
        //we are checking get api
       switch(Mage::helper('customerordercancel')->GetRequest($order)){
      case "true":
      //$var="false";
      //we are checking here post Api 
             switch ($token) {
                 case 'true':
                 try {

            // Make sure that the order can still be canceled since customer clicked on "Cancel Order"
            if(!Mage::helper('customerordercancel')->canCancel($order)) {


                throw new Exception('Order cannot be canceled anymore.');
            }

            // Cancel and save the order
            $order->cancel();
            $order->save();
            $session->addSuccess($this->__('The order has been canceled.'));
        }
        catch (Exception $e) {
            Mage::logException($e);
            $session->addError($this->__('The order cannot be canceled.'));
                           }
     break;
    default:
    $session->addError($this->__('order cannot  canceled.'));
    break;
     }

break;
    case "false":
        $session->addError($this->__('The order cannot be  canceled.'));
    break;

 }

// Redirect to current sale order view
        $this->_redirect('sales/order/view', array('order_id' => $orderId));
    }
}