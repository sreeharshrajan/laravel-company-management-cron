<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_companies_list()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $company = Company::create([
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'address' => '123 Main St',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get(route('companies.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Company');
    }

    public function test_user_can_view_companies_list()
    {
        $user = User::factory()->create(['role' => 'user']);
        $company = Company::create([
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'address' => '123 Main St',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get(route('companies.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Company');
    }

    public function test_admin_can_create_company()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->post(route('companies.store'), [
            'name' => 'New Company',
            'email' => 'new@company.com',
            'address' => '456 Elm St',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', ['email' => 'new@company.com']);
    }

    public function test_user_cannot_create_company()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post(route('companies.store'), [
            'name' => 'New Company',
            'email' => 'new@company.com',
            'address' => '456 Elm St',
            'status' => 'active',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('companies', ['email' => 'new@company.com']);
    }

    public function test_admin_can_update_company()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $company = Company::create([
            'name' => 'Old Name',
            'email' => 'old@company.com',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->put(route('companies.update', $company), [
            'name' => 'New Name',
            'email' => 'old@company.com',
            'status' => 'inactive',
        ]);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', ['name' => 'New Name', 'status' => 'inactive']);
    }

    public function test_user_cannot_update_company()
    {
        $user = User::factory()->create(['role' => 'user']);
        $company = Company::create([
            'name' => 'Old Name',
            'email' => 'old@company.com',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->put(route('companies.update', $company), [
            'name' => 'New Name',
            'email' => 'old@company.com',
            'status' => 'inactive',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('companies', ['name' => 'Old Name']);
    }

    public function test_admin_can_delete_company()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $company = Company::create([
            'name' => 'Delete Me',
            'email' => 'delete@company.com',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->delete(route('companies.destroy', $company));

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    public function test_user_cannot_delete_company()
    {
        $user = User::factory()->create(['role' => 'user']);
        $company = Company::create([
            'name' => 'Delete Me',
            'email' => 'delete@company.com',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->delete(route('companies.destroy', $company));

        $response->assertStatus(403);
        $this->assertDatabaseHas('companies', ['id' => $company->id]);
    }
}
