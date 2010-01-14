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
	protected $_callbacks = array();

	/**
	 * Will stop the execution of the event if set to false using stop().
	 *
	 * @var bool
	 */
	protected $_active;
	
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
		$this->data[$key] =& $data;
		
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
	 * Returns an array of all the callbacks associated with the event.
	 * 
	 * @return array
	 */
	public function callbacks()
	{
		return $this->_callbacks;
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

		return $this;
	}
	
	/**
	 * Resets the callbacks array to an empty array.
	 * 
	 * @return Event
	 */
	public function reset()
	{
		$this->_callbacks = array();
		
		return $this;
	}
	
	/**
	 * Executes the event calling all callbacks with the given data.
	 * 
	 * @return	void
	 */
	public function execute()
	{
		$this->_active = TRUE;
		
		foreach ($this->_callbacks as $callback)
		{
			if ( ! $this->_active)
			{
				return;
			}

			call_user_func($callback, $this);
		}
	}

	/**
	 * Will stop the execution of the event.
	 *
	 * @return void
	 */
	public function stop()
	{
		$this->_active = FALSE;
	}
	
} // End Event