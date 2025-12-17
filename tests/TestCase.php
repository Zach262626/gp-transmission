<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Valid customer information data for testing
     */
    protected function validCustomerData(): array
    {
        return [
            'name'           => 'John Doe',
            'email'          => 'john.doe@example.com',
            'phone'          => '(555) 123-4567',
            'year'           => 2020,
            'make'           => 'Toyota',
            'model'          => 'Corolla',
            'vin'            => '1HGCM82633A004352',
            'license_plate'  => 'ABC-1234',
            'kilometres'     => 120000,
            'asset_number'   => 'AST-001',
            'complaint'      => 'This is a detailed complaint about the transmission service.',
        ];
    }

    /**
     * Get minimal valid customer data (only required fields)
     */
    protected function minimalCustomerData(): array
    {
        return [
            'name'      => 'Jane Smith',
            'email'     => 'jane@example.com',
            'phone'     => '555-987-6543',
            'year'      => 2021,
            'make'      => 'Honda',
            'model'     => 'Civic',
            'complaint' => 'Vehicle has transmission issues that need immediate attention.',
        ];
    }

    /**
     * Create a customer information record
     */
    protected function createCustomer(array $attributes = [])
    {
        return \App\Models\CustomerInformation::create(
            array_merge($this->validCustomerData(), $attributes)
        );
    }
}