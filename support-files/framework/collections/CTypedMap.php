<?php
/**
 * This file contains CTypedMap class.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CTypedMap represents a map whose items are of the certain type.
 *
 * CTypedMap extends {@link CMap} by making sure that the elements to be
 * added to the list is of certain class type.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CTypedMap.php 2614 2010-11-03 15:44:48Z qiang.xue $
 * @package system.collections
 * @since 1.0
 */
class CTypedMap extends CMap
{
	private $_type;

	/**
	 * Constructor.
	 * @param string class type
	 */
	public function __construct($type)
	{
		$this->_type=$type;
	}

	/**
	 * Adds an item into the map.
	 * This method overrides the parent implementation by
	 * checking the item to be inserted is of certain type.
	 * @param mixed key
	 * @param mixed value
	 * @throws CException If the index specified exceeds the bound,
	 * the map is read-only or the element is not of the expected type.
	 */
	public function add($index,$item)
	{
		if($item instanceof $this->_type)
			parent::add($index,$item);
		else
			throw new CException(Yii::t('yii','CTypedMap<{type}> can only hold objects of {type} class.',
				array('{type}'=>$this->_type)));
	}
}
