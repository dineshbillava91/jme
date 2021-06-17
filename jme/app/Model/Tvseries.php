<?php
App::uses('AppModel', 'Model');
/**
 * Tvserie Model
 *
 */
class Tvseries extends AppModel {

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $validate = array(
        'title_english' => array(
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
		'title_spanish' => array(
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
		'title_french' => array(
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
		'title_chinese' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'This field is required'
			),
		
		),
		'title_arabic' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'This field is required'
			),

		)
    );
 
	 public $hasMany = array(
		'VideoTvseries' => array(
			'className' => 'VideoTvseries',
			'dependent' => true
		)
	 );
}
