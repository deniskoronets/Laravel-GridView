<?php

namespace Woo\GridView\Traits;

use Closure;
use Woo\GridView\Exceptions\GridViewConfigException;

trait Configurable
{
    /**
     * Allows to load config into object properties
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
     * Should specify tests
     * @return array
     */
    abstract protected function configTests() : array;

    /**
     * Allows to test attributes and types in config
     * @throws GridViewConfigException
     */
    protected function testConfig()
    {
        foreach ($this->configTests() as $property => $tests) {

            if (!property_exists($this, $property)) {
                throw new GridViewConfigException(
                    'Unable to test ' . get_class($this) . ': property ' . $property . ' does not exist'
                );
            }

            $testPassed = true;
            $testMessage = 'Validation failed';

            foreach (explode('|', $tests) as $test) {

                switch ($test) {
                    case 'int':
                        $testPassed = is_numeric($this->$property);
                        $testMessage = 'Property should be numeric';
                        break;

                    case 'string':
                        $testPassed = is_string($this->$property);
                        $testMessage = 'Property should be a string';
                        break;

                    case 'array':
                        $testPassed = is_array($this->$property);
                        $testMessage = 'Property should be an array';
                        break;

                    case 'closure':
                        $testPassed = $this->$property instanceof Closure;
                        $testMessage = 'Property should be a valid callback (Closure instance)';
                        break;

                    case 'boolean':
                        $testPassed = is_bool($this->$property);
                        $testMessage = 'Property should be boolean';
                        break;

                    case 'any':
                        break;

                    default:
                        $testPassed = $testPassed || is_a($this->$property, $test) || is_subclass_of($this->$property, $test);
                        $testMessage = 'Property should be ' . $test . ' instance/class reference, check ' . $property;
                }
            }

            if (!$testPassed) {
                throw new GridViewConfigException(
                    'Tests ' . $tests . ' has failed on ' . get_class($this) . '::' . $property . ': ' . $testMessage
                );
            }
        }
    }
}