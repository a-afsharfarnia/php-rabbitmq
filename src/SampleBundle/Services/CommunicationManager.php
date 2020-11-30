<?php
/**
 * Created by PhpStorm.
 * User: majid
 * Date: 4/30/19
 * Time: 9:49 AM
 */

namespace SampleBundle\Services;

class CommunicationManager
{
    private const COMMUNICATION_TYPE_EMAIL = "EMAIL";
    private const COMMUNICATION_TYPE_SMS = "SMS";

    public const COMMUNICATION_PRIORITY_LEVEL_5 = 5; //highest priority
    public const COMMUNICATION_PRIORITY_LEVEL_4 = 4;
    public const COMMUNICATION_PRIORITY_LEVEL_3 = 3;
    public const COMMUNICATION_PRIORITY_LEVEL_2 = 2;
    public const COMMUNICATION_PRIORITY_LEVEL_1 = 1;

    private $rabbitMQProducerService;

    public function __construct(RabbitMQProducerService $rabbitMQProducerService)
    {
        $this->rabbitMQProducerService = $rabbitMQProducerService;
    }

    public function publishEmail($address, $subject, $content, $priority, $scheduledAt = null)
    {
        $data = [
            'receiver' => $address,
            'subject' => $subject,
            'content' => $content,
            'priority' => $priority,
            'type' => strtolower(self::COMMUNICATION_TYPE_EMAIL),
            'scheduledAt' => $scheduledAt ? $scheduledAt->format('Y-m-d  h:i:s') : ''
        ];

        $this->rabbitMQProducerService->produceMessage($data);
    }

    public function publishSMS($phone, $subject, $content, $priority, $scheduledAt = null)
    {
        $data = [
            'receiver' => $phone,
            'subject' => $subject,
            'content' => $content,
            'priority' => $priority,
            'type' => strtolower(self::COMMUNICATION_TYPE_SMS),
            'scheduledAt' => $scheduledAt ? $scheduledAt->format('Y-m-d  h:i:s') : ''
        ];

        $this->rabbitMQProducerService->produceMessage($data);
    }
}