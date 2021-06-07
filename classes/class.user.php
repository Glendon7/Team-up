<?php

class User
{
    private $_db,
        $_data,
        $_sessionName,
        $_cookieName,
        $_id,
        $_isLoggedIn,
        $_projectdata,
        $_projectid;

    public function __construct($user = null)
    {
        $this->_db = Database::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    //logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function create($table, $fields = array())
    {
        if (!$this->_db->insert($table, $fields)) {
            throw new Exception('There was an Error creating an account ');
        }
    }

    public function login($username = null, $password = null, $remember = false)
    {

        if (!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            $user = $this->find($username);


            if ($user) {
                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    Session::put($this->_sessionName, $this->data()->id);


                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck  = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return 1; // login

                }
                return 2; //incorrect password
            }
        }
        return false;
    }

    public function logout()
    {
        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function find($user = null)
    {
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('accounts', array($field, '=', $user));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }

    public function data()
    {
        return $this->_data;
    }

    public function update($table,$id=null,$fields=array()){
        if(!$id && $this->isLoggedIn()){
            $id=$this->_id;
        }

        if(!$this->_db->update($table,$id,$fields)){
            throw new Exception('Error Updating data');
        }
    }

    public function getproject($table,$col,$id)
    {        //used to get anything from the database

        $data = $this->_db->get($table, array($col, '=', $id));


        if ($data->count()) {
            $this->_projectdata = $data->results();

            return true;
        }
        return false;
    }

    public function show($table,$col,$id){
        $data = $this->_db->get($table, array($col, '=',$id));
        
        if($data->count()){
           $this->_data= $data->first();
            return true ;
        }
        return false;
        
    }
    public function getall($table){
        $data= $this->_db->getall($table);
        if($data->count()){
            return $data->results();
        }
        return false;
    }
    
    public function showid()
    {
        $this->_id = $this->data()->id;
        return $this->_id;
    }

    public function projectdata()
    {

        return $this->_projectdata;
    }

    public function projectid($id)
    {
        $this->_projectid = $id;
    }

    public function showprojectid(){
        return $this->_projectid;
    }
    public function delete($table,$id=null,$fields){

        if(!$this->_db->delete($table,array($id, '=' ,$fields))){
            throw new Exception('Error Updating data');
        }
    }
}

