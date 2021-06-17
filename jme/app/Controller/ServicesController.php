<?php
App::uses('Sanitize', 'Utility');
App::uses('AppController', 'Controller');
/**
 * Services Controller
 *
 */
class ServicesController extends AppController {

/**
 * Model name
 *
 * @var array
 */
public $uses = array('Category', 'Device', 'Favourite', 'Vote', 'CategoryLanguage', 'VideoCategory', 'VideoRelate', 'Video', 'Language', 'StaticField', 'LanguageStaticField', 'VideoLanguage', 'Tvseries','VideoTvseries', 'Banner', 'RefreshRate');


/**
 * Component name
 *
 * @var array
 */	
	public $components = array('Common');


/**
 * Get categories method
 *
 * @return void
 */
	public function get_categories($language_id = null) {
		$CategoryLanguages = $this->CategoryLanguage->find('all',array('conditions'=>array('CategoryLanguage.language_id'=>$language_id, 'Category.status'=>0),'order'=>array('CategoryLanguage.name'=>'ASC')));
		$this->set('categoryLanguages', $CategoryLanguages);
	}	

/**
 * Device add method
 *
 * @return void
 */
	public function device($language_id = null, $device_id = null) {
		
		$device = $this->Device->find('first',array('conditions'=>array('Device.device'=>$device_id)));
		if(count($device) > 0){
			
			$this->request->data['Device']['preferred_language'] = $language_id;
			$this->request->data['Device']['id'] = $device['Device']['id'];
			if ($this->Device->save($this->request->data)) {
				// Device Data
				$deviceData = $this->Device->find('first',array('conditions'=>array('Device.device'=>$device_id)));
				$this->set('device',$deviceData);
				
				// Static Data
				$staticFieldData = $this->StaticField->find('first', array('conditions'=>array('StaticField.language_id'=>$language_id)));
				
				$this->set('staticField',$staticFieldData);
				
				// Language Static Data
				$languageStaticFields = $this->LanguageStaticField->find('all', array('conditions'=>array('LanguageStaticField.language_id'=>$language_id)));
				$this->set('languageStaticFields',$languageStaticFields);
				$this->set('flag', true);
			}else {
				$this->set('flag', false);
			}
		}else{
			$this->request->data['Device']['device'] = $device_id;
			$this->request->data['Device']['preferred_language'] = $language_id;
			$this->request->data = Sanitize::clean($this->request->data);
			
			$this->Device->create();
			if ($this->Device->save($this->request->data)) {
				// Device Data
				$deviceData = $this->Device->find('first',array('conditions'=>array('Device.device'=>$device_id)));
				$this->set('device',$deviceData);
				
				// Static Data
				$staticFieldData = $this->StaticField->find('first', array('conditions'=>array('StaticField.language_id'=>$language_id)));
				$this->set('staticField',$staticFieldData);
				
				// Language Static Data
				$languageStaticFields = $this->LanguageStaticField->find('all', array('conditions'=>array('LanguageStaticField.language_id'=>$language_id)));
				$this->set('languageStaticFields',$languageStaticFields);
				$this->set('flag', true);
			} else {
				$this->set('flag', false);
			}
		}
	}
	
/**
 * Favourite add method
 *
 * @return void
 */
	public function add_favourite($video_id = null, $language_id = null, $device_id = null) {

		$favourite = $this->Favourite->find('first',array('conditions'=>array('Favourite.device'=>$device_id, 'Favourite.video_id'=>$video_id)));
		if(count($favourite) > 0){
			$Video = $this->Video->find('first',array('conditions'=>array('Video.id'=>$video_id, 'Video.status'=>0), 'recursive'=>3));
			$this->set('video',$Video);
			$this->set('device_id',$device_id);
			$this->set('language_id',$language_id);
		}else{
			$this->request->data['Favourite']['device'] = $device_id;
			$this->request->data['Favourite']['video_id'] = $video_id;
			$this->request->data = Sanitize::clean($this->request->data);
			
			$this->Favourite->create();
			if ($this->Favourite->save($this->request->data)) {
				$Video = $this->Video->find('first',array('conditions'=>array('Video.id'=>$video_id, 'Video.status'=>0), 'recursive'=>3));
				$this->set('video',$Video);
				$this->set('device_id',$device_id);
				$this->set('language_id',$language_id);
			}
		}
		$this->render('favourite');
	}

/**
 * Favourite delete method
 *
 * @return void
 */
	public function delete_favourite($video_id = null, $language_id = null, $device_id = null) {

		$favourite = $this->Favourite->find('first',array('conditions'=>array('Favourite.device'=>$device_id, 'Favourite.video_id'=>$video_id)));
		if(count($favourite) > 0){
			
			$this->Favourite->id = $favourite['Favourite']['id'];
			if ($this->Favourite->delete()) {
				$Video = $this->Video->find('first', array('conditions'=>array('Video.id'=>$video_id, 'Video.status'=>0), 'recursive' => 3));
				$this->set('video',$Video);
				$this->set('device_id',$device_id);
				$this->set('language_id',$language_id);
			}
		}
		$this->render('favourite');
	}	
	
/**
 * Vote add method
 *
 * @return void
 */
	public function vote($video_id = null, $language_id = null, $device_id = null) {
	
		$vote = $this->Vote->find('first',array('conditions'=>array('Vote.device'=>$device_id, 'Vote.video_id'=>$video_id)));
		if(count($vote) > 0){
			$Video = $this->Video->find('first',array('conditions'=>array('Video.id'=>$video_id, 'Video.status'=>0),'recursive'=>3));
			$this->set('video',$Video);
			$this->set('device_id',$device_id);
			$this->set('language_id',$language_id);
		}else{
			$this->request->data['Vote']['device'] = $device_id;
			$this->request->data['Vote']['video_id'] = $video_id;
			$this->request->data = Sanitize::clean($this->request->data);
			
			$this->Vote->create();
			if ($this->Vote->save($this->request->data)) {
				$Video = $this->Video->find('first',array('conditions'=>array('Video.id'=>$video_id, 'Video.status'=>0),'recursive'=>3));
				$this->set('video',$Video);
				$this->set('device_id',$device_id);
				$this->set('language_id',$language_id);
			}
		}
	}	
	
/**
 * Get videos by category method
 *
 * @return void
 */
	public function get_category_videos($category_id = null, $language_id = null, $device_id = null, $keyword = null) {
		$keyword = urldecode($keyword);
		$conditions = array();
		if(!empty($keyword)){
			$conditions = array("((((SELECT title_english FROM `videos` v LEFT JOIN video_tvseries vt ON v.id = vt.video_id LEFT JOIN tvseries t ON t.id = vt.tvseries_id WHERE v.id = Video.id) LIKE '%".$this->Common->trim($keyword)."%' OR VideoLanguage.title LIKE '%".$this->Common->trim($keyword)."%') AND VideoLanguage.language_id = '".$language_id."') OR (((SELECT title_english FROM `videos` v LEFT JOIN video_tvseries vt ON v.id = vt.video_id LEFT JOIN tvseries t ON t.id = vt.tvseries_id WHERE v.id = Video.id) LIKE '%".$this->Common->trim($keyword)."%' OR VideoLanguage.title LIKE '%".$this->Common->trim($keyword)."%') AND VideoLanguage.language_id = 'en'))",'VideoCategory.category_id'=>$category_id, 'Video.status'=>0);
		}else{
			$conditions = array("(VideoLanguage.language_id = '".$language_id."' OR VideoLanguage.language_id = 'en')", 'VideoCategory.category_id'=>$category_id, 'Video.status'=>0);
		}
		
		$this->VideoCategory->bindModel(
			array('hasMany' => array(
					'CategoryLanguage' => array(
						'className' => 'CategoryLanguage',
						'foreignKey' => false,
						'finderQuery' => 'SELECT * FROM category_languages as CategoryLanguage WHERE CategoryLanguage.language_id= "'.$language_id.'" And CategoryLanguage.category_id = '.$category_id
					)	
				)
			)
		);
		
		$this->VideoCategory->recursive = 2;
		$this->Category->virtualFields = array('name'=> "SELECT category_languages.name FROM category_languages WHERE category_languages.language_id = '".$language_id."' AND category_languages.category_id = Category.id");
		$this->paginate = array(
			'joins' => array(
				array(
					'alias' => 'VideoLanguage',
					'table' => 'video_languages',
					'type' => 'INNER',
					'conditions' => 'VideoCategory.video_id = VideoLanguage.video_id'
				)
			),
			'conditions' => $conditions,
			'limit' => PAGE_LIMIT_LISTING,
			'group' => array('Video.id'),
			'order' => array('Video.created'=>'DESC')
		);
		$VideoCategories = $this->paginate('VideoCategory');
		
		// print_r($VideoCategories);exit;
		
		$this->set('videoCategories', $VideoCategories);
		$this->set('language_id', $language_id);
		$this->set('device_id', $device_id);
	}	
	
/**
 * Get series by category method
 *
 * @return void
 */
	public function get_category_series($category_id = null, $language_id = null, $device_id = null, $keyword = null) {
		$keyword = urldecode($keyword);
		$conditions = array();
		if(!empty($keyword)){
			$conditions = array("((((SELECT title_english FROM `videos` v LEFT JOIN video_tvseries vt ON v.id = vt.video_id LEFT JOIN tvseries t ON t.id = vt.tvseries_id WHERE v.id = Video.id) LIKE '%".$this->Common->trim($keyword)."%' OR VideoLanguage.title LIKE '%".$this->Common->trim($keyword)."%') AND VideoLanguage.language_id = '".$language_id."') OR (((SELECT title_english FROM `videos` v LEFT JOIN video_tvseries vt ON v.id = vt.video_id LEFT JOIN tvseries t ON t.id = vt.tvseries_id WHERE v.id = Video.id) LIKE '%".$this->Common->trim($keyword)."%' OR VideoLanguage.title LIKE '%".$this->Common->trim($keyword)."%') AND VideoLanguage.language_id = 'en'))",'VideoCategory.category_id'=>$category_id, 'Video.status'=>0);
		}else{
			$conditions = array("(VideoLanguage.language_id = '".$language_id."' OR VideoLanguage.language_id = 'en')", 'VideoCategory.category_id'=>$category_id, 'Video.status'=>0);
		}
		
		$this->VideoCategory->bindModel(
			array('hasMany' => array(
					'CategoryLanguage' => array(
						'className' => 'CategoryLanguage',
						'foreignKey' => false,
						'finderQuery' => 'SELECT * FROM category_languages as CategoryLanguage WHERE CategoryLanguage.language_id= "'.$language_id.'" And CategoryLanguage.category_id = '.$category_id
					)	
				)
			)
		);
		
		$this->VideoCategory->recursive = 3;
		$this->Category->virtualFields = array('name'=> "SELECT category_languages.name FROM category_languages WHERE category_languages.language_id = '".$language_id."' AND category_languages.category_id =".$category_id);
		$this->paginate = array(
			'joins' => array(
				array(
					'alias' => 'VideoLanguage',
					'table' => 'video_languages',
					'type' => 'INNER',
					'conditions' => 'VideoCategory.video_id = VideoLanguage.video_id'
				)
			),
			'conditions' => $conditions,
			'limit' => PAGE_LIMIT_LISTING,
			'group' => array('Video.id'),
			'order' => array('Video.created'=>'DESC')
		);
		$VideoCategories = $this->paginate('VideoCategory');
		$this->set('videoCategories', $VideoCategories);
		$this->set('language_id', $language_id);
		$this->set('device_id', $device_id);
	}	
	
/**
 * Get related videos method
 *
 * @return void
 */
	/* public function get_related_videos($video_id = null, $language_id = null, $device_id = null) {
		
		$video = $this->Video->find('first',array('conditions'=>array('Video.id'=>$video_id, 'Video.status'=>0)));
		if(count($video) > 0 && !empty($video)){
		
		//	$this->request->data['Video']['views'] = $video['Video']['views'] + 1;
			$this->request->data['Video']['id'] = $video['Video']['id'];
			if($this->Video->save($this->request->data, array('validate'=>false))){
				
				// Getting ids of all related videos of given video_id 
				$ids = array();
				$VideoRelates = $this->VideoRelate->find('all', array('conditions'=>array('VideoRelate.video_id'=>$video_id, 'Video.status'=>0)));
				foreach($VideoRelates as $VideoRelate){
					$ids[] = $VideoRelate['VideoRelate']['related_video'];
				}
				
				// Fetching all related videos data
				$this->Video->recursive = 2;
				$this->Category->virtualFields = array('name'=> "SELECT category_languages.name FROM category_languages WHERE category_languages.language_id = '".$language_id."' AND category_languages.category_id = Category.id");
				
				$videoRelates = $this->Video->find('all',array('conditions'=>array('Video.id'=>$ids)));
				$this->set('videoRelates', $videoRelates);
				$this->set('language_id', $language_id);
				$this->set('device_id', $device_id);
			}
		}
	}	 */
	
