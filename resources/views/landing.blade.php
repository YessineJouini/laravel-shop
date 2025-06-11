@extends('layouts.app')

@section('content')
<div class="content-wrapper bg-white">
    <!-- Hero Section with Advanced Gradient & Particles -->
    <section class="hero-section position-relative overflow-hidden" style="background: linear-gradient(135deg, #00c2ed 0%, #0099cc 50%, #054453 100%); min-height: 100vh;">
        <!-- Animated Background Elements -->
        <div class="position-absolute w-100 h-100" style="top: 0; left: 0;">
            <div class="floating-particles">
                <div class="particle" style="top: 10%; left: 10%; animation-delay: 0s;"></div>
                <div class="particle" style="top: 20%; left: 80%; animation-delay: 2s;"></div>
                <div class="particle" style="top: 80%; left: 20%; animation-delay: 4s;"></div>
                <div class="particle" style="top: 60%; left: 70%; animation-delay: 6s;"></div>
                <div class="particle" style="top: 30%; left: 50%; animation-delay: 1s;"></div>
            </div>
        </div>
        
        <!-- Geometric Shapes -->
        <div class="position-absolute" style="top: 15%; right: 15%; opacity: 0.1; transform: rotate(45deg);">
            <div class="bg-white" style="width: 60px; height: 60px; border-radius: 12px;"></div>
        </div>
        <div class="position-absolute" style="bottom: 25%; left: 10%; opacity: 0.08;">
            <div class="border border-white rounded-circle" style="width: 80px; height: 80px;"></div>
        </div>
        
        <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh; position: relative; z-index: 2;">
            <div class="row align-items-center w-100">
                <div class="col-lg-6 text-white mb-5 mb-lg-0">
                    <div class="hero-content">
                        <!-- Badge -->
                        <div class="mb-4">
                            <span class="badge badge-pill px-4 py-2 text-warning font-weight-bold" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem;">
                                <i class="fas fa-bolt text-warning mr-2"></i>
                                #1 Tech Destination
                            </span>
                        </div>
                        
                        <h1 class="display-2 font-weight-bold mb-4 text-white hero-title">
                            Welcome to 
                            <span class="d-block mt-2" style="color: #ffffff; text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">
                                Hyper<span style="color: #054453;">Byte</span>
                            </span>
                        </h1>
                        
                        <p class="lead mb-5" style="font-size: 1.4rem; line-height: 1.7; color: rgba(255,255,255,0.9); font-weight: 300;">
                            Transform your digital world with premium technology, innovative gadgets, and professional accessories that redefine excellence.
                        </p>
                        
                        <div class="hero-buttons d-flex flex-column flex-sm-row">
                            <a href="{{ route('store.index') }}" class="btn btn-light btn-lg px-5 py-3 mr-0 mr-sm-4 mb-3 mb-sm-0 shadow-lg border-0" style="background: #ffffff; color: #054453; font-weight: 600; border-radius: 50px; transition: all 0.3s ease;">
                                <i class="fas fa-shopping-cart mr-2"></i> 
                                Explore Products
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <a href="#features" class="btn btn-outline-light btn-lg px-5 py-3 shadow border-2" style="border-radius: 50px; font-weight: 600; backdrop-filter: blur(10px); background: rgba(255,255,255,0.1);">
                                <i class="fas fa-play mr-2"></i> 
                                Watch Demo
                            </a>
                        </div>
                        
                        <!-- Trust Indicators -->
                        <div class="mt-5 pt-4">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="text-white-50">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <small class="text-white-50 d-block mt-1">4.9/5 Rating</small>
                                </div>
                                <div class="col-4">
                                    <h5 class="text-white mb-0">50K+</h5>
                                    <small class="text-white-50">Customers</small>
                                </div>
                                <div class="col-4">
                                    <h5 class="text-white mb-0">99.9%</h5>
                                    <small class="text-white-50">Uptime</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 text-center position-relative">
                    <div class="hero-image-container position-relative">
                        <!-- Main Device Mockup -->
                        <div class="device-mockup position-relative">
                            <div class="bg-white rounded shadow-lg p-4 mx-auto" style="width: 300px; height: 200px; transform: perspective(1000px) rotateY(-15deg) rotateX(5deg);">
                                <div class="bg-gradient-primary rounded mb-3" style="height: 30px; background: linear-gradient(90deg, #00c2ed, #0099cc);"></div>
                                <div class="bg-secondary rounded mb-2" style="opacity: 0.2; height: 15px; width: 80%;"></div>
