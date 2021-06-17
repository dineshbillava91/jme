<?php
App::uses('AppModel', 'Model');
/**
 * Notification Model
 *
 */
class Notification extends AppModel {

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	
	public $useTable = 'notification'; // This model uses a database table 'notification'
	
	public $validate = array(
        'message' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'This field is required'
			),
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Must be at least 3 characters long',
				'required' => true
			)
		),
		
    );
    
 
}
