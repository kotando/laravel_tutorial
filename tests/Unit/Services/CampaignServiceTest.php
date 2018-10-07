<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Eloquents\Shop;
use App\Eloquents\Campaign;
use App\Services\CampaignService;
use Carbon\Carbon;
/**
 * @coversDefaultClass \App\Services\CampaignService
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
         $beginAt = Carbon::today();
         $endAt = Carbon::tomorrow();
         $attributes = [
             'shop_id' => $shop->id,
             'name' => 'testName',
             'budget' => '12345',
             'media' => '1',
             'begin_at' =>  $beginAt,
             'end_at' => $endAt,
             'description' => 'testDescription',
             'approval_status' => '1',
             'comment' => 'testComment',
         ];

         $service = new CampaignService();
         $result = $service->create($attributes);

         $this->assertEquals($shop->id, $result->shop_id);
         $this->assertDatabaseHas('campaigns', [
             'shop_id' => $shop->id,
             'name' => 'testName',
             'budget' => '12345',
             'media' => '1',
             'begin_at' =>  $beginAt,
             'end_at' => $endAt,
             'description' => 'testDescription',
             'approval_status' => '1',
             'comment' => 'testComment',
         ]);
     }

     /**
      * @covers ::update
      * @covers ::<private>
      */
     public function testUpdate()
     {
         $campaign = factory(Campaign::class)->create();
         $beginAt = Carbon::yesterday();
         $endAt = Carbon::today();
         $shop = factory(Shop::class)->create();
         $attributes = [
             'shop_id' => $shop->id,
             'name' => 'testUpdateName',
             'budget' => '6789',
             'media' => '3',
             'begin_at' =>  $beginAt,
             'end_at' => $endAt,
             'description' => 'testUpdateDescription',
             'approval_status' => '3',
             'comment' => 'testUpdateComment',
         ];

         $service = new CampaignService();
         $result = $service->update($campaign, $attributes);

         $this->assertEquals($shop->id, $result->shop_id);
         $this->assertEquals($campaign->id, $result->id);
         $this->assertDatabaseHas('campaigns', [
           'shop_id' => $shop->id,
           'name' => 'testUpdateName',
           'budget' => '6789',
           'media' => '3',
           'begin_at' =>  $beginAt,
           'end_at' => $endAt,
           'description' => 'testUpdateDescription',
           'approval_status' => '3',
           'comment' => 'testUpdateComment',
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
