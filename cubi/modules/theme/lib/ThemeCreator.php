<?php
class ThemePackCreator
{
	public $theme;
	
    public function __construct($theme)
    {
    	$this->theme = $theme;
    }
    
    public function createNew()
    {    	
    	$theme = $this->theme;
    	if(CLI){
				echo "Creating new theme : $theme".PHP_EOL;
				
		}
		$theme_dir = THEME_PATH.DIRECTORY_SEPARATOR.$theme;
    	if(!is_dir($theme_dir)){
			if(CLI){
				echo "Create theme directory: $theme".PHP_EOL;
			}
    		@mkdir($theme_dir);
		}
    	$dir = THEME_PATH.DIRECTORY_SEPARATOR."default";
		$dir_iterator = new RecursiveDirectoryIterator($dir);
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $file) {
				if($this->isThemeFile($file)){
				    $src_path=$file->getRealPath();
				    $dest_path= THEME_PATH.DIRECTORY_SEPARATOR.$theme.str_replace($dir,"",$src_path);;			    
					if(is_dir($src_path))
					{
						if(!is_dir($dest_path))
						{
							if(CLI){
								echo "  Create theme dir: ".str_replace(THEME_PATH.DIRECTORY_SEPARATOR,"",$dest_path).PHP_EOL;
							}							
							@mkdir($dest_path);
						}
					}
					elseif(is_file($src_path))
					{
						if(is_file($dest_path))
						{
//							if file exist, then merge it 
//							if(!$this->compareFile($src_path,$dest_path)){
//								@copy($src_path,$dest_path);
//							}
						}
						else
						{
						if(CLI){
							echo "  Create theme file: ".str_replace(THEME_PATH.DIRECTORY_SEPARATOR,"",$dest_path).PHP_EOL;
						}
							//just copy and override it
							@copy($src_path,$dest_path);
						}
					}
				}
			
		}    	
    }
    
    private function isThemeFile($file){
    	$path = $file->getRealPath();
    	if(preg_match("/(\.)svn/si",$path)){
    		return false;
    	}
    	if(preg_match("/(\%\%)/si",$path)){
    		return false;
    	}
    	return true;
    }
    
    private function compareFile($src, $dst){
    	$src_data = file_get_contents($src);
    	$dst_data = file_get_contents($dst);
    	if($src_data == $dst_data)
    	{
    		return true;
    	}
    	else
    	{
    		return false;    		
    	}
    }
}