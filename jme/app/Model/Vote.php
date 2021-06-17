<?php
App::uses('AppModel', 'Model');
/**
 * Vote Model
 *
 * @property Device $Device
 * @property Video $Video
 */
class Vote extends AppModel {

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
		)
	);
}
