<script setup>
import { ref, computed, nextTick, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { useForm, usePage } from '@inertiajs/vue3';
import Layout from '@/Components/Frontend/Layout.vue';

const { t } = useI18n();
const page = usePage();

const props = defineProps({
    seo: Object,
    courts: Object,
});

const activeTab = ref('sport');
const asset = (path) => `/assets/paradise/${path}`;
const successAlert = ref(null);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    booking_date: '',
    start_time: '',
    end_time: '',
    court_type: 'tennis',
    court_number: 1,
    players: 2,
    message: '',
});

const availableSlots = ref([]);
const loadingSlots = ref(false);
const selectedCourt = ref(null);

// Get courts for selected type
const courtsForType = computed(() => {
    if (!props.courts || !form.court_type) return [];
    return props.courts[form.court_type] || [];
});

// Watch for changes in court type, court number, or date to fetch available slots
watch([() => form.court_type, () => form.court_number, () => form.booking_date], async () => {
    if (form.court_type && form.court_number && form.booking_date) {
        await fetchAvailableSlots();
    } else {
        availableSlots.value = [];
    }
    // Reset time selection when changing court/date
    form.start_time = '';
    form.end_time = '';
});

// Update court number when court type changes
watch(() => form.court_type, () => {
    const courts = courtsForType.value;
    if (courts.length > 0) {
        form.court_number = courts[0].court_number;
        selectedCourt.value = courts[0];
    }
});

const fetchAvailableSlots = async () => {
    loadingSlots.value = true;
    try {
        const response = await fetch(`/activities/available-slots?court_type=${form.court_type}&court_number=${form.court_number}&date=${form.booking_date}`);
        const data = await response.json();
        availableSlots.value = data.slots || [];
    } catch (error) {
        console.error('Failed to fetch slots:', error);
        availableSlots.value = [];
    }
    loadingSlots.value = false;
};

const selectTimeSlot = (slot) => {
    form.start_time = slot;
    // Calculate end time based on slot duration
    const court = selectedCourt.value || courtsForType.value.find(c => c.court_number === form.court_number);
    const duration = court?.slot_duration || 60;
    const [hours, minutes] = slot.split(':').map(Number);
    const endDate = new Date(2000, 0, 1, hours, minutes + duration);
    form.end_time = `${String(endDate.getHours()).padStart(2, '0')}:${String(endDate.getMinutes()).padStart(2, '0')}`;
};

