<?php
require_once("includes/initialize.php");

class Logs
{
	function __construct($owner_id,$where_to)
	{
		$dir=SITE_ROOT;
		chdir($dir);
		if(!is_dir("logs"))
			{
			mkdir('logs',0777);
			chdir('logs');
			}
			else
			chdir('logs');
			
		$dirname="Owner_".$owner_id;
		if(!is_dir($dirname))
			{
			mkdir($dirname,0777);
			chdir($dirname);
			}
			else
			{
			chdir($dirname);
			}
		if($where_to=='user')
			{
			$dirname="User_Logs";
			if(!is_dir($dirname))
				{
				mkdir($dirname,0777);
				chdir($dirname);
				}
			else
				{
				chdir($dirname);
				}
			}
		else
			{
				$dirname="Test_Logs";
				if(!is_dir($dirname))
				{
				mkdir($dirname,0777);
				chdir($dirname);
				}
				else
				{
				chdir($dirname);
				}
					$dirname=$where_to;
					if(!is_dir($dirname))
					{
					mkdir($dirname,0777);
					chdir($dirname);
					}
					else
					{
					chdir($dirname);
					}
				
				
			}	
	}
	
	public function write_logfile($filename,$action, $message="",$time='time()')
		{
			
			$logfile = $filename.'.txt';
			$new = file_exists($logfile) ? false : true;
  			if($handle = fopen($logfile, 'a')) { // append
   			 	$timestamp = strftime("%Y-%m-%d %H:%M:%S", $time);
				$content = "{$timestamp} | {$action}: {$message}\r\n";
				fwrite($handle, $content);
   				 fclose($handle);
   				 if($new) { chmod($logfile, 0755); }
 			 } 
			 else
			  {
   			 echo "Could not open log file for writing.";
 			 }
		
		}
	
	public function read_logfile()
		{
		
		}
		
		
	
}


?>