<?php 
use App\Models\AutoloadModel;

if (! function_exists('get_data')){
	function get_data(array $param = []){
		$model = new AutoloadModel();

		$where = [];
		if(isset($param['where'])){
			$where = $param['where'];
		}
	 	$object = $model->_get_where([
            'select' => $param['select'],
            'table' => $param['table'],
            'where' => $where,
            'order_by' => $param['order_by']
        ], TRUE);
	 	return $object;
	}
}

if (! function_exists('check_type_canonical')){
	function check_type_canonical($language = ''){
		$model = new AutoloadModel();

	 	$object = $model->_get_where([
            'select' => 'content',
            'table' => 'system_translate',
            'where' => [
            	'language' => $language,
            	'keyword' => 'website_canonical'
            ],
        ]);
	 	return $object;
	}
}

if (! function_exists('separateArray')){
	function separateArray($param= [], $target=[]){
		$data=[];
		for ($i = 0; $i < count($param);$i++){
			if (isset($param[$i]))
				for ($j = 0; $j < count($target);$j++){
					$data[$i][$target[$j]] = $param[$i][$target[$j]]; 
				}
			}
		return $data;
	} 
}
if(!function_exists('get_id_create_batch')){
	function get_id_create_batch(int $firstid = 0, int $length = 0){
		$data[] = $firstid;
		for($i = 1 ; $i < $length; $i++){
			$data[] = $firstid + $i;
		}

		return $data;
	}
}

if (! function_exists('count_object')){
	function count_object(array $param = []){
		$model = new AutoloadModel();

		$catalogueid = $param['catalogueid'];

		$id = [];	
		if($catalogueid > 0){
			$catalogue = $model->_get_where([
				'select' => 'id, lft, rgt, title',
				'table' => $param['module'].'',
				'where' => ['id' => $catalogueid],
			]);

			$catalogueChildren = $model->_get_where([
				'select' => 'id',
				'table' => $param['module'].'',
				'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
			], TRUE);

			$id = array_column($catalogueChildren, 'id');
		}

		$count = 0;
		$module = explode('_',  $param['module']);
		if(isset($id) && is_array($id)  && count($id)){
			$count = $model->_get_where([
				'select' => 'tb1.id',
				'table' => current($module).' as tb1',
				'where' => [
					'tb1.deleted_at' => 0,
					'tb1.publish' => 1,
				],
				'where_in' => $id,
				'where_in_field' => 'tb2.catalogueid',
				'join' => [
					[
						'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.current($module).'\' ', 'inner'
					],
					[
						'user as tb3','tb1.userid_created = tb3.id','inner'
					]
				],
				'group_by' => 'tb1.id',
				'count' => TRUE
			]);
		}
		

		return $count;
		
	}
}

if (! function_exists('convert_code')){
	function convert_code($code = '', $module =''){
		$model = new AutoloadModel();

		$code_Explode = explode('-',  $code );
		$code = (int)'1'.$code_Explode[1];
		$id = $model->_get_where([
			'select' => 'objectid',
			'table' => 'id_general',
			'where' => ['module' => $module]
		]);
		$code  = $code + $id['objectid'];
		$code = substr($code, 1);
		$code = $code_Explode[0].'-'.$code.'-'.$code_Explode[2];
		return $code;
	}
}

if (! function_exists('get_catalogue_object')){
	function get_catalogue_object(array $param = []){
		$model = new AutoloadModel();


		$object = $model->_get_where([
		  	'select' => 'tb1.id, tb4.title',
            'table' => $param['module'].'_catalogue as tb1',
            'join' => [
	            		[
							$param['module'].'_translate as tb4','tb1.id = tb4.objectid AND tb4.module = \''.$param['module'].'_catalogue'.'\'','inner'
						]
					],
            'where' => ['tb1.deleted_at' => 0],
            'where_in' => $param['catalogue'],
            'where_in_field' => 'tb1.id',
            'order_by' => 'tb4.title asc'
		], TRUE);
		return $object;
		
	}
}


if (! function_exists('get_list_language')){
	function get_list_language(array $param = []){
		$model = new AutoloadModel();

		$language = $model->_get_where([
			'select' => 'id, canonical, image',
			'table' => 'language',
			'where' => ['publish' => 1,'canonical !=' => $param['currentLanguage']]
		], TRUE);

		return $language;
	}
}
if (! function_exists('get_all_language')){
	function get_all_language(){
		$model = new AutoloadModel();

		$language = $model->_get_where([
			'select' => 'id, canonical, image',
			'table' => 'language',
			'where' => ['publish' => 1]
		], TRUE);

		return $language;
	}
}


if (! function_exists('get_full_language')){
	function get_full_language(array $param = []){
		$model = new AutoloadModel();

		$language = $model->_get_where([
			'select' => 'id, canonical, image',
			'table' => 'language',
			'where' => ['publish' => 1]
		], TRUE);

		return $language;
	}
}


