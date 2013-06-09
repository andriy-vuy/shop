<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Img extends Zend_Form
{

    public function init()
    {
		$this->setAttrib('enctype', 'multipart/form-data');
		$img = new Zend_Form_Element_File('img');
		$img->setLabel('Изменить картинку')
			->setDestination(APPLICATION_PATH."/../public_html/data/images")
			->addValidator('Size', false, 1024000)
			->addValidator('Extension', false, 'jpg,png,gif');
		
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('ok');
				
		$this->addElements(array($img, $submit));
    }


}