	public function get_related_videos($video_id = null, $language_id = null, $device_id = null) {
		
		$category_ids = array();
		$ctg='';
		if($language_id == null)					// if language is not known
			$language_id='en';						// then default language is english
		$video = $this->Video->find('first',array('conditions'=>array('Video.id'=>$video_id, 'Video.status'=>0)));
		if(count($video) > 0 && !empty($video)){
		
		//	$this->request->data['Video']['views'] = $video['Video']['views'] + 1;
			$this->request->data['Video']['id'] = $video['Video']['id'];
			if($this->Video->save($this->request->data, array('validate'=>false))){
				
				// Getting ids of all related videos of given video_id 
				$ids = array();
				$VideoRelates = $this->VideoRelate->find('all', array('conditions'=>array('VideoRelate.video_id'=>$video_id, 'Video.status'=>0)));
				//by  **start** // finding all the categories to which the video belongs
				$vid_categories = $this->VideoCategory->find('all',array('conditions'=>array('VideoCategory.video_id'=>$video_id),'fields'=>array('category_id')));
				if(count($vid_categories))
				{
					foreach($vid_categories as $category_id)
					{
						//$category_ids[]= $category_id['VideoCategory']['category_id'];
						$ctg .= $category_id['VideoCategory']['category_id'].' ,';
					}
					$ctg = substr($ctg,0,-1); // categories retrieved in string so that it can be passed to the sub-query//
					$sub_query = 'Select * from video_categories where category_id IN ('.$ctg.') AND video_id != '.$video_id.' group by video_id' ;
					$query = "SELECT Video.id FROM videos Video
							JOIN (".$sub_query."
							)A ON ( A.video_id = Video.id ) where Video.status = 0 ORDER BY Video.views DESC LIMIT 30";
				}
				else
				{
					$query = 'Select id from videos as Video where  Video.id != '.$video_id.' AND Video.status = 0 ORDER BY Video.views DESC LIMIT 30' ;
					
				}
				 
				//pr($language_id);
				
				
				
				$results = $this->Video->query($query);
				 
				//  **end** //
				foreach($results as $result){
					$ids[] = $result['Video']['id'];
				}
			   
				/*	foreach($VideoRelates as $VideoRelate){
						$ids[] = $VideoRelate['VideoRelate']['related_video'];
					}
				*/
				
				// Fetching all related videos data
				$this->Video->recursive = 2;
				$this->Category->virtualFields = array('name'=> "SELECT category_languages.name FROM category_languages WHERE category_languages.language_id = '".$language_id."' AND category_languages.category_id = Category.id");
				
				$videoRelates = $this->Video->find('all',array('conditions'=>array('Video.id'=>$ids),'order'=>array('Video.views'=>'DESC')));
				
				$this->set('videoRelates', $videoRelates);
				$this->set('language_id', $language_id);
				$this->set('device_id', $device_id);
			}
		}
	}	

/**
 * Get favourite videos method
 *
 * @return void
 */
	public function get_favourite_videos($language_id = null, $device_id = null, $keyword = null) {
		$keyword = urldecode($keyword);
		$conditions = array();
		if(!empty($keyword)){
			$conditions = array("((SELECT title_english FROM `videos` v LEFT JOIN video_tvseries vt ON v.id = vt.video_id LEFT JOIN tvseries t ON t.id = vt.tvseries_id WHERE v.id = Video.id) LIKE '%".$this->Common->trim($keyword)."%' OR VideoLanguage.title LIKE '%".$this->Common->trim($keyword)."%') AND (VideoLanguage.language_id = '".$language_id."' OR VideoLanguage.language_id = 'en')",'Favourite.device'=>$device_id, 'Video.status'=>0);
		}else{
			$conditions = array("(VideoLanguage.language_id = '".$language_id."' OR VideoLanguage.language_id = 'en')", 'Favourite.device'=>$device_id, 'Video.status'=>0);
		}
		
		$this->Favourite->recursive = 2;
		$this->Category->virtualFields = array('name'=> "SELECT category_languages.name FROM category_languages WHERE category_languages.language_id = '".$language_id."' AND category_languages.category_id = Category.id");
		$this->paginate = array(
			'joins' => array(
				array(
					'alias' => 'VideoLanguage',
					'table' => 'video_languages',
					'type' => 'INNER',
					'conditions' => 'Favourite.video_id = VideoLanguage.video_id'
				)
			),
			'conditions' => $conditions,
			'limit' => PAGE_LIMIT_LISTING,
			'group' => array('Favourite.video_id'),
			'order' => array('Favourite.created'=>'DESC')
		);
		$favourites = $this->paginate('Favourite');
		
		$this->set('favourites', $favourites);
		$this->set('language_id', $language_id);
		$this->set('device_id', $device_id);
	}	

/**
 * Get languages method
 *
 * @return void
 */
	public function get_languages() {
		$languages = $this->Language->find('all', array('recursive'=>0,'order' => array('created' => 'asc')));
		$this->set('languages',$languages);
	}
	
/**
 * Get popoluar videos method
 *
 * @return void
 */
	public function get_popular_videos($language_id = null, $device_id = null, $keyword = null) {
		$keyword = urldecode($keyword);
		/*
		$this->Video->recursive = 2;
		$this->Category->virtualFields = array('name'=> "SELECT category_languages.name FROM category_languages WHERE category_languages.language_id = '".$language_id."' AND category_languages.category_id = Category.id");
		$this->paginate = array(
			// 'conditions' => array('Video.status'=>0),
			'conditions' => $conditions,
			'limit' => PAGE_LIMIT_LISTING,
			'order' => array('Video.views'=>'DESC')
		);
		$videos = $this->paginate('Video');
		$this->set('videoLanguages',$videos);
		$this->set('language_id', $language_id);
		$this->set('device_id', $device_id);
		*/
		
		$conditions = array();
 		if(!empty($keyword)){
			$conditions = array("((((SELECT title_english FROM `videos` v LEFT JOIN video_tvseries vt ON v.id = vt.video_id LEFT JOIN tvseries t ON t.id = vt.tvseries_id WHERE v.id = Video.id) LIKE '%".$this->Common->trim($keyword)."%' OR VideoLanguage.title LIKE '%".$this->Common->trim($keyword)."%') AND VideoLanguage.language_id = '".$language_id."') OR (((SELECT title_english FROM `videos` v LEFT JOIN video_tvseries vt ON v.id = vt.video_id LEFT JOIN tvseries t ON t.id = vt.tvseries_id WHERE v.id = Video.id) LIKE '%".$this->Common->trim($keyword)."%' OR VideoLanguage.title LIKE '%".$this->Common->trim($keyword)."%') AND VideoLanguage.language_id = 'en'))",'Video.status'=>0);
		}else{
			
			$conditions = array("(VideoLanguage.language_id = '".$language_id."')", 'Video.status'=>0);
		}
 		
		$this->VideoLanguage->recursive = 3;
		$this->Category->virtualFields = array('name'=> "SELECT category_languages.name FROM category_languages WHERE category_languages.language_id = '".$language_id."' AND category_languages.category_id = Category.id");
		$this->paginate = array(
			'conditions' => $conditions,
			'limit' => PAGE_LIMIT_LISTING,
			'group' => array('VideoLanguage.video_id'),
			'order' => array('Video.video_views'=>'DESC')
		);
		$videoLanguages = $this->paginate('VideoLanguage');
		
		$this->set('videoLanguages',$videoLanguages);
		$this->set('language_id', $language_id);
		$this->set('device_id', $device_id);
	}	
	
/**
 * Get new videos method
 *
 * @return void
 */
	public function get_new_videos($language_id = null, $device_id = null) {
		
		$this->Video->recursive = 2;
		$this->Category->virtualFields = array('name'=> "SELECT category_languages.name FROM category_languages WHERE category_languages.language_id = '".$language_id."' AND category_languages.category_id = Category.id");
		$this->paginate = array(
			'conditions' => array('Video.status'=>0),
			'limit' => PAGE_LIMIT_NEWVIDEOS,
			'order' => array('Video.created'=>'DESC')
		);
		$videos = $this->paginate('Video');
		$this->set('videos',$videos);
		$this->set('language_id', $language_id);
		$this->set('device_id', $device_id);
		//$this->device(($language_id,$device_id);
		if(!empty($device_id) && strlen($device_id) > 0){
			$device = $this->Device->find('first',array('conditions'=>array('Device.device'=>$device_id)));
			if(count($device) > 0){
						if ($this->Device->save($this->request->data)) {
							$flag = true;	
						}else {
							$flag = false;	
						}
			}else{
					$this->request->data['Device']['device'] = $device_id;
					$this->request->data['Device']['preferred_language'] = $language_id;
					$this->request->data = Sanitize::clean($this->request->data);
					
					$this->Device->create();
					if ($this->Device->save($this->request->data)) {
						$flag = true;	
					} else {
						$flag = false;
					}
			}
		}

	}
/**
 * Get tv series method
 *
 * @return void
 */
	public function get_tv_series($language_id = null) {
		$this->Tvseries->recursive = 0;
		$this->paginate = array(
			'conditions' => array('Tvseries.status'=>'1'),
			'order' => array('Tvseries.created'=>'DESC')
		);
		$tvseries = $this->paginate('Tvseries');
		$this->set('tvseries',$tvseries);
		$this->set('language_id',$language_id);
	}

/**
 * Get tv series videos list method
 *
 * @return void
 */
/*  	public function get_tv_series_videos($series_id = null, $language_id = null, $device_id = null, $page=null, $keyword=null	) {
		
		$conditions = array();
		if(!empty($keyword)){
			$conditions = array("(SELECT title FROM  `tvseries` ts LEFT JOIN video_tvseries vts ON vts.video_id = ts.id LEFT JOIN video_languages vl ON vl.video_id = vts.video_id LEFT JOIN videos v ON v.id = vts.video_id WHERE ts.id =".$series_id." AND ts.status = 1) LIKE  '%".$keyword."%'");
		}
		
		if(!empty($page)){
			$offset = ($page-1) * 10;
		}

		$this->Tvseries->bindModel(
			array('hasMany' => array(
					'VideoTvseries' => array(
						'className' => 'VideoTvseries',
						'dependent' => true,
						'limit' => 10,
						'offset' => $offset
					)
				)
			)
		);

		$this->Tvseries->recursive = 2;
		$tvseries = $this->Tvseries->find('all');
		
		$this->set('tvseries',$tvseries);
		$this->set('device_id',$device_id);
	}
 */	
   	public function get_tv_series_videos($series_id = null, $language_id = null, $device_id = null, $page=null, $keyword=null	) {
		$keyword = urldecode($keyword);
		$conditions = array();
		
		if(!empty($page)){
			$offset = ($page-1) * 10;
		}
		
		$arr = $arr2 = array();
		
		$arr = $this->VideoTvseries->find('all',array('conditions' => array('VideoTvseries.video_title LIKE' => "%".$keyword."%",'VideoTvseries.tvseries_id' => $series_id),'fields' => array('VideoTvseries.video_id')));
		if(count($arr) > 0){$arr = Set::extract($arr,'{n}.VideoTvseries.video_id');}
		
		
		$seriesCond = array('Tvseries.title_english LIKE' => "%".$keyword."%",'Tvseries.id' => $series_id);
		if($language_id == 'en'){ $seriesCond = array('Tvseries.title_english LIKE' => "%".$keyword."%",'Tvseries.id' => $series_id); }
		elseif($language_id == 'fr'){ $seriesCond = array('Tvseries.title_french LIKE' => "%".$keyword."%",'Tvseries.id' => $series_id); }
		elseif($language_id == 'es'){ $seriesCond = array('Tvseries.title_spanish LIKE' => "%".$keyword."%",'Tvseries.id' => $series_id); }
		
		
		$arr2 = $this->Tvseries->find('all',array('conditions' => $seriesCond));
		if(count($arr2) > 0){$arr2 = Set::extract($arr2,'{n}.VideoTvseries.{n}.id');$arr2 = array_values($arr2[0]);}

		// $arr = array_unique(array_merge($arr,$arr2));
		$arr = array_merge($arr,$arr2);
		
		$this->set('vids',$arr);
		
		if(count($arr) == 1){ array('VideoTvseries.id' => $arr); }else{ $conditions = array('VideoTvseries.id IN' => $arr); }
		
		if(count($arr) > 0){
			$this->Tvseries->bindModel(
				array('hasMany' => array(
						'VideoTvseries' => array(
							'className' => 'VideoTvseries',
							'dependent' => true,
							'limit' => 10,
							'offset' => $offset,
							'conditions' => $conditions
						)
					)
				)
			);

			$this->Tvseries->recursive = 3;
			// $tvseries = $this->Tvseries->find('all',array('conditions'=>array('Tvseries.id'=>$series_id)));
			$tvseries = $this->Tvseries->find('all',array('conditions'=>array('Tvseries.id'=>$series_id)));
			
			$this->set('tvseries',$tvseries);

			
		}else{ $this->set('tvseries',array()); }
		
		$this->set('device_id',$device_id);
		$this->set('language_id',$language_id);
	}
 
/**
 * Get tv series videos list method
 *
 * @return void
 */
	public function get_related_series_videos($video_id,$language_id = null) {
		$video_ids = $cat_video_ids = array();
		//GET: the tvseries ID according to the video ID
		$tvseries_id = $this->VideoTvseries->find('first',array(
			'conditions' => array('VideoTvseries.video_id' => $video_id),
			'fields' => array('VideoTvseries.tvseries_id')
		));
		if(!empty($tvseries_id['VideoTvseries']['tvseries_id'])){		//CONDITION: tv series id in not be empty
			$tvseries_id = Set::extract($tvseries_id,'VideoTvseries');
			$tvseries_id = $tvseries_id['tvseries_id'];
			
			//GET: video ids which are related to the current tv series according to the tv series ID
			$video_ids = $this->VideoTvseries->find('all',array(
				'conditions' => array('VideoTvseries.tvseries_id' => $tvseries_id,'VideoTvseries.video_id !=' => $video_id),
				'fields' => array('VideoTvseries.video_id')
			));
			
			$total_videos = count($video_ids);	//COUNT: Total number of videos from the current video related series

			if($total_videos > 0){$video_ids = Set::extract($video_ids,'{n}.VideoTvseries.video_id');}else{ $video_ids = array(); }
			if( $total_videos <= 30 ){
				
				//CONDITION: If the number videos is less than 30 in the video related series then the rest videos will be fetched from thne related category of the current video
				$required_videos_count = 30 - $total_videos;	 
				
				//GET: the category ID of the current video
				$categories_ids = $this->VideoCategory->find('all',array(
					'conditions' => array('VideoCategory.video_id' => $video_id),
					'fields' => array('VideoCategory.category_id')
				));
				// $categories_ids = Set::extract($categories_ids,'{n}.VideoCategory');
				
				//CONDITION: the category ID is not to be empty
				if(!empty($categories_ids[0]['VideoCategory']['category_id'])){
					$categories_ids = Set::extract($categories_ids,'{n}.VideoCategory.category_id');
					foreach($categories_ids as $categories_id){
						// echo $categories_id.'---';
						//GET: video ids which are related to the current category
						$cat_video_ids = $this->VideoCategory->find('all',array(
							'conditions' => array('VideoCategory.category_id' => $categories_id,'VideoCategory.video_id !=' => $video_id),
							'fields' => array('VideoCategory.video_id')
						));
						if(count($cat_video_ids) > 0){$cat_video_ids = Set::extract($cat_video_ids,'{n}.VideoCategory.video_id');}
						$video_ids = array_merge($video_ids,$cat_video_ids);
					}
				}
			}
			$this->Video->recursive = 2;
			$videos = $this->Video->find('all',array('conditions'=>array('Video.id'=>$video_ids,'Video.status'=>0),'order'=>array('Video.created DESC')));
			$i = 0;
			
			if($language_id == null){
				$language_id = 'en';
			}
			
			if(count($videos) > 0){
				while($i < 30){
					foreach($videos as $key => $single_video){
						//Setting the TV series array variable in the Video array
						$series_name = $single_video['VideoTvseries'][0]['Tvseries']['title_english'];
						$videos[$key]['Video']['tvseries_name'] = ($series_name)?$series_name:"";
						
						//Setting the Categories array variable in the Video array
						$flag = true; $categories = '';
						
						foreach($single_video['VideoCategory'] as $category){
							
							// Fetch Data from Category Language
							$category_languages = $this->CategoryLanguage->find('all', array('conditions'=>array('CategoryLanguage.category_id'=>$category['category_id'], 'CategoryLanguage.language_id'=>$language_id)));
							foreach($category_languages as $category_language){
								if($flag){
									$categories = $category_language['CategoryLanguage']['name'].',';
									$flag = false;
								} else{
									$categories .= $category_language['CategoryLanguage']['name'].',';
								}
								
								
							}
							
							
						}
						
						$categories = substr($categories,0,-1);
						$videos[$key]['Video']['categories'] = ($categories)?$categories:"";
						$i++;
					}
				}
			}
			
			$this->set('videoRelates',$videos);
			$this->set('language_id',$language_id);
		}
	}

