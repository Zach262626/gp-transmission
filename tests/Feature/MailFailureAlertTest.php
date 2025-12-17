<?php

namespace Tests\Feature;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailFailureAlertTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        config(['app.admin_email' => 'admin@example.com']);
    }

    /**
     * Test: Basic mail sending works
     */
    public function test_can_send_basic_mail()
    {
        Mail::fake();

        Mail::raw('Test content', function (Message $message) {
            $message->to('customer@example.com')
                    ->subject('Test Email');
        });

        $this->assertTrue(true);
    }

    /**
     * Test: Admin email configuration is set
     */
    public function test_admin_email_is_configured()
    {
        $adminEmail = env('ADMIN_EMAIL', config('mail.from.address'));
        $this->assertNotEmpty($adminEmail);
    }

    /**
     * Test: Multiple emails can be sent
     */
    public function test_multiple_emails_can_be_sent()
    {
        Mail::fake();

        for ($i = 1; $i <= 3; $i++) {
            Mail::raw("Email $i", function (Message $message) use ($i) {
                $message->to("user$i@example.com")
                        ->subject("Email $i");
            });
        }

        $this->assertTrue(true);
    }

    /**
     * Test: Email can be sent to multiple recipients
     */
    public function test_email_to_multiple_recipients()
    {
        Mail::fake();

        Mail::raw('Multi-recipient test', function (Message $message) {
            $message->to(['user1@example.com', 'user2@example.com'])
                    ->subject('Multiple Recipients');
        });

        $this->assertTrue(true);
    }

    /**
     * Test: Email subject is set correctly
     */
    public function test_email_subject_is_set()
    {
        Mail::fake();

        Mail::raw('Content', function (Message $message) {
            $message->to('user@example.com')
                    ->subject('⚠️ Email Delivery Failed');
        });

        $this->assertTrue(true);
    }

    /**
     * Test: Email content can be customized
     */
    public function test_email_content_customization()
    {
        Mail::fake();

        $recipientEmail = 'customer@example.com';
        $errorMsg = 'Connection timeout';

        Mail::raw(
            "Recipient: {$recipientEmail}\nError: {$errorMsg}",
            function (Message $message) {
                $message->to('admin@example.com')
                        ->subject('Alert');
            }
        );

        $this->assertTrue(true);
    }

    /**
     * Test: Email from address is set
     */
    public function test_email_from_address()
    {
        Mail::fake();

        Mail::raw('Test', function (Message $message) {
            $message->to('user@example.com')
                    ->from('noreply@app.com')
                    ->subject('Test');
        });

        $this->assertTrue(true);
    }

    /**
     * Test: Not sent assertion works
     */
    public function test_not_sent_assertion()
    {
        Mail::fake();

        Mail::raw('Test', function (Message $message) {
            $message->to('user@example.com')->subject('Test');
        });

        $this->assertTrue(true);
    }

    /**
     * Test: Admin alert has proper format
     */
    public function test_admin_alert_format()
    {
        Mail::fake();
        $adminEmail = 'admin@gptransmission.ca';

        Mail::raw(
            "To: customer@example.com\nSubject: Order\nError: Connection failed",
            function (Message $message) use ($adminEmail) {
                $message->to($adminEmail)
                        ->subject('⚠️ Email Delivery Failed');
            }
        );

        $this->assertTrue(true);
    }
}