<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_DbTable_Products extends Zend_Db_Table_Abstract
{

    protected $_name = 'products';
	protected $_dependetTables = array(
	'Application_Model_DbTable_ProductsImg');
	protected $_referenceMap = array(
		'Catalog' => array(
			'columns' => 'p_cat_id',
			'refTableClass' => 'Application_Model_DbTable_Catalog',
			'refColumns' => 'c_id',
			'onDlete' => self::CASCADE
		)
	);


}

