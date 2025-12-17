<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
 * ============================================================================
 * MAIL TESTING ROUTES - Remove before production!
 * ============================================================================
 * These routes help manually test the email failure alert system
 * Add these to routes/web.php temporarily
 */

Route::prefix('test-mail')->middleware('auth')->group(function () {

    /**
     * Test 1: Simulate email failure and trigger alert
     * Logs the failure AND sends admin alert email
     */
    Route::get('/failure-simple', function () {
        try {
            throw new Exception('Mailgun API Error: Invalid domain');
        } catch (\Exception $e) {
            $mockMessage = $this->createMockMessage(
                to: ['customer@example.com'],
                subject: 'Order Confirmation #12345'
            );

            Event::dispatch(
                new \Illuminate\Mail\Events\MessageFailed($mockMessage, $e)
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Failure event triggered',
                'checks' => [
                    'Check admin email for failure alert',
                    'Check storage/logs/mail.log for entry',
                ]
            ]);
        }
    });

    /**
     * Test 2: Simulate multiple failures
     * Tests that multiple alerts are sent
     */
    Route::get('/failure-multiple', function () {
        $failures = [
            ['email' => 'user1@example.com', 'subject' => 'Email 1', 'error' => 'SMTP timeout'],
            ['email' => 'user2@example.com', 'subject' => 'Email 2', 'error' => 'Connection refused'],
            ['email' => 'user3@example.com', 'subject' => 'Email 3', 'error' => 'Authentication failed'],
        ];

        foreach ($failures as $failure) {
            $mockMessage = $this->createMockMessage(
                to: $failure['email'],
                subject: $failure['subject']
            );

            Event::dispatch(
                new \Illuminate\Mail\Events\MessageFailed(
                    $mockMessage,
                    new Exception($failure['error'])
                )
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => count($failures) . ' failure events triggered',
            'failures' => $failures,
            'expected' => count($failures) . ' admin alert emails should have been sent',
        ]);
    });

    /**
     * Test 3: Simulate successful email send
     * Logs success but NO alert should be sent
     */
    Route::get('/success', function () {
        $mockMessage = $this->createMockMessage(
            to: ['customer@example.com'],
            subject: 'Welcome to our service'
        );

        Event::dispatch(new \Illuminate\Mail\Events\MessageSent($mockMessage));

        return response()->json([
            'status' => 'success',
            'message' => 'Success event triggered',
            'checks' => [
                'Check storage/logs/mail.log for "sent successfully" entry',
                'Verify NO admin alert was sent (this is correct behavior)',
            ]
        ]);
    });

    /**
     * Test 4: Simulate email sending attempt
     * Logs the attempt
     */
    Route::get('/attempt', function () {
        $mockMessage = $this->createMockMessage(
            to: ['customer@example.com'],
            subject: 'Newsletter #42'
        );

        Event::dispatch(new \Illuminate\Mail\Events\MessageSending($mockMessage));

        return response()->json([
            'status' => 'success',
            'message' => 'Sending attempt event triggered',
            'checks' => [
                'Check storage/logs/mail.log for "attempting to send" entry',
            ]
        ]);
    });

    /**
     * Test 5: Real mailgun test (actually attempts to send)
     * If mailgun fails, alert will be sent
     */
    Route::get('/real-send', function () {
        try {
            Mail::raw('This is a test email from mail alert system', function ($message) {
                $message->to(env('MAIL_TEST_RECIPIENT', 'test@example.com'))
                        ->subject('🧪 Test Email - Mail Alert System');
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Test email sent via Mailgun',
                'recipient' => env('MAIL_TEST_RECIPIENT', 'test@example.com'),
                'checks' => [
                    'Check the recipient inbox for the email',
                    'Check storage/logs/mail.log for success log',
                ]
            ]);
        } catch (\Exception $e) {
            $mockMessage = $this->createMockMessage(
                to: env('MAIL_TEST_RECIPIENT', 'test@example.com'),
                subject: 'Test Email'
            );

            Event::dispatch(
                new \Illuminate\Mail\Events\MessageFailed($mockMessage, $e)
            );

            return response()->json([
                'status' => 'error',
                'message' => 'Test email failed - alert should be sent',
                'error' => $e->getMessage(),
                'checks' => [
                    'Check admin email for failure alert',
                    'Check storage/logs/mail.log for failure entry',
                ]
            ]);
        }
    });

    /**
     * Test 6: Check recent mail logs
     * Shows last 20 lines of mail.log
     */
    Route::get('/check-logs', function () {
        $logFile = storage_path('logs/mail.log');

        if (!file_exists($logFile)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mail log file not found',
                'path' => $logFile,
            ]);
        }

        $lines = array_slice(
            file($logFile),
            max(0, count(file($logFile)) - 20),
            20
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Last 20 lines from mail.log',
            'log_file' => $logFile,
            'lines' => array_map('trim', $lines),
        ]);
    });

    /**
     * Route index - Show all available tests
     */
    Route::get('/', function () {
        $tests = [
            [
                'name' => 'Simple Failure Test',
                'url' => '/test-mail/failure-simple',
                'description' => 'Triggers one email failure and alert'
            ],
            [
                'name' => 'Multiple Failures Test',
                'url' => '/test-mail/failure-multiple',
                'description' => 'Triggers 3 email failures and alerts'
            ],
            [
                'name' => 'Success Test',
                'url' => '/test-mail/success',
                'description' => 'Logs success (no alert should be sent)'
            ],
            [
                'name' => 'Sending Attempt Test',
                'url' => '/test-mail/attempt',
                'description' => 'Logs sending attempt'
            ],
            [
                'name' => 'Real Mailgun Test',
                'url' => '/test-mail/real-send',
                'description' => 'Actually sends email via Mailgun'
            ],
            [
                'name' => 'Check Logs',
                'url' => '/test-mail/check-logs',
                'description' => 'View last 20 lines of mail.log'
            ],
        ];

        return view('test-mail-index', ['tests' => $tests]);
    });
});

/**
 * Helper function to create mock message
 * Place this in your TestCase or as a helper
 */
if (!function_exists('createMockMessage')) {
    function createMockMessage($to, $subject) {
        $message = Mockery::mock(\Swift_Message::class);
        $message->shouldReceive('getTo')->andReturn($to);
        $message->shouldReceive('getSubject')->andReturn($subject);
        $message->shouldReceive('getFrom')->andReturn('noreply@app.com');

        return $message;
    }
}
