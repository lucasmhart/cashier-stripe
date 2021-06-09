<?php

namespace Lumen\Cashier\Exceptions;

use Exception;
use Lumen\Cashier\Subscription;

class SubscriptionUpdateFailure extends Exception
{
    /**
     * Create a new SubscriptionUpdateFailure instance.
     *
     * @param  \Lumen\Cashier\Subscription  $subscription
     * @return static
     */
    public static function incompleteSubscription(Subscription $subscription)
    {
        return new static(
            "The subscription \"{$subscription->stripe_id}\" cannot be updated because its payment is incomplete."
        );
    }
}
