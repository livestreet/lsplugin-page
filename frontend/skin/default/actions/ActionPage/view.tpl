{**
 * Отображение страницы
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_options' prepend}
	{$layoutNoSidebar = !Config::Get('plugin.page.show_block_structure')}
{/block}

{block name='layout_page_title'}
	{$oPage->getTitle()|escape}
{/block}

{block name='layout_content'}
	{capture page_text}
		{if !$oPage->getAutoBr() or Config::Get('view.wysiwyg')}
			{$oPage->getText()}
		{else}
			{$oPage->getText()|nl2br}
		{/if}
	{/capture}

	{component 'text' text=$smarty.capture.page_text}

	{if $oUserCurrent and $oUserCurrent->isAdministrator()}
		<br />
		{component 'button' url=$oPage->getAdminEditWebUrl() mods='primary' text='Редактировать'}
	{/if}
{/block}