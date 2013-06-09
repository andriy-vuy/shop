<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$this->view->title = "Shop";
        $this->view->headTitle('Главная');
		if(isset(Zend_Auth::getInstance()->getIdentity()->id)){
			$identit = Zend_Auth::getInstance()->getIdentity()->id;
			$this->view->identit = $identit;
		}else{
			$this->view->message = 'Здравствуйте гость';
		}
		$products = new Application_Model_Products;
		$products = $products->getProductMain();
		$this->view->products = $products;
		if(isset(Zend_Auth::getInstance()->getIdentity()->u_name)){
			$u_name = Zend_Auth::getInstance()->getIdentity()->u_name;
			$logfile = APPLICATION_PATH . '/logs/stats/' . date('F_Y') . '.txt';
			$msg = $u_name . ' IP: ' . $_SERVER['REMOTE_ADDR'];
			$writer = new Zend_Log_Writer_Stream($logfile);
			$log = new Zend_Log();
			$log->addWriter($writer)->info($msg);
		}
    }

}

