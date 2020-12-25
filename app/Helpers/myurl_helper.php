<?php 

if(!function_exists('rewrite_url')){
	function rewrite_url($param = '', $style = '', $module = '', $prefix = '' , $suffix = ''){
		$data = [];
		switch ($style) {
			case 'normal':
				foreach ($param as $key => $value) {
					$checkLink = explode('.', $value['canonical']);
					$checkid = explode('-data-id=' , $checkLink[0]);
					$link = removeutf8($value['canonical']);
					if(isset($checkid)){
						$link = slug($link);
						$link = $checkid[0].'-data-id='.$value['id'].''.$suffix;
					}else{
						if(!isset($checkLink[1])){
							$link = slug($link);
							$link = $link.'-'.$prefix.'-data-id='.$value['id'].''.$suffix;
						}
					}
					$data[] = $link;
				}
				break;
		}

		return $data;
	}
}

?>

