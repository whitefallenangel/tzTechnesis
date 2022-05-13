<?php
  require 'simple_html_dom.php';
  $error = '';
  $imagesCount = 0;
  $imageSize = 0;

  if (!empty($_GET['url']) && filter_var($_GET['url'], FILTER_VALIDATE_URL)) {
	
    $html = new simple_html_dom();
    $html->load_file($_GET['url']);
	$imageList = $html->find('img');
	
	if (count($imageList)) {
	  echo '<table><tr>';
		
  	  foreach($imageList as $key => $element) {
		$size = @strlen( file_get_contents((empty($url['host']) ? $_GET['url'] : '') . $element->src) );
		$url = parse_url($element->src);
		$imageSize += $size;
	    echo '<td><img src="' . (empty($url['host']) ? $_GET['url'] : '') . $element->src . '"></td>';
		if ( $key % 4 == 3 ) echo '</tr><tr>';
	  }
	  
	  echo '</tr></table>';
	  echo '<b>На странице обнаружено ' . count($imageList) . ' изображений на ' . $imageSize / 1024 / 1024 . ' Мб</b>';
	} else {
      echo '<b style="color: red;">На странице не обнаружено изображений!</b>';
	}	
	
  } elseif (isset($_GET['url'])) {
	$error = 'Wrong URL!';
  }

?>

<html>
  <body>
    <style>
	  body {
		text-align: center;
		font-size: 1.1em;
	  }
	  div.error {
		color: red;
	  }
	  form {
	    padding: 25px;
	  }
	  img {
		max-width: 100%;
	  }
	  table {
		width: 80%;
		margin: 0 auto 30px;
	  }
	  td {
		width: 25%;
		text-align: center;
		border: 1px solid #888;
		padding: 10px;
	  }
	  td:hover {
	    background: #eee;
		border-color: #f47f7f;
	  }

	button {
	  display: inline-block;
	  font: inherit;
	  border: 0;
	  outline: 0;
	  cursor: pointer;
	  background: #7f8ff4;
	  color: #fff;
	  box-shadow: 0 0 10px 2px rgba(0, 0, 0, 0.1);
	  border-radius: 2px;
	  padding: 10px 30px;
	  margin-left: -96px;
	  text-transform: uppercase;
	}
	button:hover {
	  background: #6c7ff2;
	}

	input {
	  width: 360px;
	  background: none;
	  color: #999;
	  box-shadow: 0 6px 10px 0 rgba(0, 0, 0, 0.1);
	  outline: 0;
	  border: 0;
	  padding: 18px 15px;
	}
    </style>
  
    <div class="error"><?php echo $error ? $error : ''; ?></div>

	  <form>
		<input name="url" type="url" placeholder="Enter Url" />
		<button type="submit">Parse</button>
	  </form>
  </body>
</html>