{if !isset($id)}{$id=''}{/if}
<div>
<b>{_("Edit Google Analytics Module")}</b>
<form method="post" action="">
	{_("Id")}: {html_text name="id" value=$id}
	{html_submit name="sb--ga--$idmod" value="{_("Save")}"}
</form>
</div>