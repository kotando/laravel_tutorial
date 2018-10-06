<?php

namespace App\Services;

use App\Eloquents\Invoice;

class InvoiceService
{
    public function index()
    {
        $query = Invoice::query();
        return $query->get();
    }

    public function findOrFail(int $invoiceId)
    {
        return Invoice::findOrFail($invoiceId);
    }

    public function create(array $attributes)
    {
        $invoice = new Invoice();
        $invoice->fill($attributes);
        $invoice->save();

        return $invoice;
    }

    public function update(Invoice $invoice, array $attributes)
    {
        $invoice->fill($attributes);
        $invoice->save();

        return $invoice;
    }

    public function delete(Invoice $invoice)
    {
        $invoice->delete();
    }
}

?>
