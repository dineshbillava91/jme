<?php
App::uses('AppModel', 'Model');
/**
 * CategoryLanguage Model
 *
 * @property Language $Language
 * @property Category $Category
 */
class CategoryLanguage extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
        'en' => array(
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
		'es' => array(
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
		'fr' => array(
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
		'zh' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'This field is required'
			)

		),
		'ar' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'This field is required'
			),

		)
    );
	
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
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
