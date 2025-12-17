<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Models\CustomerInformation;
use App\Mail\CustomerInformationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerInformationMailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test mail has correct subject
     */
    public function test_mail_has_correct_subject()
    {
        $record = CustomerInformation::create([
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
            'complaint' => 'This is a complaint.',
        ]);

        $mail = new CustomerInformationMail($record);

        $this->assertEquals('Customer Information Form', $mail->envelope()->subject);
    }

    /**
     * Test mail has correct from address
     */
    public function test_mail_has_correct_from_address()
    {
        $record = CustomerInformation::create([
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
            'complaint' => 'This is a complaint.',
        ]);

        $mail = new CustomerInformationMail($record);
        $envelope = $mail->envelope();

        $this->assertEquals('CustomerInformation@mail.gptransmission.ca', $envelope->from->address);
        $this->assertEquals('GP Transmission', $envelope->from->name);
    }

    /**
     * Test mail uses correct view
     */
    public function test_mail_uses_correct_view()
    {
        $record = CustomerInformation::create([
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
            'complaint' => 'This is a complaint.',
        ]);

        $mail = new CustomerInformationMail($record);
        $content = $mail->content();

        $this->assertEquals('mail.customer_information', $content->view);
    }

    /**
     * Test mail has no attachments
     */
    public function test_mail_has_no_attachments()
    {
        $record = CustomerInformation::create([
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
            'complaint' => 'This is a complaint.',
        ]);

        $mail = new CustomerInformationMail($record);
        $attachments = $mail->attachments();

        $this->assertIsArray($attachments);
        $this->assertCount(0, $attachments);
    }

    /**
     * Test mail contains customer data
     */
    public function test_mail_contains_customer_data()
    {
        $record = CustomerInformation::create([
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
            'complaint' => 'This is a complaint.',
        ]);

        $mail = new CustomerInformationMail($record);

        $this->assertEquals($record, $mail->data);
    }

    /**
     * Test mail renders without errors
     */
    public function test_mail_renders_without_errors()
    {
        $record = CustomerInformation::create([
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
            'complaint' => 'This is a complaint.',
        ]);

        $mail = new CustomerInformationMail($record);

        // Should not throw an exception
        $this->assertNotNull($mail);
    }

    /**
     * Test mail with optional fields as null
     */
    public function test_mail_with_optional_fields_null()
    {
        $record = CustomerInformation::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '(555) 123-4567',
            'year' => 2020,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'vin' => null,
            'license_plate' => null,
            'kilometres' => null,
            'asset_number' => null,
            'complaint' => 'This is a complaint.',
        ]);

        $mail = new CustomerInformationMail($record);

        $this->assertNull($mail->data->vin);
        $this->assertNull($mail->data->license_plate);
        $this->assertNull($mail->data->kilometres);
        $this->assertNull($mail->data->asset_number);
    }

    /**
     * Test mail with special characters
     */
    public function test_mail_with_special_characters()
    {
        $record = CustomerInformation::create([
            'name' => "Jean-Pierre D'Amélie",
            'email' => 'john@example.com',
            'phone' => '(555) 123-4567',
            'year' => 2020,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'vin' => '1HGCM82633A004352',
            'license_plate' => 'ABC-1234',
            'kilometres' => 120000,
            'asset_number' => 'AST-001!@#',
            'complaint' => "The vehicle is making strange noises & vibrations!",
        ]);

        $mail = new CustomerInformationMail($record);

        $this->assertEquals("Jean-Pierre D'Amélie", $mail->data->name);
        $this->assertStringContainsString('&', $mail->data->complaint);
    }

    /**
     * Test mail subject contains expected text
     */
    public function test_mail_subject_is_meaningful()
    {
        $record = CustomerInformation::create([
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
            'complaint' => 'This is a complaint.',
        ]);

        $mail = new CustomerInformationMail($record);
        $subject = $mail->envelope()->subject;

        $this->assertStringContainsString('Customer', $subject);
        $this->assertStringContainsString('Information', $subject);
    }

    /**
     * Test mail from address is valid
     */
    public function test_mail_from_address_is_valid()
    {
        $record = CustomerInformation::create([
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
            'complaint' => 'This is a complaint.',
        ]);

        $mail = new CustomerInformationMail($record);
        $from = $mail->envelope()->from->address;

        $this->assertStringContainsString('@', $from);
        $this->assertStringContainsString('.', $from);
    }

    /**
     * Test mail preserves data types
     */
    public function test_mail_preserves_data_types()
    {
        $record = CustomerInformation::create([
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
            'complaint' => 'This is a complaint.',
        ]);

        $mail = new CustomerInformationMail($record);

        $this->assertIsString($mail->data->name);
        $this->assertIsString($mail->data->email);
        $this->assertIsString($mail->data->phone);
        $this->assertIsInt($mail->data->year);
        $this->assertIsInt($mail->data->kilometres);
    }
}
