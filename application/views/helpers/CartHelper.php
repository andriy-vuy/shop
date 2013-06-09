<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Zend_View_Helper_CartHelper extends Zend_View_Helper_Abstract
{
    public function cartHelper()
    {
		if(isset(Zend_Auth::getInstance()->getIdentity()->u_role)){
			$name = Zend_Auth::getInstance()->getIdentity()->u_role;
		}else{
			$name = 'guest';
		}
		$sesid = Zend_Session::getId();
		$cart = new Application_Model_ShoppingCart($sesid);
		$cart = $cart->getUserCart($sesid);
		$sum = 0;
		$quantity = 0; 
		if(count($cart)){
			echo'<p><a href="/user/cart/">Корзина</a>';
			foreach($cart as $val){
				if($name == 'guest'){
					$prise = round($val['p_price']*$val['tax']*$val['guest'],2);
				}elseif($name == 'user'){
					$prise = round($val['p_price']*$val['tax']*$val['user'],2);
				}elseif($name == 'user1'){
					$prise = round($val['p_price']*$val['tax']*$val['user1'],2);
				}elseif($name == 'user2'){
					$prise = round($val['p_price']*$val['tax']*$val['user2'],2);
				}elseif($name == 'user3'){
					$prise = round($val['p_price']*$val['tax']*$val['user3'],2);
				}elseif($name == 'admin'){
					$prise = round($val['p_price']*$val['tax']*$val['admin'],2);
				}
				$sum += $val['sc_quantity']*$prise;
				$quantity += $val['sc_quantity'];
			}
			echo '<br>Количество '.$quantity;
			echo '<br>На сумму: '.$sum.' гривен'.'</p>';
		}else{
			echo '<p><a href="/user/cart/">Корзина пустая</a></p>';;
		}
	}
}