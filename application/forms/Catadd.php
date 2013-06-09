<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Catadd extends Zend_Form
{

    public function init()
    {
        $c_title = new Zend_Form_Element_Text('c_title');
		$c_title->setLabel('Введите название категории')
				->setRequired(true)
				->addValidator('NotEmpty');
					
		$categories = new Application_Model_Catalog;
		$cat_name = $categories->getCategories();
		$c_parent_id = new Zend_Form_Element_Select('c_parent_id');
		$c_parent_id->setLabel('Выберите категорию родителя')
					->addMultiOptions($cat_name);

		$c_metakeywords = new Zend_Form_Element_Textarea('c_metakeywords');
		$c_metakeywords->setLabel('Введите meta ключевые слова категории')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '1')
				->setRequired(true);
				
		$c_metadescription = new Zend_Form_Element_Textarea('c_metadescription');
		$c_metadescription->setLabel('Введите meta описание')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '2')
				->setRequired(true);
				
		$c_text = new Zend_Form_Element_Textarea('c_text');
		$c_text->setLabel('Введите текст категории')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '4')
				->setRequired(true);
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Добавить');
		
		$this->addElements(array($c_title, $c_parent_id, $c_metakeywords, $c_metadescription, $c_text, $submit));
    }


}

