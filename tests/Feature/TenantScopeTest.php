 <?php

    use App\Models\Tenant;
    use App\Models\User;
    use Illuminate\Support\Facades\File;
    use Illuminate\Foundation\Testing\RefreshDatabase;

    describe('a model has a tenant id on the migration', function () {

        it('should create a migration file with tenant id', function () {
            $this->artisan('make:model Test -m');
            $filename = File::glob(database_path('migrations/*_create_tests_table.php'))[0];

            $this->assertTrue(File::exists($filename));
            $this->assertStringContainsString(
                '$table->unsignedBigInteger(\'tenant_id\');',
                File::get($filename)
            );
            File::delete($filename);
            File::delete(app_path('Models/Test.php'));
        });
    });

    describe('a user can only see users in the same tenant', function () {
        uses(RefreshDatabase::class);
        it('should create users into separate tenants and count users in is own tenant', function () {

            $tenant1 = Tenant::factory()->create();
            $tenant2 = Tenant::factory()->create();
            $user1 = User::factory()->create([
                'tenant_id' => $tenant1,
            ]);

            User::factory(9)->create([
                'tenant_id' => $tenant1
            ]);

            User::factory(10)->create([
                'tenant_id' => $tenant2
            ]);

            auth()->login($user1);

            $this->assertEquals(10, User::count());
        });
    });

    describe('a user can only create another user in his tenant', function () {
        uses(RefreshDatabase::class);
        it('', function () {
            $tenant1 = Tenant::factory()->create();
            $tenant2 = Tenant::factory()->create();
            $user1 = User::factory()->create([
                'tenant_id' => $tenant1,
            ]);

            auth()->login($user1);

            $createdUser = User::factory()->create();

            $this->assertTrue($createdUser->tenant_id == $user1->tenant_id);
        });
    });
