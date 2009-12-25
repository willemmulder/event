<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The main event class.
 *
 * @package		Event
 * @author		Oliver Morgan
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
class Event {
	
	/**
	 * An array of instaces created using the factory method.
	 * 
	 * @var	array
	 */
	protected static $_instances;
	
	/**
	 * The event's identifier.
	 * 
	 * @var	string
	 */
	public $name;
	
	/**
	 * The event's userdata.
	 * 
	 * @var array
	 */
	public $data;
	
	/**
	 * A list of callbacks to be called by the event on invoke.
	 * 
	 * @var	array
	 */
	protected $_callbacks;

	/**
	 * Retrieves an event from instances, creating one if needed.
	 *
	 * @param	string	The name of the instance.
	 * @return	Event
	 */
	public static function instance($name)
	{
		( ! isset(self::$_instances[$name]))
		AND self::$_instances[$name] = new self($name);

		return self::$_instances[$name];
	}
	
	/**
	 * Initializes a new instance of the event object.
	 * 
	 * @param	string	The name of the event.
	 * @return	void
	 */
	protected function __construct($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Binds an variable by reference.
	 *
	 * @param	string	The key.
	 * @param	mixed	The data.
	 * @return	Event
	 */
	public function bind($key, & $data)
	{
		$this->data =& $data;
		
		return $this;
	}
	
	/**
	 * Sets the data variable to a given value.
	 *
	 * @param	string	The key.
	 * @param	mixed	The value.
	 * @return	Event
	 */
	public function set($key, $data)
	{
		$this->data[$key] = $data;
		
		return $this;
	}
	
	/**
	 * Adds a callback to be invoked by the event.
	 * 
	 * @param	mixed	The callback to be invoked.
	 * @return	Event
	 */
	public function callback($callback)
	{
		$this->_callbacks[] = $callback;
	}
	
	/**
	 * Invokes the event calling all callbacks with the given data.
	 * 
	 * @return	void
	 */
	public function invoke()
	{
		foreach ($this->_callbacks as $callback)
		{
			call_user_func($callback, $this);
		}
	}
	
} // End Event