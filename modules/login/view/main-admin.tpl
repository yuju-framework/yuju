{if !isset($urlvalid)}{$urlvalid=''}{/if}
{if !isset($module)}{$module=''}{/if}
<div>
<b>{_("Edit Login")}</b>
<form method="post" action="">
{_("URL valid")}: {html_text name="urlvalid" value={$urlvalid}}<br />
{_("module")}: {html_text name="module" value={$module}}<br />
{html_submit name="sb--login--$idmod" value="{_("Save")}"}
</form>