<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';

const { t } = useI18n();
const page = usePage();

const showSuccess = ref(false);
const successMessage = ref('');

const form = useForm({
    name: '',
    email: '',
    phone: '',
    event_date: '',
    guests: '',
    event_type: '',
    message: '',
});

const submit = () => {
    form.post('/celebrations/contact', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            showSuccess.value = true;
            successMessage.value = page.props.flash?.success || t('celebrations.success_message');
            setTimeout(() => { showSuccess.value = false; }, 10000);
        },
    });
};

const asset = (path) => `/assets/paradise/${path}`;

const galleryImages = [
    'celebrations/svadba-1-400x340.jpg',
    'celebrations/svadba2-400x340.jpeg',
    'celebrations/svadba-3-400x340.jpeg',
    'celebrations/svadba4-pozadina-1-400x340.jpg',
    'celebrations/foaje-400x340.jpg',
    'celebrations/foajematicno4-400x340.jpg',
    'celebrations/foajematicno5-400x340.jpg',
    'celebrations/IMG_9336-400x340.jpeg',
];

const includedServices = [
    { icon: 'bi-cup-straw', key: 'sparkling_wine' },
    { icon: 'bi-flower1', key: 'flower_arrangements' },
    { icon: 'bi-cake2', key: 'brides_cake' },
    { icon: 'bi-palette', key: 'chair_covers' },
    { icon: 'bi-lamp', key: 'candles' },
    { icon: 'bi-fire', key: 'fire_torch' },
];

const eventTypes = [
    { value: 'wedding', labelKey: 'wedding' },
    { value: 'anniversary', labelKey: 'anniversary' },
    { value: 'birthday', labelKey: 'birthday' },
    { value: 'corporate', labelKey: 'corporate_event' },
    { value: 'other', labelKey: 'other' },
];
</script>

