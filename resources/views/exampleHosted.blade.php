<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket Checkout | Railway Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            border-radius: 8px;
        }
        .btn-custom:hover {
            background: linear-gradient(45deg, #0056b3, #004094);
        }
        .total-info {
            font-size: 1.1rem;
        }
        /* Modal Styling */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        }
        .modal-header {
            border-bottom: none;
        }
        .modal-header .btn-close {
            margin-top: -1rem;
            margin-right: -1rem;
        }
    </style>
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="ticketCheckoutModal" tabindex="-1" aria-labelledby="ticketCheckoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketCheckoutModalLabel">Ticket Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7 mx-auto">
                        <div class="card p-4">
                            <h4 class="mb-3">Ticket Information</h4>
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Ticket Price</h6>
                                    </div>
                                    <span>$1000.00</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">VAT (10%)</h6>
                                    </div>
                                    <span>$100.00</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Route</h6>
                                    </div>
                                    <span>Dhaka Junction - Chittagong Central</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="total-info">Total Payment</span>
                                    <strong>$1100.00</strong>
                                </li>
                            </ul>
                            <form action="{{ url('/pay') }}" method="POST">
    @csrf <!-- This generates a CSRF token for security -->
    <input type="hidden" value="1100" name="amount" required />
    <input type="hidden" value="{{ $cusName }}" name="name" /> <!-- Assuming you have this variable -->
    <input type="hidden" value="{{ $contactNo }}" name="contactNo" /> <!-- Assuming you have this variable -->
    <button class="btn btn-custom w-100 mt-3" type="submit">Proceed to Payment</button>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Automatically open the modal on page load
    document.addEventListener("DOMContentLoaded", function () {
        const ticketCheckoutModal = new bootstrap.Modal(document.getElementById('ticketCheckoutModal'));
        ticketCheckoutModal.show();
    });
</script>
</body>
</html>