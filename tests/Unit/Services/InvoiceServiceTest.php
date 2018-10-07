<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Eloquents\Shop;
use App\Eloquents\Invoice;
use App\Services\InvoiceService;

use Carbon\Carbon;

/**
 * @coversDefaultClass \App\Services\InvoiceService
 */
class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers ::index
     * @covers ::<private>
     */
     public function testIndex()
     {
         factory(Invoice::class, 3)->create();
         $service = new InvoiceService;
         $results = $service->index();

         $this->assertCount(3, $results);
     }

     /**
      * @covers ::findOrFail
      * @covers ::<private>
      */
     public function testFindOrFail()
     {
         $invoice = factory(Invoice::class)->create();
         $service = new InvoiceService();
         $result = $service->findOrFail($invoice->id);

         $this->assertEquals($invoice->id, $result->id);
         $this->assertEquals($invoice->shop_id, $result->shop_id);
     }

     /**
      * @covers ::create
      * @covers ::<private>
      */
     public function testCreate()
     {
         $shop = factory(Shop::class)->create();

         $beginAt = Carbon::today();
         $endAt = Carbon::tomorrow();

         $attributes = [
             'shop_id' => $shop->id,
             'billing_amount' => 30000,
             'begin_at' => $beginAt,
             'end_at' => $endAt,
             'description' => 'I am Nonaka',
         ];

         $service = new InvoiceService();
         $result = $service->create($attributes);

         $this->assertEquals($shop->id, $result->shop_id);
         $this->assertDatabaseHas('invoices', [
             'shop_id'     => $shop->id,
             'billing_amount' => $attributes['billing_amount'],
             'begin_at' => $attributes['begin_at'],
             'end_at' => $attributes['end_at'],
             'description' => $attributes['description'],
         ]);
     }

     /**
      * @covers ::update
      * @covers ::<private>
      */
     public function testUpdate()
     {
         $invoice = factory(Invoice::class)->create();

         $shop = factory(Shop::class)->create();

         $beginAt = Carbon::today();
         $endAt = Carbon::tomorrow();

         $attributes = [
             'shop_id' => $shop->id,
             'billing_amount' => 30000,
             'begin_at' => $beginAt,
             'end_at' => $endAt,
             'description' => 'I am Nonaka',
         ];

         $service = new InvoiceService();
         $result = $service->update($invoice, $attributes);

         $this->assertEquals($shop->id, $result->shop_id);
         $this->assertDatabaseHas('invoices', [
             'shop_id'     => $shop->id,
             'billing_amount' => $attributes['billing_amount'],
             'begin_at' => $attributes['begin_at'],
             'end_at' => $attributes['end_at'],
             'description' => $attributes['description'],
         ]);
     }

     /**
      * @covers ::delete
      * @covers ::<private>
      */
     public function testDelete()
     {
         $invoice = factory(Invoice::class)->create();

         $service = new InvoiceService();
         $result = $service->delete($invoice);

         $this->assertDatabaseMissing('invoices', [
             'id' => $invoice->id,
         ]);
     }
 }
