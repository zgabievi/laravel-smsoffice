<?php

namespace Gabievi\LaravelSMSOffice\Tests;

use PHPUnit\Framework\TestCase;
use Gabievi\LaravelSMSOffice\SMSOffice;

class SMSOfficeTest extends TestCase
{
    /** @var SMSOffice */
    private $smsoffice;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();

        $this->smsoffice = new SMSOffice('TEST_KEY', 'JOHN');
    }

    /** @test */
    public function it_throws_exception_if_recipient_is_not_defined()
    {
        $this->expectException(\DomainException::class);

        $this->smsoffice->send([
            'content' => 'TEST_MESSAGE',
        ]);
    }

    /** @test */
    public function it_throws_exception_if_content_is_not_defined()
    {
        $this->expectException(\DomainException::class);

        $this->smsoffice->send([
            'destination' => '995500123456',
        ]);
    }

    /** @test */
    public function it_throws_exception_if_key_parameter_is_not_correct()
    {
        $this->expectException(\DomainException::class);

        $this->smsoffice->send([
            'destination' => '995500123456',
            'content' => 'TEST_MESSAGE',
        ]);
    }
}
