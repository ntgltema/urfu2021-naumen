<?php
include_once 'vendor/autoload.php';
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/naumen.json');

	function GetUser($chat_id, $sql) {
		$params = [
			'telegram_id' => $chat_id,
		];
		return $sql->row('SELECT * FROM naumen_users WHERE telegram_id = :telegram_id', $params);
	}
	
	function AddUser($chat_id, $sql) {
		$params = [
			'telegram_id' => $chat_id,
			'time' => time()
		];
		return $sql->query('INSERT INTO naumen_users VALUES (0, :telegram_id, 0, :time, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null)', $params);
	}
	
	function ClearUser($chat_id, $sql) {
		$params = [
			'telegram_id' => $chat_id,
			'telegram_id1' => "-".$chat_id,
			
		];
		return $sql->query('UPDATE naumen_users SET telegram_id = :telegram_id1 WHERE telegram_id = :telegram_id', $params);
	}
	
	function SetMode($chat_id, $sql, $mode) {
		$params = [
			'telegram_id' => $chat_id,
			'mode' => $mode
		];
		return $sql->query('UPDATE naumen_users SET mode = :mode WHERE telegram_id = :telegram_id', $params);
	}
	
	function UpdateUser($chat_id, $sql) {
		$params = [
			'telegram_id' => $chat_id,
			'last_message' => time()
		];
		return $sql->query('UPDATE naumen_users SET last_message = :last_message WHERE telegram_id = :telegram_id', $params);
	}
	
	function SetData($chat_id, $field, $value, $sql) {
		$params = [
			'telegram_id' => $chat_id,
			'value' => $value,
		];
		return $sql->query('UPDATE naumen_users SET '.$field.' = :value WHERE telegram_id = :telegram_id', $params);
	}
	
	function GetTraineeTypes($city, $sql) {
		$params = [
			'city' => $city
		];
		return $sql->row('SELECT type, COUNT(type) FROM naumen_trainee WHERE city = :city and active = 1 GROUP BY type', $params);
	}
	
	function GetTrainees($type, $city, $sql) {
		$params = [
			'city' => $city,
			'type' => $type,
		];
		return $sql->row('SELECT * FROM naumen_trainee WHERE city = :city and active = 1 and type = :type', $params);
	}
	
	function GetTrainee($id, $sql) {
		$params = [
			'id' => $id,
		];
		return $sql->row('SELECT * FROM naumen_trainee WHERE id = :id', $params)[0];
	}
	
	function NextQuestion($chat_id, $sql) {
		$user = GetUser($chat_id, $sql)[0];
		foreach($user as $field => $value)
			if($value == null)
				return $field;
		return null;
	}
	
	function GetQuestion($field, $sql) {
		$params = [
			'field' => $field,
		];
		return $sql->row('SELECT * FROM naumen_questions WHERE field = :field', $params)[0];
	}
	function GetNextQuestion($chat_id, $sql) {
		$question = NextQuestion($chat_id, $sql);
		if($question == null)
			return array("text" => "Анкета заполнена");
		
		$questionData = GetQuestion($question, $sql);
		if($questionData["keyboard"] == null) 
			return array("text" => "*".$questionData["title"]."*");
		return array("text" => "*".$questionData["title"]."*", 
						"buttons" => json_decode($questionData["keyboard"], true)
					);
	}

	function SendData($chat_id, $data) {
		if(!is_array($data)){
			return sendTelegram('deleteMessage', 
				array(
					'chat_id' => $chat_id,
					'message_id' => $data,
					)
			);
		}
		else if(isset($data['img']) && $data['img'] != ''){
			return sendTelegram('sendPhoto', 
				array(
					'chat_id' => $chat_id,
					'photo' => $data['img'],
					'parse_mode' => 'Markdown',
					'caption' => $data['text'],
					'reply_markup' => isset($data['buttons']) ? json_encode($data['buttons']) : ""
				)
			);
		}
		else {
			return sendTelegram('sendMessage', 
				array(
					'chat_id' => $chat_id,
					'parse_mode' => 'Markdown',
					'text' => $data['text'],
					'reply_markup' => isset($data['buttons']) ? json_encode($data['buttons']) : ""
				)
			);
		}
	}
	
	function CheckChannel($chat_id, $user_id) {
		return json_decode(sendTelegram('getChatMember', 
			array(
				'chat_id' => $chat_id,
				'user_id' => $user_id,
			)
		), true);
	}
	
	function AddToTable() {
		$client = new Google_Client;
			try{
				$client->useApplicationDefaultCredentials();
			  $client->setApplicationName("Something to do with my representatives");
				$client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds']);
			   if ($client->isAccessTokenExpired()) {
					$client->refreshTokenWithAssertion();
				}

				$accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
				ServiceRequestFactory::setInstance(
					new DefaultServiceRequest($accessToken)
				);
			   // Get our spreadsheet
				$spreadsheet = (new Google\Spreadsheet\SpreadsheetService)
					->getSpreadsheetFeed()
					->getByTitle('NaumenTest');

				// Get the first worksheet (tab)
				$worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
				$worksheet = $worksheets[0];


				$listFeed = $worksheet->getListFeed();
				$listFeed->insert([
					'name' => "'". 'Igor',
					'phone' => "'". '2425-245-224545',
					'surname' => "'". 'Orlov',
					'city' => "'". 'Berlin',
					'age' => "'". '35',
					'date' => date_create('now')->format('Y-m-d H:i:s')
				]);

			}catch(Exception $e){
			  file_put_contents("naumen.txt", $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile() . ' ' . $e->getCode);
			}
	}
	
	
	
	function sendTelegram($method, $response) {
		$ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);
		curl_setopt($ch, CURLOPT_POST, 1);  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}