<div class="bg-secondary rounded mb-2" style="opacity: 0.2; height: 15px; width: 60%;"></div>
<div class="bg-secondary rounded" style="opacity: 0.2; height: 15px; width: 40%;"></div>

                                <div class="position-absolute" style="bottom: 20px; right: 20px;">
                                    <div class="bg-success rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Icons -->
                        <div class="floating-icons">
                            <div class="floating-icon" style="top: 10%; left: 10%; animation-delay: 0s;">
                                <div class="bg-white rounded-circle shadow p-3">
                                    <i class="fas fa-mobile-alt text-primary"></i>
                                </div>
                            </div>
                            <div class="floating-icon" style="top: 60%; left: 80%; animation-delay: 1s;">
                                <div class="bg-white rounded-circle shadow p-3">
                                    <i class="fas fa-headphones text-success"></i>
                                </div>
                            </div>
                            <div class="floating-icon" style="bottom: 20%; left: 20%; animation-delay: 2s;">
                                <div class="bg-white rounded-circle shadow p-3">
                                    <i class="fas fa-laptop text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="position-absolute w-100 text-center" style="bottom: 30px; left: 0; z-index: 3;">
            <a href="#features" class="text-white text-decoration-none">
                <div class="scroll-indicator mx-auto mb-2" style="width: 30px; height: 50px; border: 2px solid rgba(255,255,255,0.5); border-radius: 25px; position: relative;">
                    <div class="scroll-dot bg-white rounded-circle" style="width: 6px; height: 6px; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); animation: scroll 2s infinite;"></div>
                </div>
                <small class="text-white-50">Scroll to explore</small>
            </a>
        </div>
    </section>

    <!-- Features Section with Cards Grid -->
    <section id="features" class="py-5 position-relative" style="background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);">
        <div class="container">
            <!-- Section Header -->
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <div class="mb-4">
                        <span class="badge badge-primary px-4 py-2" style="background: linear-gradient(90deg, #00c2ed, #0099cc); border: none; border-radius: 50px; font-size: 0.9rem;">
                            <i class="fas fa-award mr-2"></i>
                            Premium Experience
                        </span>
                    </div>
                    <h2 class="display-3 font-weight-bold mb-4" style="color: #054453;">
                        Why Choose 
                        <span style="color: #00c2ed;">HyperByte</span>?
                    </h2>
                    <p class="lead text-muted mb-0 mx-auto" style="max-width: 600px;">
                        Experience excellence in every aspect of your tech journey with our premium solutions
                    </p>
                </div>
            </div>
            
            <!-- Features Grid -->
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-lg feature-card" style="border-radius: 20px; overflow: hidden; transition: all 0.4s ease;">
                        <div class="card-body text-center p-5 position-relative">
                            <!-- Background Pattern -->
                            <div class="position-absolute" style="top: -50px; right: -50px; opacity: 0.05;">
                                <i class="fas fa-laptop-code" style="font-size: 8rem;"></i>
                            </div>
                            
                            <div class="feature-icon mb-4 position-relative">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center position-relative" 
                                     style="width: 100px; height: 100px; background: linear-gradient(135deg, #00c2ed, #0099cc); box-shadow: 0 10px 30px rgba(0, 194, 237, 0.3);">
                                    <i class="fas fa-rocket fa-2x text-white"></i>
                                    <div class="position-absolute rounded-circle border border-primary" style="width: 120px; height: 120px; top: -10px; left: -10px; opacity: 0.3; animation: pulse 2s infinite;"></div>
                                </div>
                            </div>
                            
                            <h4 class="font-weight-bold mb-3 h3" style="color: #054453;">Latest Technology</h4>
                            <p class="text-muted mb-4" style="line-height: 1.7;">
                                Discover cutting-edge devices and innovative solutions from leading brands worldwide, always staying ahead of the curve.
                            </p>
                            
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-primary btn-sm px-4" style="border-radius: 50px; border-width: 2px;">
                                    Learn More <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-lg feature-card" style="border-radius: 20px; overflow: hidden; transition: all 0.4s ease;">
                        <div class="card-body text-center p-5 position-relative">
                            <div class="position-absolute" style="top: -50px; right: -50px; opacity: 0.05;">
                                <i class="fas fa-shipping-fast" style="font-size: 8rem;"></i>
                            </div>
                            
                            <div class="feature-icon mb-4 position-relative">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center position-relative" 
                                     style="width: 100px; height: 100px; background: linear-gradient(135deg, #28a745, #20c997); box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);">
                                    <i class="fas fa-shipping-fast fa-2x text-white"></i>
                                    <div class="position-absolute rounded-circle border border-success" style="width: 120px; height: 120px; top: -10px; left: -10px; opacity: 0.3; animation: pulse 2s infinite;"></div>
                                </div>
                            </div>
                            
                            <h4 class="font-weight-bold mb-3 h3" style="color: #054453;">Lightning Delivery</h4>
                            <p class="text-muted mb-4" style="line-height: 1.7;">
                                Experience ultra-fast, secure shipping with real-time tracking and guaranteed delivery windows for all orders.
                            </p>
                            
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-success btn-sm px-4" style="border-radius: 50px; border-width: 2px;">
                                    Track Order <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-lg feature-card" style="border-radius: 20px; overflow: hidden; transition: all 0.4s ease;">
                        <div class="card-body text-center p-5 position-relative">
                            <div class="position-absolute" style="top: -50px; right: -50px; opacity: 0.05;">
                                <i class="fas fa-headset" style="font-size: 8rem;"></i>
                            </div>
                            
                            <div class="feature-icon mb-4 position-relative">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center position-relative" 
                                     style="width: 100px; height: 100px; background: linear-gradient(135deg, #ffc107, #fd7e14); box-shadow: 0 10px 30px rgba(255, 193, 7, 0.3);">
                                    <i class="fas fa-headset fa-2x text-white"></i>
                                    <div class="position-absolute rounded-circle border border-warning" style="width: 120px; height: 120px; top: -10px; left: -10px; opacity: 0.3; animation: pulse 2s infinite;"></div>
                                </div>
                            </div>
                            
                            <h4 class="font-weight-bold mb-3 h3" style="color: #054453;">Expert Support</h4>
                            <p class="text-muted mb-4" style="line-height: 1.7;">
                                Professional customer service team available 24/7 with expert knowledge to assist with all your technical needs.
                            </p>
                            
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-warning btn-sm px-4" style="border-radius: 50px; border-width: 2px;">
                                    Get Help <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Statistics Section -->
    <section class="py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #054453 0%, #00c2ed 100%);">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card p-4 rounded-lg" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 20px;">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-users fa-3x text-white opacity-75"></i>
                        </div>
                        <h3 class="display-3 font-weight-bold text-white mb-2 counter" data-count="50000">0</h3>
                        <p class="text-white-50 font-weight-medium mb-0">Happy Customers</p>
                        <div class="progress mt-3" style="height: 4px; background: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: 95%; animation: growWidth 2s ease-out;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card p-4 rounded-lg" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 20px;">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-box fa-3x text-white opacity-75"></i>
                        </div>
                        <h3 class="display-3 font-weight-bold text-white mb-2 counter" data-count="1000">0</h3>
                        <p class="text-white-50 font-weight-medium mb-0">Premium Products</p>
                        <div class="progress mt-3" style="height: 4px; background: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: 88%; animation: growWidth 2s ease-out 0.5s both;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card p-4 rounded-lg" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 20px;">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-chart-line fa-3x text-white opacity-75"></i>
                        </div>
                        <h3 class="display-3 font-weight-bold text-white mb-2">99.9<span style="font-size: 0.6em;">%</span></h3>
                        <p class="text-white-50 font-weight-medium mb-0">Uptime Guarantee</p>
                        <div class="progress mt-3" style="height: 4px; background: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: 99%; animation: growWidth 2s ease-out 1s both;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card p-4 rounded-lg" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 20px;">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-clock fa-3x text-white opacity-75"></i>
                        </div>
                        <h3 class="display-3 font-weight-bold text-white mb-2">24<span style="font-size: 0.6em;">/7</span></h3>
                        <p class="text-white-50 font-weight-medium mb-0">Customer Support</p>
                        <div class="progress mt-3" style="height: 4px; background: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: 100%; animation: growWidth 2s ease-out 1.5s both;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Background Elements -->
        <div class="position-absolute" style="top: 10%; right: 10%; opacity: 0.1;">
            <i class="fas fa-microchip fa-6x text-white"></i>
        </div>
        <div class="position-absolute" style="bottom: 10%; left: 10%; opacity: 0.1;">
            <i class="fas fa-network-wired fa-4x text-white"></i>
        </div>
    </section>

    <!-- Enhanced Call to Action Section -->
    <section class="cta-section py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #00c2ed 0%, #0099cc 50%, #054453 100%); min-height: 60vh;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center min-vh-30">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="mb-3">
                        <span class="badge badge-light px-4 py-2" style="border-radius: 50px; color: #054453; font-weight: 600;">
                            <i class="fas fa-gift mr-2"></i>
                            Limited Time Offer
                        </span>
                    </div>
                    <h2 class="display-3 font-weight-bold text-white mb-4">
                        Ready to Start Your 
                        <span class="d-block" style="color: #ffffff; text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">
                            Tech Journey?
                        </span>
                    </h2>
                    <p class="lead text-white mb-4" style="font-size: 1.3rem; line-height: 1.7; opacity: 0.9;">
                        Join thousands of satisfied customers and get access to exclusive deals, faster checkout, and personalized recommendations.
                    </p>
                    
                    <!-- Benefits List -->
                    <div class="row text-white mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check-circle mr-3 text-success"></i>
                                <span>Exclusive member discounts</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check-circle mr-3 text-success"></i>
                                <span>Priority customer support</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check-circle mr-3 text-success"></i>
                                <span>Early access to new products</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check-circle mr-3 text-success"></i>
                                <span>Free express shipping</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 text-center">
                    <div class="cta-card p-4 rounded-lg" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); border-radius: 25px;">
                        <h4 class="text-white mb-3 font-weight-bold">Get Started Today</h4>
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 mb-3 shadow-lg border-0 w-100" style="background: #ffffff; color: #054453; font-weight: 700; border-radius: 50px; font-size: 1.1rem;">
                            <i class="fas fa-user-plus mr-2"></i> 
                            Create Free Account
                        </a>
                        <p class="text-white mb-2" style="opacity: 0.8;">
                            <small><i class="fas fa-shield-alt mr-1"></i> 100% Secure & Free Forever</small>
                        </p>
                        <p class="text-white-50 mb-0">
                            <small>No credit card required</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Background Pattern -->
        <div class="position-absolute" style="top: 15%; right: 8%; opacity: 0.1; transform: rotate(12deg);">
            <i class="fas fa-cogs fa-5x text-white"></i>
        </div>
        <div class="position-absolute" style="bottom: 15%; left: 8%; opacity: 0.1; transform: rotate(-12deg);">
            <i class="fas fa-rocket fa-4x text-white"></i>
        </div>
        <div class="position-absolute" style="top: 50%; right: 3%; opacity: 0.08;">
            <i class="fas fa-atom fa-3x text-white"></i>
        </div>
    </section>
