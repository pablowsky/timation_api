<?php
class SendNotification{ 	
 	private $s_key;
	public function __construct($key){
		$this->s_key = $key;
	}
	
	public function sendPushNotificationToGCMSever($token, $data){
		
		//include_once 'config.php';
		
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array(
            'to' => $token,
            //'notification' => array('title' => 'Working Good', 'body' => 'That is all we want'),
            'data' => $data
        );
 
        $headers = array(
            'Authorization:key=' . $this->s_key,
            'Content-Type:application/json'
        );		
		$ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    
        $result = curl_exec($ch);
       
        curl_close($ch);

        return $result;
	}
}
?>