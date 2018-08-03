<?php

$path = __DIR__ . "/" . $argv[1];
$dest = $path . ".png";
$bytesPerPixel = 3;

$buffer = file_get_contents($path);
$length = filesize($path);

if (!$buffer || !$length) {
  die("File read error\n");
}

//pad to even multiple
while (strlen($buffer) % $bytesPerPixel != 0) {
  $buffer .= chr(0);
}

$pixels = ceil($length / $bytesPerPixel);
$side = ceil(sqrt($pixels));

$gd = imagecreatetruecolor($side, $side);

$colors = [];
for ($i = 0; $i < $length; $i += $bytesPerPixel) {
  $color = imagecolorallocate($gd, ord($buffer[$i]), ord($buffer[$i + 1]), ord($buffer[$i + 2]));
  $x = ($i / $bytesPerPixel) % $side;
  $y = ceil( ($i + 1) / ($side * $bytesPerPixel)) - 1;
  imagesetpixel($gd, $x, $y, $color);
}

imagepng($gd, $dest);

echo "Written to: $dest\n";
echo "File-size: $length bytes\n";
echo "Pixels $pixels ($side x $side)\n";