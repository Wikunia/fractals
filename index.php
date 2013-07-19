<!DOCTYPE html>
<head></head>
<body>
<h1>z=(a+bi)<sup>2</sup>+c</h1>
<form action="index.php" id="komplex"  name="komplex" method="get">
<?php
$cr = $_GET['cr'];
$ci = $_GET['ci'];
$Re = $_GET['Re'];
$Im = $_GET['Im'];
$from = $_GET['from'];
$middle = $_GET['middle'];
$to = $_GET['to'];
$format = $_GET['format'];
$width = $_GET['width'];
$height = $_GET['height'];

if ($format == "Julia") { echo '<input type="radio" name="format" value="Julia" checked/>Julia set<br>'; } else { echo '<input type="radio" name="format" value="Julia" />Julia set<br>'; }
if ($format == "Mandelbrot") { echo '<input type="radio" name="format" value="Mandelbrot" checked />Mandelbrot set<br>'; } else {echo '<input type="radio" name="format" value="Mandelbrot" />Mandelbrot set<br>'; } 

echo '
<input id="cr" style="display:none;" type="text" size="5" name="cr" autocomplete="off" placeholder="Re(c)" value="'.$cr.'" />
<input id="ci" style="display:none;" type="text" size="5" name="ci" autocomplete="off" placeholder="Im(c)" value="'.$ci.'" />
<input id="Re" style="display:none;" type="text" size="5" name="Re" autocomplete="off" placeholder="Re" value="'.$Re.'" />
<input id="Im" style="display:none;" type="text" size="5" name="Im" autocomplete="off" placeholder="Im" value="'.$Im.'" />
<br>
';


echo 'Image size:<br>
<input type="text" size="5" name="width" autocomplete="off"  value="'.$width.'" /> *
<input type="text" size="5" name="height" autocomplete="off"  value="'.$height.'" />
';
echo '<br>Color gradient:<br>
<input type="color" name="from" value="'.$from.'" required /> &rarr;
<input type="color" name="middle" value="'.$middle.'" required /> &rarr;
<input type="color" name="to" value="'.$to.'" required />
<input type="submit" value=" Submit ">
';
?>
<br>


<?php
function GetNew($Re,$Im) {
	$ReNew = Pow($Re,2)-Pow($Im,2)-1;
	$ImNew = 2*$Re*$Im;
	$Betrag = sqrt(Pow($ReNew,2)+Pow($ImNew,2));
	return array($ReNew,$ImNew,$Betrag);
}
$from = $_GET['from'];
$to = $_GET['to'];
$format = $_GET['format'];

if (($from != "") and ($to != ""))
{	
	$from = urldecode(substr($from,1,6));
	$middle = urldecode(substr($middle,1,6));
	$to = urldecode(substr($to,1,6));
	$x = round($width/2);
	$y = round($height/2);
	print '<img id="pic" src="zoom.php?x='.$x.'&y='.$y.'&zoom=100&Re='.$Re.'&Im='.$Im.'&cr='.$cr.'&ci='.$ci.'&from='.$from.'&middle='.$middle.'&to='.$to.'&format='.$format.'&width='.$width.'&height='.$height.'">';
}

?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script src="JS/komplex.js"></script>
</body>
</html>