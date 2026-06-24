<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LogMailListener
{
    /**
     * Log email sending attempt (Illuminate\Mail\Events\MessageSending)
     */
    public function handleMessageSending(MessageSending $event)
    {
        $to = $this->getRecipients($event->message);
        $subject = $event->message->getSubject();

        Log::channel('mail')->info('Email attempting to send', [
            'to' => $to,
            'subject' => $subject,
        ]);
    }

    /**
     * Log successful send (Illuminate\Mail\Events\MessageSent)
     */
    public function handleMessageSent(MessageSent $event)
    {
        $to = $this->getRecipients($event->message);
        $subject = $event->message->getSubject();

        Log::channel('mail')->info('Email sent successfully', [
            'to' => $to,
            'subject' => $subject,
        ]);
    }

    /**
     * Record a send failure. Laravel dispatches no failure event, so this is
     * invoked manually from the catch block at the call site (e.g.
     * CustomerInformationController). Logs to the mail channel and alerts admin.
     *
     * @param  array<int, string>|string  $recipients
     */
    public function handleMessageFailed($recipients, ?string $subject, string $error)
    {
        Log::channel('mail')->error('Email failed to send', [
            'to' => $recipients,
            'subject' => $subject,
            'error' => $error,
        ]);

        $this->sendAdminAlert($recipients, $subject, $error);
    }

    /**
     * Send alert to admin when email fails
     * Note: This is called from the failure alert mechanism in your application
     */
    public function sendAdminAlert($recipients, $subject, $error)
    {
        try {
            $adminEmail = env('ADMIN_CC_EMAIL', config('mail.from.address'));

            if (! $adminEmail) {
                Log::warning('ADMIN_CC_EMAIL not configured, cannot send failure alert');

                return;
            }

            // Format recipients for display
            $recipientStr = is_array($recipients) ? implode(', ', $recipients) : $recipients;

            Mail::raw(
                "Email Delivery Failed\n\n".
                "Recipient(s): {$recipientStr}\n".
                "Subject: {$subject}\n".
                "Error: {$error}",
                function ($message) use ($adminEmail) {
                    $message->to($adminEmail)
                        ->subject('⚠️ Email Delivery Failed');
                }
            );

            Log::channel('mail')->info('Admin CC alert sent', [
                'ADMIN_CC_EMAIL' => $adminEmail,
                'recipients' => $recipientStr,
                'error' => $error,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send admin alert email', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Extract recipients from Symfony Email message
     */
    private function getRecipients($message): array
    {
        $recipients = [];

        // Get 'to' recipients
        if (method_exists($message, 'getTo')) {
            $toAddresses = $message->getTo();
            if (is_array($toAddresses)) {
                foreach ($toAddresses as $address) {
                    if (is_string($address)) {
                        $recipients[] = $address;
                    } elseif (is_object($address) && method_exists($address, 'getAddress')) {
                        $recipients[] = $address->getAddress();
                    }
                }
            } elseif (is_string($toAddresses)) {
                $recipients[] = $toAddresses;
            }
        }

        return ! empty($recipients) ? $recipients : ['unknown'];
    }
}
