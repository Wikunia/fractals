<?php
header("Content-type: image/jpg");
$width = $_GET['width'];
$height = $_GET['height'];
$theImage = imagecreate ($width , $height);

$half_width = round($width/2);
$half_height = round($height/2);

$xGet = $_GET['x']-$half_width;
$yGet = $half_height-$_GET['y'];
$zoom = $_GET['zoom'];
$Re = $_GET['Re'];
$Re_GET = $_GET['Re'];
$Im = $_GET['Im'];
$Im_GET = $_GET['Im'];
$cr = $_GET['cr'];
$ci = $_GET['ci'];
$from =  $_GET['from'];
$middle =  $_GET['middle'];
$to =  $_GET['to'];
$format =  $_GET['format'];


imagecolorallocate($theImage, 0,0,0);
$color = array();
$gradient = array();


$gradient["from"] = array("red"=>hexdec(substr($from,0,2)),"green"=>hexdec(substr($from,2,2)),"blue"=>hexdec(substr($from,4,2)));
$gradient["middle"] = array("red"=>hexdec(substr($middle,0,2)),"green"=>hexdec(substr($middle,2,2)),"blue"=>hexdec(substr($middle,4,2)));
$gradient["to"] = array("red"=>hexdec(substr($to,0,2)),"green"=>hexdec(substr($to,2,2)),"blue"=>hexdec(substr($to,4,2)));

$steps = 200;
for ($i = 0; $i < round($steps/4); $i++)
{
	$red = floor($i * ($gradient["middle"]["red"]-$gradient["from"]["red"])/$steps)+$gradient["from"]["red"];
	$green = floor($i * ($gradient["middle"]["green"]-$gradient["from"]["green"])/$steps)+$gradient["from"]["green"];
	$blue = floor($i * ($gradient["middle"]["blue"]-$gradient["from"]["blue"])/$steps)+$gradient["from"]["blue"];
	$color[] = imagecolorallocate($theImage, $red, $green, $blue);	
}
for ($i = round($steps/4)+1; $i < $steps; $i++)
{
	$red = floor($i * ($gradient["to"]["red"]-$gradient["middle"]["red"])/$steps)+$gradient["middle"]["red"];
	$green = floor($i * ($gradient["to"]["green"]-$gradient["middle"]["green"])/$steps)+$gradient["middle"]["green"];
	$blue = floor($i * ($gradient["to"]["blue"]-$gradient["middle"]["blue"])/$steps)+$gradient["middle"]["blue"];
	$color[] = imagecolorallocate($theImage, $red, $green, $blue);	
}

$black = imagecolorallocate($theImage, 0, 0, 0);
$white = imagecolorallocate($theImage, 255, 255, 255);
$blue = imagecolorallocate($theImage, 0,0,139);
$orange = imagecolorallocate($theImage, 255,165,0);
$green = imagecolorallocate($theImage, 173,255,47);
$red = imagecolorallocate($theImage, 255,0,0); 


for ($r = -$half_width; $r <= $half_width; $r++) // left to right
	{
		for ($i = -$half_height; $i <= $half_height; $i++) // bottom to top
			{	
				if ($format == "Julia")
				{
					$Re = ($xGet+$r/($zoom/100))/100;
					$Im = ($yGet+$i/($zoom/100))/100;
				}
				else if ($format == "Mandelbrot")
				{
					$cr = ($xGet+$r/($zoom/100))/100;
					$ci = ($yGet+$i/($zoom/100))/100;
					$Re = $Re_GET;
					$Im = $Im_GET;					
				}

				for ($d = 1; $d <= $steps; $d++)
					{	
						$abs_value = sqrt($Re*$Re+$Im*$Im);
						if ($abs_value >= 2)
						{
							$x = round($half_width+$r);
							$y = round($half_height-$i);
						
							imageline($theImage, $x,$y,$x,$y, $color[$d]);
						
							break;
						}
						$ReNew = $Re*$Re-$Im*$Im+$cr;
						$ImNew = 2*$Re*$Im+$ci;
						$Re = $ReNew;
						$Im = $ImNew;
					}
			}	
	}
	

imagejpeg($theImage);
imagedestroy($theImage);


?>
