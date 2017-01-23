<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Database
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * SQL server database iterator.
 *
 * @since  12.1
 */
class JDatabaseIteratorSqlsrv extends JDatabaseIterator
{
	/**
	 * Get the number of rows in the result set for the executed SQL given by the cursor.
	 *
	 * @return  integer  The number of rows in the result set.
	 *
	 * @since   12.1
	 * @see     Countable::count()
	 */
	public function count()
	{
		return sqlsrv_num_rows($this->cursor);
	}

	/**
	 * Method to fetch a row from the result set cursor as an object.
	 *
	 * @return  mixed   Either the next row from the result set or false if there are no more rows.
	 *
	 * @since   12.1
	 */
	protected function fetchObject()
	{
		$row = sqlsrv_fetch_object($this->cursor, $this->class);

		if (is_object($row))
		{
			// For SQLServer - we need to strip slashes
			foreach (get_object_vars($row) as $key => $value)
			{
				// Check public variable from object including those from $class, ex. JMenuItem
				if (is_string($value))
				{
					$row->$key = stripslashes($value);
				}
			}
		}

		return $row;
	}

	/**
	 * Method to free up the memory used for the result set.
	 *
	 * @return  void
	 *
	 * @since   12.1
	 */
	protected function freeResult()
	{
		sqlsrv_free_stmt($this->cursor);
	}
}