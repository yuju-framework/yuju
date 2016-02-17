<style>
    .sortable-{$name} { list-style-type: none; margin: 0; padding: 0; width: 60%; background-color: lightgrey; min-height:20px; cursor: move;}
    .sortable-{$name} li { margin: 0 3px 3px 3px; padding: 0.4em;}
    .sortable-{$name} li:hover { margin: 0 3px 3px 3px; padding: 0.4em; background-color: lightblue; }
    .sortable-{$name} li span { position: absolute; margin-left: -1.3em; }
</style>

<div class="col-lg-6">
    Available
    <ul id="sortable1-{$name}" class="sortable-{$name}">
        {foreach from=$list1 item="listitem"}
            {if !in_array($listitem, $list2)}
                <li class="ui-state-default">{$listitem}</li>
            {/if}
        {/foreach}
    </ul>
</div>
<div class="col-lg-6">
    In Use
    <ul id="sortable2-{$name}" class="sortable-{$name}">
        {foreach from=$list2 item="listitem"}
            <li class="ui-state-default">{$listitem}</li>
        {/foreach}
    </ul>
</div>
<input type="hidden" name="text-{$name}" value="" id="text-{$name}">
<script type="text/javascript">
        $("ul.sortable-{$name}").sortable({
            connectWith: ".sortable-{$name}",
            update: function(event, ui) {
                var textOutput = "[";
                $("#sortable2-{$name} li").each(function(i) {
                    //textOutput += '"{$DOMAIN}css/' + $(this).text() + '",';
                    textOutput += '"{$startString}' + $(this).text() + '",';
                });
                textOutput = textOutput.slice(0, -1) + "]";
            }
        });
        $("ul.sortable-{$name}").disableSelection();
</script>