	/**Get the videos on the basis of Channels -> TV Series -> Videos(based upon the both channel and series ID) **/
   	public function get_channel_series_videos($channel_id = null, $series_id = null, $language_id = null, $keyword=null,  $page=null) {
		
		$keyword = urldecode($keyword);
		$conditions = array();
		
		if(!empty($page)){
			$offset = ($page-1) * 10;
		}
		$arr = $arr2 = array();
		
		$arr = $this->VideoCategory->find('all',array('conditions' => array('VideoCategory.category_id' => $channel_id),'fields' => array('VideoCategory.video_id')));
		if(count($arr) > 0){$arr = Set::extract($arr,'{n}.VideoCategory.video_id');}
		
		if(!empty($keyword)){
			$arrStr = implode("','",$arr);
			$arrVids = $this->VideoLanguage->query("SELECT * FROM video_languages WHERE (title LIKE '%".$keyword."%' OR description LIKE '%".$keyword."%') AND video_id IN ('".$arrStr."') AND language_id = '".$language_id."'");
			if(count($arrVids) > 0){$arrVids = Set::extract($arrVids,'{n}.video_languages.video_id');}
			
			$arr = $arrVids;
		}
		
		$this->set('vids',$arr);
		
	
		
		$arr = $this->VideoTvseries->find('all',array('conditions' => array('VideoTvseries.video_id' => $arr, 'VideoTvseries.tvseries_id' => $series_id,),'fields' => array('VideoTvseries.id')));
		if(count($arr) > 0){$arr = Set::extract($arr,'{n}.VideoTvseries.id');}
		
		
		if(count($arr) == 1){ array('VideoTvseries.id' => $arr); }else{ $conditions = array('VideoTvseries.id IN' => $arr); }
		
		if(count($arr) > 0){
			$this->Tvseries->bindModel(array('hasMany' => array('VideoTvseries' => array('className' => 'VideoTvseries','dependent' => true,'limit' => 10,'offset' => $offset,'conditions' => $conditions))));

			$this->Tvseries->recursive = 3;
			// $tvseries = $this->Tvseries->find('all',array('conditions'=>array('Tvseries.id'=>$series_id)));
			$tvseries = $this->Tvseries->find('all',array('conditions'=>array('Tvseries.id'=>$series_id)));
			$this->set('tvseries',$tvseries);
			
			//echo '<pre>'; print_r($tvseries);die;
			
		}else{ $this->set('tvseries',array()); }
		
		$this->set('device_id',$device_id);
		$this->set('language_id', $language_id);
	}
	
