<html>
{$ticket.url}

{$comment.author} <{$comment.author_email}> changed:

<table>
<tr>
	<th>What</th>
	<th>Removed</th>
	<th>Added</th>
</tr>
{foreach item=item key=itemName from=$comment.changes}
{if $itemName != 'comment'}
<tr>
	<td>{$itemName|capitalize}</td>
	<td>{$item.old}</td>
	<td>{$item.new}</td>
</tr>
{/if}
{/foreach}
</table>

--- Comment from {$comment.author} <{$comment.author_email}> {$comment.time} --- 
{$comment.changes.comment}

------- You are receiving this mail because: ------- You are the {$trac_role} for the bug.
</html>