<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Login extends Zend_Form
{

    public function init()
    {
		$u_name = new Zend_Form_Element_Text('u_name');
		$u_name->setLabel('Имя пользователя')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addFilter('StringTrim');
		
		$u_password = new Zend_Form_Element_Password('u_password');
		$u_password->setLabel('Пароль')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addFilter('StringTrim');
				
		$rememberme = new Zend_Form_Element_Checkbox('rememberme');
		$rememberme->setLabel('Запомнить меня')
				->setCheckedValue('rememberme');
		$label = $rememberme->getDecorator('label');
		$label->setOption('placement', 'append');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Войти');
		
		$this->addElements(array($u_name, $u_password, $rememberme, $submit));
    }


}

