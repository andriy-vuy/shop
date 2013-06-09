<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Custom_Mail extends Zend_Mail
{
	public function __construct($charset = 'utf-8')
	{
		parent::__construct($charset);
		$this->setFrom('lucky_nick@mail.ru', 'Shop');
	}
	
	public function setBodyView($script, $params = array())
	{
		$layout = new Zend_Layout(array(
			'layoutPath' => APPLICATION_PATH . '/layouts/scripts'));
		$layout->setLayout('email');
		$view = new Zend_View();
		$view->setScriptPath(APPLICATION_PATH . '/views/scripts/mail');
		foreach($params as $key => $value){
			$view->assign($key,$value);
		}
		$layout->content = $view->render($script . '.phtml');
		$html = $layout->render();
		$this->setBodyHtml($html);
		return $this;
	}
}

