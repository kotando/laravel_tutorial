<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Eloquents\User;
use App\Eloquents\Shop;
use App\Services\ShopService;

/**
 * @coversDefaultClass \App\Services\ShopService
 */
class ShopTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers ::index
     * @covers ::<private>
     */
     public function testIndex()
     {
         factory(Shop::class, 3)->create();
         $service = new ShopService;
         $results = $service->index();

         $this->assertCount(3, $results);
     }

     /**
      * @covers ::findOrFail
      * @covers ::<private>
      */
     public function testFindOrFail()
     {
         $shop = factory(Shop::class)->create();
         $service = new ShopService();
         $result = $service->findOrFail($shop->id);

         $this->assertEquals($shop->user_id, $result->user_id);
     }

     /**
      * @covers ::create
      * @covers ::<private>
      */
     public function testCreate()
     {
         $user = factory(User::class)->create();
         $attributes = [
             'user_id' => $user->id,
         ];

         $service = new ShopService();
         $result = $service->create($attributes);

         $this->assertEquals($user->id, $result->user_id);
         $this->assertDatabaseHas('shops', [
             'user_id'     => $user->id,
         ]);
     }

     /**
      * @covers ::update
      * @covers ::<private>
      */
     public function testUpdate()
     {
         $shop = factory(Shop::class)->create();

         $user = factory(User::class)->create();
         $attributes = [
             'user_id' => $user->id
         ];

         $service = new ShopService();
         $result = $service->update($shop, $attributes);

         $this->assertEquals($user->id, $result->user_id);
         $this->assertDatabaseHas('shops', [
             'id'      => $shop->id,
             'user_id' => $user->id,
         ]);
     }

     /**
      * @covers ::delete
      * @covers ::<private>
      */
     public function testDelete()
     {
         $shop = factory(Shop::class)->create();

         $service = new ShopService();
         $result = $service->delete($shop);

         $this->assertDatabaseMissing('shops', [
             'id' => $shop->id,
         ]);
     }
 }
