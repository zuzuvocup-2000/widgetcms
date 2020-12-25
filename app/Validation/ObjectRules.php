<?php 
namespace App\Validation;
use App\Models\AutoloadModel;
use CodeIgniter\HTTP\RequestInterface;

class ObjectRules {

	protected $AutoloadModel;
	protected $helper = ['mystring'];
	protected $request;

	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
		$this->request = \Config\Services::request();
		helper($this->helper);

	}

	public function check_canonical(string $canonical = '', string $module = ''): bool{
		$originalCanonical = $this->request->getPost('original_canonical');
		$modulExtract = explode('_', $module);
		$count = 0;
		if($originalCanonical != $canonical){
			$count = $this->AutoloadModel->_get_where([
				'select' => 'objectid',
				'table' => $modulExtract[0].'_translate',
				'where' => ['canonical' => $canonical],
				'count' => TRUE
			]);
		}

		
		if($count > 0){
			return false;
		}
		return true;
 	}

 	public function check_id(string $productid = '', string $module = ''): bool{
		$originalId = $this->request->getPost('original_productid');
		$modulExtract = explode('_', $module);
		$count = 0;
		if($originalId != $productid){
			$count = $this->AutoloadModel->_get_where([
				'select' => 'objectid',
				'table' => $modulExtract[0].'_translate',
				'where' => ['productid' => $productid],
				'count' => TRUE
			]);
		}
		if($count > 0){
			return false;
		}
		return true;
 	}

 	
 	public function check_keyword(string $keyword = '', $module = ''): bool{
		$originalId = $this->request->getPost('original_keyword');
		$count = 0;
		if($originalId != $keyword){
			$count = $this->AutoloadModel->_get_where([
				'select' => 'id',
				'table' => $module ,
				'where' => ['keyword' => $keyword],
				'count' => TRUE
			]);
		}
		if($count > 0){
			return false;
		}
		return true;
 	}


}

