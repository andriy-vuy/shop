<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class Zend_View_Helper_CatHelper extends Zend_View_Helper_Abstract
{
    public function catHelper()
    {
		$catalog = new Application_Model_Catalog();
		$sort = 'c_id';
		$catalog = $catalog->getAll($sort);
		echo '<br><a href="/products/">Товары</a>';
		if(count($catalog)){
			$elm = array(0 => array('c_title' => '', 'c_parent_id' => -1));
			foreach($catalog as $r)
			$elm[$r['c_id']] = $r;
	
			function print_catalog($data, $id, $level = 0)
			{
				echo str_repeat('&nbsp', $level) . "<a href='/products/catalogview/id/$id/'>";
				echo $data[$id]['c_title'];
				echo '<br>' . '</a>';
				foreach ($data as $row)
					if ($row['c_parent_id'] == $id)
					echo print_catalog($data, $row['c_id'], $level + 1);
			}
			print_catalog($elm, 0);
		}
		
	}
}
