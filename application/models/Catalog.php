<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_Catalog extends Custom_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Application_Model_DbTable_Catalog, $id);
	}
	
	public function getCategories()
    {
		$select  = $this->_dbTable->select()
			->from('catalog', array(
					'key' => 'c_id',
					'value' => 'c_title'))
			->where('c_isproduct = 0');
			$stmt = $select->query();
			$result = $stmt->fetchAll();
		array_unshift($result , '');
        return $result;
    }
	
	public function getCatAdd()
    {
	$select  = $this->_dbTable->select()
				->from(array('c1' => 'catalog'),
					array('key' => 'c_id',
					'value' => 'c_title'))
				->joinLeft(array('c2' => 'catalog'),'c1. c_id = c2. c_parent_id')
				->where('c2.c_id is null');
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function getDate($id)
    {
		$select  = $this->_dbTable->select()
			->setIntegrityCheck(false)
			->from(array('c' => 'catalog'),
						array('c_id'))
			->join(array('p' => 'products'),
				'c.c_id = p.p_cat_id',
						array('p_latmodified'))
			->where('c.c_id = ?', $id)
			->order('p_latmodified DESC')
			->limit(1);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	
	}

}