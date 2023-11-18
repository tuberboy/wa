<?php
set_time_limit(0);
error_reporting(0);
function check_number($number) {
	$url = "https://api.whatsapp.com/send/?phone=".$number."&text&type=phone_number&app_absent=0";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
		'Accept-Encoding: ',
		'Accept-Language: en-US,en;q=0.9',
		'sec-ch-ua: "Google Chrome";v="119", "Chromium";v="119", "Not?A_Brand";v="24"',
		'sec-ch-ua-mobile: ?0',
		'sec-ch-ua-platform: "Windows"',
		'Sec-Fetch-Dest: document',
		'Sec-Fetch-Mode: navigate',
		'Sec-Fetch-Site: none',
		'Sec-Fetch-User: ?1',
		'Upgrade-Insecure-Requests: 1',
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36'
	]);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	$result = curl_exec($ch);
	preg_match('/"_9vd5 _9scb _9scr">(.+?)</', $result, $matched);
	if ($matched[1] != null) {
		return $matched[1];
	} else {
		return false;
	}
}

wa:
echo "First Range (+14044822340): ";
$first = trim(fgets(STDIN));
echo "Last Range  (+19999999999): ";
$last = trim(fgets(STDIN));

if($last <= $first){
	echo "The number format is incorrect!\n";
	goto wa;
} else {
	$a = 1;
	$b = 0;
	$c = 0;
	for($i = $first; $i <= $last; $i++) {
		$number = $i;
		$check = check_number($number);
		if($check !== false) {
			echo "[$a] Number: \033[32m$number\033[0m detected: \033[34m$check\033[0m\n";
			$f = fopen("whatsapp_number.txt", "a");
			fwrite($f, $number."|".$check.PHP_EOL);
			fclose($f);
		} else {
			echo "[$a] Number is invalid: \033[31m$number\033[0m\n";
			$c++;
		}
		$a++;
	}
}
goto wa;
?>