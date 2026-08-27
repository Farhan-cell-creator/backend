<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    @vite('resources/css/pdf.css')
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