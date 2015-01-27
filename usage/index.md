## Usage

In this section we'll show how you can make use of the base testing class.

On any phpunit test case, extend the `Cartalyst\Testing\IlluminateTestCase` instead of the `PHPUnit_Framework_TestCase`.

Start using the helpers and bindings on your class.

```php

use Cartalyst\Testing\IlluminateTestCase;

class AdminContentControllerTest extends IlluminateTestCase {

	public function fooTest()
	{
		$this->app['view']->shouldReceive('make')
			->once();

		$this->trans(10);

		$this->controller->index();
	}

}
```

### IoC Bindings

The current classes are bound into the `$app` variable on the base class.

Binding     | Class
----------- | --------
alerts		| Cartalyst\Alerts\Alerts
cache		| Illuminate\Cache\CacheManager
config		| Illuminate\Config\Repository
datagrid	| Cartalyst\DataGrid\DataGrid
events		| Illuminate\Events\Dispatcher
files		| Illuminate\Filesystem\Filesystem
redirect	| Illuminate\Routing\Redirector
request		| Illuminate\Http\Request
sentinel	| Cartalyst\Sentinel\Sentinel
session		| Illuminate\Session\SessionManager
translator	| Illuminate\Translation\Translator
url			| Illuminate\Routing\UrlGenerator
validator	| Illuminate\Validation\Factory
view		| Illuminate\View\Factory

> **Note:** You can pass custom `key`/`value` pairs into the array, please check the examples below.
```

### Helpers

The helpers below will set expectations on different classes to reduce the amount of code required for common expectations.

All helper methods are chainable, meaning you can chain both on one method call.

```php
$this->trans()->redirect('to');
```

#### trans

The trans method sets an expectation on the `translator` class, passing in a number to the `trans` method will set the number of times the expectation should be called.

```php
$this->trans(5);
```

#### redirect

Sets an expectation on the `redirect` class, it receives an argument of the method that should be expected.

```php
$this->redirect('to');
```
