
$(document).ready(function(){
	$(document).on('click','.td-default span.text-danger', function(){


		let _this = $(this);
		let id = _this.parents('tr').attr('data-id');
		let field = _this.parent('td').attr('data-field');
		let $module = _this.parent('td').attr('data-module');
		var formURL = 'ajax/language/update_default_language';
		var parent  = _this.parent();
		_this.html(loading());
		
		setTimeout(function(){

			

			$.post(formURL, {
				id: id,module: $module, field:field},
				function(data){
					if(data == 0){
						sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
					}else{
						let json = JSON.parse(data);
						$('.td-default ').not(_this).html('<span class="text-danger">No</span>');
						parent.html('<span class="text-navy">Yes</span>');
						location.reload();

					}
				});
		}, 500);


		return false;
	});
});
