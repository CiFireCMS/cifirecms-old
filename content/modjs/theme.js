$(function() {
	'use strict'

	$('.c_blank_theme').on('click',function(e) {
		e.preventDefault();
		$('#modal_create_blank').modal('show');
	});

	$('.modal_active').click(function(e) {
		e.preventDefault();
		var idActive = $(this).attr('idActive');
		$('#idActive').val(idActive);
		$('#modal_active').modal('show');
	});

	$(':file#fupload').change(function() {
		var file = $(this)[0].files[0];
		var fileReader = new FileReader();
		getLangJSON().done(function(lang){
			fileReader.onloadend = function (e) {
				var arr = (new Uint8Array(e.target.result)).subarray(0, 4);
				var fileHeader = '';
				for (var i = 0; i < arr.length; i++) {
					fileHeader += arr[i].toString(16);
				}
				var type = mimeFileType(fileHeader,'');
				// console.log('File header: ' + file.type);

				// 504b34 = application/x-zip-compressed
				if (fileHeader !== '504b34' || file.type == '' || file.type !== 'application/x-zip-compressed') {
					$(this).val('');
					$('#fupload').val('');
					$('.custom-file-label').html(file.name);
					$('.detail-package').show().html('<div class="text-danger tx-13">'+ lang.message['error_filetype'] +'</div>');
					$('#install-button').prop('disabled', true);
				} else {
					$('.custom-file-label').html(file.name);
					$('.detail-package').show().html('<div class="tx-gray-700 tx-13"><div> File : '+ file.name +'</div><div> Type : '+ file.type +'</div> <div> Size : '+ formatFileBytes(file.size) +'</div> </div>');
					$('#install-button').prop('disabled', false);
				}
			};
			fileReader.readAsArrayBuffer(file);
		});
	});

	$('.backup_theme').click(function(e) {
		e.preventDefault();
		var self = $(this); 
		var id = self.attr('data-theme-id');
		var folder = self.attr('data-theme-folder');
		var title = self.attr('data-theme-title');
		self.find('i').attr('class','fa fa-spin fa-spinner');
		$.ajax({
			url: window.location.href + '/backup',
			type: 'POST',
			dataType: 'JSON',
			data:{
				'id': id,
				'folder': folder,
				'title': title,
				'csrf_name': csrfToken
			},
			cache: false,
			success: function(response){
				self.find('i').attr('class','cificon licon-download');
			}
		});
	});

	$(".create_file").click(function(e) {
		e.preventDefault();
		$('#modal_create_file').modal('show');
	});

	$('.delete_theme').on('click',function(e) {
		e.preventDefault();
		var idTeme = $(this).attr("data-id");
		var folderTheme = $(this).attr("data-folder");
		var data = {
			'id': idTeme,
			'folder': folderTheme
		};
		var url = admin_url + a_mod + '/delete-theme';
		themeDelete(data, url)
	});

	function themeDelete(data,uri){
		var dataPk = data;
		var dataUrl = uri;
		getLangJSON().done(function(lang){
			swal({
				title               : '<span class="mg-t-30">'+lang.modal['delete_title']+'</span>',
				text                : lang.modal['delete_content'],

				showConfirmButton   : true,
				confirmButtonClass  : 'btn btn-lg btn-danger',
				confirmButtonText   : lang.button['delete'],

				showCancelButton    : true,
				cancelButtonClass   : 'btn btn-lg btn-secondary',
				cancelButtonText    : lang.button['cancel'],

				animation           : false,
				buttonsStyling      : false,
				showCloseButton     : false,
				showLoaderOnConfirm : true,
				allowOutsideClick   : false,

				preConfirm: function() {
					return new Promise(function(resolve, reject) {
						$.ajax({
							type: 'POST',
							url: dataUrl,
							dataType: 'json',
							data: {
								'data': dataPk,
								'csrf_name': csrfToken
							},
							cache: false,
							success:function(response) {
								if (response['success']==true) {
									$('#theme-item-'+response['dataDelete']).remove()
									resolve();                              
								} else {
									Swal({
										type     : 'error',
										title    : '<span class="mg-b-30">ERROR</span>',
										showConfirmButton : false,
										showCloseButton   : true
									});
								}
							}
						});
					});
				},
			});
		});
	}
});