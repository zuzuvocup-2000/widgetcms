<?php 
namespace App\Controllers\Backend\Widget;
use App\Controllers\BaseController;

class Widget extends BaseController{
	protected $data;
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'website_widget';
	}


	

	public function index(){
		$session = session();
		
		$this->data['widgetList'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.keyword, tb1.html,tb1.css,tb1.script,tb1.id,tb1.title,tb1.publish,tb1.catalogueid,tb1.image, tb2.title as nameCatalogue',
			'table' => 'website_widget as tb1',
			'join' => [
				[
					'widget_catalogue as tb2', 'tb1.catalogueid = tb2.id','inner'
				]
			],
			'order_by' => 'tb1.catalogueid asc'
		], TRUE);
		$temp = [];
		if(isset($this->data['system'])){
			foreach($this->data['system'] as $key => $val){
				$temp[$val['keyword']] = $val['content'];
			}
		}

		$this->data['temp'] = $temp;

		if($this->request->getMethod() == 'post'){
			$config  = $this->request->getPost('config');
			if(isset($config) && is_array($config) && count($config)){
				$delete = $this->AutoloadModel->_delete([
					'table' => 'system_translate',
					'where' => ['language' => $this->currentLanguage()]
				]);
				$_update = [];
				foreach($config as $key => $val){
					$_update[] = [
						'language' => $this->currentLanguage(),
						'keyword' => $key,
						'content' => $val,
						'userid_updated' => $this->auth['id'],
						'updated_at' => $this->currentTime
					];
					
				}
				$flag =	$this->AutoloadModel->_create_batch([
					'table' => 'system_translate',
					'data' => $_update,
				]);
			}
	 		if($flag > 0){

	 			$session->setFlashdata('message-success', 'Cập Nhật Cấu hình chung Thành Công!');
				return redirect()->to(BASE_URL.'backend/widget/widget/index');
	 		}

	        
		}
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['template'] = 'backend/widget/widget/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$this->data['catalogueList'] = $this->get_catalogue();
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if($this->validate($validate['validate'], $validate['errorValidate'])){
				$insert = $this->store(['method' => 'create']);
				$resultid = $this->AutoloadModel->_insert([
		 			'table' => $this->data['module'],
		 			'data' => $insert,
		 		]);
		 		if($resultid > 0){
		 			$session->setFlashdata('message-success', 'Tạo Widget Thành Công! Hãy tạo Widget tiếp theo.');
 					return redirect()->to(BASE_URL.'backend/widget/widget/index');
		 		}
			}else{
				$this->data['validate'] = $this->validator->listErrors();
			}
		}
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['template'] = 'backend/widget/widget/create';
		return view('backend/dashboard/layout/home', $this->data);
	}


	public function update($id = 0){
		$session = session();
		$this->data['catalogueList'] = $this->get_catalogue();

		$this->data['widget'] = $this->AutoloadModel->_get_where([
			'select' => 'keyword, html,css,script,id,title,publish,catalogueid,image',
			'table' => 'website_widget',
			'where' => [
				'id' => $id
			]
		]);
		$this->data['widget']['html'] = base64_decode($this->data['widget']['html']);
		$this->data['widget']['css'] = base64_decode($this->data['widget']['css']);
		$this->data['widget']['script'] = base64_decode($this->data['widget']['script']);
		// pre($this->data['widget']);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if($this->validate($validate['validate'], $validate['errorValidate'])){
				$update = $this->store(['method' => 'update']);
				$resultid = $this->AutoloadModel->_update([
		 			'table' => $this->data['module'],
		 			'data' => $update,
		 			'where' => [
		 				'id' => $id
		 			]
		 		]);
		 		if($resultid > 0){
		 			$session->setFlashdata('message-success', 'Tạo Widget Thành Công! Hãy tạo Widget tiếp theo.');
 					return redirect()->to(BASE_URL.'backend/widget/widget/index');
		 		}
			}else{
				$this->data['validate'] = $this->validator->listErrors();
			}
		}
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['template'] = 'backend/widget/widget/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function store($param = []){

		helper(['text']);
		$store = [
			'title' => validate_input($this->request->getPost('title')),
			'keyword' => slug($this->request->getPost('keyword')),
			'publish' => $this->request->getPost('publish'),
			'catalogueid' => $this->request->getPost('catalogueid'),
			'html' => base64_encode(validate_input($this->request->getPost('html'))),
			'image' => validate_input($this->request->getPost('image')),
			'css' => base64_encode(validate_input($this->request->getPost('css'))),
			'script' => base64_encode(validate_input($this->request->getPost('script'))),
		];
		if($param['method'] == 'create' && isset($param['method'])){	
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 			
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
		return $store;
	}

	function get_catalogue(){
		$data = $this->AutoloadModel->_get_where([
			'select' => 'id, title, keyword',
			'table' => 'widget_catalogue',
			'where' => [
				'publish' => 1
			],
			'order_by' => 'title asc'
		],TRUE);
		$new = [
			0 => '-- Chọn nhóm Widget --'
		];
		foreach ($data as $key => $value) {
			$new[$value['id']] = $value['title'];
		}
		return $new;
	}

	private function validation(){
		$validate = [
			'title' => 'required',
			'keyword' => 'required|check_keyword['.$this->data['module'].']',
			'catalogueid' => 'is_natural_no_zero'
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập tiêu đề Widget!'
			],
			'keyword' => [
				'required' => 'Bạn phải nhập từ khóa Widget!',
				'check_keyword' => 'Từ khóa Widget đã tồn tại, vui lòng chọn từ khóa khác!',
			],
			'catalogueid' => [
				'is_natural_no_zero' => 'Bạn phải chọn nhóm Widget!',
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
