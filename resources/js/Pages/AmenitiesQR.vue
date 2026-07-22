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
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    </Head>

    <div class="qr-page" :class="{ 'loaded': isLoaded }">
        <!-- Background Pattern -->
        <div class="bg-pattern"></div>
        
        <!-- Main Content -->
        <div class="qr-container">
            <!-- Header -->
            <header class="qr-header">
                <img :src="asset('img/logo-white.png')" alt="Alexandar Palace" class="logo">
                <div class="header-decoration">
                    <div class="line"></div>
                    <i class="bi bi-diamond-fill"></i>
                    <div class="line"></div>
                </div>
            </header>

            <!-- QR Card -->
            <div class="qr-card">
                <div class="card-glow"></div>
                
                <div class="card-header">
                    <span class="subtitle">Discover Our</span>
                    <h1>Hotel Amenities</h1>
                    <p>Scan the QR code to explore all our luxury facilities and services</p>
                </div>

                <div class="qr-wrapper">
                    <div class="qr-frame">
                        <div class="corner top-left"></div>
                        <div class="corner top-right"></div>
                        <div class="corner bottom-left"></div>
                        <div class="corner bottom-right"></div>
                        
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

                <div class="scan-instruction">
                    <div class="phone-icon">
                        <i class="bi bi-phone"></i>
                        <div class="scan-lines"></div>
                    </div>
                    <span>Point your camera at the QR code</span>
                </div>

                <div class="amenities-preview">
                    <div class="preview-item">
                        <i class="bi bi-droplet-half"></i>
                        <span>SPA & Wellness</span>
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
                <small>Bul. Ilinden 101, Skopje</small>
            </footer>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap');

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

/* Header */
.qr-header {
    text-align: center;
    margin-bottom: 30px;
}

.logo {
    height: 50px;
    width: auto;
    margin-bottom: 20px;
    filter: drop-shadow(0 4px 20px rgba(201, 162, 39, 0.3));
}

.header-decoration,
.footer-decoration {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.header-decoration .line,
.footer-decoration .line {
    width: 50px;
    height: 1px;
    background: linear-gradient(90deg, transparent, #c9a227, transparent);
}

.header-decoration i,
.footer-decoration i {
    color: #c9a227;
    font-size: 0.5rem;
}

/* QR Card */
.qr-card {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.02) 100%);
    border: 1px solid rgba(201, 162, 39, 0.3);
    border-radius: 24px;
    padding: 40px 30px;
    position: relative;
    overflow: hidden;
}

.card-glow {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(201, 162, 39, 0.1) 0%, transparent 50%);
    animation: rotate 20s linear infinite;
    pointer-events: none;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.card-header {
    text-align: center;
    margin-bottom: 35px;
    position: relative;
    z-index: 2;
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
    color: rgba(255, 255, 255, 0.6);
    line-height: 1.5;
}

/* QR Code */
.qr-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 25px;
    position: relative;
    z-index: 2;
}

.qr-frame {
    position: relative;
    padding: 20px;
    background: linear-gradient(145deg, rgba(15, 15, 15, 0.9) 0%, rgba(26, 26, 26, 0.9) 100%);
    border-radius: 16px;
}

.corner {
    position: absolute;
    width: 30px;
    height: 30px;
    border-color: #c9a227;
    border-style: solid;
}

.corner.top-left {
    top: 0;
    left: 0;
    border-width: 3px 0 0 3px;
    border-radius: 8px 0 0 0;
}

.corner.top-right {
    top: 0;
    right: 0;
    border-width: 3px 3px 0 0;
    border-radius: 0 8px 0 0;
}

.corner.bottom-left {
    bottom: 0;
    left: 0;
    border-width: 0 0 3px 3px;
    border-radius: 0 0 0 8px;
}

.corner.bottom-right {
    bottom: 0;
    right: 0;
    border-width: 0 3px 3px 0;
    border-radius: 0 0 8px 0;
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
    inset: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 15, 15, 0.9);
}

.spinner {
    width: 40px;
    height: 40px;
    border: 3px solid rgba(201, 162, 39, 0.2);
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
    position: relative;
    z-index: 2;
}

.phone-icon {
    position: relative;
    font-size: 1.5rem;
    color: #c9a227;
}

.scan-lines {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    height: 2px;
    background: #c9a227;
    animation: scan 1.5s ease-in-out infinite;
}

@keyframes scan {
    0%, 100% { opacity: 0.3; transform: translate(-50%, -50%) scaleX(0.5); }
    50% { opacity: 1; transform: translate(-50%, -50%) scaleX(1); }
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
    position: relative;
    z-index: 2;
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
    margin-top: 30px;
}

.action-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 20px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    font-family: inherit;
}

.action-btn.download {
    background: linear-gradient(135deg, #c9a227 0%, #a68520 100%);
    color: #fff;
}

.action-btn.download:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(201, 162, 39, 0.4);
}

.action-btn.print {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(201, 162, 39, 0.5);
    color: #c9a227;
}

.action-btn.print:hover {
    background: rgba(201, 162, 39, 0.2);
    transform: translateY(-2px);
}

/* Direct Link */
.direct-link {
    text-align: center;
    margin-top: 25px;
    font-size: 0.85rem;
}

.direct-link span {
    color: rgba(255, 255, 255, 0.5);
    margin-right: 8px;
}

.direct-link a {
    color: #c9a227;
    text-decoration: none;
    border-bottom: 1px solid rgba(201, 162, 39, 0.3);
    transition: all 0.3s ease;
}

.direct-link a:hover {
    border-bottom-color: #c9a227;
}

/* Footer */
.qr-footer {
    text-align: center;
    margin-top: 40px;
}

.qr-footer p {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: #fff;
    margin-top: 15px;
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
    
    .card-glow {
        display: none;
    }
    
    .card-header h1,
    .card-header p,
    .scan-instruction span,
    .preview-item span,
    .qr-footer p,
    .qr-footer small {
        color: #1a1a1a !important;
    }
    
    .bg-pattern {
        display: none;
    }
}

/* Responsive */
@media (max-width: 480px) {
    .qr-card {
        padding: 30px 20px;
    }
    
    .card-header h1 {
        font-size: 1.6rem;
    }
    
    .qr-code {
        width: 180px;
        height: 180px;
    }
    
    .amenities-preview {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
