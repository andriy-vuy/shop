<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Product extends Zend_Form
{
	
    public function init()
    {
	
        $p_title = new Zend_Form_Element_Text('p_title');
		$p_title->setLabel('Введите название товара')
				->setRequired(true)
				->addValidator('NotEmpty');
				
		$p_code = new Zend_Form_Element_Text('p_code');
		$p_code->setLabel('Введите код товара')
				->setRequired(true)
				->addValidator('NotEmpty');
				
		$categories = new Application_Model_Catalog();
		$cat_name = $categories->getCatAdd();
		$p_cat_id = new Zend_Form_Element_Select('p_cat_id');
		$p_cat_id->setLabel('Выберите категорию')
					->addMultiOptions($cat_name)
					->addValidator('NotEmpty');
					
		$markup = new Application_Model_Markup();
		$name = $markup->getMarkup();
		$p_markup = new Zend_Form_Element_Select('p_markup');
		$p_markup->setLabel('Выберите наценку')
					->addMultiOptions($name)
					->addValidator('NotEmpty');
					
		$p_metakeywords = new Zend_Form_Element_Textarea('p_metakeywords');
		$p_metakeywords->setLabel('Введите meta ключевые слова товара')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '1');
				
		$p_metadescription = new Zend_Form_Element_Textarea('p_metadescription');
		$p_metadescription->setLabel('Введите meta описание')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '2');
				
		$p_text = new Zend_Form_Element_Textarea('p_text');
		$p_text->setLabel('Введите описание товара')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '4');
				
		$p_price = new Zend_Form_Element_Text('p_price');
		$p_price->setLabel('Цена товара')
				->setRequired(true)
				->addValidator('NotEmpty');
		$validator = new Zend_Validate_Float();
		$validator->isValid(1234.5);
		$validator->isValid('10a01');
		$validator->isValid('1,234.5');
				
		$p_quantity = new Zend_Form_Element_Text('p_quantity');
		$p_quantity->setLabel('Количество')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addValidator('Int');
				
		$p_status = new Zend_Form_Element_Radio('p_status');
        $p_status->setLabel('Состояние:')
            ->addMultiOptions(array(
                    '1' => 'В наличии',
					'0' => 'Отсутствует'
                        ))
			->setValue("1");
		
		$this->setAttrib('enctype', 'multipart/form-data');
		$pi_img = new Zend_Form_Element_File('pi_img');
		$pi_img->setLabel('Картинка:')
			->setMultiFile(2)
			->addValidator('Size', false, 1024000)
			->addValidator('Extension', false, 'jpg,png,gif')
			->addValidator('Count', false, array('min' => 0, 'max' => 2))
			->setDestination(APPLICATION_PATH . '/../public_html/data/images');
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Добавить');
				
		$this->addElements(array($p_title, $p_code, $p_cat_id, $p_markup, $p_metakeywords, $p_metadescription, $p_text, $p_price, $p_quantity, $p_status, $pi_img, $submit));
    }


}

