<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_Info extends Custom_Model
{
	public function __construct($id = null)
	{
		parent::__construct(new Application_Model_DbTable_Info, $id);
	}
	
	public function getInfo($id)
    {
		$select  = $this->_dbTable->select()
			->from('info',array('i_text'))
			->where('i_id = ?', $id);
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
    }
	
	public function getAllInfo()
    {
		$select  = $this->_dbTable->select()
			->from('info',array('i_id','i_title'));
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
    }

}