const submitBooking = () => {
    form.post('/activities/book', {
        preserveScroll: false,
        onSuccess: () => {
            form.reset();
            nextTick(() => {
                if (successAlert.value) {
                    successAlert.value.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        },
    });
};

const sportFeatures = [
    { icon: 'bi-person-badge', key: 'personal_instructor' },
    { icon: 'bi-heart-pulse', key: 'cardio_equipment' },
    { icon: 'bi-lightning', key: 'strength_training' },
    { icon: 'bi-arrows-expand', key: 'stretching_room' },
    { icon: 'bi-clipboard-check', key: 'supervised_nutrition' },
    { icon: 'bi-calendar-check', key: 'exercise_program' },
    { icon: 'bi-capsule', key: 'food_supplements' },
    { icon: 'bi-cup-hot', key: 'juice_coffee_bar' },
    { icon: 'bi-door-open', key: 'locker_facilities' },
    { icon: 'bi-thermometer-sun', key: 'sauna' },
    { icon: 'bi-hand-index-thumb', key: 'massage' },
];

const successMessage = computed(() => page.props.flash?.success);
</script>

<template>
    <Layout
        :title="seo?.title || t('activities.page_title')"
        :description="seo?.description"
    >
        <!-- Hero Section - Split Design -->
        <div class="hero-split">
            <div class="hero-half hero-sport" @click="activeTab = 'sport'">
                <img :src="asset('img/activities/teniszaweb.webp')" alt="Sport">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <i class="bi bi-dribbble"></i>
                    <h2>{{ t('activities.sport') }}</h2>
                    <p>{{ t('activities.sport_desc') }}</p>
                </div>
            </div>
            <div class="hero-half hero-spa" @click="activeTab = 'spa'">
                <img :src="asset('img/spa/DSC_4700-scaled.webp')" alt="SPA">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <i class="bi bi-droplet-half"></i>
                    <h2>{{ t('activities.spa') }}</h2>
                    <p>{{ t('activities.spa_tab_desc') }}</p>
                </div>
            </div>
            <div class="hero-center-title">
                <small>{{ t('activities.hero_subtitle') }}</small>
                <h1>{{ t('activities.hero_title') }}</h1>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <div class="container">
                <div class="tab-buttons">
                    <button 
                        :class="['tab-btn', { active: activeTab === 'sport' }]"
                        @click="activeTab = 'sport'"
                    >
                        <div class="tab-icon">
                            <i class="bi bi-dribbble"></i>
                        </div>
                        <div class="tab-text">
                            <span class="tab-label">{{ t('activities.sport') }}</span>
                            <span class="tab-desc">{{ t('activities.sport_desc') }}</span>
                        </div>
                    </button>
                    <button 
                        :class="['tab-btn', { active: activeTab === 'spa' }]"
                        @click="activeTab = 'spa'"
                    >
                        <div class="tab-icon">
                            <i class="bi bi-droplet-half"></i>
                        </div>
                        <div class="tab-text">
                            <span class="tab-label">{{ t('activities.spa') }}</span>
                            <span class="tab-desc">{{ t('activities.spa_tab_desc') }}</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sport Tab Content -->
        <div v-show="activeTab === 'sport'" class="tab-content">
            <!-- Tennis Courts Section -->
            <section class="courts-section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-5 mb-5 mb-lg-0" data-cue="slideInLeft">
                            <div class="section-content">
                                <span class="section-label">{{ t('activities.tennis_club') }}</span>
                                <h2 class="section-title">{{ t('activities.courts_title') }}</h2>
                                <p class="section-text">{{ t('activities.courts_desc') }}</p>
                                <div class="courts-list">
                                    <div class="court-item">
                                        <i class="bi bi-circle-fill"></i>
                                        <span>4 {{ t('activities.tennis_courts') }}</span>
                                    </div>
                                    <div class="court-item">
                                        <i class="bi bi-circle-fill"></i>
                                        <span>2 {{ t('activities.basketball_courts') }}</span>
                                    </div>
                                    <div class="court-item">
                                        <i class="bi bi-circle-fill"></i>
                                        <span>{{ t('activities.football_pitch') }}</span>
                                    </div>
                                </div>
                                <div class="schedule-box">
                                    <div class="schedule-item">
                                        <span class="schedule-time">08:00 - 22:00</span>
                                        <span class="schedule-days">{{ t('activities.everyday') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7" data-cue="slideInRight">
                            <div class="courts-gallery">
                                <div class="gallery-main">
                                    <img :src="asset('img/activities/teniski-teren-scaled.webp')" alt="Tennis Courts">
                                </div>
                                <div class="gallery-side">
                                    <div class="gallery-item">
                                        <img :src="asset('img/activities/athlete-holding-racket-ball-scaled-e1638379849163.webp')" alt="Tennis Player">
                                    </div>
                                    <div class="gallery-item">
                                        <img :src="asset('img/activities/kosarkarski-teren-scaled.webp')" alt="Basketball Court">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Image Showcase -->
            <section class="image-showcase">
                <div class="showcase-grid">
                    <div class="showcase-item" data-cue="fadeIn">
                        <img :src="asset('img/activities/edited5-scaled.webp')" alt="Sport Facilities">
                        <!-- <div class="showcase-overlay">
                            <span>{{ t('activities.tennis_courts') }}</span>
                        </div> -->
                    </div>
                    <div class="showcase-item" data-cue="fadeIn" data-delay="100">
                        <img :src="asset('img/activities/slika-9-440x550.webp')" alt="Tennis">
                        <!-- <div class="showcase-overlay">
                            <span>{{ t('activities.basketball_courts') }}</span>
                        </div> -->
                    </div>
                    <div class="showcase-item" data-cue="fadeIn" data-delay="200">
                        <img :src="asset('img/activities/slika-10-440x550.webp')" alt="Sport">
                        <!-- <div class="showcase-overlay">
                            <span>{{ t('activities.football_pitch') }}</span>
                        </div> -->
                    </div>
                    <div class="showcase-item" data-cue="fadeIn" data-delay="300">
                        <img :src="asset('img/activities/image00003-440x550.webp')" alt="Facilities">
                        <!-- <div class="showcase-overlay">
                            <span>{{ t('activities.our_facilities') }}</span>
                        </div> -->
                    </div>
                </div>
            </section>

            <!-- Fitness Section -->
            <section class="fitness-section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 order-lg-2 mb-5 mb-lg-0" data-cue="slideInRight">
                            <div class="section-content">
                                <span class="section-label">{{ t('activities.premium_fitness') }}</span>
                                <h2 class="section-title">{{ t('activities.fitness_title') }}</h2>
                                <p class="section-text">{{ t('activities.fitness_desc') }}</p>
                                <p class="section-text">{{ t('activities.fitness_desc2') }}</p>
                                <div class="schedule-box">
                                    <div class="schedule-item">
                                        <span class="schedule-time">06:30 - 22:00</span>
                                        <span class="schedule-days">{{ t('activities.monday_friday') }}</span>
                                    </div>
                                    <div class="schedule-item">
                                        <span class="schedule-time">09:00 - 20:00</span>
                                        <span class="schedule-days">{{ t('activities.saturday_sunday') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 order-lg-1" data-cue="slideInLeft">
                            <div class="fitness-gallery">
                                <div class="fitness-main">
                                    <img :src="asset('img/activities/Fitness3-440x550.webp')" alt="Fitness Center">
                                </div>
                                <div class="fitness-secondary">
                                    <img :src="asset('img/activities/Fitness2-440x550.webp')" alt="Gym Equipment">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Grid -->
            <section class="features-section">
                <div class="container">
                    <div class="text-center mb-5">
                        <span class="section-label">{{ t('activities.what_we_offer') }}</span>
                        <h2 class="section-title">{{ t('activities.our_facilities') }}</h2>
                    </div>
                    <div class="features-grid">
                        <div v-for="(feature, index) in sportFeatures" :key="index" class="feature-item" data-cue="fadeIn" :data-delay="index * 50">
                            <i :class="['bi', feature.icon]"></i>
                            <span>{{ t(`activities.${feature.key}`) }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Booking Section -->
            <section class="booking-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="booking-card" data-cue="fadeIn">
                                <div class="booking-header">
                                    <h2>{{ t('activities.book_court') }}</h2>
                                    <p>{{ t('activities.book_court_desc') }}</p>
                                </div>

                                <div v-if="successMessage" ref="successAlert" class="alert alert-success mb-4">
                                    {{ successMessage }}
                                </div>

                                <form @submit.prevent="submitBooking" class="booking-form">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ t('activities.your_name') }} *</label>
                                            <input 
                                                type="text" 
                                                v-model="form.name" 
                                                class="form-control"
                                                :class="{ 'is-invalid': form.errors.name }"
                                                required
                                            >
                                            <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ t('activities.your_email') }} *</label>
                                            <input 
                                                type="email" 
                                                v-model="form.email" 
                                                class="form-control"
                                                :class="{ 'is-invalid': form.errors.email }"
                                                required
                                            >
                                            <div v-if="form.errors.email" class="invalid-feedback">{{ form.errors.email }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ t('activities.phone') }}</label>
                                            <input 
                                                type="tel" 
                                                v-model="form.phone" 
                                                class="form-control"
                                            >
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ t('activities.court_type') }} *</label>
                                            <select v-model="form.court_type" class="form-select" required>
                                                <option value="tennis">{{ t('activities.tennis_court') }}</option>
                                                <option value="basketball">{{ t('activities.basketball_court') }}</option>
                                                <option value="football">{{ t('activities.football_field') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6" v-if="courtsForType.length > 1">
                                            <label class="form-label">{{ t('activities.select_court') || 'Select Court' }} *</label>
                                            <select v-model="form.court_number" class="form-select" required>
                                                <option v-for="court in courtsForType" :key="court.id" :value="court.court_number">
                                                    {{ court.name || `Court #${court.court_number}` }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ t('activities.date') }} *</label>
                                            <input 
                                                type="date" 
                                                v-model="form.booking_date" 
                                                class="form-control"
                                                :class="{ 'is-invalid': form.errors.booking_date }"
                                                :min="new Date().toISOString().split('T')[0]"
                                                required
                                            >
                                            <div v-if="form.errors.booking_date" class="invalid-feedback">{{ form.errors.booking_date }}</div>
                                        </div>
                                        
                                        <!-- Time Slot Selection -->
                                        <div class="col-12" v-if="form.booking_date">
                                            <label class="form-label">{{ t('activities.select_time') || 'Select Time Slot' }} *</label>
                                            <div v-if="loadingSlots" class="text-center py-3">
                                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <span class="ms-2">{{ t('activities.loading_slots') || 'Loading available slots...' }}</span>
                                            </div>
                                            <div v-else-if="availableSlots.length === 0" class="alert alert-warning">
                                                {{ t('activities.no_slots') || 'No available slots for this date. Please select another date.' }}
                                            </div>
                                            <div v-else class="time-slots-grid">
                                                <button 
                                                    v-for="slot in availableSlots" 
                                                    :key="slot"
                                                    type="button"
                                                    :class="['time-slot-btn', { 'active': form.start_time === slot }]"
                                                    @click="selectTimeSlot(slot)"
                                                >
                                                    {{ slot }}
                                                </button>
                                            </div>
                                            <div v-if="form.errors.start_time" class="text-danger small mt-2">{{ form.errors.start_time }}</div>
                                        </div>
                                        
                                        <!-- Selected Time Display -->
                                        <div class="col-12" v-if="form.start_time && form.end_time">
                                            <div class="selected-time-display">
                                                <i class="bi bi-clock me-2"></i>
                                                <strong>{{ t('activities.selected_time') || 'Selected' }}:</strong> 
                                                {{ form.start_time }} - {{ form.end_time }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ t('activities.number_of_players') }} *</label>
                                            <input 
                                                type="number" 
                                                v-model="form.players" 
                                                class="form-control"
                                                min="1"
                                                max="22"
                                                required
                                            >
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">{{ t('activities.message') }}</label>
                                            <textarea 
                                                v-model="form.message" 
                                                class="form-control"
                                                rows="3"
                                            ></textarea>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button 
                                                type="submit" 
                                                class="submit-btn"
                                                :disabled="form.processing"
                                            >
                                                <span v-if="form.processing">{{ t('activities.sending') }}</span>
                                                <span v-else>{{ t('activities.submit_booking') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="cta-section">
                <div class="container">
                    <div class="cta-content text-center">
                        <h2>{{ t('activities.come_visit') }}</h2>
                        <p>{{ t('activities.spend_quality_time') }}</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- SPA Tab Content -->
        <div v-show="activeTab === 'spa'" class="tab-content">
            <!-- SPA Intro Section -->
            <section class="spa-intro">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-5 mb-lg-0" data-cue="slideInLeft">
                            <div class="spa-intro-content">
                                <span class="section-label">{{ t('activities.spa') }} & Wellness</span>
                                <h2 class="section-title">{{ t('activities.spa_title') }}</h2>
                                <p class="spa-lead">{{ t('activities.spa_intro') }}</p>
                                <div class="schedule-box">
                                    <div class="schedule-item">
                                        <span class="schedule-time">06:00 - 22:00</span>
                                        <span class="schedule-days">{{ t('activities.monday_friday') }}</span>
                                    </div>
                                    <div class="schedule-item">
                                        <span class="schedule-time">09:00 - 20:00</span>
                                        <span class="schedule-days">{{ t('activities.saturday_sunday') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6" data-cue="slideInRight">
                            <div class="spa-intro-gallery">
                                <div class="spa-main-img">
                                    <img :src="asset('img/spa/DSC_4700-scaled.webp')" alt="SPA">
                                </div>
                                <div class="spa-floating-img">
                                    <img :src="asset('img/spa/spa_2.webp')" alt="Wellness">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SPA Services -->
            <section class="spa-services">
                <div class="container">
                    <div class="text-center mb-5">
                        <span class="section-label">{{ t('activities.our_services') }}</span>
                        <h2 class="section-title">{{ t('activities.spa_services_title') }}</h2>
                    </div>
                    <div class="spa-services-grid">
                        <!-- Hammam -->
                        <div class="spa-service-card" data-cue="fadeIn">
                            <div class="service-image">
                                <img :src="asset('img/spa/spa-banner-new-e1639394449773.webp')" alt="Hammam">
                            </div>
                            <div class="service-content">
                                <h3>{{ t('activities.hammam') }}</h3>
                                <p>{{ t('activities.hammam_desc') }}</p>
                            </div>
                        </div>
                        <!-- Massages -->
                        <div class="spa-service-card" data-cue="fadeIn" data-delay="100">
                            <div class="service-image">
                                <img :src="asset('img/spa/spa_3.webp')" alt="Massages">
                            </div>
                            <div class="service-content">
                                <h3>{{ t('activities.classical_massages') }}</h3>
                                <p>{{ t('activities.massages_desc') }}</p>
                            </div>
                        </div>
                        <!-- Treatments -->
                        <div class="spa-service-card" data-cue="fadeIn" data-delay="200">
                            <div class="service-image">
                                <img :src="asset('img/spa/873e369b-5891-4821-890e-efe4baecc851-scaled.webp')" alt="Treatments">
                            </div>
                            <div class="service-content">
                                <h3>{{ t('activities.facial_body') }}</h3>
                                <p>{{ t('activities.treatments_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SPA Gallery -->
            <section class="spa-gallery">
                <div class="spa-gallery-grid">
                    <div class="spa-gallery-item" data-cue="fadeIn">
                        <img :src="asset('img/spa/9b59dce9-a19c-4190-a02d-cf60d3867e73-scaled.webp')" alt="SPA">
                    </div>
                    <div class="spa-gallery-item" data-cue="fadeIn" data-delay="100">
                        <img :src="asset('img/spa/c96990e3-ab05-4df6-bf05-7594be3c1c63-2-scaled.webp')" alt="Wellness">
                    </div>
                    <div class="spa-gallery-item" data-cue="fadeIn" data-delay="200">
                        <img :src="asset('img/spa/spa_3.webp')" alt="Relaxation">
                    </div>
                </div>
            </section>

            <!-- SPA CTA -->
            <section class="spa-cta">
                <div class="container">
                    <div class="spa-cta-content text-center">
                        <h2>{{ t('activities.spa_cta_title') }}</h2>
                        <p>{{ t('activities.spa_cta_desc') }}</p>
                        <a href="/contacts" class="spa-cta-btn">{{ t('activities.book_appointment') }}</a>
                    </div>
                </div>
            </section>
        </div>

    </Layout>
</template>

<style scoped>
/* Split Hero */
.hero-split {
    display: flex;
    height: 70vh;
    min-height: 500px;
    position: relative;
}

.hero-half {
    flex: 1;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.hero-half img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease;
}

.hero-half:hover img {
    transform: scale(1.05);
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    transition: background 0.4s ease;
}

.hero-half:hover .hero-overlay {
    background: rgba(0, 0, 0, 0.3);
}

.hero-content {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #fff;
    padding: 30px;
    z-index: 2;
}

.hero-content i {
    font-size: 3rem;
    color: #c9a227;
    margin-bottom: 20px;
    opacity: 0.9;
}

.hero-content h2 {
    font-size: 2.5rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 4px;
    margin-bottom: 15px;
    color: #fff;
}

.hero-content p {
    font-size: 1rem;
    opacity: 0.8;
    letter-spacing: 1px;
    color: #fff;
}

.hero-center-title {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 10;
    background: rgba(0, 0, 0, 0.7);
    padding: 30px 60px;
    border-radius: 10px;
    backdrop-filter: blur(10px);
}

.hero-center-title small {
    display: block;
    font-size: 0.85rem;
    color: #c9a227;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 10px;
}

.hero-center-title h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 3px;
}

/* Divider line between halves */
.hero-split::after {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 100%;
    background: rgba(255, 255, 255, 0.3);
    z-index: 5;
}

/* Tab Navigation */
.tab-navigation {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    padding: 40px 0;
    margin-top: -5px;
}

.tab-buttons {
    display: flex;
    justify-content: center;
    gap: 30px;
}

.tab-btn {
    background: rgba(255,255,255,0.05);
    border: 2px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.7);
    padding: 30px 50px;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.4s ease;
    display: flex;
    align-items: center;
    gap: 20px;
    min-width: 280px;
}

.tab-btn:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(201, 162, 39, 0.3);
    transform: translateY(-3px);
}

.tab-btn.active {
    background: linear-gradient(135deg, rgba(201, 162, 39, 0.2) 0%, rgba(201, 162, 39, 0.1) 100%);
    border-color: #c9a227;
    box-shadow: 0 10px 40px rgba(201, 162, 39, 0.2);
}

.tab-icon {
    width: 60px;
    height: 60px;
    background: rgba(201, 162, 39, 0.15);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.tab-btn.active .tab-icon {
    background: #c9a227;
}

.tab-icon i {
    font-size: 1.8rem;
    color: #c9a227;
    transition: all 0.3s ease;
}

.tab-btn.active .tab-icon i {
    color: #fff;
}

.tab-text {
    text-align: left;
}

.tab-label {
    display: block;
    font-size: 1.3rem;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 5px;
}

.tab-btn.active .tab-label {
    color: #c9a227;
}

.tab-desc {
    display: block;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.5);
    font-weight: 400;
}

/* Section Styles */
.courts-section,
.fitness-section {
    padding: 100px 0;
}

.fitness-section {
    background: #f8f9fa;
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

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 25px;
}

.section-text {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #666;
    margin-bottom: 20px;
}

.courts-list {
    margin: 30px 0;
}

.court-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 1rem;
    color: #444;
}

.court-item i {
    font-size: 0.5rem;
    color: #c9a227;
}

.schedule-box {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 25px;
    margin-top: 30px;
}

.fitness-section .schedule-box {
    background: #fff;
}

.schedule-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.schedule-item:last-child {
    border-bottom: none;
}

.schedule-time {
    font-size: 1.2rem;
    font-weight: 700;
    color: #c9a227;
}

.schedule-days {
    font-size: 0.9rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Courts Gallery */
.courts-gallery {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 15px;
    height: 500px;
}

.gallery-main {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.12);
}

.gallery-main img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-main:hover img {
    transform: scale(1.05);
}

.gallery-side {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.gallery-item {
    flex: 1;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

/* Image Showcase */
.image-showcase {
    background: #1a1a1a;
    padding: 0;
}

.showcase-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}

.showcase-item {
    position: relative;
    height: 350px;
    overflow: hidden;
}

.showcase-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.showcase-item:hover img {
    transform: scale(1.1);
}

.showcase-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 60%);
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 30px;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.showcase-item:hover .showcase-overlay {
    opacity: 1;
}

.showcase-overlay span {
    color: #fff;
    font-size: 1.1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-bottom: 2px solid #c9a227;
    padding-bottom: 5px;
}

/* Fitness Gallery */
.fitness-gallery {
    position: relative;
    height: 500px;
}

.fitness-main {
    width: 85%;
    height: 100%;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.12);
}

.fitness-main img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.fitness-secondary {
    position: absolute;
    bottom: -30px;
    right: 0;
    width: 50%;
    height: 250px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    border: 5px solid #fff;
}

.fitness-secondary img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.courts-image,
.fitness-image {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.12);
}

.courts-image img,
.fitness-image img {
    width: 100%;
    height: 450px;
    object-fit: cover;
}

/* Features Section */
.features-section {
    padding: 100px 0;
    background: #fff;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.feature-item {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 25px 20px;
    text-align: center;
    transition: all 0.3s ease;
}

.feature-item:hover {
    background: #1a1a1a;
    color: #fff;
    transform: translateY(-5px);
}

.feature-item i {
    font-size: 2rem;
    color: #c9a227;
    margin-bottom: 15px;
    display: block;
}

.feature-item span {
    font-size: 0.9rem;
    font-weight: 500;
}

/* Booking Section */
.booking-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
}

.booking-card {
    background: #fff;
    border-radius: 20px;
    padding: 50px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.08);
}

