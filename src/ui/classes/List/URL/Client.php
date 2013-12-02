<?php
/**
 * Построитель адресов в формате КИ
 *
 * @version ${product.version}
 *
 * @copyright 2013, Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license http://www.gnu.org/licenses/gpl.txt	GPL License 3
 * @author Михаил Красильников <m.krasilnikov@yandex.ru>
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
 * Построитель адресов в формате КИ
 *
 * Например, шаблон переключателя страниц может выглядеть так:
 *
 * <code>
 * …/foo/bar/p%d/
 * </code>
 *
 * Корневой URL может быть задан в {@link __construct конструкторе}.
 *
 * @package UI
 * @since 2.02
 */
class UI_List_URL_Client implements UI_List_URL_Interface
{
    /**
     * Базовый URL
     *
     * Всегда заканчивается символом «/»
     *
     * @var string
     * @see __construct()
     * @since 2.02
     */
    private $baseURL;

    /**
     * Конструктор
     *
     * @param string $baseURL  базовый URL, все аргументы будет присоединяться к нему. Если не указан,
     *                         будет использован результат вызова {@link WebPage::clientUrl()}.
     *
     * @since 2.02
     * @uses WebPage::clientUrl()
     */
    public function __construct($baseURL = null)
    {
        if ($baseURL)
        {
            $this->baseURL = $baseURL;
        }
        else
        {
            $page = Eresus_Kernel::app()->getPage();
            $this->baseURL = $page->clientURL($page->id);
        }
        if (mb_substr($this->baseURL, -1) != '/')
        {
            $this->baseURL .= '/';
        }
    }

    /**
     * Возвращает шаблон URL для переключателя страниц
     *
     * @return string
     *
     * @since 2.02
     */
    public function getPagination()
    {
        return $this->baseURL . 'p%d/';
    }

    /**
     * Возвращает URL для ЭУ «Удалить»
     *
     * @param UI_List_Item_Interface $item
     *
     * @return string
     *
     * @since 2.02
     */
    public function getDelete(UI_List_Item_Interface $item)
    {
        return $this->getActionUrl($item, 'delete');
    }

    /**
     * Возвращает URL для ЭУ «Изменить»
     *
     * @param UI_List_Item_Interface $item
     *
     * @return string
     *
     * @since 2.02
     */
    public function getEdit(UI_List_Item_Interface $item)
    {
        return $this->getActionUrl($item, 'edit');
    }

    /**
     * Возвращает шаблон URL для ЭУ «Поднять выше»
     *
     * @param UI_List_Item_Interface $item
     *
     * @return string
     *
     * @since 2.02
     */
    public function getOrderingUp(UI_List_Item_Interface $item)
    {
        return $this->getActionUrl($item, 'up');
    }

    /**
     * Возвращает шаблон URL для ЭУ «Опустить ниже»
     *
     * @param UI_List_Item_Interface $item
     *
     * @return string
     *
     * @since 2.02
     */
    public function getOrderingDown(UI_List_Item_Interface $item)
    {
        return $this->getActionUrl($item, 'down');
    }

    /**
     * Возвращает URL для ЭУ «Включить/Отключить»
     *
     * @param UI_List_Item_Interface $item
     *
     * @return string
     *
     * @since 2.02
     */
    public function getToggle(UI_List_Item_Interface $item)
    {
        return $this->getActionUrl($item, 'toggle');
    }

    /**
     * @param UI_List_Item_Interface $item
     * @param string                 $action
     *
     * @return string
     * @since 2.02
     */
    protected function getActionUrl(UI_List_Item_Interface $item, $action)
    {
        return $this->baseURL . $item->getId() . '/' . $action . '/';
    }
}

