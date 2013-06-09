<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initAutoload()
	{
		$moduleLoader = new Zend_Application_Module_Autoloader(array(
		'namespace' => '',
		'basePath' => APPLICATION_PATH));
		
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace(array('Custom_'));
		
		return $moduleLoader;
	}
	
	protected function _initPlugins()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Plugin_Acl());
	}

	protected function _initView()
	{
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		$view->doctype('HTML5');
		$view->headMeta()
			->setCharset( 'UTF-8' );
		$view->headTitle('Shop');
		$view->headTitle()->setSeparator(' | ');
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$view->idetity = false;
		}else{
			$view->idetity = Zend_Auth::getInstance()->getIdentity();
		}
	}
	
	protected function _initEmail()
	{
		$email_config = array(
			'auth' => 'plain',
			'username' => 'andrewabank@ukr.net',
			'password' => '55044949',
			//'ssl' => 'tls',
			'port' => 2525
		);
		$transport = new Zend_Mail_Transport_Smtp('smtp.mail.ru',
			$email_config);
		Zend_Mail::setDefaultTransport($transport);
	}
	
	 protected function _initUserLog()
    {
		if(isset(Zend_Auth::getInstance()->getIdentity()->u_name)){
			$u_name = Zend_Auth::getInstance()->getIdentity()->u_name;
		}else{
			$u_name = 'guest';
		}
		$logfile = APPLICATION_PATH . '/logs/stats/' . date('d_F_Y') . '.txt';
		$msg = $u_name . ' IP: ' . $_SERVER['REMOTE_ADDR'] .' '. ' URL: ' . 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$writer = new Zend_Log_Writer_Stream($logfile);
		$log = new Zend_Log();
		$log->addWriter($writer)->info($msg);
    }
	
	public function _initTranslator()
    {
        $translator = new Zend_Translate('array', APPLICATION_PATH . '/languages/ru/form.php', 'ru');
        Zend_Form::setDefaultTranslator($translator);
    }

}

