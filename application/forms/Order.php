<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_Order extends Zend_Form
{

    public function init()
    {
		$o_uid = new Zend_Form_Element_Hidden('o_uid');
        $o_uid->addFilter('Int');

		$o_username = new Zend_Form_Element_Text('o_username');
		$o_username->setLabel('Введите Ваше имя и фамилию')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addFilter('StringTrim')
				->addFilter('StripTags');
				
		$o_userphone= new Zend_Form_Element_Text('o_userphone');
		$o_userphone->setLabel('Введите номер телефона. Пример: 0501111111 ')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addValidator('Int');
				
        $o_useremail = new Zend_Form_Element_Text('o_useremail');
		$o_useremail->setLabel('Email')
				->addValidator('EmailAddress');
				
		$delivery = new Application_Model_Delivery();
		$delivery_name = $delivery->getDelivery();
		$o_delivery = new Zend_Form_Element_Select('o_delivery');
		$o_delivery->setLabel('Выберите перевозчика')
					->setRequired(true)
					->addValidator('NotEmpty')
					->addMultiOptions($delivery_name);
					
					
		$o_payment = new Zend_Form_Element_Radio('o_payment');
        $o_payment->setLabel('Способ оплаты:')
            ->addMultiOptions(array(
				'Наличными' => 'Наличными',
				'Наложенный платеж' => 'Наложенный платеж',
				'Через банк' => 'Через банк'))
			->setRequired(true)
			->addValidator('NotEmpty');
				
		$o_text = new Zend_Form_Element_Textarea('o_text');
		$o_text->setLabel('Добавте сопроводительный текст')
				->setAttrib('COLS', '40')
				->setAttrib('ROWS', '4');
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Заказать');
				
		$this->addElements(array($o_uid, $o_username, $o_userphone, $o_useremail, $o_delivery, $o_payment, $o_text, $submit));
    }


}

