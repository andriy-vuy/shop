<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Contact extends Zend_Form
{

    public function init()
    {
        $from = new Zend_Form_Element_Text('from');
		$from->setLabel('Введите Ваш email')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addValidator('EmailAddress');
				
		$setSubject = new Zend_Form_Element_Text('setSubject');
		$setSubject->setLabel('Введите тему сообщения')
				->setRequired(true)
				->addValidator('NotEmpty');
				
		$setBodyText = new Zend_Form_Element_Textarea('setBodyText');
		$setBodyText->setLabel('Введите текст')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '4')
				->setRequired(true)
				->addValidator('NotEmpty');
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Отправить');
		
		$this->addElements(array($from, $setSubject, $setBodyText, $submit));
    }


}

