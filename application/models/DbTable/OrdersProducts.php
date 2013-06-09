<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_DbTable_OrdersProducts extends Zend_Db_Table_Abstract
{

    protected $_name = 'orders_products';
	protected $_referenceMap = array(
		'Orders' => array(
			'columns' => 'op_productid',
			'refTableClass' => 'Application_Model_DbTable_Orders',
			'refColumns' => 'o_id',
			'onDlete' => self::CASCADE
		)
	);


}

