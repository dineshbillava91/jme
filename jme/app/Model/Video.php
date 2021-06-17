<?php
App::uses('AppModel', 'Model');
/**
 * Video Model
 *
 * @property Favourite $Favourite
 * @property VideoCateogory $VideoCateogory
 * @property VideoFrame $VideoFrame
 * @property VideoLanguage $VideoLanguage
 * @property VideoRelate $VideoRelate
 * @property Vote $Vote
 */
class Video extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'video_url' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This Video URL is required',
				'required' => true,
			),
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Must be at least 3 characters long',
				'required' => true
			),
			'rule1' => array(
				'rule' => array('url', true),
				'message' => 'Please enter valid url',
				'required' => true
			)
		),
		'video_duration' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Video duration is required',
				'required' => true,
			),
		)
	);

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Favourite' => array(
			'className' => 'Favourite',
			'foreignKey' => 'video_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'VideoCategory' => array(
			'className' => 'VideoCategory',
			'foreignKey' => 'video_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'VideoTvseries' => array(
			'className' => 'VideoTvseries',
			'foreignKey' => 'video_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'VideoLanguage' => array(
			'className' => 'VideoLanguage',
			'foreignKey' => 'video_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'VideoRelate' => array(
			'className' => 'VideoRelate',
			'foreignKey' => 'video_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Vote' => array(
			'className' => 'Vote',
			'foreignKey' => 'video_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
