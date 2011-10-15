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



class Fb_LikeController extends FbCommonController

{
	/**
	* Function init
	*
	* This function is used for initialization. Also include necessary javascript files.
	*
	* Date Created: 2011-10-13
	*
	* @access public
	* @param ()  - No parameter
	* @return (void) - Return void
	*
	* @author Yogesh
	*  
	* @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	**/  
	
	public function init()
	{
		parent::init();
		
 	}
	 
	/**
	* Function indexAction
	*
	* Date Created: 2011-09-01
	*
	* @access public
	* @param ()  - No parameter
	* @return (void) - Return void
	*
	* @author Yogesh
	*  
	* @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	**/  
	
    public function indexAction()
	{
		global $mysession;
	}
	
	/**
	* Function yourlikesAction
	*
	* This function is used to display all the product that logged in user likes.
	*
	* Date Created: 2011-10-13
	*
	* @access public
	* @param ()  - No parameter
	* @return (void) - Return void
	*
	* @author Yogesh
	*  
	* @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	**/  
	
    public function yourlikesAction()
	{
		global $mysession,$user,$facebook;
		$likes = new Models_Like();
		
		$flag = 0;
		if ($user) {  
			$flag = 1;  
			
			try {
				
				$uprofile = $facebook->api('/me');
				$this->view->yourlike_user_id = $uprofile["id"];
				
			  } catch (FacebookApiException $e) {
			  
					error_log($e);
					$user = null;
			  }
			
		} else {  
		
			$flag = 0; 	
		}
		
		$this->view->userlogin = $flag;
		
		//set current page number
		$page_no = 1;
		
		//set no. of records to display on page
		$pagesize = 6;
		
		//Get Request
		$request = $this->getRequest();
		$Sort = '';
		
		$request = $this->getRequest();
		
		if($this->_request->getParam("page_no") != '' ){
		
			$page_no = $this->_request->getParam("page_no");
			$mysession->pagesize = $pagesize;
		}
		
		$result = $likes->getAllLikes($this->view->yourlike_user_id); 
		
		//Set Pagination
		$paginator = Zend_Paginator::factory($result);
		$paginator->setItemCountPerPage($pagesize);
		$paginator->setCurrentPageNumber($page_no);
		
		//Set View variables
		$this->view->pagesize = $pagesize;
		$this->view->page_no = $page_no;
		$this->view->arr_pagesize = '1';
		$this->view->paginator = $paginator;
		$this->view->records = $paginator->getCurrentItems();	
		
		
	}
	
	/**
	* Function friendlikesAction
	*
	* This function is used to display all the product that logged in user's frieds likes 
	*
	* Date Created: 2011-10-13
	*
	* @access public
	* @param ()  - No parameter
	* @return (void) - Return void
	*
	* @author Yogesh
	*  
	* @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	**/  
	
    public function friendlikesAction()
	{
		global $mysession,$user,$facebook;
		
		$likes = new Models_Like();
		
		$flag = 0;
		if ($user) {  
			$flag = 1;  
			
			try {
				
				$uprofile = $facebook->api('/me/friends'); 
				
				$friends = array();
				foreach( $uprofile["data"] as $key => $val )
				{
					$friends[] = $val["id"];
				}
				
				$frined_list = implode(",",$friends);
				
				//set current page number
				$page_no = 1;
				
				//set no. of records to display on page
				$pagesize = 6;
				
				//Get Request
				$request = $this->getRequest();
				$Sort = '';
				
				if($this->_request->getParam("page_no") != '' ){
		
					$page_no = $this->_request->getParam("page_no");
					$mysession->pagesize = $pagesize;
				}
				
				$result = $likes->getAllFriendLikes($frined_list); 
				
				//Set Pagination
				$paginator = Zend_Paginator::factory($result);
				$paginator->setItemCountPerPage($pagesize);
				$paginator->setCurrentPageNumber($page_no);
				
				//Set View variables
				$this->view->pagesize = $pagesize;
				$this->view->page_no = $page_no;
				$this->view->arr_pagesize = '1';
				$this->view->paginator = $paginator;
				$this->view->records = $paginator->getCurrentItems();	
				
				
			  } catch (FacebookApiException $e) {
			  
					error_log($e);
					$user = null;
			  }
			
		} else {  
		
			$flag = 0; 	
		}
		$this->view->userlogin = $flag;
		
		$request = $this->getRequest();
		
		if($request->isPost() && $request->getPost("friends_email") !=  '' ){
		
		
		
		}
		
		
	}
	
}

?>