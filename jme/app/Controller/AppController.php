<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $components = array(
			'Session',
			'Auth' => array(
				'authenticate' => array('Form'=>array('fields'=>array('id'=>'id'))),
				'loginRedirect' => array('controller'=>'videos', 'action'=>'index', 'admin'=>true),
				'logoutRedirect' => array('controller'=>'users', 'action'=>'login', 'admin'=>true),
				'authError' => 'You cannot access this page',
				'authorize' => array('Controller') // Added this line
			)
		);
		
	public function isAuthorized($user) {
		// Admin can access every action
		if (isset($user['type']) && $user['type'] == 0) {
			return true;
		}

		// Default deny
		return false;
	}
	
	public function beforeFilter() {
//	0778ec8594542ba82575145298ed9ce6b366d5a2
		$this->Auth->allow('get_categories', 'device', 'add_favourite', 'delete_favourite', 'vote', 'get_category_videos', 'get_related_videos', 'get_favourite_videos', 'get_languages', 'get_popular_videos', 'get_new_videos', 'get_tv_series', 'get_tv_series_videos', 'get_related_series_videos','get_channel_series_videos','get_category_series', 'getBanners','updateVideoViews','forgot');
    }
	
	public function beforeRender() {
		/* if($this->name == 'CakeError') {
			$this->layout = 'error';
		} */
	}

	public function sendEmail($mailData,$sub,$template)
    { 
        $response = array();
        $subject = $sub;
        $to = $mailData['email'];
       	App::uses('CakeEmail', 'Network/Email'); 
        $Email = new CakeEmail('smtp');
        //$Email = new CakeEmail('default');
        try
        {
            $from = 'info@logosent.net';
            $Email->from(array($from => 'Logosent Support'));
            $Email->replyTo('info@logosent.net');
            $Email->to($to);
            //$Email->bcc($bcc,$bcc1);
            $Email->subject($subject);
            $Email->template($template);
            $Email->emailFormat('html');
            $Email->viewVars(array('data' => $mailData));
            if($Email->send())
            	return true;
            else
            	return false;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

}
