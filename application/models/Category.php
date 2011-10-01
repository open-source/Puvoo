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
 * Class Models_Category
 *
 * Class Models_Category contains methods handle categories on site.
 *
 * Date created: 2011-08-22
 *
 * @category	Puvoo
 * @package 	Models
 * @author	    Jayesh 
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */  
 
class Models_Category
{
	
	private $db;
	
	
	/**
	 * Function __construct
	 *
	 * This is a constructor function.
     * It will set db adapter for the model 
	 *
	 * Date created: 2011-08-24
	 *
	 * @access public
	 * @param ()  - No parameter
	 * @return () - Return void
	 * @author Amar
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	function __construct()
	{
		$this->db = Zend_Registry::get('Db_Adapter');
	}
 	
	/**
	 * function getMainCategory()
	 *
	 * It is used to get the main category from the database and display in left menu.
	 *
	 * Date created: 2011-08-22
	 *
	 * @param () - No parameter
	 * @return (Array) - Return Array of records
	 * @author Jayesh 
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
 	public function GetMainCategory()
	{
		$db = $this->db;
		
		$sql = "select * from category_master where parent_id = '0' and is_active='1' order By category_name asc";
 		$result = $db->fetchAll($sql);
		return $result;
 	} 
	
	/**
	 * function GetCategory
	 *
	 * It is used to get the category from the database and display in left menu.
	 *
	 * Date created: 2011-08-22
	 *
	 * @param () - No parameter
	 * @return (Array) - Return Array of records
	 * @author Jayesh 
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	public function GetCategory()
	{
		$db = $this->db;
		
		$sql = "select * from category_master where parent_id = '0' and is_active='1' order By category_name asc";
 		$result = $db->fetchAll($sql);
		return $result;
	
	}

	/**
	 * function GetCategoryID
	 *
	 * It is used to get category id throught product id.
	 *
	 * Date created: 2011-08-22
	 *
	 * @param () (Int)  - $Poductid : Product Id
	 * @return (Array) - Return Array of records
	 * @author  Jayesh 
	 * @param   two parameters / login_id and password.
     * @global  $db Zend_db for database.
                $mysession Zend_Session_Namespace for session variables.
	 * 
	 */
	
	public function GetCategoryID($Poductid)
	{
		$db = $this->db;
		
		$sql = "SELECT cm.* from product_to_categories as ptc 
				LEFT JOIN category_master as cm ON (cm.category_id = ptc.category_id)
				WHERE ptc.product_id='".$Poductid."' and cm.parent_id !='0'";
				
 		$result = $db->fetchRow($sql);
		return $result;
	
	}

	
	/*
	 * GetCategoryById(): To get data of category by selected category id.
	 *
	 * It is used to get the all records of particular category by category id.
	 *
	 * Date created: 2011-08-26
	 *
	 * @param () (Int)  - $id : Category Id
	 * @return (Array) - Return Array of records
	 * @author  Yogesh 
	 * @param   two parameters / login_id and password.
     * @global  $db Zend_db for database.
                $mysession Zend_Session_Namespace for session variables.
	 * 
	 */
	
	public function GetCategoryById($id)
	{
		$db = $this->db;
		
		$sql = "select * from category_master where category_id = ".$id." order By category_name asc";
 		$result = $db->fetchRow($sql);
		return $result;
	
	}

	 /*
	 * GetSubCategory(): To get the sub category.
	 *
	 * It is used to get the main category from the database and display in left menu.
	 *
	 * Date created: 2011-08-22
	 *
	 * @param (Int)- $parentid  - Parent id
	 * @return (Array) - Return Array of records
	 * @author  Jayesh 
	 * @param   two parameters / login_id and password.
     * @global  $db Zend_db for database.
                $mysession Zend_Session_Namespace for session variables.
	 * 
	 */


