<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
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
	 * Creates a new instance of an event, overwriting any events with the same name.
	 * 
	 * @return	Event
	 */
	public static function factory($name)
	{
		return $this->_instances[$name] = new self($name);
	}
	
	/**
	 * Retrieves an existing event from existing instances, if none are found an error is thrown.
	 * 
	 * @param	string	The name of the instance.
	 * @throws	Kohana_Exception
	 * @return	Event
	 */
	public static function instance($name)
	{
		if (isset(self::$_instances[$name]))
		{
			return self::$_instances[$name];
		}
		else
		{
			throw new Kohana_Exception('Event instance :inst could not be found.', array(
				':inst'	=> $name
			));
		}
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
	 * @var mixed
	 */
	protected $_data;
	
	/**
	 * A list of callbacks to be called by the event on invoke.
	 * 
	 * @var	array
	 */
	protected $_callbacks;
	
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
	 * Binds an object by reference.
	 * 
	 * @param	mixed	The data.
	 * @return	Event
	 */
	public function bind($data)
	{
		$this->data =& $data;
		
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
			call_user_func($callback, $this->data);
		}
	}
	
} // End Event