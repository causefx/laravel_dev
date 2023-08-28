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
        return $data['scheme'] . "://". $path . "." . $hostname[count($hostname)-2] . "." . $hostname[count($hostname)-1] . ($data['port'] ? ":" . $data['port'] >
}

?>

<html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML 5 Boilerplate</title>
    <link rel="stylesheet" href="dist/spectre.min.css">
	<link rel="stylesheet" href="dist/spectre-exp.min.css">
	<link rel="stylesheet" href="dist/spectre-icons.min.css">
  </head>
  <body>
	<div class="hero bg-gray">
	  <div class="hero-body">
		<h1>Laravel Local Dev</h1>
		<p>Projects below</p>
	  </div>
	</div>
	<div class="docs-content" id="content">
          <div class="container" id="cards">
            <h3 class="s-title">Projects<a class="anchor" href="#cards" aria-hidden="true">#</a></h3>
            <div class="columns">
              <div class="column col-6 col-xs-12">
			  
				<?php
			    $d = dir("/var/www/html");
				while(false !== ($entry = $d->read()))
				{
					if (!in_array($entry, ['.', '..'])) {
						echo '
						<div class="card">
						  <div class="card-header">
							<div class="card-title h5">Apple</div>
						  </div>
						  <div class="card-footer">
							<div class="btn-group btn-group-block">
							  <a href="'.buildUrl($entry).'" class="btn btn-primary">'.$entry.'</a>
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
          </div>
        </div>
  </body>
</html>