<?php
function create_nginx_config($_domain)
{
	$myConf = "server {". "\n";
	$myConf .= "  include sites-available/config-mradib.conf;". "\n\n";

	$myConf .= "  server_name ". $_domain . ";"."\n";
	// set custom header to detect this domain on code
	$myConf .= "  root /home/root/test-arvan-cdn/public_html;". "\n";
	$myConf .= '  add_header X-MrAdib-Domain "'. $_domain . '";'."\n";
	$myConf .= "}";

	// show created config
	echo "<pre>". $myConf. "</pre>";

	if(!is_dir('/etc/nginx/site-available/'))
	{
		die("We need nginx!");
	}

	$mradib_config = "/etc/nginx/site-available/config-mradib.conf";
	if(!file_exists($mradib_config))
	{
		copy('config-mradib.conf', $mradib_config);
	}

	// save config
	file_put_contents('/etc/nginx/site-available/'. $_domain, $myConf);

	// create shortcut on enable folder
	exec("sudo ln -s /etc/nginx/sites-available/". $_domain. " /etc/nginx/sites-enabled/");

	// @TODO test config is correct
	// exec("nginx -t");

	// reload nginx
	exec("service nginx reload");
}

?>