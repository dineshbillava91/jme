<?php
App::uses('Sanitize', 'Utility');
App::uses('AppController', 'Controller');
/**
 * Banners Controller
 *
 * @property Banner $Banner
 */
class BannersController extends AppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array('Banner','RefreshRate');

/**
 * Component name
 *
 * @var array
 */	
	public $components = array('Common');

/**
 * METHOD: used to upload a file.
 */
	private function _uploadFile($array, $index, $extentions, $path){
		if($array[$index]['error'] == 0){
		/* UPLOAD: Banner thumbnail(code starts). */
			//SET: the Banner thumbnail upload path on the server.
			$uploadPath = WWW_ROOT.$path;
			//SET: the Banner thumbnail variable.
			$fileArray = $array[$index];
			//GET: extention from the file name.
			$ext = explode('.',$fileArray['name']);
			$ext = end($ext);
			//SET: the temp variables for the upload process.
			$fileName = date('YmdHisiHYdm').'.'.$ext; 
			$fileTmpName = $fileArray['tmp_name'];
			//CHECK: if the thumbnail is unable to upload then the set the response message.
			if(move_uploaded_file($fileTmpName, $uploadPath.$fileName)){ return $fileName; }
			else{ return 0; }
		/* UPLOAD: Banner thumbnail(code ends). */
		}else{ return 0; }
	}

/**
 * Admin index method
 *
 * @return void
 */	
	public function admin_index() {
		//GET: the banners list.
		$banners = $this->Banner->find('all');
		//GET: refresh rate.
		$refreshRate = $this->RefreshRate->find('first');
		$refreshRate = Set::extract('RefreshRate',$refreshRate);
		$refreshRate = $refreshRate['refresh_rate'];
		//SET: the variables for the usage in the view part.
		$this->set('banners', $banners);
		$this->set('refresh_rate', $refreshRate);
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','banners');
        $this->set('title_for_layout',SITE_NAME.' : Manage Banners');
	}	
	
/**
 * Admin add method
 *
 * @return void
 */
	public function admin_add() {
		//CLEAN: the posted data 
		$this->request->data = Sanitize::clean($this->request->data);
		//CHECK: is the POST data submitted.
		if ($this->request->is('post')) {
			//SET: variables for the further usage.
			$postArray = $this->request->data['Banner'];
			$uploadPath = 'uploads/banners/';
			//CALL: the upload file method.
			$fileName = $this->_uploadFile($postArray, 'banner', '', $uploadPath);
			//CHECK: if filename is not equal to 0.
			if($fileName != 0){
				//SET: the filename on the banner index.
				$this->request->data['Banner']['banner'] = $fileName;
				//CHECK: is the post data is saved or not.
				if($this->Banner->save($this->request->data)) { $message = 'Banner saved successfully'; }
				else{ $message = 'Banner upload failed'; }
				//SET: the session flash message for the response.
				$this->Session->setFlash(__($message));
				$this->redirect(array('controller'=>'banners', 'action'=>'admin_index'));
			}else{
				//SET: the session message on process failure.
				$this->Session->setFlash(__('File upload failed. Please try again!'));
			}
		}
		// Set Variable
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','banners');
        $this->set('title_for_layout',SITE_NAME.' : Manage Banners');
	}
	
