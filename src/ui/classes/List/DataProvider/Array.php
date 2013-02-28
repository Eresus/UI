<?php
/**
 * Поставщик данных для списка из массива
 *
 * @version ${product.version}
 *
 * @copyright 2013, Михаил Красильников <mihalych@vsepofigu.ru>
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
 * Поставщик данных для {@link UI_List списка} из массива
 *
 * @since 2.01
 * @package UI
 */
class UI_List_DataProvider_Array implements  UI_List_DataProvider_Interface
{
	/**
	 * Данные
	 *
	 * @var array
	 * @since 2.01
	 */
	private $data = array();

	/**
	 * Конструктор поставщика данных
	 *
	 * @param array $array  массив объектов
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct(array $array)
	{
		foreach ($array as $item)
		{
			if (!($item instanceof UI_List_Item_Interface))
			{
				switch (true)
				{
					case is_object($item):
						$item = new UI_List_Item_Object($item);
						break;
					default:
						throw new InvalidArgumentException(
							get_class($this) . ' accepts only objects as array elements.'
						);
				}
			}
			$this->data []= $item;
		}
	}

	/**
	 * Возвращает элементы списка
	 *
	 * Возвращает массив элементов списка, количеством не более $limit, пропустив первые
	 * $offset элементов.
	 *
	 * @param int $limit   максимум элементов, который следует вернуть
	 * @param int $offset  сколько элементов пропустить
	 *
	 * @return UI_List_Item_Interface[]  массив элементов списка
	 *
	 * @since 2.01
	 */
	public function getItems($limit = null, $offset = 0)
	{
		return array_slice($this->data, $offset, $limit);
	}

	/**
	 * Возвращает общее количество элементов в списке
	 *
	 * @return int  общее количество элементов в списке
	 *
	 * @since 2.01
	 */
	public function getCount()
	{
		return count($this->data);
	}
}
