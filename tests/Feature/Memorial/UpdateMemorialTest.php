<?php

namespace Tests\Feature\Memorial;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateMemorialTest extends TestCase
{
    use WithFaker;

    protected $attributes = [];

    public function setUp(): void {
        parent::setUp();

        $this->setBaseRoute('memorial');
        $this->setBaseModel('App\Models\Memorial\Memorial');

        $this->attributes = [
            'name' => $this->faker->name(),
            'profession' => $this->faker->company,
            'age' => $this->faker->randomNumber(),
        ];
    }

    /** @test */
    public function testUserCanUpdateMemorial() {
        $this->signIn([
            'update_memorial',
        ]);

        $this->update($this->attributes);
    }

    /** @test */
    public function testUnauthenticatedUserCanNotUpdateMemorial() {
        $this->update($this->attributes);
    }

    /** @test */
    public function testUserWithoutPermissionCanNotUpdateMemorial() {
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);
        $this->signIn();
        $this->update($this->attributes);
    }

    /** @test */
    public function testMemorialRequiresNameProfessionAndAge() {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->signIn([
            'update_memorial'
        ]);
        $this->update($this->attributes);

        $memorial = \App\Models\Memorial\Memorial::first();

        $this->postJson(route('memorial.store', $memorial->id), [
            'name' => NULL,
            'profession' => NULL,
            'age' => NULL,
        ]);
    }

    /** @test */
    public function testUpdateMemorialShouldHaveACorrespondingPost() {
        $this->signIn([
            'update_memorial'
        ]);
        $this->update($this->attributes);
        $memorial = \App\Models\Memorial\Memorial::first();
        $this->assertInstanceOf(\App\Models\Blog\Post::class, $memorial->post);
    }
}
