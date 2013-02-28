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
require_once TESTS_SRC_DIR . '/ui/classes/List/DataProvider/Interface.php';
require_once TESTS_SRC_DIR . '/ui/classes/List/DataProvider/Array.php';

/**
 * @package UI
 * @subpackage Tests
 */
class UI_List_DataProvider_Array_Test extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers UI_List_DataProvider_Array::__construct
	 * @covers UI_List_DataProvider_Array::getItems
	 * @covers UI_List_DataProvider_Array::getCount
	 */
	public function testOverall()
	{
		$o1 = new stdClass();
		$o1->id = 1;
		$o1->enabled = true;
		$o1->foo = 'bar1';

		$o2 = new stdClass();
		$o2->id = 2;
		$o2->enabled = true;
		$o2->foo = 'bar2';

		$o3 = new stdClass();
		$o3->id = 3;
		$o3->enabled = false;
		$o3->foo = 'bar3';

		$provider = new UI_List_DataProvider_Array(array($o1, $o2, $o3));

		$this->assertEquals(3, $provider->getCount());
		$items = $provider->getItems(1, 1);
		$this->assertCount(1, $items);
		$this->assertEquals(2, $items[0]->getId());
		$this->assertTrue($items[0]->isEnabled());
		$this->assertEquals('bar2', $items[0]->foo);
	}
}