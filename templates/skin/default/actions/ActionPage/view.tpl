{**
 * Отображение страницы
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_options'}
	{$bNoSidebar = !Config::Get('plugin.page.show_block_structure')}
{/block}

{block name='layout_page_title'}
	{$oPage->getTitle()|escape}
{/block}

{block name='layout_content'}
	{if !$oPage->getAutoBr() or Config::Get('view.wysiwyg')}
		{$oPage->getText()}
	{else}
		{$oPage->getText()|nl2br}
	{/if}


	{if $oUserCurrent and $oUserCurrent->isAdministrator()}
		<br />
		<a href="{$oPage->getAdminEditWebUrl()}">Редактировать</a>
	{/if}
{/block}