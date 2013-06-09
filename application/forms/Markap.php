<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Markap extends Zend_Form
{

    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
		$name->setLabel('Введите название наценки')
				->setRequired(true)
				->addValidator('NotEmpty');
				
		$tax = new Zend_Form_Element_Text('tax');
		$tax->setLabel('Расходы')
				->setRequired(true)
				->addValidator('NotEmpty');
		$validator6 = new Zend_Validate_Float();
		$validator6->isValid(1234.5);
		$validator6->isValid('10a01');
		$validator6->isValid('1,234.5');
		
		$guest = new Zend_Form_Element_Text('guest');
		$guest->setLabel('Наценка для гостя')
				->setRequired(true)
				->addValidator('NotEmpty');
		$validator1 = new Zend_Validate_Float();
		$validator1->isValid(1234.5);
		$validator1->isValid('10a01');
		$validator1->isValid('1,234.5');
		
		$user = new Zend_Form_Element_Text('user');
		$user->setLabel('Наценка для простого пользователя')
				->setRequired(true)
				->addValidator('NotEmpty');
		$validator2 = new Zend_Validate_Float();
		$validator2->isValid(1234.5);
		$validator2->isValid('10a01');
		$validator2->isValid('1,234.5');
		
		$user1 = new Zend_Form_Element_Text('user1');
		$user1->setLabel('Наценка для пользователя 1 уровня')
				->setRequired(true)
				->addValidator('NotEmpty');
		$validator3 = new Zend_Validate_Float();
		$validator3->isValid(1234.5);
		$validator3->isValid('10a01');
		$validator3->isValid('1,234.5');
		
		$user2 = new Zend_Form_Element_Text('user2');
		$user2->setLabel('Наценка для пользователя 2 уровня')
				->setRequired(true)
				->addValidator('NotEmpty');
		$validator4 = new Zend_Validate_Float();
		$validator4->isValid(1234.5);
		$validator4->isValid('10a01');
		$validator4->isValid('1,234.5');
		
		$user3 = new Zend_Form_Element_Text('user3');
		$user3->setLabel('Наценка для пользователя 3 уровня')
				->setRequired(true)
				->addValidator('NotEmpty');
		$validator5 = new Zend_Validate_Float();
		$validator5->isValid(1234.5);
		$validator5->isValid('10a01');
		$validator5->isValid('1,234.5');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('ok');
		
		$this->addElements(array($name, $tax, $guest, $user, $user1, $user2, $user3, $submit));
    }


}

