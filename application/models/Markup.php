<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_Markup extends Custom_Model
{
	public function __construct($id = null)
	{
		parent::__construct(new Application_Model_DbTable_Markup, $id);
	}
	
	public function getMarkup()
    {
	$select  = $this->_dbTable->select()
				->from(array('m' => 'markup'),
					array('key' => 't_id',
					'value' => 'name'));
			$stmt = $select->query();
			$result = $stmt->fetchAll();
        return $result;
	}

}

