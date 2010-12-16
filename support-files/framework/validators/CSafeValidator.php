<?php
/**
 * CSafeValidator class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CSafeValidator marks the associated attributes to be safe for massive assignments.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CSafeValidator.php 2497 2010-09-23 13:28:52Z mdomba $
 * @package system.validators
 * @since 1.1
 */
class CSafeValidator extends CValidator
{
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
	}
}

