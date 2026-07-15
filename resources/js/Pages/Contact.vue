<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';

const props = defineProps({
    page: Object,
    sections: Object,
    rooms: Array,
    settings: Object,
    seo: Object,
});

const { t } = useI18n();

const hero = props.sections?.hero;
const booking = props.sections?.booking;

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
        onSuccess: () => form.reset(),
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
    >
        <!-- Hero Section -->
        <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img" :src="hero?.image ? asset(hero.image) : asset('img/hero_home_2.jpg')" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small class="slide-animated one">{{ hero?.subtitle || 'Luxury Hotel Experience' }}</small>
                    <h1 class="slide-animated two">{{ hero?.title || 'Contact Us' }}</h1>
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
                                <h4>Address</h4>
                                <div v-html="settings?.address?.value || 'Bul. Ilinden 101, 1000 Skopje<br>North Macedonia'"></div>
                            </li>
                            <li>
                                <i class="bi bi-envelope-paper"></i>
                                <h4>Email address</h4>
                                <p>
                                    <a :href="`mailto:${settings?.booking_email?.value || 'booking@alexandarpalace.mk'}`">{{ settings?.booking_email?.value || 'booking@alexandarpalace.mk' }}</a> - 
                                    <a :href="`mailto:${settings?.email?.value || 'info@alexandarpalace.mk'}`">{{ settings?.email?.value || 'info@alexandarpalace.mk' }}</a>
                                </p>
                            </li>
                            <li>
                                <i class="bi bi-telephone"></i>
                                <h4>Telephone</h4>
                                <div>
                                    <a :href="`tel:${settings?.phone?.value || '+389 2 3092 392'}`">{{ settings?.phone?.value || '+389 2 3092 392' }}</a>
                                    <br><small>Monday to Friday 9am - 7pm</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 order-lg-1">
                    <h3 class="mb-3">Get in Touch</h3>
                    <div v-if="form.recentlySuccessful" class="alert alert-success">
                        Thank you for your message. We will get back to you soon!
                    </div>
                    <form @submit.prevent="submit" autocomplete="off">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-floating mb-4">
                                    <input class="form-control" type="text" id="name_contact" v-model="form.name" placeholder="Name" required>
                                    <label for="name_contact">Name</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating mb-4">
                                    <input class="form-control" type="text" id="lastname_contact" v-model="form.lastname" placeholder="Last Name">
                                    <label for="lastname_contact">Last name</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-floating mb-4">
                                    <input class="form-control" type="email" id="email_contact" v-model="form.email" placeholder="Email" required>
                                    <label for="email_contact">Email</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating mb-4">
                                    <input class="form-control" type="text" id="phone_contact" v-model="form.phone" placeholder="Telephone">
                                    <label for="phone_contact">Telephone</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-4">
                            <textarea class="form-control" placeholder="Message" id="message_contact" v-model="form.message" required></textarea>
                            <label for="message_contact">Message</label>
                        </div>
                        <p class="mt-3">
                            <button type="submit" class="btn_1 outline" :disabled="form.processing">Submit</button>
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
                :src="settings?.google_maps_embed?.value || 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2965.0824050865396!2d21.4254!3d41.9981!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDU5JzUzLjIiTiAyMcKwMjUnMzEuNCJF!5e0!3m2!1sen!2smk!4v1234567890'"
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <!-- Booking Section -->
        <div class="container margin_120_95" id="booking_section">
            <div class="row justify-content-between">
                <div class="col-xl-4">
                    <div data-cue="slideInUp">
                        <div class="title">
                            <small>{{ booking?.subtitle || 'Alexandar Palace Hotel' }}</small>
                            <h2>{{ booking?.title || 'Check Availability' }}</h2>
                        </div>
                        <p v-if="booking?.content" v-html="booking.content"></p>
                        <p v-else>Mea nibh meis philosophia eu. Duis legimus efficiantur ea sea. Id placerat tacimates definitionem sea, prima quidam vim no.</p>
                        <p class="phone_element no_borders">
                            <a :href="`tel:${settings?.phone?.value || '+389 2 3092 392'}`">
                                <i class="bi bi-telephone"></i>
                                <span><em>Info and bookings</em>{{ settings?.phone?.value || '+389 2 3092 392' }}</span>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div data-cue="slideInUp" data-delay="200">
                        <form @submit.prevent="bookingForm.post('/bookings')">
                            <div class="booking_wrapper pb-4">
                                <div class="col-12">
                                    <input type="hidden" id="contact_booking_dates" name="date_booking" v-model="bookingForm.date_booking">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="custom_select">
                                            <select v-model="bookingForm.room_id" class="wide">
                                                <option value="">Select Room</option>
                                                <option v-for="room in rooms" :key="room.id" :value="room.id">{{ room.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="qty-buttons version_2">
                                                    <input type="button" value="+" class="qtyplus" @click="bookingForm.adults++">
                                                    <input type="text" v-model="bookingForm.adults" class="qty form-control" placeholder="Adults">
                                                    <input type="button" value="-" class="qtyminus" @click="bookingForm.adults > 1 ? bookingForm.adults-- : null">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="qty-buttons version_2">
                                                    <input type="button" value="+" class="qtyplus" @click="bookingForm.children++">
                                                    <input type="text" v-model="bookingForm.children" class="qty form-control" placeholder="Childs">
                                                    <input type="button" value="-" class="qtyminus" @click="bookingForm.children > 0 ? bookingForm.children-- : null">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-end mt-4">
                                <button type="submit" class="btn_1 outline" :disabled="bookingForm.processing">Book Now</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
