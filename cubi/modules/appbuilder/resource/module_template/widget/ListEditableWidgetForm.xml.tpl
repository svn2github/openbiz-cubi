<?xml version="1.0" encoding="UTF-8"?>
<EasyForm Name="{$form_name}" 
			Class="{$form_class}"			  
			FormType="List" 
			jsClass="Openbiz.TableForm" 
			BizDataObj="{$form_do}" 
			PageSize="10" 
			DefaultForm="Y" 
			TemplateEngine="Smarty" 
			TemplateFile="{$form_template}" 
			MessageFile="{$message_file}" 
			Access="{$acl.access}">	
	<DataPanel>          
{assign var=col_counter value=0}            
{foreach from=$fields item=fld}
{if $fld.Field == 'id'}
		<Element Name="row_selections" 
        			Class="RowCheckbox"  
        			Label="" 
        			FieldName="Id"/>
		<Element Name="fld_Id" 
        			Class="common.element.ColumnTitle" 
        			FieldName="Id" 
        			Label="ID" 
        			Sortable="Y" 
        			AllowURLParam="N" 
        			Link="javascript:;" />   
{if $do_perm_control eq 'Y' }
		<Element Name="fld_share" Class="ColumnShare" 
				MyPrivateImg="{$share_icons.icon_private}"
				MySharedImg="{$share_icons.icon_shared}" 
				MyAssignedImg="{$share_icons.icon_assigned}"
				MyDistributedImg="{$share_icons.icon_shared_distributed}" 
				GroupSharedImg="{$share_icons.icon_shared_group}"
				OtherSharedImg="{$share_icons.icon_shared_other}"
				FieldName="create_by" 
				Label="Share"  
				Sortable="Y" 
				AllowURLParam="N" 
				Translatable="N" 
				OnEventLog="N" 
				Link="javascript:;">
			<EventHandler Name="fld_share_onclick" 
							Event="onclick" 
							Function="LoadDialog(common.form.DataSharingForm,{literal}{@:Elem[fld_Id].Value}{/literal})"/>		
		</Element>
{/if}
{elseif $fld.Field == 'status'}
		<Element Name="fld_status" 
					Class="ColumnBool" 
					FieldName="status" 
					Label="Status"  
					Sortable="Y" 
					AllowURLParam="N" 
					Translatable="N" 
					OnEventLog="N" 
					Link="javascript:;">
			<EventHandler Name="fld_status_onclick" 
							Event="onclick" 
							Function="UpdateFieldValueXor({literal}{@:Elem[fld_Id].Value}{/literal},fld_status,{literal}{@:Elem[fld_status].Value}{/literal})"/>		
		</Element>
{elseif $fld.Type != 'timestamp'  && 
		$fld.Field != 'create_by' && 
		$fld.Field != 'create_time' && 
		$fld.Field != 'update_by' && 
		$fld.Field != 'update_time' && 
		$fld.Field != 'type_id' &&
		$fld.Field != 'owner_id' &&
		$fld.Field != 'group_id' &&
		$fld.Field != 'group_perm' &&
		$fld.Field != 'other_perm' 
		}
{if $col_counter==0}
		<Element Name="fld_{$fld.Field}" 
        			Class="ColumnText" 
        			FieldName="{$fld.Field}" 
        			Label="{$fld.FieldLabel}"         			 
        			Sortable="Y" 
        			MaxLength="15"
        			Link="{literal}{APP_INDEX}{/literal}/{$detail_view_url}/{literal}{@:Elem[fld_Id].Value}{/literal}"        			
        			{if $fld.Default != 'NULL' && $fld.Default != '' }DefaultValue="{$fld.Default}"{/if} /> 
{else}
		<Element Name="fld_{$fld.Field}" 
        			Class="ColumnText" 
        			FieldName="{$fld.Field}" 
        			Label="{$fld.FieldLabel}" 
        			MaxLength="15"        			 
        			Sortable="Y"
        			{if $fld.Default != 'NULL' && $fld.Default != '' }DefaultValue="{$fld.Default}"{/if} />        			
{/if}        	
{assign var=col_counter value=$col_counter+1}
{/if}     
{/foreach}
{if $features.data_type eq 1}
		<Element Name="fld_color" 
				Class="ColumnStyle" 
				FieldName="type_color" 
				Label="Type"  
				Sortable="Y" 
				AllowURLParam="N" 
				Translatable="N" 
				OnEventLog="N" />
				
		<Element Name="fld_type" 
				Class="ColumnText"  
				Style="line-height:24px;" 
				FieldName="type_name" 
				Label="Type"  
				Sortable="Y" 
				AllowURLParam="N" 
				Translatable="N" 
				OnEventLog="N" />						        
{/if}  
    </DataPanel>
	<ActionPanel>
		<Element Name="btn_add" 
				Class="Button" 
				Text="Add" 
				CssClass="button_gray_add">
            <EventHandler Name="add_onclick" 
            			Event="onclick" 
            			Function="LoadDialog({$quick_add_widget_form_full_name})"/>
        </Element>
        <Element Name="btn_spacer" 
        		Class="Spacer" 
        		Width="10" /> 
        		   
        <Element Name="btn_pick" 
        		Class="Button" 
        		Text="Pick Docs" 
        		CssClass="button_gray_w">
            <EventHandler Name="pick_onclick" 
            			Event="onclick" 
            			Function="LoadDialog({$pick_widget_form_full_name})"/>
        </Element>
        <Element Name="btn_remove" 
        		Class="Button" 
        		Text="Remove" 
        		CssClass="button_gray_w">
            <EventHandler Name="remove_onclick" 
            			Event="onclick" 
            			Function="RemoveRecord()"/>
        </Element>
    </ActionPanel> 
    <NavPanel>
    	{literal}
    	<!-- Page Selector -->
		<Element  Name="page_selector" 
					Class="PageSelector" 
					Text="{@:m_CurrentPage}" 
					Label="Go to Page" 
					CssClass="input_select" 
					CssFocusClass="input_select_focus">
            <EventHandler Name="btn_page_selector_onchange" 
            				Event="onchange" 
            				Function="GotoSelectedPage(page_selector)"/>
        </Element>
        
        <!-- Page Size Selector -->
        <Element  Name="pagesize_selector" 
        			Class="PagesizeSelector" 
        			Text="{@:m_Range}" 
        			Label="Show Rows" 
        			CssClass="input_select" 
        			CssFocusClass="input_select_focus">
            <EventHandler Name="btn_pagesize_selector_onchange" 
            				Event="onchange" 
            				Function="SetPageSize(pagesize_selector)"/>
        </Element> 
        
        <!-- Goto First Page Button -->   
        <Element  Name="btn_first" 
        			Class="Button" 
        			Enabled="{(@:m_CurrentPage == 1)?'N':'Y'}" 
        			CssClass="button_gray_navi {(@:m_CurrentPage == 1)?'first_gray':'first'}">
            <EventHandler Name="first_onclick" 
            				Event="onclick" 
            				Function="GotoPage(1)"/>
        </Element>
        
        <!-- Goto Previous Page Button -->   
        <Element Name="btn_prev" 
        			Class="Button" 
        			Enabled="{(@:m_CurrentPage == 1)?'N':'Y'}" 
        			CssClass="button_gray_navi {(@:m_CurrentPage == 1)?'prev_gray':'prev'}">
            <EventHandler Name="prev_onclick" 
            				Event="onclick" 
            				Function="GotoPage({@:m_CurrentPage - 1})" 
            				ShortcutKey="Ctrl+Shift+Left"/>
        </Element>
        
        <!-- Display Current Page / Total Pages -->
        <Element Name="txt_page" 
        			Class="LabelText" 
        			Text="{'@:m_CurrentPage of @:m_TotalPages '}">
        </Element>
        
        <!-- Goto Next Page Button -->  
        <Element Name="btn_next" 
        			Class="Button" 
        			Enabled="{(@:m_CurrentPage == @:m_TotalPages )?'N':'Y'}" 
        			CssClass="button_gray_navi {(@:m_CurrentPage == @:m_TotalPages)?'next_gray':'next'}">
            <EventHandler Name="next_onclick" 
            				Event="onclick" 
            				Function="GotoPage({@:m_CurrentPage + 1})" 
            				ShortcutKey="Ctrl+Shift+Right"/>
        </Element>
        
        <!-- Goto Last Page Button -->  
        <Element  Name="btn_last" 
        			Class="Button" 
        			Enabled="{(@:m_CurrentPage == @:m_TotalPages )?'N':'Y'}" 
        			CssClass="button_gray_navi {(@:m_CurrentPage == @:m_TotalPages)?'last_gray':'last'}">
            <EventHandler Name="last_onclick" 
            				Event="onclick" 
            				Function="GotoPage({@:m_TotalPages})"/>
        </Element>
        {/literal}
    </NavPanel> 


</EasyForm>
