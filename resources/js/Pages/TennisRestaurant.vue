<script setup>
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';

const { t } = useI18n();

defineProps({
    galleryImages: Array,
    dishes: Array,
    seo: Object,
});

const asset = (path) => `/assets/paradise/${path}`;

const features = [
    { icon: 'bi-cup-hot-fill', key: 'great_coffee', descKey: 'coffee_desc' },
    { icon: 'bi-tropical-drink', key: 'fresh_drinks', descKey: 'drinks_desc' },
    { icon: 'bi-balloon-heart-fill', key: 'birthdays_events', descKey: 'events_desc' },
];
</script>

<template>
    <Layout
        :title="seo?.title || t('tennisRestaurant.page_title')"
        :description="seo?.description"
    >
        <!-- Hero Section -->
        <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img" :src="asset('img/tennis-restaurant/tennis-court-banner.webp')" alt="Tennis Court Restaurant">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small class="slide-animated one">{{ t('tennisRestaurant.hero_subtitle') }}</small>
                    <h1 class="slide-animated two">{{ t('tennisRestaurant.hero_title') }}</h1>
                </div>
            </div>
        </div>

        <!-- Introduction with Stats -->
        <div class="intro-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0" data-cue="slideInLeft">
                        <div class="intro-content">
                            <span class="intro-label">{{ t('tennisRestaurant.welcome_to') }}</span>
                            <h2 class="intro-title">{{ t('tennisRestaurant.intro_title') }}</h2>
                            <p class="intro-text">{{ t('tennisRestaurant.intro_text') }}</p>
                            <div class="intro-stats">
                                <div class="stat-item">
                                    <span class="stat-number">100%</span>
                                    <span class="stat-label">{{ t('tennisRestaurant.fresh_ingredients') }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">5★</span>
                                    <span class="stat-label">{{ t('tennisRestaurant.service_rating') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-cue="slideInRight">
                        <div class="intro-images">
                            <div class="main-image">
                                <img :src="asset('img/tennis-restaurant/IMG_8753-prp6uzwtgs0wq8y7xcdjftwjbwyvk1dwtmjwmw6bns.webp')" alt="Fresh Drinks">
                            </div>
                            <div class="floating-image">
                                <img :src="asset('img/tennis-restaurant/5C8B3760-FC2B-4EAD-B731-9663CD55A9D9-2048x2048.webp')" alt="Coffee">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Cards -->
        <div class="features-section">
            <div class="container">
                <div class="row g-4">
                    <div v-for="(feature, index) in features" :key="index" class="col-lg-4" data-cue="slideInUp" :data-delay="index * 150">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i :class="['bi', feature.icon]"></i>
                            </div>
                            <h3 class="feature-title">{{ t(`tennisRestaurant.${feature.key}`) }}</h3>
                            <p class="feature-desc">{{ t(`tennisRestaurant.${feature.descKey}`) }}</p>
                            <div class="feature-line"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Birthdays & Events Section -->
        <div class="events-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 order-lg-1 order-2" data-cue="slideInLeft">
                        <div class="events-image">
                            <img :src="asset('img/tennis-restaurant/IMG_8753-prp6uzwtgs0wq8y7xcdjftwjbwyvk1dwtmjwmw6bns.webp')" alt="Birthdays & Events">
                            <div class="events-badge">
                                <i class="bi bi-balloon-heart-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-2 order-1 mb-5 mb-lg-0" data-cue="slideInRight">
                        <div class="events-content">
                            <span class="events-label">{{ t('tennisRestaurant.birthdays_events') }}</span>
                            <h2 class="events-title">{{ t('tennisRestaurant.celebrate_title') }}</h2>
                            <p class="events-text">{{ t('tennisRestaurant.events_desc') }}</p>
                            <ul class="events-features">
                                <li><i class="bi bi-check2-circle"></i> {{ t('tennisRestaurant.birthday_parties') }}</li>
                                <li><i class="bi bi-check2-circle"></i> {{ t('tennisRestaurant.family_gatherings') }}</li>
                                <li><i class="bi bi-check2-circle"></i> {{ t('tennisRestaurant.private_events') }}</li>
                                <li><i class="bi bi-check2-circle"></i> {{ t('tennisRestaurant.corporate_celebrations') }}</li>
                            </ul>
                            <a href="/contacts" class="events-btn">{{ t('tennisRestaurant.plan_event') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Width Image with Quote -->
        <div class="quote-section">
            <div class="quote-bg" :style="{ backgroundImage: `url(${asset('img/tennis-restaurant/IMG_2602-1536x2048.webp')})` }"></div>
            <div class="quote-overlay"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <div class="quote-content" data-cue="fadeIn">
                            <div class="quote-mark">"</div>
                            <p class="quote-text">{{ t('tennisRestaurant.testimonial_text') }}</p>
                            <div class="quote-author">
                                <span class="author-line"></span>
                                <span class="author-name">{{ t('tennisRestaurant.testimonial_author') }}</span>
                                <span class="author-line"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Masonry -->
        <div class="gallery-section">
            <div class="container">
                <div class="section-header text-center" data-cue="fadeIn">
                    <span class="section-label">Our Gallery</span>
                    <h2 class="section-heading">{{ t('tennisRestaurant.gallery_title') }}</h2>
                </div>
                <div class="gallery-grid" data-cue="fadeIn" data-delay="200">
                    <div v-for="(image, index) in galleryImages" :key="index" class="gallery-item" :class="{ 'large': index === 0 || index === 3 }">
                        <a :href="asset('img/tennis-restaurant/' + image)" class="glightbox" data-glightbox="gallery:tennis">
                            <img :src="asset('img/tennis-restaurant/' + image)" :alt="'Gallery ' + (index + 1)">
                            <div class="gallery-overlay">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section">
            <div class="container">
                <div class="cta-content text-center" data-cue="fadeIn">
                    <h2 class="cta-title">{{ t('tennisRestaurant.ready_experience') }}</h2>
                    <p class="cta-text">{{ t('tennisRestaurant.visit_us') }}</p>
                    <a href="/contacts" class="cta-btn">{{ t('tennisRestaurant.get_in_touch') }}</a>
                </div>
            </div>
        </div>

    </Layout>
</template>

<style scoped>
/* Intro Section */
.intro-section {
    padding: 120px 0;
    background: #fff;
}

.intro-label {
    display: inline-block;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 3px;
    color: #c9a227;
    margin-bottom: 15px;
}

.intro-title {
    font-size: 3.5rem;
    font-weight: 700;
    line-height: 1.1;
    color: #1a1a1a;
    margin-bottom: 25px;
}

.intro-text {
    font-size: 1.1rem;
    line-height: 1.9;
    color: #666;
    margin-bottom: 40px;
    max-width: 480px;
}

.intro-stats {
    display: flex;
    gap: 50px;
}

.stat-item {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #c9a227;
    line-height: 1;
}

.stat-label {
    font-size: 0.85rem;
    color: #888;
    margin-top: 8px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.intro-images {
    position: relative;
    padding-left: 60px;
}

.main-image {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.15);
}

.main-image img {
    width: 100%;
    height: 450px;
    object-fit: cover;
}

.floating-image {
    position: absolute;
    bottom: -40px;
    left: 0;
    width: 200px;
    height: 200px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    border: 5px solid #fff;
}

.floating-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Features Section */
.features-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
}

.feature-card {
    background: #fff;
    padding: 50px 40px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 15px 50px rgba(0,0,0,0.06);
    transition: all 0.4s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.12);
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #c9a227, #e8c547);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.feature-card:hover::before {
    transform: scaleX(1);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #c9a227 0%, #e8c547 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
}

.feature-icon i {
    font-size: 2rem;
    color: #fff;
}

.feature-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 15px;
}

.feature-desc {
    font-size: 0.95rem;
    color: #777;
    line-height: 1.8;
    margin-bottom: 0;
}

.feature-line {
    width: 40px;
    height: 2px;
    background: #c9a227;
    margin: 25px auto 0;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.feature-card:hover .feature-line {
    opacity: 1;
}

/* Events Section */
.events-section {
    padding: 120px 0;
    background: #fff;
}

.events-image {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.12);
}

.events-image img {
    width: 100%;
    height: 500px;
    object-fit: cover;
}

.events-badge {
    position: absolute;
    top: 30px;
    right: 30px;
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #c9a227 0%, #e8c547 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(201, 162, 39, 0.4);
}

.events-badge i {
    font-size: 1.8rem;
    color: #fff;
}

.events-content {
    padding-left: 50px;
}

.events-label {
    display: inline-block;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 3px;
    color: #c9a227;
    margin-bottom: 15px;
}

.events-title {
    font-size: 2.8rem;
    font-weight: 700;
    line-height: 1.2;
    color: #1a1a1a;
    margin-bottom: 20px;
}

.events-text {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #666;
    margin-bottom: 30px;
}

.events-features {
    list-style: none;
    padding: 0;
    margin: 0 0 35px 0;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.events-features li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.95rem;
    color: #555;
}

.events-features li i {
    color: #c9a227;
    font-size: 1.1rem;
}

.events-btn {
    display: inline-block;
    padding: 16px 40px;
    background: transparent;
    border: 2px solid #c9a227;
    color: #c9a227;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.4s ease;
}

.events-btn:hover {
    background: linear-gradient(135deg, #c9a227 0%, #e8c547 100%);
    border-color: transparent;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(201, 162, 39, 0.3);
}

/* Quote Section */
.quote-section {
    position: relative;
    padding: 150px 0;
    overflow: hidden;
}

.quote-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

.quote-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(26,26,26,0.9) 0%, rgba(26,26,26,0.8) 100%);
}

.quote-content {
    position: relative;
    z-index: 1;
}

.quote-mark {
    font-family: Georgia, serif;
    font-size: 150px;
    line-height: 0.5;
    color: #c9a227;
    opacity: 0.5;
    margin-bottom: 20px;
}

.quote-text {
    font-size: 1.5rem;
    font-style: italic;
    color: #fff;
    line-height: 1.9;
    margin-bottom: 40px;
}

.quote-author {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

.author-line {
    width: 50px;
    height: 1px;
    background: #c9a227;
}

.author-name {
    font-size: 1rem;
    font-weight: 600;
    color: #c9a227;
    text-transform: uppercase;
    letter-spacing: 3px;
}

/* Gallery Section */
.gallery-section {
    padding: 120px 0;
    background: #fff;
}

.section-header {
    margin-bottom: 60px;
}

.section-label {
    display: inline-block;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 3px;
    color: #c9a227;
    margin-bottom: 15px;
}

.section-heading {
    font-size: 2.8rem;
    font-weight: 700;
    color: #1a1a1a;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.gallery-item {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    aspect-ratio: 1;
}

.gallery-item.large {
    grid-row: span 2;
    aspect-ratio: auto;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(201, 162, 39, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay i {
    font-size: 2rem;
    color: #fff;
}

/* CTA Section */
.cta-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 15px;
}

.cta-text {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.7);
    margin-bottom: 35px;
}

.cta-btn {
    display: inline-block;
    padding: 18px 50px;
    background: linear-gradient(135deg, #c9a227 0%, #e8c547 100%);
    color: #fff;
    font-size: 0.95rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.4s ease;
}

.cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(201, 162, 39, 0.4);
    color: #fff;
}

/* Responsive */
@media (max-width: 991px) {
    .intro-section {
        padding: 80px 0;
    }
    
    .intro-title {
        font-size: 2.5rem;
    }
    
    .intro-images {
        padding-left: 0;
        margin-top: 50px;
    }
    
    .floating-image {
        width: 150px;
        height: 150px;
        bottom: -20px;
        left: 20px;
    }
    
    .events-section {
        padding: 80px 0;
    }
    
    .events-content {
        padding-left: 0;
        margin-bottom: 40px;
    }
    
    .events-title {
        font-size: 2.2rem;
    }
    
    .events-image img {
        height: 400px;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .gallery-item.large {
        grid-row: span 1;
    }
    
    .quote-text {
        font-size: 1.2rem;
    }
}

@media (max-width: 576px) {
    .intro-title {
        font-size: 2rem;
    }
    
    .intro-stats {
        gap: 30px;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .feature-card {
        padding: 40px 30px;
    }
    
    .events-title {
        font-size: 1.8rem;
    }
    
    .events-features {
        grid-template-columns: 1fr;
    }
    
    .events-image img {
        height: 300px;
    }
    
    .gallery-grid {
        grid-template-columns: 1fr;
    }
    
    .quote-section {
        padding: 80px 0;
    }
    
    .quote-mark {
        font-size: 80px;
    }
    
    .section-heading {
        font-size: 2rem;
    }
    
    .cta-title {
        font-size: 1.8rem;
    }
}
</style>
