<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Csv extends Zend_Form
{

    public function init()
    {
        $this->setAttrib('enctype', 'multipart/form-data');
		$csv = new Zend_Form_Element_File('csv');
		$csv->setLabel('Загрузить CSV файл')
			->setDestination(APPLICATION_PATH.'/../public_html/data/csv')
			->addValidator('Extension', false, 'csv')
			->setValueDisabled(true);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('ok');
		
		$this->addElements(array($csv, $submit));
    }


}

