<?php 
namespace App\Controllers\Api\Widget;
use CodeIgniter\RESTful\ResourceController;
use App\Models\AutoloadModel;

class Widget extends ResourceController{
	
	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
	}

	public function list(){
		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			$widget = $this->AutoloadModel->_get_where([
				'select' => 'keyword, html, css, script, id, title,image, catalogueid',
				'table' => 'website_widget',
			], TRUE);

			if(isset($widget) && is_array($widget) && count($widget)){
				$response['data'] = $widget;
				$response['message'] = 'Truy xuất dữ liệu thành công!';
				$response['code'] = '10';
			}else{
				$response['message'] = 'Không có dữ liệu phù hợp!';
				$response['code'] = '11';
			}
			return $this->respond($response);
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function widget_catalogue_list(){
		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			$widget_catalogue = $this->AutoloadModel->_get_where([
				'select' => 'keyword, id, title',
				'table' => 'widget_catalogue',
				'where' => [
					'deleted_at' => 0
				]
			], TRUE);

			if(isset($widget_catalogue) && is_array($widget_catalogue) && count($widget_catalogue)){
				$response['data'] = $widget_catalogue;
				$response['message'] = 'Truy xuất dữ liệu thành công!';
				$response['code'] = '10';
			}else{
				$response['message'] = 'Không có dữ liệu phù hợp!';
				$response['code'] = '11';
			}
			return $this->respond($response);
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}
}
