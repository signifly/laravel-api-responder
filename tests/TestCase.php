<?php

namespace R4nkt\Responder\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use R4nkt\Responder\ResponderServiceProvider;
use R4nkt\Responder\Tests\Models\Product;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('app.key', 'base64:9e0yNQB60wgU/cqbP09uphPo3aglW3iQJy+u4JQgnQE=');

        $app['config']->set('responder.namespace', 'R4nkt\\Responder\\Tests\\Resources');
    }

    protected function getPackageProviders($app)
    {
        return [
            ResponderServiceProvider::class,
        ];
    }

    protected function setUpDatabase(): void
    {
        $this->createProductsTable();
        $this->seedProductsTable();
    }

    protected function createProductsTable(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });
    }

    protected function seedProductsTable(): void
    {
        foreach (range(1, 10) as $index) {
            Product::create([
                'name' => "name {$index}",
                'description' => "description {$index}",
            ]);
        }
    }
}
