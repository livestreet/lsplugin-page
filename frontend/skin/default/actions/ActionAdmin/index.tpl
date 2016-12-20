{**
 * Список страниц
 *
 * @param array $aPageItems Список страниц
 *}

<h3 class="page-sub-header">{$aLang.plugin.page.titles.list}</h3>

{component 'admin:button'  text = $aLang.plugin.page.actions.create mods='primary' url = {$oAdminUrl->get('create')}}

<br>
<br>

{if $aPageItems}
	<table class="ls-table">
		<thead>
			<tr>
				<th>{$aLang.plugin.page.admin.list.title}</th>
				<th>{$aLang.plugin.page.admin.list.url}</th>
				<th class="text-center" width="100">{$aLang.plugin.page.admin.list.active}</th>
				<th class="text-center" width="100">{$aLang.plugin.page.admin.list.index}</th>
				<th class="ls-table-cell-actions" width="100">{$aLang.plugin.page.admin.list.action}</th>
			</tr>
		</thead>

		<tbody>
			{foreach $aPageItems as $aPageItem}
				{$oPageItem=$aPageItem.entity}
				<tr id="article-item-{$oPageItem->getId()}">
					<td>
						{component 'icon'
							icon = (( $aPageItem.level == 0 ) ? 'folder' : 'file')
							attributes = [
								style => "margin-left: {$aPageItem.level*20}px"
							]}
						<a href="{$oPageItem->getWebUrl()}">{$oPageItem->getTitle()|escape}</a>
					</td>
					<td>
						{$oPageItem->getUrlFull()}
					</td>
					<td class="text-center">{($oPageItem->getActive()) ? 'да' : 'нет'}</td>
					<td class="text-center">{($oPageItem->getMain()) ? 'да' : 'нет'}</td>
					<td class="ls-table-cell-actions">
						<a href="{$oAdminUrl->get('update')}{$oPageItem->getId()}/" class="fa fa-edit" title="{$aLang.plugin.page.actions.update}"></a>
						<a href="#" class="fa fa-trash" onclick="if (confirm('Действительно удалить?')) { ls.plugin.page.admin.removePage({$oPageItem->getId()}); } return false;" title="{$aLang.plugin.page.actions.remove}"></a>
						<a href="{$oAdminUrl->get('sort/up')}{$oPageItem->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="fa fa-arrow-up" title="{$aLang.plugin.page.actions.sort_up}"></a>
						<a href="{$oAdminUrl->get('sort/down')}{$oPageItem->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="fa fa-arrow-down" title="{$aLang.plugin.page.actions.sort_down}"></a>
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
{else}
	{component 'admin:blankslate' text=$aLang.plugin.page.admin.list.empty}
{/if}
