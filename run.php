<?php
echo 'Cookie: ';
$cookie = trim(fgets(STDIN));
echo 'Auth Token: ';
$auth = trim(fgets(STDIN));
echo 'Hashtag: ';
$ht = trim(fgets(STDIN));

while(true)
{
$headers = array();
$headers[] = 'Cookie: '.$cookie;
$headers[] = "Origin: https://twitter.com";
$headers[] = "Accept-Encoding: gzip, deflate, br";
$headers[] = "Accept-Language: en-US,en;q=0.9";
$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36";
$headers[] = "Content-Type: application/x-www-form-urlencoded";
$headers[] = "Accept: application/json, text/javascript, */*; q=0.01";
$headers[] = "Referer: https://twitter.com/";
$headers[] = "Authority: twitter.com";
$headers[] = "X-Requested-With: XMLHttpRequest";
$headers[] = "X-Twitter-Active-User: yes";
$url = 'https://twitter.com/i/tweet/create';

$f_contents = file("tweet.txt"); 
$tweet = $f_contents[rand(0, count($f_contents) - 1)];

$post = 'authenticity_token='.$auth.'&batch_mode=off&is_permalink_page=false&place_id=&status='.$tweet.''.$ht.'&tagged_users=';

$post = json_decode(yarzCurl($url, $post, false, $headers, true));
if(isset($post->tweet_id))
{
    echo "Tweet ID : ".$post->tweet_id."\n";
	sleep(50);
} else {
	die(print_r($post));
}
}

function yarzCurl($url, $fields=false, $cookie=false, $httpheader=false, $encoding=false)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	if($fields !== false)
	{
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	}
	if($encoding !== false)
	{
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	}
	if($cookie !== false)
	{
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
	}
	if($httpheader !== false)
	{
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	}
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
