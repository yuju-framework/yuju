<div>
    <form method="post" action="">
        <b>{_("Edit content")}</b> 
        <script type="text/javascript" src="{$DOMAIN}js/ckeditor/ckeditor.js"></script>
        <div contenteditable="true" id="contenthtml{$idmod}" style="min-height:50px;border:1px dotted red;">{if isset($value)}{$value}{/if}</div>
        <input type="hidden" id="value--html--{$idmod}" name="value" value="" />
        {html_submit name="sb--html--$idmod" id="sb--html--$idmod" value="{_("Save")}"}
        <script>
            $('#sb--html--{$idmod}').click(function() {
                $('#value--html--{$idmod}').val(CKEDITOR.instances.contenthtml{$idmod}.getData());
            });
        </script>
    </form>
</div>