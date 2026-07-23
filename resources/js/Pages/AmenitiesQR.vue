<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    amenitiesUrl: String,
    seo: Object,
});

const qrLoaded = ref(false);
const isLoaded = ref(false);

const qrCodeUrl = computed(() => {
    const baseUrl = window.location.origin;
    const fullUrl = `${baseUrl}/amenities`;
    return `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encodeURIComponent(fullUrl)}&bgcolor=0f0f0f&color=c9a227&format=svg`;
});

const downloadQrUrl = computed(() => {
    const baseUrl = window.location.origin;
    const fullUrl = `${baseUrl}/amenities`;
    return `https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data=${encodeURIComponent(fullUrl)}&format=png`;
});

onMounted(() => {
    setTimeout(() => {
        isLoaded.value = true;
    }, 100);
});

const asset = (path) => `/assets/paradise/${path}`;

const downloadQR = () => {
    const link = document.createElement('a');
    link.href = downloadQrUrl.value;
    link.download = 'alexandar-palace-amenities-qr.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

const printQR = () => {
    window.print();
};
</script>

<template>
    <Head>
        <title>{{ seo?.title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Cormorant+Garamond:wght@300;400;500;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    </Head>

    <div class="qr-page" :class="{ 'loaded': isLoaded }">
        <!-- Background Pattern -->
        <div class="bg-pattern"></div>
        
        <!-- Main Content -->
        <div class="qr-container">
            <!-- QR Card -->
            <div class="qr-card">
                <div class="logo-wrapper">
                    <img :src="asset('img/logo.png')" alt="Alexandar Palace" class="logo">
                </div>
                <div class="header-decoration">
                    <div class="line"></div>
                    <i class="bi bi-diamond-fill"></i>
                    <div class="line"></div>
                </div>
                <div class="card-header">
                    <span class="subtitle">Discover Our</span>
                    <h1>Hotel Amenities</h1>
                    <p>Scan to explore our world-class facilities & services</p>
                </div>

                <div class="qr-wrapper">
                    <div class="qr-outer-frame">
                        <div class="qr-frame">
                            <div class="corner top-left"></div>
                            <div class="corner top-right"></div>
                            <div class="corner bottom-left"></div>
                            <div class="corner bottom-right"></div>
                            
                            <div class="qr-inner">
                                <img 
                                    :src="qrCodeUrl" 
                                    alt="Scan for Amenities" 
                                    class="qr-code"
                                    @load="qrLoaded = true"
                                    :class="{ 'loaded': qrLoaded }"
                                >
                                
                                <div v-if="!qrLoaded" class="qr-loading">
                                    <div class="spinner"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="scan-instruction">
                    <i class="bi bi-phone"></i>
                    <span>Point your camera at the QR code</span>
                </div>

                <div class="amenities-preview">
                    <div class="preview-item">
                        <i class="bi bi-droplet-half"></i>
                        <span>SPA</span>
                    </div>
                    <div class="preview-item">
                        <i class="bi bi-cup-hot"></i>
                        <span>Dining</span>
                    </div>
                    <div class="preview-item">
                        <i class="bi bi-dribbble"></i>
                        <span>Sports</span>
                    </div>
                    <div class="preview-item">
                        <i class="bi bi-building"></i>
                        <span>Rooms</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons (for admin/staff) -->
            <div class="action-buttons no-print">
                <button @click="downloadQR" class="action-btn download">
                    <i class="bi bi-download"></i>
                    <span>Download QR</span>
                </button>
                <button @click="printQR" class="action-btn print">
                    <i class="bi bi-printer"></i>
                    <span>Print</span>
                </button>
            </div>

            <!-- Direct Link -->
            <div class="direct-link no-print">
                <span>Or visit directly:</span>
                <a :href="amenitiesUrl">{{ amenitiesUrl }}</a>
            </div>

            <!-- Footer -->
            <footer class="qr-footer">
                <div class="footer-decoration">
                    <div class="line"></div>
                    <i class="bi bi-star-fill"></i>
                    <div class="line"></div>
                </div>
                <p>Alexandar Palace Hotel</p>
                <small>Blvd. 8-mi Septemvri No. 15, Skopje</small>
            </footer>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Cormorant+Garamond:wght@300;400;500;600&family=Inter:wght@300;400;500;600&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.qr-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0a0a0a 100%);
    font-family: 'Inter', sans-serif;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    position: relative;
    overflow: hidden;
    opacity: 0;
    transition: opacity 0.8s ease;
}

.qr-page.loaded {
    opacity: 1;
}

.bg-pattern {
    position: absolute;
    inset: 0;
    background: 
        radial-gradient(circle at 20% 20%, rgba(201, 162, 39, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 80% 80%, rgba(201, 162, 39, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 50% 50%, rgba(201, 162, 39, 0.03) 0%, transparent 60%);
    pointer-events: none;
}

.qr-container {
    max-width: 480px;
    width: 100%;
    position: relative;
    z-index: 2;
}

.logo-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.logo {
    height: 60px;
    width: auto;
    filter: drop-shadow(0 4px 20px rgba(201, 162, 39, 0.3));
}

.header-decoration {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 20px;
}

.header-decoration .line {
    width: 50px;
    height: 1px;
    background: linear-gradient(90deg, transparent, #c9a227, transparent);
}

.header-decoration i {
    color: #c9a227;
    font-size: 0.5rem;
}

/* QR Card */
.qr-card {
    background: linear-gradient(165deg, rgba(20, 20, 20, 0.95) 0%, rgba(10, 10, 10, 0.98) 100%);
    border: 1px solid rgba(201, 162, 39, 0.3);
    border-radius: 24px;
    padding: 40px 30px;
    position: relative;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
}

.card-header {
    text-align: center;
    margin-bottom: 30px;
}

.card-header .subtitle {
    display: block;
    font-size: 0.85rem;
    color: #c9a227;
    text-transform: uppercase;
    letter-spacing: 4px;
    margin-bottom: 10px;
}

.card-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: 12px;
}

.card-header p {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.5);
    line-height: 1.6;
    font-weight: 300;
}

/* QR Code */
.qr-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 25px;
}

.qr-outer-frame {
    padding: 3px;
    background: linear-gradient(135deg, #c9a227 0%, #a68520 100%);
    border-radius: 18px;
}

.qr-frame {
    position: relative;
    padding: 20px;
    background: #0f0f0f;
    border-radius: 15px;
}

.corner {
    position: absolute;
    width: 35px;
    height: 35px;
    border-color: #c9a227;
    border-style: solid;
    opacity: 0.6;
}

.corner.top-left {
    top: 8px;
    left: 8px;
    border-width: 2px 0 0 2px;
    border-radius: 6px 0 0 0;
}

.corner.top-right {
    top: 8px;
    right: 8px;
    border-width: 2px 2px 0 0;
    border-radius: 0 6px 0 0;
}

.corner.bottom-left {
    bottom: 8px;
    left: 8px;
    border-width: 0 0 2px 2px;
    border-radius: 0 0 0 6px;
}

.corner.bottom-right {
    bottom: 8px;
    right: 8px;
    border-width: 0 2px 2px 0;
    border-radius: 0 0 6px 0;
}

.qr-inner {
    position: relative;
}

.qr-code {
    width: 220px;
    height: 220px;
    display: block;
    opacity: 0;
    transition: opacity 0.5s ease;
}

.qr-code.loaded {
    opacity: 1;
}

.qr-loading {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0f0f0f;
}

.spinner {
    width: 45px;
    height: 45px;
    border: 3px solid rgba(201, 162, 39, 0.15);
    border-top-color: #c9a227;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Scan Instruction */
.scan-instruction {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: 30px;
}

.scan-instruction i {
    font-size: 1.5rem;
    color: #c9a227;
}

.scan-instruction span {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
}

/* Amenities Preview */
.amenities-preview {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

.preview-item {
    text-align: center;
    padding: 15px 10px;
    background: rgba(201, 162, 39, 0.1);
    border: 1px solid rgba(201, 162, 39, 0.2);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.preview-item:hover {
    background: rgba(201, 162, 39, 0.2);
    transform: translateY(-2px);
}

.preview-item i {
    font-size: 1.3rem;
    color: #c9a227;
    display: block;
    margin-bottom: 8px;
}

.preview-item span {
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 15px;
    margin-top: 35px;
}

.action-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px 24px;
    border-radius: 14px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.4s ease;
    border: none;
    font-family: inherit;
}

.action-btn.download {
    background: linear-gradient(135deg, #c9a227 0%, #a68520 100%);
    color: #fff;
    box-shadow: 0 4px 20px rgba(201, 162, 39, 0.3);
}

.action-btn.download:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(201, 162, 39, 0.5);
}

.action-btn.print {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(201, 162, 39, 0.4);
    color: #c9a227;
}

.action-btn.print:hover {
    background: rgba(201, 162, 39, 0.15);
    transform: translateY(-3px);
    border-color: rgba(201, 162, 39, 0.6);
}

/* Direct Link */
.direct-link {
    text-align: center;
    margin-top: 25px;
    font-size: 0.85rem;
}

.direct-link span {
    color: rgba(255, 255, 255, 0.4);
    margin-right: 8px;
}

.direct-link a {
    color: #c9a227;
    text-decoration: none;
    border-bottom: 1px solid rgba(201, 162, 39, 0.3);
    transition: all 0.3s ease;
    padding-bottom: 2px;
}

.direct-link a:hover {
    border-bottom-color: #c9a227;
}

/* Footer */
.qr-footer {
    text-align: center;
    margin-top: 40px;
}

.footer-decoration {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 15px;
}

.footer-decoration .line {
    width: 40px;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(201, 162, 39, 0.5), transparent);
}

.footer-decoration i {
    color: #c9a227;
    font-size: 0.5rem;
}

.qr-footer p {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: #fff;
    margin-bottom: 5px;
}

.qr-footer small {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
}

/* Print Styles */
@media print {
    .no-print {
        display: none !important;
    }
    
    .qr-page {
        background: #fff !important;
        padding: 20px;
    }
    
    .qr-card {
        background: #fff !important;
        border: 2px solid #c9a227;
        box-shadow: none;
    }
    
    .card-border-glow,
    .card-inner-glow,
    .floating-elements,
    .bg-gradient,
    .bg-pattern {
        display: none !important;
    }
    
    .card-header h1,
    .card-header p,
    .scan-instruction span,
    .preview-item span,
    .hotel-name,
    .address {
        color: #1a1a1a !important;
    }
    
    .qr-outer-frame {
        box-shadow: none;
    }
}

/* Responsive */
@media (max-width: 480px) {
    .qr-page {
        padding: 30px 15px;
    }
    
    .qr-card {
        padding: 35px 25px;
        border-radius: 24px;
    }
    
    .card-header h1 {
        font-size: 1.8rem;
    }
    
    .qr-code {
        width: 170px;
        height: 170px;
    }
    
    .qr-outer-frame {
        padding: 3px;
    }
    
    .qr-frame {
        padding: 20px;
    }
    
    .amenities-preview {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .contact-row {
        flex-direction: column;
        gap: 10px;
    }
    
    .hotel-tagline {
        font-size: 0.85rem;
        letter-spacing: 3px;
    }
}
</style>
