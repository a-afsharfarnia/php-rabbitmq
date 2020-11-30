<?php
/**
 * Created by PhpStorm.
 * User: Abbas AfsharFarnia
 * Date: 20/04/19
 * Time: 9:00 AM
 */

namespace SampleBundle\Services;

use OldSound\RabbitMqBundle\RabbitMq\Producer;

class RabbitMQProducerService
{
   /** @var Producer */
    private $producer;

    private $producerParameters = [
        "content_type" => 'text/plain',
        "delivery_mode" => 2,
        "exchange" => [
            'name' => 'test',
            'type' => 'direct',
            'passive' => false,
            'durable' => true,
            'auto_delete' => false,
            'internal' => false,
            'nowait' => false,
            'declare' => true,
            'arguments' => NULL,
            'ticket' => NULL
        ]
    ];

    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    public function produceMessage($message, $exchangeName = null, $queueName = null)
    {
        if ($exchangeName === null) {
            $exchangeName = "email_exchange";
        }

        if ($queueName === null) {
            $queueName = "email_queue_1";
        }

        $parameters = [
            "content_type" => 'text/plain',
            "delivery_mode" => 2,
            "exchange" => [
                'name' => $exchangeName,
                'type' => 'direct',
                'passive' => false,
                'durable' => true,
                'auto_delete' => false,
                'internal' => false,
                'nowait' => false,
                'declare' => true,
                'arguments' => NULL,
                'ticket' => NULL
            ],
            "new_queue" => [
                'name' => $queueName,
                'passive' => false,
                'durable' => true,
                'exclusive' => false,
                'auto_delete' => false,
                'nowait' => false,
                'declare' => true,
                'arguments' => NULL,
                'ticket' => NULL,
                'routing_keys' => []
            ]
        ];

        $this->producerPublish($message, $parameters);
    }

    /**
     * Example For $parameters:
     *
     * [
     *      "content_type" =>  'text/plain',
     *      "delivery_mode" => 2,
     *      "exchange" => [
     *          'name' => 'test-rmq',
     *          'type' => 'direct',
     *          'passive' => false,
     *          'durable' => true,
     *          'auto_delete' => false,
     *          'internal' => false,
     *          'nowait' => false,
     *          'declare' => true,
     *          'arguments' => NULL,
     *          'ticket' => NULL
     *      ],
     *      "new_queue" => [
     *          'name' => 'test-rmq',
     *          'passive' => false,
     *          'durable' => true,
     *          'exclusive' => false,
     *          'auto_delete' => false,
     *          'nowait' => false,
     *          'declare' => true,
     *          'arguments' => NULL,
     *          'ticket' => NULL,
     *          'routing_keys' => []
     *      ]
     * ]
     *
     * If you want to define a new queue, add the "new_queue" element, else you must not add the "new_queue" element.
     *
     * @param $message
     * @param array $parameters
     * @return array|string
     */
    private function producerPublish($message, array $parameters =[])
    {
        if (is_array($message)) {
            $message = json_encode($message);
        }

        $this->setProducerParameters($parameters);

        $this->producer->publish($message);
    }

    /**
     * @param array $parameters
     * @return void
     */
    private function setProducerParameters(array $parameters = [])
    {
        $this->producerParameters = array_merge($this->producerParameters, $parameters);

        $this->producer->setContentType($this->producerParameters['content_type']);
        $this->producer->setDeliveryMode($this->producerParameters['delivery_mode']);
        $this->producer->setExchangeOptions($this->producerParameters['exchange']);

        //*********************** Create New Queue
        if (array_key_exists("new_queue", $this->producerParameters)) {
            $this->producer->setQueueOptions($this->producerParameters['new_queue']);
        }
    }
}