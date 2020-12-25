<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-4">
					<h2 class="panel-title">Thêm mới nhóm giao diện để dễ dàng quản lý và tìm kiếm widget</h2>
			</div>
			<div class="col-lg-8">
				<div class="ibox m0">
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tiêu đề Nhóm <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', set_value('title', (isset($widget_catalogue['title'])) ? $widget_catalogue['title'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Từ khóa Nhóm <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('keyword', set_value('keyword', (isset($widget_catalogue['keyword'])) ? $widget_catalogue['keyword'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('original_keyword', set_value('keyword', (isset($widget_catalogue['keyword'])) ? $widget_catalogue['keyword'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="toolbox action clearfix">
							<div class="uk-flex uk-flex-middle uk-button pull-right">
								<button class="btn btn-primary btn-sm" name="create" value="delete" type="submit">Lưu Lại</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</form>