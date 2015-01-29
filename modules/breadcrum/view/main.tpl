<div class="breadcrum">
    
    {if isset ($href)}
        {foreach key=key item=item from=$href}
            {if $item@first}
                <a href="{$DOMAIN}">{$item}</a>>                
            {else if $item@last}
                {$item}
            {else}
                <a href="{$DOMAIN}{$key}">{$item}</a>> 
            {/if}
            
        {/foreach}
    {/if}    
</div>