.booking-header {
    text-align: center;
    margin-bottom: 40px;
}

.booking-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 10px;
}

.booking-header p {
    color: #666;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.form-control,
.form-select {
    border: 2px solid #eee;
    border-radius: 10px;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: #c9a227;
    box-shadow: 0 0 0 3px rgba(201, 162, 39, 0.1);
}

.submit-btn {
    background: linear-gradient(135deg, #c9a227 0%, #e8c547 100%);
    color: #fff;
    border: none;
    padding: 18px 60px;
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.4s ease;
}

.submit-btn:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(201, 162, 39, 0.4);
}

.submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* CTA Section */
.cta-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
}

.cta-content h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 15px;
}

.cta-content p {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.7);
}

/* SPA Sections */
.spa-intro {
    padding: 100px 0;
    background: #fff;
}

.spa-intro-content {
    padding-right: 30px;
}

.spa-lead {
    font-size: 1.15rem;
    line-height: 1.9;
    color: #555;
    font-style: italic;
}

.spa-intro-gallery {
    position: relative;
    height: 500px;
}

.spa-main-img {
    width: 90%;
    height: 100%;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.15);
}

.spa-main-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.spa-floating-img {
    position: absolute;
    bottom: -40px;
    right: 0;
    width: 45%;
    height: 220px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    border: 5px solid #fff;
}

