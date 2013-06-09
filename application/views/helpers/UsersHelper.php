<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Zend_View_Helper_UsersHelper extends Zend_View_Helper_Abstract
{
    public function usersHelper()
    {
		if(isset(Zend_Auth::getInstance()->getIdentity()->u_role)){
			$u_name = Zend_Auth::getInstance()->getIdentity()->u_role;
		}else{
			$u_name = 'guest';
		}
		echo '<a href="/">Главная</a><br>';
		if($u_name == 'guest'){
			echo '<a href="/user/login/">Вход</a><br>';
			echo '<a href="/user/registration/">Регистрация</a>';
		}else{
			echo '<a href="/user/">Кабинет</a><br>';
			echo '<a href="/user/logout/">Выйти</a>';
		}
		if($u_name == 'admin'){
			echo '<br><a href="/admin/index/">Админ</a><br>';
			echo '<a href="/admin/orders/">Заказы</a><br>';
			echo '<a href="/admin/catalog/">Каталог</a><br>';
			echo '<a href="/admin/products/">Товары</a><br>';
			echo '<a href="/admin/csv/">CSV</a><br>';
			echo '<a href="/admin/users/">Пользователи</a><br>';
			echo '<a href="/admin/markup/">Наценка</a><br>';
			echo '<a href="/admin/delivery/">Доставка</a><br>';
			echo '<a href="/admin/info/">Информация</a>';
		}else{
			echo '<br><a href="/user/orders/">Заказы</a>';
		}
	}
}