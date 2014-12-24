{**
 * Статистика по пользователям
 *
 * @styles css/blocks.css
 *}

{extends 'components/block/block.tpl'}

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
				name       = 'pages_tree'
				classes    = 'actionbar-item-link'
				activeItem = $oCurrentPage->getUrlFull()
				mods       = 'stacked pills'
				items      = $aItems}
{/block}