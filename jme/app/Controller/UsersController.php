<?php
App::uses('Sanitize', 'Utility');
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

/**
 * Admin login method
 *
 * @return void
 */
	public function beforeFilter(){
		$this->Auth->allow('admin_forgot');
	}

	public function admin_login() {
	
		
		//echo $this->Auth->password('admin'); exit;
		
		// Check Cookie for Remember Me
		if((isset($_COOKIE['username']) && isset($_COOKIE['password']))  && (!empty($_COOKIE['username']) && !empty($_COOKIE['password']))){
			$this->request->data['User']['username'] = $_COOKIE['username']; 
			$this->request->data['User']['password'] = $_COOKIE['password']; 
			$this->request->data['User']['remember_me'] = $_COOKIE['remember_me']; 
			$this->User->set($this->request->data);
		}
	
		if ($this->request->is('post')) {
			
			
			// Set the data to the model
			$this->User->set($this->request->data);
			
			// Check Validation
			$validate_fields = array('username','password');
			if ($this->User->validates(array('fieldList'=>$validate_fields))) {
				if ($this->Auth->login()) {
				// Set Cookie for Remember Me
					if($this->request->data['User']['remember_me'] == 1){
						setcookie('username', $this->request->data['User']['username'], 2592000 + time());
						setcookie('password', $this->request->data['User']['password'], 2592000 + time());
						setcookie('remember_me', $this->request->data['User']['remember_me'], 2592000 + time());
					}
				
					$this->redirect($this->Auth->redirect());
				} else {
					$this->Session->setFlash(__('Invalid username or password, try again'));
				}
			}
		}
        $this->set('title_for_layout',SITE_NAME.' : Admin Login');
	}

/**
 * Admin logout method
 *
 * @return void
 */	
	public function admin_logout() {
		$this->redirect($this->Auth->logout());
	}	

/**
 * Admin change password method
 *
 * @return void
 */
	public function admin_change_password() {
		if ($this->request->is('post')) {
			
			// Set the data to the model
			$this->User->set($this->request->data);
			
			// Check Validation
			$validate_fields = array('curr_password','new_password','con_password');
			if ($this->User->validates(array('fieldList'=>$validate_fields))) {
			
				// Clean the posted data 
				$this->request->data = Sanitize::clean($this->request->data);
				
				// Store the value in variable
				$id = $this->Auth->user('id');
				$new_password = AuthComponent::password($this->request->data['User']['new_password']);
					
				$data['User']['password'] = $new_password;
				$data['User']['id'] = $id;
				
				if ($this->User->save($data, array('validate'=>false))) {
					$this->Session->setFlash(__('Password has been changed successfully'));
					$this->redirect(array('action' => 'admin_change_password'));
				} else {
					$this->Session->setFlash(__('Password could not be changed. Please, try again.'));
				}
			}
		}
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','admin');
		$this->set('title_for_layout',SITE_NAME.' : Admin Change Password');
	}

	public function admin_forgot(){
		if($this->request->data){
			$data = $this->request->data;
			if($user = $this->User->getUserByUserName($data['User']['username']))
			{
				/*if ($this->Auth->loggedIn()) {
		            $this->redirect($this->Auth->redirect());
		        }*/

                $password = $this->generatePassword();
                $mailData = array(
                    'username' => $user['User']['username'],
                    'email' => $user['User']['email'],
                    'password' => $password
                );

                if($this->sendEmail($mailData, 'Password Reset', 'password_forgot'))
                {
                	$this->User->id = $user['User']['id'];
                	$this->User->saveField('password',AuthComponent::password($password));
                	$this->Session->setFlash(__('Email has been sent successfully'));
                }
                else{
                	$this->Session->setFlash(__('Email has not been sent'));
                }
			}
			else{
				$this->Session->setFlash(__('Email does not exist'));
			}
		}
	}

	public function generatePassword(){
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        
        return implode($pass);
	}

}
