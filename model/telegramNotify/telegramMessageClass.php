<?php
	class TelegramNotify{

		private static function newMessage($chatID, $messaggio, $token) {
		    echo "sending message to " . $chatID . "\n";

		    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
		    $url = $url . "&text=" . urlencode($messaggio);
		    $ch = curl_init();
		    $optArray = array(
		            CURLOPT_URL => $url,
		            CURLOPT_RETURNTRANSFER => true
		    );
		    curl_setopt_array($ch, $optArray);
		    $result = curl_exec($ch);
		    curl_close($ch);
		    return $result;
		}

		public static function sendMessage($message){
			self::newMessage('354321697',$message,'755074052:AAHtZ_Bf0ieDSIKtKm_QlLrqfMEEnEYji94');
		}

	}



?>