</div>

<!-- Enhanced Custom Styles -->
<style>
    /* Advanced Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(2deg); }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.3; }
        50% { transform: scale(1.05); opacity: 0.5; }
    }
    
    @keyframes scroll {
        0% { opacity: 1; transform: translateX(-50%) translateY(0); }
        50% { opacity: 0.5; transform: translateX(-50%) translateY(15px); }
        100% { opacity: 1; transform: translateX(-50%) translateY(0); }
    }
    
    @keyframes growWidth {
        from { width: 0%; }
        to { width: var(--target-width, 100%); }
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes bounceIn {
        0% { opacity: 0; transform: scale(0.3); }
        50% { opacity: 1; transform: scale(1.05); }
        70% { transform: scale(0.9); }
        100% { opacity: 1; transform: scale(1); }
    }
    
    /* Particles Animation */
    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255,255,255,0.6);
        border-radius: 50%;
        animation: particleFloat 8s infinite ease-in-out;
    }
    
    @keyframes particleFloat {
        0%, 100% { transform: translateY(0px) translateX(0px); opacity: 0.6; }
        25% { transform: translateY(-30px) translateX(10px); opacity: 1; }
        50% { transform: translateY(-60px) translateX(-5px); opacity: 0.8; }
        75% { transform: translateY(-30px) translateX(-10px); opacity: 1; }
    }
    
    /* Floating Icons */
    .floating-icon {
        position: absolute;
        animation: floatIcon 6s infinite ease-in-out;
    }
    
    @keyframes floatIcon {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }
    
    /* Hero Enhancements */
    .hero-title {
        animation: fadeInUp 1s ease-out;
        text-shadow: 2px 2px 20px rgba(0,0,0,0.3);
    }
    
    .hero-content {
        animation: fadeInUp 1s ease-out 0.3s both;
    }
    
    .device-mockup {
        animation: bounceIn 1s ease-out 0.6s both;
    }
    
    /* Feature Cards */
    .feature-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform: translateY(0);
    }
    
    .feature-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 194, 237, 0.15) !important;
    }
    
    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    /* Enhanced Buttons */
    .btn {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn:hover::before {
        left: 100%;
    }
    
    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    /* Statistics Cards */
    .stat-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .stat-card:hover {
        transform: translateY(-5px) scale(1.05);
        background: rgba(255,255,255,0.2) !important;
    }
    
    /* CTA Card */
    .cta-card {
        transition: all 0.3s ease;
    }
    
    .cta-card:hover {
        transform: translateY(-5px);
        background: rgba(255,255,255,0.25) !important;
    }
    
    /* Glassmorphism Effects */
    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Scroll Indicator */
    .scroll-indicator {
        animation: scrollPulse 2s infinite;
    }
    
    @keyframes scrollPulse {
        0%, 100% { transform: scale(1); opacity: 0.7; }
        50% { transform: scale(1.1); opacity: 1; }
    }
    
    /* Text Gradients */
    .text-gradient {
        background: linear-gradient(135deg, #00c2ed, #0099cc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Loading Animation for Counters */
    .counter {
        transition: all 0.3s ease;
    }
    
    /* Enhanced Shadows */
    .shadow-primary {
        box-shadow: 0 10px 30px rgba(0, 194, 237, 0.3) !important;
    }
    
    .shadow-success {
        box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3) !important;
    }
    
    .shadow-warning {
        box-shadow: 0 10px 30px rgba(255, 193, 7, 0.3) !important;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .display-2 {
            font-size: 2.5rem;
        }
        
        .display-3 {
            font-size: 2rem;
        }
        
        .hero-section {
            min-height: 80vh !important;
        }
        
        .container {
            min-height: 80vh !important;
        }
        
        .hero-buttons .btn {
            display: block;
            margin: 10px 0;
            width: 100%;
        }
        
        .device-mockup .bg-white {
            width: 250px !important;
            height: 160px !important;
        }
        
        .floating-icon {
            display: none;
        }
        
        .particle {
            display: none;
        }
        
        .feature-card {
            margin-bottom: 2rem;
        }
        
        .stat-card {
            margin-bottom: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .display-2 {
            font-size: 2rem;
        }
        
        .lead {
            font-size: 1.1rem !important;
        }
        
        .hero-content .row .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
        
        .hero-content .row .col-4 h5 {
            font-size: 1rem;
        }
        
        .hero-content .row .col-4 small {
            font-size: 0.75rem;
        }
    }
    
    /* Performance Optimizations */
    .feature-card,
    .stat-card,
    .btn,
    .hero-image-container {
        will-change: transform;
    }
    
    /* Accessibility Improvements */
    .btn:focus,
    .card:focus {
        outline: 3px solid rgba(0, 194, 237, 0.5);
        outline-offset: 2px;
    }
    
    /* Print Styles */
    @media print {
        .hero-section {
            background: #00c2ed !important;
            -webkit-print-color-adjust: exact;
        }
        
        .particle,
        .floating-icon,
        .scroll-indicator {
            display: none;
        }
    }
    
   
     
        
       
    
    
    /* Reduced Motion Support */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
        
        .particle,
        .floating-icon {
            animation: none;
        }
    }
    
    /* High Contrast Mode */
    @media (prefers-contrast: high) {
        .text-white-50 {
            opacity: 0.8 !important;
        }
        
        .btn-outline-light {
            border-width: 3px !important;
        }
    }

    /* Fix for navbar background on landing page */
    .navbar {
        background: rgba(255,255,255,0.95) !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        z-index: 1050;
    }
 
</style>

<script>
// Enhanced JavaScript for Interactive Elements
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Counter animation
    const counters = document.querySelectorAll('.counter');
    const observerOptions = {
        threshold: 0.7,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;
                
                const updateCounter = () => {
                    current += step;
                    if (current < target) {
                        counter.textContent = Math.floor(current).toLocaleString();
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target.toLocaleString();
                    }
                };
                
                updateCounter();
                counterObserver.unobserve(counter);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
    
    // Parallax effect for hero section
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.hero-section .position-absolute');
        
        parallaxElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.1);
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
    
    // Card hover effects with mouse tracking
    document.querySelectorAll('.feature-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-15px) scale(1.02)`;
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0) scale(1)';
        });
    });
    
    // Dynamic gradient animation
    let gradientAngle = 135;
    setInterval(() => {
        gradientAngle += 1;
        if (gradientAngle >= 360) gradientAngle = 0;
        
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            heroSection.style.background = `linear-gradient(${gradientAngle}deg, #00c2ed 0%, #0099cc 50%, #054453 100%)`;
        }
    }, 100);
});
</script>
@endsection