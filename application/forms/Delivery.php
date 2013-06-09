<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Delivery extends Zend_Form
{

    public function init()
    {
		$d_name = new Zend_Form_Element_Text('d_name');
		$d_name->setLabel('Введите перевозчика')
				->setRequired(true)
				->addValidator('NotEmpty');
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('ok');
		
		$this->addElements(array($d_name, $submit));
    }


}

