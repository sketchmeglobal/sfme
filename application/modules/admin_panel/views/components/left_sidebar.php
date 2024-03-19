
<?php
$class_name = $this->router->fetch_class();
$method_name = $this->router->fetch_method();
$user_type = $this->session->usertype;
$pr_rs = $this->db->get_where('users', array('user_id' => $this->session->user_id))->row();
$pr = isset($pr_rs->payment_role) ? $pr_rs->payment_role : 0;
?>
<style>
    li a span b{color: #fff453}
    .affix{width:240px;height: 100%;overflow:scroll;}
     .affix::-webkit-scrollbar {
      width: 10px;
    }
    
    /* Track */
     .affix::-webkit-scrollbar-track {
      background: #f1f1f1; 
    }
     
    /* Handle */
     .affix::-webkit-scrollbar-thumb {
      background: #888; 
    }
    
    /* Handle on hover */
     .affix::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }
</style>
<div class="sidebar-left">
    <!--responsive view logo start-->
    <div class="logo theme-logo-bg visible-xs-* visible-sm-*">
        <a href="<?=base_url();?>" target="_blank">
            <img src="<?=base_url();?>assets/img/logo_20px.png" alt="Shilpa Logo">
<!--            <i class="fa fa-home"></i>-->
            <span class="brand-name"><strong><?=WEBSITE_NAME_SHORT;?></strong></span>
        </a>
    </div>
    <!--responsive view logo end-->

    <div class="sidebar-left-info affix">
        <!-- visible small devices start-->
        <div class=" search-field">  </div>
        <!-- visible small devices end-->

        <!--sidebar nav start-->
        <ul class="nav nav-pills nav-stacked side-navigation">

            <!-- top common area -->
            <li><h3 class="navigation-title">Menu</h3></li>
            <?php 
            if($user_type == 1){ 
                ?>
                <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                    <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span><b>Admin</b> Dashboard</span></a>
                </li>
                <?php
            } else if($user_type == 2){ 
                ?>
                <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                    <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span><b>Resource</b> Dashboard</span></a>
                </li>
                <?php
            } else if($user_type == 3){ 
                ?>
                <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                    <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span><b>Marketing</b> Dashboard</span></a>
                </li>
                <?php
            } else if($user_type == 4){ 
                ?>
                <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                    <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span><b>Export</b> Dashboard</span></a>
                </li>
                <?php
            } else if($user_type == 5){ 
                ?>
                <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                    <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span><b>Documentor</b> Dashboard</span></a>
                </li>
                <?php
            } else if($user_type == 6){ 
                ?>
                <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                    <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span><b>Task</b> Dashboard</span></a>
                </li>
                <?php
            } else if($user_type == 7){ 
                ?>
                <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                    <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span><b>Account</b> Dashboard</span></a>
                </li>
                <?php
            } else if($user_type == 8){ 
                ?>
                <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                    <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span><b>Trader</b> Dashboard</span></a>
                </li>
                <?php
            }
            ?>
            
            

            <li class="<?= (($class_name == 'Profile') && ($method_name == 'profile')) ? 'active' : ''; ?>">
                <a href="<?=base_url();?>admin/profile"><i class="fa fa-vcard-o"></i> <span>Profile</span></a>
            </li>    
            <!-- top common area ends-->

            <?php 
            if($user_type == 1){ 
                include_once('sidebar/admin.php');
            } else if($user_type == 2){ 
                include_once('sidebar/resource.php');
            } else if($user_type == 3){ 
                include_once('sidebar/marketing.php');
            } else if($user_type == 4){ 
                include_once('sidebar/export.php');
            } else if($user_type == 5){ 
                include_once('sidebar/doc_manager.php');
            } else if($user_type == 6){ 
                include_once('sidebar/task_manager.php');
            } else if($user_type == 7){ 
                include_once('sidebar/account.php');
            } else if($user_type == 8){ 
                include_once('sidebar/trader.php');
            }
            ?>

            <!-- bottom common area -->
            <!-- TASK STARTS -->
            <li class="menu-list <?=($class_name == 'Task') ? 'active' : ''; ?>"><a href=""><i class="fa fa-tasks"></i> <span>Task</span></a>
                <ul class="child-list">
                    <!-- <li class="< ?=(($class_name == 'Task') && ($method_name == 'task_activity')) ? 'active' : ''; ?>">
                        <a href="< ?=base_url();?>admin/task-activity-all"><i class="fa fa-caret-right"></i> Task Activity</a>
                    </li> -->
                    <li class="<?=(($class_name == 'Task') && ($method_name == 'task_dashboard')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/task-dashboard"><i class="fa fa-caret-right"></i> Task Dashboard</a>
                    </li>
                    <li class="<?=(($class_name == 'Task') && ($method_name == 'task_list_open')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/task-list-open"><i class="fa fa-caret-right"></i> Task List (Opened)</a>
                    </li>
                    <li class="<?=(($class_name == 'Task') && ($method_name == 'task_list_closed')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/task-list-closed"><i class="fa fa-caret-right"></i> Task List (Closed)</a>
                    </li>
                    <li class="<?=(($class_name == 'Task') && ($method_name == 'task_communication')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/task-communication"><i class="fa fa-caret-right"></i> Task Communication</a>
                    </li>
                </ul>
            </li>
                          
            <li class="menu-list <?=($class_name == 'Documents' || $class_name == 'SharedWithMe') ? 'active' : ''; ?>"><a href=""><i class="fa fa-file-text-o"></i> <span>Documents</span></a>
                <ul class="child-list">
                    <li class="<?=(($class_name == 'Documents')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/my-documents/0"><i class="fa fa-caret-right"></i> <span>My Documents</span></a>
                    </li>

                    <li class="<?=(($class_name == 'SharedWithMe')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/shared-with-me/0"><i class="fa fa-caret-right"></i> <span>Shared With Me</span></a>
                    </li>
                </ul>
            </li>
            
            <div class="sidebar-widget">
                <h4>Account Information</h4>
                <ul class="list-group">
                    <li style="background: #faf5a7;">
                        
                        <?php 
                        if($pr == '1') {
                            echo '<p style="color: #616364;text-align: center;padding: 5px;letter-spacing: 2px;font-size: 13px;font-weight: bold;">';
                            echo 'Role: Junior Accountant';
                            echo '</p>';
                        } else if($pr == '2'){ 
                            echo '<p style="color: #616364;text-align: center;padding: 5px;letter-spacing: 2px;font-size: 13px;font-weight: bold;">';
                            echo 'Role: Senior Accountant'; 
                            echo '</p>';
                        }else if ($pr == '3'){
                            echo '<p style="color: #616364;text-align: center;padding: 5px;letter-spacing: 2px;font-size: 13px;font-weight: bold;">';
                            echo 'Role: Head Accountant';
                            echo '</p>';
                        }
                        ?>
                        
                    </li>
                    <li>
                        <p>
                            <strong><i class="fa fa-user-circle-o"></i> <span class="username"><?=$this->session->username;?></span></strong>
                            <br/>
                            <strong><i class="fa fa-envelope"></i> <?=$this->session->email;?></strong>
                        </p>
                    </li>
                    
                    <li>
                        <a href="<?=base_url();?>admin/profile" class="btn btn-info btn-sm addon-btn">Edit Info. <i class="fa fa-vcard pull-left"></i></a>
                    </li>
                </ul>
            </div>  
        </ul>

    </div>
</div>