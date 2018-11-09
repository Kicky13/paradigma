<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class sender extends CI_Controller {

   
    function __construct() {
        parent::__construct();
   		$this->load->model('m_send');
    }
    
    function index($target = null){
    	$getId = $_GET['id'];
    	$title = 'test notif';
		$message = 'Lorem ipsum';
		$id = array($getId);
		$data = array(
			'body' => $message,
		    'title' => "$title -> $getId",
			'badges' => 69,
			"image"=> "www/img/logo.png",
			"style" => "picture",
	        "picture" => "http://36.media.tumblr.com/c066cc2238103856c9ac506faa6f3bc2/tumblr_nmstmqtuo81tssmyno1_1280.jpg",
	        "summaryText" => "The internet is built on cat pictures",
	        "actions" => array(
	        		array( "icon"=> "emailGuests", "title"=> "EMAIL GUESTS", "callback"=> "app.emailGuests", "foreground"=> true),
	        		array("icon" => "snooze", "title" => "SNOOZE", "callback" => "app.snooze", "foreground" => false)

	        	)

			);
		$fields = array
		(
			'to' => '/topics/'.$getId,
		    'data'          => $data,
		    'priority' => 'high'
		    // 'notification' => array(
		    //     'body' => $message,
		    //     'title' => $title,
		    //     'sound' => 'default',
		    //     'icon' => 'icon'
		    // )
		);

		// if ($target==null) {
		// 	$fields['registration_ids'] = $id;
		// }else{
		// 	$fields['to'] = $getId;
		// }

		echo $this->sendPushNotification($fields);
    }

    function registeredId(){
    	$param['registeredId'] = $_POST['id'];
    	$param['nama'] = $_POST['nama'];

    	$result = $this->m_send->register($param);

    	echo $result;
    }

    function sendPushNotification($fields = array())
	{
	    $API_ACCESS_KEY = 'AIzaSyCAbp2hiuxSvzFHysn9ci06UVvdL6kOea0';
	    $headers = array
	    (
	        'Authorization: key=' . $API_ACCESS_KEY,
	        'Content-Type: application/json'
	    );
	    $ch = curl_init();
	    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	    curl_setopt( $ch,CURLOPT_POST, true );
	    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	    $result = curl_exec($ch );
	    curl_close( $ch );
	    return $result;
	}
}