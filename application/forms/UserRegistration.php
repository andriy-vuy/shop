<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_UserRegistration extends Zend_Form
{

    public function init()
    {
        $this->setName('form_registration');
		
		$isEmptyMessage = 'Значение является обязательным и не может быть пустым';

        $u_name = new Zend_Form_Element_Text('u_name');
		$u_name->setLabel('Введите Ваше имя*')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addValidator('Alnum')
				->addValidator('Db_NoRecordExists', false, array(
					'table' => 'users',
					'field' => 'u_name'))
				->addFilter('StringTrim')
				->addFilter('StripTags')
				;
				
        $u_password = new Zend_Form_Element_Password('u_password');
		$u_password->setLabel('Введите Ваш пароль*')
				->setRequired(true)
				->addValidator('NotEmpty')
				;
				
		$password_confirm = new Zend_Form_Element_Password('password_confirm');
		$password_confirm->setLabel('Введите пароль еще раз*')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addPrefixPath('Custom_Validator', 'Custom', 'validate')
				->addValidator('Passwordconfirm')
				;
				
        $u_email = new Zend_Form_Element_Text('u_email');
		$u_email->setLabel('Введите Ваш email*')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addValidator('EmailAddress')
				->addValidator('Db_NoRecordExists', false, array(
					'table' => 'users',
					'field' => 'u_email'))
				;
				
		$u_phone = new Zend_Form_Element_Text('u_phone');
		$u_phone->setLabel('Введите номер Вашего телефона')
				->addValidator('Int');
				
        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Регистрация');

        $this->addElements(array($u_name, $u_password, $password_confirm, $u_email, $u_phone, $submit));
    }


}

