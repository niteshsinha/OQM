<?php
class Collection {

	private $_members=array();
	
	public function addItem($obj,$key=null){
		if($key){
		// Throw exception if the key is already in use
		if(isset($this->_members[$key])){
			throw new Exception ("Key {$key} already in use.")
			} else {
				$this->_members[$key]=$obj;
				}
		}else {
			$this->_members=$obj;
		}
	}
	public function removeItem($key){
	
	}
	public function getItem($key){
	
	}
	public function length(){
	
	}
?>