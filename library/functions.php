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


#====================================================================================================
#	Function Name	:   sendMail
#====================================================================================================

function sendMail($to,$to_name,$from,$from_name,$subject,$body)
{
	 try {
			$mail = new Zend_Mail ('utf-8');
			$mail->addTo ( $to, $to_name)
					 ->setFrom( $from, $from_name )
					 ->setSubject ( $subject)
					 ->setBodyHtml ( $body );
			$result = $mail->send();
			return  true;
				
		} catch ( Zend_Mail_Exception $e ) {
			$e->getMessage ();
			return false; 
		} 
}



#====================================================================================================
#	Function Name	:   RandomPassword
#====================================================================================================

function RandomPassword($num_letters) 
{ 
	$pass = "";
	$array = array( 
					 "a","b","c","d","e","f","g","h","i","j","k","l", 
					 "m","n","o","p","q","r","s","t","u","v","w","x","y", 
					  "z","1","2","3","4","5","6","7","8","9" 
					 ); 
	$uppercased = 3; 
	mt_srand ((double)microtime()*1000000); 
	for($i=0; $i<$num_letters; $i++) 
		$pass .= $array[mt_rand(0, (count($array) - 1))]; 

	for($i=1; $i<strlen($pass); $i++) 
	{ 
		if(substr($pass, $i, 1) == substr($pass, $i-1, 1)) 
			$pass = substr($pass, 0, $i) . substr($pass, $i+1); 
	} 
	for($i=0; $i<strlen($pass); $i++) 
	{ 
		if(mt_rand(0, $uppercased) == 0) 
			$pass = substr($pass,0,$i) . strtoupper(substr($pass, $i,1)) . 
			substr($pass, $i+1); 
	} 
	$pass = substr($pass, 0, $num_letters); 
	return($pass); 
}


/**
 * Function createDirectory
 *
 * This function is used to create new directory in given path
 *
 * Date created: 2011-09-13
 *
 * @access public
 * @param (string)  - $path: path to create directory
 * @return (Boolean) - Return true or false depending on directory created or not
 * @author Amar
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 **/

function createDirectory($path)
{
	if(mkdir($path , 0644))
	{
	   return true;
	}
	else
	{
	   return false;
	} 
}

/**
 * Function deleteAllFiles
 *
 * This function is used to delete all files from a given folder
 *
 * Date created: 2011-09-15
 *
 * @access public
 * @param (string)  - $path: directory path to delete all files
 * @return (void) - Return void
 * @author Amar
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 **/

function deleteAllFiles($path)
{
	foreach(glob($path) as $v)
	{
		@unlink($v);
	}
}
