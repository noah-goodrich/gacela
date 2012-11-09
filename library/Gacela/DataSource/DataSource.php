<?php
/**
 * @author Noah Goodrich
 * @date May 7, 2011
 *
 *
*/

namespace Gacela\DataSource;

abstract class DataSource implements iDataSource
{

	protected $_config = array();

	protected $_resources = array();

	/**
	 * @var \Gacela\DataSource\Adapter\Adapter
	 */
	protected $_adapter;

	/**
	 * @var \Gacela
	 */
	protected $_gacela;

	protected $_lastQuery = array();

	/**
	 * @param $name
	 * @param $key
	 * @param null $data
	 * @return mixed
	 */
	protected function _cache($name, $key, $data = null)
	{
		$instance = $this->_gacela;

		$version = $instance->cache($name . '_version');

		if (is_null($version) || $version === false) {
			$version = 0;
			$instance->cache($name . '_version', $version);
		}

		$key = 'query_' . $version . '_' . $key;

		$cached = $instance->cache($key);

		if (is_null($data)) {
			return $cached;
		}

		if ($cached === false) {
			$instance->cache($key, $data);
		} else {
			$instance->cache($key, $data, true);
		}
	}

	/**
	 * @param $name
	 */
	protected function _incrementCache($name)
	{
		$instance = $this->_gacela;

		$cached = $instance->cache($name.'_version');

		if($cached !== false) {
			$instance->incrementCache($name.'_version');
		}
	}

	protected function _setLastQuery($query, $args = array())
	{
		if($query instanceof Query\Query)  {
			// Using the _lastQuery variable so that we can see the query when debugging
			list($this->_lastQuery['query'], $this->_lastQuery['args']) = $query->assemble();
		} else {
			if(is_null($args)) {
				$args = array();
			}

			$this->_lastQuery = array('query' => $query, 'args' => $args);
		}

		return hash('whirlpool', serialize(array($this->_lastQuery['query'], $this->_lastQuery['args'])));
	}

	public function __construct(\Gacela $gacela, \Gacela\DataSource\Adapter\iAdapter $adapter, array $config)
	{
		$this->_gacela = $gacela;

		$this->_adapter = $adapter;

		$this->_config = (object) $config;
	}

	public function beginTransaction()
	{
		return false;
	}

	public function createConfig($name, $fields, $write = false)
	{
		$resource = $this->loadResource($name, true);

		$resource = (array) $resource;

		$resource = array_shift($resource);

		foreach($resource['columns'] as $field => $meta)
		{
			if(!in_array($field, $fields)) {
				unset($resource['columns'][$field]);
			}
			else {
				foreach($meta as $k => $m) {
					if(is_object($m)) {
						$meta[$k] = (array) $m;
					}
				}

				$resource['columns'][$field] = (array) $meta;
			}
		}

		$string = "<?php \n\n return ".var_export($resource, true);

		$string .= ';';

		if($write) {
			$handle = fopen($this->_gacela->configPath().$name.'.php', 'w+');

			if(!fwrite($handle, $string)) {
				return false;
			}
		}

		return $string;
	}

	public function commitTransaction()
	{
		return false;
	}

	public function getName()
	{
		return $this->_config->name;
	}

	public function lastQuery()
	{
		return $this->_lastQuery;
	}

	/**
	 * @see \Gacela\DataSource\iDataSource::loadResource()
	 */
	public function loadResource($name, $force = false)
	{
		$cached = $this->_gacela->cacheMetaData('resource_'.$name);

		if(!$cached || $force)  {
			$class = $this->_gacela->autoload("DataSource\\Resource");

			$cached = new $class($this->_adapter->load($name, $force));

			$this->_gacela->cacheMetaData($this->_config->name.'_resource_'.$name, $cached);
		}

		return $cached;
	}

	public function rollbackTransaction()
	{
		return false;
	}
}

