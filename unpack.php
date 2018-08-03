<?php

$path = __DIR__ . "/" . $argv[1];
$dest = $path . ".zip";

$im = imagecreatefrompng($path);
list($width, $height) = getimagesize($path);
$out = '';

echo "$width x $height image\n";
for ($y = 0; $y < $height; $y++)
{
  for ($x = 0; $x < $width; $x++)
  {
    $rgb = imagecolorat($im, $x, $y);
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;
    $out .= chr($r) . chr($g) . chr($b);
  }
}

file_put_contents($dest, $out);
echo "Written to: $dest\n";