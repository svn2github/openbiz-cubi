<?php
class AttachmentForm extends EasyForm
{  
   	public function download($id)
   	{
		$record = $this->getDataObj()->fetchById($id);
      
		if (count($record) == 0)
		 	return;
		$size = $record['size'];
		$type = $record['type'];
		$name = $record['filename'];
		$pid = $record['parent_id'];
		$filepath = $this->getTargetPath()."/".$pid."/".$name;
		
		if (!file_exists($filepath)) {
		 BizSystem::clientProxy()->showErrorMessage("File is not found at $filepath");
		 return;
		}
		
		include_once (OPENBIZ_HOME."/others/class.httpdownload.php");
		
		$object = new httpdownload();
		$object->set_byfile($filepath); //Download from a file
		$object->mime = $type;
		$object->use_resume = true; //Enable Resume Mode
		$object->download(); //Download File
		
		exit;
   }
   
   protected function getTargetPath()
   {
      return SECURE_UPLOAD_PATH.DIRECTORY_SEPARATOR.$this->m_Package.DIRECTORY_SEPARATOR."attachment";
   }

   public function saveRecord()
   {
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;

        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
         
		// read in file data and attributes
		foreach ($_FILES as $file) {
			$error = $file['error'];
			if ($error != 0) {
				$this->reportError($error);
				return false;
			}
			$recArr["filename"] = $file['name'];
			$recArr["type"] = $file['type'];
			$recArr["size"] = $file['size'];
			$pid = $recArr['parent_id'];
			
			// move the upload file to target upload directory
			$filedir = $this->getTargetPath().DIRECTORY_SEPARATOR.$pid;
			$filepath = $filedir.DIRECTORY_SEPARATOR.$file['name'];
			if (!is_dir($filedir))
			{
				$old = umask(0);
				$res = @mkdir($filedir, 0777, true);
				umask($old);
			}
			
			// TODO: check if the same file exist
			$replace_exist =  BizSystem::clientProxy()->getFormInputs('file_replace');
			if (file_exists($filepath) && $replace_exist != 'Y')
			{
				BizSystem::clientProxy()->showErrorMessage("The same file already exists, please try again!");
				return false;
			}
			
			if (!move_uploaded_file($file['tmp_name'], $filepath)) {
				BizSystem::clientProxy()->showErrorMessage("There was an error uploading the file, please try again!");
				return false;
			}
			if (file_exists($filepath))
			{
				// update the record whose filename is the same as input
				$searchRule = "[filename] = '".$file['name']."'";
				$recordList = $this->getDataObj()->directFetch($searchRule);
				if (count($recordList)>0)
					$this->_doUpdate($recArr, $recordList[0]);
				else
				    $this->_doInsert($recArr);
			}
			else 
			{
				$this->_doInsert($recArr);
			}
			break;
		}
		
		// in case of popup form, close it, then rerender the parent form
		if ($this->m_ParentFormName) {
			$this->close();
			$this->renderParent();
		}
		
		$this->processPostAction();
   }

   protected function reportError($error)
   {
      if ($error==1)
         $errorStr = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
      else if ($error==2)
         $errorStr = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
      else if ($error==3)
         $errorStr = "The uploaded file was only partially uploaded";
      else if ($error==4)
         $errorStr = "No file was uploaded";
      else if ($error==6)
         $errorStr = "Missing a temporary folder";
      else if ($error==7)
         $errorStr = "Failed to write file to disk";
      else
         $errorStr = "Error in file upload";
         
      BizSystem::clientProxy()->showErrorMessage($errorStr);
   }
}

?>