	//METHOD: to check the request method is POST or not.
	public function _requestMethodPost(){
		//CHECK: the request is POST or not.
		if ($_SERVER['REQUEST_METHOD'] != 'POST') { 
			//CREATE: json data.
			$this->_jsonEncode(1,'POST data required');
		}	
	}
	
	//METHOD: to create the output JSON.
	public function _jsonEncode($error, $message, $response=array()){
		echo json_encode(array('error' => $error, 'message' => $message, 'response' => $response)); exit;
	}
	
	//METHOD: if isset some particular index value.
	public function _isSet($data,$index){
		//CHECK: is the particular index is SET in the array or not.
		if(!isset($data[$index])){
			//RETURN: json encoded response with error message.
			$this->_jsonEncode(1,'GET data required ('.$index.')');
		}
	}
	
	//METHOD: if index value is empty then return error message.
	public function _isEmpty($data,$index,$message=null){
		//CHECK: is the particular index is SET in the array or not.
		if(empty($data[$index])){
			if(is_null($message)){
				//RETURN: json encoded response with error message.
				$this->_jsonEncode(1,'GET data required ('.$index.')');
			}else{
				//RETURN: json encoded response with error message.
				$this->_jsonEncode(1,$message);
			}
		}
	}
	
	//METHOD: to decode the data from the JSON format.
	public function _jsonDecode(){
		//CHECK: if data is submitted by the FORM or by JSON parameteres
		if(!empty($_POST['filledData'])){
			//DECODE: the POST data from form data to an array.
			$data = (array)json_decode($_POST['filledData']);
		}else{
			//GET: file contents from the POST data.
			$data = file_get_contents('php://input');
			//DECODE: the POST data from json format to an array.
			$data = (array)json_decode($data);
		}
		//CHECK: if count $data array is greater than 0.
		if(count($data)>0){ return $data; }
		//ELSE: the json response with error message.
		else{ $this->_jsonEncode(1,'GET data required'); }
	}
	
