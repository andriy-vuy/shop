<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Info extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
		
		$i_title = new Zend_Form_Element_Text('i_title');
		$i_title->setLabel('Введите название')
				->setRequired(true)
				->addValidator('NotEmpty');
				
		$i_metakeywords = new Zend_Form_Element_Textarea('i_metakeywords');
		$i_metakeywords->setLabel('Введите meta ключевые слова')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '1');
				
		$i_metadescription = new Zend_Form_Element_Textarea('i_metadescription');
		$i_metadescription->setLabel('Введите meta описание')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '2');
				
		$i_text = new Zend_Form_Element_Textarea('i_text');
		$i_text->setLabel('Введите текст')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '4');
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('ok');
		
		$this->addElements(array($i_title,  $i_metakeywords, $i_metadescription, $i_text, $submit));
    }


}