.spa-floating-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* SPA Services */
.spa-services {
    padding: 100px 0;
    background: #f8f9fa;
}

.spa-services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.spa-service-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    transition: all 0.4s ease;
}

.spa-service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.15);
}

.service-image {
    height: 280px;
    overflow: hidden;
}

.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.spa-service-card:hover .service-image img {
    transform: scale(1.1);
}

.service-content {
    padding: 30px;
}

.service-content h3 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 15px;
}

.service-content p {
    font-size: 0.95rem;
    line-height: 1.7;
    color: #666;
    margin: 0;
}

/* SPA Gallery */
.spa-gallery {
    background: #1a1a1a;
}

.spa-gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
}

.spa-gallery-item {
    height: 350px;
    overflow: hidden;
}

.spa-gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.spa-gallery-item:hover img {
    transform: scale(1.1);
}

/* SPA CTA */
.spa-cta {
    padding: 100px 0;
    background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
}

.spa-cta-content h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 15px;
}

.spa-cta-content p {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.7);
    margin-bottom: 30px;
}

.spa-cta-btn {
    display: inline-block;
    background: linear-gradient(135deg, #c9a227 0%, #e8c547 100%);
    color: #fff;
    padding: 18px 50px;
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.4s ease;
}

.spa-cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(201, 162, 39, 0.4);
    color: #fff;
}

