<?php
/**
 * UI
 *
 * ���������� ��� ���������� UI
 *
 * @version ${product.version}
 *
 * @copyright 2011, ������ ������������ <mihalych@vsepofigu.ru>
 * @license http://www.gnu.org/licenses/gpl.txt	GPL License 3
 * @author ������ ������������ <mihalych@vsepofigu.ru>
 *
 * ������ ��������� �������� ��������� ����������� ������������. ��
 * ������ �������������� �� �/��� �������������� � ������������ �
 * ��������� ������ 3 ���� (�� ������ ������) � ��������� ����� �������
 * ������ ����������� ������������ �������� GNU, �������������� Free
 * Software Foundation.
 *
 * �� �������������� ��� ��������� � ������� �� ��, ��� ��� ����� ���
 * ��������, ������ �� ������������� �� ��� ������� ��������, � ���
 * ����� �������� ��������� ��������� ��� ������� � ����������� ���
 * ������������� � ���������� �����. ��� ��������� ����� ���������
 * ���������� ������������ �� ����������� ������������ ��������� GNU.
 *
 * �� ������ ���� �������� ����� ����������� ������������ ��������
 * GNU � ���� ����������. ���� �� �� �� ��������, �������� �������� ��
 * <http://www.gnu.org/licenses/>
 *
 * @package UI
 *
 * $Id$
 */

/**
 * �������� ����� �������
 *
 * @package UI
 */
class UI extends Plugin
{
	/**
	 * ������ �������
	 * @var string
	 */
	public $version = '${product.version}';

	/**
	 * ��������� ������ ����
	 * @var string
	 */
	public $kernel = '2.15';

	/**
	 * �������� �������
	 * @var string
	 */
	public $title = 'UI';

	/**
	 * ������� �������
	 * @var string
	 */
	public $description = '���������� ����������������� ����������';
}