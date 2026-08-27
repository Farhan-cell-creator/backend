<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            color: #333;
            background: #f5f7fa;
        }

        .invoice {
            background: #ffffff;
            border: 1px solid #e1e5eb;
            padding: 30px;
        }

        /* ================= HEADER ================= */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid #4b5260;
        }

        /* ================= LOGO ================= */

        .logo-section {
            text-align: center;
        }

        .logo-link {
            text-decoration: none;
            display: inline-block;
        }

        .logo-wrapper {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #4b5466;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            box-sizing: border-box;
        }

        .logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .company-name {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #2b2e35;
        }

        /* ================= INVOICE INFO ================= */

        .invoice-info {
            text-align: right;
        }

        .invoice-info h1 {
            margin: 0;
            color: #1e3a8a;
            font-size: 32px;
            letter-spacing: 2px;
        }

        .invoice-info p {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }

        /* ================= CUSTOMER ================= */

        .customer {
            margin-bottom: 30px;
            padding: 20px;
            background: #eff6ff;
            border-left: 5px solid #424857;
        }

        .customer h3 {
            margin-top: 0;
            color: #3a4460;
        }

        .customer p {
            margin: 7px 0;
        }

        /* ================= TABLE ================= */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dbe3ef;
            padding: 12px;
        }

        th {
            text-align: left;
            background: #2b2e35;
            color: #ffffff;
            font-size: 14px;
        }

        td {
            font-size: 14px;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        /* ================= SUMMARY ================= */

        .summary {
            width: 300px;
            margin-left: auto;
            margin-top: 30px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 9px 0;
            font-size: 15px;
        }

        .grand-total {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            border-top: 2px solid #5a5d62;
            margin-top: 10px;
            padding-top: 12px;
        }

        /* ================= FOOTER ================= */

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .footer strong {
            color: #2b2e35;
        }
    </style>
</head>

<body>

<div class="invoice">

    <!-- ================= HEADER ================= -->

    <div class="header">

        <!-- Logo + Company Name -->

        <div class="logo-section">

            <a
                href="https://zimogroup.org/"
                target="_blank"
                class="logo-link"
            >

                <div class="logo-wrapper">

                    <img
                        src="https://tse1.mm.bing.net/th/id/OIP.dErF93nOoia81ZdPBq85WQAAAA?r=0&rs=1&pid=ImgDetMain&o=7&rm=3"
                        class="logo"
                        alt="Zimo Group Logo"
                    >

                </div>

            </a>

            <div class="company-name">
                Zimo Group
            </div>

        </div>


        <!-- Invoice Information -->

        <div class="invoice-info">

            <h1>INVOICE</h1>

            <p>
                <strong>Order #:</strong>
                {{ $invoice['order_number'] }}
            </p>

            <p>
                <strong>Date:</strong>
                {{ $invoice['date'] }}
            </p>

        </div>

    </div>


    <!-- ================= CUSTOMER DETAILS ================= -->

    <div class="customer">

        <h3>Customer Details</h3>

        <p>
            <strong>Name:</strong>
            {{ $invoice['customer']['name'] }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ $invoice['customer']['email'] }}
        </p>

        <p>
            <strong>Phone:</strong>
            {{ $invoice['customer']['phone'] }}
        </p>

    </div>


    <!-- ================= PRODUCTS ================= -->

    <table>

        <thead>

            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>

        </thead>

        <tbody>

            @foreach($invoice['products'] as $index => $product)

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $product['name'] }}
                    </td>

                    <td>
                        {{ $product['quantity'] }}
                    </td>

                    <td>
                        Rs. {{ number_format($product['price'], 2) }}
                    </td>

                    <td>
                        Rs.
                        {{ number_format(
                            $product['quantity'] * $product['price'],
                            2
                        ) }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    <!-- ================= SUMMARY ================= -->

    <div class="summary">

        <div class="summary-row">

            <span>
                Subtotal:
            </span>

            <span>
                Rs. {{ number_format($invoice['subtotal'], 2) }}
            </span>

        </div>


        <div class="summary-row">

            <span>
                Discount:
            </span>

            <span>
                Rs. {{ number_format($invoice['discount'], 2) }}
            </span>

        </div>


        <div class="summary-row grand-total">

            <span>
                Total:
            </span>

            <span>
                Rs. {{ number_format($invoice['total'], 2) }}
            </span>

        </div>

    </div>


    <!-- ================= FOOTER ================= -->

    <div class="footer">

        Thank you for your business!

        <br>

        <strong>Zimo Group</strong>

    </div>

</div>

</body>
</html>