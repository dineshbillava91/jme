<?php
App::uses('AppModel', 'Model');
/**
 * VideoLanguage Model
 *
 * @property Video $Video
 */
class VideoLanguage extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title_en' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field is required',
				'required' => true,
			),
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Must be at least 3 characters long',
				'required' => true
			)
		),
		'description_en' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field is required',
				'required' => true,
			),
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Must be at least 3 characters long',
				'required' => true
			)
		),
	);

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Video' => array(
			'className' => 'Video',
			'foreignKey' => 'video_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
