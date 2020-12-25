<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quản lý Widget</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>">Home</a>
			</li>
			<li class="active"><strong>Quản lý Widget</strong></li>
		</ol>
	</div>
</div>
<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			
			<div class="col-lg-8">
				<div class="ibox m0">
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tiêu đề <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', set_value('title', (isset($widget['title'])) ? $widget['title'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Từ khóa <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('keyword', set_value('keyword', (isset($widget['keyword'])) ? $widget['keyword'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('original_keyword', set_value('keyword', (isset($widget['keyword'])) ? $widget['keyword'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							
						</div>
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Chọn nhóm Widget<b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_dropdown('catalogueid', $catalogueList, set_value('catalogueid', (isset($widget['catalogueid'])) ? $widget['catalogueid'] : ''), 'class="form-control m-b select2"');?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row form-html">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											Nhập các thẻ html
										</label>
									</div>
									<?php echo form_textarea('html', htmlspecialchars_decode(html_entity_decode(set_value('html', (isset($widget['html'])) ? $widget['html'] : ''))), 'class="va_code_theme"  placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row form-html">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											Nhập CSS
										</label>
									</div>
									<?php echo form_textarea('css', htmlspecialchars_decode(html_entity_decode(set_value('css', (isset($widget['css'])) ? $widget['css'] : ''))), 'class="va_code_theme"  placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row form-html">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											Nhập Javascript
										</label>
									</div>
									<?php echo form_textarea('script', htmlspecialchars_decode(html_entity_decode(set_value('script', (isset($widget['script'])) ? $widget['script'] : '')),ENT_QUOTES), 'class="va_code_theme"  placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						
						<div class="toolbox action clearfix">
							<div class="uk-flex uk-flex-middle uk-button pull-right">
								<button class="btn btn-primary btn-sm" name="" value="" type="submit">Lưu lại</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="ibox mb20">
					<div class="ibox-title uk-flex-space-between uk-flex uk-flex-middle">
						<h5 class="choose-image" style="cursor: pointer;margin:0;">Ảnh demo</h5>
						<a href="" title="" data-target="image" class="uploadImage">Upload hình ảnh</a>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="avatar" style="cursor: pointer;"><img src="<?php echo (isset($_POST['image'])) ? $_POST['image'] : ((isset($widget['image']) && $widget['image'] != '') ? $widget['image'] : 'public/not-found.png') ?>" class="img-thumbnail" alt=""></div>
									<?php echo form_input('image', htmlspecialchars_decode(html_entity_decode(set_value('image', (isset($widget['image'])) ? $widget['image'] : ''))), 'class="form-control " placeholder="Đường dẫn của ảnh"  id="imageTxt"  autocomplete="off" style="display:none;" ');?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ibox mb20">
					<div class="ibox-title">
						<h5>Hiển thị </h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="text-warning mb15">Quản lý thiết lập hiển thị cho blog này.</div>
									<div class="block clearfix">
										<div class="i-checks mr30" style="width:100%;">
											<span style="color:#000;" class="uk-flex uk-flex-middle"> 
												<?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($widget['publish']) && $widget['publish'] == 1)) ? true : (!isset($_POST['publish'])) ? true : false),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
												<label for="publish" style="margin:0;cursor:pointer;">Cho phép hiển thị trên website</label>
											</span>
										</div>
									</div>
									<div class="block clearfix">
										<div class="i-checks" style="width:100%;">
											<span style="color:#000;" class="uk-flex uk-flex-middle"> 
												<?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($widget['publish']) && $widget['publish'] == 0)) ? true : ((!isset($_POST['publish']) && !isset($widget['publish'])) ? true : false)),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>
												
												<label for="no-publish" style="margin:0;cursor:pointer;">Không Cho phép hiển thị trên website</label>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>


