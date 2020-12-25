<nav class="navbar-default navbar-static-side" role="navigation">
    <?php  
        $user = authentication();
        $uri = service('uri');   
        $uri = current_url(true);
        $uriModule = $uri->getSegment(2);
        $uriModule_name = $uri->getSegment(3);
        $baseController = new App\Controllers\BaseController();
        $language = $baseController->currentLanguage();
    ?>
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                    <img alt="image" class="img-circle" src="<?php echo $user['image']; ?>" style="min-width:48px;height:48px;" />
                     </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="<?php echo site_url('profile') ?>">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold" style="color:#fff"><?php echo $user['fullname'] ?></strong>
                     </span> <span class="text-muted text-xs block"><?php echo $user['job'] ?> <b class="caret" style="color: #8095a8"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('backend/authentication/auth/logout') ?>">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="landing_link">
                <a  href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><i class="fa fa-star"></i> <span class="nav-label">Dashboard</span> <span class="label label-warning pull-right">NEW</span></a>
            </li>
            <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>">
                <a href="<?php echo base_url('backend/widget/catalogue/index') ?>"><i class="fa fa-file-text" aria-hidden="true"></i>QL Nhóm Widget</a>
            </li>
            <li class="<?php echo ( $uriModule_name == 'widget') ? 'active'  : '' ?>">
                <a href="<?php echo base_url('backend/widget/widget/index') ?>"><i class="fa fa-file-text" aria-hidden="true"></i>QL Widget</a>
            </li>
            <li class="<?php echo ( $uriModule == 'user') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo translate('cms_lang.sidebar.sb_user', $language) ?></span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/user/catalogue/index') ?>"><?php echo translate('cms_lang.sidebar.sb_user_catalogue', $language) ?></a></li>
                    <li class="<?php echo ( $uriModule_name == 'user') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/user/user/index') ?>"><?php echo translate('cms_lang.sidebar.sb_user', $language) ?></a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'language' || $uriModule == 'system' || $uriModule == 'slide' || $uriModule == 'menu') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-cog"></i> <span class="nav-label"><?php echo translate('cms_lang.sidebar.sb_setting', $language) ?></span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?php echo ( $uriModule_name == 'language') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/language/language/index') ?>"><?php echo translate('cms_lang.sidebar.sb_language', $language) ?></a></li>
                    

                    <li class="<?php echo ( $uriModule_name == 'general') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/system/general/index') ?>">Cấu Hình Chung</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>