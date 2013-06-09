<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_DbTable_Orders extends Zend_Db_Table_Abstract
{

    protected $_name = 'orders';
	protected $_dependetTables = array(
	'Application_Model_DbTable_OrdersProducts');


}

