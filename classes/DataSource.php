<?php
/**
 * Class DataSource
 */

abstract class DataSource {
    private static $_dataSources;

    private $_name = null;

    private $_parameters = array();

    public function __construct($name)
    {
        $this->_name = $name;
        self::$_dataSources[] = $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set a parameter on this data source
     *
     * @param $parameterName Name of the parameter
     * @param $parameterValue Value of the parameter
     */
    public function setParameter($parameterName, $parameterValue)
    {
        $this->_parameters[$parameterName] = $parameterValue;
    }

    public function getParameter($parameterName)
    {
        return $this->_parameters[$parameterName];
    }

    public static function getAllDataSources()
    {
        return self::$_dataSources;
    }
}