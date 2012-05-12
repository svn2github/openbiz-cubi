<?xml version="1.0" standalone="no"?>
<Module Name="{$mod_name}" 
		Description="{$mod_description}" 
		Version="{$mod_version}" 
		OpenbizVersion="3.0" 
		Author="{$mod_author}"
		LoadHandler="{$mod_loader}" >
	<ACL>		
		<Resource Name="collab_statistics">
			<Action Name="access" 
					Description="access collaboration system statistics"/>
		</Resource>
	</ACL>
	<Menu>
        <MenuItem Name="Collab_Statistics" 
        			Title="Statistics" 
        			Parent="collab" 
        			Description="" 
        			IconImage="spacer.gif" 
        			IconCssClass="icon_statistics" 
        			Order="110" 
        			Access="collab_statistics.access" >
			<MenuItem Name="Collab_Statistics.TypeStat" 
						Title="Data Type Statistics" 
						Description=""  
						URL="{@home:url}/collab/statistics_type" 
						Access="collab_statistics.access" 
						Order="10" />			
		</MenuItem>	
	</Menu>
	<Dependency>
		<Module Name="system"/>
		<Module Name="menu"/>
	</Dependency>
	<ChangeLog>                	
		<Version Name="0.1">    		    		
			<Change Name="feature_05.01" 
					Type="New_Feature" 
					Status="Finished" 
					PublishDate="2011-12-05" 
					Description="Release with an advanced Message module" />
		</Version>       
	</ChangeLog>    
</Module>