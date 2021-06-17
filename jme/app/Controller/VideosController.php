<?php
App::uses('Sanitize', 'Utility');
App::uses('AppController', 'Controller');
/**
 * Videos Controller
 *
 * @property Video $Video
 */
class VideosController extends AppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array('Video', 'Language', 'CategoryLanguage', 'VideoLanguage', 'VideoCategory', 'Category', 'VideoRelate','Tvseries','VideoTvseries');

/**
 * Component name
 *
 * @var array
 */	
	public $components = array('Common');

	
/**
 * Admin search method
 *
 * @return void
 */
	public function admin_search() {
		$conditions = array();
		if(!empty($this->request->query)){
			$name = Sanitize::clean($this->request->query['q']);
			$conditions = array("(Video.director LIKE '%".$this->Common->trim($name)."%' OR VideoLanguage.title LIKE '%".$this->Common->trim($name)."%')", 'VideoLanguage.language_id'=>'en', 'Video.status'=>0);
			$this->request->data['Video']['name'] = html_entity_decode($this->Common->trim($name), ENT_QUOTES);
		}
		// Query fetching data
		$this->VideoLanguage->recursive = 3;
		$this->Video->virtualFields = array('no_of_votes'=> "SELECT COUNT(*) FROM votes WHERE votes.video_id = Video.id");
		$this->Category->virtualFields = array('name'=> "SELECT category_languages.name FROM category_languages WHERE category_languages.language_id = 'en' AND category_languages.category_id = Category.id");
		$this->paginate = array(
			'conditions' => $conditions,
			'limit' => PAGE_LIMIT_LISTING,
			'order' => array('Video.id'=>'DESC')
		);
		$VideoLanguages = $this->paginate('VideoLanguage');
		
		// Set Variable
		$this->Video->set($this->request->data['Video']['name']);
		$this->set('videoLanguages', $VideoLanguages);
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','video');
		$this->set('title_for_layout',SITE_NAME.' : Manage Videos');
		$this->render('admin_index');
	}	

/**
 * Admin index method
 *
 * @return void
 */	
	public function admin_index() {
		
		// Query fetching data
		$this->VideoLanguage->recursive = 3;
		$this->Video->virtualFields = array('no_of_votes'=> "SELECT COUNT(*) FROM votes WHERE votes.video_id = Video.id");
		$this->Category->virtualFields = array('name'=> "SELECT category_languages.name FROM category_languages WHERE category_languages.language_id = 'en' AND category_languages.category_id = Category.id");
		$this->paginate = array(
			'conditions' => array('VideoLanguage.language_id'=>'en', 'Video.status'=>array(0)),
			'limit' => PAGE_LIMIT_LISTING,
			'order' => array('Video.created'=>'DESC')
		);
		$VideoLanguages = $this->paginate('VideoLanguage');
		
		// Set Variable
		$this->set('videoLanguages', $VideoLanguages);
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','video');
        $this->set('title_for_layout',SITE_NAME.' : Manage Videos');
	}	
	
