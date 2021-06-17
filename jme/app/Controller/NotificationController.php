<?php
App::uses('Sanitize', 'Utility');
App::uses('AppController', 'Controller');
/**
 * Tvseries Controller
 *
 * @property Category $Category
 */
class NotificationController extends AppController {

	/**
	 * Model name
	 *
	 * @var array
	 */
	public $uses = array('Notification');


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
	/*public function admin_index() {
		$this->paginate = array(
			'limit' => PAGE_LIMIT_LISTING,
			'order' => array('Notification.id'=>'DESC')
		);
		$notification = $this->paginate('Notification');
		$this->set('notification', $notification);
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','notification');
		$this->set('title_for_layout',SITE_NAME.' : Notifications');
	}*/
	
	public function admin_index() {
		
		if ($this->request->is('post')) {
				
			// Set the data to the model
			$this->Notification->set($this->request->data);
			$validate_fields = array('message');

			// Check Validation
			if ($this->Notification->validates(array('fieldList'=>$validate_fields))) {
				
				if ($this->Notification->save($this->request->data)) {
					
				    $message = $this->request->data["Notification"]["message"];
				    $result = $this->Common->send_notification($message);
				    if( $result == "Success"){
				    	$this->Session->setFlash(__('Notification sent successfully'));
				    	
				    }else{
				    	$this->Session->setFlash(__( $result));
				    	
				    }
					$this->redirect(array('action' => 'admin_index'));
				} else {
					$this->Session->setFlash(__('The Notification could not be sent. Please, try again.'));
				}
			}
		}
		
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','Notification');
		$this->set('title_for_layout',SITE_NAME.' : Send Notification');
		$this->render("admin_add");
	}

	/**
	 * Admin add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
				
			// Set the data to the model
			$this->Notification->set($this->request->data);
			$validate_fields = array('message');

			// Check Validation
			if ($this->Notification->validates(array('fieldList'=>$validate_fields))) {
				
				if ($this->Notification->save($this->request->data)) {
					
				    $message = $this->request->data["Notification"]["message"];
				    $result = $this->Common->send_notification($message);
				    if( $result == "Success"){
				    	$this->Session->setFlash(__('Notification sent successfully'));
				    	
				    }else{
				    	$this->Session->setFlash(__( $result));
				    	
				    }
					$this->redirect(array('action' => 'admin_index'));
				} else {
					$this->Session->setFlash(__('The Notification could not be sent. Please, try again.'));
				}
			}
		}
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','Notification');
		$this->set('title_for_layout',SITE_NAME.' : Send Notification');
	}
	
	
	

	
	


}