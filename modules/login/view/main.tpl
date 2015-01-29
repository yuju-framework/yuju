<div id="login">
{if $module == 'false' && $activeuser->isLogin()}
{_("Hello, ")}{$activeuser->getNombre()}
{else}
<form action="{$smarty.server.REQUEST_URI}" method="post">
<div><span style="width:65px;">{_("e-mail")}</span> {html_text name="user" size="20"}</div>
<div><span style="width:65px;">{_("pass")}</span> {html_pass name="pass" size="20"}</div>
<div>{html_submit name="login" value="{_("Log In")}"}</div>
</form>
{/if}
</div>