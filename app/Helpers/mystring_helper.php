<?php 



if(!function_exists('translate')){
	function translate(string $string = '', string $language = '', array $param = []){

		if(in_array($language, ['vi','en']) == false){
			$language = 'en';
		}

		return lang($string, $param, $language);
	}
}

if(!function_exists('view_cells')){
	function view_cells(string $module = ''){
		$module = explode('_',  $module);
		$new_module = [];
		foreach ($module as $key => $value) {
			$new_module[] = ucwords($value);
		}
		$view =  '\App\Controllers\Backend\\';
		foreach ($new_module as $key => $value) {
			$view = $view.$value.((isset($new_module[$key + 1])) ? '\\' : '').((!isset($new_module[$key + 1])) ? '::index' : '');
		}

		return $view;
	}
}

if(!function_exists('get_first_img')){
	function get_first_img(string $album = ''){
		$image = json_decode($album);
		$image = $image[0];
		return $image;
	}
}


if(!function_exists('gettime')){
	function gettime($time, $type = 'H:i - d/m/Y'){
		if($type == 'datetime'){
			$type = 'Y-m-d H:i:s';
		}
		if($type == 'date'){
			$type = 'Y-m-d';
		}
		return gmdate($type, strtotime($time) + 7*3600);
	}
}

if(!function_exists('getthumb')){
	function getthumb(string $string = '', bool $thumb = true){
		$image = '';
		
		if(!file_exists(dirname(dirname(dirname(__FILE__))).$image) ){
			$image = 'public/not-found.png';
		}
		if($thumb == TRUE){
			$thumbUrl = str_replace('/upload/image', '/upload/thumb/Images', $string);
			if (file_exists(dirname(dirname(dirname(__FILE__))).$thumbUrl)){
				return $thumbUrl;
			}
		}
		return $string;
	}
}




if (! function_exists('validate_input')){
	function validate_input(string $string): string{
		return htmlspecialchars_decode(html_entity_decode($string));
	}
}


if (! function_exists('password_encode')){
	function password_encode(string $password, string $salt): string{
		return md5(md5($salt.$password));
	}
}


if (! function_exists('pre')){
	function pre($param, $flag = true){
		echo '<pre>';
		print_r($param);
		if($flag == true){
			die();
		}
		
	}
}


if (! function_exists('convertArray')){
	function convert_array($param){
		$array[0] = '[Chọn '.$param['text'].']';
		if(isset($param['data']) && is_array($param['data']) && count($param['data'])){
			foreach($param['data'] as $key => $val){
				$array[$val[$param['field']]] = $val[$param['value']];
			}
		}
		
		return $array;
	}
}



// tạo thông báo
if(!function_exists('show_flashdata')){
	function show_flashdata($body = TRUE){;
		$result = [];
		$session = session();
		$message = $session->getFlashdata('message-success');
		$result['message'] = $message;
		if(isset($message)){
			$result['flag'] = 0;
			return $result;
		}
		$message = $session->getFlashdata('message-danger');
		$result['message'] = $message;
		if(isset($message)){
			$result['flag'] = 1;
		}
		
		
		return $result;
	}
}


if(!function_exists('removeutf8')){
	function removeutf8($value = NULL){
		$chars = array(
			'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
			'e' =>	array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
			'i'	=>	array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
			'o'	=>	array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
			'u'	=>	array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
			'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
			'd'	=>	array('đ','Đ'),
		);
		foreach ($chars as $key => $arr)
			foreach ($arr as $val)
				$value = str_replace($val, $key, $value);
		return $value;
	}
}

if(!function_exists('slug')){
	function slug($value = NULL){
		$value = removeutf8($value);
		$value = str_replace('-', ' ', trim($value));
		$value = preg_replace('/[^a-z0-9-]+/i', ' ', $value);
		$value = trim(preg_replace('/\s\s+/', ' ', $value));
		return strtolower(str_replace(' ', '-', trim($value)));
	}
}

if(!function_exists('slug_database')){
	function slug_database($value = NULL){
		$value = removeutf8($value);
		$value = str_replace('_', ' ', trim($value));
		$value = preg_replace('/[^a-z0-9-]+/i', ' ', $value);
		$value = trim(preg_replace('/\s\s+/', ' ', $value));
		return strtolower(str_replace(' ', '_', trim($value)));
	}
}

?>

