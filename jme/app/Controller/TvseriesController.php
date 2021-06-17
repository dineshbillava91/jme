<?php
App::uses('Sanitize', 'Utility');
App::uses('AppController', 'Controller');
/**
 * Tvseries Controller
 *
 * @property Category $Category
 */
class TvseriesController extends AppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array('Tvseries','Language');


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
		$this->Tvseries->recursive = 0;
		$this->paginate = array(
			'conditions' => array('Tvseries.status' => '1'),
			'limit' => PAGE_LIMIT_LISTING,
			'order' => array('Tvseries.id'=>'DESC')
		);
		$series = $this->paginate('Tvseries');
		$this->set('series', $series);
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','tvseries');
		$this->set('title_for_layout',SITE_NAME.' : Manage Series');
	}	
	
/**
 * Admin add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			
			// Set the data to the model
			$this->request->data['Tvseries']['status'] = '1';
			$this->Tvseries->set($this->request->data);
			$validate_fields = array('title_english','title_french','title_spanish','title_chinese','title_arabic');
			// Check Validation
			if ($this->Tvseries->validates(array('fieldList'=>$validate_fields))) {
				$this->Tvseries->create();
				if ($this->Tvseries->save($this->request->data)) {
					$this->Session->setFlash(__('The series has been saved successfully'));
					$this->redirect(array('action' => 'admin_index'));
				} else {
					$this->Session->setFlash(__('The series could not be saved. Please, try again.'));
				}
			}
		}
		$languages = $this->Language->find('list');
		$this->set(compact('languages'));
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','tvseries');
		$this->set('title_for_layout',SITE_NAME.' : Add Series');
	}
	
/**
 * Admin edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Tvseries->id = $id;
		if (!$this->Tvseries->exists()) {
			throw new NotFoundException(__('Invalid series'));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
	
			// Set the data to the model
			$this->Tvseries->set($this->request->data);
	
			// Checking Validation
			$validate_fields = array('title_english','title_french','title_spanish','title_chinese','title_arabic');
			if ($this->Tvseries->validates(array('fieldList'=>$validate_fields))) {
			
				// Clean the posted data 
				//$this->request->data = Sanitize::clean($this->request->data);
			
				if ($this->Tvseries->save($this->request->data)) {
					$this->Session->setFlash(__('The category has been saved'));
					$this->redirect(array('action' => 'admin_index'));
				} else {
					$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
				}
			}
		} else {
			
			// Fetch Data from Category Language
			$series = $this->Tvseries->find('first', array('conditions'=>array('Tvseries.id'=>$id)));
			// print_r($series);exit;
			foreach($series as $record){
				if(!empty($record['id'])){
					$Tvseries['Tvseries']['title_english'] = $record['title_english'];
					$Tvseries['Tvseries']['title_french'] = $record['title_french'];
					$Tvseries['Tvseries']['title_spanish'] = $record['title_spanish'];
					$Tvseries['Tvseries']['title_chinese'] = $record['title_chinese'];
					$Tvseries['Tvseries']['title_arabic'] = $record['title_arabic'];
				}
			}
			$this->request->data = $Tvseries;
		}
		$languages = $this->Language->find('list');
		$this->set(compact('languages'));
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','tvseries');
		$this->set('title_for_layout',SITE_NAME.' : Edit Series');
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
		$this->Tvseries->id = $id;
		if (!$this->Tvseries->exists()) {
			throw new NotFoundException(__('Invalid TV Series'));
		}
		if ($this->Tvseries->saveField('status','0')) {
			$this->Session->setFlash(__('Tvseries deleted successfully'));
			$this->redirect(array('action' => 'admin_index'));
		}else{
			echo 'sdsad';
		}
		$this->Session->setFlash(__('Tvseries was not deleted'));
		// $this->redirect(array('action' => 'admin_index'));
		exit;
	}	
}