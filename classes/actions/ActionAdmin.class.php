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

class PluginPage_ActionAdmin extends PluginAdmin_ActionPlugin {

	/**
	 * Объект УРЛа админки, позволяет удобно получать УРЛы на страницы управления плагином
	 */
	public $oAdminUrl;
	public $oUserCurrent;

	public function Init() {
		$this->oAdminUrl=Engine::GetEntity('PluginAdmin_ModuleUi_EntityAdminUrl');
		$this->oAdminUrl->setPluginCode(Plugin::GetPluginCode($this));
		$this->oUserCurrent=$this->User_GetUserCurrent();
		$this->Viewer_AppendScript(Plugin::GetWebPath(__CLASS__) . 'js/admin.js');

		$this->SetDefaultEvent('index');
	}

	/**
	 * Регистрируем евенты
	 *
	 */
	protected function RegisterEvent() {
		/**
		 * Для ajax регистрируем внешний обработчик
		 */
		$this->RegisterEventExternal('Ajax','PluginPage_ActionAdmin_EventAjax');
		/**
		 * Список статей, создание и обновление
		 */
		$this->AddEvent('index','EventIndex');
		//$this->AddEventPreg('/^(page(\d{1,5}))?$/i','/^$/i','EventIndex');
		$this->AddEvent('create','EventCreate');
		$this->AddEventPreg('/^update$/i','/^\d{1,6}$/i','/^$/i','EventUpdate');
		/**
		 * Ajax обработка
		 */
		$this->AddEventPreg('/^ajax$/i', '/^page-create$/i','/^$/i', 'Ajax::EventPageCreate');
		$this->AddEventPreg('/^ajax$/i', '/^page-update$/i','/^$/i', 'Ajax::EventPageUpdate');
		$this->AddEventPreg('/^ajax$/i', '/^page-remove$/i','/^$/i', 'Ajax::EventPageRemove');
	}

	/**
	 *	Вывод списка статей
	 */
	protected function EventIndex() {
		/**
		 * Получаем список страниц
		 */
		$aPages=$this->PluginPage_Main_LoadTreeOfPage(array('#order' => array('sort' => 'desc')));
		$aPages=ModuleORM::buildTree($aPages);
		/**
		 * Прогружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aPageItems',$aPages);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('index');
	}

	/**
	 * Создание статьи. По факту только отображение шаблона, т.к. обработка идет на ajax
	 */
	protected function EventCreate() {
		/**
		 * Получаем список категорий для данного типа
		 */
		$aPages=$this->PluginPage_Main_LoadTreeOfPage(array('#order' => array('sort' => 'desc')));
		$aPages=ModuleORM::buildTree($aPages);

		$this->Viewer_Assign('aPageItems', $aPages);
		$this->SetTemplateAction('create');
	}

	/**
	 * Редактирование статьи
	 */
	protected function EventUpdate() {
		/**
		 * Проверяем статью на существование
		 */
		if (!($oPage=$this->PluginPage_Main_GetPageById($this->GetParam(0)))) {
			$this->Message_AddErrorSingle('Не удалось найти страницу',$this->Lang_Get('error'));
			return $this->EventError();
		}

		$this->Viewer_Assign("oPage",$oPage);
		$this->SetTemplateAction('create');
	}
}