$(document).ready(function(){
	function log (message) {
		document.querySelector('#time_end').value = message
	}

	window.onload = function () {
		document.querySelector('#time_start').addEventListener('datechanged', function(e) {
			// console.log(e.data.dateFrom)
			// console.log('New date', e.data, this.value)
		})

		duDatepicker('#time_start', {
			format: 'dd/mm/yyyy', range: true, clearBtn: true,
			// disabledDays: ['Sat', 'Sun'],
			events: {
				dateChanged: function (data) {
					log(data.dateTo)
				},
				onRangeFormat: function (from, to) {
					var fromFormat = 'dd/mm/yyyy', toFormat = 'dd/mm/yyyy';

					if (from.getMonth() === to.getMonth() && from.getFullYear() === to.getFullYear()) {
						fromFormat = 'dd/mm/yyyy'
					} else if (from.getFullYear() === to.getFullYear()) {
						fromFormat = 'mmmm d'
						toFormat = 'dd/mm/yyyy'
					}


					return from.getTime() === to.getTime() ?
						this.formatDate(from, 'dd/mm/yyyy') :
						this.formatDate(from, fromFormat);
				}
			}
		})

	}

	$('#add_website').on("submit", function(event) {
        event.preventDefault();
        let add_title = $('.add_title').val();
        let add_router = $('.add_router').val();
        let time_start = $('.time_start').val();
        let time_end = $('.time_end').val();
        if (add_title == "") {
            alert("Vui lòng nhập vào trường Tiêu đề Website!");
        } else if (add_router == '') {
            alert("Vui lòng nhập vào trường Đường dẫn Website!");
        }else if (time_start == '') {
            alert("Vui lòng chọn ngày tạo Website!");
        }else {
            let form_URL = 'ajax/website_control/add_website';
        	$.post(form_URL, {
				add_title : add_title, add_router: add_router, time_start: time_start, time_end: time_end
			},
			function(data){
				$('#insert_form')[0].reset();
                $('#add_data_Modal').modal('hide');
                $('#add_data_Modal').find('.va-wrapper').remove();
                location.reload();
			});	
        }
    });
});