/**
 * Admin add method
 *
 * @return void
 */
	public function admin_add() {
		// Categories
		$categories = array();
		$this->CategoryLanguage->recursive = 0;
		$this->paginate = array(
			'conditions' => array('CategoryLanguage.language_id'=>'en', 'Category.status'=>0),
			'order' => array('CategoryLanguage.name'=>'ASC')
		);
		$CategoryLanguages = $this->paginate('CategoryLanguage');
		foreach($CategoryLanguages as $CategoryLanguage){
			$categories[$CategoryLanguage['Category']['id']] = html_entity_decode(substr($CategoryLanguage['CategoryLanguage']['name'],0,35), ENT_QUOTES);
		}
		
		//TV Series
		$series = array();
		$this->Tvseries->recursive = 0;
		$this->paginate = array(
			'conditions' => array('Tvseries.status' => '1'),
			'order' => array('Tvseries.title_english' => 'ASC')
		);
		$TVSeries = $this->paginate('Tvseries');
		foreach($TVSeries as $record){
			$series[$record['Tvseries']['id']] = html_entity_decode(substr($record['Tvseries']['title_english'],0,35), ENT_QUOTES);
		}
		
		// Languages
		$languages = $this->Language->find('list');
		$this->set(compact('languages','categories','series'));
		
		if ($this->request->is('post')) {
			
			// Set Data
			$this->Video->set($this->request->data);
			$this->VideoLanguage->set($this->request->data);
					
			// Array Declaration
			$err = array();
			
			// Check Validation for videos
			if (!$this->Video->validates(array('fieldList'=>array('video_url')))) {
				$err[] = $this->Video->validationErrors;
			}
				
			// Check Validation for video_languages
			if (!$this->VideoLanguage->validates()) {
				$err[] = $this->VideoLanguage->validationErrors;
			}
			
			if(count($err) == 0){
				
				// Clean the posted data 
				$this->request->data = Sanitize::clean($this->request->data);
				
				// Remove Spaces
				$video_url = $this->Common->trim($this->request->data['Video']['video_url']);
				
				// Store data after removing spaces from begining and end
				$this->request->data['Video']['video_url'] = $video_url;
				
				// Explode video_url and fetch the video_id 
				$video_id = '';
				$arrVideo = explode('?v=',$video_url);
				$video_id = @$arrVideo[1];
				
				$successText = 'The video has been saved'; 
				
				if($this->request->data['Video']['video_thumbnail']['error'] == 0){
				/* UPLOAD: video thumbnail(code starts). */
					//SET: the video thumbnail upload path on the server.
					$thumbnail_path = WWW_ROOT.'uploads/video/';
					//SET: the video thumbnail variable.
					$videoThumbnail = $this->request->data['Video']['video_thumbnail'];
					//GET: extention from the file name.
					$ext = explode('.',$videoThumbnail['name']);
					$ext = end($ext);
					//SET: the temp variables for the upload process.
					$fileName = date('YmdHis').'-thumb.'.$ext; 
					$fileTmpLoc = $videoThumbnail['tmp_name'];
					//CHECK: if the thumbnail is unable to upload then the set the response message.
					if(move_uploaded_file($fileTmpLoc, $thumbnail_path. $fileName)){ 
						$successText = 'The video has been saved'; 
					}
					$this->request->data['Video']['video_thumbnail'] = $fileName;
				/* UPLOAD: video thumbnail(code ends). */
				}else{ 
					$successText = 'The video has been saved (Unable to update video thumbnail)';
					$this->request->data['Video']['video_thumbnail'] = '';
				}
				
				
				$this->Video->create();
				if ($this->Video->save($this->request->data)) {
				
					// Get last insert ID
					$video_id = $this->Video->getLastInsertId();
					
					// Loop for storing data in VideoLanguage table
					$data = array();
					foreach($languages as $key => $value){
						$title = $this->Common->removeSlashes($this->request->data['VideoLanguage']['title_'.$key]);
						$description = $this->Common->removeSlashes($this->request->data['VideoLanguage']['description_'.$key]);
						
						if(!empty($title) && !empty($description)){
							$data[] = array('VideoLanguage'=>array('video_id'=>$video_id, 'language_id'=>$key, 'title'=>$title, 'description'=>$description));
						}
					}
					$this->VideoLanguage->saveMany($data, array('validate' => false));
					
					// Loop for storing data in VideoCategory table
					if(!empty($this->request->data['VideoCategory']['category_id'])){	
						$result = array();
						foreach($this->request->data['VideoCategory']['category_id'] as $k => $v){
							$result[] = array('VideoCategory'=>array('video_id'=>$video_id, 'category_id'=>$v));
						}
						$this->VideoCategory->saveMany($result, array('validate' => false));
					}
					
					// Loop for storing data in Tvseries table
					if(!empty($this->request->data['VideoTvseries']['tvseries_id'])){	
						$result = array();
						$v = $this->request->data['VideoTvseries']['tvseries_id'];
						$result = array('VideoTvseries'=>array('video_id'=>$video_id, 'tvseries_id'=>$v));
						$this->VideoTvseries->saveMany($result, array('validate' => false));
					}
					
					// Redirect to Video Relates
					$this->Session->setFlash(__($successText));
					$this->redirect(array('controller'=>'videos', 'action'=>'admin_index'));
				} else {
					$this->Session->setFlash(__('The video could not be saved. Please, try again.'));
				}
			}		
		}
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','video');
        $this->set('title_for_layout',SITE_NAME.' : Add Related Videos');
	}
	
