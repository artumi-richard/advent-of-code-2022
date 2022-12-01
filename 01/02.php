<?php
$fp = fopen('data/01.txt','r');
$calories=[];
$iElfID = 0;
while($line = fgets($fp, 1024))
{
	if(!trim($line))
		$iElfID++;
	if(!isset($calories[$iElfID]))
		$calories[$iElfID]=0;
	$calories[$iElfID]+=(int) $line;
}
asort($calories);
print array_pop($calories) + array_pop($calories) + array_pop($calories);



