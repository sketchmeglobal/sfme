<?php
class Task_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function log_before_update($post_array,$primary_key){
        $insertArray = array(
            'table_name' => $this->table_name,
            'pk_id' => $primary_key,
            'action_taken'=>'edit', 
            'old_data' => json_encode($post_array),
            'user_id' => $this->session->user_id,
            'comment' => 'master'
        );
        if($this->db->insert('user_logs', $insertArray)){
            return true;
        }else{
            return false;
        }
    }

    public function check_and_log_before_delete($primary_key){
        // echo $this->reference_table_name . ' || ' . $this->reference_pk_field_name . ' || ' . $primary_key;die;
        $item_exists = 0;
        foreach($this->reference_array as $ra){
            $nr = $this->db->get_where($ra['tbl_name'], array($ra['tbl_pk_fld'] => $primary_key))->num_rows();
            if($nr > 0){
                $item_exists = 1;
            }
        }
        // print_r($this->reference_array);die;        

        if($item_exists > 0){
            return false;
        } else{
            $user_data = $this->db->where($this->pk_field_name, $primary_key)->get($this->table_name)->row();
            $insertArray = array(
                'table_name' => $this->table_name,
                'pk_id' => $primary_key,
                'action_taken'=>'delete', 
                'old_data' => json_encode($user_data),
                'user_id' => $this->session->user_id,
                'comment' => 'master'
            );
            if($this->db->insert('user_logs', $insertArray)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function task_dashboard() {
        $user_id = $this->session->user_id;
        $data =array();
        $data['title'] = 'Edit task activity';
        $data['menu'] = 'Task';

        if($this->input->post('filter_submit')){

            $start_date = ($this->input->post('start_date') == '') ? START_DATE : $this->input->post('start_date');
            $end_date = ($this->input->post('end_date') == '') ? '' : $this->input->post('end_date');
            $task = ($this->input->post('task') == '') ? '' : $this->input->post('task');
            $task_status = ($this->input->post('task_status') == '') ? '' : $this->input->post('task_status');
            $activity = ($this->input->post('activity') == '') ? '' : $this->input->post('activity');
            $activity_status = ($this->input->post('activity_status') == '') ? '' : $this->input->post('activity_status');
            $priority = ($this->input->post('priority') == '') ? '' : $this->input->post('priority');                        
            $task_initiator = ($this->input->post('task_initiator') == '') ? '' : $this->input->post('task_initiator');
            
            $query1= "SELECT * FROM task_header LEFT JOIN task_activity ON th_id=task_header_id"; 
            $where0 = " WHERE task_start_date >= '" .$start_date. "'";
            $where1 = ($end_date == '') ? '' :  " AND task_end_date <='".$end_date."'";
            $where2 = ($task == '') ? '' :  " AND task_header_id ='".$task."'";
            $where3 = ($activity == '') ? '' :  " AND ta_id ='".$activity."'";
            $where4 = ($priority == '') ? '' :  " AND task_priority ='".$priority."'";
            $where5 = ($task_status == '') ? '' : " AND task_status = '".$task_status."'"; 
            $where6 = ($activity_status == '') ? '' : " AND activity_status = '".$activity_status."'";
            $where6 = ($task_initiator == '') ? '' : " AND task_initiator = '".$task_initiator."'"; 

            $query = $query1.$where0.$where1.$where2.$where3.$where4.$where5.$where6;
            $filter_result = $this->db->query($query)->result();
            $data['fitler_result'] = $filter_result;

        }

        $data['all_users'] = $this->db->get_where('users', array('verified' => 1, 'blocked' => 0))->result();

        $data['all_tasks'] = $this->db
            ->get_where('task_header', array('task_status' => 'Open'))->result();

        if($user_id == 1){
            
            $data['activity_notification'] = $this->db
                ->select('th_id,ta_id,task_title,task_initiator,task_priority,activity_title')
                ->join('task_header', 'th_id=task_header_id','left')
                ->get_where('task_activity', array('has_seen' => 0))->result();

            $data['mail_notification'] = $this->db
                ->select('th_id,tc_id,task_title,task_initiator,task_priority,from_id,to_id,thread_status')
                ->join('task_header', 'th_id=task_header_id','left')
                ->get_where('task_communication', array('has_seen' => 0))->result();    

        }else{
            
            $data['activity_notification'] = $this->db
                ->select('th_id,ta_id,task_title,task_initiator,task_priority,activity_title')
                ->join('task_header', 'th_id=task_header_id','left')
                ->get_where('task_activity', array('has_seen' => 0, 'activity_member' => $user_id))->result();
            
            $data['mail_notification'] = $this->db
                ->select('th_id,tc_id,task_title,task_initiator,task_priority,from_id,to_id,thread_status')
                ->join('task_header', 'th_id=task_header_id','left')
                ->get_where('task_communication', array('has_seen' => 0, 'to_id' => $user_id))->result();
            
        }
        
        return array('page'=>'task/task_dashboard', 'data'=>$data); //loading common view page
    }

    // search area
    public function ajax_fetch_activity_on_task($task_id){
        
       $rdata = $this->db
            ->select('ta_id,activity_title')
            ->get_where('task_activity', array('task_header_id' => $task_id))->result();
       echo json_encode($rdata);

    }

    public function ajax_update_activity_notification($ta_id){
        $user_id = $this->session->user_id;
        $nr = $this->db
            ->get_where('task_activity',array('ta_id' => $ta_id, 'activity_member' => $user_id))->num_rows();

        if($nr > 0){
            $update_array = array(
                'has_seen' =>  1
            );
            if($this->db->update('task_activity', $update_array, array('ta_id' => $ta_id))){
                echo json_encode('success');
            }else{
                echo json_encode('failure');
            } 
        }
    }

    public function task_group() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Task/task_group'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Task');
            $crud->set_table('task_group');
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_delete();

            $this->table_name = 'task_group';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->unset_columns('created_date','modified_date','status');
            $crud->unset_fields('created_date','modified_date','status');
            $crud->required_fields('task_group_name', 'task_group_type');
            $crud->unique_fields(array('task_group_name'));

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Task Group';
            $output->section_heading = 'Task Group <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Task Group';
            $output->add_button = '';

            return array('page'=>'task/common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function task_template() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Task/task_template'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Task');
            $crud->set_table('task_template');
            
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'task_template';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->unset_columns('created_date','modified_date','status');
            $crud->unset_fields('created_date','modified_date','status');
            $crud->required_fields('template_name');
            $crud->unique_fields(array('template_name'));

            $crud->field_type('user_id', 'hidden', $user_id);

            $crud->add_action('Common Activity', 
                base_url() . 'assets/grocery_crud/themes/flexigrid/css/images/activity.png', 
                'admin/task-common-activity'); 

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Task Template';
            $output->section_heading = 'Task Template <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Task Template';
            $output->add_button = '';

            return array('page'=>'task/common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function task_list_open() {
        $user_id = $this->session->user_id;
        
        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Task/task_list_open'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Task');
            $crud->set_table('task_header');
            $crud->where('task_status', 'Open');
            if($user_id != 1){
                $where = "FIND_IN_SET(".$user_id.", task_members)";
                $crud->where($where);
                $crud->unset_delete();
            }
            
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'task_header';
            $crud->callback_before_update(array($this,'log_before_update'));
            $crud->callback_column('task_members',array($this,'callback_activity_member'));

            $crud->unset_columns('documents','task_status','task_details','task_start_date','documents','created_date','modified_date','status');
            $crud->required_fields('task_title','task_initiator','task_start_date','task_end_date','task_priority'); // 'task_members',
            $crud->unique_fields(array('task_title'));

            if($user_id == 1){
                $crud->unset_fields('documents','created_date','modified_date','status');
                $crud->set_relation('task_initiator', 'users', 'username', array());
            }else{
                $crud->unset_fields('documents','created_date','modified_date','status','task_status');
                $crud->unset_delete();
                $crud->set_relation('task_initiator', 'users', 'username', array('user_id' => $user_id));
            }
            
            $crud->set_field_upload('documents','assets/task/');

            $this->db->select('user_id, username');
            $results = $this->db->where('verified', 1)->get('users')->result();
            $user_arr = array();
            foreach ($results as $result) {
                $user_arr[$result->user_id] = $result->username;
            }
            
            $crud->field_type('task_members','multiselect', $user_arr);
            $crud->field_type('user_id', 'hidden', $user_id);

            $crud->add_action('Activity', base_url() . 'assets/grocery_crud/themes/flexigrid/css/images/activity.png', 'admin/task-activity'); 
            $crud->add_action('Activity Details', '', '','ui-icon-activity-details',array($this,'task_activity_details'));
            // $crud->add_action('Activity Details', '', 'admin/edit-user-task-activity', array($this,'task_activity_details'));

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Task';
            $output->section_heading = 'Task <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Task';
            $output->add_button = '';

            return array('page'=>'task/common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function task_activity_details($primary_key , $row){
        $nr = $this->db->get_where('task_activity', array('task_header_id' => $primary_key))->num_rows();
        if($nr > 0){
            $task_acitivity_id = $this->db->get_where('task_activity', array('task_header_id' => $primary_key))->row()->ta_id;
        }else{
            $task_acitivity_id = 0;
        }
        return base_url("admin/edit-user-task-activity") . '/' . $task_acitivity_id;
    }

    public function task_list_closed() {
        $user_id = $this->session->user_id;
        
        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Task/task_list_closed'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Task');
            $crud->set_table('task_header');
            $crud->where('task_status', 'Closed');
            
            $crud->unset_read();
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_delete();
            

            $this->table_name = 'task_header';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->unset_columns('documents','task_status','task_details','tast_start_date','created_date','modified_date','status');
            $crud->unset_fields('documents','created_date','modified_date','status');
            $crud->required_fields('task_title','task_initiator','task_start_date','task_end_date','task_priority');
            $crud->unique_fields(array('task_title'));

            $crud->set_relation('task_initiator', 'users', 'username', array());
            $crud->set_field_upload('documents','assets/task/');

            $this->db->select('user_id, username');
            $results = $this->db->where('verified', 1)->get('users')->result();
            $user_arr = array();
            foreach ($results as $result) {
                $user_arr[$result->user_id] = $result->username;
            }
            
            $crud->field_type('task_members','multiselect', $user_arr);
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Task';
            $output->section_heading = 'Task <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Task';
            $output->add_button = '';

            return array('page'=>'task/common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function task_activity_all() {
        $user_id = $this->session->user_id;
        
        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Task/task_activity_all'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Task');
            $crud->set_table('task_activity');

            if($user_id != 1){
                $crud->where('activity_member', $user_id);
                $crud->unset_delete();
                $crud->unset_edit();
                $crud->add_action('Edit', 'https://www.grocerycrud.com/v1.x/assets/grocery_crud/themes/flexigrid/css/images/edit.png', 'admin/edit-user-task-activity');
            }

            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'task_activity';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->unset_columns('activity_details','activity_start_date','activity_remarks','created_date','modified_date','status');
            $crud->unset_fields('created_date','modified_date','status');
            $crud->required_fields('activity_title','activity_member','activity_status');
            $crud->unique_fields(array('task_title'));

            $crud->set_relation('task_template_id', 'task_template', 'template_name', array());
            $crud->set_relation('task_header_id', 'task_header', 'task_title', array());
            $crud->set_relation('activity_member', 'users', 'username', array());
            $crud->set_field_upload('activity_document','assets/task/');

            $crud->display_as('task_template_id', 'Template Type');
            $crud->display_as('task_header_id', 'Main task');
            
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Task Activity';
            $output->section_heading = 'Task Activity <small>Add/Edit/Delete/Update</small>';
            $output->menu_name = 'Task Activity';
            $output->add_button = '';

            return array('page'=>'task/common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function task_activity($theader) {
        $user_id = $this->session->user_id;
        $header = $this->db->get_where('task_header', array('th_id' => $theader))->row();
        $header_title = "Task Activity <small>(Add / Edit / Delete)</small><hr>";
        $header_title .= "<div style='border-left:5px solid #8fb9e3;padding: 10px;'>" . $header->task_title . "</div>";

        try{
            $crud = new grocery_CRUD();
            // $crud->set_crud_url_path(base_url('admin_panel/Task/task_activity'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Activity');
            $crud->set_table('task_activity');

            $crud->where('task_header_id', $theader);
            if($user_id != 1){
                $where = "FIND_IN_SET(".$user_id.", activity_member)";
                $crud->where($where);
                $crud->unset_delete();
            }

            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'task_activity';

            $crud->add_action('Edit', base_url() . 'assets/grocery_crud/themes/flexigrid/css/images/activity.png', 'admin/edit-user-task-activity');

            $crud->callback_before_update(array($this,'log_before_update'));
            $crud->callback_column('activity_initiator',array($this,'callback_activity_initiator'));
            $crud->callback_column('activity_member',array($this,'callback_activity_member'));

            $crud->columns('task_template_id','activity_title','activity_initiator','activity_member','activity_document','activity_status');
            $crud->unset_fields('activity_start_date','activity_end_date','has_seen','created_date','modified_date','status','activity_permission','activity_remarks');
            $crud->required_fields('activity_title','activity_status'); //'activity_member',
            
            // $crud->unique_fields(array('task_title'));
            // $crud->add_fields('task_template_id','activity_title','activity_details','activity_member','activity_document','activity_status');
            // $crud->edit_fields('activity_permission','activity_remarks');
            // $crud->set_relation('activity_member', 'users', 'username', array());

            $crud->set_relation('task_template_id', 'task_template', 'template_name', array());
            
            $tmembers = explode(",",$this->db->get_where('task_header', array('th_id' => $theader))->row()->task_members);
            
            foreach($tmembers as $userid){
                $rs = $this->db->get_where('users', array('user_id' => $userid))->row();
                if(count($rs) > 0){
                    $username = $rs->username;
                }else{
                    $username = '<i><small>No username provided</small></i>';
                }
                
                $user_arr[$userid] = $username;
            }
            
            $crud->set_field_upload('activity_document','assets/task/');

            $crud->field_type('activity_member','dropdown', $user_arr);
            $crud->field_type('task_header_id', 'hidden', $theader);
            $crud->field_type('user_id', 'hidden', $user_id);

            $crud->display_as('task_template_id','Template Type'); 
            // $crud->display_as('activity_permission','Request change permission'); 
            // $crud->display_as('activity_remarks','Change reason');
            
            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Activity';
            $output->section_heading = $header_title;
            $output->menu_name = 'Activity';
            $output->add_button = '';

            return array('page'=>'task/common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function callback_activity_member($value, $row) {
        $tmembers = explode(",",$value);
        $username = '';    
        if(count($tmembers) > 0){
            foreach($tmembers as $userid){
                $rr = $this->db->get_where('users', array('user_id' => $userid))->row();
                if(!empty($rr)){
                    $username .= $this->db->get_where('users', array('user_id' => $userid))->row()->username . ', ';
                }
            }
            return rtrim($username, ", ");
        }else{
            return '-';
        }
        
    }

    public function callback_activity_initiator($value, $row) {
        $task_header_id = $row->task_header_id;
        $task_initiator = $this->db->get_where('task_header', array('th_id' => $task_header_id))->row()->task_initiator;
        return $this->db->get_where('users', array('user_id' => $task_initiator))->row()->username;
    }

    public function task_common_activity($template_id) {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            // $crud->set_crud_url_path(base_url('admin_panel/Task/task_common_activity'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Task');
            $crud->set_table('common_task_activity');
            $crud->where('template_id', $template_id);
            
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'common_task_activity';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->unset_columns('template_id','common_info','created_date','modified_date','status');
            $crud->unset_fields('common_info','created_date','modified_date','status');
            $crud->required_fields('common_question','tempalte_id','pattern');
            $crud->unique_fields(array('common_question'));
            
            // $crud->set_relation('template_id','task_template','template_name',array('task_template.status' => 1));

            $crud->field_type('template_id', 'hidden', $template_id);
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Common Task Activity';
            $output->section_heading = 'Common Task Activity <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Common Task Activity';
            $output->add_button = '';

            return array('page'=>'task/common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function edit_user_task_activity($task_activity_id){

        $data['title'] = 'Edit task activity';
        $data['menu'] = 'Task';
        $data['task_activity_id'] = $task_activity_id;
        $user_id = $this->session->user_id;
        $data['msg'] = '';

        // form submit
        if($this->input->post('commonsubmit')){
            $comm_ques = count($this->input->post('task_common_id'));
            
            for($iter = 0; $iter<$comm_ques; $iter++){
                $is_exist = $this->db
                    ->get_where('task_activity_detail_common', array(
                        'task_activity_id' => $this->input->post('task_activity_id'),
                        'cta_id' => $this->input->post('task_common_id')[$iter]))
                    ->num_rows();
                if($is_exist > 0){
                    $update_array = array(
                        'task_value' => $this->input->post('task_value')[$iter]                        
                    );
                    $this->db
                    ->where(array(
                        'task_activity_id' => $this->input->post('task_activity_id'),
                        'cta_id' => $this->input->post('task_common_id')[$iter]))
                    ->update('task_activity_detail_common', $update_array);
                }else{
                    $insert_array = array(
                        'task_activity_id' => $this->input->post('task_activity_id'),
                        'cta_id' => $this->input->post('task_common_id')[$iter],
                        'task_value' => $this->input->post('task_value')[$iter]
                    );
                    $this->db->insert('task_activity_detail_common', $insert_array);
                }
                $data['msg'] = 'Data updated successfully';
            }

        }

        if($this->input->post('generalsubmit')){

            $update_array = array(
                'activity_status' => $this->input->post('activity_status'),
                'activity_details' => $this->input->post('activity_question_ans')
            );
            $this->db
            ->where(array('ta_id' => $task_activity_id))
            ->update('task_activity', $update_array);
            $data['msg'] = 'Data updated successfully';

        }
        
        $row_val = $this->db->get_where('task_activity', array('ta_id' => $task_activity_id))->row();
        if(count($row_val) > 0){
            $task_header_id = $this->db->get_where('task_activity', array('ta_id' => $task_activity_id))->row()->task_header_id;
        }else{
            die('Task activity not set. <a href="'.base_url().'">Go Back</a>');
        }
        

        $data['task_details'] = $this->db->get_where('task_header', array('th_id' => $task_header_id))->row();
        $task_template_type = $this->db->get_where('task_activity', array('ta_id' => $task_activity_id))->row()->task_template_id;

        if($task_template_type != '' or $task_template_type != 0 or $task_template_type != NULL){ 
            $cact_query = "SELECT
                    common_task_activity.cta_id,task_activity_id,tadc_id,common_question,pattern,task_value
                FROM
                    `common_task_activity`
                LEFT JOIN `task_activity_detail_common` ON `common_task_activity`.`cta_id` = `task_activity_detail_common`.`cta_id`
                WHERE
                    `common_task_activity`.`status` = 1 AND (task_activity_id = $task_activity_id OR task_activity_id IS NULL)
                    AND `common_task_activity`.template_id = $task_template_type
                ORDER BY
                    `pattern`";
            $data['common_activities'] = $this->db->query($cact_query)->result();
            
        }else{ 
            $data['common_activities'] = '';
        }

        $data['task_activity'] = $this->db->get_where('task_activity', array('ta_id' => $task_activity_id))->result();



        return array('page'=>'task/edit_user_task_activity', 'data'=>$data);

    }

    public function task_communication() {
        $user_id = $this->session->user_id;
        $user_role = $this->session->usertype;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Task/task_communication'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Task Communication');
            $crud->set_table('task_communication');
            if($user_id != 1){
                $where = "thread_status = 'first' AND (from_id = ".$user_id." OR FIND_IN_SET(".$user_id.", to_id))"; //to_id = ".$user_id."
                $crud->where($where);
            }else{
                $crud->where('thread_status', 'first');
            }
            

            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'task_communication';

            
            $crud->callback_before_update(array($this,'log_before_update'));
            $crud->callback_column('from_id',array($this,'username_from_id'));
            
            $crud->unset_columns('thread_status','to_id','created_date','modified_date','status');
            $crud->unset_fields('created_date','modified_date','status');
            $crud->required_fields('task_header_id','comment');
            $crud->unique_fields(array('task_header_id'));
            
            $crud->set_field_upload('document','assets/task/');
            
            $crud->set_relation('task_header_id', 'task_header', 'task_title', array());
            
            // Resource and marketer can't communicate
            
            if($user_role == '2'){
                $results = $this->db->where('verified', 1)->where('usertype !=', '3')->where('user_id !=', $user_id)->get('users')->result();
            } else if($user_role == '3'){
                $results = $this->db->where('verified', 1)->where('usertype !=', '2')->where('user_id !=', $user_id)->get('users')->result();
            }else{
                $results = $this->db->where('verified', 1)->where('user_id !=', $user_id)->get('users')->result();
            }

            // echo $this->db->last_query(); die;
            
            $user_arr = array();
            foreach ($results as $result) {
                $user_arr[$result->user_id] = $result->username;
            }
            
            $crud->field_type('to_id','multiselect', $user_arr);
            $crud->field_type('from_id', 'hidden', $user_id);    
            $crud->field_type('user_id', 'hidden', $user_id);
            $crud->field_type('thread_status', 'hidden', 'first');
            
            $crud->add_action('Chats', 
                base_url() . 'assets/grocery_crud/themes/flexigrid/css/images/communication.png', 
                'admin/task-communication-details'); 
            
            $crud->display_as('task_header_id', 'Task Header');
            $crud->display_as('to_id', 'Sent To');
            $crud->display_as('from_id', 'Sent From');
    
            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Task Communication';
            $output->section_heading = 'Task Communication <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Task Communication';
            $output->add_button = '';

            return array('page'=>'task/common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function username_from_id($value, $row) {
      return $this->db->get_where('users', array('users.user_id' => $value))->row()->username;
    }

    public function task_communication_details($tcid) {

        $user_id = $this->session->user_id;
        $data['title'] = 'Edit task activity';
        $data['menu'] = 'Task';
        $data['task_communication_id'] = $tcid;
        $data['task_header_id'] = $this->db->get_where('task_communication', array("tc_id" => $tcid))->row()->task_header_id;
        $data['all_users'] = $this->db->get_where('users', array('verified' => 1, 'blocked' => 0, 'user_id !=' => $user_id))->result();
        $data['msg'] = '';

        $to_members = '';

        $task_details= $this->db
            ->select('users.username, task_title, task_start_date, task_end_date, task_priority, task_status, task_header.documents, task_communication.*')
            ->join('task_header','task_header.th_id=task_header_id','left')
            ->join('users','users.user_id=from_id','left')
            ->get_where('task_communication', array('tc_id' => $tcid))->row();

        $data['task_details'] = $task_details;
        $task_comm_members = explode(",",$task_details->to_id);    
        
        foreach($task_comm_members as $tcm){
            $to_members .= '#' . $this->db
                ->select('username')
                ->get_where('users', array('user_id' => $tcm))->row()->username;
        }    
        $data['to_members'] = substr($to_members, 1);
        $data['msg'] = '';

        if($this->input->post('reply_submit')){
            $insert_array = array(
                'task_header_id' => $this->input->post('th_id'),
                'from_id' => $user_id,
                'to_id' => implode(",",$this->input->post('participant')),
                'comment' => $this->input->post('reply')
            );
            if($this->db->insert("task_communication",$insert_array)){
                
                $tc_id = $this->db->insert_id();
                
                if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){
                    $filesCount = count($_FILES['files']['name']); 
                    for($i = 0; $i < $filesCount; $i++){ 
                        $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
                        $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
                        $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
                        $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
                     
                        // File upload configuration 
                        $uploadPath = './upload/communication/'; 
                        $config['upload_path'] = $uploadPath; 
                        $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|exl|exls|txt|zip'; 
                        $config['max_size']    = '10000'; 
                        //$config['max_width'] = '1024'; 
                        //$config['max_height'] = '768';
                        
                        // Load and initialize upload library 
                        $this->load->library('upload', $config); 
                        $this->upload->initialize($config); 
    
                        if($this->upload->do_upload('file')){ 
                            // Uploaded file data 
                            $fileData = $this->upload->data(); 
                            $uploadData['task_header_id'] = $this->input->post('th_id'); 
                            $uploadData['tc_id'] = $tc_id; 
                            $uploadData['document'] = $fileData['file_name']; 
                        }else{  
                            $data['msg'] .= $_FILES['file']['name'].' | File type issue ';
                        }   
                        
                        if(!empty($uploadData)){ 
                            $this->db->insert('task_communication_attachments',$uploadData); 
                        }else{
                            $data['msg'] .= " | Attachment not uploaded | ";
                        }
    
                    }
                }
                $data['msg'] = "Reply sent successfully";
            }
        }

        $data['task_reply'] = $this->db
            ->select('username, to_id, comment, created_date, tc_id, task_header_id')
            ->join('users','users.user_id=from_id','left')
            ->order_by('tc_id','desc')
            ->get_where('task_communication', array('task_header_id' => $data['task_header_id']))->result();

        // $data['task_attachments'] = $this->db
        //     ->select('document')
        //     ->get_where('task_communication_attachments', 
        //         array('task_header_id' => $data['task_header_id'], 'tc_id' => $task_details->tc_id))
        //     ->result();    

        return array('page'=>'task/task_communication_details', 'data'=>$data); 
    }

    public function ajax_update_mail_notification($tc_id){
        $user_id = $this->session->user_id;
        $nr = $this->db
            ->get_where('task_communication',array('tc_id' => $tc_id, 'to_id' => $user_id))->num_rows();

        if($nr > 0){
            $update_array = array(
                'has_seen' =>  1
            );
            if($this->db->update('task_communication', $update_array, array('tc_id' => $tc_id))){
                echo json_encode('success');
            }else{
                echo json_encode('failure');
            } 
        }
    }

}