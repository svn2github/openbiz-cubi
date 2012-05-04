<?xml version="1.0" standalone="no"?>
<BizDataObj Name="{$do_name}" 
		Description="{$do_desc}" 
		Class="BizDataObj" 
		DataPermControl="N"
		DBName="{$db_name}" 
		Table="{$table_name}" 
		Uniqueness="{$uniqueness}" 
		Stateless="N" 
		IdGeneration="Identity" 
		CacheLifeTime="0" 
		>
	<BizFieldList>
	    <BizField Name="Id" Description="Record ID"	Column="id" Type=""/>
        <BizField Name="{$table_ref_id}" Description="Main Record ID"	Column="{$table_ref_id}" Type=""/>
        <BizField Name="related_id" Description="Related Record ID"	Column="related_id" Type=""/>
    </BizFieldList>
    <TableJoins>
    </TableJoins>
    <ObjReferences>
    </ObjReferences>
</BizDataObj>