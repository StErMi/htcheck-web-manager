<?php
/**
 * CInlineValidator class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CInlineValidator represents a validator which is defined as a method in the object being validated.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CInlineValidator.php 2497 2010-09-23 13:28:52Z mdomba $
 * @package system.validators
 * @since 1.0
 */
class CInlineValidator extends CValidator
{
	/**
	 * @var string the name of the validation method defined in the active record class
	 */
	public $method;
	/**
	 * @var array additional parameters that are passed to the validation method
	 */
	public $params;

	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		$method=$this->method;
		$object->$method($attribute,$this->params);
	}
}
