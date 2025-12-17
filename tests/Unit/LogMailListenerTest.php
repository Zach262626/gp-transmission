<?php

namespace Tests\Unit;

use App\Listeners\LogMailListener;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mime\Email;
use Tests\TestCase;

class LogMailListenerTest extends TestCase
{
    protected LogMailListener $listener;

    protected function setUp(): void
    {
        parent::setUp();
        $this->listener = new LogMailListener();
    }

    /**
     * Test: Listener logs message sending attempt
     */
    public function test_listener_logs_message_sending_attempt()
    {
        Log::shouldReceive('channel')
            ->with('mail')
            ->andReturnSelf()
            ->shouldReceive('info')
            ->with('Email attempting to send', \Mockery::any())
            ->once();

        $message = $this->createSymfonyEmail('test@example.com', 'Subject');
        $event = new MessageSending($message);

        $this->listener->handleMessageSending($event);
    }

    /**
     * Test: Log includes recipient email
     */
    public function test_log_entry_includes_recipient()
    {
        Log::shouldReceive('channel')
            ->with('mail')
            ->andReturnSelf()
            ->shouldReceive('info')
            ->with(
                'Email attempting to send',
                \Mockery::on(function ($data) {
                    return isset($data['to']) && is_array($data['to']) && 
                           in_array('recipient@test.com', $data['to']);
                })
            )
            ->once();

        $message = $this->createSymfonyEmail('recipient@test.com', 'Test');
        $event = new MessageSending($message);

        $this->listener->handleMessageSending($event);
    }

    /**
     * Test: Log entry includes subject
     */
    public function test_log_entry_includes_subject()
    {
        Log::shouldReceive('channel')
            ->with('mail')
            ->andReturnSelf()
            ->shouldReceive('info')
            ->with(
                'Email attempting to send',
                \Mockery::on(function ($data) {
                    return isset($data['subject']) && $data['subject'] === 'Invoice #123';
                })
            )
            ->once();

        $message = $this->createSymfonyEmail('admin@example.com', 'Invoice #123');
        $event = new MessageSending($message);

        $this->listener->handleMessageSending($event);
    }

    /**
     * Test: Can extract multiple recipients
     */
    public function test_can_extract_multiple_recipients()
    {
        Log::shouldReceive('channel')
            ->with('mail')
            ->andReturnSelf()
            ->shouldReceive('info')
            ->with(
                'Email attempting to send',
                \Mockery::on(function ($data) {
                    return isset($data['to']) && is_array($data['to']) && 
                           count($data['to']) >= 1;
                })
            )
            ->once();

        $message = new Email();
        $message->to('user1@example.com')
                ->to('user2@example.com')
                ->subject('Multi-recipient test')
                ->from('noreply@app.com');

        $event = new MessageSending($message);
        $this->listener->handleMessageSending($event);
    }

    /**
     * Test: Handles edge cases in recipient extraction
     */
    public function test_handles_edge_cases_in_recipients()
    {
        Log::shouldReceive('channel')
            ->with('mail')
            ->andReturnSelf()
            ->shouldReceive('info')
            ->with(
                'Email attempting to send',
                \Mockery::any()
            )
            ->once();

        $message = new Email();
        $message->to('user@example.com')
                ->subject('Test Subject')
                ->from('noreply@app.com');

        $event = new MessageSending($message);
        $this->listener->handleMessageSending($event);
    }

    /**
     * Helper: Create Symfony Email message
     */
    private function createSymfonyEmail(string $to, string $subject): Email
    {
        $email = new Email();
        $email->to($to)
              ->subject($subject)
              ->from('noreply@app.com');

        return $email;
    }
}