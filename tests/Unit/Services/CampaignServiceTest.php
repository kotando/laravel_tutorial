<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Eloquents\Shop;
use App\Eloquents\Campaign;
use App\Services\CampaignService;

/**
 * @coversDefaultClass \App\Services\ShopService
 */
class CampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers ::index
     * @covers ::<private>
     */
     public function testIndex()
     {
         factory(Campaign::class, 3)->create();
         $service = new CampaignService;
         $results = $service->index();

         $this->assertCount(3, $results);
     }

     /**
      * @covers ::findOrFail
      * @covers ::<private>
      */
     public function testFindOrFail()
     {
         $campaign = factory(Campaign::class)->create();
         $service = new CampaignService();
         $result = $service->findOrFail($campaign->id);

         $this->assertEquals($campaign->id, $result->id);
         $this->assertEquals($campaign->shop_id, $result->shop_id);
     }

     /**
      * @covers ::create
      * @covers ::<private>
      */
     public function testCreate()
     {
         $shop = factory(Shop::class)->create();
         $campaign = factory(Campaign::class)->create();
         $attributes = [
             'shop_id' => $shop->id,
             'name' => $campaign->name,
             'budget' => $campaign->budget,
             'media' => $campaign->media,
             'begin_at' => $campaign->begin_at,
             'end_at' => $campaign->end_at,
             'description' => $campaign->description,
             'approval_status' => $campaign->approval_status,
             'comment' => $campaign->comment,
         ];

         $service = new CampaignService();
         $result = $service->create($attributes);

         $this->assertEquals($shop->id, $result->shop_id);
         $this->assertDatabaseHas('campaigns', [
             'shop_id'     => $shop->id,
             'name' => $campaign->name,
             'budget' => $campaign->budget,
             'media' => $campaign->media,
             'begin_at' => $campaign->begin_at,
             'end_at' => $campaign->end_at,
             'description' => $campaign->description,
             'approval_status' => $campaign->approval_status,
             'comment' => $campaign->comment,
         ]);
     }

     /**
      * @covers ::update
      * @covers ::<private>
      */
     public function testUpdate()
     {
         $campaign = factory(Campaign::class)->create();

         $shop = factory(Shop::class)->create();
         $attributes = [
             'shop_id' => $shop->id
         ];

         $service = new CampaignService();
         $result = $service->update($campaign, $attributes);

         $this->assertEquals($shop->id, $result->shop_id);
         $this->assertDatabaseHas('campaigns', [
             'id'      => $campaign->id,
             'shop_id' => $shop->id,
         ]);
     }

     /**
      * @covers ::delete
      * @covers ::<private>
      */
     public function testDelete()
     {
         $campaign = factory(Campaign::class)->create();

         $service = new CampaignService();
         $result = $service->delete($campaign);

         $this->assertDatabaseMissing('campaigns', [
             'id' => $campaign->id,
         ]);
     }
 }
