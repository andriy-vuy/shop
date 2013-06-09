<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_Orders extends Custom_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Application_Model_DbTable_Orders, $id);
	}
	
	public function getUserOrders($u_id)
	{
		$select  = $this->_dbTable->select()
			->from('orders', array('o_code', 'o_created'))
			->where('o_uid = ?', $u_id);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function getOrder($code)
	{
		$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->from(array('o' => 'orders'),
							array('o_id',
								'o_username',
								'o_useremail',
								'o_userphone',
								'o_text',
								'o_payment',
								'o_code',
								'o_created'))
			->join(array('d' => 'delivery'),
				'o.o_delivery = d.d_id',
					array('d_name'))
			->where('o_code = ?', $code);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function getOrderId($id)
	{
		$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->from(array('o' => 'orders'),
							array('o_id',
								'o_username',
								'o_useremail',
								'o_userphone',
								'o_text',
								'o_payment',
								'o_code',
								'o_created'))
			->join(array('d' => 'delivery'),
				'o.o_delivery = d.d_id',
					array('d_name'))
			->where('o_id = ?', $id);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function sendOrderEmail($tomail)
	{
		$mail = new Custom_mail();
		$mail->addTo($tomail);
		$mail->setSubject('Код заказа');
		$mail->setBodyView('order', array('order' => $this));
		$mail->send();
	}

}