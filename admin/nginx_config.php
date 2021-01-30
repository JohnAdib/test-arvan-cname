<?php
function create_nginx_config($_domain)
{
	$myConf = "server {". "\n";
	$myConf .= "  include sites-available/config-mradib.conf;". "\n\n";

	$myConf .= "  server_name ". $_domain . ";"."\n";
	// set custom header to detect this domain on code
	$myConf .= "  root /var/www/html/test-arvan-cname/bucket;". "\n\n";

	$myConf .= '  location / {'."\n";
	$myConf .= '    try_files $uri $uri/ /index.php$is_args$args;'."\n";
	$myConf .= '  }'."\n";

	$myConf .= '  location ~ \.php$ {'."\n";
	$myConf .= '    include snippets/fastcgi-php.conf;'."\n";
	$myConf .= '    fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;'."\n";
	$myConf .= '    fastcgi_param Dev MrAdib;'."\n";
	$myConf .= '    fastcgi_param X-MrAdib-Domain "'. $_domain . '";'."\n";
	$myConf .= '  }'."\n";


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

	$myFile = '/etc/nginx/sites-available/'. $_domain;
	echo("Save config file<br>");
	file_put_contents($myFile, $myConf);
	chmod($myFile, 0777);
	chown($myFile, 'root');


	echo("create shortcut on enable folder<br>");
	exec("ln -s /etc/nginx/sites-available/". $_domain. " /etc/nginx/sites-enabled/");
	chown('/etc/nginx/sites-enabled/'. $_domain, 'root');

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