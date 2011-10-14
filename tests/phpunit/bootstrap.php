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
 * $Id: bootstrap.php 1877 2011-10-13 08:39:02Z mk $
 */

define('TESTS_SRC_DIR', realpath(__DIR__ . '/../../src'));

PHP_CodeCoverage_Filter::getInstance()->addFileToWhitelist(TESTS_SRC_DIR .
	'/ui/classes/List/DataProvider/Interface.php');
PHP_CodeCoverage_Filter::getInstance()->addFileToWhitelist(TESTS_SRC_DIR .
	'/ui/classes/List/URL/Interface.php');
PHP_CodeCoverage_Filter::getInstance()->addDirectoryToWhitelist(TESTS_SRC_DIR);

/**
 * Универсальная заглушка
 *
 * @package UI
 * @subpackage Tests
 */
class UniversalStub implements ArrayAccess
{
	public function __get($a)
	{
		return $this;
	}
	//-----------------------------------------------------------------------------

	public function __call($a, $b)
	{
		return $this;
	}
	//-----------------------------------------------------------------------------

	public function offsetExists($offset)
	{
		return true;
	}
	//-----------------------------------------------------------------------------

	public function offsetGet($offset)
	{
		return $this;
	}
	//-----------------------------------------------------------------------------

	public function offsetSet($offset, $value)
	{
		;
	}
	//-----------------------------------------------------------------------------

	public function offsetUnset($offset)
	{
		;
	}
	//-----------------------------------------------------------------------------

	public function __toString()
	{
		return '';
	}
	//-----------------------------------------------------------------------------
}



/**
 * Фасад к моку для эмуляции статичных методов
 *
 * @package UI
 * @subpackage Tests
 */
class MockFacade
{
	/**
	 * Мок
	 *
	 * @var object
	 */
	private static $mock;

	/**
	 * Устанавливает мок
	 *
	 * @param object $mock
	 *
	 * @return void
	 *
	 * @since 2.16
	 */
	public static function setMock($mock)
	{
		self::$mock = $mock;
	}
	//-----------------------------------------------------------------------------

	/**
	 * Вызывает метод мока
	 *
	 * @param string $method
	 * @param array  $args
	 *
	 * @return void
	 *
	 * @since 2.16
	 */
	public static function __callstatic($method, $args)
	{
		if (self::$mock && method_exists(self::$mock, $method))
		{
			return call_user_func_array(array(self::$mock, $method), $args);
		}

		return new UniversalStub();
	}
	//-----------------------------------------------------------------------------
}


/**
 * Заглушка для класса Plugin
 *
 * @package UI
 * @subpackage Tests
 */
class Plugin extends UniversalStub {}

/**
 * Заглушка для класса DB
 *
 * @package UI
 * @subpackage Tests
 */
class DB extends MockFacade {}

/**
 * Заглушка для класса ezcQuery
 *
 * @package UI
 * @subpackage Tests
 */
class ezcQuery extends UniversalStub {}

/**
 * Заглушка для класса ezcQuerySelect
 *
 * @package UI
 * @subpackage Tests
 */
class ezcQuerySelect extends ezcQuery {}

/**
 * Заглушка для класса PaginationHelper
 *
 * @package UI
 * @subpackage Tests
 */
class PaginationHelper extends UniversalStub {}

function arg($name)
{
	if (isset($GLOBALS['TESTS_arg'][$name]))
	{
		return $GLOBALS['TESTS_arg'][$name];
	}
	return null;
}