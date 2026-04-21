<?php

namespace Interdotz\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;
use Interdotz\Sdk\Auth\AuthClient;
use Interdotz\Sdk\InterdotzClient;
use Interdotz\Sdk\Mailbox\MailboxClient;
use Interdotz\Sdk\Payment\PaymentClient;
use Interdotz\Sdk\Sso\SsoClient;
use Interdotz\Sdk\Webhook\WebhookHandler;

/**
 * @method static AuthClient auth()
 * @method static MailboxClient mailbox()
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

    public static function routes(array $options = []): void
    {
        $prefix     = $options['prefix']     ?? 'api/client';
        $middleware = $options['middleware']  ?? ['api'];

        Route::prefix($prefix)->middleware($middleware)->group(
            __DIR__ . '/../../routes/mailbox.php'
        );
    }
}
