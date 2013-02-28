<?php
/**
 * Элемент списка. Обёртка к произвольному объекту
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
 * Элемент списка. Обёртка к произвольному объекту
 *
 * @since 2.01
 * @package UI
 */
class UI_List_Item_Object implements  UI_List_Item_Interface
{
	/**
	 * Объект
	 * @var object
	 */
	protected $object;

	/**
	 * Имена свойств, могущих выступать в роли идентификатора
	 * @var string[]
	 * @since 2.01
	 */
	protected $idNames = array('id', 'key');

	/**
	 * Имена свойств, могущих выступать в роли флага активности
	 * @var string[]
	 * @since 2.01
	 */
	protected $enabledNames = array('enabled', 'active');

	/**
	 * Конструктор
	 *
	 * @param $object  оборачиваемый объект
	 *
	 * @throws InvalidArgumentException
	 *
	 * @since 2.01
	 */
	public function __construct($object)
	{
		if (!is_object($object))
		{
			throw new InvalidArgumentException(
				get_class($this) . '::__construct() expects argument 1 to be an object!');
		}
		$this->object = $object;
	}

	/**
	 * Задаёт имена свойств, могущих выступать в роли идентификатора
	 *
	 * @param string[] $names
	 *
	 * @return void
	 */
	public function setIdNames(array $names)
	{
		$this->idNames = $names;
	}

	/**
	 * Задаёт имена свойств, могущих выступать в роли флага активности
	 *
	 * @param string[] $names
	 *
	 * @return void
	 */
	public function setEnabledNames(array $names)
	{
		$this->enabledNames = $names;
	}

	/**
	 * Возвращает идентификатор элемента
	 *
	 * @return string|null
	 *
	 * @since 2.01
	 */
	public function getId()
	{
		foreach ($this->idNames as $name)
		{
			if (isset($this->object->{$name}))
			{
				return $this->object->{$name};
			}
		}
		return null;
	}

	/**
	 * Возвращать true если элемент включён, false — если выключен и null — если состояние неизвестно
	 *
	 * Используется для определения состояния ЭУ «Активность»
	 *
	 * @return bool|null
	 *
	 * @since 2.01
	 */
	public function isEnabled()
	{
		foreach ($this->enabledNames as $name)
		{
			if (isset($this->object->{$name}))
			{
				return $this->object->{$name};
			}
		}
		return null;
	}

	/**
	 * Прокси к свойствам объекта
	 *
	 * @param string $property имя свойства
	 *
	 * @return mixed
	 *
	 * @since 2.01
	 */
	public function __get($property)
	{
		return $this->object->{$property};
	}
}
