<?php
/*********************************************************************
    class.user.php
**********************************************************************/
class User{
	
	var $username;
	var $passwd;
	var $id;
	var $email;
	var $salt;
	
	var $firstname;
	var $lastname;
	
	function User($var){        
		$this->id =0;
        return ($this->lookup($var));
    }
	
	function lookup($var){

        $sql=sprintf("SELECT user_id,username,password,salt FROM ".USERS_TABLE." WHERE username=%s",db_input($var));

        $res=db_query($sql);
        if(!$res || !db_num_rows($res))
            return NULL;

        $row=db_fetch_array($res);        
        $this->id         = $row['user_id'];     
        $this->firstname  = ucfirst($row['username']);
        $this->lastname   = ucfirst($row['username']);
        
        $this->passwd     = $row['password'];
        $this->username   = $row['username'];
        $this->email      = $row['email'];
        $this->salt       = $row['salt'];
		
        return ($this->id);
    }
	
	function check_passwd($password){		
		$hash = hash("sha512", $password . $this->salt);				
		return (strlen($this->passwd) && (($this->passwd == $hash)==1))?(TRUE):(FALSE);        
    }
	
	function getId(){
        return $this->id;
    }	
}
?>