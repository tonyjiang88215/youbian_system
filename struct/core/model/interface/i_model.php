<?php
Interface i_model
{
	public function select($colums,$where,$limit,$order);
	public function insert($recordeArray);
	public function delete($where);
	public function update($recorderArray);
	public function verify($recorderArray);
}
?>