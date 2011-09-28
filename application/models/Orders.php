<?php
/**
 * Puvoo
 * http://www.puvoo.com
 *
 * NOTICE OF LICENSE
 *
 * Copyright (c) 2011
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@puvoo.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Puvoo to newer
 * versions in the future. If you wish to customize Puvoo for your
 * needs please refer to http://www.puvoo.com for more information.
 */


/**
 * Class Models_Orders
 *
 * Class Models_Orders contains methods to handle Orders.
 *
 * Date created: 2011-09-21
 *
 * @category	Puvoo
 * @package 	Models
 * @author	    Yogesh 
 *  
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */  
 
class Models_Orders
{
	private $db;
	private $admin_id;
	
	/**
	 * Function __construct
	 *
	 * This is a constructor functions.
     * It will set db adapter for the model 
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param ()  - No parameter
	 * @return () - Return void
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	function __construct()
	{
		global $mysession;
		$this->db = Zend_Registry::get('Db_Adapter');
		$this->admin_id = $mysession->Admin_Id;
	}
 	
	
	/**
	 * Function GetAllOrders
	 *
	 * This function is used to fetch all orders.
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param ()  - No parameter
	 * @return (Array) - Array of all orders
	 *
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	 
	 function GetAllOrders()
	 {
	 	$db = $this->db;
	 	
		$select = $db->select()
					 ->from("order_master");
		
		return $db->fetchAll($select);
	 
	 }
	 
   /**
	 * Function getOrderById
	 *
	 * This function is used to fetch all records of selected order.
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param (Int)  	- $id: Value of Order id
	 * @return (Array) 	- Array of order records.
	 *
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	  
	 function getOrderById($id)
	 {
	 	$db = $this->db;
	 	
		$select = "SELECT om.*, scm.country_name as shipping_country, bcm.country_name as billing_country, ssm.state_name as shipping_state_name, bsm.state_name as billing_state_name 
				   FROM order_master as om
				   LEFT JOIN country_master as scm ON ( scm.country_id = om.shipping_user_country_id)
				   LEFT JOIN country_master as bcm ON ( bcm.country_id = om.billing_user_country_id )
				   LEFT JOIN state_master as ssm ON ( ssm.state_id = om.shipping_user_state_id )
				   LEFT JOIN state_master as bsm ON ( bsm.state_id = om.billing_user_state_id )
				   WHERE om.order_id = ".$id;
		
		return $db->fetchRow($select);
	 
	 }

   /**
	 * Function SearchOrders
	 *
	 * This function is used to search all orders on specified condition.
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param (String)  - $where: Search Condition
	 * @return (Array) 	- Array of all orders
	 *
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/

	 function SearchOrders($where)
	 {
	 	$db = $this->db;
		
		$select = "SELECT * 
				   FROM order_master as om";
		if( $where != '' ){
		 	$select .=" WHERE 1=1 ".$where;
		} else {
			$select .=" WHERE 2=1";
		}
		return $db->fetchAll($select);
	 }
	 
   /**
	 * Function getAllOrderId
	 *
	 * This function is used to fetch order ids by comparing string value with product name.
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param (String) 	- $str: String to compare with product name
	 * @return (Array) 	- Array of order records.
	 *
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/

	 function getAllOrderId($str)
	 {
	 	$db = $this->db;
		
		$select = "	SELECT order_id 
					FROM order_detail
					WHERE product_name 
					LIKE '%".$str."%'
					GROUP BY order_id";			
		return $db->fetchAll($select);
	 }

   /**
	 * Function getOrderProductDetail
	 *
	 * This function is used to fetch all product's detail of order.
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param (Int) 	- $id: Value of order id
	 * @return (Array) 	- Array of order's product details.
	 *
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/	 
 
	 function getOrderProductDetail($id)
	 {
	 	$db = $this->db;
		
	 	$select = "SELECT od.*,opo.*
				   FROM order_detail as od
				   LEFT JOIN order_product_options as opo ON (od.order_detail_id = opo.order_detail_id)
				   WHERE od.order_id = ".$id;
		
		return $db->fetchAll($select);
	 }

   /**
	 * Function DeleteOrder
	 *
	 * This function is used to delete order and its all details.
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param (Int) 		- $id: Value of order id
	 * @return (Boolean)	- Return true on success.
	 *
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
 
	 function DeleteOrder($id)
	 {
	 	$db = $this->db;
		
		$db->delete("order_master","order_id=".$id);
		
		$order_options = $this->fetchAllRecords("order_detail","order_id=2");		
		
		if( isset($order_options) ) {		
			foreach($order_options as $key => $val) {
				$db->delete("order_product_options","order_detail_id = ".$val["order_detail_id"]);
			}
		}
		
		$db->delete("order_detail","order_id=".$id);
		
		return true;
	 }

   /**
	 * Function DeleteAllOrderDetail
	 *
	 * This function is used to delete multiple orders and its all details on order's ids.
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param (String) 		- $ids: String of order ids by comma seprated.
	 * @return (Boolean)	- Return true on success.
	 *
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/

	public function DeleteAllOrderDetail($ids)
	{
		$db = $this->db;	
		
		if( isset($ids) ) {
		
			foreach( $ids as $key => $val ) {
				
				$flag = $this->DeleteOrder($val);
				
				if($flag) { } else { break; return false; }
			}
			
			return true;	
		}
	}
	
   /**
	 * Function fetchAllRecords
	 *
	 * This function is used to fetch all recored from table with specifed condition.
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param (String) 		- $table: Table name
	 * @param (String)		- $where: Condition
	 * @return (Array)		- Array of all records
	 *
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	 	
	public function fetchAllRecords($table,$where = '1=1')
	{
		$db = $this->db;
		$select = $db->select()
				 	 ->from($table)
					 ->where($where);
		return $db->fetchAll($select);
	}


   /**
	 * Function updateOrder
	 *
	 * This function is used to update the status of order's product.
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param (Array) 		- $data: Array of order detail id
	 * @return (Boolean)	- Return true on success
	 *
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	 
	 function updateOrder($data)
	 {
	 	$db = $this->db;
		
		$where = "order_id = ".$data["order_id"];
		
		$db->update("order_master", $data, $where);
		
		return true;
	 
	 }

   /**
	 * Function getDashboardOrders
	 *
	 * This function is used to fetch recently added 10 orders for the merchant dashboard order list.
	 *
	 * Date created: 2011-09-21
	 *
	 * @access public
	 * @param (String) 		- $where: Condition
	 * @return (Array)		- Array of order records
	 *
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	 
	 function getDashboardOrders($where = ' WHERE 1=1 ' )
	 {
	 	$db = $this->db;
		
		$select = " SELECT *
					FROM `order_master`
					".$where."
					ORDER BY `order_id` DESC
					LIMIT 0 , 10 ";
					
		return $db->fetchAll($select);
	 
	 }
}
?>