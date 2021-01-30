<?php
require_once "nginx_config.php";

// show list of domains
read_domain_list();

if(!isset($_GET['add']))
{
	die("Please pass domain on get parameter. for example ?add=s3.talambar.com");
}

$myNewDomain = $_GET['add'];
if(filter_var(gethostbyname($myNewDomain), FILTER_VALIDATE_IP))
{
	create_nginx_config($myNewDomain);
}
else
{
	die('Please enter valid domain');
}

?>