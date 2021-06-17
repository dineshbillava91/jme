<?php
App::uses('AppModel', 'Model');
/**
 * Language Model
 *
 * @property Category $Category
 * @property Video $Video
 */
class Language extends AppModel {

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Category' => array(
			'className' => 'Category',
			'joinTable' => 'category_languages',
			'foreignKey' => 'language_id',
			'associationForeignKey' => 'category_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Video' => array(
			'className' => 'Video',
			'joinTable' => 'video_languages',
			'foreignKey' => 'language_id',
			'associationForeignKey' => 'video_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	public $hasMany = array(
		'StaticField' => array(
			'className' => 'StaticField',
			'foreignKey' => 'language_id',
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
		'LanguageStaticField' => array(
			'className' => 'LanguageStaticField',
			'foreignKey' => 'language_id',
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


	/*
	*
	*	Called before any find-related operation. 
	* 
	*/

	public function beforeFind($queryData) {
        parent::beforeFind();
        $queryData['order'][$this->alias . '.created'] = "asc";
        return $queryData;
    }
}
