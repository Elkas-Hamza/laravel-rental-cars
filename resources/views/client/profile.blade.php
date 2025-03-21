@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <div class="profile-img-container mb-3">
                            @if (auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile Image"
                                    class="rounded-circle img-fluid" style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 120px; height: 120px;">
                                    <span class="text-white fs-1">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <h5 class="card-title">{{ auth()->user()->name }}</h5>
                        <p class="text-muted">Member since {{ auth()->user()->created_at->format('M Y') }}</p>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#profile-info" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                            <i class="bi bi-person me-2"></i> Personal Information
                        </a>
                        <a href="#address-info" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="bi bi-geo-alt me-2"></i> Address Information
                        </a>
                        <a href="#password-change" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="bi bi-shield-lock me-2"></i> Change Password
                        </a>
                        <a href="#notification-settings" class="list-group-item list-group-item-action"
                            data-bs-toggle="list">
                            <i class="bi bi-bell me-2"></i> Notification Settings
                        </a>
                        <a href="#payment-methods" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="bi bi-credit-card me-2"></i> Payment Methods
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Personal Information Tab -->
                    <div class="tab-pane fade show active" id="profile-info">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ auth()->user()->name }}" required>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ auth()->user()->email }}" required>
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" id="phone" name="phone"
                                                value="{{ auth()->user()->phone }}">
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" id="date_of_birth"
                                                name="date_of_birth" value="{{ auth()->user()->date_of_birth }}">
                                            @error('date_of_birth')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="profile_photo" class="form-label">Profile Photo</label>
                                        <input type="file" class="form-control" id="profile_photo" name="photo">
                                        <small class="form-text text-muted">Allowed formats: JPG, PNG, GIF. Max size: 2MB.</small>
                                        @error('photo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        
                                        @if(auth()->user()->photo)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Current Profile Photo" class="img-thumbnail" style="max-height: 100px;">
                                                <small class="d-block mt-1">Current photo</small>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-2"></i>Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information Tab -->
                    <div class="tab-pane fade" id="address-info">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Address Information</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update.address') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="address_line1" class="form-label">Address Line 1</label>
                                        <input type="text" class="form-control" id="address_line1"
                                            name="address_line1" value="{{ auth()->user()->address_line1 ?? '' }}">
                                        @error('address_line1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="address_line2" class="form-label">Address Line 2</label>
                                        <input type="text" class="form-control" id="address_line2"
                                            name="address_line2" value="{{ auth()->user()->address_line2 ?? '' }}">
                                        @error('address_line2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="{{ auth()->user()->city ?? '' }}">
                                            @error('city')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="state" class="form-label">State/Province</label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                value="{{ auth()->user()->state ?? '' }}">
                                            @error('state')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text" class="form-control" id="postal_code"
                                                name="postal_code" value="{{ auth()->user()->postal_code ?? '' }}">
                                            @error('postal_code')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <select class="form-select" id="country" name="country">
                                            <option value="">Select Country</option>
                                            <option value="US"
                                                {{ (auth()->user()->country ?? '') == 'US' ? 'selected' : '' }}>United
                                                States</option>
                                            <option value="CA"
                                                {{ (auth()->user()->country ?? '') == 'CA' ? 'selected' : '' }}>Canada
                                            </option>
                                            <option value="MX"
                                                {{ (auth()->user()->country ?? '') == 'MX' ? 'selected' : '' }}>Mexico
                                            </option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                        @error('country')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-2"></i>Save Address
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password Tab -->
                    <div class="tab-pane fade" id="password-change">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Change Password</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update.password') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password" required>
                                        @error('current_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            required>
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-shield-check me-2"></i>Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Settings Tab -->
                    <div class="tab-pane fade" id="notification-settings">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Notification Settings</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update.notifications') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="email_notifications"
                                            name="email_notifications"
                                            {{ auth()->user()->email_notifications ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_notifications">Email
                                            Notifications</label>
                                        <div class="form-text">Receive emails about your reservations, special offers, and
                                            account updates.</div>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="sms_notifications"
                                            name="sms_notifications"
                                            {{ auth()->user()->sms_notifications ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sms_notifications">SMS Notifications</label>
                                        <div class="form-text">Receive text messages for reservation confirmations and
                                            updates.</div>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="promotional_emails"
                                            name="promotional_emails"
                                            {{ auth()->user()->promotional_emails ? 'checked' : '' }}>
                                        <label class="form-check-label" for="promotional_emails">Promotional
                                            Emails</label>
                                        <div class="form-text">Receive special offers, discounts, and promotions via email.
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-2"></i>Save Preferences
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods Tab -->
                    <div class="tab-pane fade" id="payment-methods">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Payment Methods</h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#addPaymentModal">
                                    <i class="bi bi-plus-circle me-2"></i>Add New
                                </button>
                            </div>
                            <div class="card-body">
                                @if (isset($paymentMethods) && count($paymentMethods) > 0)
                                    <div class="list-group">
                                        @foreach ($paymentMethods as $method)
                                            <div
                                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    @if ($method->type == 'credit_card')
                                                        <i class="bi bi-credit-card fs-4 me-3"></i>
                                                    @elseif($method->type == 'paypal')
                                                        <i class="bi bi-paypal fs-4 me-3"></i>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $method->name }}</h6>
                                                        <small class="text-muted">
                                                            @if ($method->type == 'credit_card')
                                                                **** **** **** {{ $method->last_four }}
                                                                <span class="ms-2">Expires:
                                                                    {{ $method->expiry_month }}/{{ $method->expiry_year }}</span>
                                                            @elseif($method->type == 'paypal')
                                                                {{ $method->email }}
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                                <div>
                                                    @if ($method->is_default)
                                                        <span class="badge bg-success me-2">Default</span>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deletePaymentModal{{ $method->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Delete Payment Method Modal -->
                                            <div class="modal fade" id="deletePaymentModal{{ $method->id }}"
                                                tabindex="-1"
                                                aria-labelledby="deletePaymentModalLabel{{ $method->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="deletePaymentModalLabel{{ $method->id }}">Confirm
                                                                Deletion</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this payment method?</p>
                                                            <p class="fw-bold">{{ $method->name }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <form
                                                                action="{{ route('payment-methods.destroy', $method->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="bi bi-credit-card display-1 text-muted"></i>
                                        <h5 class="mt-3">No Payment Methods Added</h5>
                                        <p class="text-muted">Add a payment method to make your future bookings easier.</p>
                                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                            data-bs-target="#addPaymentModal">
                                            <i class="bi bi-plus-circle me-2"></i>Add Payment Method
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Method Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">Add Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-credit-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-credit" type="button" role="tab" aria-controls="nav-credit"
                                aria-selected="true">Credit Card</button>
                            <button class="nav-link" id="nav-paypal-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-paypal" type="button" role="tab" aria-controls="nav-paypal"
                                aria-selected="false">PayPal</button>
                        </div>
                    </nav>
                    <div class="tab-content mt-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-credit" role="tabpanel"
                            aria-labelledby="nav-credit-tab">
                            <form action="{{ route('payment-methods.store') }}" method="POST" id="creditCardForm">
                                @csrf
                                <input type="hidden" name="type" value="credit_card">

                                <div class="mb-3">
                                    <label for="card_name" class="form-label">Name on Card</label>
                                    <input type="text" class="form-control" id="card_name" name="card_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="card_number" class="form-label">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number"
                                        placeholder="1234 5678 9012 3456" required>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="form-label">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiry_date" name="expiry_date"
                                            placeholder="MM/YY" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvv" name="cvv"
                                            placeholder="123" required>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="make_default"
                                        name="make_default">
                                    <label class="form-check-label" for="make_default">
                                        Make this my default payment method
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="nav-paypal" role="tabpanel" aria-labelledby="nav-paypal-tab">
                            <form action="{{ route('payment-methods.store') }}" method="POST" id="paypalForm">
                                @csrf
                                <input type="hidden" name="type" value="paypal">

                                <div class="mb-3">
                                    <label for="paypal_email" class="form-label">PayPal Email</label>
                                    <input type="email" class="form-control" id="paypal_email" name="paypal_email"
                                        required>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="paypal_make_default"
                                        name="make_default">
                                    <label class="form-check-label" for="paypal_make_default">
                                        Make this my default payment method
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="savePaymentMethod">Save Payment Method</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle tab navigation via URL hash
            let url = document.location.toString();
            if (url.match('#')) {
                const tabId = url.split('#')[1];
                $('.list-group-item[href="#' + tabId + '"]').tab('show');
            }

            // Update URL hash when tabs are clicked
            $('.list-group-item[data-bs-toggle="list"]').on('shown.bs.tab', function(e) {
                if (history.pushState) {
                    history.pushState(null, null, '#' + e.target.getAttribute('href').substr(1));
                } else {
                    location.hash = '#' + e.target.getAttribute('href').substr(1);
                }
            });

            // Save payment method form submission
            document.getElementById('savePaymentMethod').addEventListener('click', function() {
                const activeTab = document.querySelector('.tab-pane.active');
                const form = activeTab.querySelector('form');
                form.submit();
            });
        });
    </script>
@endsection
