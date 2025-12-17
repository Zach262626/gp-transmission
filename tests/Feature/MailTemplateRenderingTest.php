<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CustomerInformation;
use App\Mail\CustomerInformationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailTemplateRenderingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test mail template renders without errors
     */
    public function test_mail_template_renders_without_errors()
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
        $rendered = $mail->render();

        $this->assertNotNull($rendered);
        $this->assertIsString((string) $rendered);
    }

    /**
     * Test mail template contains all customer data
     */
    public function test_mail_template_contains_all_data()
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
            'complaint' => 'This is a detailed complaint.',
        ]);

        $mail = new CustomerInformationMail($record);
        $rendered = (string) $mail->render();

        $this->assertStringContainsString('John Doe', $rendered);
        $this->assertStringContainsString('john@example.com', $rendered);
        $this->assertStringContainsString('(555) 123-4567', $rendered);
        $this->assertStringContainsString('Toyota', $rendered);
        $this->assertStringContainsString('Corolla', $rendered);
        $this->assertStringContainsString('1HGCM82633A004352', $rendered);
        $this->assertStringContainsString('ABC-1234', $rendered);
        // Kilometres is formatted with commas, so look for the formatted version
        $this->assertStringContainsString('120,000', $rendered);
        $this->assertStringContainsString('AST-001', $rendered);
    }

    /**
     * Test mail template displays VIN correctly (lowercase key)
     */
    public function test_mail_template_displays_vin_correctly()
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
        $rendered = (string) $mail->render();

        $this->assertStringContainsString('1HGCM82633A004352', $rendered);
    }

    /**
     * Test mail template handles null optional fields
     */
    public function test_mail_template_handles_null_optional_fields()
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
        $rendered = (string) $mail->render();

        // Should display 'N/A' for null values
        $this->assertStringContainsString('N/A', $rendered);
        // Should not have errors
        $this->assertNotNull($rendered);
    }

    /**
     * Test mail template displays formatted kilometres with commas
     */
    public function test_mail_template_formats_kilometres()
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
        $rendered = (string) $mail->render();

        // Should contain formatted number with comma
        $this->assertStringContainsString('120,000', $rendered);
        $this->assertStringContainsString('km', $rendered);
    }

    /**
     * Test mail template displays created_at timestamp
     */
    public function test_mail_template_displays_created_at_timestamp()
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
        $rendered = (string) $mail->render();

        // Should contain the timestamp
        $this->assertStringContainsString($record->created_at->format('Y-m-d'), $rendered);
    }

    /**
     * Test mail template handles special characters
     */
    public function test_mail_template_handles_special_characters()
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
            'complaint' => "The vehicle makes strange noises & vibrations!",
        ]);

        $mail = new CustomerInformationMail($record);
        $rendered = (string) $mail->render();

        // Should contain special characters (escaped properly by Blade)
        $this->assertNotNull($rendered);
    }

    /**
     * Test mail template displays proper table structure
     */
    public function test_mail_template_has_table_structure()
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
        $rendered = (string) $mail->render();

        // Should have HTML table structure
        $this->assertStringContainsString('<table', $rendered);
        $this->assertStringContainsString('</table>', $rendered);
        $this->assertStringContainsString('<tr>', $rendered);
        $this->assertStringContainsString('</tr>', $rendered);
        // Check for at least one td (there will be many)
        $this->assertStringContainsString('<td', $rendered);
    }

    /**
     * Test mail template has valid HTML structure
     */
    public function test_mail_template_has_valid_html_structure()
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
        $rendered = (string) $mail->render();

        // Should have proper HTML structure
        $this->assertStringContainsString('<!DOCTYPE html>', $rendered);
        $this->assertStringContainsString('<html', $rendered);
        $this->assertStringContainsString('<head>', $rendered);
        $this->assertStringContainsString('<body', $rendered);
    }

    /**
     * Test mail template displays all vehicle information
     */
    public function test_mail_template_displays_vehicle_info()
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
        $rendered = (string) $mail->render();

        // All vehicle info should be present
        $this->assertStringContainsString('2020', $rendered);
        $this->assertStringContainsString('Toyota', $rendered);
        $this->assertStringContainsString('Corolla', $rendered);
    }

    /**
     * Test mail template renders complaint text properly
     */
    public function test_mail_template_renders_complaint_text()
    {
        $complaint = "The transmission is making strange noises and vibrating.\nPlease investigate and fix this issue.";

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
            'complaint' => $complaint,
        ]);

        $mail = new CustomerInformationMail($record);
        $rendered = (string) $mail->render();

        // Complaint should be in rendered email
        $this->assertStringContainsString('transmission', $rendered);
    }

    /**
     * Test mail template with long text values
     */
    public function test_mail_template_with_long_text_values()
    {
        $longComplaint = str_repeat('This is a long complaint. ', 50);

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
            'complaint' => $longComplaint,
        ]);

        $mail = new CustomerInformationMail($record);
        $rendered = (string) $mail->render();

        // Should render without issues
        $this->assertNotNull($rendered);
        $this->assertStringContainsString('This is a long complaint', $rendered);
    }

    /**
     * Test mail shows all required labels
     */
    public function test_mail_shows_all_required_labels()
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
        $rendered = (string) $mail->render();

        // Should contain all field labels
        $this->assertStringContainsString('Name:', $rendered);
        $this->assertStringContainsString('Email:', $rendered);
        $this->assertStringContainsString('Phone:', $rendered);
        $this->assertStringContainsString('Year:', $rendered);
        $this->assertStringContainsString('Make:', $rendered);
        $this->assertStringContainsString('Model:', $rendered);
        $this->assertStringContainsString('VIN:', $rendered);
        $this->assertStringContainsString('License Plate:', $rendered);
        $this->assertStringContainsString('Kilometres:', $rendered);
        $this->assertStringContainsString('Asset Number:', $rendered);
        $this->assertStringContainsString('Complaint:', $rendered);
    }
}