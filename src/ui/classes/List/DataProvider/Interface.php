<?php
/**
 * UI
 *
 * Интерфейс поставщика данных для списка
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
 * Интерфейс поставщика данных для {@link UI_List списка}
 *
 * @package UI
 */
interface UI_List_DataProvider_Interface
{
	/**
	 * Должен возвращать элементы списка
	 *
	 * Должен возвращать массив элементов списка, количеством не более $limit, пропустив первые
	 * $offset элементов. Элементы массива должны быть объектами, предоставляющими интерфейс
	 * {@link UI_List_Item_Interface}.
	 *
	 * @param int $limit   максимум элементов, который следует вернуть
	 * @param int $offset  сколько элементов пропустить
	 *
	 * @return array  массив элементов списка
	 *
	 * @since 1.00
	 */
	public function getItems($limit = null, $offset = 0);
	//-----------------------------------------------------------------------------

	/**
	 * Должен возвращать общее количество элементов в списке
	 *
	 * @return int  общее количество элементов в списке
	 *
	 * @since 1.00
	 */
	public function getCount();
	//-----------------------------------------------------------------------------
}