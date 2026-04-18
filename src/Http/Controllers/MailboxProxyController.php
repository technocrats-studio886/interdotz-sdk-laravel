<?php

namespace Interdotz\Laravel\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Interdotz\Sdk\Exceptions\MailboxException;
use Interdotz\Sdk\InterdotzClient;

class MailboxProxyController extends Controller
{
    public function __construct(
        private readonly InterdotzClient $client,
    ) {}

    public function inbox(Request $request): JsonResponse
    {
        return $this->proxy(fn() => $this->client->mailbox()->getInbox(
            accessToken: $this->token($request),
            page:        $request->integer('page', 0),
            size:        $request->integer('size', 20),
        ));
    }

    public function sent(Request $request): JsonResponse
    {
        return $this->proxy(fn() => $this->client->mailbox()->getSent(
            accessToken: $this->token($request),
            page:        $request->integer('page', 0),
            size:        $request->integer('size', 20),
        ));
    }

    public function detail(Request $request, string $mailId): JsonResponse
    {
        return $this->proxy(fn() => $this->client->mailbox()->getDetail(
            accessToken: $this->token($request),
            mailId:      $mailId,
        ));
    }

    public function send(Request $request): JsonResponse
    {
        $request->validate([
            'recipient_id'        => 'required|string',
            'recipient_client_id' => 'required|string',
            'subject'             => 'required|string|max:200',
            'body'                => 'required|string',
        ]);

        return $this->proxy(fn() => $this->client->mailbox()->send(
            accessToken:       $this->token($request),
            recipientId:       $request->string('recipient_id'),
            recipientClientId: $request->string('recipient_client_id'),
            subject:           $request->string('subject'),
            body:              $request->string('body'),
        ));
    }

    public function markAsRead(Request $request, string $mailId): JsonResponse
    {
        return $this->proxy(fn() => $this->client->mailbox()->markAsRead(
            accessToken: $this->token($request),
            mailId:      $mailId,
        ));
    }

    public function markAllRead(Request $request): JsonResponse
    {
        return $this->proxy(fn() => ['updated' => $this->client->mailbox()->markAllRead(
            accessToken: $this->token($request),
        )]);
    }

    public function delete(Request $request, string $mailId): JsonResponse
    {
        return $this->proxy(function () use ($request, $mailId) {
            $this->client->mailbox()->delete(
                accessToken: $this->token($request),
                mailId:      $mailId,
            );
            return ['deleted' => true];
        });
    }

    private function token(Request $request): string
    {
        return $request->bearerToken() ?? '';
    }

    private function proxy(callable $fn): JsonResponse
    {
        try {
            return response()->json($fn());
        } catch (MailboxException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
