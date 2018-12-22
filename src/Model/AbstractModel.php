<?php

namespace TheRat\LinodeBundle\Model;

use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoCacheExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;

class AbstractModel
{
    /**
     * @var PropertyInfoCacheExtractor
     */
    protected static $propertyInfo;

    /**
     * @var array
     */
    protected static $types = [];

    /**
     * Populates model with type casting based on vars' annotations
     * @param array $data
     *
     * @return $this
     */
    public function populate(array $data = [])
    {
        foreach ($data as $key => $value) {
            $camelKey = preg_replace_callback(
                '/(_([a-z]{1}))/',
                function ($matches) {
                    return strtoupper($matches[2]);
                },
                $key
            );
            if (property_exists($this, $key)) {
                $types = $this->getTypes($key);
                if ($types) {
                    /** @var \Symfony\Component\PropertyInfo\Type $type */
                    $type = array_shift($types);
                    if ($type->getClassName()) {
                        switch ($type->getClassName()) {
                            case \DateTime::class:
                                if (!is_null($value)) {
                                    $value = new \DateTime($value, new \DateTimeZone('UTC'));
                                }
                                break;
                        }
                    } else {
                        switch ($type->getBuiltinType()) {
                            case 'bool':
                                $value = (boolean)$value;
                                break;
                            case 'int':
                                $value = (int)$value;
                                break;
                        }
                    }
                }

                $this->$key = $value;
            } elseif (property_exists($this, $camelKey)) {
                $this->$camelKey = $value;
            }
        }

        return $this;
    }

    public function toArray(array $allowedKeys = [], array $disabledKeys = [])
    {
        $result = null;
        $class = new \ReflectionClass($this);
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $methodName = $method->getName();
            if ($method->getNumberOfParameters() === 0 && (
                    strpos($methodName, "get") === 0
                    || strpos($methodName, "is") === 0
                )) {
                $propertyName = $this->underscore($methodName);
                $propertyName = str_replace(['get_', 'is_'], '', $propertyName);

                if (!empty($allowedKeys) && in_array($propertyName, $allowedKeys)) {
                    $result[$propertyName] = call_user_func_array([$this, $methodName], []);
                } elseif (!empty($disabledKeys) && !in_array($propertyName, $disabledKeys)) {
                    $result[$propertyName] = call_user_func_array([$this, $methodName], []);
                } else {
                    $result[$propertyName] = call_user_func_array([$this, $methodName], []);
                }
            }
        }

        return $result;
    }

    public function underscore($value)
    {
        if (is_numeric($value)) {
            return $value;
        }

        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $value, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    protected function getTypes($key)
    {
        $class = get_class($this);
        if (!array_key_exists($class, self::$types) || !array_key_exists($key, self::$types[$class])) {
            self::$types[$class][$key] = $this->getPropertyInfo()->getTypes(get_class($this), $key);
        }

        return self::$types[$class][$key];
    }

    /**
     * @return PropertyInfoCacheExtractor
     */
    protected function getPropertyInfo()
    {
        if (!self::$propertyInfo) {
            $phpDocExtractor = new PhpDocExtractor();
            $propertyInfo = new PropertyInfoExtractor([], [$phpDocExtractor]);
            self::$propertyInfo = new PropertyInfoCacheExtractor($propertyInfo, new ArrayAdapter());
        }

        return self::$propertyInfo;
    }
}