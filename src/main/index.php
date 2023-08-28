<?php

function buildUrl($path)
{
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']
                === 'on' ? "https" : "http") .
                "://" . $_SERVER['HTTP_HOST'] .
                $_SERVER['REQUEST_URI'];
        $data = parse_url($link);
        $host = $data['host'];
        $hostname = explode(".", $host);
        return $data['scheme'] . "://". $path . "." . $hostname[count($hostname)-2] . "." . $hostname[count($hostname)-1] . ($data['port'] ? ":" . $data['port'] : "");
}
?>

<html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Dev</title>
    <link rel="stylesheet" href="dist/spectre.min.css">
	<link rel="stylesheet" href="dist/spectre-exp.min.css">
	<link rel="stylesheet" href="dist/spectre-icons.min.css">
  </head>
  <body>
	<header class="navbar">
	  <section class="navbar-section">
		<a href="https://github.com/causefx/laravel_dev" class="btn btn-link">Github</a>
		
	  </section>
	  <section class="navbar-center">
		Laravel Local Dev
	  </section>
	  <section class="navbar-section">
		
		<a href="https://github.com/causefx/laravel_dev/issues/new" class="btn btn-link">Issue</a>
	  </section>
	</header>
	<div class="divider"></div>
	<div class="container" id="cards">
		<div class="columns">
			<?php
			$d = dir("/var/www/html");
			while(false !== ($entry = $d->read()))
			{
				if (!in_array($entry, ['.', '..'])) {
					echo '
					<div class="column col-3 col-xs-12">
						<div class="card mb-2">
						  <div class="card-header">
							<div class="card-title h5">'.$entry.'</div>
						  </div>
						  <div class="card-footer">
							<div class="btn-group btn-group-block">
							  <a href="'.buildUrl($entry).'" class="btn btn-primary">Visit</a>
							</div>
						  </div>
						</div>
					</div>
					';
				}
			}
			$d->close();
			?>
		</div>
	</div>
  </body>
</html>
