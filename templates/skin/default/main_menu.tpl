{foreach from=$aPagesMain item=oPage}
	<li {if $sAction=='page' and $sEvent==$oPage->getUrl()}class="active"{/if}><a href="{$oPage->getWebUrl()}" >{$oPage->getTitle()|escape}</a><i></i></li>
{/foreach}	