<template>
    <Layout
        :title="seo?.title || t('celebrations.page_title')"
        :description="seo?.description"
        :hideBookingSection="true"
    >
        <!-- Hero Section -->
        <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img" :src="asset('img/celebrations/celebrations-banner.webp')" alt="Celebrations">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small class="slide-animated one">{{ t('celebrations.hero_subtitle') }}</small>
                    <h1 class="slide-animated two">{{ t('celebrations.hero_title') }}</h1>
                </div>
            </div>
        </div>

        <!-- Introduction Section -->
        <div class="container margin_120_95">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <span class="subheading">{{ t('celebrations.unforgettable_moments') }}</span>
                    <h2 class="section-title">{{ t('celebrations.leading_venue') }}</h2>
                    <p class="lead" style="color: #666; font-size: 1.25rem; line-height: 1.8;">
                        {{ t('celebrations.intro_text') }}
                    </p>
                </div>
            </div>

            <!-- Capacity Stats -->
            <div class="row mt-5 justify-content-center">
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="stat-card text-center" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 20px; padding: 50px 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                        <div style="font-size: 4.5rem; font-weight: 700; color: #c9a227; line-height: 1;">750</div>
                        <div style="color: #fff; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 3px; margin-top: 15px;">{{ t('celebrations.guests') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Included Services Section -->
        <div style="background: linear-gradient(135deg, #f8f5f0 0%, #fff 100%); padding: 80px 0;">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="subheading">{{ t('celebrations.whats_included') }}</span>
                    <h2 class="section-title">{{ t('celebrations.wedding_packages') }}</h2>
                </div>
                
                <div class="row justify-content-center">
                    <div v-for="(service, index) in includedServices" :key="index" class="col-lg-4 col-md-6 mb-4">
                        <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 20px; transition: transform 0.3s ease;" class="service-card">
                            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #c9a227 0%, #d4af37 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i :class="service.icon" style="font-size: 28px; color: #fff;"></i>
                            </div>
                            <div>
                                <h5 style="margin: 0; color: #1a1a1a; font-size: 1.1rem;">{{ t('celebrations.' + service.key) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="container margin_120_95">
            <div class="text-center mb-5">
                <span class="subheading">{{ t('celebrations.our_gallery') }}</span>
                <h2 class="section-title">{{ t('celebrations.gallery_title') }}</h2>
            </div>
            
            <div class="row g-4">
                <div v-for="(img, index) in galleryImages" :key="index" class="col-lg-3 col-md-4 col-sm-6">
                    <div style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transition: transform 0.3s ease;" class="gallery-item">
                        <img :src="asset('img/' + img)" :alt="'Celebration ' + (index + 1)" style="width: 100%; height: 220px; object-fit: cover; display: block;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <div style="background: #111; padding: 80px 0;">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="subheading" style="color: #c9a227;">{{ t('celebrations.why_choose_us') }}</span>
                    <h2 style="color: #fff; font-size: 2.5rem;">{{ t('celebrations.perfect_venue') }}</h2>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div style="text-align: center; padding: 30px;">
                                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; border: 2px solid #c9a227; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-star" style="font-size: 32px; color: #c9a227;"></i>
                                    </div>
                                    <h5 style="color: #fff; margin-bottom: 10px;">{{ t('celebrations.elegant_spaces') }}</h5>
                                    <p style="color: #999; font-size: 14px;">{{ t('celebrations.elegant_spaces_desc') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div style="text-align: center; padding: 30px;">
                                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; border: 2px solid #c9a227; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-people" style="font-size: 32px; color: #c9a227;"></i>
                                    </div>
                                    <h5 style="color: #fff; margin-bottom: 10px;">{{ t('celebrations.expert_team') }}</h5>
                                    <p style="color: #999; font-size: 14px;">{{ t('celebrations.expert_team_desc') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div style="text-align: center; padding: 30px;">
                                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; border: 2px solid #c9a227; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-gem" style="font-size: 32px; color: #c9a227;"></i>
                                    </div>
                                    <h5 style="color: #fff; margin-bottom: 10px;">{{ t('celebrations.custom_packages') }}</h5>
                                    <p style="color: #999; font-size: 14px;">{{ t('celebrations.custom_packages_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="container margin_120_95" id="contact-form">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <span class="subheading">{{ t('celebrations.get_in_touch') }}</span>
                        <h2 class="section-title">{{ t('celebrations.plan_your_event') }}</h2>
                        <p style="color: #666;">
                            {{ t('celebrations.form_intro') }}
                        </p>
                    </div>

                    <!-- Success Message -->
                    <div v-if="showSuccess" class="alert mb-4" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 20px; border-radius: 10px; text-align: center;">
                        <i class="bi bi-check-circle-fill me-2" style="font-size: 1.5rem;"></i>
                        <strong>{{ successMessage }}</strong>
                    </div>

                    <form @submit.prevent="submit" style="background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 15px 50px rgba(0,0,0,0.1);">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="name" 
                                        v-model="form.name" 
                                        :placeholder="t('celebrations.your_name')"
                                        required
                                        :class="{ 'is-invalid': form.errors.name }"
                                    >
                                    <label for="name">{{ t('celebrations.your_name') }} *</label>
                                    <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="email" 
                                        v-model="form.email" 
                                        :placeholder="t('celebrations.your_email')"
                                        required
                                        :class="{ 'is-invalid': form.errors.email }"
                                    >
                                    <label for="email">{{ t('celebrations.your_email') }} *</label>
                                    <div v-if="form.errors.email" class="invalid-feedback">{{ form.errors.email }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input 
                                        type="tel" 
                                        class="form-control" 
                                        id="phone" 
                                        v-model="form.phone" 
                                        :placeholder="t('celebrations.phone')"
                                        :class="{ 'is-invalid': form.errors.phone }"
                                    >
                                    <label for="phone">{{ t('celebrations.phone') }}</label>
                                    <div v-if="form.errors.phone" class="invalid-feedback">{{ form.errors.phone }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <select 
                                        class="form-select" 
                                        id="event_type" 
                                        v-model="form.event_type"
                                        :class="{ 'is-invalid': form.errors.event_type }"
                                    >
                                        <option value="">{{ t('celebrations.select_event_type') }}</option>
                                        <option v-for="type in eventTypes" :key="type.value" :value="type.value">
                                            {{ t('celebrations.' + type.labelKey) }}
                                        </option>
                                    </select>
                                    <label for="event_type">{{ t('celebrations.event_type') }}</label>
                                    <div v-if="form.errors.event_type" class="invalid-feedback">{{ form.errors.event_type }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input 
                                        type="date" 
                                        class="form-control" 
                                        id="event_date" 
                                        v-model="form.event_date"
                                        :class="{ 'is-invalid': form.errors.event_date }"
                                    >
                                    <label for="event_date">{{ t('celebrations.event_date') }}</label>
                                    <div v-if="form.errors.event_date" class="invalid-feedback">{{ form.errors.event_date }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="guests" 
                                        v-model="form.guests"
                                        min="1"
                                        max="750"
                                        :placeholder="t('celebrations.number_of_guests')"
                                        :class="{ 'is-invalid': form.errors.guests }"
                                    >
                                    <label for="guests">{{ t('celebrations.number_of_guests') }}</label>
                                    <div v-if="form.errors.guests" class="invalid-feedback">{{ form.errors.guests }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="form-floating">
                                <textarea 
                                    class="form-control" 
                                    id="message" 
                                    v-model="form.message" 
                                    :placeholder="t('celebrations.your_message')"
                                    style="height: 150px;"
                                    required
                                    :class="{ 'is-invalid': form.errors.message }"
                                ></textarea>
                                <label for="message">{{ t('celebrations.your_message') }} *</label>
                                <div v-if="form.errors.message" class="invalid-feedback">{{ form.errors.message }}</div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button 
                                type="submit" 
                                class="btn_1 outline"
                                :disabled="form.processing"
                                style="min-width: 200px;"
                            >
                                <span v-if="form.processing">{{ t('celebrations.sending') }}</span>
                                <span v-else>{{ t('celebrations.send_inquiry') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.gallery-item:hover {
    transform: translateY(-5px);
}

.service-card:hover {
    transform: translateY(-3px);
}

.subheading {
    display: block;
    color: #c9a227;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 15px;
}

.section-title {
    font-size: 2.5rem;
    color: #1a1a1a;
    margin-bottom: 20px;
}
</style>
