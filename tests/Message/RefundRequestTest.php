<?php

namespace Omnipay\AlliedWallet\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    /** @var  AbstractRequest */
    protected $request;

    public function setUp()
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setTransactionReference('123456')
            ->setAmount('400.00');
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('RefundSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('123456', $response->getTransactionReference());
        $this->assertSame('Success', $response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('RefundFailure.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Failure', $response->getMessage());
    }
}
