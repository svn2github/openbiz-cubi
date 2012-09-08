<form id="{$form.name}" name="{$form.name}">

<div class="newapp_bg_warper">
<div class="newapp_bg" style="height:auto">
{include file="system_appbuilder_btn.tpl.html"}
<div style="height:110px;">
	<div class="newapp_title" style="width:auto;">
		<h2 style="width:auto;padding-right:20px;">{$widget.title}</h2>			
	</div>
	{if $widget.description}
	<div class="newapp_desc">
		
		<p class="input_row" style="line-height:18px;padding-bottom:0px;color:#666666;">		
		<span>{$widget.description|replace:'\n':'<br/>'}</span>
		</p>		
	</div>
	{/if}
</div>
	<div class="asset_welcome">
		<a class="asset_view_btn" href="{$app_index}/asset/asset_query"></a>
		<div class="asset_view_txt">
			<h2><a href="{$app_index}/asset/asset_manage">{t}Asset Query{/t}</a></h2>
			<p>{t}Using Barcode scanner to quickly query assets{/t}</p>
		</div>
		
		<a class="asset_manage_btn" href="{$app_index}/asset/asset_manage"></a>
		<div class="asset_manage_txt">
			<h2><a href="{$app_index}/asset/asset_manage">{t}Asset Manage{/t}</a></h2>
			<p>{t}You can manage assets data{/t}</p>
		</div>		
		
		<a class="asset_barcode_btn" href="{$app_index}/asset/gen_barcode"></a>
		<div class="asset_barcode_txt">
			<h2><a href="{$app_index}/asset/gen_barcode">{t}Barcode Generator{/t}</a></h2>
			<p>{t}Quickly generate batch of Barcodes{/t}</p>
		</div>
		
		<a class="asset_type_btn" href="{$app_index}/asset/asset_type"></a>
		<div class="asset_type_txt">
			<h2><a href="{$app_index}/asset/gen_barcode">{t}Asset Type{/t}</a></h2>
			<p>{t}You can manage types for assets{/t}</p>
		</div>
	</div>
	<div  style="height:40px; padding-top:40px;color:#999999;font-size: 11px;padding-left: 10px;padding-top: 5px;">
	{t}The application is designed for Openbiz Cubi Platform.{/t}
	</div>
</div>
</div>
</form>		