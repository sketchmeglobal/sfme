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

    public function task_list() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Task/task_list'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Task');
            $crud->set_table('task_header');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'task_header';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->unset_columns('created_date','modified_date','status');
            $crud->unset_fields('created_date','modified_date','status');
            $crud->required_fields('task_title','task_initiator','task_start_date','task_end_date','task_priority','task_group_type');
            $crud->unique_fields(array('task_title'));

            $crud->set_relation('task_initiator', 'users', 'username', array());
            $crud->set_relation('task_group_type', 'task_group', 'task_group_name', array());
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

    public function task_activity() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Task/task_activity'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Task');
            $crud->set_table('task_activity');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'task_activity';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->unset_columns('created_date','modified_date','status');
            $crud->unset_fields('created_date','modified_date','status');
            $crud->required_fields('activity_task_id','activity_title','activity_member','activity_status');
            // $crud->unique_fields(array('task_title'));

            $crud->set_relation('activity_task_id', 'task_header', 'task_title', array());
            $crud->set_relation('activity_member', 'users', 'username', array());
            $crud->set_field_upload('activity_document','assets/task/');

            
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Task Activity';
            $output->section_heading = 'Task Activity <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Task Activity';
            $output->add_button = '';

            return array('page'=>'task/common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function task_common_activity() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Task/task_common_activity'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Task');
            $crud->set_table('common_task_activity');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'common_task_activity';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->unset_columns('created_date','modified_date','status');
            $crud->unset_fields('created_date','modified_date','status');
            $crud->required_fields('common_question');
            $crud->unique_fields(array('common_question'));
            
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

}