<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Custom_Model
{
	protected $_dbTable;
	protected $_row;
	public function __construct(Zend_Db_Table_Abstract $_dbTable, $id)
	{
		$this->_dbTable = $_dbTable;
		if($id){
			$this->_row = $this->_dbTable->find($id)->current();
		}else{
			$this->_row = $this->_dbTable->createRow();
		}
	}
	
	
	
	public function fill($data)
	{
		foreach($data as $key => $value){
			if(isset($this->_row->$key)){
				$this->_row->$key = $value;
			}
		}
	}
	
	
	
	public function save()
	{
		$this->_row->save();
	}
	
	
	public function delete()
	{
		$this->_row->delete();
	}
	
	
	public function __set($name,$val)
	{
		if(isset($this->_row->$name)){
			$this->_row->$name = $val;
        }
	}
	
	
	public function __get($name)
	{
		if(isset($this->_row->$name)){
			return $this->_row->$name;
		}
	}
	
	public function populateForm()
	{
		return $this->_row->toArray();
	}
	
	public function getAll($sort)
	{
		$select  = $this->_dbTable->select()
			->order($sort);
		$stmt = $select->query();
		$result = $stmt->fetchAll();
        return $result;
	}
}


