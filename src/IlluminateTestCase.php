<?php namespace Cartalyst\Testing;
/**
 * Part of the Testing package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Testing
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;

class IlluminateTestCase extends PHPUnit_Framework_TestCase {

	/**
	 * Close mockery.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		m::close();
	}

	/**
	 * Setup.
	 *
	 * @return void
	 */
	public function setUp()
	{
		// IoC Container
		$this->app = new Container;

		// IoC Bindings
		$this->app['alerts']     = m::mock('Cartalyst\Alerts\Alerts');
		$this->app['cache']      = m::mock('Illuminate\Cache\CacheManager');
		$this->app['config']     = m::mock('Illuminate\Config\Repository');
		$this->app['datagrid']   = m::mock('Cartalyst\DataGrid\DataGrid');
		$this->app['events']     = m::mock('Illuminate\Events\Dispatcher');
		$this->app['files']      = m::mock('Illuminate\Filesystem\Filesystem');
		$this->app['redirect']   = m::mock('Illuminate\Routing\Redirector');
		$this->app['request']    = m::mock('Illuminate\Http\Request');
		$this->app['sentinel']   = m::mock('Cartalyst\Sentinel\Sentinel');
		$this->app['session']    = m::mock('Illuminate\Session\SessionManager');
		$this->app['translator'] = m::mock('Illuminate\Translation\Translator');
		$this->app['url']        = m::mock('Illuminate\Routing\UrlGenerator');
		$this->app['validator']  = m::mock('Illuminate\Validation\Factory');
		$this->app['view']       = m::mock('Illuminate\View\Factory');

		// Configurations
		$this->app['config']->shouldIgnoreMissing();

		// Set the facade container
		Facade::setFacadeApplication($this->app);
	}

	/**
	 * Set trans expectation.
	 *
	 * @param  int  $times
	 * @return this
	 */
	protected function trans($times = 1)
	{
		$this->app['translator']->shouldReceive('trans')
			->times($times);

		return $this;
	}

	/**
	 * Set a redirect method expectation.
	 *
	 * @param  $method  string
	 * @return this
	 */
	protected function redirect($method)
	{
		$this->app['redirect']->shouldReceive($method)
			->once()
			->andReturn($this->app['redirect']);

		return $this;
	}

}
