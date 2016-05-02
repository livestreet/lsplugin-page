{**
 * Добавление/редактирование страницы
 *
 * @param array $oPage Объект редактируемой страницы
 *}


<h3 class="page-sub-header">
	{if $oPage}
		Редактирование страницы
	{else}
		Добавление страницы
	{/if}
</h3>

<form id="form-page-create" enctype="multipart/form-data" action="" method="post" onsubmit="{if $oPage}ls.plugin.page.admin.updatePage('form-page-create');{else}ls.plugin.page.admin.createPage('form-page-create');{/if} return false;">

	{$aCategoriesList[] = [
		'value' => '',
		'text' => ''
	]}
	{foreach $aPageItems as $aPageItem}
		{$aCategoriesList[] = [
		'text' => ''|str_pad:(2*$aPageItem.level):'-'|cat:$aPageItem['entity']->getTitle(),
		'value' => $aPageItem['entity']->getId()
	]}
	{/foreach}
	{component 'admin:field' template='select'
		name          = 'page[pid]'
		label         = 'Вложить в'
		inputClasses  = 'width-200'
		items         = $aCategoriesList
		selectedValue = ($oPage) ? $oPage->getPid() : '' }

	{component 'admin:field' template='text'
		name  = 'page[title]'
		value = (($oPage) ? $oPage->getTitle() : '')
		label = 'Название'}

	{component 'admin:field' template='text'
		name  = 'page[url]'
		value = ($oPage) ? $oPage->getUrl() : ''
		label = 'URL'}

	{component 'admin:editor'
		name            = 'page[text]'
		value           = (($oPage) ? $oPage->getText() : '')
		label           = 'Текст'
		inputClasses    = 'js-editor-default'}

	{component 'admin:field' template='text'
		name  = 'page[seo_keywords]'
		value = (($oPage) ? $oPage->getSeoKeywords() : '')
		label = 'SEO Keywords'}

	{component 'admin:field' template='text'
		name  = 'page[seo_description]'
		value = (($oPage) ? $oPage->getSeoDescription() : '')
		label = 'SEO Description'}

	{component 'admin:field' template='text'
		name  = 'page[sort]'
		value = ($oPage) ? $oPage->getSort() : ''
		label = 'Сортировка'}

	{component 'admin:field' template='checkbox'
		name  = 'page[auto_br]'
		checked = ($oPage) ? $oPage->getAutoBr() : 0
		label = 'Делать автопереносы строк'}

	{component 'admin:field' template='checkbox'
		name  = 'page[active]'
		checked = ($oPage) ? $oPage->getActive() : 0
		label = 'Показывать'}

	{component 'admin:field' template='checkbox'
		name  = 'page[main]'
		checked = ($oPage) ? $oPage->getMain() : 0
		label = 'Выводить на главную'}

	<br/>

	{* Кнпоки *}
	{if $oPage}{component 'admin:field' template='hidden' name='page[id]' value=$oPage->getId()}{/if}
	{component 'admin:button'
		name = 'page[submit]'
		text = {lang "{( ! $oPage ) ? 'common.create' : 'common.save'}"}
		mods = 'primary'}
</form>


<script>
	jQuery(document).ready(function($){
		$( '.js-editor-default' ).lsEditor();
	});
</script>
