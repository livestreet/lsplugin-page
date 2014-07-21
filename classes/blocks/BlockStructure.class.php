<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/**
 * Обработка блока
 *
 * @package blocks
 * @since 1.0
 */
class PluginPage_BlockStructure extends Block {
	/**
	 * Запуск обработки
	 */
	public function Exec() {
		$aPages=$aCategories=$this->PluginPage_Main_LoadTreeOfPage(array('active'=>1,'#order'=>array('sort'=>'desc')));
		$aPages=ModuleORM::buildTree($aPages);
		$this->Viewer_Assign("aPagesTree",$aPages);
		$this->Viewer_Assign("oCurrentPage",$this->GetParam('current_page'));
	}
}