/* Responsive */
@media (max-width: 991px) {
    .hero-split {
        height: 60vh;
        min-height: 400px;
    }
    
    .hero-content h2 {
        font-size: 2rem;
    }
    
    .hero-content i {
        font-size: 2.5rem;
    }
    
    .hero-center-title {
        padding: 20px 40px;
    }
    
    .hero-center-title h1 {
        font-size: 2rem;
    }
    
    .tab-navigation {
        padding: 30px 0;
    }
    
    .tab-buttons {
        gap: 20px;
    }
    
    .tab-btn {
        padding: 20px 30px;
        min-width: 220px;
    }
    
    .tab-icon {
        width: 50px;
        height: 50px;
    }
    
    .tab-icon i {
        font-size: 1.5rem;
    }
    
    .tab-label {
        font-size: 1.1rem;
    }
    
    .features-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .courts-gallery {
        height: 400px;
    }
    
    .fitness-gallery {
        height: 400px;
    }
    
    .fitness-secondary {
        height: 200px;
    }
    
    .showcase-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .showcase-item {
        height: 280px;
    }
    
    .courts-image img,
    .fitness-image img {
        height: 350px;
    }
    
    .booking-card {
        padding: 30px;
    }
    
    .spa-services-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .spa-gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .spa-gallery-item {
        height: 280px;
    }
    
    .spa-intro-gallery {
        height: 400px;
    }
    
    .spa-floating-img {
        height: 180px;
    }
}

