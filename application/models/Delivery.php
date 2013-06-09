<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_Delivery extends Custom_Model
{
	public function __construct($id = null)
	{
		parent::__construct(new Application_Model_DbTable_Delivery, $id);
	}
	
	public function getDelivery()
    {
		$select  = $this->_dbTable->select()
			->from('delivery', array(
					'key' => 'd_id',
					'value' => 'd_name'));
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
    }


}

