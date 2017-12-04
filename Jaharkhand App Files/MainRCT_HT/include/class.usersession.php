<?php
/*********************************************************************
    class.usersession.php    
**********************************************************************/
include_once(INCLUDE_DIR.'class.user.php');

class UserSession {
   var $session_id = '';
   var $userID='';   
   var $validated=FALSE;

   function UserSession($userid){           
      $this->session_id=session_id();
      $this->userID=$userid;
   }

   function getSessionId(){
       return $this->session_id;
   }
   
   function refreshSession(){
       //nothing to do...clients need to worry about it.
   }

   function sessionToken(){

      $time  = time();
      $hash  = md5($time.$this->userID);
      $token = "$hash:$time";

      return($token);
   }

   function isvalidSession($htoken,$maxidletime=0){        
       
        $token = rawurldecode($htoken);
        
        #check if we got what we expected....
        if($token && !strstr($token,":"))
            return FALSE;
        
        #get the goodies
        list($hash,$expire)=explode(":",$token);
        
        #Make sure the session hash is valid
        if((md5($expire . $this->userID)!=$hash)){
            return FALSE;
        }
        #is it expired??
                
        if($maxidletime && ((time()-$expire)>$maxidletime)){
            return FALSE;
        }
        #Make sure IP is still same ( proxy access??????)        

        $this->validated=TRUE;

        return TRUE;
   }

   function isValid() {
        return FALSE;
   }

}

class StaffSession extends User {
    
    var $session;
    
    function StaffSession($var){
        parent::User($var);
        $this->session= new UserSession($var);
    }    
	
	function isValid(){
        global $_SESSION;
		
        if(!$this->getId() || $this->session->getSessionId()!=session_id())
            return false;
        
        return $this->session->isvalidSession($_SESSION['_staff']['token'],SessionTimeout)?true:false;
    }
	
    function refreshSession(){
        global $_SESSION;
        $_SESSION['_staff']['token']=$this->getSessionToken();
    }
    
    function getSession() {
        return $this->session;
    }

    function getSessionToken() {
        return $this->session->sessionToken();
    }    
}

?>
