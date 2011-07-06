<form id='{$form.name}' name='{$form.name}'>
{literal}
<style>
#main #right_panel .content table.input_row td .label_text{
width:350px;
}
.action_panel{
width:310px;
}
.search_panel{
width:380px;
}
.search_panel select{
float:left;
margin-right:5px;
}
</style>
{/literal}
<div style="padding-left:25px;padding-right:40px;">
	<div>
{include file="system_appbuilder_btn.tpl.html"}
	<table><tr><td>
		{if $form.icon !='' }
		<div class="form_icon"><img  src="{$form.icon}" border="0" /></div>
		{/if}
		<div style="float:left; width:600px;">
		<h2>
		{$form.title}
		</h2> 
		<p class="form_desc">{$form.description}</p>
		</div>
	</td></tr></table>
	</div>
{if $actionPanel or $searchPanel }	
	<div class="form_header_panel">	
		<div class="action_panel"  style="width:292px;">
		{foreach item=elem from=$actionPanel}
		    	{$elem.element}
		{/foreach}
		</div>
		<div class="search_panel" style="width:398px;">
		{foreach item=elem key=name from=$searchPanel}
			
				{if $elem.label} {$elem.label} {/if} 
				{$elem.element}
			
		{/foreach}
		</div>
	</div>
	
{/if}	

<div  id="from_table_container"  class="from_table_container" style="padding-top:3px; padding-bottom:3px;">
<div id="notes" style="width:700px;height:500px;overflow:hidden;background-image:url({$resource_url}/note/images/sticky_board_background.jpg);"></div>
</div>

<script type="text/javascript">
form_name = '{$form.name}';
{literal}
function updateNoteData(note)
{
	Openbiz.getFormObject(form_name).selectedId = note.id;
	Openbiz.getFormObject(form_name).noteText = note.text;
	Openbiz.getFormObject(form_name).notePos_x = note.pos_x;
	Openbiz.getFormObject(form_name).notePos_y = note.pos_y;
	Openbiz.getFormObject(form_name).noteWidth = note.width;
	Openbiz.getFormObject(form_name).noteHeight = note.height;		
}
var clicked = function(note) {	

	$j('#note-'+Openbiz.getFormObject(form_name).selectedId).each(
			function(i){
				this.style.zIndex = Openbiz.getFormObject(form_name).selectedItemZIndex;						
			}
	);
	$j('#note-'+Openbiz.getFormObject(form_name).selectedId+' .background').each(
			function(i){
			this.style.borderColor = Openbiz.getFormObject(form_name).selectedItemBorderColor;
			this.style.backgroundColor = Openbiz.getFormObject(form_name).selectedItemBgColor;			
			}
	);
	$j('#note-'+Openbiz.getFormObject(form_name).selectedId+' .jStickyNote p').each(
			function(i){
				this.style.color = Openbiz.getFormObject(form_name).selectedItemFontColor;
			}
	);

	$j('#note-'+note.id).each(
			function(i){				
				Openbiz.getFormObject(form_name).selectedItemZIndex = this.style.zIndex;	
				this.style.zIndex = '1000';									
			}
		);
	$j('#note-'+note.id+' .background').each(
		function(i){
			//save style
			Openbiz.getFormObject(form_name).selectedItemBorderColor = this.style.borderColor;
			Openbiz.getFormObject(form_name).selectedItemBgColor = this.style.backgroundColor;
					
			//change style
			this.style.borderColor = '#7c0303';
			this.style.backgroundColor = '#ff0000';				
		}
	);
	$j('#note-'+note.id+' .jStickyNote p').each(
			function(i){
				Openbiz.getFormObject(form_name).selectedItemFontColor = this.style.color;
				this.style.color = '#ffffff';		
			}
	);	
	updateNoteData(note);		
	Openbiz.CallFunction(form_name+'.SelectRecord('+note.id+')');
}
var created = function(note) {
	updateNoteData(note);	
}
var edited = function(note) {
	updateNoteData(note);	
	Openbiz.CallFunction(form_name+'.UpdateRecord()');
}
var deleted = function(note) {
	updateNoteData(note);
	Openbiz.CallFunction(form_name+'.DeleteNote()');
}
var moved = function(note) {
	clicked(note);
	updateNoteData(note);	
	Openbiz.CallFunction(form_name+'.UpdateRecord()');
}
var resized = function(note) {
	clicked(note);
	updateNoteData(note);	
	Openbiz.CallFunction(form_name+'.UpdateRecord()');
}

var options = {
	notes:[
	  {/literal}{$form.notes}{literal}
  	],
  	resizable:true,
  	controls:false,
  	clickCallback: clicked,
  	editCallback: edited,
  	createCallback: created,
  	resizeCallback: resized,
  	moveCallback: moved,
  	deleteCallback: deleted
	};
	
$j('#notes').stickyNotes(options);

{/literal}
</script>
<!-- status switch  -->
<script>
{if $form.status eq 'Enabled'}
{elseif $form.status eq 'Disabled'}
$('{$form.name}_data_table').fade({literal}{ duration: 0.5, from: 1, to: 0.35 }{/literal});
{/if}
</script>
<span id='{$form.name}_selected_id' style="display:none">{$default_selected_id}</span>
<!-- table end -->	

	<div class="form_footer_panel">
		<div class="ajax_indicator">
			<div id='{$form.name}.load_disp' style="display:none" >
				<img src="{$image_url}/form_ajax_loader.gif"/>
			</div>
		</div>
		<div class="navi_panel">
{if $navPanel}
   {foreach item=elem from=$navPanel}
   		{if $elem.label} <label style="width:68px;">{$elem.label}</label>{/if}
    	{$elem.element}
   {/foreach}
{/if}			
		
		</div>		
	</div>
	<div class="v_spacer"></div>
</div>
</form>