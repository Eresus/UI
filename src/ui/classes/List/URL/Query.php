<?php
/**
 * UI
 *
 * Шаблон URL с аргументами в запросе
 *
 * @version ${product.version}
 *
 * @copyright 2011, Михаил Красильников <mihalych@vsepofigu.ru>
 * @license http://www.gnu.org/licenses/gpl.txt	GPL License 3
 * @author Михаил Красильников <mihalych@vsepofigu.ru>
 *
 * Данная программа является свободным программным обеспечением. Вы
 * вправе распространять ее и/или модифицировать в соответствии с
 * условиями версии 3 либо (по вашему выбору) с условиями более поздней
 * версии Стандартной Общественной Лицензии GNU, опубликованной Free
 * Software Foundation.
 *
 * Мы распространяем эту программу в надежде на то, что она будет вам
 * полезной, однако НЕ ПРЕДОСТАВЛЯЕМ НА НЕЕ НИКАКИХ ГАРАНТИЙ, в том
 * числе ГАРАНТИИ ТОВАРНОГО СОСТОЯНИЯ ПРИ ПРОДАЖЕ и ПРИГОДНОСТИ ДЛЯ
 * ИСПОЛЬЗОВАНИЯ В КОНКРЕТНЫХ ЦЕЛЯХ. Для получения более подробной
 * информации ознакомьтесь со Стандартной Общественной Лицензией GNU.
 *
 * Вы должны были получить копию Стандартной Общественной Лицензии
 * GNU с этой программой. Если Вы ее не получили, смотрите документ на
 * <http://www.gnu.org/licenses/>
 *
 * @package UI
 *
 * $Id$
 */


/**
 * Шаблон URL с аргументами в запросе
 *
 * @package UI
 */
class UI_List_URL_Query implements UI_List_URL_Interface
{
	/**
	 * Возвращает шаблон URL для переключателя страниц
	 *
	 * @return string
	 *
	 * @since 1.00
	 */
	public function getPagination()
	{
		return $GLOBALS['page']->url(array('page' => '%d'));
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает URL для ЭУ «Удалить»
	 *
	 * @param UI_List_Item_Interface $item
	 *
	 * @return string
	 *
	 * @since 1.00
	 */
	public function getDelete(UI_List_Item_Interface $item)
	{
		return $GLOBALS['page']->url(array('id' => $item->getId(), 'action' => 'delete'));
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает URL для ЭУ «Изменить»
	 *
	 * @param UI_List_Item_Interface $item
	 *
	 * @return string
	 *
	 * @since 1.00
	 */
	public function getEdit(UI_List_Item_Interface $item)
	{
		return $GLOBALS['page']->url(array('id' => $item->getId(), 'action' => 'edit'));
	}
	//-----------------------------------------------------------------------------
}
