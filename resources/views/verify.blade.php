@extends('layouts.app')

@section('content')
<div class="otp-container">
    <div class="card-wrapper">
        <div class="otp-card card-responsive">
            <!-- Logo Header -->
            <div class="text-center mb-6">
                <div class="header-logo">
                    <img src="{{ asset('./logo.jpg') }}" alt="Logo" class="logo-img" />
                </div>
            </div>

            <!-- Card Title -->
            <h1 class="card-title">Vérification OTP</h1>

            <!-- Card Content -->
            <div class="card-content">
                <div class="email-info">
                    Un code de vérification a été envoyé à : {{ $email }}<strong></strong>
                </div>

                <form id="otpForm" method="POST" action="{{ route('otp.verify') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="form-group">
                        <label for="otp">Code OTP</label>
                        <input
                            type="text"
                            id="otp"
                            name="otp"
                            class="form-input"
                            required
                            maxlength="6"
                            placeholder="Entrez le code OTP"
                        >
                    </div>

                    <!-- Alert Messages -->
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <div id="ajaxMessage" class="alert" style="display: none;"></div>

                    <!-- Submit Button -->
                    <div class="card-actions">
                        <button type="submit" class="btn-verify" id="verifyBtn">
                            <span class="btn-text">Vérifier</span>
                            <span class="btn-loader" style="display: none;">
                                <span class="spinner"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.otp-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    min-width: 100%;
    background-color: #1976d2;
    padding: 16px;
}

.card-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
}

.otp-card {
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    padding: 48px;
}

.card-responsive {
    width: 30%;
    margin: 16px auto;
}

/* Logo */
.header-logo {
    display: flex;
    justify-content: center;
    margin-bottom: 24px;
}

.logo-img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #eaeaecf5;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

/* Card Title */
.card-title {
    font-size: 1.5rem;
    text-align: center;
    color: #333;
    margin-bottom: 24px;
    font-weight: 600;
}

/* Card Content */
.card-content {
    margin-top: 16px;
}

.email-info {
    margin-bottom: 24px;
    text-align: center;
    color: #666;
    font-size: 14px;
}

.email-info strong {
    color: #333;
}

/* Form Group */
.form-group {
    margin-bottom: 24px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
    font-size: 14px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: #1976d2;
}

/* Alerts */
.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 16px;
    font-size: 14px;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

/* Button */
.card-actions {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    margin-bottom: 30px;
}

.btn-verify {
    width: 100%;
    height: 60px;
    border-radius: 15px;
    background-color: #1976d2;
    color: #ffffff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    transition: background-color 0.3s;
    cursor: pointer;
    min-width: 200px;
    min-height: 50px;
    position: relative;
}

.btn-verify:hover {
    background-color: #f0f0f0;
    color: #1976d2;
}

.btn-verify:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-text {
    display: inline-block;
}

.btn-loader {
    display: none;
}

.btn-verify.loading .btn-text {
    display: none;
}

.btn-verify.loading .btn-loader {
    display: inline-block;
}

/* Spinner */
.spinner {
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 0.8s linear infinite;
    display: inline-block;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive Styles */
@media (max-width: 1200px) {
    .card-responsive {
        width: 50%;
    }
}

@media (max-width: 900px) {
    .card-responsive {
        width: 70%;
    }

    .otp-card {
        padding: 40px;
    }
}

@media (max-width: 600px) {
    .card-responsive {
        width: 95%;
    }

    .otp-card {
        padding: 24px;
    }

    .logo-img {
        width: 70px;
        height: 70px;
    }

    .card-title {
        font-size: 1.25rem;
    }

    .btn-verify {
        height: 50px;
        font-size: 14px;
    }
}
</style>

{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('otpForm');
    const verifyBtn = document.getElementById('verifyBtn');
    const ajaxMessage = document.getElementById('ajaxMessage');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Show loading state
        verifyBtn.classList.add('loading');
        verifyBtn.disabled = true;
        ajaxMessage.style.display = 'none';

        const formData = new FormData(form);

        fetch('{{ route("otp.verify") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                ajaxMessage.textContent = 'Vérification réussie ✅';
                ajaxMessage.className = 'alert alert-success';
                ajaxMessage.style.display = 'block';

                // Redirect after 1 second
                setTimeout(() => {
                    window.location.href = '{{ route("home") }}';
                }, 1000);
            } else {
                // Show error message
                ajaxMessage.textContent = data.message || 'Code OTP invalide';
                ajaxMessage.className = 'alert alert-error';
                ajaxMessage.style.display = 'block';

                // Reset button
                verifyBtn.classList.remove('loading');
                verifyBtn.disabled = false;
            }
        })
        .catch(error => {
            // Show error message
            ajaxMessage.textContent = 'Erreur serveur. Veuillez réessayer.';
            ajaxMessage.className = 'alert alert-error';
            ajaxMessage.style.display = 'block';

            // Reset button
            verifyBtn.classList.remove('loading');
            verifyBtn.disabled = false;
        });
    });
});
</script> --}}
@endsection
