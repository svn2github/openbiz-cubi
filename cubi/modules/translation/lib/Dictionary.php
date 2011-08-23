<?php

//$this->translate('apple', 'en', 'zh_CN');

class Dictionary
{
	public $form, $to;
	protected $dict;
	
	public function __construct($from, $to)
	{
		$this->from = $from;
		$this->to = $to;
	}
	
	public function update()
	{
		$this->writeDictFile($this->dict);
	}
	
	public function translate($text)
	{
		if (empty($text) || empty($this->from) || empty($this->to))
			return $text;
		
		$key = md5($text);
		
		// TODO: split string by \\n, \\t ...
		
		// get the dictionary file first
		if (!$this->dict)
			$this->dict = $this->readDictFile();
		if (isset($this->dict[$key])) {
			echo "hit dictionary for $text".nl;
			return $this->dict[$key]['to_text'];
		}
		// call google translation api
		require_once('google.translator.php');
		$toText = Google_Translate_API::translate($text, $this->from, $this->to);
		if ($toText !== false)
			$this->dict[$key] = array('from_text'=>$text, 'to_text'=>$toText);
		
		return $toText;
	}
	
	protected function readDictFile()
	{
		$dictFile = $this->getDictFile();
		if (file_exists($dictFile)) {
			include($dictFile);
			echo "# Read dictionary from $dictFile".nl;
			if (is_array($dict))
				return $dict;
		}
		return array();
	}
	
	protected function writeDictFile($data)
	{
		if (empty($data))
			return;
		$dictFile = $this->getDictFile();
		$content = "<?php \n";
		$content .= '$dict = '."\n";
		$content .= var_export($data, true);
		$content .= ";\n";
		$content .= "?>";
		echo "# Write dictionary to $dictFile".nl;
		file_put_contents($dictFile, $content);
	}
	
	protected function getDictFile()
	{
		$dictionaryPath = LANGUAGE_PATH.DIRECTORY_SEPARATOR.'dictionary';
		$dictFile = $dictionaryPath.DIRECTORY_SEPARATOR.$this->from.'2'.$this->to.'.php';
		return $dictFile;
	}
}

?>