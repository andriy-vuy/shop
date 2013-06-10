<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->title = "Личный кабинет";
        $this->view->headTitle($this->view->title);
		if(isset(Zend_Auth::getInstance()->getIdentity()->id)){
			$identit = Zend_Auth::getInstance()->getIdentity()->id;
			$this->view->identit = $identit;
		}else{
			$this->view->message = 'Здравствуйте гость';
		}
		$sesid = Zend_Session::getId();
		$cart = new Application_Model_ShoppingCart($sesid);
		$this->view->cart = $cart->getUserCart($sesid);
    }

    public function registrationAction()
    {
        $this->view->title = "Регистрация нового пользователя";
        $this->view->headTitle($this->view->title);
        $form = new Application_Form_UserRegistration();
		
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getPost())){
				$user = new Application_Model_Users();
				$user->fill($form->getValues());
				$user->u_created = date('Y-m-d H:i:s');
				$user->u_password = sha1($user->u_password);
				$user->u_code = uniqid();
				$user->save();
				$user->sendActivationEmail();
				$urlOptions = array('controller'=>'user', 'action'=>'reconfirm');
				$this->_helper->redirector->gotoRoute($urlOptions);
				}
			}
		
        $this->view->form = $form;
    }
	
	public function reconfirmAction()
    {
		$this->view->title = "Подтверждение активации";
        $this->view->headTitle($this->view->title);
	}

    public function confirmAction()
    {
        $id = $this->_getParam('id');
		$code = $this->_getParam('code');
		$user = new Application_Model_Users($id);
		if($user->u_activated){
		$this->view->message = 'Ваш аккаунт уже активирован';
		}else{
			if($user->u_code == $code and $code > 0){
				$user->u_activated = true;
				$user->save();
				$this->view->message = 'Ваш аккаунт успешно активирован';
			}else{
				$this->view->message = 'Неверные данные активации';
			}
		}
    }

    public function loginAction()
    {
        $this->view->title = "Вход в систему";
		$this->view->headTitle($this->view->title);
		$form = new Application_Form_Login();
	
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getPost())){
				$user = new Application_Model_Users();
				if($user->authorize($form->getValue('u_name'),$form->getValue('u_password'))){
					if(Zend_Auth::getInstance()->getIdentity()->u_role == 'admin'){
					$urlOptions = array('controller'=>'admin', 'action'=>'index');
					$this->_helper->redirector->gotoRoute($urlOptions);
					}else{
					$urlOptions = array('controller'=>'index', 'action'=>'index');
					$this->_helper->redirector->gotoRoute($urlOptions);
					}
				}else{
					$this->view->error = 'Неверные данные авторизации';
				}
			}
		}
		$this->view->form = $form;
		if(isset(Zend_Auth::getInstance()->getIdentity()->id)){
			$identit = Zend_Auth::getInstance()->getIdentity()->id;
			$this->view->identit = $identit;
		}
    }

    public function logoutAction()
    {
        require_once 'Zend/Auth.php';
        $auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		Zend_Session::forgetMe();
		$this->_redirect($_SERVER['HTTP_REFERER']);
    }

    public function editAction()
    {
		$this->view->title = "Страница изменения пароля пользователя";
        $this->view->headTitle($this->view->title);
		$id = Zend_Auth::getInstance()->getIdentity()->u_id;
		$user = new Application_Model_Users($id);
		$form = new Application_Form_Passedid();
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getPost())){
			$user->fill($form->getValues());
			$user->u_lastmodified = date('Y-m-d H:i:s');
			$user->u_password = sha1($user->u_password);
			$user->save();
			$this->_helper->redirector('index');
			}
		}else{
			$form->populate($user->populateForm());
		}
		$this->view->form = $form;
    }
	
	public function addtocartAction()
    {	
		$pid = $this->_getParam('id');
		if($pid){
			$cart = new Application_Model_ShoppingCart();
			$sesid = Zend_Session::getId();
			$cart->sc_user = $sesid;
			$cart->sc_product = $pid;
			$cart->sc_quantity = 1;
			$cart->save();
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}	
    }

    public function cartAction()
    {
		$this->view->title = "Корзина";
        $this->view->headTitle($this->view->title);
		if(isset(Zend_Auth::getInstance()->getIdentity()->id)){
			$identit = Zend_Auth::getInstance()->getIdentity()->id;
			$this->view->identit = $identit;
		}
        $sesid = Zend_Session::getId();
		$cart = new Application_Model_ShoppingCart($sesid);
		$this->view->cart = $cart->getUserCart($sesid);
		$images = new Application_Model_ShoppingCart($sesid);
		$this->view->images = $images->getImgCart($sesid);
    }

    public function cartdeleteAction()
    {
        $id = $this->_getParam('id');
		if($id){
			$cart = new Application_Model_ShoppingCart($id);
			$cart->delete();
			$this->_helper->redirector('cart');
		}else{
			$this->_helper->redirector('cart');
		}
    }
	
	public function ordersAction()
	{
		$this->view->title = "Заказы:";
		$this->view->headTitle($this->view->title);
		$form = new Application_Form_Code();
		if(isset(Zend_Auth::getInstance()->getIdentity()->u_id)){
			$u_id = Zend_Auth::getInstance()->getIdentity()->u_id;
			$name = Zend_Auth::getInstance()->getIdentity()->u_name;
			$this->view->u_id = $u_id;
			$order = new Application_Model_Orders($u_id);
			$orders = $order->getUserOrders($u_id);
			$this->view->name = $name;
			$this->view->orders = $orders;
		}
		$this->view->form = $form;
	}
	
	public function orderAction()
	{
		$this->view->title = "Информация о заказе:";
		$this->view->headTitle($this->view->title);
		$code = $this->_getParam('code');
			if($code){
				$orders = new Application_Model_Orders($code);
				$order = $orders->getOrder($code);
				$this->view->order = $order;
				foreach($order as $val){
					$id = $val['o_id'];
					$op = new Application_Model_OrdersProducts($id);
					$order_p = $op->getOp($id);
					$this->view->order_p = $order_p;
				}		
			}else{
				$this->_helper->redirector('orders');
		}
	}
	
	public function checkoutAction()
	{
		$this->view->title = "Оформление заказа";
        $this->view->headTitle($this->view->title);
		if(isset(Zend_Auth::getInstance()->getIdentity()->id)){
			$identit = Zend_Auth::getInstance()->getIdentity()->id;
			$this->view->identit = $identit;
		}
        $sesid = Zend_Session::getId();
		$cart = new Application_Model_ShoppingCart($sesid);
		$cart = $cart->getUserCart($sesid);
		$this->view->cart = $cart;
		$images = new Application_Model_ShoppingCart($sesid);
		$this->view->images = $images->getImgCart($sesid);
		$form = new Application_Form_Order();
		$order = new Application_Model_Orders();
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getPost())){
				$order->fill($form->getValues());
				$order->o_code = uniqid();
				$order->o_created = date('Y-m-d H:i:s');
				$order->save();
				if(isset(Zend_Auth::getInstance()->getIdentity()->u_id)){
						$u_name = Zend_Auth::getInstance()->getIdentity()->u_role;
						}else{
						$u_name = 'guest';
						}
				if(count($cart)){
					foreach($cart as $value){
						$o_product = new Application_Model_OrdersProducts();
						$o_product->op_ordersid = $order->o_id;
						$o_product->op_productid = $value['p_id'];
						$o_product->op_producttitle = $value['p_title'];
						if($u_name == 'guest'){
						$prise = round($value['p_price']*$value['tax']*$value['guest'],2);
						}elseif($u_name == 'user'){
						$prise = round($value['p_price']*$value['tax']*$value['user'],2);
						}elseif($u_name == 'user1'){
						$prise = round($value['p_price']*$value['tax']*$value['user1'],2);
						}elseif($u_name == 'user2'){
						$prise = round($value['p_price']*$value['tax']*$value['user2'],2);
						}elseif($u_name == 'user3'){
						$prise = round($value['p_price']*$value['tax']*$value['user3'],2);
						}elseif($u_name == 'admin'){
						$prise = round($value['p_price']*$value['tax']*$value['admin'],2);
						}
						$o_product->op_productprice = $prise;
						$sc_quantity = $value['sc_quantity'];
						$p_quantity = $value['p_quantity'];
						$p_ordered = $value['p_ordered'];
						if($sc_quantity >= $p_quantity - $p_ordered){
						$quantity = $p_quantity - $p_ordered;
						}else{
						$quantity = $sc_quantity;
						}
						$o_product->op_quantity = $sc_quantity;
						$o_product->save();
						$p_id = $value['p_id'];
						$product = new Application_Model_Products($p_id);
						$product->p_ordered = $value['p_ordered']+$sc_quantity;
						$product->save();
					}
				}
				$s_cart = new Application_Model_ShoppingCart($sesid);
				$s_cart->deleteCart($sesid);
				$tomail = $order->o_useremail;
				$order->sendOrderEmail($tomail);
				$this->_helper->redirector('order');
			}
		}else{
			if(isset(Zend_Auth::getInstance()->getIdentity()->u_id)){
				$o_uid = Zend_Auth::getInstance()->getIdentity()->u_id;
				$name = Zend_Auth::getInstance()->getIdentity()->u_name;
				$email = Zend_Auth::getInstance()->getIdentity()->u_email;
				$phone = Zend_Auth::getInstance()->getIdentity()->u_phone;
				$data = array('o_uid' => $o_uid,
							'o_username' => $name, 	'o_userphone' => $phone,
							'o_useremail' => $email);
				$this->view->form = $form->populate($data);
			}
		}
		
		$this->view->form = $form;
	}
	
	public function infoAction()
	{
		$value = $this->_getParam('value');
		if($value){
			if($value == 'delivery'){
				$id = 1;
			}elseif($value == 'guarantee'){
				$id = 2;
			}elseif($value == 'payment'){
				$id = 3;
			}elseif($value == 'help'){
				$id = 4;
			}elseif($value == 'contacts'){
				$id = 5;
			}else{
				$id = 4;
			}
		$info = new Application_Model_Info($id);
		$this->view->headMeta()->appendHttpEquiv('Last-Modified', $info->i_latmodified);
		$this->view->headMeta()->appendName('keywords', $info->i_metakeywords);
		$this->view->headMeta()->appendName('description', $info->i_metadescription);
		$this->view->title = $info->i_title;
		$this->view->headTitle($this->view->title);
		$info = $info->getInfo($id);
		$this->view->info = $info;
		}
		if($id == 5){
		$form = new Application_Form_Contact();
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getPost())){
				$mail = new Custom_mail();
				$mail->addTo('lucky_nick@mail.ru');
				$mail->setSubject($form->getValue('setSubject') . '. Отправитель: <' . $form->getValue('from') .'>');
				$mail->setBodyText($form->getValue('setBodyText'));
				$mail->send();
				$urlOptions = array('controller'=>'index', 'action'=>'index');
					$this->_helper->redirector->gotoRoute($urlOptions);
			}
		}
		$this->view->form = $form;
		}
	}
	
    public function testfileAction()
    {
        $this->_helper->layout->setLayout('newapplayout');
        $this->view->title = "Личный кабинет";
        $this->view->headTitle($this->view->title);
		if(isset(Zend_Auth::getInstance()->getIdentity()->id)){
			$identit = Zend_Auth::getInstance()->getIdentity()->id;
			$this->view->identit = $identit;
		}else{
			$this->view->message = 'Здравствуйте гость';
		}
		$sesid = Zend_Session::getId();
		$cart = new Application_Model_ShoppingCart($sesid);
		$this->view->cart = $cart->getUserCart($sesid);
        
        
    }

}

	
	



