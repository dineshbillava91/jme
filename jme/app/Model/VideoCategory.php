<?php
App::uses('AppModel', 'Model');
/**
 * VideoCateogory Model
 *
 * @property Video $Video
 * @property Category $Category
 */
class VideoCategory extends AppModel {

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
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $virtualFields = array(
		'category_name' => "SELECT name FROM `categories` c LEFT JOIN category_languages cl ON c.id = cl.category_id where c.id= VideoCategory.category_id limit 0,1",
		'status' => "SELECT status FROM `categories` c LEFT JOIN category_languages cl ON c.id = cl.category_id where c.id= VideoCategory.category_id limit 0,1"
	);
}
