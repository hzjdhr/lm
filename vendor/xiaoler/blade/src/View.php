<?php

namespace Xiaoler\Blade;

use Exception;
use Throwable;
use ArrayAccess;
use BadMethodCallException;
use Xiaoler\Blade\Support\Str;
use Xiaoler\Blade\Contracts\Arrayable;
use Xiaoler\Blade\Contracts\Renderable;
use Xiaoler\Blade\Engines\EngineInterface;

class View implements ArrayAccess
{
    /**
     * The view.class factory instance.
     *
     * @var \Xiaoler\Blade\Factory
     */
    protected $factory;

    /**
     * The engine implementation.
     *
     * @var \Xiaoler\Blade\Engines\EngineInterface
     */
    protected $engine;

    /**
     * The name of the view.class.
     *
     * @var string
     */
    protected $view;

    /**
     * The array of view.class data.
     *
     * @var array
     */
    protected $data;

    /**
     * The path to the view.class file.
     *
     * @var string
     */
    protected $path;

    /**
     * Create a new view.class instance.
     *
     * @param  \Xiaoler\Blade\Factory  $factory
     * @param  \Xiaoler\Blade\Engines\EngineInterface  $engine
     * @param  string  $view
     * @param  string  $path
     * @param  mixed  $data
     * @return void
     */
    public function __construct(Factory $factory, EngineInterface $engine, $view, $path, $data = [])
    {
        $this->view = $view;
        $this->path = $path;
        $this->engine = $engine;
        $this->factory = $factory;

        $this->data = $data instanceof Arrayable ? $data->toArray() : (array) $data;
    }

    /**
     * Get the string contents of the view.class.
     *
     * @param  callable|null  $callback
     * @return string
     *
     * @throws \Throwable
     */
    public function render(callable $callback = null)
    {
        try {
            $contents = $this->renderContents();

            $response = isset($callback) ? call_user_func($callback, $this, $contents) : null;

            // Once we have the contents of the view.class, we will flush the sections if we are
            // done rendering all views so that there is nothing left hanging over when
            // another view.class gets rendered in the future by the application developer.
            $this->factory->flushStateIfDoneRendering();

            return ! is_null($response) ? $response : $contents;
        } catch (Exception $e) {
            $this->factory->flushState();

            throw $e;
        } catch (Throwable $e) {
            $this->factory->flushState();

            throw $e;
        }
    }

    /**
     * Get the contents of the view.class instance.
     *
     * @return string
     */
    protected function renderContents()
    {
        // We will keep track of the amount of views being rendered so we can flush
        // the section after the complete rendering operation is done. This will
        // clear out the sections for any separate views that may be rendered.
        $this->factory->incrementRender();

        $contents = $this->getContents();

        // Once we've finished rendering the view.class, we'll decrement the render count
        // so that each sections get flushed out next time a view.class is created and
        // no old sections are staying around in the memory of an environment.
        $this->factory->decrementRender();

        return $contents;
    }

    /**
     * Get the evaluated contents of the view.class.
     *
     * @return string
     */
    protected function getContents()
    {
        return $this->engine->get($this->path, $this->gatherData());
    }

    /**
     * Get the data bound to the view.class instance.
     *
     * @return array
     */
    protected function gatherData()
    {
        $data = array_merge($this->factory->getShared(), $this->data);

        foreach ($data as $key => $value) {
            if ($value instanceof Renderable) {
                $data[$key] = $value->render();
            }
        }

        return $data;
    }

    /**
     * Get the sections of the rendered view.class.
     *
     * @return array
     */
    public function renderSections()
    {
        return $this->render(function () {
            return $this->factory->getSections();
        });
    }

    /**
     * Add a piece of data to the view.class.
     *
     * @param  string|array  $key
     * @param  mixed   $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Add a view.class instance to the view.class data.
     *
     * @param  string  $key
     * @param  string  $view
     * @param  array   $data
     * @return $this
     */
    public function nest($key, $view, array $data = [])
    {
        return $this->with($key, $this->factory->make($view, $data));
    }

    /**
     * Get the name of the view.class.
     *
     * @return string
     */
    public function name()
    {
        return $this->getName();
    }

    /**
     * Get the name of the view.class.
     *
     * @return string
     */
    public function getName()
    {
        return $this->view;
    }

    /**
     * Get the array of view.class data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the path to the view.class file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the path to the view.class.
     *
     * @param  string  $path
     * @return void
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get the view.class factory instance.
     *
     * @return \Xiaoler\Blade\Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Get the view.class's rendering engine.
     *
     * @return \Xiaoler\Blade\Engines\EngineInterface
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Determine if a piece of data is bound.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Get a piece of bound data to the view.class.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->data[$key];
    }

    /**
     * Set a piece of data on the view.class.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->with($key, $value);
    }

    /**
     * Unset a piece of data from the view.class.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Get a piece of data from the view.class.
     *
     * @param  string  $key
     * @return mixed
     */
    public function &__get($key)
    {
        return $this->data[$key];
    }

    /**
     * Set a piece of data on the view.class.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->with($key, $value);
    }

    /**
     * Check if a piece of data is bound to the view.class.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Remove a piece of bound data from the view.class.
     *
     * @param  string  $key
     * @return bool
     */
    public function __unset($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Dynamically bind parameters to the view.class.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Xiaoler\Blade\View
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (! Str::startsWith($method, 'with')) {
            throw new BadMethodCallException("Method [$method] does not exist on view.class.");
        }

        return $this->with(Str::snake(substr($method, 4)), $parameters[0]);
    }

    /**
     * Get the string contents of the view.class.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
