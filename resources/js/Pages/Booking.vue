<script setup>
import { computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Components/Frontend/Layout.vue';

const props = defineProps({
    rooms: Array,
    selectedRoomId: Number,
    bookingDefaults: { type: Object, default: () => ({}) },
    seo: Object,
});

const asset = (path) => `/assets/paradise/${path}`;

const form = useForm({
    room_id: props.selectedRoomId || '',
    name: '',
    last_name: '',
    email: '',
    phone: '',
    check_in: props.bookingDefaults.check_in || '',
    check_out: props.bookingDefaults.check_out || '',
    adults: props.bookingDefaults.adults || 1,
    children: props.bookingDefaults.children || 0,
    special_requests: '',
});

const selectedRoom = computed(() => props.rooms.find((room) => room.id === Number(form.room_id)));

const nights = computed(() => {
    if (!form.check_in || !form.check_out) return 0;

    const checkIn = new Date(`${form.check_in}T00:00:00`);
    const checkOut = new Date(`${form.check_out}T00:00:00`);
    const difference = Math.round((checkOut - checkIn) / 86400000);

    return difference > 0 ? difference : 0;
});

const totalPrice = computed(() => {
    if (!selectedRoom.value || !nights.value) return 0;
    return Number(selectedRoom.value.discounted_price || selectedRoom.value.price_per_night) * nights.value;
});

const formatPrice = (price) => Number(price).toFixed(2);

const submit = () => {
    form.post('/bookings', { preserveScroll: true });
};
</script>

<template>
    <Layout
        :title="seo.title"
        :description="seo.description"
        :keywords="seo.keywords"
        :image="seo.image"
        :canonical="seo.canonical"
        :schema="seo.schema"
        :alternateUrls="seo.alternateUrls"
    >
        <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img" :src="asset(selectedRoom?.featured_image || 'img/hero_home_1.jpg')" alt="Reservation">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.55)">
                <div class="container">
                    <small class="slide-animated one">Alexandar Palace Hotel</small>
                    <h1 class="slide-animated two">Request a Reservation</h1>
                    <p class="slide-animated three">We will review your request and reply as soon as possible.</p>
                </div>
            </div>
        </div>

        <div class="container margin_120_95">
            <div v-if="$page.props.flash?.success" class="booking-success">
                <div class="success-envelope" aria-hidden="true">
                    <div class="envelope-flap"></div>
                    <div class="envelope-letter">
                        <span>A</span>
                    </div>
                </div>
                <small>Alexandar Palace Hotel</small>
                <h2>Your request is on its way</h2>
                <p>{{ $page.props.flash.success }}</p>
                <p>Our reservations team will review the details and contact you as soon as possible.</p>
                <Link href="/rooms" class="btn_1 outline mt-3">Explore Rooms & Suites</Link>
            </div>
            <div v-else class="row justify-content-between">
                <div class="col-lg-4 order-lg-2 mb-5 mb-lg-0">
                    <div class="booking-summary">
                        <h3>Your stay</h3>
                        <div v-if="selectedRoom" class="selected-room">
                            <img :src="asset(selectedRoom.featured_image)" :alt="selectedRoom.name">
                            <h4>{{ selectedRoom.name }}</h4>
                            <p>From €{{ formatPrice(selectedRoom.discounted_price || selectedRoom.price_per_night) }} per night</p>
                        </div>
                        <div v-if="selectedRoom && nights > 0" class="price-breakdown">
                            <div><span>Nights</span><strong>{{ nights }}</strong></div>
                            <div><span>Rate per night</span><strong>€{{ formatPrice(selectedRoom.discounted_price || selectedRoom.price_per_night) }}</strong></div>
                            <div class="total"><span>Estimated total</span><strong>€{{ formatPrice(totalPrice) }}</strong></div>
                        </div>
                        <p class="mb-0">Your reservation is not confirmed until you receive a confirmation email from our team.</p>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="title mb-4">
                        <small>Reservation details</small>
                        <h2>Plan your stay</h2>
                    </div>

                    <form @submit.prevent="submit" novalidate>
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="room_id" class="form-label">Room or Suite</label>
                                <select id="room_id" v-model="form.room_id" class="form-select" required>
                                    <option value="" disabled>Select a room or suite</option>
                                    <option v-for="room in rooms" :key="room.id" :value="room.id">{{ room.name }} — from €{{ room.price_per_night }}/night</option>
                                </select>
                                <div v-if="form.errors.room_id" class="field-error">{{ form.errors.room_id }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="check_in" class="form-label">Check-in</label>
                                <input id="check_in" v-model="form.check_in" type="date" class="form-control" :min="new Date().toISOString().split('T')[0]" required>
                                <div v-if="form.errors.check_in" class="field-error">{{ form.errors.check_in }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="check_out" class="form-label">Check-out</label>
                                <input id="check_out" v-model="form.check_out" type="date" class="form-control" :min="form.check_in || new Date().toISOString().split('T')[0]" required>
                                <div v-if="form.errors.check_out" class="field-error">{{ form.errors.check_out }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="adults" class="form-label">Adults</label>
                                <input id="adults" v-model.number="form.adults" type="number" min="1" max="10" class="form-control" required>
                                <div v-if="form.errors.adults" class="field-error">{{ form.errors.adults }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="children" class="form-label">Children</label>
                                <input id="children" v-model.number="form.children" type="number" min="0" max="10" class="form-control" required>
                                <div v-if="form.errors.children" class="field-error">{{ form.errors.children }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">First name</label>
                                <input id="name" v-model="form.name" type="text" autocomplete="given-name" class="form-control" required>
                                <div v-if="form.errors.name" class="field-error">{{ form.errors.name }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="last_name" class="form-label">Last name</label>
                                <input id="last_name" v-model="form.last_name" type="text" autocomplete="family-name" class="form-control" required>
                                <div v-if="form.errors.last_name" class="field-error">{{ form.errors.last_name }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">Email address</label>
                                <input id="email" v-model="form.email" type="email" autocomplete="email" class="form-control" required>
                                <div v-if="form.errors.email" class="field-error">{{ form.errors.email }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="phone" class="form-label">Phone number</label>
                                <input id="phone" v-model="form.phone" type="tel" autocomplete="tel" class="form-control" required>
                                <div v-if="form.errors.phone" class="field-error">{{ form.errors.phone }}</div>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="special_requests" class="form-label">Special requests <span class="text-muted">(optional)</span></label>
                                <textarea id="special_requests" v-model="form.special_requests" class="form-control" rows="4" placeholder="Arrival time, accessibility requirements, or other requests"></textarea>
                                <div v-if="form.errors.special_requests" class="field-error">{{ form.errors.special_requests }}</div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-3 align-items-center">
                            <button type="submit" class="btn_1" :disabled="form.processing">
                                {{ form.processing ? 'Sending request…' : 'Send Reservation Request' }}
                            </button>
                            <Link href="/rooms" class="animated_link"><strong>Back to Rooms</strong></Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.booking-summary { background: #f5f2ec; padding: 32px; }
.booking-summary h3 { margin-bottom: 24px; }
.selected-room { border-bottom: 1px solid #d8d1c5; margin-bottom: 24px; padding-bottom: 20px; }
.selected-room img { width: 100%; height: 180px; object-fit: cover; margin-bottom: 16px; }
.selected-room h4 { margin-bottom: 5px; }
.selected-room p { margin: 0; color: #8f7952; }
.price-breakdown { border-bottom: 1px solid #d8d1c5; margin-bottom: 24px; padding-bottom: 18px; }
.price-breakdown > div { display: flex; justify-content: space-between; margin-bottom: 10px; }
.price-breakdown .total { border-top: 1px solid #d8d1c5; color: #4b514d; font-size: 1.1rem; margin-top: 14px; padding-top: 14px; }
.form-label { display: block; font-weight: 600; margin-bottom: 8px; }
.form-control, .form-select { border: 1px solid #dedede; border-radius: 0; min-height: 52px; }
textarea.form-control { min-height: auto; }
.field-error { color: #b42318; font-size: .875rem; margin-top: 6px; }
.booking-success { margin: 0 auto; max-width: 620px; padding: 40px 20px; text-align: center; }
.booking-success small { color: #626262; font-size: .75rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; }
.booking-success h2 { font-size: clamp(2rem, 5vw, 3.25rem); margin: 18px 0; }
.booking-success p { color: #5c5c5c; font-size: 1.05rem; margin: 0 auto 10px; max-width: 520px; }
.success-envelope { height: 160px; margin: 0 auto 34px; perspective: 800px; position: relative; width: 230px; }
.success-envelope::before { background: #393939; bottom: 0; content: ''; height: 120px; left: 0; position: absolute; right: 0; }
.success-envelope::after { border-color: transparent transparent #555; border-style: solid; border-width: 0 115px 70px; bottom: 0; content: ''; height: 0; left: 0; position: absolute; width: 0; }
.envelope-flap { border-color: #454545 transparent transparent; border-style: solid; border-width: 72px 115px 0; height: 0; left: 0; position: absolute; top: 40px; transform-origin: top; transform: rotateX(0); width: 0; z-index: 3; animation: envelope-open .8s cubic-bezier(.2,.8,.2,1) .2s both; }
.envelope-letter { align-items: center; background: #fff; box-shadow: 0 10px 20px rgba(0,0,0,.12); display: flex; height: 120px; justify-content: center; left: 15px; position: absolute; top: 28px; transform: translateY(0); width: 200px; z-index: 2; animation: letter-rise .9s cubic-bezier(.2,.8,.2,1) .5s both; }
.envelope-letter span { border: 1px solid #424242; border-radius: 50%; color: #424242; font-family: Georgia, serif; font-size: 2rem; height: 54px; line-height: 52px; width: 54px; }
@keyframes envelope-open { to { opacity: 0; transform: rotateX(-180deg); } }
@keyframes letter-rise { to { transform: translateY(-38px); } }
@media (prefers-reduced-motion: reduce) { .envelope-flap, .envelope-letter { animation: none; } }
</style>
