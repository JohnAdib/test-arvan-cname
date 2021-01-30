<?php
require_once "nginx_config.php";

// show list of domains
read_domain_list();

if(!isset($_GET['domain']) || !isset($_GET['bucket']))
{
	die("Please pass domain and bucket on get parameter. for example ?domain=s3.talambar.com&bucket=test1");
}

$myDomain = $_GET['domain'];
$myBucket = $_GET['bucket'];

if(filter_var(gethostbyname($myDomain), FILTER_VALIDATE_IP))
{
	create_nginx_config($myDomain, $myBucket);
}
else
{
	die('Please enter valid domain');
}

?>