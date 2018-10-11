<?php

namespace Woo\GridView;

use Woo\GridView\Exceptions\GridViewConfigException;

class GridViewHelper
{
    private function __construct() {}

    /**
     * Allows to load config into object properties
     * @param object $object
     * @param array $config
     * @throws GridViewConfigException
     */
    public static function loadConfig($object, array $config)
    {
        foreach ($config as $key => $value) {

            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }
    }

    /**
     * Allows to test attributes and types in config
     * @param $object
     * @param array $tests
     * @throws GridViewConfigException
     */
    public static function testConfig($object, array $tests)
    {
        foreach ($tests as $property => $test) {

            if (!property_exists($object, $property)) {
                throw new GridViewConfigException(
                    'Unable to test ' . get_class($object) . ': property ' . $property . ' does not exist'
                );
            }

            if (is_scalar($test)) {

                $testPassed = true;

                switch ($test) {
                    case 'int':
                        $testPassed = is_numeric($object->$property);
                        break;

                    case 'string':
                        $testPassed = is_string($object->$property);
                        break;

                    case 'array':
                        $testPassed = is_array($object->$property);
                        break;

                    case 'closure':
                        $testPassed = $object->$property instanceof \Closure;
                        break;

                    case 'any':
                        break;

                    default:
                        $testPassed = is_subclass_of($object->$property, $test);
                }

                if (!$testPassed) {
                    throw new GridViewConfigException('
                        Test ' . $test . ' has failed on ' . get_class($object) . '::' . $property
                    );
                }
            }
        }
    }

    /**
     * Allows to convert options array to html string
     * @param array $htmlOptions
     * @return string
     */
    public static function htmlOptionsToString(array $htmlOptions) : string
    {
        if (empty($htmlOptions)) {
            return '';
        }

        $out = [];

        foreach ($htmlOptions as $k => $v) {
            $out[] = htmlentities($k) . '="' . htmlentities($v, ENT_COMPAT) . '"';
        }

        return implode(' ', $out);
    }
}