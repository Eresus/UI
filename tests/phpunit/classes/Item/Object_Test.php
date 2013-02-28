<?php
/**
 * Модульные тесты
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
 * @subpackage Tests
 */


require_once __DIR__ . '/../../bootstrap.php';
require_once TESTS_SRC_DIR . '/ui/classes/List/Item/Interface.php';
require_once TESTS_SRC_DIR . '/ui/classes/List/Item/Object.php';

/**
 * @package UI
 * @subpackage Tests
 */
class UI_List_Item_Object_Test extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers UI_List_Item_Object::__construct
	 * @covers UI_List_Item_Object::getId
	 * @covers UI_List_Item_Object::isEnabled
	 * @covers UI_List_Item_Object::__get
	 */
	public function testFullObjectDefaults()
	{
		$object = new stdClass();
		$item = new UI_List_Item_Object($object);

		$object->id = 123;
		$object->enabled = true;
		$object->foo = 'bar';
		$this->assertEquals(123, $item->getId());
		$this->assertTrue($item->isEnabled());
		$this->assertEquals('bar', $item->foo);

		$object->enabled = false;
		$this->assertFalse($item->isEnabled());

		$object = new stdClass();
		$item = new UI_List_Item_Object($object);

		$object->key = 123;
		$object->active = true;
		$object->foo = 'bar';
		$this->assertEquals(123, $item->getId());
		$this->assertTrue($item->isEnabled());
		$this->assertEquals('bar', $item->foo);
	}

	/**
	 * @covers UI_List_Item_Object::__construct
	 * @covers UI_List_Item_Object::getId
	 * @covers UI_List_Item_Object::isEnabled
	 * @covers UI_List_Item_Object::__get
	 */
	public function testEmptyObjectDefaults()
	{
		$object = new stdClass();
		$item = new UI_List_Item_Object($object);

		$object->foo = 'bar';
		$this->assertNull($item->getId());
		$this->assertNull($item->isEnabled());
		$this->assertEquals('bar', $item->foo);
	}

	/**
	 * @covers UI_List_Item_Object::__construct
	 * @covers UI_List_Item_Object::getId
	 * @covers UI_List_Item_Object::isEnabled
	 * @covers UI_List_Item_Object::setIdNames
	 * @covers UI_List_Item_Object::setEnabledNames
	 */
	public function testFullObjectCustom()
	{
		$object = new stdClass();
		$item = new UI_List_Item_Object($object);

		$object->foo = 123;
		$object->bar = true;

		$item->setIdNames(array('foo'));
		$item->setEnabledNames(array('bar'));

		$this->assertEquals(123, $item->getId());
		$this->assertTrue($item->isEnabled());
	}

	/**
	 * @covers UI_List_Item_Object::getId
	 * @covers UI_List_Item_Object::isEnabled
	 */
	public function testVirtualObject()
	{
		$item = new UI_List_Item_Object(new UI_List_Item_Object_Test_Virtual());

		$this->assertEquals(123, $item->getId());
		$this->assertTrue($item->isEnabled());
	}
}

class UI_List_Item_Object_Test_Virtual
{
	public function __get($key)
	{
		switch ($key)
		{
			case 'id':
				return 123;
			case 'enabled':
				return true;
		}
		return null;
	}

	public function __isset($key)
	{
		return in_array($key, array('id', 'enabled'));
	}
}