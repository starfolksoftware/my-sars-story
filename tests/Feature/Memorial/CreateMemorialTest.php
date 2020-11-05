<?php

namespace Tests\Feature\Memorial;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateMemorialTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->setBaseRoute('memorial');
        $this->setBaseModel('App\Models\Memorial\Memorial');
    }
    
    /** @test */
    public function testUserCanCreateMemorial() {
        $this->signIn([
            'create_memorial'
        ]);
        $this->store();
    }

    /** @test */
    public function testUnauthenticatedUserCanNotCreateMemorial() {
        $this->store();
    }

    /** @test */
    public function testUserWithoutPermissionCanNotCreateMemorial() {
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);
        $this->signIn();
        $this->store();
    }

    /** @test */
    public function testMemorialRequiresNameProfessionAndAge() {
        $this->signIn([
            'create_memorial'
        ]);

        $response = $this->postJson(route('memorial.store', 'create'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name',
            'profession',
            'age',
        ]);
    }

    /** @test */
    public function testCreatedMemorialShouldHaveACorrespondingPost() {
        $this->signIn([
            'create_memorial'
        ]);
        $this->store();
        $memorial = \App\Models\Memorial\Memorial::first();
        $this->assertInstanceOf(\App\Models\Blog\Post::class, $memorial->post);
    }
}
