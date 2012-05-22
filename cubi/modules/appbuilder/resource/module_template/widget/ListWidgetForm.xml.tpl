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
    <ActionPanel /> 
    <NavPanel />     
</EasyForm>
