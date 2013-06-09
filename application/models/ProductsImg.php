<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_ProductsImg extends Custom_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Application_Model_DbTable_ProductsImg, $id);
	}
	
	public function getProductImg($id)
	{
		$select  = $this->_dbTable->select()
			->from('products_img')
			->where('pi_pid = ?', $id);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}

}