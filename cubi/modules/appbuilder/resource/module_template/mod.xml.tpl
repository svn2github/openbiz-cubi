<?xml version="1.0" standalone="no"?>
<Module Name="{$mod_name}" 
		Description="{$mod_description}" 
		Version="{$mod_version}" 
		OpenbizVersion="3.0" 
		Author="{$mod_author}"
		LoadHandler="{$mod_loader}" >
	<ACL>
{foreach from=$resource_acl key=resource item=acl}
		<Resource Name="{$resource}">
{foreach from=$acl key=name item=description}
			<Action Name="{$name}" 
					Description="{$description}"/>
{/foreach}
		</Resource>
{/foreach}
	</ACL>
	<Menu>
		<MenuItem Name="{$mod_name}" 
				Title="{$mod_label}" 
				Description="" 
				URL="{$mod_root_uri}" 
				Order="50" 
				Access="{$mod_name}.Access">		
{assign var=menu_order value=50}
{foreach from=$menu item=menuitem}
	        <MenuItem Name="{$menuitem.name}" 
	        			Title="{$menuitem.title}" 	        			
	        			Description="{$menuitem.description}" 
	        			URL="{$menuitem.uri}" 
	        			IconImage="spacer.gif" 
	        			IconCssClass="{$menuitem.icon_css}" 
	        			Order="{$menu_order}" 
	        			Access="{$menuitem.acl}" >
{assign var=submenu_order value=50}
{foreach from=$menuitem.child item=submenuitem}	        			
				<MenuItem Name="{$submenuitem.name}" 
		        			Title="{$submenuitem.title}" 	        			
		        			Description="{$submenuitem.description}" 
		        			URL="{$submenuitem.uri}" 
		        			IconImage="spacer.gif" 
		        			IconCssClass="{$submenuitem.icon_css}" 
		        			Order="{$submenu_order}" 
		        			Access="{$submenuitem.acl}" >
{assign var=submenu3_order value=50}
{foreach from=$submenuitem.child item=submenu3item}
						<MenuItem Name="{$submenu3item.name}" 
				        			Title="{$submenu3item.title}" 	        			
				        			Description="{$submenu3item.description}" 
				        			URL="{$submenu3item.uri}" 
				        			IconImage="spacer.gif" 
				        			IconCssClass="{$submenu3item.icon_css}" 
				        			Order="{$submenu3_order}" 
				        			Access="{$submenu3item.acl}" />
{assign var=submenu3_order value=$submenu3_order+10}
{/foreach}
		        </MenuItem>		
{assign var=submenu_order value=$submenu_order+10}
{/foreach}
			</MenuItem>
{assign var=menu_order value=$menu_order+10}
{/foreach}
		</MenuItem>	
	</Menu>
	<Dependency>
{foreach from=$modules item=module}
		<Module Name="{$name}" /> 
{/foreach}
	</Dependency>	
	<ChangeLog>
{foreach from=$change_logs item=version}	
		<Version Name="{$version}">
	    	<Change Name="{$name}" 
	    			Type="{$type}"  
	    			Status="{$finished}" 
	    			PublishDate="{$publish_date}" 
	    			Description="{$description}" />
	    </Version>
{/foreach}	    
	</ChangeLog>    
</Module>