<?php
/**
 * Copyright (c) 2012 Vuy_Nick
 * @author Vuy_Nick <lucky_nick@mail.ru>
 * @version 1.0
 */
class ProductsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->title = "Все товары";
        $this->view->headTitle($this->view->title);
        if(isset(Zend_Auth::getInstance()->getIdentity()->id)){
			$identit = Zend_Auth::getInstance()->getIdentity()->id;
			$this->view->identit = $identit;
		}
		$products = new Application_Model_Products;
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
		$result = $products->getProdImg($sort);
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($result));
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage($num);
		Zend_Paginator::setDefaultScrollingStyle('Sliding');
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('/paginators/pagination.phtml');
		$this->view->paginator = $paginator;
    }

    public function catalogviewAction()
    {
		$id = $this->_getParam('id');
		if(isset(Zend_Auth::getInstance()->getIdentity()->id)){
			$identit = Zend_Auth::getInstance()->getIdentity()->id;
			$this->view->identit = $identit;
		}
		if($id){
			$this->view->cat_id = $id;
			$catalog = new Application_Model_Catalog($id);
			$date = $catalog->getDate($id);
			if($date){
				foreach($date as $val){
				$this->view->headMeta()->appendHttpEquiv('Last-Modified', $val['p_latmodified']);
				}
			}else{
				$this->view->headMeta()->appendHttpEquiv('Last-Modified', $catalog->c_lastmodified);
			}
			if($catalog->c_metakeywords){
				$this->view->headMeta()->appendName('keywords', $catalog->c_metakeywords);
			}
			if($catalog->c_metadescription){
				$this->view->headMeta()->appendName('description', $catalog->c_metadescription);
			}
			$this->view->catalog = $catalog;
			$this->view->title = $catalog->c_title;
			$this->view->headTitle($this->view->title);
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
			$result = $products->getProductsImgCat($id, $sort);
			$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($result));
			$paginator->setCurrentPageNumber($page);
			$paginator->setItemCountPerPage($num);
			Zend_Paginator::setDefaultScrollingStyle('Sliding');
			Zend_View_Helper_PaginationControl::setDefaultViewPartial('/paginators/pagination.phtml');
			$this->view->paginator = $paginator;
		}else{
			$this->_helper->redirector('index');
		}
		
    }

    public function viewAction()
    {
		if(isset(Zend_Auth::getInstance()->getIdentity()->id)){
			$identit = Zend_Auth::getInstance()->getIdentity()->id;
			$this->view->identit = $identit;
		}
		$id = $this->_getParam('id');
		if($id){
			$product = new Application_Model_Products($id);
			$this->view->headMeta()->appendHttpEquiv('Last-Modified', $product->p_latmodified);
			$this->view->headMeta()->appendName('keywords', $product->p_metakeywords);
			$this->view->headMeta()->appendName('description', $product->p_metadescription);
			if(isset(Zend_Auth::getInstance()->getIdentity()->u_role)){
				$name = Zend_Auth::getInstance()->getIdentity()->u_role;
			}else{
				$name = 'guest';
			}
			if($name == 'guest' || $name == 'user'){
				$this->view->title = 'ID-' . $product->p_id;
			}else{
				$this->view->title = $product->p_title;
			}
			$this->view->headTitle($this->view->title);
			$this->view->product = $product;
			$pid = $product->p_cat_id;
			$cat = new Application_Model_Catalog($pid);
			$this->view->cat = $cat;
			$p_markup = $product->p_markup;
			$markup = new Application_Model_Markup($p_markup);
			$this->view->markup = $markup;
			$images = new Application_Model_ProductsImg();
			$img = $images->getProductImg($id);
			$this->view->img = $img;
		}else{
			$this->_helper->redirector('index');
		}
		
    }
	
	public function searchAction()
    {
		$this->view->title = "Результат поиска";
        $this->view->headTitle($this->view->title);
		if($this->_getParam('val')){
			$val = $this->_getParam('val');
			$search = new Application_Model_Search();
			$search = $search->searchProduct($val);
			$this->view->search = $search;
		}else{
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

    


}











