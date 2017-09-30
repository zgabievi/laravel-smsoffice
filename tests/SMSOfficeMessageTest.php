<?php

namespace Gabievi\LaravelSMSOffice\Tests;

use PHPUnit\Framework\TestCase;
use Gabievi\LaravelSMSOffice\SMSOfficeMessage;

class SMSOfficeMessageTest extends TestCase
{
    /** @test */
    public function it_can_accept_a_content_in_construct()
    {
        $message = new SMSOfficeMessage('hello');

        $this->assertEquals('hello', $message->content);
    }

    /** @test */
    public function it_can_accept_a_content_with_create_method()
    {
        $message = SMSOfficeMessage::create('hello');

        $this->assertEquals('hello', $message->content);
    }

    /** @test */
    public function it_can_set_content_on_initialed_message()
    {
        $message = new SMSOfficeMessage;
        $message->content('hello');

        $this->assertEquals('hello', $message->content);
    }
}
