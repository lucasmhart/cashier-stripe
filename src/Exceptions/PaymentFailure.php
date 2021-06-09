<?php

namespace Lumen\Cashier\Exceptions;

use Lumen\Cashier\Payment;

class PaymentFailure extends IncompletePayment
{
    /**
     * Create a new PaymentFailure instance.
     *
     * @param  \Lumen\Cashier\Payment  $payment
     * @return static
     */
    public static function invalidPaymentMethod(Payment $payment)
    {
        return new static(
            $payment,
            'The payment attempt failed because of an invalid payment method.'
        );
    }
}
