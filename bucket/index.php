<?php
echo "Hi! You are connected to bucket on arvan server. Let us show some detail";
echo "<pre>";
$data =
[
	'REQUEST_SCHEME' => isset($_SERVER[REQUEST_SCHEME])? $_SERVER[REQUEST_SCHEME]:"-",
	'HTTP_HOST'      => isset($_SERVER[HTTP_HOST])? $_SERVER[HTTP_HOST]:"-",
	'REQUEST_URI'    => isset($_SERVER[REQUEST_URI])? $_SERVER[REQUEST_URI]:"-",
	'SERVER_ADDR'    => isset($_SERVER[SERVER_ADDR])? $_SERVER[SERVER_ADDR]:"-",
	'X-Domain'       => isset($_SERVER["X-Domain"])? $_SERVER["X-Domain"]:"-",
	'X-Bucket'       => isset($_SERVER["X-Bucket"])? $_SERVER["X-Bucket"]:"-",
];

foreach ($data as $key => $value)
{
	echo $key. "\t <b>". $value. "</b>\n";
}

echo "</pre>";

echo "<hr>";
echo '<h1>$_SERVER</h1>'."\n";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";

?>