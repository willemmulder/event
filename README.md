# Kohana 3.0 Event Manager

This handly little module is very small, lightweight and well documented.

## User Guide

### Setting up an event

To setup an event you must call the static factory method, specifying the name / identifier of the event. This will return the event object.

#### Binding Userdata

To bind data to the event, use the bind method. This will bind data by reference. In this example i've created a basic setup menu event which binds the current object to the event.

	Event::factory('menu.setup')
		->bind($this);

#### Setting Userdata

In contrast to binding, setting user data is not set by reference, and as such protected the state of the original object.

	Event::factory('menu.setup')
		->set($this);

> Note: All methods are chainable except the invoke() method.

### Retrieving event instances

Events can be retrieved using the instance method. You must be sure that the method has already been created using the factory method, otherwise an exception is thrown.

	Event::instance('menu.setup');

The instance of the event with name `menu.setup` is returned using this method.

### Adding observers / callbacks

To have a function called when the event is invoked, you can use the callback method to add your callback to the event.

	Event::instance('menu.setup')
		->callback(array($this, 'callback'));

> Note: Make sure your callback matches the required delegate (shown below) and is publically accessible, otherwise an exception will be thrown.

On invoke, your callback will be called and given the event object. You need to know what this will be before setting up the callback.

#### Callback Delegate Method

Your callback method should be of the same format as:

	public function callback(Event $event) { }

### Invoking events

This is sometimes called dispatching, but is where every callback in the event object is called with the binded data.

	Event::instance('menu.setup')
		->invoke();

> Note: Do not invoke the same event in a callback otherwise reccursion will occur.