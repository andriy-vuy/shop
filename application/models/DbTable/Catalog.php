<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_DbTable_Catalog extends Zend_Db_Table_Abstract
{

    protected $_name = 'catalog';
	protected $_dependetTables = array(
		'Application_Model_DbTable_Products');


}

