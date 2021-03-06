<?php
include_once 'functions.php';

$data = file_get_contents('php://input');
$DATA = $data;
$data = json_decode($data, true);
define('TOKEN', $bot['token']);
$sql = $this->model->db;
if (isset($data['message'])) {
	$chat_id = $data['message']['from']['id'];
	$message = $data['message']['text'];
	$userData= $data['message']['from'];
} 
elseif (isset($data['callback_query'])) {
	$chat_id = $data['callback_query']['message']['chat']['id'];
	$message = $data['callback_query']['data'];
	$userData= $data['callback_query']['from'];
}
else {
	exit();
}

$user = GetUser($chat_id, $sql);
if($user){
	UpdateUser($chat_id, $sql);
	$user = $user[0];
}
else {
	AddUser($chat_id, $sql);
	$user = GetUser($chat_id, $sql)[0];
}

if(isset($data['message']['document'])){
	$file = $data['message']['document']['file_name'];
	if (preg_match("/traniee[0-9]{1,20}\.zip/", $file)) {
		$traniee = substr($file, 7, -4);
		$temp = NextQuestion($chat_id, $sql);
		if($temp != null)
			SendData($chat_id, array("text" => "Не так быстро, сначала нам нужно узнать друг друга поближе.
Закончи с анкетой."));
		else {
			$file_data = sendTelegram('getFile', 
				array(
					'file_id' => $data['message']['document']['file_id'],
				));
			$file_path = json_decode($file_data, true)['result']['file_path'];
			$src  = 'https://api.telegram.org/file/bot' . TOKEN . '/' . $file_path;
			$dest = time() . '-' . $chat_id  . '-' . $traniee. '.zip';
			copy($src, $dest);
			AddToTable($user, $traniee, "https://ntgltema.ga/".$dest);
			SendData($chat_id, array("text" => "Заявка для участия в стажировке отправлена."));
		}
			
		exit();
	}
}

if (mb_stripos($message, '/start') !== false){
	$keys = array(
		"keyboard" => 
		[
			[
				[
					"text" => "Хочу рассказать о себе"
				]
			],
			[
				[
					"text" => "Хочу почитать о тебе"
				]
			],
			[
				[
					"text" => "Хочу на стажировку"
				]
			],
			[
				[
					"text" => "Забудь обо мне"
				]
			]
		],
		"one_time_keyboard" => false, // можно заменить на FALSE,клавиатура скроется после нажатия кнопки автоматически при True
		"resize_keyboard" => true // можно заменить на FALSE, клавиатура будет использовать компактный размер автоматически при True
	);
	SetMode($chat_id, $sql, 0);
	SendData($chat_id, array("text" => "Привет, давай знакомиться!
	
Я бот для заполнения анкеты на стажировку в компании naumen

Меня сделали на *HACKATHON BEST URFU‘21*", "buttons" => $keys));
	exit();
}
else if(mb_stripos($message, 'Закончить заполнять анкету') !== false) {
	$keys = array(
		"keyboard" => 
		[
			[
				[
					"text" => "Хочу рассказать о себе"
				]
			],
			[
				[
					"text" => "Хочу почитать о тебе"
				]
			],
			[
				[
					"text" => "Хочу на стажировку"
				]
			],
			[
				[
					"text" => "Забудь обо мне"
				]
			]
		],
		"one_time_keyboard" => false, // можно заменить на FALSE,клавиатура скроется после нажатия кнопки автоматически при True
		"resize_keyboard" => true // можно заменить на FALSE, клавиатура будет использовать компактный размер автоматически при True
	);
	SetMode($chat_id, $sql, 0);
	SendData($chat_id, array("text" => "Мы можем вернуться к этому разговору в любое время", "buttons" => $keys));
	exit();
}
else if(mb_stripos($message, 'Забудь обо мне') !== false) {
	$keys = array(
		"keyboard" => 
		[
			[
				[
					"text" => "Хочу рассказать о себе"
				]
			],
			[
				[
					"text" => "Хочу почитать о тебе"
				]
			],
			[
				[
					"text" => "Хочу на стажировку"
				]
			],
			[
				[
					"text" => "Забудь обо мне"
				]
			]
		],
		"one_time_keyboard" => false, // можно заменить на FALSE,клавиатура скроется после нажатия кнопки автоматически при True
		"resize_keyboard" => true // можно заменить на FALSE, клавиатура будет использовать компактный размер автоматически при True
	);
	ClearUser($chat_id, $sql);
	SendData($chat_id, array("text" => "Эххх, ты был интересным собеседником, возвращайся еще", "buttons" => $keys));
	exit();
}
else if(mb_stripos($message, 'Хочу на стажировку') !== false) {
	$temp = NextQuestion($chat_id, $sql);
	if($temp != null)
		SendData($chat_id, array("text" => "Не так быстро, сначала нам нужно узнать друг друга поближе.
Закончи с анкетой."));
	else {
		$types = GetTraineeTypes($user['city'], $sql);
		if(count($types)){
			$keys = array(
					"inline_keyboard" => [],
					"one_time_keyboard" => false, // можно заменить на FALSE,клавиатура скроется после нажатия кнопки автоматически при True
					"resize_keyboard" => true // можно заменить на FALSE, клавиатура будет использовать компактный размер автоматически при True
				);
			foreach($types as $type){
				$keys["inline_keyboard"][] = array(array("text" => $type["type"]." [".$type["COUNT(type)"]."]", "callback_data" => "type_".$type["type"]));
			}
			SendData($chat_id, array("text" => "В твоем городе доступны стажировки в следующих направлениях.", "buttons" => $keys));
		}
		else
			SendData($chat_id, array("text" => "В твоем городе сейчас нет доступных стажировок, как только они появятся, я напишу."));
	}
	exit();
}
else if ((mb_stripos($message, 'Хочу почитать о тебе') !== false)) {
	$keys = array(
					"inline_keyboard" => [],
					"one_time_keyboard" => false, // можно заменить на FALSE,клавиатура скроется после нажатия кнопки автоматически при True
					"resize_keyboard" => true // можно заменить на FALSE, клавиатура будет использовать компактный размер автоматически при True
				);
	$keys["inline_keyboard"][] = array(array("text" => "Читать", "callback_data" => "faq_0"));
	SendData($chat_id, array("text" => "Подготовил для тебя небольшие заметки, а если захочешь узнать подробнее, то всегда сможешь сделать это на [сайте](https://www.naumen.ru) или задать вопрос на почту nautrainee@naumen.ru", "buttons" => $keys));
	exit();
}
else if (preg_match("/faq_[0-9]{1,2}/", $message)) {
	$faq = substr($message, 4);
	$keys = array(
					"inline_keyboard" => [],
					"one_time_keyboard" => false, // можно заменить на FALSE,клавиатура скроется после нажатия кнопки автоматически при True
					"resize_keyboard" => true // можно заменить на FALSE, клавиатура будет использовать компактный размер автоматически при True
				);
	$keys["inline_keyboard"][] = array(array("text" => "Дальше", "callback_data" => "faq_".($faq + 1)));
	SendData($chat_id, $data['callback_query']['message']['message_id']);
	SendData($chat_id, array("text" => "Подготовил для тебя небольшие заметки, а если захочешь узнать подробнее, то всегда сможешь сделать это на [сайте](https://www.naumen.ru) или задать вопрос на почту nautrainee@naumen.ru", "buttons" => $keys, "img" => "https://ntgltema.ga/".$faq.".jpg"));
	exit();
}
else if ((mb_stripos($message, 'Хочу рассказать о себе') !== false)) {
	$keys = array(
		"keyboard" => 
		[
			[
				[
					"text" => "Закончить заполнять анкету"
				]
			]
		],
		"one_time_keyboard" => false, // можно заменить на FALSE,клавиатура скроется после нажатия кнопки автоматически при True
		"resize_keyboard" => true // можно заменить на FALSE, клавиатура будет использовать компактный размер автоматически при True
	);
	SendData($chat_id, array("text" => "Так... готовлюсь записывать", "buttons" => $keys));
	SetMode($chat_id, $sql, 1);
	SendData($chat_id, GetNextQuestion($chat_id, $sql));
	exit();
}
else if (preg_match("/cancel_[a-z]{1,20}/", $message)) {
	$field = substr($message, 7);
	SendData($chat_id, $data['callback_query']['message']['message_id']);
	SetData($chat_id, $field, null, $sql);
	SendData($chat_id, GetNextQuestion($chat_id, $sql));
	exit();
}
else if (preg_match("/type_[А-я\s]{1,20}/", $message)) {
	$type = substr($message, 5);
	$trainees = GetTrainees($type, $user['city'], $sql);
	$keys = array(
			"inline_keyboard" => [],
			"one_time_keyboard" => false, // можно заменить на FALSE,клавиатура скроется после нажатия кнопки автоматически при True
			"resize_keyboard" => true // можно заменить на FALSE, клавиатура будет использовать компактный размер автоматически при True
		);
	foreach($trainees as $trainee) {
		$keys["inline_keyboard"][] = array(array("text" => $trainee["name"], "callback_data" => "trainee_".$trainee["id"]));
	}
	SendData($chat_id, $data['callback_query']['message']['message_id']);
	SendData($chat_id, array("text" => "Выберите интересующую стажировку.", "buttons" => $keys ));
	exit();
}
else if (preg_match("/trainee_[0-9]{1,20}/", $message)) {
	$trainee = substr($message, 8);
	$traineeData = GetTrainee($trainee, $sql);
	SendData($chat_id, $data['callback_query']['message']['message_id']);
	SendData($chat_id, array("text" => "_".$traineeData["description"]."_


Для того чтобы принять участие в стажировке по этому направлению тебе *обязательно нужно выполнить* [тестовое задание](".$traineeData["task"].").
Когда все будет готово, отправь боту архив с названием traniee".$trainee.".zip, содержащим все необходимые файлы.
После этого бот передаст твои данные нашим рекуртерам.", "img" => "https://ntgltema.ga/task.jpg"));
	exit();
}
else {
	if($user["mode"] == 1){
		$q = NextQuestion($chat_id, $sql);
		if($q != null){
			SendData($chat_id, $data['callback_query']['message']['message_id']);
			SetData($chat_id, $q, $message, $sql);
			$title = GetQuestion($q, $sql)["title"];
			SendData($chat_id, array("text" => "*".$title."* - ".$message, "buttons" => array(
				"inline_keyboard" => 
				[
					[
						[
							"text" => "Отменить",
							"callback_data" => "cancel_".$q
						]
					]
				],
				"one_time_keyboard" => false, // можно заменить на FALSE,клавиатура скроется после нажатия кнопки автоматически при True
				"resize_keyboard" => true // можно заменить на FALSE, клавиатура будет использовать компактный размер автоматически при True
			)));
			SendData($chat_id, GetNextQuestion($chat_id, $sql));
			exit();
		}
	}
	
	sendTelegram(
		'sendMessage', 
		array(
			'chat_id' => $chat_id,
			'text' => 'Я вас не понимаю 😭'
		)
	);
}
