<?php

class Dir {
	private 
		$parent,
		$name,
		$dirs=[], 
		$files=[];
	public function addDir(Dir $d)
	{
		$this->dirs[]=$d;
	}
	public function addFile(File $f)
	{
		$this->files[]=$f;
	}
	public function __construct(string $name)
	{
		$this->name=$name;
	}
	public function setParentFolder(Dir $d)
	{
		$this->parent=$d;
	}
	public function parentFolder()
	{
		return $this->parent;
	}
	public function getSize():int
	{
		$i=0;
		foreach($this->dirs as $dir)
			$i+=$dir->getSize();
		foreach($this->files as $file)
			$i+=$file->getSize();
		return $i;
	}
	public function getDir($name)
	{
		foreach($this->dirs as $dir)
		{
			if($dir->getName()===$name)
				return $dir;
		}
		throw new Exception('No Dir '.$name.' Found in '.$this->fullPath());
	}
	public function fullPath()
	{
		if(!$this->parent)
			return '/';
		return implode('/', $this->path());
	}
	public function path()
	{
		if(!$this->parent)
			return ['/'];
		$aPath = [$this->getName()];
		if($this->parent)
			array_merge($aPath, $this->parent->path());
		return $aPath;
	}
	public function getName()
	{
		return $this->name;
	}
	public function createChildDir($name)
	{
		$dir = new Dir($name);
		$dir->setParentFolder($this);
		$this->dirs[]=$dir;
	}
	public function createChildFile($size, $name)
	{
		$file = new File($name, (int) $size, $this);
		$this->files[]=$file;
	}
	public function printTree()
	{
		print $this->fullPath()."\n";
		foreach($this->dirs as $dir)
		{
			$dir->printTree();
		}
		foreach($this->files as $file)
		{
			print $file->fullPath()."\n";
		}
	}
	public function flatDirs()
	{
		$a=[];
		$a[]=$this;
		foreach($this->dirs as $dir)
		{
			$a= array_merge($a, $dir->flatDirs());
		}
		return $a;
	}
}
class RootDir extends Dir {
	public function fullPath()
	{
		return '/';
	}
	public function path()
	{
		return [];
	}
}
class File
{
	private 
		$name,
		$parent,
		$size;
	public function __construct(string $name, int $size, Dir $parent)
	{
		$this->name=$name;
		$this->size=$size;
		$this->parent=$parent;
	}
	public function getSize():int
	{
		return $this->size;
	}
	public function parentFolder()
	{
		return $this->parent;
	}
	public function fullPath()
	{
		print $this->parent->fullPath().'/'.$this->name;
	}

}
class Command 
{
	public
		$sCommandArgs='',
		$output=[];
	public function args()
	{
		return $this->sCommandArgs;
	}
	public function __construct(string $sCommandArgs)
	{
		$this->sCommandArgs=$sCommandArgs;
	}
	public function recordOutput(string $outputLine)
	{
		$this->output[]=$outputLine;
	}
}
class CD extends Command
{

	public function run(&$pwd)
	{
		$args=$this->args();
		if($args=='/')
		{
			global $root;
			$pwd=$root;
		}
		else if ($args=='..')
		{
			$pwd=$pwd->parentFolder();
		}
		else 
		{
			//try to cd into "$args"
			$dirName=$args;
			$pwd = $pwd->getDir($dirName);
		}
	}
}
class LS extends Command
{
	public function run($pwd)
	{
		foreach($this->output as $line)
		{
			$aParts = explode(' ', $line);
			if($aParts[0]=='dir')
			{
				$pwd->createChildDir($aParts[1]);
			}
			else
			{
				$pwd->createChildFile($aParts[0], $aParts[1]);
			}
		}
	}
}
class CommandFactory
{
	static public function makeCommand($command)
	{
		$aCommand = explode(' ' , $command);
		$sCommandName = array_shift($aCommand);
		if($sCommandName=='cd')
			return new CD(implode(' ',$aCommand));
		else if ($sCommandName=='ls')
			return new LS(implode(' ',$aCommand));
		throw new ErrorException("Unknown command $command");
	}
}
function splitIntoCommands($aFile)
{
	$aCommands=[];
	$iCommandID=-1;
	foreach($aFile as $line)
	{
		if($line[0]=='$')
		{
			$iCommandID++;
			$command = trim(substr($line,1));
			$oCommand = CommandFactory::makeCommand($command);
			$aCommands[]=$oCommand;
		}
		else
		{
			$oCommand->recordOutput($line);
		}
	}
	return $aCommands;
}
function processCommand(&$pwd, $oCommand)
{
	$oCommand->run($pwd);
}
function processFile($aFile)
{
	global $root;
	$root = new RootDir('/');
	$cwd = $root;
	$aCommands = splitIntoCommands($aFile);
	foreach($aCommands as $oCommand)
	{
		processCommand($cwd, $oCommand);
	}
	$root->printTree();
	$answer=0;
	foreach($root->flatDirs() as $dir)
	{
		$size=$dir->getSize();
		if($size<=100000)
			$answer+=$size;

	}
	print $answer."\n";
}


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
function go($filename)
{
	$aFile = getFile($filename);
	processFile($aFile);


}


print "Example\n";
go('data/example.txt');
print "Input\n";
go('data/input.txt');

