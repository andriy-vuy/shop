<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_Search extends Custom_Model
{
	public function __construct($id = null)
	{
		parent::__construct(new Application_Model_DbTable_Search, $id);
	}
	
	public function searchProduct($val)
	{
		$select  = $this->_dbTable->select()
			->from(array('search'))
			->where('p_status = 1')
			->where("p_title LIKE '%$val%'")
			->orWhere("p_text LIKE '%$val%'")
			->orWhere("c_title LIKE '%$val%'")
			->orWhere("c_text LIKE '%$val%'")
			->orWhere("u_name LIKE '%$val%'")
			->orWhere("u_email LIKE '%$val%'")
			->orWhere("u_phone LIKE '%$val%'");
			/* ->where("MATCH(p_title,
							p_text,
							c_title,
							c_text,
							u_name,
							u_email,
							u_phone)
				AGAINST('$val*' IN BOOLEAN MODE)"); */
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}
	
	public function searchProductAdmin($val)
	{
		$select  = $this->_dbTable->select()
			->from(array('search'))
			->where("p_title LIKE '%$val%'")
			->orWhere("p_text LIKE '%$val%'")
			->orWhere("c_title LIKE '%$val%'")
			->orWhere("c_text LIKE '%$val%'")
			->orWhere("u_name LIKE '%$val%'")
			->orWhere("u_email LIKE '%$val%'")
			->orWhere("u_phone LIKE '%$val%'");
			/* ->where("MATCH(p_title,
							p_text,
							c_title,
							c_text,
							u_name,
							u_email,
							u_phone)
				AGAINST('$val*' IN BOOLEAN MODE)"); */
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}

}

