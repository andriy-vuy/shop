<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Passedid extends Zend_Form
{

    public function init()
    {
		$this->setName('form_passedit');
		
		$isEmptyMessage = 'Значение является обязательным и не может быть пустым';
		
		$u_phone = new Zend_Form_Element_Text('u_phone');
		$u_phone->setLabel('Введите номер Вашего телефона')
				->addValidator('Int');
	
        $u_password = new Zend_Form_Element_Password('u_password');
		$u_password->setLabel('Введите Ваш новый пароль')
				->setRequired(true)
				->addValidator('NotEmpty')
				;
				
		$password_confirm = new Zend_Form_Element_Password('password_confirm');
		$password_confirm->setLabel('Введите пароль еще раз')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addPrefixPath('Custom_Validator', 'Custom', 'validate')
				->addValidator('Passwordconfirm')
				;
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Добавить');
		
		$this->addElements(array($u_phone, $u_password, $password_confirm, $submit));
    }


}