@media (max-width: 768px) {
    .hero-split {
        flex-direction: column;
        height: auto;
    }
    
    .hero-half {
        height: 50vh;
        min-height: 300px;
    }
    
    .hero-split::after {
        top: 50%;
        left: 0;
        width: 100%;
        height: 2px;
        transform: translateY(-50%);
    }
    
    .hero-center-title {
        padding: 15px 30px;
    }
    
    .hero-center-title h1 {
        font-size: 1.5rem;
        letter-spacing: 2px;
    }
    
    .hero-center-title small {
        font-size: 0.75rem;
    }
    
    .hero-content h2 {
        font-size: 1.8rem;
    }
    
    .hero-content p {
        font-size: 0.9rem;
    }
    
    .features-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .courts-gallery {
        grid-template-columns: 1fr;
        height: auto;
    }
    
    .gallery-main {
        height: 300px;
    }
    
    .gallery-side {
        flex-direction: row;
    }
    
    .gallery-item {
        height: 200px;
    }
    
    .fitness-gallery {
        height: auto;
    }
    
    .fitness-main {
        width: 100%;
        height: 350px;
    }
    
    .fitness-secondary {
        position: relative;
        bottom: 0;
        width: 100%;
        height: 200px;
        margin-top: 15px;
        border: none;
    }
    
    .spa-services-grid {
        grid-template-columns: 1fr;
    }
    
    .spa-intro-gallery {
        height: auto;
        margin-top: 30px;
    }
    
    .spa-main-img {
        width: 100%;
        height: 350px;
    }
    
    .spa-floating-img {
        position: relative;
        bottom: 0;
        width: 100%;
        height: 200px;
        margin-top: 15px;
        border: none;
    }
    
    .spa-gallery-grid {
        grid-template-columns: 1fr;
    }
    
    .spa-gallery-item {
        height: 250px;
    }
}

