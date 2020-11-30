<?php
/**
 * Created by PhpStorm.
 * User: Abbas AfsharFarnia
 * Date: 20/04/19
 * Time: 9:00 AM
 */

namespace SampleBundle\Services;

use OldSound\RabbitMqBundle\Provider\ConnectionParametersProviderInterface;

class RabbitMQConnectionService implements ConnectionParametersProviderInterface {

    protected $connectionParameters = [
        'host' => 'localhost',
        'port' => 5672,
        'user' => 'guest',
        'password' => 'guest',
        'vhost' => 'foo',
        'lazy' => true,
        'connection_timeout' => 3,
        'read_write_timeout' => 2,
        'keepalive' => false,
        'heartbeat' => 0,
        'use_socket' => false
    ];

    /**
     * Example for $parameters:
     * [
     *   'host' => 'localhost',
     *   'port' => 5672,
     *   'user' => 'guest',
     *   'password' => 'guest',
     *   'vhost' => 'foo',
     *   'lazy' => true,
     *   'connection_timeout' => 3,
     *   'read_write_timeout' => 2,
     *   'keepalive' => false,
     *   'heartbeat' => 0,
     *   'use_socket' => false
     * ]
     *
     * @param array $parameters
     * @return void
     */
    public function setConnectionParameters(array $parameters = [])
    {
        $this->connectionParameters = array_merge($this->connectionParameters, $parameters);
    }

    public function getConnectionParameters() {
        return $this->connectionParameters;
    }
}