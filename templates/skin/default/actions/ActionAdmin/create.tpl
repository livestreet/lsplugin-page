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
	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.select.tpl"
			sFieldName          = 'page[pid]'
			sFieldLabel         = 'Вложить в'
			sFieldClasses       = 'width-200'
			aFieldItems         = $aCategoriesList
			sFieldSelectedValue = $_aRequest.page.pid}


	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
			 sFieldName  = 'page[title]'
			 sFieldValue = (($oPage) ? $oPage->getTitle() : '')|escape
			 sFieldLabel = 'Название'}


	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
			sFieldName  = 'page[url]'
			sFieldValue = ($oPage) ? $oPage->getUrl() : ''
			sFieldLabel = 'URL'}


	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.textarea.tpl"
			sFieldName            = 'page[text]'
			sFieldValue           = (($oPage) ? $oPage->getText() : '')|escape
			sFieldLabel           = 'Текст'}


	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
			sFieldName  = 'page[seo_keywords]'
			sFieldValue = (($oPage) ? $oPage->getSeoKeywords() : '')|escape
			sFieldLabel = 'SEO Keywords'}


	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
			sFieldName  = 'page[seo_description]'
			sFieldValue = (($oPage) ? $oPage->getSeoDescription() : '')|escape
			sFieldLabel = 'SEO Description'}


	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
			sFieldName  = 'page[sort]'
			sFieldValue = (($oPage) ? $oPage->getSort() : '')|escape
			sFieldLabel = 'Сортировка'}


	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
			sFieldName  = 'page[auto_br]'
			bFieldChecked = ($oPage) ? $oPage->getAutoBr() : 0
			sFieldLabel = 'Делать автопереносы строк'}


	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
			sFieldName  = 'page[active]'
			bFieldChecked = ($oPage) ? $oPage->getActive() : 0
			sFieldLabel = 'Показывать'}


	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
			sFieldName  = 'page[main]'
			bFieldChecked = ($oPage) ? $oPage->getMain() : 0
			sFieldLabel = 'Выводить на главную'}

	<br/>

	{* Кнпоки *}
	{if $oPage}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.tpl" sFieldName='page[id]' sFieldValue=$oPage->getId()}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'page[submit]'
				 sFieldStyle = 'primary'
				 sFieldText  = 'Сохранить'}
	{else}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				 sFieldName  = 'page[submit]'
				 sFieldStyle = 'primary'
				 sFieldText  = 'Добавить'}
	{/if}
</form>
