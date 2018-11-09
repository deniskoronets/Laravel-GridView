<?php

namespace Woo\GridView\Traits;

use Woo\GridView\Exceptions\GridViewConfigException;

trait Configurable
{
    /**
     * Allows to load config into object properties
     * @param object $object
     * @param array $config
     * @throws GridViewConfigException
     */
    public function loadConfig(array $config)
    {
        foreach ($config as $key => $value) {

            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $this->testConfig();
    }

    /**
     * Override this method in classes
     * @return array
     */
    protected function configTests() : array
    {
        return [];
    }

    /**
     * Allows to test attributes and types in config
     * @param $object
     * @param array $tests
     * @throws GridViewConfigException
     */
    protected function testConfig()
    {
        foreach ($this->configTests() as $property => $test) {

            if (!property_exists($this, $property)) {
                throw new GridViewConfigException(
                    'Unable to test ' . get_class($this) . ': property ' . $property . ' does not exist'
                );
            }

            if (is_scalar($test)) {

                $testPassed = true;

                switch ($test) {
                    case 'int':
                        $testPassed = is_numeric($this->$property);
                        break;

                    case 'string':
                        $testPassed = is_string($this->$property);
                        break;

                    case 'array':
                        $testPassed = is_array($this->$property);
                        break;

                    case 'closure':
                        $testPassed = $this->$property instanceof \Closure;
                        break;

                    case 'any':
                        break;

                    default:
                        $testPassed = is_subclass_of($this->$property, $test);
                }

                if (!$testPassed) {
                    throw new GridViewConfigException('
                        Test ' . $test . ' has failed on ' . get_class($this) . '::' . $property
                    );
                }
            }
        }
    }
}