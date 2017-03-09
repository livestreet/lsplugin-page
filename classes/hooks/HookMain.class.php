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
class PluginPage_HookMain extends Hook
{
    /**
     * Регистрация необходимых хуков
     */
    public function RegisterHook()
    {
        /**
         * Хук на отображение админки
         */
        $this->AddHook('init_action_admin', 'InitActionAdmin');
        /**
         * Хук на главное меню сайта
         */
        $this->AddHook('template_nav_main', 'NavMain');
    }

    /**
     * Добавляем в главное меню админки свой раздел с подпунктами
     */
    public function InitActionAdmin()
    {
        /**
         * Получаем объект главного меню
         */
        $oMenu = $this->PluginAdmin_Ui_GetMenuMain();
        /**
         * Добавляем новый раздел
         */
        $oMenu->AddSection(
            Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption($this->Lang_Get('plugin.page.admin.title'))->SetName('page')->SetUrl('plugin/page')->setIcon('file-text-o')
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption($this->Lang_Get('plugin.page.admin.menu.list'))->SetUrl(''))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption($this->Lang_Get('plugin.page.admin.menu.create'))->SetUrl('create'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption($this->Lang_Get('plugin.page.admin.menu.settings'))->SetUrl('/admin/settings/plugin/page'))
        );
    }

    /**
     * Добавляем пункты в главное меню
     *
     * @param $aParams
     *
     * @return array
     */
    public function NavMain($aParams)
    {
        $aPages = $this->PluginPage_Main_GetPageItemsByFilter(array(
            'pid'    => null,
            'main'   => 1,
            'active' => 1,
            '#order' => array('sort' => 'desc')
        ));
        $aResult = array();
        foreach ($aPages as $oPage) {
            $aResult[] = array(
                'text' => htmlspecialchars($oPage->getTitle()),
                'url'  => $oPage->getWebUrl(),
                'name' => 'page_' . $oPage->getUrl(),
            );
        }
        $aParams['items'] = array_merge($aParams['items'], $aResult);
        return $aParams['items'];
    }
}