<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyDetailFormTest extends TestCase
{
    use RefreshDatabase;

    public function testFormRendersSuccessfully(): void
    {
        // get form with the url
        $response = $this->get('/');

        // Assert the response status
        $response->assertStatus(200);

        // Assert that the form view is rendered
        $response->assertViewIs('company.create');
    }

    public function testFormStoresDataAndRendersViewWithResultDataUponSuccessfulSubmission(): void
    {
        $formData = [
            'symbol' => 'GOOG',
            'email' => 'abc@test.email',
            'start_date' => '2023-6-11',
            'end_date' => '2023-6-21',
        ];

        // Submit the form with the given data
        $response = $this->post('/', $formData);

        // Assert the response status
        $response->assertStatus(200);

        // Assert that the data was saved in the database
        $this->assertDatabaseHas('company_details', $formData);

        // Assert that the view is rendered after successful form submission
        $response->assertViewIs('company.history');

        // Assert that the view contains the data returned from the controller
        $responseData = $response->viewData('filteredHistoryData');
        $this->assertIsArray($responseData);
        $this->assertNotEmpty($responseData);
    }
}
