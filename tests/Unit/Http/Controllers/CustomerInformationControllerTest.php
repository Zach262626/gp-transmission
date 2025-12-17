<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\CustomerInformation;
use App\Mail\CustomerInformationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class CustomerInformationControllerTest extends TestCase
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
     * Test successful form submission with all fields
     */
    public function test_successful_form_submission_with_all_fields()
    {
        Mail::fake();

        $response = $this->post(route('customerInformationCreate'), $this->validData);

        $response->assertRedirect(route('main'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('customer_information', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '(555) 123-4567',
        ]);

        Mail::assertSent(CustomerInformationMail::class);
    }

    /**
     * Test successful form submission with optional fields missing
     */
    public function test_successful_form_submission_with_optional_fields_missing()
    {
        Mail::fake();

        $data = $this->validData;
        unset($data['vin'], $data['license_plate'], $data['kilometres'], $data['asset_number']);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertRedirect(route('main'));

        $this->assertDatabaseHas('customer_information', [
            'name' => 'John Doe',
            'vin' => null,
            'license_plate' => null,
        ]);
    }

    /**
     * Test formatted phone number is accepted
     */
    public function test_formatted_phone_number_accepted()
    {
        Mail::fake();

        $data = $this->validData;
        $data['phone'] = '(555) 123-4567';

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertRedirect(route('main'));
        $this->assertDatabaseHas('customer_information', [
            'phone' => '(555) 123-4567'
        ]);
    }

    /**
     * Test unformatted phone number is accepted
     */
    public function test_unformatted_phone_number_accepted()
    {
        Mail::fake();

        $data = $this->validData;
        $data['phone'] = '5551234567';

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertRedirect(route('main'));
        $this->assertDatabaseHas('customer_information', [
            'phone' => '5551234567'
        ]);
    }

    /**
     * Test alphanumeric asset number is accepted
     */
    public function test_alphanumeric_asset_number_accepted()
    {
        Mail::fake();

        $data = $this->validData;
        $data['asset_number'] = 'ABC-123-XYZ';

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertRedirect(route('main'));
        $this->assertDatabaseHas('customer_information', [
            'asset_number' => 'ABC-123-XYZ'
        ]);
    }

    /**
     * Test email is sent to correct recipients
     */
    public function test_email_sent_to_correct_recipients()
    {
        Mail::fake();

        $this->post(route('customerInformationCreate'), $this->validData);

        Mail::assertSent(CustomerInformationMail::class, function ($mail) {
            return $mail->hasTo(env('ADMIN_EMAIL', 'sebgallant@hotmail.com')) &&
                   $mail->hasCc(env('ADMIN_CC_EMAIL', 'hatrickzach@gmail.com'));
        });
    }

    /**
     * Test email contains correct data
     */
    public function test_email_contains_correct_data()
    {
        Mail::fake();

        $this->post(route('customerInformationCreate'), $this->validData);

        Mail::assertSent(CustomerInformationMail::class, function ($mail) {
            return $mail->data['name'] === 'John Doe' &&
                   $mail->data['email'] === 'john@example.com' &&
                   $mail->data['vin'] === '1HGCM82633A004352';
        });
    }

    // ========================
    // VALIDATION TESTS
    // ========================

    /**
     * Test missing required name field
     */
    public function test_validation_fails_without_name()
    {
        Mail::fake();

        $data = $this->validData;
        unset($data['name']);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('customer_information', 0);
    }

    /**
     * Test missing required email field
     */
    public function test_validation_fails_without_email()
    {
        Mail::fake();

        $data = $this->validData;
        unset($data['email']);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('customer_information', 0);
    }

    /**
     * Test invalid email format rejected
     */
    public function test_validation_fails_with_invalid_email()
    {
        Mail::fake();

        $data = $this->validData;
        $data['email'] = 'not-an-email';

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('customer_information', 0);
    }

    /**
     * Test missing required phone field
     */
    public function test_validation_fails_without_phone()
    {
        Mail::fake();

        $data = $this->validData;
        unset($data['phone']);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('phone');
        $this->assertDatabaseCount('customer_information', 0);
    }

    /**
     * Test phone number too short
     */
    public function test_validation_fails_with_short_phone()
    {
        Mail::fake();

        $data = $this->validData;
        $data['phone'] = '123';

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('phone');
    }

    /**
     * Test phone number too long
     */
    public function test_validation_fails_with_long_phone()
    {
        Mail::fake();

        $data = $this->validData;
        $data['phone'] = str_repeat('1', 21);  // 21 characters

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('phone');
    }

    /**
     * Test missing required year field
     */
    public function test_validation_fails_without_year()
    {
        Mail::fake();

        $data = $this->validData;
        unset($data['year']);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('year');
    }

    /**
     * Test invalid year (too old)
     */
    public function test_validation_fails_with_year_too_old()
    {
        Mail::fake();

        $data = $this->validData;
        $data['year'] = 1800;

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('year');
    }

    /**
     * Test invalid year (too new)
     */
    public function test_validation_fails_with_year_too_new()
    {
        Mail::fake();

        $data = $this->validData;
        $data['year'] = 2200;

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('year');
    }

    /**
     * Test missing required make field
     */
    public function test_validation_fails_without_make()
    {
        Mail::fake();

        $data = $this->validData;
        unset($data['make']);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('make');
    }

    /**
     * Test missing required model field
     */
    public function test_validation_fails_without_model()
    {
        Mail::fake();

        $data = $this->validData;
        unset($data['model']);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('model');
    }

    /**
     * Test missing required complaint field
     */
    public function test_validation_fails_without_complaint()
    {
        Mail::fake();

        $data = $this->validData;
        unset($data['complaint']);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('complaint');
    }

    /**
     * Test complaint too short
     */
    public function test_validation_fails_with_short_complaint()
    {
        Mail::fake();

        $data = $this->validData;
        $data['complaint'] = 'Too short';

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('complaint');
    }

    /**
     * Test complaint too long
     */
    public function test_validation_fails_with_long_complaint()
    {
        Mail::fake();

        $data = $this->validData;
        $data['complaint'] = str_repeat('a', 5001);  // 5001 characters

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('complaint');
    }

    /**
     * Test name too long
     */
    public function test_validation_fails_with_long_name()
    {
        Mail::fake();

        $data = $this->validData;
        $data['name'] = str_repeat('a', 256);

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test VIN too long
     */
    public function test_validation_fails_with_long_vin()
    {
        Mail::fake();

        $data = $this->validData;
        $data['vin'] = str_repeat('a', 18);  // VIN max is 17

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('vin');
    }

    /**
     * Test license plate too long
     */
    public function test_validation_fails_with_long_license_plate()
    {
        Mail::fake();

        $data = $this->validData;
        $data['license_plate'] = str_repeat('a', 11);  // Max is 10

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('license_plate');
    }

    /**
     * Test kilometres must be positive
     */
    public function test_validation_fails_with_negative_kilometres()
    {
        Mail::fake();

        $data = $this->validData;
        $data['kilometres'] = -100;

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('kilometres');
    }

    /**
     * Test asset number too long
     */
    public function test_validation_fails_with_long_asset_number()
    {
        Mail::fake();

        $data = $this->validData;
        $data['asset_number'] = str_repeat('a', 51);  // Max is 50

        $response = $this->post(route('customerInformationCreate'), $data);

        $response->assertSessionHasErrors('asset_number');
    }

    // ========================
    // DATA PERSISTENCE TESTS
    // ========================

    /**
     * Test all fields are saved to database
     */
    public function test_all_fields_saved_to_database()
    {
        Mail::fake();

        $this->post(route('customerInformationCreate'), $this->validData);

        $this->assertDatabaseHas('customer_information', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '(555) 123-4567',
            'year' => 2020,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'vin' => '1HGCM82633A004352',
            'license_plate' => 'ABC-1234',
            'kilometres' => 120000,
            'asset_number' => 'AST-001',
            'complaint' => 'This is a detailed complaint about the transmission service we received.',
        ]);
    }

    /**
     * Test created_at timestamp is automatically set
     */
    public function test_created_at_timestamp_automatically_set()
    {
        Mail::fake();

        $this->post(route('customerInformationCreate'), $this->validData);

        $record = CustomerInformation::where('name', 'John Doe')->first();

        $this->assertNotNull($record->created_at);
        $this->assertFalse($record->created_at->isFuture());
    }
}