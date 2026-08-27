<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class PdfController extends Controller
{
    //
     public function generate()
    {
        $invoice = [
            'order_number' => 'ORD-2026-001',
            'date' => '25 August 2026',

            'customer' => [
                'name' => 'Ali Khan',
                'email' => 'ali@example.com',
                'phone' => '+92 300 1234567',
            ],

            'products' => [
                [
                    'name' => 'Laptop',
                    'quantity' => 1,
                    'price' => 120000,
                ],
                [
                    'name' => 'Wireless Mouse',
                    'quantity' => 2,
                    'price' => 2500,
                ],
                [
                    'name' => 'Touch pad',
                    'quantity' => 1,
                    'price' => 5000,
                ],
                  [
                    'name' => 'Desktop',
                    'quantity' => 1,
                    'price' => 120000,
                ],
                [
                    'name' => 'Wire Mouse',
                    'quantity' => 2,
                    'price' => 2500,
                ],
               
            ],

            'discount' => 5000,
        ];

        // Calculate subtotal
        $subtotal = 0;

        foreach ($invoice['products'] as $product) {
            $subtotal += $product['quantity'] * $product['price'];
        }

        // Calculate total
        $total = $subtotal - $invoice['discount'];

        // Add calculated values
        $invoice['subtotal'] = $subtotal;
        $invoice['total'] = $total;

        return Pdf::view('pdf', [
            'invoice' => $invoice,
        ])->download('invoice.pdf');
    }
}
