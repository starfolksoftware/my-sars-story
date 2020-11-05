<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;
use App\Models\Auth\Permission;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $baseRoute = null;
    protected $baseModel = null;

    protected function signIn(array $permissions = [], $user = null) {
        $user = $user ?? create(\App\Models\Auth\User::class);

        foreach ($permissions as $key => $permission) {
            $user->givePermissionTo(
                Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web'])
            );
        }

        Passport::actingAs(
            $user,
            []
        );
        return $this;
    }

    protected function setBaseRoute($route) {
        $this->baseRoute = $route;
    }

    protected function setBaseModel($model) {
        $this->baseModel = $model;
    }

    protected function store($attributes = [], $model = '', $route = '') {
        $this->withoutExceptionHandling();

        $route = $this->baseRoute ? "{$this->baseRoute}.store" : $route;
        $model = $this->baseModel ?? $model;

        $attributes = raw($model, $attributes);
        
        if (!auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }

        $response = $this->postJson(route($route, 'create'), $attributes)->assertSuccessful();

        $model = new $model;
        $this->assertDatabaseCount($model->getTable(), 1);

        return $response;
    }

    protected function update($attributes = [], $model = '', $route = '') {
        $this->withoutExceptionHandling();

        $route = $this->baseRoute ? "{$this->baseRoute}.update" : $route;
        $model = $this->baseModel ?? $model;

        $model = create($model, $attributes);

        if (!auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }

        $id = $model->id ?? 'create';

        $response = $this->postJson(route($route, $model->id), $model->toArray())->assertSuccessful();

        $model = new $model;

        tap($model->fresh(), function($model) use ($attributes) {
            collect($attributes)->each(function($value, $key) use ($model) {
                $this->assertEquals($value, $model[$key]);
            });
        });

        return $response;
    }

    protected function destroy($model = '', $route = '') {
        $route = $this->baseRoute ? "{$this->baseRoute}.destroy" : $route;
        $model = $this->baseModel ?? $model;

        $model = create($model);

        if (!auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }

        $response = $this->deleteJson(route($route, $model->id));

        $this->assertDatabaseMissing($model->getTable(), $model->toArray());

        return $response;
    }
}
