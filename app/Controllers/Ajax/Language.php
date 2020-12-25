<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Language extends BaseController{
	
	public function __construct(){
	}


	public function update_default_language(){
		$post['id'] = $this->request->getPost('id');
		$post['field'] = $this->request->getPost('field');

		$language = $this->AutoloadModel->_get_where([
			'select' => 'id, title, default',
			'table' => 'language',
			'where' => ['id' => $post['id']]
		]);


		$_update[$post['field']] = (($language[$post['field']] == 1)?0:1);

		if($_update[$post['field']] == 1){
			$flag_1 = $this->AutoloadModel->_update([
				'data' => ['default' => 0],
				'table' => 'language'
			]);
		}


		$flag = $this->AutoloadModel->_update([
			'table' => 'language',
			'data' => $_update,
			'where' => [
				'id' => $post['id']
			],
		]);

		echo json_encode([
			'flag' => $flag,
			'id' => $post['id'],
			'value' => $_update[$post['field']],
		]);

	}

}
