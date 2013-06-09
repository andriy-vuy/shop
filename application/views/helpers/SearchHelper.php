<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Zend_View_Helper_SearchHelper extends Zend_View_Helper_Abstract
{
    public function searchHelper()
    {
		if(isset(Zend_Auth::getInstance()->getIdentity()->u_role)){
			$u_name = Zend_Auth::getInstance()->getIdentity()->u_role;
		}else{
			$u_name = 'guest';
		}
		if($u_name == 'admin'){
		$link = '/admin/search/';
		}else{
		$link = '/products/search/';
		}
		echo"
		<p>
		<form action=$link method='get'>
		<input type='text' name='val' id='search'>
		<input type='submit' value='ok'>
		</form></p>";
	}
}