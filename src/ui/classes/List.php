<?php
/**
 * UI
 *
 * Список элементов
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
 * Список элементов
 *
 * Позволяет создавать многостраничные списки произвольных элементов, получаемых из различных
 * источников и оформлять их на основе произвольных шаблонов.
 *
 * Для получения данных используется специальный объект-посредник, реализующий интерфейс
 * {@link UI_List_DataProvider_Interface}.
 *
 * Можно задать размер страницы и номер текущей страницы списка при помощи {@link setPageSize()} и
 * {@link setPage()} соответственно.
 *
 * Для отрисовки списка надо передать в шаблон либо сам объект UI_List, либо значения, возвращаемые
 * методами {@link getItems()} и {@link getPagination()}.
 *
 * Если передавать объект в переменной <b>$list</b>, то шаблон может выглядеть так:
 *
 * <code>
 * {foreach $list->getItems() item}
 * <div>{$item.foo} {$item.bar}</div>
 * {/foreach}
 * {$list->getPagination()->render()}
 * </code>
 *
 * Корневой адрес для переключателя страниц задаётся методом {@link setURL()}.
 *
 * @package UI
 */
class UI_List
{
	/**
	 * Модуль
	 *
	 * @var Plugin
	 */
	private $plugin;

	/**
	 * Поставщик данных
	 *
	 * @var UI_List_DataProvider_Interface
	 */
	private $dataProvider;

	/**
	 * Размер страницы
	 *
	 * @var int
	 */
	private $pageSize;

	/**
	 * Элементы списка
	 *
	 * @var array
	 */
	private $items;

	/**
	 * Корневой URL
	 *
	 * @var UI_List_URL_Interface
	 */
	private $url;

	/**
	 * Страница списка
	 *
	 * @var int
	 */
	private $page = 1;

	/**
	 * Переключатель страниц
	 *
	 * @var PaginationHelper
	 */
	private $pagination = null;

	/**
	 * Конструктор
	 *
	 * @param Plugin                         $plugin    плагин-владелец
	 * @param UI_List_DataProvider_Interface $provider  поставщик данных
	 * @param UI_List_URL_Interface          $url       базовый URL
	 *
	 * @return UI_List
	 *
	 * @since 1.00
	 */
	public function __construct(Plugin $plugin, UI_List_DataProvider_Interface $provider = null,
		UI_List_URL_Interface $url = null)
	{
		$this->plugin = $plugin;
		if ($provider)
		{
			$this->setDataProvider($provider);
		}
		if ($url)
		{
			$this->setURL($url);
		}
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает поставщика данных
	 *
	 * @return UI_List_DataProvider_Interface
	 *
	 * @since 1.00
	 */
	public function getDataProvider()
	{
		return $this->dataProvider;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Устанавливает поставщика данных
	 *
	 * @param UI_List_DataProvider_Interface $provider
	 *
	 * @return void
	 *
	 * @since 1.00
	 */
	public function setDataProvider(UI_List_DataProvider_Interface $provider)
	{
		$this->dataProvider = $provider;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Устанавливает корневой URL
	 *
	 * @param UI_List_URL_Interface $url
	 *
	 * @return void
	 *
	 * @since 1.00
	 */
	public function setURL(UI_List_URL_Interface $url)
	{
		$this->url = $url;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Устанавливает страницу списка
	 *
	 * @param int $page
	 *
	 * @return void
	 *
	 * @since 1.00
	 */
	public function setPage($page)
	{
		$this->page = $page;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Устанавливет размер страницы (в строках)
	 *
	 * @param int $size
	 *
	 * @return void
	 *
	 * @since 1.00
	 */
	public function setPageSize($size)
	{
		$this->pageSize = $size;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает массив элементов списка
	 *
	 * @return array
	 *
	 * @since 1.00
	 */
	public function getItems()
	{
		if (is_null($this->items))
		{
			$this->items = $this->dataProvider->getItems($this->pageSize,
				($this->page - 1) * $this->pageSize);
		}
		return $this->items;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Возвращает переключатель страниц
	 *
	 * @return PaginationHelper
	 *
	 * @since 1.00
	 */
	public function getPagination()
	{
		if (!$this->pagination)
		{
			if (!$this->url)
			{
				$this->url = new UI_List_URL_Query();
			}
			$this->url->setPage($this->page);
			$totalPages = ceil($this->dataProvider->getCount() / $this->pageSize);
			$this->pagination = new PaginationHelper($totalPages, $this->page, (string) $this->url);
		}
		return $this->pagination;
	}
	//-----------------------------------------------------------------------------
}