if (! function_exists('check_id_exist')){
	function check_id_exist($module = ''){
		$model = new AutoloadModel();

		$count = $model->_get_where([
			'table' => 'id_general',
			'where' => ['module' => $module],
			'count' => TRUE
		], TRUE);

		return $count;
	}
}

if (! function_exists('object_menu')){
	function object_menu($module = '',$translate = 0, $language = ''){
		$model = new AutoloadModel();
		$moduleExplode = explode('_',  $module);
		if(isset($params['translate']) && $params['translate'] == 0){
			$ObjectList = $model->_get_where([
				'select' => 'title, canonical, id',
				'table' => $module,
				'order_by' => 'created_at desc',
				'limit' => 5
			],TRUE);
		}else{
			if(isset($moduleExplode[1])){
				$ObjectList = $model->_get_where([
					'select' => 'tb1.title, tb1.id, tb1.canonical, tb1.module, tb2.parentid as catalogueid, tb1.objectid as objectid',
					'table' => $moduleExplode[0].'_translate as tb1',
					'join' => [
						[
							$module.' as tb2', 'tb2.id = tb1.objectid', 'inner'
						],
					],
					'where' => [
						'tb1.module' => $module,
						'tb1.language' => $language,
					],
					'order_by' => 'tb1.created_at desc',
					'limit' => 5
				],TRUE);
			}else{
				$ObjectList = $model->_get_where([
					'select' => 'tb1.title, tb1.objectid as objectid, tb1.canonical, tb1.module, tb2.catalogueid as catalogueid',
					'table' => $moduleExplode[0].'_translate as tb1',
					'join' => [
						[
							$module.' as tb2', 'tb2.id = tb1.objectid', 'inner'
						],
					],
					'where' => [
						'tb1.module' => $module,
						'tb1.language' => $language,
					],
					'order_by' => 'tb1.created_at desc',
					'limit' => 5
				],TRUE);
			}
		}
		return $ObjectList;
	}
}


if (! function_exists('silo')){
	function silo($id = '', $canonical = '', $module = '', $catid = '', $lang = ''){
	    $model = new AutoloadModel();
		
		$moduleExplode = explode('_',  $module);
	    if($catid == 0){
	        $category = $model->_get_where([
	            'select' => 'id, lft, rgt',
	            'table' => $moduleExplode[0].'_catalogue',
	            'where' => ['parentid' => $catid, 'id' => $id]
	        ]);
	       	$allCategory = $model->_get_where([
	            'select' => 'objectid, canonical, module',
	            'table' => $moduleExplode[0].'_translate',
	            'where' => [
	            	$moduleExplode[0].'_translate.id' => $category['id'],
	            	'module' => $moduleExplode[0].'_catalogue',
	            	'language' => $lang
	            ],
	            'join' => [
	            	[
	            		$moduleExplode[0].'_catalogue', $moduleExplode[0].'_catalogue.id = '.$category['id'].'','inner'
	            	]
	            ],
	            'order_by' => $moduleExplode[0].'_catalogue.lft asc',
	        ], TRUE);
	        $url = '';
	        foreach($allCategory as $key => $val){
	            $url = $url.$val['canonical'].(($key + 1 < count($allCategory)) ? '/' : '');
	        }

	    }else{
	        $category = $model->_get_where([
	            'select' => 'id, lft, rgt, parentid',
	            'table' => $moduleExplode[0].'_catalogue',
	            'where' => ['id' => $catid]
	        ]);
	        // pre($category);
	        if($category['parentid'] != 0){
	        	$category = $model->_get_where([
		            'select' => 'id, lft, rgt, parentid',
		            'table' => $moduleExplode[0].'_catalogue',
		            'where' => ['id' => $category['parentid']]
		        ]);
	        }
			$allCategory = $model->_get_where([
	            'select' => 'tb2.objectid, tb2.canonical, tb2.module',
	            'table' => $moduleExplode[0].'_catalogue as tb1',
	            'join' => [
	            	[
	            		$moduleExplode[0].'_translate as tb2', 'tb2.objectid = tb1.id AND tb2.language = \''.$lang.'\' AND tb2.module = \''.$moduleExplode[0].'_catalogue\'','inner'
	            	]
	            ],
	            'where' => [
	                'tb1.lft >=' => $category['lft'],
	                'tb1.rgt <=' => $category['rgt'],
	            ],
	            'order_by' => 'tb1.lft asc',
	        ], TRUE);

	        $url = '';

	        foreach($allCategory as $key => $val){
	        	if($val['canonical'] == $canonical){
	        		$url = $url.$val['canonical'].(($key + 1 < count($allCategory)) ? '/' : '');
	        		$canonical = '';
	        	}else{
	            	$url = $url.$val['canonical'].'/';
	        	}
	        }

	        $url = $url.$canonical;
	    }
	        // pre($url);
	    return $url;
	}
}

?>

