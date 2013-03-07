<?php
/**
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
 * Для отрисовки списка надо передать в шаблон объект {@link UI_List}, а затем использовать
 * методы {@link getItems()}, {@link getPagination()} и {@link getControls()} для вставки в шаблон
 * соответствующих частей списка.
 *
 * Чтобы использовать в шаблоне переключатель страниц и другие элементы управления списком, надо
 * задать генератор адресов методом {@link setURL()}.
 *
 * Пример шаблона:
 *
 * <code>
 * {if count($list->getItems())}
 * <ul>
 *   {foreach $list->getItems() item}
 *   <li>
 *     {$list->getControls($item, 'edit', 'toggle', 'delete')}
 *     {$item->foo}
 *     {$item->bar}
 *   </li>
 *   {/foreach}
 * </ul>
 * {$list->getPagination()->render()}
 * {/if}
 * </code>
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
     * @param UI_List_URL_Interface          $url       построитель адресов
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

    /**
     * Возвращает построитель адресов
     *
     * @return UI_List_URL_Interface
     *
     * @since 1.00
     */
    public function getURL()
    {
        if (!$this->url)
        {
            $this->url = new UI_List_URL_Query();
        }
        return $this->url;
    }

    /**
     * Устанавливает построитель адресов
     *
     * См. {@link UI_List_URL_Interface}
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

    /**
     * Устанавливает номер текущей страницы списка
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

    /**
     * Устанавливает размер страницы (в строках)
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

    /**
     * Возвращает массив элементов списка для подстановки в шаблон
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
            $totalPages = $this->pageSize ? ceil($this->dataProvider->getCount() / $this->pageSize) : 0;
            $this->pagination = new PaginationHelper($totalPages, $this->page,
                $this->getURL()->getPagination());
        }
        return $this->pagination;
    }

    /**
     * Возвращает разметку элементов управления для использования в шаблоне
     *
     * Возможные имена ЭУ:
     *
     * - delete — Удаление
     * - edit — Изменение
     * - ordering — Переместить выше/ниже в списке
     * - toggle — Включить/Отключить
     *
     * @param UI_List_Item_Interface $item          элемент списка, для которого нужны элементы управления
     * @param string                 $control1,...  элементы управления, которые нужны
     *
     * @return string
     *
     * @since 1.00
     */
    public function getControls(UI_List_Item_Interface $item, $control1 = null)
    {
        $controls = func_get_args();
        array_shift($controls);

        $html = '';

        if (in_array('edit', $controls))
        {
            $html .= $this->getControl_edit($item);
        }

        if (in_array('toggle', $controls))
        {
            $html .= $this->getControl_toggle($item);
        }

        if (in_array('ordering', $controls))
        {
            $html .= $this->getControl_ordering($item);
        }

        if (in_array('delete', $controls))
        {
            $html .= $this->getControl_delete($item);
        }

        return $html;
    }

    /**
     * Возвращает разметку ЭУ «Удалить»
     *
     * @param UI_List_Item_Interface $item  элемент списка, для которого нужно создать ЭУ
     *
     * @return string
     *
     * @since 1.00
     */
    private function getControl_delete(UI_List_Item_Interface $item)
    {
        /** @var TAdminUI $page */
        $page = Eresus_Kernel::app()->getPage();
        return '<a href="' . $this->getURL()->getDelete($item) . '" title="' . ADM_DELETE
            . '" onclick="return askdel(this);"><img src="' . Eresus_CMS::getLegacyKernel()->root
            . $page->getUITheme()->getIcon('item-delete.png') . '" alt="' . ADM_DELETE . '"></a> ';
    }

    /**
     * Возвращает разметку ЭУ «Изменить»
     *
     * @param UI_List_Item_Interface $item  элемент списка, для которого нужно создать ЭУ
     *
     * @return string
     *
     * @since 1.00
     */
    private function getControl_edit(UI_List_Item_Interface $item)
    {
        /** @var TAdminUI $page */
        $page = Eresus_Kernel::app()->getPage();
        return '<a href="' . $this->getURL()->getEdit($item) . '" title="' . ADM_EDIT . '"><img src="'
            . Eresus_CMS::getLegacyKernel()->root . $page->getUITheme()->getIcon('item-edit.png')
            . '" alt="' . ADM_EDIT . '"></a> ';
    }

    /**
     * Возвращает разметку ЭУ «Порядок следования»
     *
     * @param UI_List_Item_Interface $item  элемент списка, для которого нужно создать ЭУ
     *
     * @return string
     *
     * @since 1.00
     */
    private function getControl_ordering(UI_List_Item_Interface $item)
    {
        $rootUrl = Eresus_CMS::getLegacyKernel()->root;
        /** @var TAdminUI $page */
        $page = Eresus_Kernel::app()->getPage();

        return '<a href="' . $this->getURL()->getOrderingUp($item) . '" title="' . ADM_UP
            . '"><img src="' . $rootUrl . $page->getUITheme()->getIcon('move-up.png') . '" alt="' . ADM_UP
            . '"></a> <a href="' . $this->getURL()->getOrderingDown($item) . '" title="' . ADM_DOWN
            . '"><img src="' . $rootUrl . $page->getUITheme()->getIcon('move-down.png') . '" alt="'
            . ADM_DOWN . '"></a> ';
    }

    /**
     * Возвращает разметку ЭУ «Активность»
     *
     * @param UI_List_Item_Interface $item  элемент списка, для которого нужно создать ЭУ
     *
     * @return string
     *
     * @since 1.00
     */
    private function getControl_toggle(UI_List_Item_Interface $item)
    {
        /** @var TAdminUI $page */
        $page = Eresus_Kernel::app()->getPage();
        return '<a href="' . $this->getURL()->getToggle($item) . '" title="'
            . ($item->isEnabled() ? ADM_DEACTIVATE : ADM_ACTIVATE ) . '"><img src="'
            . Eresus_CMS::getLegacyKernel()->root . $page->getUITheme()->getIcon('item-'
            . ($item->isEnabled() ? 'active' : 'inactive') . '.png') . '" alt="'
            . ($item->isEnabled() ? ADM_ACTIVATED : ADM_DEACTIVATED ) . '"></a> ';
    }
}

