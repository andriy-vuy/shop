<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_ShoppingCart extends Custom_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Application_Model_DbTable_ShoppingCart, $id);
	}
	
	public function getUserCart($sesid)
	{
		$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->from(array('sc' => 'shopping_cart'),
					array('sc.sc_pid',
							'sc.sc_user',
							'sc.sc_product',
			'SUM(sc.sc_quantity) AS sc_quantity'))
			->join(array('p' => 'products'),
			'sc. sc_product = p. p_id')
			->join(array('m' => 'markup'),
			'p. p_markup = m. t_id')
			->where('sc.sc_user = ?', $sesid)
			->where('p.p_status = 1')
			->where('p.p_quantity - p.p_ordered > 0')
			->group('p.p_id');
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function getImgCart($sesid)
	{
	$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->distinct()
			->from(array('sc' => 'shopping_cart'),
					array('sc.sc_pid',
							'sc.sc_user',
							'sc.sc_product'))
			->join(array('p' => 'products'),
			'sc. sc_product = p.p_id',
					array('p_id'))
			->join(array('i' => 'products_img'),
			'p.p_id = i.pi_pid')
			->where('sc.sc_user = ?', $sesid)
			->where('p.p_status = 1')
			->group('p.p_id');
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function deleteCart($sesid)
	{
		$table = $this->_dbTable;
		$where = $table->getAdapter()->quoteInto('sc_user = ?', $sesid);
		$table->delete($where);
	}

}