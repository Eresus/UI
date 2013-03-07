<?php
/**
 * Интерфейс построителя шаблонов адресов
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
 * Интерфейс построителя шаблонов адресов
 *
 * Построитель адресов используется {@link UI_List списком} чтобы создавать шаблоны адресов для
 * различных элементов управления, таких как переключатель страниц, «Изменить», «Удалить» и т. д.
 *
 * Вы можете создать собственный построитель или воспользоваться входящим в модуль UI:
 *
 * - {@link UI_List_URL_Query}
 *
 * @package UI
 */
interface UI_List_URL_Interface
{
    /**
     * Должен возвращать шаблон URL для переключателя страниц
     *
     * @return string
     *
     * @since 1.00
     */
    public function getPagination();

    /**
     * Должен возвращать шаблон URL для ЭУ «Удалить»
     *
     * @param UI_List_Item_Interface $item
     *
     * @return string
     *
     * @since 1.00
     */
    public function getDelete(UI_List_Item_Interface $item);

    /**
     * Должен возвращать шаблон URL для ЭУ «Изменить»
     *
     * @param UI_List_Item_Interface $item
     *
     * @return string
     *
     * @since 1.00
     */
    public function getEdit(UI_List_Item_Interface $item);

    /**
     * Должен возвращать шаблон URL для ЭУ «Поднять выше»
     *
     * @param UI_List_Item_Interface $item
     *
     * @return string
     *
     * @since 1.00
     */
    public function getOrderingUp(UI_List_Item_Interface $item);

    /**
     * Должен возвращать шаблон URL для ЭУ «Опустить ниже»
     *
     * @param UI_List_Item_Interface $item
     *
     * @return string
     *
     * @since 1.00
     */
    public function getOrderingDown(UI_List_Item_Interface $item);

    /**
     * Должен возвращать шаблон URL для ЭУ «Включить/Отключить»
     *
     * @param UI_List_Item_Interface $item
     *
     * @return string
     *
     * @since 1.00
     */
    public function getToggle(UI_List_Item_Interface $item);
}

