<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - LKR Prices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .price-lkr {
            color: #28a745;
            font-weight: bold;
            font-size: 1.2em;
        }
        .currency-badge {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.8em;
            margin-left: 0.5rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-center mb-3">Our Products</h1>
                <p class="text-center text-muted">All prices are displayed in Sri Lankan Rupees (LKR)</p>
                <div class="text-center">
                    <span class="badge bg-success">✓ Converted from USD to LKR</span>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 product-card shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted flex-grow-1">{{ $product->description }}</p>
                            <div class="mt-auto">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="price-lkr">
                                        LKR {{ number_format($product->price, 2) }}
                                        <span class="currency-badge">LKR</span>
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Converted from USD at rate 1:320
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <button class="btn btn-primary btn-sm w-100">Add to Cart</button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h4>No Products Available</h4>
                        <p>There are currently no products in our catalog.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Currency Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Exchange Rate Used:</h6>
                                <p class="mb-0">1 USD = 320 LKR</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Total Products:</h6>
                                <p class="mb-0">{{ $products->count() }} items</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
