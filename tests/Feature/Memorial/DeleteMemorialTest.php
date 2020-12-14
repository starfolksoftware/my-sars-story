<?php

namespace Tests\Feature\Memorial;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteMemorialTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->setBaseRoute('memorial');
        $this->setBaseModel('App\Models\Memorial\Memorial');
    }

    /** @test */
    public function testUserCanDeleteMemorial() {
        $this->signIn([
            'delete_memorial'
        ]);
        $this->destroy()->assertStatus(204);
    }

    /** @test */
    public function testUnauthenticatedUserCanNotDeleteMemorial() {
        $this->destroy()->assertStatus(401);
    }

    /** @test */
    public function testUserWithoutPermissionCanNotDeleteMemorial() {
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);
        $this->signIn();
        $this->destroy()->assertStatus(403);
    }

    /** @test */
    public function testDeletedMemorialShouldNotHaveACorrespondingPost() {
        $this->signIn([
            'delete_memorial'
        ]);
        $this->destroy();
        $this->assertEquals(0, \App\Models\Blog\Post::all()->count());
    }
}
