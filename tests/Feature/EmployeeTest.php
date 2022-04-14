<?php

namespace Tests\Feature;

use App\Http\Middleware\AuthenticateApi;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EmployeeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function testGet()
    {
        $this->seed(CompanySeeder::class);
        $this->seed(EmployeeSeeder::class);

        $response = $this->withHeaders($this->getHeaders())
               ->get('/api/v1/employees/');

        $response->assertStatus(200);

        $response = $this->withHeaders($this->getHeaders())
            ->get('/api/v1/empoes', $this->getHeaders());
        $response->assertStatus(404);

        $this->refreshDatabase();
    }

    public function testAdd()
    {

        $response = $this->withHeaders($this->getHeaders())
                    ->post('/api/v1/employees', []);
        $response->assertStatus(422);

        $data = [
            'name' => 'Koko Triks',
            'position' => 'cleaner'
        ];
        $response = $this->withHeaders($this->getHeaders())
                    ->post('/api/v1/employees', $data);
        $response->assertStatus(201);

        $this->refreshDatabase();
    }
    public function testDestroy() {

        $this->seed(CompanySeeder::class);

        $data = [
            'name' => 'Koko Triks',
            'position' => 'cleaner',
            'company_id' => 4,
            'status' =>'outsource'
        ];

        $response = $this->withHeaders($this->getHeaders())
                    ->post('/api/v1/employees', $data);
        $response->assertStatus(201);

        $employee_id = $this->getFirstEmployeelId();

        $response = $this->delete('/api/v1/employees/' . $employee_id);

        $response->assertStatus(204);

        $response = $this->delete('/api/v1/employees/' . $employee_id);

        $response->assertStatus(404);

        $this->refreshDatabase();

    }

    public function testAddCompany()
    {
        $this->seed(CompanySeeder::class);

        $data = [
            'name' => 'Koko Triks',
            'position' => 'cleaner',
        ];

        $response = $this->withHeaders($this->getHeaders())
            ->post('/api/v1/employees', $data);

        $response->assertStatus(201);

        $employee_id = $this->getFirstEmployeelId();

        $data = [
            'company_id' => '5',
            'status' => 'full-time',
        ];
        $response = $this->patch('/api/v1/employees/'. $employee_id.'/add_company', $data );

        $response->assertStatus(200);

    }


    private function getHeaders()
    {
        return ['Accept' => 'application/json', AuthenticateApi::API_KEY_HEADER => config('services.api.token')];
    }

    private function getFirstEmployeelId() {

        $response = $this->get('/api/v1/employees/?limit=1');
        $content = json_decode($response->getContent(), true);

        return $content['data'][0]['employee_id'];
    }
}
