<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>{$description}</title>
  <link rel="stylesheet" href="../css/openbiz.css" type="text/css">
  <link rel="stylesheet" href="../css/ticket.css" type="text/css">
  {$style_sheets}
  {$scripts}
</head>
<body bgcolor="#EDEDED">

{php} 
$this->assign('header', MODULE_PATH.'/common/templates/header.tpl'); 
$this->assign('footer', MODULE_PATH.'/common/templates/footer.tpl'); 
{/php}

<!-- header -->
<div style="margin-top:20px">
{include file=$header}
</div>

<!-- main -->
<table border=0 cellspacing=10 cellpadding=0 width=100%>
<tr>
<td width=150 valign=top>
   <div class="arrowlistmenu">
   <h3 class="headerbar">System Administration</h3>
   <ul>
   <li><a href="controller.php?view=system.user.v_user&form=system.user.f_userList">Users</a></li>
   <li><a href="controller.php?view=system.role.v_role&form=system.role.f_roleList">Roles</a></li>
   <li><a href="controller.php?view=system.module.v_module&form=system.module.f_moduleList">Modules</a></li>
   <!--<li><a href="controller.php?view=system.acl.v_acl_action&form=system.acl.f_acl_actionList">Permission</a></li>-->
   </ul>
   </div>
</td>
<td>
<div style="width:100%">
<table width=100% border=0 cellspacing=10 cellpadding=0>
{foreach item=form from=$forms}
   <tr><td>{$form}</td></tr>
{/foreach}
</table>
</div>
</td>
</tr>
</table>

<!-- footer -->
<div style="margin-top:20px">
{include file=$footer}
</div>

</body>
</html>
