
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-12">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div>
                <h2>Quản Lý Widget</h2>
                <ol class="breadcrumb" style="margin-bottom:10px;">
                    <li>
                        <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
                    </li>
                    <li class="active"><strong>Quản lý Widget</strong></li>
                </ol>
            </div>
            <div class="uk-button">
                <a href="<?php echo base_url('backend/widget/widget/create') ?>" class="btn btn-danger "><i class="fa fa-plus"></i> Thêm Widget Mới</a>
            </div>
        </div>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <form method="post" action="" class="form-horizontal box">
       <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title uk-flex uk-flex-middle">
                        <h5>Quản lý Widget </h5>
                    </div>
                    <div class="ibox-content">
                        <div class="text-danger mb10">* Vị trí trên, dưới, trái, phải được tính bằng px.</div>
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 100px">Giao diện</th>
                                <th class="text-center">Nhóm Widget</th>
                                <th class="text-center" style="width: 150px">Từ khóa Widget</th>
                                <th>Tiêu đề</th>
                                <th class="text-center" style="width:88px;">Tình trạng</th>
                                <th class="text-center" style="width:88px;">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>

                                <?php if(isset($widgetList) && is_array($widgetList) && count($widgetList)){ ?>
                                <?php foreach($widgetList as $key => $val){ 
                                    $val['html'] = base64_decode(validate_input($val['html']));
                                    $val['css'] = base64_decode(validate_input($val['css']));
                                    $val['script'] = base64_decode(validate_input($val['script']));
                                ?>

                                <?php  
                                    $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                                ?>

                                <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                    <td class="text-center " >
                                        <a class="img-scaledown" href="<?php echo site_url('backend/widget/widget/update/'.$val['id']); ?>" keyword="">
                                            <img src="<?php echo $val['image'] ?>"  alt="">
                                        </a>
                                    </td>
                                    <td class="text-center text-success" style="width:200px"><?php echo $val['nameCatalogue']; ?></td>
                                    <td class="text-center"> 
                                        <div class="main-info">
                                            <div class="keyword"><a class="mainkeyword" href="<?php echo site_url('backend/widget/widget/update/'.$val['id']); ?>" keyword=""><?php echo $val['keyword']; ?></a></div>
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="main-info">
                                            <div class="title"><a class="maintitle" href="<?php echo site_url('backend/widget/widget/update/'.$val['id']); ?>" title=""><?php echo $val['title']; ?></a></div>
                                        </div>
                                    </td>

                                     
                                    <td class="text-center  active_widget" data-field="publish" data-module="<?php echo $module; ?>" data-where="id"><?php echo $status; ?></td>
                                    <td class="text-center">
                                        <a type="button" href="<?php echo base_url('backend/widget/widget/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                <?php }}else{ ?>
                                    <tr>
                                        <td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                        <div id="pagination">
                            <?php echo (isset($pagination)) ? $pagination : ''; ?>
                        </div>
                        <div class="uk-clearfix mt30">
                            <button type="submit"  class="btn btn-success block m-b pull-right">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
