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
 * Admin Logout Controller.
 *
 * Admin_LogoutController. It is used to logout from admin section.
 *
 * Date Created: 2011-08-20
 *
 * @category	Puvoo
 * @package 	Admin_Controllers
 * @author	    Amar 
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 **/  
class Admin_LogoutController extends Zend_Controller_Action 
{
	
	/**
     * Function indexAction
	 *
	 * This function is used to logout from admin section of site.
	 *
     * Date Created: 2011-08-20
     *
     * @access public
	 * @param ()  - No parameter
	 * @return (void) - Return void
	 *
     * @author Amar
     * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
     **/  
   function indexAction() 
   {
		# // clear everything - session is cleared also!  
     	Zend_Auth::getInstance()->clearIdentity();  

   		Zend_Session::namespaceUnset("Puvoo");
		Zend_Session::destroy();		
		$this->_redirect('/admin/login/'); 
   }
}
?>
