<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Code extends Zend_Form
{

    public function init()
    {
		$this->setMethod('get');
		$this->setAction('order');
        $code = new Zend_Form_Element_Text('code');
		$code->setLabel('Введите код Вашего заказа')
				->setRequired(true)
				->addValidator('NotEmpty');
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Ввод');
				
		$this->addElements(array($code, $submit));
    }


}

