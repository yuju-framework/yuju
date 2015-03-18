{if !isset($urlfail)}{$urlfail=''}{/if}
{if !isset($role)}{$role=''}{/if}
<div>
<b>{_("Edit ACL")}</b>
<form method="post" action="">
	{_("URL Fail")}: {html_text name="urlfail" value=$urlfail}
	{_("Role")}: {html_text name="role" value=$role}
	{html_submit name="sb--acl--$idmod" value="{_("Save")}"}
</form>
</div>