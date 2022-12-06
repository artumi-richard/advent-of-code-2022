<?php

function getFile($filename)
{
	$fp = fopen($filename,'r');
	$aFile=[];
	while($line = fgets($fp, 2048))
	{
		//remove last "\n"
		$line = substr($line, 0,strlen($line)-1);
		$aFile[]=$line;
	}
	fclose($fp);
	return $aFile;
}
function findRepeatingPattern($line)
{

	$len = strlen($line);
	for($i=0;$i<$len-4; $i++)
	{
		$sub = substr($line, $i, 4);
		$a=str_split($sub);

		$a=array_unique($a);
		if(count($a)==4)
			return $i+4;
	}
	return false;
}
function go($filename)
{
	$aFile = getFile($filename);
	$line = $aFile[0];
	$r = findRepeatingPattern($line);
	print $r."\n";


}


print "Example1 expecting 7 \n";
go('data/example1.txt');
print "Example2 expecting 5\n";
go('data/example2.txt');
print "Example3 expecting 6\n";
go('data/example3.txt');
print "Example4 expecting 10\n";
go('data/example4.txt');
print "Example5 expecting 11\n";
go('data/example5.txt');
print "Input\n";
go('data/input.txt');

