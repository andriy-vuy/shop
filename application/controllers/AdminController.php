<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->title = "Администртрование";
        $this->view->headTitle($this->view->title);
    }

    public function useraddAction()
    {
        $this->view->title = "Добавить нового пользователя";
        $this->view->headTitle($this->view->title);
        $form = new Application_Form_AddUser();
		
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getPost())){
				$user = new Application_Model_Users();
				$user->fill($form->getValues());
				$user->u_created = date('Y-m-d H:i:s');
				$user->u_password = sha1($user->u_password);
				$user->u_code = uniqid();
				$user->save();
				$this->_helper->redirector('users');
			}
		}
		
		$this->view->form = $form;
    }

    public function usereditAction()
    {
        $this->view->title = "Редактировать данные пользователя";
        $this->view->headTitle($this->view->title);
		$id = $this->_getParam('id');
		if($id){
			$user = new Application_Model_Users($id);
			$form = new Application_Form_EditUser();
			$this->view->user = $user;
		
			if($this->getRequest()->isPost()){
				if($form->isValid($this->getRequest()->getPost())){
				$user->fill($form->getValues());
				$user->u_lastmodified = date('Y-m-d H:i:s');
				$user->u_code = uniqid();
				$user->save();
				$this->_helper->redirector('users');
				}
			}else{
				$form->populate($user->populateForm());
			}
		
			$this->view->form = $form;
		}else{
			$this->_helper->redirector('users');
		}
    }

    public function usersAction()
    {
        $this->view->title = "Список пользователей";
        $this->view->headTitle($this->view->title);
		$user = new Application_Model_Users();
		$num = 10;
		$page = $this->_getParam('page');
		if($page<1 or empty($page)){
			$page = 1;
		}
		$sort = 'u_id';
		$result = $user->getAll($sort);
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($result));
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage($num);
		Zend_Paginator::setDefaultScrollingStyle('Sliding');
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('/paginators/pagination.phtml');
		$this->view->paginator = $paginator;
    }

    public function userdeleteAction()
    {
        $id = $this->_getParam('id');
		if($id){
			$user = new Application_Model_Users($id);
			$user->delete();
			$this->_helper->redirector('users');
		}else{
			$this->_helper->redirector('users');
		}
    }

    public function userviewAction()
    {
        $this->view->title = "Просмотр данных пользователя";
        $this->view->headTitle($this->view->title);
		$id = $this->_getParam('id');
		if($id){
			$user = new Application_Model_Users($id);
			$this->view->user = $user;
		}else{
			$this->_helper->redirector('users');
		}
    }

    public function catalogAction()
    {
        $this->view->title = "Каталог список категорий";
        $this->view->headTitle($this->view->title);
		
		$catalog = new Application_Model_Catalog();
		$sort = 'c_id';
		$this->view->catalog = $catalog->getAll($sort);
    }

    public function catalogviewAction()
    {
        $this->view->title = "Просмотр категории каталога";
        $this->view->headTitle($this->view->title);
		$id = $this->_getParam('id');
		if($id){
			$this->view->cat_id = $id;
			$catalog = new Application_Model_Catalog($id);
			$pid = $catalog->c_parent_id;
			$c_parent = new Application_Model_Catalog($pid);
			$this->view->catalog = $catalog;
			$this->view->c_parent = $c_parent;
			$products = new Application_Model_Products($id);
			$num = 10;
			$page = $this->_getParam('page');
			if($page<1 or empty($page)){
				$page = 1;
			}
			if($this->_getParam('sort') == 1){
			$sort = 'p_id DESC';
		}elseif($this->_getParam('sort') == 2){
			$sort = 'p_id';
		}elseif($this->_getParam('sort') == 3){
			$sort = 'p_title DESC';
		}elseif($this->_getParam('sort') == 4){
			$sort = 'p_title';
		}elseif($this->_getParam('sort') == 5){
			$sort = 'p_price DESC';
		}elseif($this->_getParam('sort') == 6){
			$sort = 'p_price';
		}else{
			$sort = 'p_id DESC';
		}
			$result = $products->getAllProductsImgCat($id, $sort);
			$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($result));
			$paginator->setCurrentPageNumber($page);
			$paginator->setItemCountPerPage($num);
			Zend_Paginator::setDefaultScrollingStyle('Sliding');
			Zend_View_Helper_PaginationControl::setDefaultViewPartial('/paginators/pagination.phtml');
			$this->view->paginator = $paginator;
		}else{
			$this->_helper->redirector('catalog');
		}
    }

    public function catalogaddAction()
    {
        $this->view->title = "Добавить новую категорию";
        $this->view->headTitle($this->view->title);
        $form = new Application_Form_Catadd();
		
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getPost())){
				$catalog = new Application_Model_Catalog();
				$catalog->fill($form->getValues());
				$catalog->c_created = date('Y-m-d H:i:s');
				$catalog->c_lastmodified = date('Y-m-d H:i:s');
				$catalog->save();
				$this->_helper->redirector('catalogadd');
			}	
		}
		$this->view->form = $form;
    }

    public function catalogeditAction()
    {
		$this->view->title = "Редактировать категорию каталога";
        $this->view->headTitle($this->view->title);
		$id = $this->_getParam('id');
		if($id){
			$catalog = new Application_Model_Catalog($id);
			$form = new Application_Form_Catadd();
			$this->view->catalog = $catalog;
		
			if($this->getRequest()->isPost()){
				if($form->isValid($this->getRequest()->getPost())){
				$catalog->fill($form->getValues());
				$catalog->c_lastmodified = date('Y-m-d H:i:s');
				$catalog->save();
				$this->_helper->redirector('catalog');
				}
			}else{
				$form->populate($catalog->populateForm());
			}
		
			$this->view->form = $form;
		}else{
			$this->_helper->redirector('catalog');
		}
    }

    public function catalogdeleteAction()
    {
        $id = $this->_getParam('id');
		if($id){
			$catalog = new Application_Model_Catalog($id);
			$catalog->delete();
			$this->_helper->redirector('catalog');
		}else{
			$this->_helper->redirector('catalog');
		}
    }

    public function productsAction()
    {
        $this->view->title = "Список товаров";
        $this->view->headTitle($this->view->title);
		$products = new Application_Model_Products();
		$num = 10;
		$page = $this->_getParam('page');
		if($page<1 or empty($page)){
			$page = 1;
		}
		if($this->_getParam('sort') == 1){
			$sort = 'p_id DESC';
		}elseif($this->_getParam('sort') == 2){
			$sort = 'p_id';
		}elseif($this->_getParam('sort') == 3){
			$sort = 'p_title DESC';
		}elseif($this->_getParam('sort') == 4){
			$sort = 'p_title';
		}elseif($this->_getParam('sort') == 5){
			$sort = 'p_price DESC';
		}elseif($this->_getParam('sort') == 6){
			$sort = 'p_price';
		}else{
			$sort = 'p_id DESC';
		}
		$result = $products->getAllProductsImg($sort);
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($result));
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage($num);
		Zend_Paginator::setDefaultScrollingStyle('Sliding');
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('/paginators/pagination.phtml');
		$this->view->paginator = $paginator;
    }

    public function productaddAction()
    {
        $this->view->title = "Добавить новый товар";
        $this->view->headTitle($this->view->title);
        $form = new Application_Form_Product();
		$product = new Application_Model_Products();
		
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getPost())){
				$product->fill($form->getValues());
				$product->p_created = date('Y-m-d H:i:s');
				$product->p_latmodified = date('Y-m-d H:i:s');
				$product->save();
				$catalog = new Application_Model_Catalog($form->getValue('p_cat_id'));
				$catalog->c_isproduct = true;
				$catalog->save();
				if($form->pi_img->getFileInfo()){
					foreach($form->pi_img->getFileInfo() as $img){
						if($img['name']){
						$images = new Application_Model_ProductsImg();
						$images->pi_pid = $product->p_id;
						$images->pi_img = $img['name'];
						$images->save();
						}
					}
				}
				$this->_helper->redirector('productadd');
			}	
		}
		$this->view->form = $form;
		$products = $product->getProduct();
		$this->view->products = $products;
		
    }

    public function producteditAction()
    {
        $this->view->title = "Редактировать товар";
        $this->view->headTitle($this->view->title);
		$id = $this->_getParam('id');
		if($id){
			$this->view->id = $id;
			$images = new Application_Model_ProductsImg();
			$this->view->images = $images->getProductImg($id);
			$form_img = new Application_Form_Img();
			if($this->getRequest()->isPost()){
				if($form_img->isValid($this->getRequest()->getPost())){
				$images->fill($form_img->getValues());
					if($form_img->img->getFileInfo()){
						foreach($form_img->img->getFileInfo() as $img){
							if($img['name']){
							$images->pi_pid = $id;
							$images->pi_img = $img['name'];
							$images->save();
							$this->_redirect($_SERVER['HTTP_REFERER']);
							}
						}
					}
				}
			}
			$this->view->form_img = $form_img;
			
			$product = new Application_Model_Products($id);
			$form = new Application_Form_Productedit();
		
			if($this->getRequest()->isPost()){
				if($form->isValid($this->getRequest()->getPost())){
				$product->fill($form->getValues());
				$product->p_ordered = 0;
				$product->p_latmodified = date('Y-m-d H:i:s');
				$product->save();
				$catalog = new Application_Model_Catalog($form->getValue('p_cat_id'));
				$catalog->c_isproduct = true;
				$catalog->save();
				$this->_helper->redirector('products');
				}
			}else{
				$form->populate($product->populateForm());
			}
		
			$this->view->form = $form;
		}else{
		$this->_helper->redirector('products');
		}
    }
	
	public function productviewAction()
    {
		$this->view->title = "Просмотр товара";
        $this->view->headTitle($this->view->title);
		$id = $this->_getParam('id');
		if($id){
			$product = new Application_Model_Products($id);
			$this->view->product = $product;
			$pid = $product->p_cat_id;
			$mid = $product->p_markup;
			$markup = new Application_Model_Markup($mid);
			$this->view->markup = $markup;
			$cat = new Application_Model_Catalog($pid);
			$this->view->cat = $cat;
			$images = new Application_Model_ProductsImg();
			$img = $images->getProductImg($id);
			$this->view->img = $img;
		}else{
			$this->_helper->redirector('products');
		}
    }
	
	public function imgdeleteAction()
    {
        $id = $this->_getParam('id');
		if($id){
			$images = new Application_Model_ProductsImg($id);
			unlink(APPLICATION_PATH . '/../public_html/data/images/' . $images->pi_img);
			$images->delete();
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
		$this->_redirect($_SERVER['HTTP_REFERER']);
    }

    public function productdeleteAction()
    {
        $id = $this->_getParam('id');
		if($id){
			$images = new Application_Model_ProductsImg();
			$img = $images->getProductImg($id);
			foreach($img as $image){
				unlink(APPLICATION_PATH . '/../public_html/data/images/' . $image['pi_img']);
			}
			$product = new Application_Model_Products($id);
			$product->delete();
			$this->_helper->redirector('products');
		}else{
			$this->_helper->redirector('products');	
		}
		$this->_helper->redirector('products');
    }

    public function productactivAction()
    {
		$id = $this->_getParam('id');
		if($id){
			$val = $this->_getParam('val');
			$product = new Application_Model_Products($id);
			if($val == 1){
				$product->p_status = '1';
				$product->p_latmodified = date('Y-m-d H:i:s');
				$product->save();
			}else{
				$product->p_status = '0';
				$product->p_latmodified = date('Y-m-d H:i:s');
				$product->save();
			}
		$this->_redirect($_SERVER['HTTP_REFERER']);
		}else{
		$this->_redirect($_SERVER['HTTP_REFERER']);
		}
    }

    public function markupAction()
    {
        $this->view->title = "Список наценок";
        $this->view->headTitle($this->view->title);
		
		$markup = new Application_Model_Markup();
		$sort = 't_id';
		$this->view->markup = $markup->getAll($sort);
    }
	
	public function markupaddAction()
    {
        $this->view->title = "Добавить коофициенты наценки";
        $this->view->headTitle($this->view->title);
        $form = new Application_Form_Markap();
		
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getPost())){
				$markup = new Application_Model_Markup();
				$markup->fill($form->getValues());
				$markup->save();
				$this->_helper->redirector('markup');
			}
		}
		
		$this->view->form = $form;
    }
	
	public function markupeditAction()
    {
        $this->view->title = "Редактировать коофициенты наценки";
        $this->view->headTitle($this->view->title);
		$id = $this->_getParam('id');
		if($id){
			$markup = new Application_Model_Markup($id);
			$form = new Application_Form_Markap();
			if($this->getRequest()->isPost()){
				if($form->isValid($this->getRequest()->getPost())){
				$markup->fill($form->getValues());
				$markup->save();
				$this->_helper->redirector('markup');
				}
			}else{
				$form->populate($markup->populateForm());
			}
			$this->view->form = $form;
		}else{
			$this->_helper->redirector('markup');
		}
    }
	
	public function deliveryAction()
	{
        $this->view->title = "Список перевозчиков";
        $this->view->headTitle($this->view->title);
		
		$delivery = new Application_Model_Delivery();
		$sort = 'd_id';
		$this->view->delivery = $delivery->getAll($sort);
		
        $form = new Application_Form_Delivery();
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getPost())){
				$delivery->fill($form->getValues());
				$delivery->save();
				$this->_helper->redirector('delivery');
			}
		}
		
		$this->view->form = $form;
    }
	
	public function deliverydeleteAction()
	{
	$id = $this->_getParam('id');
		if($id){
			$delivery = new Application_Model_Delivery($id);
			$delivery->delete();
			$this->_helper->redirector('delivery');
		}else{
			$this->_helper->redirector('delivery');
		}
	}
	
	public function ordersAction()
	{
		$this->view->title = "Список заказов";
		$this->view->headTitle($this->view->title);
		$orders = new Application_Model_Orders();
		$num = 10;
		$page = $this->_getParam('page');
		if($page<1 or empty($page)){
			$page = 1;
		}
		$sort = 'o_id DESC';
		$result = $orders->getAll($sort);
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($result));
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage($num);
		Zend_Paginator::setDefaultScrollingStyle('Sliding');
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('/paginators/pagination.phtml');
		$this->view->paginator = $paginator;
	}
	
	public function orderAction()
	{
		$this->view->title = "Информация о заказе:";
        $this->view->headTitle($this->view->title);
		$id = $this->_getParam('id');
		if($id){
			$orders = new Application_Model_Orders($id);
			$order = $orders->getOrderId($id);
			$this->view->order = $order;
			foreach($order as $val){
			$id = $val['o_id'];
			$op = new Application_Model_OrdersProducts($id);
			$order_p = $op->getOp($id);
			$this->view->order_p = $order_p;
			}
		}else{
			$this->_helper->redirector('orders');
		}
	}
	
	public function orderdeleteAction()
	{
		 $id = $this->_getParam('id');
		if($id){
			$orders = new Application_Model_Orders($id);
			$orders->delete();
			$this->_helper->redirector('orders');
		}else{
			$this->_helper->redirector('orders');
		}
	}
	
	public function searchAction()
    {
		$this->view->title = "Результат поиска";
        $this->view->headTitle($this->view->title);
		if($this->_getParam('val')){
			$val = $this->_getParam('val');
			$search = new Application_Model_Search();
			$search = $search->searchProductAdmin($val);
			$this->view->search = $search;
		}else{
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	public function infoAction()
    {
		$this->view->title = "Информация для пользователей";
        $this->view->headTitle($this->view->title);
		$info = new Application_Model_Info();
		$info = $info->getAllInfo();
		$this->view->info = $info;
		if($this->_getParam('id')){
			$id = $this->_getParam('id');
			if($id){
			$info_ed = new Application_Model_Info($id);
			$form = new Application_Form_Info();
			$this->view->info_ed = $info_ed;
		
			if($this->getRequest()->isPost()){
				if($form->isValid($this->getRequest()->getPost())){
				$info_ed->fill($form->getValues());
				$info_ed->i_lastmodified = date('Y-m-d H:i:s');
				$info_ed->save();
				$this->_helper->redirector('info');
				}
			}else{
				$form->populate($info_ed->populateForm());
			}
			$this->view->form = $form;
			}
		}
	}
	
	public function csvAction()
    {
		$this->view->title = "CSV";
        $this->view->headTitle($this->view->title);
		if($this->_getParam('value')){
			$value = $this->_getParam('value');
			if($value == 'insert'){
$file = "./data/csv/insert.csv";
if (file_exists($file)){
	if(($handle = fopen($file, "r")) !== FALSE){
		$column = fgetcsv($handle,"",";");
		foreach($column as $col) {
			$columns[]= trim($col);
		}
		while (($data = fgetcsv($handle,"",";")) !== FALSE) {
			$values = array();
			foreach($data as $val){
				$val = mb_convert_encoding($val,"utf-8","cp1251");
				$values[]= trim($val); 
			}
			$item = array_combine($columns, $values);
			$product = new Application_Model_Products();
			if(isset($item['p_cat_id'])){
			$product->p_cat_id = $item['p_cat_id'];
			}
			if(isset($item['p_code'])){
			$product->p_code = $item['p_code'];
			}
			if(isset($item['p_markup'])){
			$product->p_markup = $item['p_markup'];
			}
			if(isset($item['p_title'])){
			$product->p_title = $item['p_title'];
			}
			if(isset($item['p_metakeywords'])){
			$product->p_metakeywords = $item['p_metakeywords'];
			}
			if(isset($item['p_metadescription'])){
			$product->p_metadescription = $item['p_metadescription'];
			}
			if(isset($item['p_text'])){
			$product->p_text = $item['p_text'];
			}
			if(isset($item['p_price'])){
			$product->p_price = $item['p_price'];
			}
			if(isset($item['p_quantity'])){
			$product->p_quantity = $item['p_quantity'];
			}
			$product->p_created = date('Y-m-d H:i:s');
			$product->p_latmodified = date('Y-m-d H:i:s');
			$product->save();
			if(isset($item['img_1'])){
			$images = new Application_Model_ProductsImg();
			$images->pi_pid = $product->p_id;
			$images->pi_img = $item['img_1'];
			$images->save();
			}
			if(isset($item['img_2'])){
			$images = new Application_Model_ProductsImg();
			$images->pi_pid = $product->p_id;
			$images->pi_img = $item['img_2'];
			$images->save();
			}
		}
	}
		fclose($handle);
		unlink($file);
		$this->_helper->redirector('products');
}else{
	echo 'File not exists!';
}
			}elseif($value == 'update'){
$file = "./data/csv/update.csv";
if (file_exists($file)){
	if(($handle = fopen($file, "r")) !== FALSE){
		$column = fgetcsv($handle,"",";");
		foreach($column as $col) {
			$columns[]= trim($col);
		}
		while (($data = fgetcsv($handle,"",";")) !== FALSE) {
			$values = array();
			foreach($data as $val){
				$val = mb_convert_encoding($val,"utf-8","cp1251");
				$values[]= trim($val); 
			}
			$item = array_combine($columns, $values);
			$row = $item['p_code'];
			$products = new Application_Model_Products();
			$products = $products->getProdId($row);
			foreach($products as $val){
			$id = $val['p_id'];
			$product = new Application_Model_Products($id);
			if(isset($item['p_cat_id'])){
			$product->p_cat_id = $item['p_cat_id'];
			}
			if(isset($item['p_code'])){
			$product->p_code = $item['p_code'];
			}
			if(isset($item['p_markup'])){
			$product->p_markup = $item['p_markup'];
			}
			if(isset($item['p_title'])){
			$product->p_title = $item['p_title'];
			}
			if(isset($item['p_metakeywords'])){
			$product->p_metakeywords = $item['p_metakeywords'];
			}
			if(isset($item['p_metadescription'])){
			$product->p_metadescription = $item['p_metadescription'];
			}
			if(isset($item['p_text'])){
			$product->p_text = $item['p_text'];
			}
			if(isset($item['p_price'])){
			$product->p_price = $item['p_price'];
			}
			if(isset($item['p_status'])){
			$product->p_status = $item['p_status'];
			}
			if(isset($item['p_quantity'])){
			$product->p_quantity = $item['p_quantity'];
			}
			$product->p_ordered = 0;
			$product->p_latmodified = date('Y-m-d H:i:s');
			$product->save();
			}
		}
	}
		fclose($handle);
		unlink($file);
		$this->_helper->redirector('products');
}else{
	echo 'File not exists!';
}
			}elseif($value == 'delete'){
$file = "./data/csv/delete.csv";			
if (file_exists($file)){
	if(($handle = fopen($file, "r")) !== FALSE){
		while (($data = fgetcsv($handle,"",";")) !== FALSE) {
			$values = array();
			foreach($data as $val){
				$row = trim($val); 
			}
			$product = new Application_Model_Products();
			$product = $product->getProdId($row);
			foreach($product as $val){
				$id = $val['p_id'];
				if($id){
					$images = new Application_Model_ProductsImg();
					$img = $images->getProductImg($id);
					foreach($img as $image){
						unlink(APPLICATION_PATH . '/../public_html/data/images/' . $image['pi_img']);
					}
					$product = new Application_Model_Products($id);
					$product->delete();
				}else{
					$this->_helper->redirector('csv');
				}	
			}
		}
	}
		fclose($handle);
		unlink($file);
		$this->_helper->redirector('products');
}else{
	echo 'File not exists!';
}
			}else{
				$this->_helper->redirector('products');
			}
		}
		if (!file_exists("./data/csv/insert.csv"
		) && !file_exists("./data/csv/update.csv"
		) && !file_exists("./data/csv/delete.csv"
		)){
			$form = new Application_Form_Csv();
			$this->view->form = $form;
			if($this->getRequest()->isPost()){
				if($form->isValid($this->getRequest()->getPost())){
					if (!$form->csv->receive()) {
						print "Upload error";
					}
					$this->_helper->redirector('csv');
				}
			}
		}
	}


}

	







