<?php
/**
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Maxim Mzhelskiy <rus.engine@gmail.com>
 *
 */

/**
 * Хуки
 */
class PluginPage_HookMain extends Hook {
	/**
	 * Регистрация необходимых хуков
	 */
	public function RegisterHook() {
		/**
		 * Хук на отображение админки
		 */
		$this->AddHook('init_action_admin','InitActionAdmin');
		/**
		 * Хук на главное меню сайта
		 */
		$this->AddHook('template_nav_main','NavMain');
	}

	/**
	 * Добавляем в главное меню админки свой раздел с подпунктами
	 */
	public function InitActionAdmin() {
		/**
		 * Получаем объект главного меню
		 */
		$oMenu = $this->PluginAdmin_Ui_GetMenuMain();
		/**
		 * Добавляем новый раздел
		 */
		$oMenu->AddSection(
			Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Статические страницы')->SetName('page')->SetUrl('plugin/page')
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Список страниц')->SetUrl(''))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Создать')->SetUrl('create'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Настройки')->SetUrl('/admin/settings/plugin/page'))
		);
	}
	/**
	 * Добавляем пункты в главное меню
	 *
	 * @param $aParams
	 *
	 * @return array
	 */
	public function NavMain($aParams) {
		$aPages=$this->PluginPage_Main_GetPageItemsByFilter(array('#where'=>array('pid is null'=>array()),'main'=>1,'active'=>1,'#order'=>array('sort'=>'desc')));
		$aResult=array();
		foreach($aPages as $oPage) {
			$aResult[]=array(
				'text'=>htmlspecialchars($oPage->getTitle()),
				'url'=>$oPage->getWebUrl(),
				'name'=>'page_'.$oPage->getUrl(),
			);
		}
		return array_merge($aParams['aItems'],$aResult);
	}
}