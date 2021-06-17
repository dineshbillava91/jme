<?php
App::uses('Sanitize', 'Utility');
App::uses('AppController', 'Controller');
/**
 * VideoRelates Controller
 *
 * @property VideoRelate $VideoRelate
 */
class VideoRelatesController extends AppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array('VideoRelate', 'CategoryLanguage', 'VideoCategory', 'VideoLanguage', 'Video');

/**
 * Component name
 *
 * @var array
 */	
	public $components = array('Common');	
	
/**
 * Admin add related videos method
 *
 * @return void
 */
	public function admin_add($video_id = null) {
		$this->Video->id = $video_id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		$this->set('video_id', $video_id);
		
		// Save Data
		if ($this->request->is('post')) {
			if(!empty($this->request->data['VideoRelate']['related_video_ids'])){
				
				// Variable Declaration
				$relatedVideoIds = '';
				
				// Explode the value with , and store it in array form in relatedVideoIds
				$relatedVideoIds = explode(',',$this->request->data['VideoRelate']['related_video_ids']);
				
				/// Loop to access the array values
				foreach($relatedVideoIds as $key => $value){
					$data[] = array('VideoRelate'=>array('video_id'=>$video_id, 'related_video'=>$value));
				}			
				if($this->VideoRelate->saveMany($data)){
					$this->Session->setFlash(__('The video has been saved'));
				}else{
					$this->Session->setFlash(__('Could not relate the selected videos.Please try again.'));
				}
			}
			
			$this->redirect(array('controller'=>'videos', 'action'=>'admin_index'));
		}
	
		// Categories listing
		$categories = array();
		$categoryLanguages = $this->CategoryLanguage->find('all', array('conditions'=>array('CategoryLanguage.language_id'=>'en','Category.status'=>0)));
		if(!empty($categoryLanguages) && count($categoryLanguages) > 0){	
			$categories['no_category'] = 'No Category';
			foreach($categoryLanguages as $categoryLanguage){
				$categories[$categoryLanguage['Category']['id']] = html_entity_decode($categoryLanguage['CategoryLanguage']['name'], ENT_QUOTES);
			}
		}
		$this->set(compact('categories'));
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','video');
		$this->set('title_for_layout',SITE_NAME.' : Manage Related Videos');
	}
	
