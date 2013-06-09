<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Application_Model_DbTable_ProductsImg extends Zend_Db_Table_Abstract
{

    protected $_name = 'products_img';
	protected $_referenceMap = array(
		'Products' => array(
			'columns' => 'pi_pid',
			'refTableClass' => 'Application_Model_DbTable_Products',
			'refColumns' => 'p_id',
			'onDlete' => self::CASCADE
		)
	);


}

