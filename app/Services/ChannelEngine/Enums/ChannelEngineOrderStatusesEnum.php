<?php

declare(strict_types=1);

namespace ChannelEngine\Enums;

enum ChannelEngineOrderStatusesEnum
{
    case IN_PROGRESS;
    case SHIPPED;
    case IN_BACKORDER;
    case MANCO;
    case CANCELLED;
    case IN_COMBI;
    case CLOSED;
    case NEW;
    case RETURNED;
    case REQUEST_CORRECTION;
    case AWAITING_PAYMENT;

    public static function fromName(string $name): self
    {
        return self::{$name};
    }
}