/**
 * Admin edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		
		$this->Video->id = $id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		
		$totalRelatedVideos = $this->VideoRelate->find('count',array('conditions'=>array('VideoRelate.video_id'=>$id)));
		$this->set('totalRelatedVideos',$totalRelatedVideos);
		$this->set('video_id',$id);
		
		// Categories
		$categories = array();
		$this->CategoryLanguage->recursive = 0;
		$this->paginate = array(
			'conditions' => array('CategoryLanguage.language_id'=>'en', 'Category.status'=>0),
			'order' => array('CategoryLanguage.name'=>'ASC')
		);
		$CategoryLanguages = $this->paginate('CategoryLanguage');
		foreach($CategoryLanguages as $CategoryLanguage){
			$categories[$CategoryLanguage['Category']['id']] = html_entity_decode(substr($CategoryLanguage['CategoryLanguage']['name'],0,35), ENT_QUOTES);
		}
		
		//TV Series
		$series = array();
		$this->Tvseries->recursive = 0;
		$this->paginate = array(
			'conditions' => array('Tvseries.status' => '1'),
			'order' => array('Tvseries.title_english' => 'ASC')
		);
		$TVSeries = $this->paginate('Tvseries');
		foreach($TVSeries as $record){
			$series[$record['Tvseries']['id']] = html_entity_decode(substr($record['Tvseries']['title_english'],0,35), ENT_QUOTES);
		}
		
		// Languages
		$languages = $this->Language->find('list');
		$this->set(compact('languages','categories','series'));
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
			// Set Data
			$this->Video->set($this->request->data);
			$this->VideoLanguage->set($this->request->data);
			
			// Array Declaration
			$err = array();
			
			// Check Validation for videos
			if (!$this->Video->validates(array('fieldList'=>array('video_url')))) {
				$err[] = $this->Video->validationErrors;
			}
				
			// Check Validation for video_languages
			if (!$this->VideoLanguage->validates()) {
				$err[] = $this->VideoLanguage->validationErrors;
			}
			
			if(count($err) == 0){
				
				// Clean the posted data 
				$this->request->data = Sanitize::clean($this->request->data);
				
				// Remove Spaces
				$video_url = $this->Common->trim($this->request->data['Video']['video_url']);
				
				// Store data after removing spaces from begining and end
				$this->request->data['Video']['video_url'] = $video_url;
				
				if($this->request->data['Video']['video_thumbnail']['error'] == 0){
				/* UPLOAD: video thumbnail(code starts). */
					//SET: the video thumbnail upload path on the server.
					$thumbnail_path = WWW_ROOT.'uploads/video/';
					//SET: the video thumbnail variable.
					$videoThumbnail = $this->request->data['Video']['video_thumbnail'];
					//GET: extention from the file name.
					$ext = explode('.',$videoThumbnail['name']);
					$ext = end($ext);
					//SET: the temp variables for the upload process.
					$fileName = date('YmdHis').'-thumb.'.$ext; 
					$fileTmpLoc = $videoThumbnail['tmp_name'];
					//CHECK: if the thumbnail is unable to upload then the set the response message.
					if(move_uploaded_file($fileTmpLoc, $thumbnail_path. $fileName)){ 
						$successText = 'The video has been saved'; 
					}
					$this->request->data['Video']['video_thumbnail'] = $fileName;
				/* UPLOAD: video thumbnail(code ends). */
				}else{ 
					$this->request->data['Video']['video_thumbnail'] = $this->request->data['Video']['old_thumbnail'];
				}
				
				
				if ($this->Video->save($this->request->data, array('validate'=>false))) {
					// Loop for storing/updating data in VideoLanguage table
					foreach($languages as $key => $value){
						$data = array();
						$videoLanguage_id = '';
						$title = '';
						$description = '';
						
						$title = $this->Common->removeSlashes($this->request->data['VideoLanguage']['title_'.$key]);
						$description = $this->Common->removeSlashes($this->request->data['VideoLanguage']['description_'.$key]);
						
						if(isset($this->request->data['VideoLanguage']['id_'.$key])){
							$videoLanguage_id = $this->request->data['VideoLanguage']['id_'.$key];
						}
						
						if(isset($videoLanguage_id) && !empty($videoLanguage_id)){
							// Edit
							$data['VideoLanguage']['video_id'] = $id;
							$data['VideoLanguage']['language_id'] = $key;
							$data['VideoLanguage']['title'] = $title;
							$data['VideoLanguage']['description'] = $description;
							$data['VideoLanguage']['id'] = $videoLanguage_id;
							
							$this->VideoLanguage->save($data, array('validate' => false));
						}else{
							// Add
							if(!empty($title) && !empty($description)){
								$data['VideoLanguage']['video_id'] = $id;
								$data['VideoLanguage']['language_id'] = $key;
								$data['VideoLanguage']['title'] = $title;
								$data['VideoLanguage']['description'] = $description;
								
								$this->VideoLanguage->create();
								$this->VideoLanguage->save($data, array('validate' => false));
							}elseif(!empty($title)){
								
								$data['VideoLanguage']['video_id'] = $id;
								$data['VideoLanguage']['language_id'] = $key;
								$data['VideoLanguage']['title'] = $title;
								
								$this->VideoLanguage->create();
								$this->VideoLanguage->save($data, array('validate' => false));
								
							}elseif(!empty($description)){
								
								$data['VideoLanguage']['video_id'] = $id;
								$data['VideoLanguage']['language_id'] = $key;
								$data['VideoLanguage']['description'] = $description;
								
								$this->VideoLanguage->create();
								$this->VideoLanguage->save($data, array('validate' => false));
								
							}
						}
					}

					// Video Categories
					// Delete data
					if(!empty($this->request->data['VideoCategory']['category_id'])){	
						$this->VideoCategory->deleteAll(array('VideoCategory.video_id'=>$id), false);
						$result = array();
						foreach($this->request->data['VideoCategory']['category_id'] as $k => $v){
							$result[] = array('VideoCategory'=>array('video_id'=>$id, 'category_id'=>$v));
						}
						$this->VideoCategory->saveMany($result, array('validate' => false));
					}else{
						$this->VideoCategory->deleteAll(array('VideoCategory.video_id'=>$id), false);
					}
					
					// Video Tvseries
					// Delete data
					
					if(!empty($this->request->data['VideoTvseries']['tvseries_id'])){	
						$this->VideoTvseries->deleteAll(array('VideoTvseries.video_id'=>$id), false);
						$result = array();
						$v = $this->request->data['VideoTvseries']['tvseries_id'];
						$result = array('VideoTvseries'=>array('video_id'=>$id, 'tvseries_id'=>$v));
						$this->VideoTvseries->saveMany($result, array('validate' => false));
					}else{
						$this->VideoTvseries->deleteAll(array('VideoTvseries.video_id'=>$id), false);
					}
					
					$this->Session->setFlash(__('The video has been saved'));
					$this->redirect(array('controller'=>'videos', 'action'=>'admin_index'));
				} else {
					$this->Session->setFlash(__('The video could not be saved. Please, try again.'));
				}
					
			}
		} else {
			$arrData = array();
			$datas = $this->Video->read(null, $id);
			$arrData['Video']['director'] = html_entity_decode($datas['Video']['director'], ENT_QUOTES); 
			$arrData['Video']['video_url'] = $datas['Video']['video_url']; 
			$arrData['Video']['video_duration'] = $datas['Video']['video_duration']; 
			$arrData['Video']['video_thumbnail'] = $datas['Video']['video_thumbnail']; 
			foreach($datas['VideoCategory'] as $videoCategories){
				$arrData['VideoCategory']['id'][] = $videoCategories['id']; 
				$arrData['VideoCategory']['category_id'][] = $videoCategories['category_id']; 
			}
			foreach($datas['VideoTvseries'] as $videoSeries){
				$arrData['VideoTvseries']['id'][] = $videoSeries['id']; 
				$arrData['VideoTvseries']['tvseries_id'][] = $videoSeries['tvseries_id']; 
			}
			foreach($datas['VideoLanguage'] as $videoLanguages){
				$arrData['VideoLanguage']['id_'.$videoLanguages['language_id']] = $videoLanguages['id'];
				if($videoLanguages['language_id'] == 'en'){
					$arrData['VideoLanguage']['title_'.$videoLanguages['language_id']] = html_entity_decode($videoLanguages['title'], ENT_QUOTES);
					$arrData['VideoLanguage']['description_'.$videoLanguages['language_id']] = html_entity_decode($videoLanguages['description'], ENT_QUOTES);
				}else{
					$arrData['VideoLanguage']['title_'.$videoLanguages['language_id']] = html_entity_decode($videoLanguages['title'], ENT_QUOTES, 'UTF-8');
					$arrData['VideoLanguage']['description_'.$videoLanguages['language_id']] = html_entity_decode($videoLanguages['description'], ENT_QUOTES, 'UTF-8');
				}
			}
			$this->request->data = $arrData;
		}
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','video');
		$this->set('title_for_layout',SITE_NAME.' : Edit Related Videos');
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
		$this->Video->id = $id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		
		$data = array();
		$data['Video']['status'] = 1;
		$data['Video']['id'] = $id;
		
		if ($this->Video->save($data, array('validate'=>false))) {
			$this->Session->setFlash(__('Video deleted successfully'));
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash(__('Video was not deleted'));
		$this->redirect(array('action' => 'admin_index'));
	}	
	public function admin_activate($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Video->id = $id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		
		$data = array();
		$data['Video']['status'] = 0;
		$data['Video']['id'] = $id;
		
		if ($this->Video->save($data, array('validate'=>false))) {
			$this->Session->setFlash(__('Video activated successfully'));
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash(__('Video was not activated'));
		$this->redirect(array('action' => 'admin_index'));
	}	

/**
 * Ajax Admin director listing method
 *
 * @return void
 */
	public function admin_director_listing() {
	
		$videos = $this->Video->find('all',array(
													'conditions'=>array(),
													'recursive' => 0,
													'fields' => array('Video.director'),
													'group' => array('Video.director')
												)
									);
		$this->set('videos',$videos);
	}	
	
}
