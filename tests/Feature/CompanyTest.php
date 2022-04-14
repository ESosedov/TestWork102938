<?php

namespace Tests\Feature;

use App\Http\Middleware\AuthenticateApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function testAdd()
    {

        $response = $this->withHeaders($this->getHeaders())
            ->post('/api/v1/companies', []);
        $response->assertStatus(422);

        $data = [
            'name' => 'Micky and sons'
        ];
        $response = $this->withHeaders($this->getHeaders())
            ->post('/api/v1/companies', $data);
        $response->assertStatus(201);

        $this->refreshDatabase();
    }

    public function testDestroy() {

        $this->refreshDatabase();

        $data = [
            'name' => 'Micky and sons',
        ];

        $response = $this->withHeaders($this->getHeaders())
            ->post('/api/v1/companies', $data);
        $response->assertStatus(201);

        $company_id = $this->getFirstCompanylId();

        $response = $this->delete('/api/v1/companies/' . $company_id);

        $response->assertStatus(204);

        $response = $this->delete('/api/v1/companies/' . $company_id);

        $response->assertStatus(404);

        $this->refreshDatabase();

    }

    private function getHeaders()
    {
        return ['Accept' => 'application/json', AuthenticateApi::API_KEY_HEADER => config('services.api.token')];
    }

    private function getFirstCompanylId() {

        $response = $this->get('/api/v1/companies?limit=1');
        $content = json_decode($response->getContent(), true);

        return $content['data'][0]['company_id'];
    }

}
