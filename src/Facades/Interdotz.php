<?php

namespace Interdotz\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Interdotz\Sdk\Auth\AuthClient;
use Interdotz\Sdk\InterdotzClient;
use Interdotz\Sdk\Payment\PaymentClient;
use Interdotz\Sdk\Sso\SsoClient;
use Interdotz\Sdk\Webhook\WebhookHandler;

/**
 * @method static AuthClient auth()
 * @method static PaymentClient payment()
 * @method static SsoClient sso()
 * @method static WebhookHandler webhook()
 *
 * @see InterdotzClient
 */
class Interdotz extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return InterdotzClient::class;
    }
}
