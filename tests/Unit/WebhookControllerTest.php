<?php

namespace Lumen\Cashier\Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Lumen\Cashier\Events\WebhookHandled;
use Lumen\Cashier\Events\WebhookReceived;
use Lumen\Cashier\Http\Controllers\WebhookController;
use Lumen\Cashier\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class WebhookControllerTest extends TestCase
{
    public function test_proper_methods_are_called_based_on_stripe_event()
    {
        $request = $this->request('charge.succeeded');

        Event::fake([
            WebhookHandled::class,
            WebhookReceived::class,
        ]);

        $response = (new WebhookControllerTestStub)->handleWebhook($request);

        Event::assertDispatched(WebhookReceived::class, function (WebhookReceived $event) use ($request) {
            return $request->getContent() == json_encode($event->payload);
        });

        Event::assertDispatched(WebhookHandled::class, function (WebhookHandled $event) use ($request) {
            return $request->getContent() == json_encode($event->payload);
        });

        $this->assertEquals('Webhook Handled', $response->getContent());
    }

    public function test_normal_response_is_returned_if_method_is_missing()
    {
        $request = $this->request('foo.bar');

        Event::fake([
            WebhookHandled::class,
            WebhookReceived::class,
        ]);

        $response = (new WebhookControllerTestStub)->handleWebhook($request);

        Event::assertDispatched(WebhookReceived::class, function (WebhookReceived $event) use ($request) {
            return $request->getContent() == json_encode($event->payload);
        });

        Event::assertNotDispatched(WebhookHandled::class);

        $this->assertEquals(200, $response->getStatusCode());
    }

    private function request($event)
    {
        return Request::create(
            '/', 'POST', [], [], [], [], json_encode(['type' => $event, 'id' => 'event-id'])
        );
    }
}

class WebhookControllerTestStub extends WebhookController
{
    public function __construct()
    {
        // Don't call parent constructor to prevent setting middleware...
    }

    public function handleChargeSucceeded()
    {
        return new Response('Webhook Handled', 200);
    }
}
