<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Form_EditUser extends Zend_Form
{

    public function init()
    {
	
        $u_name = new Zend_Form_Element_Text('u_name');
		$u_name->setLabel('Имя пользователя')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addValidator('Alnum')
				->addFilter('StringTrim')
				->addFilter('StripTags')
				;
				
        $u_email = new Zend_Form_Element_Text('u_email');
		$u_email->setLabel('Email')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addValidator('EmailAddress')
				;
				
		$u_role = new Zend_Form_Element_Radio('u_role');
        $u_role->setLabel('Роль:')
            ->addMultiOptions(array(
                    'user' => 'user',
					'user1' => 'user1',
					'user2' => 'user2',
					'user3' => 'user3',
                    'admin' => 'admin' 
                        ));            
			$this->addElement($u_role);
			
		$u_activated = new Zend_Form_Element_Radio('u_activated');
        $u_activated->setLabel('Состояние:')
            ->addMultiOptions(array(
                    '0' => 'Блок',
                    '1' => 'Актив' 
                        ));            
			$this->addElement($u_activated);
				
        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Обновить');

        $this->addElements(array($u_name, $u_email, $u_role, $u_activated, $submit));
    }


}

