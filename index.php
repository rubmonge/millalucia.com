<?
define('PATH_LIBRARY',  '../Library/');
set_include_path(get_include_path() . PATH_SEPARATOR . PATH_LIBRARY);
require_once PATH_LIBRARY . "/Functions/Core.php";
loadFunctions("Utils");
$resizes = array(
              "h" => array('width' => 300, 'widthMax' => 300, 'height' => 1, 'heightMax' => 800),
              "m" => array('width' => 1, 'widthMax' => 260, 'height' => 1, 'heightMax' => 260),
              "s" => array('width' => 90, 'widthMax' => 90, 'height' => 90, 'heightMax' => 90)
    );
function rawToLive($src, $resizes)
    {
        if (is_file($src)) {
            /* copia regular */
            $ext     = array_pop(explode(".", $src));
            $destiny = "img/resized/" . md5($src . filemtime($src)) . "." . $ext;

            if (file_exists($destiny)) {
                $url = $destiny;                
            } else {
                $result = copy($src, $destiny);
                if ($result) {
                    /* make the thumbs */
                    foreach ($resizes as $k => $newSize) {
                        set_time_limit(0);
                        $name      = explode(".", $destiny);
                        $objResize = Easy_ImageResize_Factory::getInstanceOf($destiny, $name[0] . "_" . $k . "." . $name[1], $newSize);
                        $resultImg = $objResize->getResizedImage();
                    }
                    $url       = $destiny;                    
                }
            }
			return $url;
        }

        return false;
    }

$auxImgs = glob("img/original/*");
if (is_array($auxImgs)){
	foreach($auxImgs as $k=>$img){
		$imgs[$k]['main'] = rawToLive($img, $resizes);
		$imgs[$k]['h'] = str_replace('.',"_h.",$imgs[$k]['main']);
		$imgs[$k]['m'] = str_replace('.',"_m.",$imgs[$k]['main']);
		$imgs[$k]['s'] = str_replace('.',"_s.",$imgs[$k]['main']);
		
	}
}
shuffle($imgs);
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">

<title>Milla Luc&iacute;a</title>

<meta name="viewport" content="width=device-width">

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/stylesheet.css">

<script src="js/modernizr-2.5.3.min.js"></script>

</head>
<body>

<header class="container">
<h1>millalucia.com</h1>		
</header>

<div id="content" class="container clearfix">


<? foreach($imgs as $img): ?>
    <div class="item">
		<figure>
			<img src="<?=$img['h']?>" alt="Milla Lucía"/>							
		</figure>
    </div>
<? endforeach ?>


</div>

<footer class="container clearfix">								
	<p>&reg; su padre'<?=date('Y')?></p>
</footer>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.7.1.min.js"><\/script>')</script>
<script src="js/jquery.masonry.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>