<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    private $_controller = array(
		'controller' => 'error',
		'action' => 'denied');
		
	public function __construct()
	{
	$acl = new Zend_Acl();
		
		//roles
		$acl->addRole(new Zend_Acl_Role('guest'));
		$acl->addRole(new Zend_Acl_Role('user'), 'guest');
		$acl->addRole(new Zend_Acl_Role('user1'), 'user');
		$acl->addRole(new Zend_Acl_Role('user2'), 'user');
		$acl->addRole(new Zend_Acl_Role('user3'), 'user');
		$acl->addRole(new Zend_Acl_Role('admin'));
		
		//resourse
		$acl->add(new Zend_Acl_Resource('admin'));
		$acl->add(new Zend_Acl_Resource('user'));
		$acl->add(new Zend_Acl_Resource('index'));
		$acl->add(new Zend_Acl_Resource('products'));
		
		//permissions
		$acl->deny();
		$acl->allow('admin',null);
		
		//development
		/* $acl->deny();
		$acl->allow('guest',null); */
		
		//guest rights
		$acl->allow('guest','user',array('index', 'login','registration','reconfirm','confirm','addtocart','cart','cartdelete','orders','order','checkout','info'));
		$acl->allow('guest','index');
		$acl->allow('guest','products');
		
		//user rights
		$acl->allow('user','user',array('index', 'logout', 'edit'));
		$acl->deny('user','user',array('registration','reconfirm'));
		
		Zend_Registry::set('acl',$acl);
	}	
		
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$auth = Zend_Auth::getInstance();
		$acl = Zend_Registry::get('acl');
		
		if($auth->hasIdentity()){
			$role = $auth->getIdentity()->u_role;
		}else{
			$role = 'guest';
		}
		if(!$acl->hasRole($role)){
			$role = 'guest';
		}
		
		$controller = $request->controller;
		$action = $request->action;
		
		if(!$acl->has($controller)){
			$controller = null;
		}
		
		if(!$acl->isAllowed($role, $controller, $action)){
			$request->setControllerName($this->_controller['controller']);
			$request->setActionName($this->_controller['action']);
		}
	}
}
