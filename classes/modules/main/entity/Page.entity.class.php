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
class PluginPage_ModuleMain_EntityPage extends EntityORM
{
    /**
     * Связи с другими таблицами
     *
     * @var array
     */
    protected $aRelations = array(
        self::RELATION_TYPE_TREE,
    );

    public function Init()
    {
        parent::Init();
        /**
         * Правила валидации полей
         *
         * @var array
         */
        $this->aValidateRules[] = array('pid', 'parent_check');
        $this->aValidateRules[] = array(
            'title',
            'string',
            'allowEmpty' => false,
            'min' => 1,
            'max' => 250,
            'label' => $this->Lang_Get('plugin.page.fields.parent.label')
        );
        $this->aValidateRules[] = array(
            'url',
            'regexp', 
            'pattern' => '/^[\w\-_]+$/i',
            'allowEmpty' => false,
            'label' => $this->Lang_Get('plugin.page.fields.url.label')
        );
        $this->aValidateRules[] = array(
            'text',
            'string',
            'allowEmpty' => true,
            'min' => 1,
            'max' => 50000,
            'label' => $this->Lang_Get('plugin.page.fields.text.label')
        );
        $this->aValidateRules[] = array('text', 'text_check');
        $this->aValidateRules[] = array(
            'seo_keywords',
            'string',
            'allowEmpty' => true, 
            'min' => 1,
            'max' => 500,
            'label' => $this->Lang_Get('plugin.page.fields.seo_keywords.label')
        );
        $this->aValidateRules[] = array(
            'seo_description',
            'string',
            'allowEmpty' => true,
            'min' => 1,
            'max' => 500,
            'label' => $this->Lang_Get('plugin.page.fields.seo_description.label')
        );
        $this->aValidateRules[] = array('sort', 'sort_check');
        $this->aValidateRules[] = array('auto_br', 'auto_br_check');
        $this->aValidateRules[] = array('active', 'active_check');
        $this->aValidateRules[] = array('main', 'main_check');
    }


    public function _getTreeParentKey()
    {
        return 'pid';
    }

    /**
     * Метод автоматически выполняется перед сохранением объекта сущности (статьи)
     *
     * @return bool
     */
    protected function beforeSave()
    {
        /**
         * Если статья новая, то устанавливаем дату создания
         */
        if ($this->_isNew()) {
            $this->setDateAdd(date("Y-m-d H:i:s"));
        } else {
            $this->setDateEdit(date("Y-m-d H:i:s"));
        }
        return true;
    }

    /**
     * Выполняется перед удалением
     *
     * @return bool
     */
    protected function beforeDelete()
    {
        if ($bResult = parent::beforeDelete()) {
            /**
             * Запускаем удаление дочерних страниц
             */
            if ($aCildren = $this->getChildren()) {
                foreach ($aCildren as $oChildren) {
                    $oChildren->Delete();
                }
            }
        }
        return $bResult;
    }

    /**
     * Проверка родительской страницы
     *
     * @param string $sValue Валидируемое значение
     * @param array $aParams Параметры
     * @return bool
     */
    public function ValidateParentCheck($sValue, $aParams)
    {
        if ($this->getPid()) {
            if ($oPage = $this->PluginPage_Main_GetPageById($this->getPid())) {
                if ($oPage->getId() == $this->getId()) {
                    return $this->Lang_Get('plugin.page.fields.parent.error_descendants');
                }
                $this->setUrlFull($oPage->getUrlFull() . '/' . $this->getUrl());
            } else {
                return $this->Lang_Get('plugin.page.fields.parent.error');
            }
        } else {
            $this->setPid(null);
            $this->setUrlFull($this->getUrl());
        }
        return true;
    }

    /**
     * Установка дефолтной сортировки
     *
     * @param string $sValue Валидируемое значение
     * @param array $aParams Параметры
     * @return bool
     */
    public function ValidateSortCheck($sValue, $aParams)
    {
        if (!is_numeric($this->getSort())) {
            if (null !== ($iMin = $this->PluginPage_Main_GetMinSortFromPageByFilter())) {
                $this->setSort($iMin - 5);
            } else {
                $this->setSort(1000);
            }
        }
        return true;
    }

    /**
     * Проверка авто-переносов
     *
     * @param string $sValue Валидируемое значение
     * @param array $aParams Параметры
     * @return bool
     */
    public function ValidateAutoBrCheck($sValue, $aParams)
    {
        $this->setAutoBr($this->getAutoBr() ? 1 : 0);
        return true;
    }

    /**
     * Проверка флага активности
     *
     * @param string $sValue Валидируемое значение
     * @param array $aParams Параметры
     * @return bool
     */
    public function ValidateActiveCheck($sValue, $aParams)
    {
        $this->setActive($this->getActive() ? 1 : 0);
        return true;
    }

    /**
     * Проверка флага показа на главной
     *
     * @param string $sValue Валидируемое значение
     * @param array $aParams Параметры
     * @return bool
     */
    public function ValidateMainCheck($sValue, $aParams)
    {
        $this->setMain($this->getMain() ? 1 : 0);
        return true;
    }

    public function ValidateTextCheck($sValue)
    {
        if ($sValue) {
            $this->setTextSource($sValue);
            $this->setText($this->PluginPage_Main_ParseTextTagGallery($sValue));
        }
        return true;
    }

    /**
     * Возвращает полный URL до детального просмотра страницы
     *
     * @return string
     */
    public function getWebUrl()
    {
        return Router::GetPath('page') . $this->getUrlFull() . '/';
    }

    /**
     * Возвращает полный URL до детального просмотра страницы
     *
     * @return string
     */
    public function getAdminEditWebUrl()
    {
        return Router::GetPath('admin/plugin') . Plugin::GetPluginCode($this) . "/update/{$this->getId()}/";
    }
}