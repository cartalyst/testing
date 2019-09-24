<?php

/*
 * Part of the Testing package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Testing
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Testing;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;

class IlluminateTestCase extends TestCase
{
    /**
     * Close mockery.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /**
     * Setup.
     *
     * @return void
     */
    protected function setUp(): void
    {
        // IoC Container
        $this->app = new Container();

        // IoC Bindings
        $this->app['alerts']   = m::mock('Cartalyst\Alerts\Alerts');
        $this->app['datagrid'] = m::mock('Cartalyst\DataGrid\DataGrid');
        $this->app['sentinel'] = m::mock('Cartalyst\Sentinel\Sentinel');

        $this->app['cache']      = m::mock('Illuminate\Cache\CacheManager');
        $this->app['config']     = m::mock('Illuminate\Config\Repository');
        $this->app['events']     = m::mock('Illuminate\Events\Dispatcher');
        $this->app['files']      = m::mock('Illuminate\Filesystem\Filesystem');
        $this->app['redirect']   = m::mock('Illuminate\Routing\Redirector');
        $this->app['request']    = m::mock('Illuminate\Http\Request');
        $this->app['session']    = m::mock('Illuminate\Session\SessionManager');
        $this->app['translator'] = m::mock('Illuminate\Translation\Translator');
        $this->app['validator']  = m::mock('Illuminate\Validation\Factory');
        $this->app['view']       = m::mock('Illuminate\View\Factory');

        $this->app['Illuminate\Contracts\View\Factory']            = m::mock('Illuminate\View\Factory');
        $this->app['Illuminate\Contracts\Routing\ResponseFactory'] = m::mock('Illuminate\Contracts\Routing\ResponseFactory');
        $this->app['Illuminate\Contracts\Routing\UrlGenerator']    = m::mock('Illuminate\Contracts\Routing\UrlGenerator');

        // Configurations
        $this->app['config']->shouldIgnoreMissing();

        // Set the container instance
        Container::setInstance($this->app);

        // Set the facade container
        Facade::setFacadeApplication($this->app);
    }

    /**
     * Set trans expectation.
     *
     * @param int $times
     *
     * @return $this
     */
    protected function trans(int $times = 1): self
    {
        $this->app['translator']->shouldReceive('trans')->times($times);

        return $this;
    }

    /**
     * Set a redirect method expectation.
     *
     * @param string $method
     *
     * @return $this
     */
    protected function redirect(string $method): self
    {
        $this->app['redirect']->shouldReceive($method)
            ->once()
            ->andReturn($this->app['redirect'])
        ;

        return $this;
    }
}
