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
    subject: '',
    message: '',
});

const submit = () => {
    form.post('/congress/contact', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            showSuccess.value = true;
            successMessage.value = page.props.flash?.success || 'Thank you for your inquiry! We will get back to you as soon as possible.';
            setTimeout(() => { showSuccess.value = false; }, 10000);
        },
    });
};

const asset = (path) => `/assets/paradise/${path}`;

const congressImages = [
    'congress/Kongresnasala1-400x300.jpg',
    'congress/Kongresnasala4-400x300.jpg',
    'congress/Cinema-stylee-300-n-400x300.jpg',
    'congress/PFZ_0395pp-400x300.jpg',
    'congress/kongress.centar-gallery-5-400x300.jpg',
    'congress/kongress.centar-gallery-6-400x300.jpg',
    'congress/Kongresnisali123-pozadina-2-400x300.jpg',
    'congress/4c393ec8-81ca-48ec-ae86-9d7952352265-400x300.jpg',
];

const meetingRoomImages = [
    'congress-rooms/DSC_2972-400x400.jpg',
    'congress-rooms/DSC_3352-400x400.jpg',
    'congress-rooms/DSC_7644-400x400.jpg',
];

const roomSetups = [
    { name: 'Cinema', icon: 'cinema' },
    { name: 'Banquette', icon: 'banquette' },
    { name: 'Classroom', icon: 'classroom' },
    { name: 'U Style', icon: 'ustyle' },
    { name: 'Reception', icon: 'reception' },
];

const equipment = [
    { name: 'Infrared simultaneous translation system', icon: 'bi-broadcast' },
    { name: 'Receivers', icon: 'bi-headphones' },
    { name: 'Microphones in conference system', icon: 'bi-mic' },
    { name: 'Wireless microphones', icon: 'bi-mic-fill' },
    { name: 'Computers', icon: 'bi-pc-display' },
    { name: 'Computers with internet connection', icon: 'bi-pc-display-horizontal' },
    { name: 'Analog telephone line/internet', icon: 'bi-telephone' },
    { name: 'Photocopy machines', icon: 'bi-printer' },
    { name: 'Wireless internet', icon: 'bi-wifi' },
    { name: 'LCD projectors', icon: 'bi-projector' },
    { name: 'Telephone / Fax', icon: 'bi-telephone-forward' },
    { name: 'Screens', icon: 'bi-display' },
    { name: 'Audio Recording', icon: 'bi-record-circle' },
    { name: 'Flip Charts', icon: 'bi-easel' },
    { name: 'Audio Equipment', icon: 'bi-speaker' },
    { name: 'Piano', icon: 'bi-music-note-beamed' },
];
</script>

