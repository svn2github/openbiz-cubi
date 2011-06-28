<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>{$description}</title>
  <link rel="stylesheet" href="{$css_url}/general.css" type="text/css" />
  {$style_sheets}
  {$scripts}
  <link rel="stylesheet" href="{$css_url}/tool.css" type="text/css" />
</head>
<body style="height:95%;background-color:#ffffff;">

<!-- main -->
<div style="margin: 10">
<table width=100% border=0 cellspacing=0 cellpadding=0>
{foreach item=form from=$forms}
   <tr><td>{$form}</td></tr>
{/foreach}
</table>
</div>

</body>
</html>
