<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_OrdersProducts extends Custom_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Application_Model_DbTable_OrdersProducts, $id);
	}
	
	public function getOp($id)
	{
		$select  = $this->_dbTable->select()
			->from('orders_products')
			->where('op_ordersid = ?', $id);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}

}