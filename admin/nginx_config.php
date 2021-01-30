<?php
function create_nginx_config($_domain)
{
	$myConf = "server {". "\n";
	$myConf .= "  include sites-available/config-mradib.conf;". "\n\n";

	$myConf .= "  server_name ". $_domain . ";"."\n";
	// set custom header to detect this domain on code
	$myConf .= "  root /home/ubuntu/test-arvan-cdn/bucket;". "\n";
	$myConf .= '  add_header X-MrAdib-Domain "'. $_domain . '";'."\n";
	$myConf .= "}";

	// show created config
	echo "<pre>". $myConf. "</pre>". "<hr>";

	if(!is_dir('/etc/nginx/sites-available'))
	{
		die("We need nginx!");
	}

	$mradib_config = "/etc/nginx/sites-available/config-mradib.conf";
	if(!file_exists($mradib_config))
	{
		copy('config-mradib.conf', $mradib_config);
	}

	echo("Save config file<br>");
	file_put_contents('/etc/nginx/sites-available/'. $_domain, $myConf);

	echo("create shortcut on enable folder<br>");
	exec("ln -s /etc/nginx/sites-available/". $_domain. " /etc/nginx/sites-enabled/");

	// nginx config reload every minute with cronjob
}

function read_domain_list()
{
	$domainList = glob("/etc/nginx/sites-available/*");
	echo "<h2>List of domains</h2>";
	echo "<pre>";
	if($domainList)
	{
		foreach ($domainList as $filename)
		{
			echo basename($filename). "\n";
		}
	}
	else
	{
		echo "There are no domain!";
	}
	echo "</pre>";
	echo "<hr>";
}

?>