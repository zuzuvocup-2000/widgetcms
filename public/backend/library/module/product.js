var count = 0;



$(document).on('click','.add-attr',function(){
	let _this = $(this);
	count++;
	render_attr();
})

$(document).on('click','.ibox-title.ui-sortable-handle',function(){
	console.log(1)
})

$(document).on('click','.delete-all', function(){
	let id = [];
	let _this = $(this);
	$('.checkbox-item:checked').each(function(){
		let _this = $(this);
	 	id.push(_this.val());
	});

	if(id.length > 0){
		swal({
			title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
			text: 'Xóa các Sản phẩm được chọn',
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Thực hiện!",
			cancelButtonText: "Hủy bỏ!",
			closeOnConfirm: false,
			closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				var formURL = 'ajax/product/delete_all';
				$.post(formURL, {
					id: id, module: _this.attr('data-module')},
					function(data){
						if(data == 0){
								sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
							}else{
								for(let i = 0; i < id.length; i++){
									$('#post-'+id[i]).hide().remove()				
								}
								swal("Xóa thành công!", "Các bản ghi đã được xóa khỏi danh sách.", "success");
							}
					});
			} else {
				swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
			}
		});
	}
	else{
		sweet_error_alert('Thông báo từ hệ thống!', 'Bạn phải chọn 1 bản ghi để thực hiện chức năng này');
		return false;
	}
	return false;
});


$(document).ready(function(){
	WinMove();
});


$(document).on('click','.delete-attr',function(){
	let _this = $(this);
	_this.parents('.desc-more').remove();
	
});

$(document).on('change','#toogle_readonly',function(){
	let _this = $(this);
	let attr = $('.productid').attr('name');
	if(_this.is(':checked') && typeof attr !== typeof undefined && attr !== false){
		$('.productid').removeAttr('readonly');
	}else{
		$('.productid').attr('readonly', true);
	}
});

$(document).on('change','#id_auto',function(){
	let _this = $(this);
	let title = $('#title').val();
	let result = title.split(' ');	
	let count = result.length;
	let text = '';
	let i = 0;
	for(i = 0; i < count; i++){
		let char = result[i].charAt(0);
		text = text + char;
	}
	text = text+'-001';
	if($('#id_auto').is(':checked')){
		$('.productid').val(text)
	}else{
		$('.productid').val(productid)
	}
});

$(document).on('keyup','#title',function(){
	let _this = $(this);
	let val = _this.val();
	let result = val.split(' ');	
	let count = result.length;
	let text = '';
	let i = 0;
	for(i = 0; i < count; i++){
		let char = result[i].charAt(0);
		text = text + char;
	}
	text = text+'-001';

	if($('#id_auto').is(':checked')){
		$('.productid').val(text)
	}else{
		$('.productid').val(productid)
	}
});

$(document).on('keyup','#brand_title',function(){
	let _this = $(this);
	let val = _this.val();
	val = slug(val)
	$('#brand_canonical').val(val);
});

$('#insert_form').on("submit", function(event) {
    event.preventDefault();
    let title = $('#brand_title').val();
    let canonical = $('#brand_canonical').val();
    let keyword = $('#keyword').val();
    let img = $('#brand_img').val();
    if (title == "") {
        alert("Vui lòng nhập vào trường Tiêu đề Thương hiệu!");
    } else if (keyword == '') {
        alert("Vui lòng nhập vào trường Giá trị Nhãn hiệu!");
    } else {
        let form_URL = 'ajax/product/add_brand';
    	$.post(form_URL, {
			title : title, canonical: canonical, keyword: keyword, img: img
		},
		function(data){
			let json = JSON.parse(data);
			$('#insert_form')[0].reset();
            $('#product_add_brand .brand-avatar img').attr('src', 'public/not-found.png');
            $('#product_add_brand').modal('hide');
            $('.brand_select').append('<option value=' + json.value + '>' + json.title + '</option>')
		});	
    }
});



$(document).on('click' ,'.update_price' ,function(){
	let _this = $(this);
	_this.find('.view_price').hide();
	_this.find('input').show();
})

$(document).on('change' ,'.index_update_price' ,function(){
	let _this = $(this);
	let val = _this.val();
	let id = _this.attr('data-id')
	let field = _this.attr('data-field')
	let form_URL = 'ajax/product/update_price';
	$.post(form_URL, {
		val : val, id: id, field: field
	},
	function(data){
		
	});	
})


function render_attr(){
	let html ='';
	var id = 'title_' + count;

	html = html + '<div class="ibox desc-more" style="opacity: 1;">';
        html = html + '<div class="ibox-title ui-sortable-handle">';
        	html = html + '<div class="uk-flex uk-flex-middle">';
                html = html + '<div class="col-lg-8">';
					html = html + '<input type="text" name="sub_content[title][]" class="form-control" value="" placeholder="Tiêu đề">';
				html = html + '</div>';
				html = html + '<div class="col-lg-4">';
					html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">';
						html = html + '<a href="" title="" data-target="'+id+'" class="uploadMultiImage">Upload hình ảnh</a>';
		                html = html + '<div class="ibox-tools">';
		                    html = html + '<a class="collapse-link ui-sortable">';
		                        html = html + '<i class="fa fa-chevron-up"></i>';
		                    html = html + '</a>';
		                    html = html + '<a class="close-link">';
		                        html = html + '<i class="fa fa-times"></i>';
		                    html = html + '</a>';
		                html = html + '</div>';
					html = html + '</div>';
				html = html + '</div>';
        		
        	html = html + '</div>';
        html = html + '</div>';
        html = html + '<div class="ibox-content" style="">';
        	html = html + '<div class="row">';
                html = html + '<div class="col-lg-12" >';
                	html = html + '<textarea name="sub_content[description][]" class="form-control ck-editor" id="'+id+'" placeholder="Mô tả"></textarea>';
				html = html + '</div>';
			html = html + '</div>	';
        html = html + '</div>';
    html = html + '</div>';

	$('.attr-more').prepend(html);
	ckeditor5(id);
}

// Dragable panels
function WinMove() {
    var element = ".attr-more";
    var handle = ".ibox-title";
    var connect = ".attr-more";
    $(element).sortable({
        handle: handle,
        connectWith: connect,
        tolerance: 'pointer',
        forcePlaceholderSize: true,
        opacity: 0.8
    })
    .disableSelection();
}