/**
 * Admin edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		//SET: the value of the id to the Banner object.
		$this->Banner->id = $id;
		//CHECK: is the record exists or not.
		if (!$this->Banner->exists()) { throw new NotFoundException(__('Invalid Banner')); }
		//CHECK: the value sent method is POST or not.
		if ($this->request->is('post') || $this->request->is('put')) {
			// Set Data
			$this->Banner->set($this->request->data);
			// Clean the posted data 
			$this->request->data = Sanitize::clean($this->request->data);
			// Remove Spaces
			$banner_url = $this->Common->trim($this->request->data['Banner']['link']);
			// Store data after removing spaces from begining and end
			$this->request->data['Banner']['link'] = $banner_url;
			if($this->request->data['Banner']['banner']['error'] == 0){
			/* UPLOAD: Banner thumbnail(code starts). */
				//SET: the Banner thumbnail upload path on the server.
				$bannerPath = WWW_ROOT.'uploads/banners/';
				//SET: the Banner thumbnail variable.
				$bannerImg = $this->request->data['Banner']['banner'];
				//GET: extention from the file name.
				$ext = explode('.',$bannerImg['name']);
				$ext = end($ext);
				//SET: the temp variables for the upload process.
				$fileName = date('YmdHisiHYdm').'.'.$ext; 
				$fileTmpLoc = $bannerImg['tmp_name'];
				//CHECK: if the thumbnail is unable to upload then the set the response message.
				if(move_uploaded_file($fileTmpLoc, $bannerPath. $fileName)){ $successText = 'The Banner has been saved'; }
				$this->request->data['Banner']['banner'] = $fileName;
			/* UPLOAD: Banner thumbnail(code ends). */
			}else{ 
				//SET: the banner value from the old value gets from the hidden field.
				$this->request->data['Banner']['banner'] = $this->request->data['Banner']['old_banner'];
			}
			//UPDATE: the banner record in the database.
			if ($this->Banner->save($this->request->data, array('validate'=>false))) {
				//SET: flash message for after save process.
				$this->Session->setFlash(__('The banner has been saved'));
				//REDIRECT: to the banners dashboard.
				$this->redirect(array('controller'=>'banners', 'action'=>'admin_index'));
			} else {
				//SET: flash message after the failure of save process.
				$this->Session->setFlash(__('The banner could not be saved. Please, try again.'));
			}
		}else{
			//CREATE: an array for the moving the values to the edit view.
			$arrData = array();
			$datas = $this->Banner->read(null, $id);
			$arrData['Banner']['banner'] = $datas['Banner']['banner']; 
			$arrData['Banner']['old_banner'] = $datas['Banner']['banner']; 
			$arrData['Banner']['link'] = $datas['Banner']['link']; 
			$this->request->data = $arrData;
		}
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','banners');
		$this->set('title_for_layout',SITE_NAME.' : Edit Banner');
		
	}
	
/**
 * Admin delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_deactivate($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Banner->id = $id;
		if (!$this->Banner->exists()) {
			throw new NotFoundException(__('Invalid Banner'));
		}
		
		$data = array();
		$data['Banner']['status'] = 1;
		$data['Banner']['id'] = $id;
		
		if ($this->Banner->save($data, array('validate'=>false))) {
			$this->Session->setFlash(__('Banner deleted successfully'));
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash(__('Banner was not deleted'));
		$this->redirect(array('action' => 'admin_index'));
	}	
	public function admin_activate($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Banner->id = $id;
		if (!$this->Banner->exists()) {
			throw new NotFoundException(__('Invalid Banner'));
		}
		
		$data = array();
		$data['Banner']['status'] = 0;
		$data['Banner']['id'] = $id;
		
		if ($this->Banner->save($data, array('validate'=>false))) {
			$this->Session->setFlash(__('Banner activated successfully'));
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash(__('Banner was not activated'));
		$this->redirect(array('action' => 'admin_index'));
	}	
	
	/*
	 * METHOD: used to update the value of refresh rate.
	 * */
	public function admin_updateRefreshRate(){
		//GET: refresh rate id.
		$refreshRate = $this->RefreshRate->find('first');
		$refreshRate = Set::extract('RefreshRate',$refreshRate);
		$refreshRateId = $refreshRate['id'];
		//MODIFY: the request data array.
		$refreshRate = $this->request->data['Banner']['refresh_rate'];
		unset($this->request->data['Banner']);
		$this->request->data['RefreshRate']['refresh_rate'] = $refreshRate;
		//SET: id for the update purpose.
		$this->RefreshRate->id = $refreshRateId;
		$this->RefreshRate->save($this->request->data);
		//SET: flash message for the success of records updations.
		$this->Session->setFlash(__('Refresh Rate updated successfully'));
		$this->redirect(array('action' => 'admin_index'));
	}
}