	public function GetSubCategory($parentid=0)
	{
		$db = $this->db;
		
		$sql = "select * from category_master where parent_id = '".$parentid."' order By category_name asc";
		//print $sql;die;
 		$result = $db->fetchAll($sql);
		return $result;
	
	}
	
	
	/**
	 * Function GetAllCategories
	 *
	 * This function is used to get all categories available.
     *
	 * Date created: 2011-08-24
	 *
	 * @access public
	 * @param ()  - No parameter
	 * @return (Array) - Return Array of records
	 * @author Amar
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	public function GetAllCategories()
	{
		$db = $this->db;
		
		$sql = "select * from category_master";
		
 		$result = $db->fetchAll($sql);
		return $result;
	}
	
	/**
	 * Function GetCategoryDetail
	 *
	 * This function is used to get all details of that particular categories.
     *
	 * Date created: 2011-08-25
	 *
	 * @access public
	 * @param () (Int)  - $catid : Category Id
	 * @return (Array) - Return Array of records
	 * @author Jayesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	public function GetCategoryDetail($catid)
	{
		$db = $this->db;
		
		$sql = "select * from category_master where category_id = ".$catid."";
		
		$result =  $db->fetchRow($sql);
		
		return $result;
	
	}
	
	/**
	 * Function SearchCategories
	 *
	 * This function is used to search the category from category_master on search array.
     *
	 * Date created: 2011-08-26
	 *
	 * @access public
	 * @param () (Array)  - $data : Array of search options
	 * @return (Array) - Return Array of records
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	
	
	public function SearchCategories($data)
	{
		$db = $this->db;
		
		$sql  = "";
		$sql .= "SELECT * FROM category_master";
		// Check search array is null or not
		if(count($data) > 0 && $data != "") {
			$count = 0;		
			foreach($data as $key => $val) {
				if( $count == 0 ) {
				
					if($val != "") {
						$sql.=" WHERE lower(".$key.") like '%".$val."%'";
					} else {
						$sql.=" WHERE 1=1";
					}
					
				} else {
				
					if($val != "") {
						$sql.=" AND lower(".$key.") like '%".$val."%'";					
					} 						
				}
								
				$count++;
			}
			
		} else {
		
			$sql .= " WHERE 1=1";
		}
		
		$result =  $db->fetchAll($sql);		
		return $result;		
	}
	
	
	/**
	 * Function insertCategory
	 *
	 * This function is used to insert category.
     *
	 * Date created: 2011-08-26
	 *
	 * @access public
	 * @param () (Array)  - $data : Array of record to insert
	 * @return (Boolean) - Return true on success
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	
	public function insertCategory($data)
	{
		$db = $this->db;
		
		$db->insert("category_master", $data); 	 
		//return $db->lastInsertId(); 
		return true; 
	}
	
	/**
	 * Function updateCategory
	 *
	 * This function is used to Update category records on specified condition.
     *
	 * Date created: 2011-08-26
	 *
	 * @access public
	 * @param () (Array)  - $data : Array of record to update
	 * @param () (String)  - $where : Condition on which update record
	 * @return (Boolean) - Return true on success
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	
	public function updateCategory($data,$where)
	{
		$db = $this->db;		
		$db->update("category_master", $data, $where); 	
		return true;
	}
	
	/**
	 * Function deleteCategory
	 *
	 * This function is used to delete category on specified condition.
     *
	 * Date created: 2011-08-26
	 *
	 * @access public
	 * @param () (Int)  - $id : Category Id
	 * @return (Boolean) - Return true on success
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	
	
	public function deleteCategory($id)
	{
		$db = $this->db;	
		$db->delete("category_master", 'category_id = ' .$id);		
		return true;		
	}
	
	/**
	 * Function deletemultipleCategories
	 *
	 * This function is used to delete multiple category on specified condition.
     *
	 * Date created: 2011-08-26
	 *
	 * @access public
	 * @param () (String)  - $ids : Sting of all Category Id with comma seprated.
	 * @return (Boolean) - Return true on success
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	
	public function deletemultipleCategories($ids)
	{
		$db = $this->db;	
		$where = 'category_id in ('.$ids.')'; 			
		$db->delete("category_master",$where);	 
		
		return true;	
	}
	
	/**
	 * Function getParentCategories
	 *
	 * This function is used to get parent categories of given category
     *
	 * Date created: 2011-09-28
	 *
	 * @access public
	 * @param () (int)  - $cid : category id to get parents.
	 * @param () (array)  - $carray : array to put results in.
	 * @return (array) - Return array of category ids
	 * @author Amar
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	
	public function getParentCategories($cid,$carray = array())
	{
		$db = $this->db;	
		$data = NULL;
		if($cid > 0)
		{
			$sql = "select category_id, parent_id, category_name from category_master where category_id = " . $cid;
			$data = $db->fetchRow($sql);
			$x = count($carray);
			$carray[$x]["category_id"] = $data["category_id"];
			$carray[$x]["category_name"] = $data["category_name"];
			
			return($this->getParentCategories($data["parent_id"],$carray));
		}
		else
		{
			return $carray;
		}
		
	}
	
	/**
	 * Function getAllCateTree
	 *
	 * This function is used to get category tree 
     *
	 * Date created: 2011-09-30
	 *
	 * @access public
	 * @param () (int)  - $cid : category id 
	 * @param () (array)  - $carray : array to put results in.
	 * @return (array) - Return array of category ids
	 * @author Yogesh
	 *  
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	
	
	function getCateTree( $cid = 0 )
	{	
		global $exclude;
		$db = $this->db;	
		$tree = "";                         // Clear the directory tree
		$depth = 1;                         // Child level depth.
		$top_level_on = 1;               // What top-level category are we on?
		$exclude = array();               // Define the exclusion array
		array_push($exclude, 0);     // Put a starting value in it
		
		
		$sql = "SELECT * FROM category_master WHERE is_active = 1";
		$data = $db->fetchAll($sql);
 	
		foreach ( $data as $key => $nav_row  )
		{
     		$goOn = 1;               // Resets variable to allow us to continue building out the tree.
			for($x = 0; $x < count($exclude); $x++ )          // Check to see if the new item has been used
			{
				  if ( $exclude[$x] == $nav_row['category_id'] )
				  {
					   $goOn = 0;
					   break;         // Stop looking b/c we already found that it's in the exclusion list and we can't continue to process this node
				  }
			 }
			 if ( $goOn == 1 )
			 {
				  if($cid == $nav_row['category_id'] ) {
				    $tree .= "<option selected='selected' value='".$nav_row['category_id']."' >";
				  } else {
					$tree .= "<option value='".$nav_row['category_id']."' >";				
				  }
				  $tree .= $nav_row['category_name'];                    // Process the main tree node
				  $tree .= "</option>";
				  array_push($exclude, $nav_row['category_id']);          // Add to the exclusion list
				  if ( $nav_row['category_id'] < 6 )
				  { $top_level_on = $nav_row['category_id']; }
		 
				  $tree .= $this->build_child($nav_row['category_id'],$cid);          // Start the recursive function of building the child tree
			 }
		}
		
		return $tree; 
 	}
	
	function build_child($oldID,$cid)               // Recursive function to get all of the children...unlimited depth
	{	
		 global $exclude, $depth;               // Refer to the global array defined at the top of this script
		 $db = $this->db;	
		 $tempTree = "";
		 $child_query = "SELECT * FROM category_master WHERE is_active = 1 AND parent_id=" . $oldID;
		 
		 $row = $db->fetchAll($child_query);
		 
		foreach ( $row as $key => $child )
		{
			if ( $child['category_id'] != $child['parent_id'] )
			{		
			
				if($cid == $child['category_id'] ) {
					$tempTree .= "<option selected='selected' value='".$child['category_id']."' >";
				} else {
					$tempTree .= "<option value='".$child['category_id']."' >";				
				}
				for ( $c=0; $c < $depth; $c++ )               // Indent over so that there is distinction between levels
				{ 
					$tempTree .= "&nbsp;&nbsp;-"; 
				}
			   
				$tempTree .=  "&nbsp;&nbsp;-&nbsp;&nbsp;".$child['category_name'] . "<br>";
				$tempTree .= "</option>";
				$depth++;          // Incriment depth b/c we're building this child's child tree  (complicated yet???)
				$tempTree .= $this->build_child($child['category_id'],$cid);          // Add to the temporary local tree
				$depth--;          // Decrement depth b/c we're done building the child's child tree.
				array_push($exclude, $child['category_id']);               // Add the item to the exclusion list
			}
		}
	 
		 return $tempTree;          // Return the entire child tree
	}
	
}
?>