@media (max-width: 576px) {
    .tab-navigation {
        padding: 20px 0;
    }
    
    .tab-buttons {
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    
    .tab-btn {
        padding: 20px 25px;
        min-width: 100%;
        max-width: 320px;
    }
    
    .tab-icon {
        width: 45px;
        height: 45px;
    }
    
    .tab-icon i {
        font-size: 1.3rem;
    }
    
    .tab-label {
        font-size: 1rem;
    }
    
    .tab-desc {
        font-size: 0.75rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .showcase-grid {
        grid-template-columns: 1fr;
    }
    
    .showcase-item {
        height: 250px;
    }
    
    .gallery-side {
        flex-direction: column;
    }
    
    .courts-section,
    .fitness-section,
    .features-section,
    .booking-section {
        padding: 60px 0;
    }
}

/* Time Slots Grid */
.time-slots-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 10px;
    margin-top: 10px;
}

.time-slot-btn {
    padding: 12px 8px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    background: #fff;
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    transition: all 0.2s ease;
}

.time-slot-btn:hover {
    border-color: #c9a961;
    background: #faf8f5;
}

.time-slot-btn.active {
    border-color: #c9a961;
    background: #c9a961;
    color: #fff;
}

.selected-time-display {
    background: #f0f7f0;
    border: 1px solid #c3e6c3;
    border-radius: 8px;
    padding: 12px 16px;
    color: #2d6a2d;
    font-size: 0.95rem;
}

@media (max-width: 576px) {
    .time-slots-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .time-slot-btn {
        padding: 10px 6px;
        font-size: 0.85rem;
    }
}
</style>
