{foreach Error::getErrors() as $error}
<span style="color:red; font-weight:bold;">{$error[1]}</span>
{/foreach}