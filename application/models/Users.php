<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_Users extends Custom_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Application_Model_DbTable_Users, $id);
	}
	
	public function sendActivationEmail()
	{
		$mail = new Custom_mail();
		$mail->addTo($this->_row->u_email);
		$mail->setSubject('Активация аккаунта');
		$mail->setBodyView('activation', array('user' => $this));
		$mail->send();
	}
	
	public function authorize($u_name, $u_password)
	{
		$auth = Zend_Auth::getInstance();
		$authAdapter = new Zend_Auth_Adapter_DbTable(
			Zend_Db_Table::getDefaultAdapter(),
			'users','u_name','u_password','sha(?)');
		$authAdapter->setIdentity($u_name)
					->setCredential($u_password);
		$result = $auth->authenticate($authAdapter);
		if($result->isValid()){
			$storage = $auth->getStorage();
			$storage->write($authAdapter->getResultRowObject(null, array('u_password')));
			require_once('Zend/Session/Namespace.php');
            $session = new Zend_Session_Namespace('Zend_Auth');
            $session->setExpirationSeconds(24*3600);
            if (isset($_POST['rememberme'])) {
                Zend_Session::rememberMe();
            }
			return true;
		}else{
			return false;
		}
	}

}