	/*
	 * METHOD: used to get the banners list.
	 * URL: http://mvp-mvpcvnet-dev.netsol.local/services/getBanners
	 * API METHOD: GET
	 * */
	public function getBanners(){
		//GET: banners list.
		$banners = $this->Banner->find('all',array('conditions'=>array('Banner.status'=>0),'order'=>array('Banner.id'=>'DESC')));
		$banners = Set::extract('{n}.Banner',$banners);
		//GET: refresh rate.
		$refreshRate = $this->RefreshRate->find('first');
		$refreshRate = Set::extract('RefreshRate',$refreshRate);
		$refreshRate = $refreshRate['refresh_rate'];
		//CREATE: a response array.
		$responsearray = array();
		$responsearray['refresh_rate'] = $refreshRate;
		$responsearray['banners'] = $banners;
		//ENCODE: the response in the json format.
		$this->_jsonEncode(0,'Banners List',$responsearray);
	}
	
	/*
	 * METHOD: used to update the views by 1 count with video id.
	 * URL: http://mvp-mvpcvnet-dev.netsol.local/services/updateVideoViews/{video_id}
	 * API METHOD: GET
	 * */
	public function updateVideoViews($video_id){
		//CHECK: is the method of POST type or not.
		//$this->_requestMethodPost();
		//GET: the POST data in the form of an array.
		//$getData = $this->_jsonDecode();
		$getData['video_id'] = $video_id;
		//SET: an array with keys which have to check is set or not.
		$keys = array('video_id');
		//CHECK: is all the variables are set or not.
		foreach($keys as $key){ $this->_isSet($getData,$key); }
		foreach($keys as $key){ $this->_isEmpty($getData,$key); }
		//GET: video by id.
		$videoObj = $this->Video->find('first',array('conditions'=>array('Video.id'=>$getData['video_id'])));
		$videoObj = Set::extract('Video',$videoObj);
		$videoObj['video_views'] = $videoObj['video_views'] + 1;
		
		$this->Video->id = $videoObj['id'];
		if($this->Video->saveField('video_views', $videoObj['video_views'])){
			$this->_jsonEncode(0,'Views updated successfully!');
		}else{
			$this->_jsonEncode(1,'Something went wrong. Please try again later!');
		}
	}
	
}
