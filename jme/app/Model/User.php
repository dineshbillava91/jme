<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field is required',
				'required' => true
			),
			'minLength' => array(
				'rule' => array('minLength', 5),
				'message' => 'Must be at least 5 characters long',
				'required' => true
			)
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field is required',
				'required' => true,
			),
			'minLength' => array(
				'rule' => array('minLength', 5),
				'message' => 'Must be at least 5 characters long',
				'required' => true
			)
		),
		'curr_password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field is required',
				'required' => true,
			),
			'rule1' => array(
				'rule' => array('check_password'),
				'message' => 'Current password is not correct',
				'required' => true,
			),
			'minLength' => array(
				'rule' => array('minLength', 5),
				'message' => 'Must be at least 5 characters long',
				'required' => true
			)
		),
		'new_password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field is required',
				'required' => true,
			),
			'minLength' => array(
				'rule' => array('minLength', 5),
				'message' => 'Must be at least 5 characters long',
				'required' => true
			)
		),
		'con_password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field is required',
				'required' => true,
			),
			'rule1' => array(
				'rule' => array('confirm_password'),
				'message' => "Passwords don't match",
				'required' => true,
			),
			'minLength' => array(
				'rule' => array('minLength', 5),
				'message' => 'Must be at least 5 characters long',
				'required' => true
			)
		),
		
	);
	
	public function check_password(){
		$id = CakeSession::read("Auth.User.id");
		$password = AuthComponent::password($this->data['User']['curr_password']);

		$check_password = $this->find('count',array('conditions'=>array('User.id'=>$id,'User.password'=>$password)));
		if ($check_password > 0){
            return true;
        }else{
            return false;
        }
	}
	
	public function confirm_password(){
		$new_password = AuthComponent::password($this->data['User']['new_password']);
		$con_password = AuthComponent::password($this->data['User']['con_password']);
	
		if ($new_password != $con_password){
            return false;
        }else{
            return true;
        }  
	}

	public function getUserByUserName($username){
		$user = $this->find('first',array('conditions'=>array('User.username'=>$username),'recursive'=>-1));
		if(!empty($user))
			return $user;
		else
			return false;
	}
	
	
}
