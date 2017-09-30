<?php

namespace Gabievi\LaravelSMSOffice\Tests;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Gabievi\LaravelSMSOffice\SMSOffice;
use Illuminate\Notifications\Notification;
use Gabievi\LaravelSMSOffice\SMSOfficeChannel;
use Gabievi\LaravelSMSOffice\SMSOfficeMessage;
use Gabievi\LaravelSMSOffice\Exceptions\MissingRecipient;

class SMSOfficeChannelTest extends TestCase
{
    /** @var SMSOffice */
    private $smsoffice;

    /** @var SMSOfficeMessage */
    private $message;

    /** @var SMSOfficeChannel */
    private $channel;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();

        $this->smsoffice = M::mock(SMSOffice::class, ['TEST_KEY', 'JOHN']);
        $this->channel = new SMSOfficeChannel($this->smsoffice);
        $this->message = M::mock(SMSOfficeMessage::class);
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
        M::close();

        parent::tearDown();
    }

    /** @test */
    public function it_can_send_a_notification()
    {
        $params = [
            'destination' => '1234567890',
            'content'     => 'hello',
        ];

        $this->smsoffice->shouldReceive('send')
            ->once()
            ->with(M::on(function ($base) use ($params) {
                $this->assertEquals($base, $params);

                return $base === $params;
            }));

        $this->channel->send(new TestNotifiable, new TestNotification);
    }

    /** @test */
    public function it_does_not_send_a_message_when_recipient_missing()
    {
        $this->expectException(MissingRecipient::class);

        $this->channel->send(new TestNotifiableWithoutRouteNotificationMethod, new TestNotification);
    }

    /** @test */
    public function it_sends_notification_with_inline_message()
    {
        $params = [
            'destination' => '1234567890',
            'content'     => 'hello',
        ];

        $this->smsoffice->shouldReceive('send')
            ->once()
            ->with(M::on(function ($base) use ($params) {
                $this->assertEquals($base, $params);

                return $base === $params;
            }));

        $this->channel->send(new TestNotifiable, new TestNotificationWithInlineMessage);
    }
}

class TestNotifiable
{
    public function routeNotificationFor()
    {
        return '+001234567890';
    }
}

class TestNotifiableWithoutRouteNotificationMethod extends TestNotifiable
{
    public function routeNotificationFor()
    {
        return false;
    }
}

class TestNotification extends Notification
{
    public function toSMSOffice()
    {
        return SMSOfficeMessage::create('hello');
    }
}

class TestNotificationWithInlineMessage extends Notification
{
    public function toSMSOffice()
    {
        return 'hello';
    }
}
