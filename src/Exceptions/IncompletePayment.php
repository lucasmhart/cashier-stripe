<?php

namespace Lumen\Cashier\Exceptions;

use Exception;
use Lumen\Cashier\Payment;
use Throwable;

class IncompletePayment extends Exception
{
    /**
     * The Cashier Payment object.
     *
     * @var \Lumen\Cashier\Payment
     */
    public $payment;

    /**
     * Create a new IncompletePayment instance.
     *
     * @param  \Lumen\Cashier\Payment  $payment
     * @param  string  $message
     * @param  int  $code
     * @param  \Throwable|null  $previous
     * @return void
     */
    public function __construct(Payment $payment, $message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->payment = $payment;
    }
}
