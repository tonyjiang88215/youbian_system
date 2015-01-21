<?php
/**
 * 树形导航数据模型
 * @param id  节点的类型ID号
 * @param name  节点的名称
 * @param descrption  节点描述
 * @param sons  该节点的子节点集合，以数组形式存放，对应键值关系为  ID=>TreeObject
 * @author Tony
 *
 */
class tree{
	public $typeid;
	public $name;
	public $sortid;
	public $description;
	public $parentNode = false;
	public $previousSibling = false;
	public $nextSibling = false;
	public $sons = array();
	
	
	/**
	 * 构造函数
	 * @param $id
	 * @param $name
	 * @param $description
	 * @return unknown_type
	 */
	public function __construct($id,$sortid,$name,$description,$manager=array()){
		$this->typeid = $id;
		$this->sortid = $sortid;
		$this->name = $name;
		$this->description = $description;
		$this->manager = $manager;
	}
	
	/**
	 * 析构函数
	 * @return unknown_type
	 */
	public function __destruct(){
		
	}
	
	/**
	 * 给节点添加后代节点，从根节点出发，依次寻找节点关系，最后找到父节点，添加
	 * @param $treeElement
	 * @return unknown_type
	 */
	public function add($treeElement){
//		print_r($treeElement);
//		echo "<br />";

//		if(strlen($treeElement->getId())==strlen($this->id)+1){
//			$this->sons[$treeElement->getId()] = $treeElement;
			
//			echo "<br />-----------------------------------<br />";
//		}else{
			$parentId = "";
			$parent = $this;
			for($i=0;$i<strlen($treeElement->sortid)-strlen($this->sortid)-1;$i++){
				$parentId = substr($treeElement->sortid,0,strlen($this->sortid)+$i+1);
				$parentResult = $parent->sons;
				$parent = $parentResult[$parentId];
			}
//			print_r($parent);
//			echo "<br />-----------------------------------<br />";
			$sons = &$parent->sons;
			if(count($sons)!=0){
				$lastSon = array_pop($sons);
				$lastSon->nextSibling = &$treeElement;
				$treeElement->previousSibling = &$lastSon;
				$sons[$lastSon->sortid] = $lastSon;
			}
			$treeElement->parentNode = &$parent;
			$sons[$treeElement->sortid] = $treeElement;
//		}
	}

	

	/**
	 * @param $description the $description to set
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @param $name the $name to set
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param $id the $id to set
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $sons
	 */
	public function & getSons() {
		return $this->sons;
	}

	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}
	
	public function __get($attrName){
		return $this->$attrName;
	}
	
	public function __set($attrName,$value){
		$this->$attrName = $value;
	}

}