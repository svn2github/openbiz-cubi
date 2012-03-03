<?php 
class DocumentForm extends EasyForm
{
	public function SaveDoc()
	{
						
		parent::updateRecord();
		$message=$this->getMessage("DOC_SAVED");
		$content="<div id=\"notice_save_msg\" class=\"noticeBox\" >$message</div>";	
		$script="
		<script>try{setTimeout(\"try\{$('notice_save_msg').fade( {from: 1, to: 0});}catch(e){}\",3000);}catch(e){};</script>
		";
		BizSystem::clientProxy()->updateClientElement('notice_save', $content);
		BizSystem::clientProxy()->runClientScript($script);
	}	
}
?>
