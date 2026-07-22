<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';
import BookingSection from '@/Components/Frontend/BookingSection.vue';

const props = defineProps({
    page: Object,
    sections: Object,
    rooms: Array,
    settings: Object,
    seo: Object,
});

const { t } = useI18n();
const page = usePage();

const hero = props.sections?.hero;
const booking = props.sections?.booking;

const showSuccess = ref(false);
const successMessage = ref('');

const form = useForm({
    name: '',
    lastname: '',
    email: '',
    phone: '',
    message: '',
});

const bookingForm = useForm({
    room_id: '',
    adults: 1,
    children: 0,
    date_booking: '',
});

const submit = () => {
    form.post('/contacts', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            showSuccess.value = true;
            successMessage.value = page.props.flash?.success || t('contact.success_message');
            setTimeout(() => { showSuccess.value = false; }, 10000);
        },
    });
};

const asset = (path) => `/assets/paradise/${path}`;
</script>

<template>
    <Layout
        :title="seo?.title"
        :description="seo?.description"
        :keywords="seo?.keywords"
        :canonical="seo?.canonical"
        :schema="seo?.schema"
        :alternateUrls="seo?.alternateUrls"
        :hideBookingSection="true"
    >
        <!-- Hero Section -->
        <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img contact-hero-img" :src="asset('img/about-us-modified.webp')" alt="Hotel Aleksandar Palace">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small class="slide-animated one">{{ hero?.subtitle || t('contact.hero_subtitle') }}</small>
                    <h1 class="slide-animated two">{{ hero?.title || t('contact.hero_title') }}</h1>
                </div>
            </div>
        </div>

        <!-- Contact Info & Form Section -->
        <div class="container margin_120_95">
            <div class="row justify-content-between">
                <div class="col-xl-4 col-lg-5 order-lg-2">
                    <div class="contact_info">
                        <ul class="clearfix">
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <h4>{{ t('contact.address') }}</h4>
                                <div>Blvd. 8th September No. 15<br>Skopje, Macedonia</div>
                            </li>
                            <li>
                                <i class="bi bi-envelope-paper"></i>
                                <h4>{{ t('contact.email_label') }}</h4>
                                <p>
                                    <a href="mailto:info@aleksandarpalace.com.mk">info@aleksandarpalace.com.mk</a><br>
                                    <a href="mailto:sales@aleksandarpalace.com.mk">sales@aleksandarpalace.com.mk</a><br>
                                    <a href="mailto:spa@aleksandarpalace.com.mk">spa@aleksandarpalace.com.mk</a>
                                </p>
                            </li>
                            <li>
                                <i class="bi bi-telephone"></i>
                                <h4>{{ t('contact.phone') }}</h4>
                                <div>
                                    <a href="tel:+38923092392">+389 (2) 3092 392</a>
                                    <br><small>{{ $page.props.locale === 'mk' ? 'Понеделник до Недела 24/7' : 'Monday to Sunday 24/7' }}</small>
                                </div>
                            </li>
                            <li>
                                <i class="bi bi-share"></i>
                                <h4>{{ $page.props.locale === 'mk' ? 'Следете нè' : 'Follow Us' }}</h4>
                                <div class="social mt-2">
                                    <a href="https://www.facebook.com/hotelaleksandarpalace" target="_blank" rel="noopener" class="me-3"><i class="bi bi-facebook" style="font-size: 1.5rem;"></i></a>
                                    <a href="https://www.instagram.com/hotelaleksandarpalace/" target="_blank" rel="noopener"><i class="bi bi-instagram" style="font-size: 1.5rem;"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 order-lg-1">
                    <h3 class="mb-3">{{ t('contact.get_in_touch') }}</h3>
                    <!-- Success Message -->
                    <div v-if="showSuccess" class="alert alert-success mb-4" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px 20px; border-radius: 8px;">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ successMessage }}
                    </div>

                    <form @submit.prevent="submit" autocomplete="off">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-floating mb-4">
                                    <input class="form-control" type="text" id="name_contact" v-model="form.name" :placeholder="t('contact.name')" required>
                                    <label for="name_contact">{{ t('contact.name') }}</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating mb-4">
                                    <input class="form-control" type="text" id="lastname_contact" v-model="form.lastname" :placeholder="t('contact.last_name')">
                                    <label for="lastname_contact">{{ t('contact.last_name') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-floating mb-4">
                                    <input class="form-control" type="email" id="email_contact" v-model="form.email" :placeholder="t('contact.email')" required>
                                    <label for="email_contact">{{ t('contact.email') }}</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating mb-4">
                                    <input class="form-control" type="text" id="phone_contact" v-model="form.phone" :placeholder="t('contact.telephone')">
                                    <label for="phone_contact">{{ t('contact.telephone') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-4">
                            <textarea class="form-control" :placeholder="t('contact.message')" id="message_contact" v-model="form.message" required></textarea>
                            <label for="message_contact">{{ t('contact.message') }}</label>
                        </div>
                        <p class="mt-3">
                            <button type="submit" class="btn_1 outline" :disabled="form.processing">{{ t('contact.submit') }}</button>
                        </p>
                        <div v-if="Object.keys(form.errors).length" class="text-danger mt-2">
                            <div v-for="(error, key) in form.errors" :key="key">{{ error }}</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map_contact">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2964.2!2d21.4030225!3d42.0108086!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x135415a9bddf1df9%3A0x89a59404b305283f!2sHotel%20Aleksandar%20Palace!5e0!3m2!1sen!2smk!4v1700000000000"
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <!-- Distances Section - Dark Elegant Style -->
        <div style="background: #111; padding: 60px 0;">
            <div class="container">
                <!-- Row 1: 5 items evenly spaced -->
                <div style="display: flex; justify-content: space-between; text-align: center; margin-bottom: 50px; flex-wrap: wrap;">
                    <div style="flex: 0 0 20%; padding: 0 10px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.airport') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">23 km / 30 {{ t('contact.minutes') }}</p>
                    </div>
                    <div style="flex: 0 0 20%; padding: 0 10px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.railway_station') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">5 km / 10 {{ t('contact.minutes') }}</p>
                    </div>
                    <div style="flex: 0 0 20%; padding: 0 10px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.bus_station') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">5 km / 10 {{ t('contact.minutes') }}</p>
                    </div>
                    <div style="flex: 0 0 20%; padding: 0 10px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.city_center') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">3 km / 7 {{ t('contact.minutes') }}</p>
                    </div>
                    <div style="flex: 0 0 20%; padding: 0 10px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.city_park') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">0.1 km / 1 {{ t('contact.minute') }}</p>
                    </div>
                </div>

                <!-- Row 2: 3 items centered -->
                <div style="display: flex; justify-content: center; text-align: center; margin-bottom: 50px; gap: 80px; flex-wrap: wrap;">
                    <div style="min-width: 180px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.ski_center_mavrovo') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">{{ t('contact.hotel_bistra') }} 110 km</p>
                    </div>
                    <div style="min-width: 180px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.ohrid_lake') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">{{ t('contact.hotel_metropol') }} 185 km</p>
                    </div>
                    <div style="min-width: 180px;">
                        <i class="bi bi-grid-3x3-gap-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.airport_timetable') }}</h6>
                        <p style="margin: 0;"><a href="https://www.airports.com.mk" target="_blank" rel="noopener" style="color: #c9a227; font-size: 11px; font-style: italic;">www.airports.com.mk</a></p>
                    </div>
                </div>

                <!-- Row 3: 4 borders evenly spaced -->
                <div style="display: flex; justify-content: center; text-align: center; gap: 60px; flex-wrap: wrap;">
                    <div style="min-width: 140px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.border_with') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">{{ t('contact.serbia') }}: 47 km</p>
                    </div>
                    <div style="min-width: 140px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.border_with') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">{{ t('contact.bulgaria') }}: 134 km</p>
                    </div>
                    <div style="min-width: 140px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.border_with') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">{{ t('contact.greece') }}: 160 km</p>
                    </div>
                    <div style="min-width: 140px;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 28px; color: #c9a227; display: block; margin-bottom: 12px;"></i>
                        <h6 style="color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; font-weight: 400;">{{ t('contact.border_with') }}</h6>
                        <p style="color: #666; font-size: 11px; margin: 0; font-style: italic;">{{ t('contact.albania') }}: 192 km</p>
                    </div>
                </div>
            </div>
        </div>

        <BookingSection :rooms="rooms" />
    </Layout>
</template>

<style scoped>
.contact-hero-img {
    object-position: 80% 80% !important;
}
</style>
