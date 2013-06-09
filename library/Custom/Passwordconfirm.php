<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Custom_Validator_Passwordconfirm extends Zend_Validate_Abstract
{
	const NOT_MATCH = 'notMatch';
	protected $_messageTemplates = array(
		self::NOT_MATCH => 'Пароли не совпадают');
		
	public function isValid($value, $context = null)
	{
	$value = (string)$value;
	
		if(is_array($context)){
			if (isset($context['u_password'])&&($value == $context['u_password'])){
			return true;
			}
		}elseif(is_string($context)&&($value == $context)){
			return true;
		}
		$this->_error(self::NOT_MATCH);
		return false;
	}
}

