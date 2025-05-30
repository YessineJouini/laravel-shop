@extends('layouts.app')

@section('content')
<div class="content-wrapper bg-white">
    <!-- Hero Section with Gradient Background -->
    <section class="hero-section position-relative overflow-hidden" style="background: linear-gradient(135deg, #00c2ed 0%, #0099cc 100%); min-height: 70vh;">
        <div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
            <div class="row align-items-center w-100">
                <div class="col-lg-6 text-white">
                    <div class="hero-content">
                        <h1 class="display-3 font-weight-bold mb-4 text-white">
                            Welcome to <span style="color:rgb(5, 68, 83);">HyperByte</span>
                        </h1>
                        <p class="lead mb-4 text-white-50" style="font-size: 1.3rem; line-height: 1.6;">
                            Your premium destination for cutting-edge technology, innovative gadgets, and professional accessories.
                        </p>
                        <div class="hero-buttons">
                            <a href="{{ route('store.index') }}" class="btn btn-light btn-lg px-5 py-3 mr-3 shadow-lg" style="color: #333;">
                                <i class="fas fa-shopping-cart mr-2"></i> Explore Products
                            </a>
                            <a href="#features" class="btn btn-outline-light btn-lg px-4 py-3 shadow">
                                <i class="fas fa-info-circle mr-2"></i> Learn More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="hero-image">
                        <i class="fas fa-laptop fa-10x text-white opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Floating Elements -->
        <div class="position-absolute" style="top: 10%; right: 10%; opacity: 0.1;">
            <i class="fas fa-microchip fa-3x text-white"></i>
        </div>
        <div class="position-absolute" style="bottom: 20%; left: 10%; opacity: 0.1;">
            <i class="fas fa-mobile-alt fa-2x text-white"></i>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5" style="background: #f8f9fa;">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-4 font-weight-bold mb-3" style="color: #333;">Why Choose HyperByte?</h2>
                    <p class="lead text-muted mb-5">Experience excellence in every aspect of your tech journey</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-4">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px; background: linear-gradient(45deg, #6c757d, #495057);">
                                    <i class="fas fa-laptop-code fa-2x text-white"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-3" style="color: #333;">Latest Technology</h4>
                            <p class="text-muted mb-0">Discover cutting-edge devices and innovative solutions from leading brands worldwide.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-4">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px; background: linear-gradient(45deg, #6c757d, #495057);">
                                    <i class="fas fa-shipping-fast fa-2x text-white"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-3" style="color: #333;">Express Delivery</h4>
                            <p class="text-muted mb-0">Fast, secure, and reliable shipping with real-time tracking for all your orders.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-4">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px; background: linear-gradient(45deg, #6c757d, #495057);">
                                    <i class="fas fa-headset fa-2x text-white"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-3" style="color: #333;">Expert Support</h4>
                            <p class="text-muted mb-0">Professional customer service team available 24/7 to assist with all your needs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <h3 class="display-4 font-weight-bold" style="color: #00c2ed;">50K+</h3>
                        <p class="text-muted font-weight-medium">Happy Customers</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <h3 class="display-4 font-weight-bold" style="color: #00c2ed;">1000+</h3>
                        <p class="text-muted font-weight-medium">Premium Products</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <h3 class="display-4 font-weight-bold" style="color: #00c2ed;">99.9%</h3>
                        <p class="text-muted font-weight-medium">Uptime Guarantee</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <h3 class="display-4 font-weight-bold" style="color: #00c2ed;">24/7</h3>
                        <p class="text-muted font-weight-medium">Customer Support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section py-5 position-relative" style="background: linear-gradient(135deg, #00c2ed 0%, #0099cc 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-4 font-weight-bold text-white mb-3">
                        Ready to Start Your Tech Journey?
                    </h2>
                    <p class="lead text-white mb-4">
                        Join thousands of satisfied customers and get access to exclusive deals, faster checkout, and personalized recommendations.
                    </p>
                </div>
                <div class="col-lg-4 text-center">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 shadow-lg" style="color: #333;">
                        <i class="fas fa-user-plus mr-2"></i> Create Account
                    </a>
                    <p class="text-white-50 mt-3 mb-0">
                        <small><i class="fas fa-lock mr-1"></i> 100% Secure & Free</small>
                    </p>
                </div>
            </div>
        </div>
        <!-- Background Pattern -->
        <div class="position-absolute" style="top: 20%; right: 5%; opacity: 0.1;">
            <i class="fas fa-cog fa-4x text-white"></i>
        </div>
        <div class="position-absolute" style="bottom: 10%; left: 5%; opacity: 0.1;">
            <i class="fas fa-rocket fa-3x text-white"></i>
        </div>
    </section>
</div>

<!-- Custom Styles -->
<style>
    .hover-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(108, 117, 125, 0.15) !important;
    }
    
    .hero-section {
        position: relative;
        border-radius: 5px;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
    }
    
    .hero-image {
        position: relative;
        z-index: 2;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .stat-item {
        padding: 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .stat-item:hover {
        background: #f8f9fa;
        transform: translateY(-3px);
    }
    
    .btn {
        transition: all 0.3s ease;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }
    
    .btn-warning {
        background: #fff;
        border: 2px solid #fff;
        color: #333;
    }
    
    .btn-warning:hover {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(255, 255, 255, 0.9);
        color: #333;
    }
    
    .feature-icon {
        transition: all 0.3s ease;
    }
    
    .hover-card:hover .feature-icon {
        transform: scale(1.1);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .display-3 {
            font-size: 2.5rem;
        }
        
        .hero-section {
            min-height: 60vh !important;
        }
        
        .container {
            min-height: 60vh !important;
        }
        
        .hero-buttons .btn {
            display: block;
            margin: 10px 0;
        }
    }
</style>
@endsection