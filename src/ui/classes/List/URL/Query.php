<?php
/**
 * UI
 *
 * Построитель адресов с аргументами в запросе
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
 * Построитель адресов с аргументами в запросе (query)
 *
 * Например, шаблон переключателя страниц может выглядеть так:
 *
 * <code>
 * …/admin.php?mod=ext-myplugin&page=%d
 * </code>
 *
 * Корневой URL может быть задан в {@link __construct конструкторе}.
 *
 * @package UI
 */
class UI_List_URL_Query implements UI_List_URL_Interface
{
	/**
	 * Базовый URL
	 *
	 * Всегда заканчивается символом & или ?
	 *
	 * @var string
	 * @see __construct()
	 */
	private $baseURL;

	/**
	 * Имя аргумента для передачи идентификатора
	 *
	 * @var string
	 * @see setIdName()
	 */
	private $idName = 'id';

	/**
	 * Конструктор
	 *
	 * @param string $baseURL  базовый URL, все аргументы будет присоединяться к нему. Если не указан,
	 *                         будет использован результат вызова {@link WebPage::url()}.
	 *
	 * @return UI_List_URL_Query
	 *
	 * @since 1.00
	 * @uses WebPage::url()
	 */
	public function __construct($baseURL = null)
	{
		if ($baseURL)
		{
			$this->baseURL = $baseURL;
		}
		else
		{
			$this->baseURL = $GLOBALS['page']->url();
		}
		$lastChar = mb_substr($this->baseURL, -1);
		if ('&' != $lastChar && '?' != $lastChar)
		{
			$hasQuery = mb_strpos($this->baseURL, '?') !== false;
			$this->baseURL .= $hasQuery ? '&' : '?';
		}
	}
	//-----------------------------------------------------------------------------

	/**
	 * Задаёт имя аргумента для передачи идентификатора элемента списка
	 *
	 * По умолчанию имя аргумента «id».
	 *
	 * @param string $name
	 *
	 * @return void
	 *
	 * @since 1,.00
	 */
	public function setIdName($name)
	{
		$this->idName = $name;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает шаблон URL для переключателя страниц
	 *
	 * @return string
	 *
	 * @since 1.00
	 */
	public function getPagination()
	{
		return $this->baseURL . 'page=%d';
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
		return $this->baseURL . $this->idName . '=' . $item->getId() . '&action=delete';
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
		return $this->baseURL . $this->idName . '=' . $item->getId() . '&action=edit';
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает шаблон URL для ЭУ «Поднять выше»
	 *
	 * @param UI_List_Item_Interface $item
	 *
	 * @return string
	 *
	 * @since 1.00
	 */
	public function getOrderingUp(UI_List_Item_Interface $item)
	{
		return $this->baseURL . $this->idName . '=' . $item->getId() . '&action=up';
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает шаблон URL для ЭУ «Опустить ниже»
	 *
	 * @param UI_List_Item_Interface $item
	 *
	 * @return string
	 *
	 * @since 1.00
	 */
	public function getOrderingDown(UI_List_Item_Interface $item)
	{
		return $this->baseURL . $this->idName . '=' . $item->getId() . '&action=down';
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает URL для ЭУ «Включить/Отключить»
	 *
	 * @param UI_List_Item_Interface $item
	 *
	 * @return string
	 *
	 * @since 1.00
	 */
	public function getToggle(UI_List_Item_Interface $item)
	{
		return $this->baseURL . $this->idName . '=' . $item->getId() . '&action=toggle';
	}
	//-----------------------------------------------------------------------------
}
