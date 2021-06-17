<?php
App::uses('AppModel', 'Model');
/**
 * VideoLanguage Model
 *
 * @property Video $Video
 */
class LanguageStaticField extends AppModel {

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
