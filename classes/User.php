<?php


class User
{
    private $_db;

    public function __construct()
    {
        $this->_db = Database::getInstance();
    }
    
    public function login_user($username, $password)
    {
        $fields = array('username' => 'username', 'password' => 'password');
        $column = $fields['username'];

        $data = $this->_db->get_info($fields, 'accounts', $column, $username);

        if (password_verify($password, $data['password'])) {
            return true;
        }
        else {
            return false;
        }

    }
    public function is_loggedIn() {
        if ( Session::exists('username') ) return true;
        else return false;
    }    


    // Berikut ini fungsi yang berkaitan dengan get info user

    public function get_users() {
        // NEW
        $fields = array('user_email' => 'user_email', 'user_username' => 'user_username', 'user_first_name' => 'user_first_name', 'user_last_name' => 'user_last_name', 'user_status' => 'user_status', 'user_dob' => 'user_dob', 'user_phone' => 'user_phone', 'user_address' => 'user_address', 'user_profile_picture' => 'user_profile_picture','role_id' => 'role_id', 'batch_id' => 'batch_id', 'batch_name' => 'batch_name', 'batch_start_date' => 'batch_start_date', 'batch_end_date' => 'batch_end_date', 'role_name' => 'role_name', 'date_created' => 'date_created');
        return $this->_db->get_info($fields, '', '', '', '');
    }


    public function get_data($email) {
        
        $fields = array('user_email' => 'user_email', 'user_password' => 'user_password', 'user_username' => 'user_username', 'user_first_name' => 'user_first_name', 'user_last_name' => 'user_last_name', 'user_status' => 'user_status', 'user_dob' => 'user_dob', 'user_phone' => 'user_phone', 'user_address' => 'user_address', 'user_gender' => 'user_gender', 'user_profile_picture' => 'user_profile_picture','role_id' => 'role_id', 'batch_id' => 'batch_id');
        $column = $fields['user_email'];

        return $this->_db->get_info($fields, 'user', $column, $email);
    }


    public function check_username($username) {
        $fields = array('username' => 'username');
        $column = $fields['username'];
        $data = $this->_db->get_info($fields, 'accounts', $column, $username);

        if ( empty($data) ) return false;
        else return true;

    }

    
}