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
class PluginPage_ModuleMedia extends PluginPage_Inherit_ModuleMedia
{

    /**
     * Проверка владельца с типом "page"
     * Название метода формируется автоматически
     *
     * @param int|null $iTargetId ID владельца, для новых объектов может быть не определен
     * @param string $sAllowType Тип доступа, константа self::TYPE_CHECK_ALLOW_*
     * @param array $aParams Дополнительные параметры, всегда есть ключ 'user'
     *
     * @return bool
     */
    public function CheckTargetPage($iTargetId, $sAllowType, $aParams)
    {
        if (!$oUser = $aParams['user']) {
            return false;
        }
        if (!$oUser->isAdministrator()) {
            return false;
        }
        if (in_array($sAllowType,
            array(self::TYPE_CHECK_ALLOW_ADD, self::TYPE_CHECK_ALLOW_PREVIEW, self::TYPE_CHECK_ALLOW_VIEW_LIST))) {
            if (is_null($iTargetId)) {
                /**
                 * Разрешаем для всех новых
                 */
                return true;
            }
            if ($oPage = $this->PluginPage_Main_GetPageById($iTargetId)) {
                return true;
            }
        } else {
            return $this->CheckStandartMediaAllow($sAllowType, $aParams);
        }
        return false;
    }
}