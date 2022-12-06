<?php

namespace vanitokurason\orderlist\models;

final class OrderStatus
{
    private int $status;

    public function __construct(int $status)
    {
        $this->status = $status;
    }

    private const PENDING = 0;
    private const IN_PROGRESS = 1;
    private const COMPLETED = 2;
    private const CANCELED = 3;
    private const ERROR = 4;

    public const STATUSES = [
        self::PENDING,
        self::IN_PROGRESS,
        self::COMPLETED,
        self::CANCELED,
        self::ERROR
    ];

    public const NAMING = [
        self::PENDING => 'Pending',
        self::IN_PROGRESS => 'In progress',
        self::COMPLETED => 'Completed',
        self::CANCELED => 'Canceled',
        self::ERROR => 'Error'
    ];

    public function isNew(): bool
    {
        return $this->status === self::NEW;
    }
}