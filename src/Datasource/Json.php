<?php

namespace Nojimage\LocalGovCode\Datasource;

use InvalidArgumentException;
use ReflectionClass;
use RuntimeException;

/**
 * Json Datasource
 */
class Json implements DatasourceInterface
{

    /**
     * Default data packagename
     */
    const DATA_PACKAGENAME = 'nojimage/local-gov-code-jp';

    const PREFECTURES_JSON = 'prefectures.json';

    const CITIES_JSON = 'cities.json';

    const WARDS_JSON = 'wards.json';

    /**
     * @var string
     */
    private $filepath;

    /**
     * @var array
     */
    protected $records;

    /**
     * @var array
     */
    protected $recordsByCode;

    /**
     * @var array
     */
    protected $recordsByName;

    /**
     * constructor
     *
     * @param string $filename
     * @param string $path
     */
    public function __construct($filename, $path = null)
    {
        if ($path === null) {
            $path = $this->getVendorPath() . self::DATA_PACKAGENAME;
        }

        $this->setFilepath($filename, $path);

        $this->loadFile();
    }

    /**
     * Get data filepath
     *
     * @return string
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * Set filepath
     *
     * @param string $filename
     * @param string $path
     * @return void
     * @throws InvalidArgumentException
     */
    protected function setFilepath($filename, $path)
    {

        $path = rtrim($path, '/') . '/';
        $filepath = realpath($path . $filename);

        if (!$filepath || !is_file($filepath)) {
            throw new InvalidArgumentException(sprintf('File not found: %s', $path . $filename));
        }

        $this->filepath = $filepath;
    }

    /**
     * Get a vendor dir
     *
     * @return string
     * @throws RuntimeException
     * @see https://stackoverflow.com/questions/15714809/get-filesystem-path-of-installed-composer-package
     */
    protected function getVendorPath()
    {
        $reflector = new ReflectionClass('\Composer\Autoload\ClassLoader');
        $vendorPath = preg_replace('/^(.*)\/composer\/ClassLoader\.php$/', '$1', $reflector->getFileName());

        if ($vendorPath && is_dir($vendorPath)) {
            return $vendorPath . '/';
        }

        throw new RuntimeException('Unable to detect vendor path.');
    }

    /**
     * Load from file
     *
     * @return void
     * @throws RuntimeException
     */
    protected function loadFile()
    {
        if (!is_file($this->filepath)) {
            throw new RuntimeException(sprintf('File not found: %s', $this->filepath));
        }

        $data = json_decode(file_get_contents($this->filepath), true);
        if (json_last_error()) {
            throw new RuntimeException(sprintf('%s: %s', json_last_error_msg(), $this->filepath));
        }

        $this->reset();

        foreach ($data as $record) {
            $this->records[] = $record;
            $this->recordsByCode[$record['code']] = $record;
            $this->recordsByName[$record['name']] = $record;
        }
    }

    /**
     * Reset data
     *
     * @return void
     */
    protected function reset()
    {
        $this->records = array();
        $this->recordsByCode = array();
        $this->recordsByName = array();
    }

    /**
     * {@inheritDoc}
     */
    public function findByCode($code)
    {
        return isset($this->recordsByCode[$code]) ? $this->recordsByCode[$code] : null;
    }

    /**
     * {@inheritDoc}
     */
    public function findByName($name)
    {
        return isset($this->recordsByName[$name]) ? $this->recordsByName[$name] : null;
    }

    /**
     * {@inheritDoc}
     */
    public function find(array $conditions)
    {
        $founds = array_filter($this->records, function ($record) use ($conditions) {
            $check = array_intersect_key($record, $conditions);

            return $check === $conditions;
        });

        return array_values($founds);
    }
}
