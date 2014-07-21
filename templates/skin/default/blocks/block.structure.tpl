{**
 * Статистика по пользователям
 *
 * @styles css/blocks.css
 *}

{extends file='blocks/block.aside.base.tpl'}

{block name='block_title'}Навигация по страницам{/block}

{block name='block_content'}

		{foreach $aPagesTree as $aPage}
			{$oPage=$aPage.entity}
			{$aItems[] = [
				'text'       => ($oPage->getTitle()|escape),
				'url'        => $oPage->getWebUrl(),
				'attributes' => " style=\"margin-left: {$aPage.level * 20}px;\"",
				'name'		 => $oPage->getUrlFull()
			]}
		{/foreach}

		{include 'components/nav/nav.tpl'
				sName       = 'pages_tree'
				sClasses    = 'actionbar-item-link'
				sActiveItem = $oCurrentPage->getUrlFull()
				sMods       = 'stacked pills'
				aItems      = $aItems}
{/block}