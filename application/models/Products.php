<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_Products extends Custom_Model
{

	public function __construct($id = null)
	{
		parent::__construct(
		new Application_Model_DbTable_Products, $id);
	}
	
	//admin----------
	
	public function getProduct()
	{
		$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->from(array('p' => 'products'))
			->joinleft(array('i' => 'products_img'),
			'p. p_id = i. pi_pid')
			->group('p_id')
			->order('p_created DESC')
			->limit(5);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function getAllProductsImg($sort)
	{
		$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->from(array('p' => 'products'))
			->joinleft(array('i' => 'products_img'),
			'p. p_id = i. pi_pid', array('pi_img'))
			->join(array('m' => 'markup'),
			'p. p_markup = m. t_id')
			->group('p_id')
			->order($sort);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function getAllProductsImgCat($id, $sort)
	{
		$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->from(array('p' => 'products'))
			->joinleft(array('i' => 'products_img'),
			'p. p_id = i. pi_pid')
			->join(array('m' => 'markup'),
			'p. p_markup = m. t_id')
			->group('p_id')
			->where('p.p_cat_id = ?', $id)
			->order($sort);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function getProdId($row)
	{
		$select  = $this->_dbTable->select()
		->from('products', 'p_id')
		->where('p_code = ?', $row);
		$stmt = $select->query();
		$result = $stmt->fetchAll();
        return $result;
	}
	
	//user----------
	
	public function getProdImg($sort)
	{
		$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->from(array('p' => 'products'))
			->joinleft(array('i' => 'products_img'),
			'p. p_id = i. pi_pid')
			->join(array('m' => 'markup'),
			'p. p_markup = m. t_id')
			->group('p_id')
			->where('p_status = 1')
			->order($sort);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function getProductsImgCat($id, $sort)
	{
		$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->from(array('p' => 'products'))
			->joinleft(array('i' => 'products_img'),
			'p. p_id = i. pi_pid')
			->join(array('m' => 'markup'),
			'p. p_markup = m. t_id')
			->group('p_id')
			->where('p_status = 1')
			->where('p.p_cat_id = ?', $id)
			->order($sort);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function getProductMain()
	{
		$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->from(array('p' => 'products'),
					array('p_id',
						'p_title',
						'p_price'))
			->joinleft(array('i' => 'products_img'),
			'p. p_id = i. pi_pid', array('pi_img'))
			->join(array('m' => 'markup'),
			'p. p_markup = m. t_id')
			->where('p_status = 1')
			->group('p_id')
			->limit(9)
			->order('p_id DESC');
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	

}