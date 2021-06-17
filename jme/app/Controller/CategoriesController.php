<?php
App::uses('Sanitize', 'Utility');
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array('Category', 'CategoryLanguage', 'Language');


/**
 * Component name
 *
 * @var array
 */	
	public $components = array('Common');

	
/**
 * Admin index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CategoryLanguage->recursive = 0;
		$this->paginate = array(
			'conditions' => array('CategoryLanguage.language_id'=>'en', 'Category.status'=>'0'),
			'limit' => PAGE_LIMIT_LISTING,
			'order' => array('Category.id'=>'DESC')
		);
		$CategoryLanguages = $this->paginate('CategoryLanguage');
		$this->set('categoryLanguages', $CategoryLanguages);
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','category');
		$this->set('title_for_layout',SITE_NAME.' : Manage Categories');
	}	
	
/**
 * Admin add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			
			// Set the data to the model
			$this->CategoryLanguage->set($this->request->data);
			
			// Check Validation
			$validate_fields = array('en','es','fr','zh','ar');

			if ($this->CategoryLanguage->validates(array('fieldList'=>$validate_fields))) {
			
				// Clean the posted data 
				//$this->request->data = Sanitize::clean($this->request->data);
			
				$this->Category->create();
				if ($this->Category->save($this->request->data)) {
					
					// Get last insert ID
					$category_id = $this->Category->getLastInsertId();
					
					// Loop for storing the data in category_languages table
					$data = array();
					foreach($this->request->data['CategoryLanguage'] as $key => $value){
						$data[] = array('CategoryLanguage'=>array('name'=>$this->Common->trim($value), 'language_id'=>$key, 'category_id'=>$category_id));
					}
					
					if ($this->CategoryLanguage->saveMany($data, array('validate' => false))) {
						$this->Session->setFlash(__('The category has been saved'));
						$this->redirect(array('action' => 'admin_index'));
					}else{
						$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
					}
				} else {
					$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
				}
			}
		}
		$languages = $this->Language->find('list');
		$this->set(compact('languages'));
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','category');
		$this->set('title_for_layout',SITE_NAME.' : Add Category');
	}
	
/**
 * Admin edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
	
			// Set the data to the model
			$this->CategoryLanguage->set($this->request->data);
	
			// Checking Validation
			$validate_fields = array('en','es','fr','zh','ar');
			if ($this->CategoryLanguage->validates(array('fieldList'=>$validate_fields))) {
			
				// Clean the posted data 
				//$this->request->data = Sanitize::clean($this->request->data);

				if ($this->Category->save($this->request->data)) {
					
					$data = array();
					$categoryLanguages = $this->CategoryLanguage->find('all', array('conditions'=>array('CategoryLanguage.category_id'=>$id)));
					$flag = 0;
					foreach($categoryLanguages as $categoryLanguage){
						$key = $categoryLanguage['CategoryLanguage']['language_id'];
						if($key == "zh" || $key == "ar") $flag = 1;
						$data[] = array('CategoryLanguage'=>array('id'=>$categoryLanguage['CategoryLanguage']['id'], 'name'=>$this->Common->trim($this->request->data['CategoryLanguage'][$key]), 'language_id'=>$key, 'category_id'=>$categoryLanguage['Category']['id']));
					}

					if($flag == 0){

						foreach($this->request->data['CategoryLanguage'] as $key => $value){
								if($key == "zh" || $key == "ar"){
									$data[] = array('CategoryLanguage'=>array('name'=>$this->Common->trim($value), 'language_id'=>$key, 'category_id'=>$id));

								}
						}	
					}
				
					

					
					if($this->CategoryLanguage->saveMany($data, array('validate'=>false))){
						$this->Session->setFlash(__('The category has been saved'));
						$this->redirect(array('action' => 'admin_index'));
					}else{
						$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
					}
				} else {
					$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
				}
			}
		} else {
			
			// Fetch Data from Category Language
			$category_languages = $this->CategoryLanguage->find('all', array('conditions'=>array('CategoryLanguage.category_id'=>$id)));
			foreach($category_languages as $category_language){
				$name = $category_language['CategoryLanguage']['name'];
				$language_id = $category_language['CategoryLanguage']['language_id'];
				
				$CategoryLanguages['Category']['id'] = $category_language['Category']['id'];
				$CategoryLanguages['CategoryLanguage'][$language_id] = html_entity_decode($name, ENT_QUOTES);
			}
			$this->request->data = $CategoryLanguages;
		}
		$languages = $this->Language->find('list');
		$this->set(compact('languages'));
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','category');
		$this->set('title_for_layout',SITE_NAME.' : Edit Category');
	}	

/**
 * Admin delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		
		$data = array();
		$data['Category']['status'] = 1;
		$data['Category']['id'] = $id;
		
		if ($this->Category->save($data)) {
			$this->Session->setFlash(__('Category deleted successfully'));
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash(__('Category was not deleted'));
		$this->redirect(array('action' => 'admin_index'));
	}
	
}