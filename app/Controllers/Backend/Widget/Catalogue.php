<?php 
namespace App\Controllers\Backend\Widget;
use App\Controllers\BaseController;

class Catalogue extends BaseController{
	protected $data;
	
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'widget_catalogue';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/widget/catalogue/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/widget/widget/index');
		}


		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$keyword = $this->condition_keyword();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => $this->data['module'],
			'keyword' => $keyword,
			'where' =>[
				'deleted_at' => 0
			],
			'count' => TRUE
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/widget/catalogue/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();


			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['widgetCatalogueList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.title, tb1.keyword,tb1.created_at, tb1.userid_created, tb2.fullname',
				'table' => $this->data['module'].' as tb1',
				'where' =>[
					'tb1.deleted_at' => 0
				],
				'join' => [
					[
						'user as tb2', 'tb1.userid_created = tb2.id','inner'
					]
				],
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
			], TRUE);
			// prE($this->data['widgetCatalogueList']);	

		}

		$this->data['template'] = 'backend/widget/catalogue/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/widget/catalogue/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/widget/widget/index');
		}
		if($this->request->getMethod() == 'post'){
			$validate = [
				'title' => 'required',
				'keyword' => 'required|check_keyword['.$this->data['module'].']',
			];
			$errorValidate = [
				'title' => [
					'required' => 'Bạn bắt buộc phải nhập vào ô Tiêu đề nhóm Widget!',
				],
				'keyword' => [
					'required' => 'Bạn bắt buộc phải nhập vào ô Từ khóa nhóm Widget!',
					'check_keyword' => 'Từ khóa bạn nhập đã tồn tại, xin vui lòng chọn từ khóa khác!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
		 		$insert = $this->store(['method' => 'create']);
		 		$insertid = $this->AutoloadModel->_insert(['table' => $this->data['module'],'data' => $insert]);
		 		if($insertid > 0){
		 			$session = session();
		 			$session->setFlashdata('message-success', 'Thêm mới nhóm Widget thành công');
		 			return redirect()->to(BASE_URL.'backend/widget/catalogue/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/widget/catalogue/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/widget/catalogue/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/widget/widget/index');
		}
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title, keyword',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		// pre($this->data[$this->data['module']]);
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Nhóm Widget không tồn tại');
 			return redirect()->to(BASE_URL.'backend/widget/catalogue/index');
		}
		if($this->request->getMethod() == 'post'){
			$validate = [
				'title' => 'required',
				'keyword' => 'required|check_keyword['.$this->data['module'].']',
			];
			$errorValidate = [
				'title' => [
					'required' => 'Bạn bắt buộc phải nhập vào ô Tiêu đề nhóm Widget!',
				],
				'keyword' => [
					'required' => 'Bạn bắt buộc phải nhập vào ô Từ khóa nhóm Widget!',
					'check_keyword' => 'Từ khóa bạn nhập đã tồn tại, xin vui lòng chọn từ khóa khác!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
		 		$update = $this->store(['method' => 'update']);
		 		$flag = $this->AutoloadModel->_update(['table' => $this->data['module'],'data' => $update, 'where' => ['id' =>$id]]);
		 		if($flag > 0){
		 			$session = session();
		 			$session->setFlashdata('message-success', 'Cập nhật nhóm Widget thành công');
		 			return redirect()->to(BASE_URL.'backend/widget/catalogue/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/widget/catalogue/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/widget/catalogue/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/widget/widget/index');
		}
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Nhóm Widget không tồn tại');
 			return redirect()->to(BASE_URL.'backend/widget/catalogue/index');
		}

		if($this->request->getPost('delete')){
			$_id = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'data' => ['deleted_at' => 1],
				'where' => ['id' => $_id],
				'table' => $this->data['module']
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/widget/catalogue/index');
		}

		$this->data['template'] = 'backend/widget/catalogue/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}


	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(title LIKE \'%'.$keyword.'%\' OR keyword LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function store($param = []){
		helper(['text']);
		$store = [
 			'title' => $this->request->getPost('title'),
 			'keyword' => $this->request->getPost('keyword'),
 		];
 		if($param['method'] == 'create' && isset($param['method'])){	
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 			$store['publish'] = 1;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
 		return $store;
	}

}
