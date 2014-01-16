<?php
/**
 * UI
 *
 * Модульные тесты
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
 * @subpackage Tests
 *
 * $Id: AllTests.php 1263 2011-10-03 17:11:17Z mk $
 */


require_once __DIR__ . '/../bootstrap.php';
require_once TESTS_SRC_DIR . '/ui/classes/List/DataProvider/Interface.php';
require_once TESTS_SRC_DIR . '/ui/classes/List/URL/Interface.php';
require_once TESTS_SRC_DIR . '/ui/classes/List.php';

/**
 * @package UI
 * @subpackage Tests
 */
class UI_List_Test extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers UI_List::__construct
	 */
	public function test_construct()
	{
		$list = $this->getMockBuilder('UI_List')->disableOriginalConstructor()->
			setMethods(array('setDataProvider', 'setURL'))->getMock();
		$list->expects($this->once())->method('setDataProvider');
		$list->expects($this->once())->method('setURL');
		$list->__construct(new Eresus_Plugin(), new UI_List_Test_DataProvider(), new UI_List_Test_URL());
	}
	//-----------------------------------------------------------------------------

	/**
	 * @covers UI_List::setDataProvider
	 * @covers UI_List::getDataProvider
	 */
	public function test_set_get_DataProvider()
	{
		$list = new UI_List(new Eresus_Plugin());
		$provider = new UI_List_Test_DataProvider();
		$list->setDataProvider($provider);
		$this->assertSame($provider, $list->getDataProvider());
	}
	//-----------------------------------------------------------------------------

	/**
	 * @covers UI_List::getItems
	 */
	public function test_getItems()
	{
		$provider = $this->getMock('UI_List_Test_DataProvider', array('getItems'));
		$provider->expects($this->once())->method('getItems')->with(10, 10);
		$list = new UI_List(new Eresus_Plugin(), $provider);
		$list->setPageSize(10);
		$list->setPage(2);
		$list->getItems();
	}
	//-----------------------------------------------------------------------------

	/**
	 * @covers UI_List::getPagination
	 */
	public function test_getPagination()
	{
		$provider = $this->getMock('UI_List_Test_DataProvider', array('getCount'));
		$provider->expects($this->once())->method('getCount')->will($this->returnValue(100));

		$url = new UI_List_Test_URL;

		$list = new UI_List(new Eresus_Plugin(), $provider, $url);
		$list->setPageSize(10);
		$list->setPage(5);
		$list->getPagination();
	}
	//-----------------------------------------------------------------------------
}

class UI_List_Test_DataProvider implements UI_List_DataProvider_Interface
{
	/**
	 * @see UI_List_DataProvider_Interface::getItems()
	 */
	public function getItems($limit = null, $offset = 0) {}
	//-----------------------------------------------------------------------------

	/**
	 * @see UI_List_DataProvider_Interface::getCount()
	 */
	public function getCount() {}
	//-----------------------------------------------------------------------------
}

class UI_List_Test_URL implements UI_List_URL_Interface
{
	/**
	 * @see UI_List_URL_Interface::getPagination()
	 */
	public function getPagination() {}
	//-----------------------------------------------------------------------------

	/**
	 * @see UI_List_URL_Interface::getDelete()
	 */
	public function getDelete(UI_List_Item_Interface $item) {}
	//-----------------------------------------------------------------------------

	/**
	 * @see UI_List_URL_Interface::getEdit()
	 */
	public function getEdit(UI_List_Item_Interface $item) {}
	//-----------------------------------------------------------------------------

	/**
	 * @see UI_List_URL_Interface::getOrderingUp()
	 */
	public function getOrderingUp(UI_List_Item_Interface $item) {}
	//-----------------------------------------------------------------------------

	/**
	 * @see UI_List_URL_Interface::getOrderingDown()
	 */
	public function getOrderingDown(UI_List_Item_Interface $item) {}
	//-----------------------------------------------------------------------------

	/**
	 * @see UI_List_URL_Interface::getToggle()
	 */
	public function getToggle(UI_List_Item_Interface $item) {}
	//-----------------------------------------------------------------------------
}
