<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

// Keep in mind when working with sessions that it is generally 
// inadvisable to store DB-related objects in sessions

class Session {
	
	private $logged_in=false;
	public $user_id;
	public $uname;
	public $owner_id;
	public $utype_id;
	
	function __construct() {
		session_start();
		$this->check_login();
    if($this->logged_in) {
      // actions to take right away if user is logged in
    } else {
      // actions to take right away if user is not logged in
    }
	}
	
  public function is_logged_in() {
    return $this->logged_in;
  }


	public function login($user) {
    // database should find user based on username/password.
    if($user){
		$this->owner_id=$_SESSION['owner_id']=$user->owner_id;
      $this->user_id = $_SESSION['user_id'] = $user->auto_id;
	  $this->uname = $_SESSION['uname'] = $user->username;
	  $this->utype_id=$_SESSION['utype_id']=$user->usertype_id;
      $this->logged_in = true;
    }
  }
  
  public function getusername()
	{
		return $this->uname;
	
	}
  
  public function logout() {
    unset($_SESSION['user_id']);
    unset($this->user_id);
	unset($_SESSION['owner_id']);
	unset($this->owner_id);
	unset($_SESSION['uname']);
	unset($this->uname);
    $this->logged_in = false;
  }

	private function check_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }
  
}

$session = new Session();

?>