<template>
    <Layout
        :title="seo?.title || 'Congress Center'"
        :description="seo?.description"
        :hideBookingSection="true"
    >
        <!-- Hero Section -->
        <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img" :src="asset('img/congress/Kongresnasala1-400x300.jpg')" alt="Congress Center">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.6)">
                <div class="container">
                    <small class="slide-animated one">{{ t('congress.hero_subtitle') }}</small>
                    <h1 class="slide-animated two">{{ t('congress.hero_title') }}</h1>
                </div>
            </div>
        </div>

        <!-- Introduction Section -->
        <div class="container margin_120_95">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <span class="subheading">{{ t('congress.business_excellence') }}</span>
                    <h2 class="section-title">{{ t('congress.world_class_facilities') }}</h2>
                    <p class="lead" style="color: #666; font-size: 1.25rem; line-height: 1.8;">
                        {{ t('congress.intro_text') }}
                    </p>
                </div>
            </div>

            <!-- Stats -->
            <div class="row mt-5 justify-content-center">
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="stat-card text-center" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 20px; padding: 50px 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                        <div style="font-size: 4.5rem; font-weight: 700; color: #c9a227; line-height: 1;">750</div>
                        <div style="color: #fff; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 3px; margin-top: 15px;">{{ t('congress.persons_banquets') }}</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="stat-card text-center" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 20px; padding: 50px 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                        <div style="font-size: 4.5rem; font-weight: 700; color: #c9a227; line-height: 1;">1500</div>
                        <div style="color: #fff; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 3px; margin-top: 15px;">{{ t('congress.persons_conferences') }}</div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 justify-content-center">
                <div class="col-lg-8 text-center">
                    <p style="color: #666; font-size: 1.1rem; font-style: italic;">
                        {{ t('congress.hall_division_text') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Room Setups Section -->
        <div style="background: #111; padding: 80px 0;">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="subheading" style="color: #c9a227;">{{ t('congress.flexible_configurations') }}</span>
                    <h2 style="color: #fff; font-size: 2.5rem;">{{ t('congress.room_setup_options') }}</h2>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
                            <!-- Cinema -->
                            <div style="flex: 1; min-width: 160px; text-align: center; padding: 0 15px;">
                                <h6 style="color: #c9a227; font-size: 13px; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 30px; font-weight: 400;">{{ t('congress.cinema') }}</h6>
                                <svg width="90" height="100" viewBox="0 0 90 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Screen at top -->
                                    <rect x="10" y="5" width="70" height="6" rx="1" fill="#c9a227"/>
                                    <!-- Row 1 -->
                                    <circle cx="22" cy="30" r="6" fill="#c9a227"/>
                                    <circle cx="38" cy="30" r="6" fill="#c9a227"/>
                                    <circle cx="54" cy="30" r="6" fill="#c9a227"/>
                                    <circle cx="70" cy="30" r="6" fill="#c9a227"/>
                                    <!-- Row 2 -->
                                    <circle cx="22" cy="48" r="6" fill="#c9a227"/>
                                    <circle cx="38" cy="48" r="6" fill="#c9a227"/>
                                    <circle cx="54" cy="48" r="6" fill="#c9a227"/>
                                    <circle cx="70" cy="48" r="6" fill="#c9a227"/>
                                    <!-- Row 3 -->
                                    <circle cx="22" cy="66" r="6" fill="#c9a227"/>
                                    <circle cx="38" cy="66" r="6" fill="#c9a227"/>
                                    <circle cx="54" cy="66" r="6" fill="#c9a227"/>
                                    <circle cx="70" cy="66" r="6" fill="#c9a227"/>
                                    <!-- Row 4 -->
                                    <circle cx="22" cy="84" r="6" fill="#c9a227"/>
                                    <circle cx="38" cy="84" r="6" fill="#c9a227"/>
                                    <circle cx="54" cy="84" r="6" fill="#c9a227"/>
                                    <circle cx="70" cy="84" r="6" fill="#c9a227"/>
                                </svg>
                            </div>
                            
                            <!-- Banquette -->
                            <div style="flex: 1; min-width: 160px; text-align: center; padding: 0 15px;">
                                <h6 style="color: #c9a227; font-size: 13px; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 30px; font-weight: 400;">{{ t('congress.banquette') }}</h6>
                                <svg width="90" height="100" viewBox="0 0 90 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Center table -->
                                    <circle cx="45" cy="50" r="22" fill="#c9a227"/>
                                    <!-- Chairs around -->
                                    <circle cx="45" cy="18" r="6" fill="#c9a227"/>
                                    <circle cx="68" cy="27" r="6" fill="#c9a227"/>
                                    <circle cx="77" cy="50" r="6" fill="#c9a227"/>
                                    <circle cx="68" cy="73" r="6" fill="#c9a227"/>
                                    <circle cx="45" cy="82" r="6" fill="#c9a227"/>
                                    <circle cx="22" cy="73" r="6" fill="#c9a227"/>
                                    <circle cx="13" cy="50" r="6" fill="#c9a227"/>
                                    <circle cx="22" cy="27" r="6" fill="#c9a227"/>
                                </svg>
                            </div>
                            
                            <!-- Classroom -->
                            <div style="flex: 1; min-width: 160px; text-align: center; padding: 0 15px;">
                                <h6 style="color: #c9a227; font-size: 13px; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 30px; font-weight: 400;">{{ t('congress.classroom') }}</h6>
                                <svg width="90" height="100" viewBox="0 0 90 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Row 1 tables -->
                                    <rect x="10" y="15" width="28" height="10" rx="2" fill="#c9a227"/>
                                    <rect x="52" y="15" width="28" height="10" rx="2" fill="#c9a227"/>
                                    <!-- Row 1 chairs -->
                                    <circle cx="18" cy="38" r="5" fill="#c9a227"/>
                                    <circle cx="32" cy="38" r="5" fill="#c9a227"/>
                                    <circle cx="58" cy="38" r="5" fill="#c9a227"/>
                                    <circle cx="72" cy="38" r="5" fill="#c9a227"/>
                                    <!-- Row 2 tables -->
                                    <rect x="10" y="52" width="28" height="10" rx="2" fill="#c9a227"/>
                                    <rect x="52" y="52" width="28" height="10" rx="2" fill="#c9a227"/>
                                    <!-- Row 2 chairs -->
                                    <circle cx="18" cy="75" r="5" fill="#c9a227"/>
                                    <circle cx="32" cy="75" r="5" fill="#c9a227"/>
                                    <circle cx="58" cy="75" r="5" fill="#c9a227"/>
                                    <circle cx="72" cy="75" r="5" fill="#c9a227"/>
                                </svg>
                            </div>
                            
                            <!-- U Style -->
                            <div style="flex: 1; min-width: 160px; text-align: center; padding: 0 15px;">
                                <h6 style="color: #c9a227; font-size: 13px; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 30px; font-weight: 400;">{{ t('congress.u_style') }}</h6>
                                <svg width="90" height="100" viewBox="0 0 90 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- U-shaped table -->
                                    <rect x="15" y="15" width="12" height="55" rx="2" fill="#c9a227"/>
                                    <rect x="15" y="58" width="60" height="12" rx="2" fill="#c9a227"/>
                                    <rect x="63" y="15" width="12" height="55" rx="2" fill="#c9a227"/>
                                    <!-- Left chairs -->
                                    <circle cx="8" cy="25" r="5" fill="#c9a227"/>
                                    <circle cx="8" cy="40" r="5" fill="#c9a227"/>
                                    <circle cx="8" cy="55" r="5" fill="#c9a227"/>
                                    <!-- Right chairs -->
                                    <circle cx="82" cy="25" r="5" fill="#c9a227"/>
                                    <circle cx="82" cy="40" r="5" fill="#c9a227"/>
                                    <circle cx="82" cy="55" r="5" fill="#c9a227"/>
                                    <!-- Bottom chairs -->
                                    <circle cx="35" cy="82" r="5" fill="#c9a227"/>
                                    <circle cx="55" cy="82" r="5" fill="#c9a227"/>
                                </svg>
                            </div>
                            
                            <!-- Reception -->
                            <div style="flex: 1; min-width: 160px; text-align: center; padding: 0 15px;">
                                <h6 style="color: #c9a227; font-size: 13px; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 30px; font-weight: 400;">{{ t('congress.reception') }}</h6>
                                <svg width="90" height="100" viewBox="0 0 45 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Cocktail glass -->
                                    <polygon points="22.5,8 38,75 22.5,62 7,75" fill="#c9a227"/>
                                    <rect x="19" y="75" width="7" height="18" fill="#c9a227"/>
                                    <rect x="10" y="90" width="25" height="4" rx="1" fill="#c9a227"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="container margin_120_95">
            <div class="text-center mb-5">
                <span class="subheading">{{ t('congress.our_venues') }}</span>
                <h2 class="section-title">{{ t('congress.gallery_title') }}</h2>
            </div>
            
            <div class="row g-4">
                <div v-for="(img, index) in congressImages" :key="index" class="col-lg-3 col-md-4 col-sm-6">
                    <div style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transition: transform 0.3s ease;" class="gallery-item">
                        <img :src="asset('img/' + img)" :alt="'Congress Hall ' + (index + 1)" style="width: 100%; height: 220px; object-fit: cover; display: block;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Meeting Rooms Section -->
        <div style="background: #f8f8f8; padding: 80px 0;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <span class="subheading">{{ t('congress.business_meetings') }}</span>
                        <h2 class="section-title">{{ t('congress.meeting_rooms') }}</h2>
                        <p style="color: #666; font-size: 1.1rem; line-height: 1.8;">
                            {{ t('congress.meeting_rooms_text') }}
                        </p>
                        <ul style="list-style: none; padding: 0; margin-top: 25px;">
                            <li style="padding: 10px 0; border-bottom: 1px solid #eee; display: flex; align-items: center;">
                                <i class="bi bi-check-circle-fill" style="color: #c9a227; margin-right: 12px;"></i>
                                <span>{{ t('congress.capacity_10_60') }}</span>
                            </li>
                            <li style="padding: 10px 0; border-bottom: 1px solid #eee; display: flex; align-items: center;">
                                <i class="bi bi-check-circle-fill" style="color: #c9a227; margin-right: 12px;"></i>
                                <span>{{ t('congress.modern_av') }}</span>
                            </li>
                            <li style="padding: 10px 0; border-bottom: 1px solid #eee; display: flex; align-items: center;">
                                <i class="bi bi-check-circle-fill" style="color: #c9a227; margin-right: 12px;"></i>
                                <span>{{ t('congress.high_speed_wifi') }}</span>
                            </li>
                            <li style="padding: 10px 0; display: flex; align-items: center;">
                                <i class="bi bi-check-circle-fill" style="color: #c9a227; margin-right: 12px;"></i>
                                <span>{{ t('congress.catering_available') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-7">
                        <div class="row g-3">
                            <div v-for="(img, index) in meetingRoomImages" :key="index" class="col-md-4">
                                <div style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                    <img :src="asset('img/' + img)" :alt="'Meeting Room ' + (index + 1)" style="width: 100%; height: 200px; object-fit: cover; display: block;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Section -->
        <div style="background: #111; padding: 80px 0;">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="subheading" style="color: #c9a227;">{{ t('congress.professional_setup') }}</span>
                    <h2 style="color: #fff; font-size: 2.5rem;">{{ t('congress.additional_equipment') }}</h2>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row">
                            <div v-for="(item, index) in equipment" :key="index" class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div style="display: flex; align-items: center; padding: 15px; background: rgba(255,255,255,0.03); border-radius: 10px; border: 1px solid rgba(201,162,39,0.2); transition: all 0.3s ease;" class="equipment-item">
                                    <i :class="item.icon" style="font-size: 28px; color: #c9a227; margin-right: 15px; min-width: 35px;"></i>
                                    <span style="color: #fff; font-size: 13px; line-height: 1.4;">{{ item.name }}</span>
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
                        <span class="subheading">{{ t('congress.get_in_touch') }}</span>
                        <h2 class="section-title">{{ t('congress.request_info') }}</h2>
                        <p style="color: #666;">
                            {{ t('congress.form_intro') }}
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
                                        :placeholder="t('congress.your_name')"
                                        required
                                        :class="{ 'is-invalid': form.errors.name }"
                                    >
                                    <label for="name">{{ t('congress.your_name') }} *</label>
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
                                        :placeholder="t('congress.your_email')"
                                        required
                                        :class="{ 'is-invalid': form.errors.email }"
                                    >
                                    <label for="email">{{ t('congress.your_email') }} *</label>
                                    <div v-if="form.errors.email" class="invalid-feedback">{{ form.errors.email }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="form-floating">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="subject" 
                                    v-model="form.subject" 
                                    :placeholder="t('congress.subject')"
                                    required
                                    :class="{ 'is-invalid': form.errors.subject }"
                                >
                                <label for="subject">{{ t('congress.subject') }} *</label>
                                <div v-if="form.errors.subject" class="invalid-feedback">{{ form.errors.subject }}</div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="form-floating">
                                <textarea 
                                    class="form-control" 
                                    id="message" 
                                    v-model="form.message" 
                                    :placeholder="t('congress.your_message')"
                                    style="height: 150px;"
                                    required
                                    :class="{ 'is-invalid': form.errors.message }"
                                ></textarea>
                                <label for="message">{{ t('congress.your_message') }} *</label>
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
                                <span v-if="form.processing">{{ t('congress.sending') }}</span>
                                <span v-else>{{ t('congress.send_inquiry') }}</span>
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

.equipment-item:hover {
    background: rgba(201,162,39,0.1) !important;
    border-color: rgba(201,162,39,0.5) !important;
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
