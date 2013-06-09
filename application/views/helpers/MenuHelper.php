<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Zend_View_Helper_MenuHelper extends Zend_View_Helper_Abstract
{
    public function menuHelper()
    {
			echo"
			<ul id='menu'>
			<li><a href='/user/info/value/delivery/'><span>Доставка</span></a></li>
			<li><a href='/user/info/value/guarantee/'><span>Гарантии</span></a></li>
			<li><a href='/user/info/value/payment/'><span>Оплата</span></a></li>
			<li><a href='/user/info/value/help/'><span>Помощь</span></a></li>
			<li><a href='/user/info/value/contacts/'><span>Контакты</span></a></li>
				</ul>
			";
	}
}