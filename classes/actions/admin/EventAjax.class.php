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
 * Часть экшена админки по управлению ajax запросами
 */
class PluginPage_ActionAdmin_EventAjax extends Event
{

    public function Init()
    {
        /**
         * Устанавливаем формат ответа
         */
        $this->Viewer_SetResponseAjax('json');
    }

    /**
     * Обработка добавления страницы
     */
    public function EventPageCreate()
    {
        /**
         * Создаем страницу
         */
        $oPage = Engine::GetEntity('PluginPage_ModuleMain_EntityPage');
        /**
         * Загружаем данные из реквеста (массив page) в объект
         * Поля массива должны совпадать с полями в $aValidateRules у объекта
         */
        $oPage->_setDataSafe(getRequest('page'));
        /**
         * Валидируем
         */
        if ($oPage->_Validate()) {
            /**
             * Добавляем в БД
             */
            if ($oPage->Add()) {
                $this->Viewer_AssignAjax('sUrlRedirect', $this->oAdminUrl->get(null, 'page'));
                $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'));
            } else {
                $this->Message_AddError('Возникла ошибка при добавлении', $this->Lang_Get('common.error.error'));
            }
        } else {
            $this->Message_AddError($oPage->_getValidateError(), $this->Lang_Get('common.error.error'));
        }
    }

    /**
     * Обработка обновления страницы
     */
    public function EventPageUpdate()
    {
        /**
         * Данные статьи из реквеста
         */
        $aPageRequest = getRequest('page');
        /**
         * Проверяем статью на существование
         */
        if (!(isset($aPageRequest['id']) and $oPage = $this->PluginPage_Main_GetPageById($aPageRequest['id']))) {
            $this->Message_AddErrorSingle('Не удалось найти страницу', $this->Lang_Get('common.error.error'));
            return;
        }
        $oPage->_setDataSafe($aPageRequest, array('auto_br', 'active', 'main'));
        /**
         * Валидируем
         */
        if ($oPage->_Validate()) {
            /**
             * Обновляем страницу
             */
            if ($oPage->Update()) {
                /**
                 * Защита от некорректного вложения
                 */
                $aPages = $this->PluginPage_Main_LoadTreeOfPage(array('#order' => array('sort' => 'desc')));
                $aPages = ModuleORM::buildTree($aPages);
                if (count($aPages) < count($this->PluginPage_Main_GetPageItemsByFilter(array()))) {
                    $oPage->setPid(null);
                    $oPage->setUrlFull($oPage->getUrl());
                    $oPage->Update();
                }
                $this->PluginPage_Main_RebuildPageUrlFull($oPage);

                $this->Message_AddNotice('Обновление прошло успешно', $this->Lang_Get('common.attention'));
                $this->Viewer_AssignAjax('sUrlRedirect', $this->oAdminUrl->get());
            } else {
                $this->Message_AddError('Возникла ошибка при обновлении', $this->Lang_Get('common.error.error'));
            }
        } else {
            $this->Message_AddError($oPage->_getValidateError(), $this->Lang_Get('common.error.error'));
        }
    }

    /**
     * Обработка удаления страницы
     */
    public function EventPageRemove()
    {
        /**
         * Проверяем страницу на существование
         */
        if (!($oPage = $this->PluginPage_Main_GetPageById(getRequestStr('id')))) {
            $this->Message_AddErrorSingle('Не удалось найти страницу', $this->Lang_Get('common.error.error'));
            return;
        }
        /**
         * Удаляем страницу
         */
        if ($oPage->Delete()) {
            $this->Message_AddNoticeSingle("Удаление прошло успешно");
            $this->Viewer_AssignAjax('sUrlRedirect', $this->oAdminUrl->get());
        } else {
            $this->Message_AddErrorSingle("Ошибка при удалении");
        }
    }
}
