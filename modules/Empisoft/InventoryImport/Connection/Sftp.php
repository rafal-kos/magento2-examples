<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Connection;

/**
 * Class Sftp
 *
 * @package Empisoft\InventoryImport\Connection
 */
class Sftp implements \Empisoft\InventoryImport\Api\ConnectionInterface
{
    /** @var \Magento\Framework\Filesystem\Io\Sftp  */
    protected $sftp;

    /** @var \Empisoft\InventoryImport\Model\Config */
    protected $config;

    /** @var bool Is connection open flag */
    protected $connected = false;

    public function __construct(
        \Magento\Framework\Filesystem\Io\Sftp $sftp,
        \Empisoft\InventoryImport\Model\Config $config
    ) {
        $this->sftp = $sftp;
        $this->config = $config;

        // I have disabled connect method from constructor to not initialize it when there is no need for it
        //$this->connect();
    }

    /**
     * Connect to SFTP
     *
     * @return \Magento\Framework\Filesystem\Io\Sftp
     * @throws \Exception
     */
    public function connect()
    {
        $config = $this->getConfig();
        if (!isset($config['hostname'])
            || !isset($config['username'])
            || !isset($config['password'])
            || !isset($config['path'])
        ) {
            throw new \InvalidArgumentException('Required config elements: hostname, username, password, path');
        }

        $this->sftp->open(
            ['host' => $config['hostname'], 'username' => $config['username'], 'password' => $config['password']]
        );
        $this->sftp->cd($config['path']);

        return $this->sftp;
    }

    public function list(): array
    {
        $files = [];

        foreach ($this->getSftp()->rawls() as $filename => $attributes) {
            // ignore directories
            if ($attributes['type'] === NET_SFTP_TYPE_DIRECTORY) {
                continue;
            }

            $files[] = $filename;
        }

        return $files;
    }

    /**
     * Get sftp connection
     *
     * @return \Magento\Framework\Filesystem\Io\Sftp
     * @throws \Exception
     */
    protected function getSftp()
    {
        if (!$this->connected) {
            $this->connect();
            $this->connected = true;
        }

        return $this->sftp;
    }

    public function read($filename, $tmpFile): ?bool
    {
        return $this->getSftp()->read($filename, $tmpFile);
    }

    /**
     * @return array
     */
    protected function getConfig(): array
    {
        return [
            'hostname' => $this->config->getHostname(),
            'path' => $this->config->getPath(),
            'username' => $this->config->getUsername(),
            'password' => $this->config->getPassword()
        ];
    }
}
