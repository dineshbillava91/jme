<?php
App::uses('AppModel', 'Model');
/**
 * Tvserie Model
 *
 */
class VideoTvseries extends AppModel {

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
 
	 public $belongsTo = array(
		'Videos' => array(
			'className' => 'Video',
			'foreignKey' => 'video_id'
		),
		'Tvseries' => array(
			'className' => 'Tvseries',
			'foreignKey' => 'tvseries_id'
		),
		'Vote' => array(
			'className' => 'Vote',
			'foreignKey' => false,
			'type' => 'LEFT',
			'conditions' => array('VideoTvseries.video_id = Vote.video_id')
		)
	 );
	 
	 var $virtualFields = array(
		"categories" => "SELECT GROUP_CONCAT(DISTINCT name SEPARATOR '~!@ ')as name FROM videos v  LEFT JOIN video_categories vc ON vc.video_id = v.id  LEFT JOIN category_languages cl ON vc.category_id = cl.category_id LEFT JOIN video_tvseries vt ON vt.video_id = v.id where v.id= VideoTvseries.video_id group by v.id",
		
		'series_name' => "SELECT title_english FROM videos v LEFT JOIN video_tvseries vt ON v.id = vt.video_id LEFT JOIN tvseries t ON t.id = vt.tvseries_id WHERE v.id = VideoTvseries.video_id",
		
		'video_title' => "SELECT title FROM videos v LEFT JOIN video_languages vl ON v.id = vl.video_id WHERE v.id = VideoTvseries.video_id ORDER BY v.id ASC LIMIT 0,1",
		
		'description' => "SELECT description FROM videos v LEFT JOIN video_languages vl ON v.id = vl.video_id WHERE v.id = VideoTvseries.video_id ORDER BY v.id ASC LIMIT 0,1",
		
		'votes' => "SELECT count(device) FROM videos v LEFT JOIN votes vl ON v.id = vl.video_id WHERE v.id = VideoTvseries.video_id ORDER BY v.id ASC LIMIT 0,1"
	 );
 
}
