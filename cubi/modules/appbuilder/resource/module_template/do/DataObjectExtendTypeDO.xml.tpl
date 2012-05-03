<?xml version="1.0" standalone="no"?>
<BizDataObj Name="{$do_name}" 
	Description="{$do_desc}" 
	DataPermControl="{$do_perm_control}" 
	Class="BizDataObj" 
	DBName="{$db_name}" 
	Table="{$table_type_name}" 
	SearchRule="" 
	SortRule="" 
	OtherSQLRule="" 
	Uniqueness="name" 
	Stateless="N" 
	IdGeneration="Identity" 
	CacheLifeTime="0">
	<BizFieldList>
		<BizField Name="Id" Column="id"     Type=""/>
		<BizField Name="name" Column="name" Length="255"   Required="Y" Type=""/>
		<BizField Name="description" Column="description"    Required="Y" Type=""/>
		<BizField Name="color" Column="color"  Type="Text"/>
		<BizField Name="sortorder" Column="sortorder"    Required="Y" Type=""/>
{if $do_perm_control eq 'Y'}	    
		<BizField Name="group_id" Column="group_id" ValueOnCreate="{literal}{@profile:default_group}{/literal}"   Required="N" Type="Number"/>
		<BizField Name="group_perm" Column="group_perm" ValueOnCreate="{literal}{BizSystem::GetDefaultPerm(group)}{/literal}"   Required="N" Type="Number"/>
		<BizField Name="other_perm" Column="other_perm" ValueOnCreate="1"   Required="N" Type="Number"/>   		
{/if}	    
		<BizField Name="create_by" Column="create_by" Type="Number" ValueOnCreate="{literal}{@profile:Id}{/literal}"/>
		<BizField Name="create_time" Column="create_time" Type="Datetime" ValueOnCreate="{literal}{date('Y-m-d H:i:s')}{/literal}"/>
		<BizField Name="update_by" Column="update_by" Type="Number" ValueOnCreate="{literal}{@profile:Id}{/literal}" ValueOnUpdate="{literal}{@profile:Id}{/literal}"/>
		<BizField Name="update_time" Column="update_time" Type="Datetime" ValueOnCreate="{literal}{date('Y-m-d H:i:s')}{/literal}" ValueOnUpdate="{literal}{date('Y-m-d H:i:s')}{/literal}"/>
	 </BizFieldList>
    <TableJoins>
    </TableJoins>
    <ObjReferences>
        <Object Name="{$record_do_full_name}" Description="Reference to Main Data Record" Relationship="1-M" Table="{$table_name}" Column="type_id" FieldRef="Id" onDelete="Restrict"/>
		<Object Name="extend.do.ExtendSettingDO" Description="Reference to Extend Data Field Setting Records" Relationship="1-M" Table="extend_setting" CondColumn='module' CondValue='{$table_name}' Column="type_id" FieldRef="Id" onDelete="Cascade"/>    
    </ObjReferences>
</BizDataObj>