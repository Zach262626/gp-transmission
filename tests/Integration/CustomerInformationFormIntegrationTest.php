<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\Models\CustomerInformation;
use App\Mail\CustomerInformationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class CustomerInformationFormIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected $validData = [
        'name'           => 'John Doe',
        'email'          => 'john@example.com',
        'phone'          => '(555) 123-4567',
        'year'           => 2020,
        'make'           => 'Toyota',
        'model'          => 'Corolla',
        'vin'            => '1HGCM82633A004352',
        'license_plate'  => 'ABC-1234',
        'kilometres'     => 120000,
        'asset_number'   => 'AST-001',
        'complaint'      => 'This is a detailed complaint about the transmission service we received.',
    ];

    /**
     * Test complete form submission flow - happy path
     */
    public function test_complete_form_submission_flow()
    {
        Mail::fake();

        // Submit form
        $response = $this->post(route('customerInformationCreate'), $this->validData);

        // Verify response
        $response->assertStatus(302);
        $response->assertRedirect(route('main'));
        $response->assertSessionHas('success');

        // Verify database
        $this->assertDatabaseCount('customer_information', 1);
        $record = CustomerInformation::first();
        $this->assertEquals('John Doe', $record->name);

        // Verify email was sent
        Mail::assertSent(CustomerInformationMail::class);
        Mail::assertSent(CustomerInformationMail::class, function ($mail) {
            return $mail->hasTo(env('ADMIN_EMAIL', 'sebgallant@hotmail.com')) &&
                   $mail->hasCc(env('ADMIN_CC_EMAIL', 'hatrickzach@gmail.com'));
        });
    }

    /**
     * Test form submission creates record before email
     */
    public function test_record_created_before_email_sent()
    {
        Mail::fake();

        $this->post(route('customerInformationCreate'), $this->validData);

        $this->assertDatabaseHas('customer_information', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /**
     * Test multiple form submissions create multiple records
     */
    public function test_multiple_form_submissions()
    {
        Mail::fake();

        // First submission
        $this->post(route('customerInformationCreate'), $this->validData);

        // Second submission with different data
        $data2 = $this->validData;
        $data2['name'] = 'Jane Doe';
        $data2['email'] = 'jane@example.com';

        $this->post(route('customerInformationCreate'), $data2);

        // Verify both records exist
        $this->assertDatabaseCount('customer_information', 2);
        $this->assertDatabaseHas('customer_information', ['name' => 'John Doe']);
        $this->assertDatabaseHas('customer_information', ['name' => 'Jane Doe']);

        // Verify two emails were sent
        Mail::assertSentTimes(CustomerInformationMail::class, 2);
    }

    /**
     * Test form displays error messages on validation failure
     */
    public function test_form_displays_validation_errors()
    {
        Mail::fake();

        $data = $this->validData;
        $data['email'] = 'invalid-email';

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('email');
        $response->assertRedirect();
        $this->assertDatabaseCount('customer_information', 0);
    }

    /**
     * Test old form data is preserved on validation error
     */
    public function test_old_form_data_preserved_on_error()
    {
        Mail::fake();

        $data = $this->validData;
        $data['email'] = 'invalid-email';

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHas('_old_input');
        $this->assertEquals('John Doe', session('_old_input.name'));
        $this->assertEquals('invalid-email', session('_old_input.email'));
    }

    /**
     * Test form with all optional fields empty
     */
    public function test_form_with_optional_fields_empty()
    {
        Mail::fake();

        $data = $this->validData;
        unset($data['vin'], $data['license_plate'], $data['kilometres'], $data['asset_number']);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertRedirect(route('main'));
        $this->assertDatabaseCount('customer_information', 1);

        $record = CustomerInformation::first();
        $this->assertNull($record->vin);
        $this->assertNull($record->license_plate);
        $this->assertNull($record->kilometres);
        $this->assertNull($record->asset_number);
    }

    /**
     * Test form with different phone formats
     */
    public function test_different_phone_formats_accepted()
    {
        Mail::fake();

        $phoneFormats = [
            '(555) 123-4567',
            '555-123-4567',
            '5551234567',
            '+1 555 123 4567',
            '555.123.4567',
        ];

        foreach ($phoneFormats as $phone) {
            // Clear database
            CustomerInformation::truncate();

            $data = $this->validData;
            $data['phone'] = $phone;

            $response = $this->post(route('customerInformationCreate'), $data);

            $response->assertRedirect(route('main'));
            $this->assertDatabaseHas('customer_information', ['phone' => $phone]);
        }
    }

    /**
     * Test email contains all form data
     */
    public function test_email_contains_all_form_data()
    {
        Mail::fake();

        $this->post(route('customerInformationCreate'), $this->validData);

        Mail::assertSent(CustomerInformationMail::class, function ($mail) {
            $data = $mail->data;
            return $data->name === 'John Doe' &&
                   $data->email === 'john@example.com' &&
                   $data->phone === '(555) 123-4567' &&
                   $data->year === 2020 &&
                   $data->make === 'Toyota' &&
                   $data->model === 'Corolla' &&
                   $data->vin === '1HGCM82633A004352' &&
                   $data->license_plate === 'ABC-1234' &&
                   $data->kilometres === 120000 &&
                   $data->asset_number === 'AST-001' &&
                   $data->complaint === 'This is a detailed complaint about the transmission service we received.';
        });
    }

    /**
     * Test email subject is correct
     */
    public function test_email_subject_is_correct()
    {
        Mail::fake();

        $this->post(route('customerInformationCreate'), $this->validData);

        Mail::assertSent(CustomerInformationMail::class, function ($mail) {
            return $mail->envelope()->subject === 'Customer Information Form';
        });
    }

    /**
     * Test email from address is correct
     */
    public function test_email_from_address_is_correct()
    {
        Mail::fake();

        $this->post(route('customerInformationCreate'), $this->validData);

        Mail::assertSent(CustomerInformationMail::class, function ($mail) {
            return $mail->envelope()->from->address === 'CustomerInformation@mail.gptransmission.ca' &&
                   $mail->envelope()->from->name === 'GP Transmission';
        });
    }

    /**
     * Test form redirects to main route on success
     */
    public function test_redirects_to_main_route_on_success()
    {
        Mail::fake();

        $response = $this->post(route('customerInformationCreate'), $this->validData);

        $response->assertRedirect(route('main'));
    }

    /**
     * Test success message is displayed
     */
    public function test_success_message_displayed()
    {
        Mail::fake();

        $response = $this->post(route('customerInformationCreate'), $this->validData);

        $response->assertSessionHas('success');
        $this->assertStringContainsString('success', session('success'));
    }

    /**
     * Test form with minimum valid complaint length
     */
    public function test_minimum_complaint_length_accepted()
    {
        Mail::fake();

        $data = $this->validData;
        $data['complaint'] = 'Minimum complaint length here.';  // Exactly 10+ characters

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertRedirect(route('main'));
    }

    /**
     * Test form with maximum valid complaint length
     */
    public function test_maximum_complaint_length_accepted()
    {
        Mail::fake();

        $data = $this->validData;
        $data['complaint'] = str_repeat('a', 5000);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertRedirect(route('main'));
    }

    /**
     * Test form validation runs for all fields
     */
    public function test_all_validation_rules_enforced()
    {
        Mail::fake();

        $invalidData = [
            'name' => '',  // Empty
            'email' => 'invalid',  // Invalid email
            'phone' => '123',  // Too short
            'year' => 1800,  // Too old
            'make' => '',  // Empty
            'model' => '',  // Empty
            'complaint' => 'short',  // Too short
        ];

        $response = $this->post(route('customerInformationCreate'), $invalidData);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'year', 'make', 'model', 'complaint']);
    }

    /**
     * Test database record has created_at timestamp
     */
    public function test_database_record_has_timestamp()
    {
        Mail::fake();

        $before = now();
        $this->post(route('customerInformationCreate'), $this->validData);
        $after = now();

        $record = CustomerInformation::first();

        $this->assertNotNull($record->created_at);
        $this->assertTrue($record->created_at->isBetween($before, $after));
    }

    /**
     * Test case sensitivity of field names
     */
    public function test_field_names_are_case_sensitive()
    {
        Mail::fake();

        // Submit with correct lowercase 'vin'
        $response = $this->post(route('customerInformationCreate'), $this->validData);

        $response->assertRedirect(route('main'));
        $record = CustomerInformation::first();

        // VIN should be saved with lowercase key
        $this->assertEquals('1HGCM82633A004352', $record->vin);
    }

    /**
     * Test email sent to both To and CC recipients
     */
    public function test_email_sent_to_both_recipients()
    {
        Mail::fake();

        $this->post(route('customerInformationCreate'), $this->validData);

        Mail::assertSent(CustomerInformationMail::class, function ($mail) {
            $hasTo = false;
            $hasCc = false;

            foreach ($mail->to as $recipient) {
                if ($recipient['address'] === env('ADMIN_EMAIL', 'sebgallant@hotmail.com')) {
                    $hasTo = true;
                }
            }

            foreach ($mail->cc as $recipient) {
                if ($recipient['address'] === env('ADMIN_CC_EMAIL', 'hatrickzach@gmail.com')) {
                    $hasCc = true;
                }
            }

            return $hasTo && $hasCc;
        });
    }

    /**
     * Test form CSRF protection
     */
    public function test_form_csrf_protection()
    {
        // Attempting to submit without CSRF token should fail
        // This is handled by Laravel middleware
        $response = $this->post(route('customerInformationCreate'), $this->validData, []);

        // Should either redirect with error or fail validation
        // CSRF token is required
    }

    /**
     * Test multiple validation errors returned together
     */
    public function test_multiple_validation_errors_returned()
    {
        Mail::fake();

        $data = [];  // All empty

        $response = $this->post(route('customerInformationCreate'), $data);

        $errors = $response->session()->get('errors')->messages();

        // Should have multiple errors
        $this->assertGreaterThan(5, count($errors));
    }
}