/**
 * Admin edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($video_id = null) {
		$this->Video->id = $video_id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		$this->set('video_id', $video_id);
		
		if ($this->request->is('post') || $this->request->is('put')) {
			if(!empty($this->request->data['VideoRelate']['related_video_ids'])){
				
				// Variable Declaration
				$relatedVideoIds = '';
				
				// Explode the value with , and store it in array form in relatedVideoIds
				$relatedVideoIds = explode(',',$this->request->data['VideoRelate']['related_video_ids']);
				
				// Delete data
				$this->VideoRelate->deleteAll(array('VideoRelate.video_id'=>$video_id), false);
				
				// Loop to access the array values
				foreach($relatedVideoIds as $key => $value){
					$data[] = array('VideoRelate'=>array('video_id'=>$video_id, 'related_video'=>$value));
				}		
				if($this->VideoRelate->saveMany($data)){
					$this->Session->setFlash(__('The video has been saved'));
				}else{
					$this->Session->setFlash(__('Could not relate the selected videos.Please try again.'));
				}
			}
			
			$this->redirect(array('controller'=>'videos', 'action'=>'admin_index'));
		}
	
		// Related Videos IDS
		$ids = array();
		$videoRelates = $this->VideoRelate->find('all', array('conditions'=>array('VideoRelate.video_id'=>$video_id,'Video.status'=>0)));
		foreach($videoRelates as $videoRelate){
			$ids[] = $videoRelate['VideoRelate']['related_video'];
		}
	
		// Related Videos listing
		$related_videos = array();
		$relatedVideoLanguages = $this->VideoLanguage->find('all', array('conditions'=>array('VideoLanguage.language_id'=>'en', 'Video.id'=>$ids, 'Video.status'=>0),'order'=>array('VideoLanguage.title'=>'ASC')));
		if(!empty($relatedVideoLanguages) && count($relatedVideoLanguages) > 0){	
			foreach($relatedVideoLanguages as $relatedVideoLanguage){
				$related_videos[$relatedVideoLanguage['Video']['id']] = html_entity_decode(substr($relatedVideoLanguage['VideoLanguage']['title'],0,30), ENT_QUOTES);
			}
		}
		
		// Categories listing
		$categories = array();
		$categoryLanguages = $this->CategoryLanguage->find('all', array('conditions'=>array('CategoryLanguage.language_id'=>'en','Category.status'=>0)));
		if(!empty($categoryLanguages) && count($categoryLanguages) > 0){	
			$categories['no_category'] = 'No Category';
			foreach($categoryLanguages as $categoryLanguage){
				$categories[$categoryLanguage['Category']['id']] = html_entity_decode($categoryLanguage['CategoryLanguage']['name'], ENT_QUOTES);
			}
		}
		$this->set(compact('categories', 'related_videos'));
		$this->set('id',$this->Auth->user('id'));
		$this->set('selected_tab','video');
		$this->set('title_for_layout',SITE_NAME.' : Manage Related Videos');
	}	
		
/**
 * Ajax Admin Select Videos list method
 *
 * @return void
 */	
	public function admin_select_videos_list(){
		
		// Variable declaration
		$flag = false;
		
		// Store Video_id in variable
		$video_id = $this->request->data['Video']['id'];
		
		// Storing values in variable
		$director = '';
		$category_id = '';
		if(!empty($this->request->data['VideoRelate']['director']) || !empty($this->request->data['VideoRelate']['category_id'])){
			$director = $this->Common->trim(Sanitize::clean($this->request->data['VideoRelate']['director']));
			$category_id = $this->request->data['VideoRelate']['category_id'];
		}
		
		// Array declaration
		$arrIds = array();
		$conditions = array();
		
		// Array Declaration and explode the values
		$relatedIds = array();
		if(!empty($this->request->data['VideoRelate']['related_video_ids'])){
			$relatedIds = explode(',',$this->request->data['VideoRelate']['related_video_ids']);
		}
		
		// Conditions based on selected values
		if(!empty($director) && !empty($category_id)){
			if(is_numeric($category_id) && $category_id > 0){
				$conditions = array("Video.director LIKE '%".$director."%'",'VideoCategory.category_id'=>$category_id,'Video.status'=>0);
			}else{
				$conditions = 'no_category';
				$flag = true;
			}
		}elseif(!empty($director)){
			$conditions = array("Video.director LIKE '%".$director."%'",'Video.status'=>0);
		}elseif(!empty($category_id)){
			if(is_numeric($category_id) && $category_id > 0){
				$conditions = array('VideoCategory.category_id'=>$category_id,'Video.status'=>0);
			}else{
				$conditions = 'no_category';
			}
		}
		
		if(!empty($conditions)){
			
			// Query to fetch desired data based on selected values
			if($conditions == 'no_category'){
				if($flag){
					// if director and category values provided
					$VideoCategories = $this->VideoCategory->query("SELECT id FROM videos as Video WHERE director LIKE '%".$director."%' AND status = 0 AND id NOT IN (SELECT video_id FROM video_categories)");
				}else{
					// if category value provided
					$VideoCategories = $this->VideoCategory->query("SELECT id FROM videos as Video WHERE status = 0 AND id NOT IN (SELECT video_id FROM video_categories)");
				}
			}else{
				$VideoCategories = $this->VideoCategory->find('all',array('conditions'=>$conditions));
			}
			
			foreach($VideoCategories as $VideoCategory){
				$arrIds[] = $VideoCategory['Video']['id'];
			}
			
			// Query to fetch data based on the selected video_id
			$this->VideoLanguage->recursive = 0;
			if(!empty($relatedIds)){	
				$this->paginate = array(
					'conditions' => array('VideoLanguage.video_id'=>$arrIds,'VideoLanguage.language_id'=>'en','Video.status'=>0,'Video.id !='=>$video_id, 'Video.id NOT'=>$relatedIds),
					'limit' => PAGE_LIMIT_RELATED,
					'order' => array('VideoLanguage.title'=>'ASC')
				);
			}else{
				$this->paginate = array(
					'conditions' => array('VideoLanguage.video_id'=>$arrIds,'VideoLanguage.language_id'=>'en','Video.status'=>0,'Video.id !='=>$video_id),
					'limit' => PAGE_LIMIT_RELATED,
					'order' => array('VideoLanguage.title'=>'ASC')
				);
			}
		
		}else{
		
			// Condition to check if relatedIds exist
			if(!empty($relatedIds)){
				// Yes fetch those videos which are not in related videos 
				$this->paginate = array(
					'conditions' => array('VideoLanguage.language_id'=>'en','Video.status'=>0,'Video.id !='=>$video_id,'Video.id NOT'=>$relatedIds),
					'limit' => PAGE_LIMIT_RELATED,
					'order' => array('VideoLanguage.title'=>'ASC')
				);
				
			}else{
				// No fetch videos
				$this->paginate = array(
					'conditions' => array('VideoLanguage.language_id'=>'en','Video.status'=>0,'Video.id !='=>$video_id),
					'limit' => PAGE_LIMIT_RELATED,
					'order' => array('VideoLanguage.title'=>'ASC')
				);
			}
		}
		$videoLanguages = $this->paginate('VideoLanguage');
		$this->set('videoLanguages', $videoLanguages);
	}	
	
}