{if !isset($urlfail)}{$urlfail=''}{/if}
<div>
<b>{_("Edit ACL")}</b>
<form method="post" action="">
	{_("URL Fail")}: {html_text name="urlfail" value=$urlfail}
	{html_submit name="sb--acl--$idmod" value="{_("Save")}"}
</form>
</div>