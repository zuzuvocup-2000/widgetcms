<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Dashboard extends BaseController{
	public function __construct(){
		
	}

	public function delete_all(){
		$id = $this->request->getPost('id');
		$module = $this->request->getPost('module');
		$flag = $this->AutoloadModel->_update([
			'table' => $module,
			'data' => ['deleted_at' => 1],
			'where_in' => $id,
			'where_in_field' => 'id',
		]);
		echo $flag;die();
	}

	public function pre_select2(){
		$param['value'] = json_decode($this->request->getPost('value'));
		$param['module'] = $this->request->getPost('module');
		$param['select'] = $this->request->getPost('select');
		$param['join'] = $this->request->getPost('join');
		$object = [];
		if($param['value'] != ''){
			$object = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb2.'.$param['select'].'',
				'table' => $param['module'].' as tb1',
				'join' => [
						[
							$param['join'].' as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\'  AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
						],
					],
				'where_in' => $param['value'],
				'where_in_field' => 'tb2.objectid',
				'order_by' => ''.$param['select'].' asc'
			], TRUE);
		}
		$temp = [];
		if(isset($object) && is_array($object) && count($object)){
			foreach($object as $index => $val){
				$temp[] = array(
					'id'=> $val['id'],
					'text' => $val[$param['select']],
				);
			}
		}
		echo json_encode(array('items' => $temp));die();

	}

	public function get_select2(){
		$param['module'] = $this->request->getPost('module');
		$param['keyword'] = $this->request->getPost('locationVal');
		$param['select'] = $this->request->getPost('select');
		$param['join'] = $this->request->getPost('join');
		if (isset($param['join']) && $param['join'] != '')
			{
				$object = $this->AutoloadModel->_get_where([
					'select' => 'tb1.id, tb2.'.$param['select'].'',
					'table' => $param['module'].' as tb1',
					'join' => [
							[
								$param['join'].' as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\'  AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
							],
						],
					'keyword' => '('.$param['select'].' LIKE \'%'.$param['keyword'].'%\')',
					'order_by' => ''.$param['select'].' asc'
				], TRUE);
			}else{
				$object = $this->AutoloadModel->_get_where([
					'select' => 'id, '.$param['select'],
					'table' => $param['module'],
					'keyword' => '('.$param['select'].' LIKE \'%'.$param['keyword'].'%\')',
					'order_by' => ''.$param['select'].' asc'
				], TRUE);
			}
		

		$temp = [];
		if(isset($object) && is_array($object) && count($object)){
			foreach($object as $index => $val){
				$temp[] = array(
					'id'=> $val['id'],
					'text' => $val[$param['select']],
				);
			}
		}

		echo json_encode(array('items' => $temp));die();

	}

	public function update_by_field(){
		$post['id'] = $this->request->getPost('id');
		$post['module'] = $this->request->getPost('module');
		$post['value'] = $this->request->getPost('value');
		$post['field'] = $this->request->getPost('field');


		$flag = $this->AutoloadModel->_update([
			'table' => $post['module'],
			'data' => [$post['field'] => $post['value']],
			'where_in' => $post['id'],
			'where_in_field' => 'id',
		]);
		echo $flag;

	}

	public function update_canonical(){
		$post['id'] = $this->request->getPost('id');
		$post['module'] = $this->request->getPost('module');
		$module = explode('_', $post['module']);

		$data = $this->AutoloadModel->_get_where([
			'select' => 'title',
			'table' => $module[0].'_translate',
			'where' => [
				'objectid' => $post['id'],
				'module' => $module[0].'_catalogue',
				'language' => $this->currentLanguage()
			]
		]);
		$data = '/'.slug($data['title']).'/';
		echo($data); die();

	}


	public function update_field(){
		$post['id'] = $this->request->getPost('id');
		$post['module'] = $this->request->getPost('module');
		$post['field'] = $this->request->getPost('field');
		$module = explode('_', $post['module']);
		$object = $this->AutoloadModel->_get_where([
			'select' => 'id, '.$post['field'],
			'table' => $post['module'],
			'where' => ['id' => $post['id']],
		]);
		if(!isset($object) || is_array($object) == false || count($object) == 0){
			echo 0;
			die();
		}
		if(isset($module) && count($module) == 2){
			$flag = $this->AutoloadModel->_update([
				'data' => ['publish' => (($object[$post['field']] == 1)?0:1)],
				'table' => current($module),
				'where' => ['catalogueid' => $post['id']],
			]);
		}
		$_update[$post['field']] = (($object[$post['field']] == 1)?0:1);
		$flag = $this->AutoloadModel->_update([
			'data' => $_update,
			'table' => $post['module'],
			'where' => ['id' => $post['id']]
		]);
		echo json_encode([
			'flag' => $flag,
			'value' => $_update[$post['field']],
		]);
		die();
	}

	public function update_widget(){
		$post['id'] = $this->request->getPost('id');
		$post['module'] = $this->request->getPost('module');
		$post['field'] = $this->request->getPost('field');
		$module = explode('_', $post['module']);
		$object = $this->AutoloadModel->_get_where([
			'select' => 'id, '.$post['field'],
			'table' => $post['module'],
			'where' => ['id' => $post['id']],
		]);
		if(!isset($object) || is_array($object) == false || count($object) == 0){
			echo 0;
			die();
		}
		if(isset($module) && count($module) == 2){
			$flag = $this->AutoloadModel->_update([
				'data' => ['publish' => (($object[$post['field']] == 1)?0:1)],
				'table' =>$post['module'],
				'where' => ['id' => $post['id']],
			]);
		}
		$_update[$post['field']] = (($object[$post['field']] == 1)?0:1);
		$flag = $this->AutoloadModel->_update([
			'data' => $_update,
			'table' => $post['module'],
			'where' => ['id' => $post['id']]
		]);
		echo json_encode([
			'flag' => $flag,
			'value' => $_update[$post['field']],
		]);
		die();
	}

	public function get_location(){
		$post = $this->request->getPost('param');

		$object = $this->AutoloadModel->_get_where([
			'select' => $post['select'],
			'table' => $post['table'],
			'where' => $post['where'],
			'order_by' => 'name asc'
		], TRUE);


		$html = '<option value="0">'.$post['text'].'</option>';
		if(isset($object) && is_array($object) && count($object)){
			foreach($object as $key => $val){
				$html = $html . '<option value="'.$val['id'].'">'.$val['name'].'</option>';
			}
		}
		echo json_encode([
			'html' => $html
		]); die();
	}
}
