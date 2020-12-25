<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Website_control extends BaseController{
	
	public function __construct(){
	}
	public function add_website(){
		$title = $this->request->getPost('add_title');
		$router = $this->request->getPost('add_router');
		$id = $this->request->getPost('id');
		$id = $this->request->getPost('id');
		$flag = $this->AutoloadModel->_update([
			'table' => 'user',
			'data' => ['deleted_at' => 1],
			'where_in' => $id,
			'where_in_field' => 'id',
		]);
		echo $flag;die();
	}
	public function update_by_field(){
		$post['id'] = $this->request->getPost('id');
		$post['module'] = $this->request->getPost('module');
		$post['value'] = $this->request->getPost('value');
		$post['field'] = $this->request->getPost('field');
		
		$flag = $this->AutoloadModel->_update([
			'table' => $post['module'],
			'data' => [$post['field'] => $post['value']]
		]);

	}
}
