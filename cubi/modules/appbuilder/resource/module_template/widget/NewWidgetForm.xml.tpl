<?xml version="1.0" encoding="UTF-8"?>
<EasyForm Name="DocumentNewForm" Class="PickerForm" Icon="{RESOURCE_URL}/collab/document/images/icon_document.gif" FormType="New" jsClass="jbForm" Title="New Document" Description="Create a new document and edit its content later." BizDataObj="collab.document.do.DocumentPickerDO" PageSize="10" DefaultForm="Y" TemplateEngine="Smarty" TemplateFile="form_docs_quick_add.tpl.html"  Access="collab_document.access" >
    <DataPanel>
	    <Element Name="fld_type_id"  ElementSet="General" Class="collab.lib.TypeSelector" FieldName="type_id" Label="Type" KeepCookie="Y" SelectFrom="collab.document.do.DocumentTypeDO[name:Id:color]" AllowURLParam="N" />
        <Element Name="fld_title"  ElementSet="General" DefaultValue="New Document" Class="InputText" FieldName="title" Label="Title"   />	
        <Element Name="fld_description"  ElementSet="General" Class="Textarea" FieldName="description" Label="Description" />
    	<Element Name="fld_sortorder" Class="Listbox" ElementSet="Miscellaneous" SelectFrom="common.lov.CommLOV(Order)" DefaultValue="50" FieldName="sortorder" Label="Ordering"  />	               

               
    </DataPanel>
    <ActionPanel>
        <Element Name="btn_save" Class="Button" Text="Save" CssClass="button_gray_m">
            <EventHandler Name="save_onclick" EventLogMsg="" Event="onclick" Function="insertToParent()"   ShortcutKey="Ctrl+Enter" ContextMenu="Save" />
        </Element>
        <Element Name="btn_cancel" Class="Button" Text="Cancel" CssClass="button_gray_m">
            <EventHandler Name="onclick" Event="onclick" Function="js:Openbiz.Window.closeDialog()"/>
        </Element>
    </ActionPanel> 
    <NavPanel>
    </NavPanel> 
    <SearchPanel>
    </SearchPanel>
</EasyForm>