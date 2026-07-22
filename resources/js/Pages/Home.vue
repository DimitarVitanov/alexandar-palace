<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';
import BookingSection from '@/Components/Frontend/BookingSection.vue';

const props = defineProps({
    page: Object,
    sections: Object,
    rooms: Array,
    news: Array,
    testimonials: Array,
    settings: Object,
    seo: Object,
});

const { t } = useI18n();

const hero = props.sections?.hero;
const about = props.sections?.about;
const videoParallax = props.sections?.video_parallax;
const facilities = props.sections?.facilities;
const localAmenities = props.sections?.local_amenities;
const booking = props.sections?.booking;

const bookingForm = useForm({
    room_id: '',
    adults: 1,
    children: 0,
});

const searchForm = useForm({
    dates: '',
    adults: 1,
    children: 0,
});

const heroBooking = useForm({
    dates: '',
    adults: 1,
    children: 0,
});

// Hero booking form state
const heroAdults = ref(1);
const heroChildren = ref(0);
const heroCheckIn = ref('');
const heroCheckOut = ref('');

const submitHeroBooking = () => {
    const params = new URLSearchParams();
    if (heroCheckIn.value) params.set('check_in', heroCheckIn.value);
    if (heroCheckOut.value) params.set('check_out', heroCheckOut.value);
    params.set('adults', heroAdults.value);
    params.set('children', heroChildren.value);
    window.location.href = `/rooms?${params.toString()}`;
};

// Initialize hero date picker
onMounted(() => {
    nextTick(() => {
        if (typeof window.easepick !== 'undefined') {
            const element = document.getElementById('hero_dates');
            if (element) {
                new window.easepick.create({
                    element: element,
                    css: ['/assets/paradise/css/daterangepicker_v2.css'],
                    format: 'DD/MM/YYYY',
                    calendars: 2,
                    grid: 2,
                    zIndex: 9999,
                    plugins: ['RangePlugin', 'LockPlugin'],
                    RangePlugin: {
                        tooltipNumber(num) {
                            return num - 1;
                        },
                        locale: {
                            one: 'night',
                            other: 'nights',
                        },
                    },
                    LockPlugin: {
                        minDate: new Date(),
                        minDays: 1,
                    },
                    setup(picker) {
                        picker.on('select', (e) => {
                            if (e.detail.start) {
                                heroCheckIn.value = e.detail.start.format('YYYY-MM-DD');
                            }
                            if (e.detail.end) {
                                heroCheckOut.value = e.detail.end.format('YYYY-MM-DD');
                            }
                        });
                    }
                });
            }
        }
    });
});

const asset = (path) => `/assets/paradise/${path}`;

const mobileVideo = ref(null);

// Force play mobile video on mount
onMounted(() => {
    nextTick(() => {
        if (mobileVideo.value && isMobile()) {
            mobileVideo.value.play().catch(() => {
                // Autoplay blocked, video will show poster
            });
        }
    });
});

const formatPrice = (price) => {
    const num = Number(price);
    return Number.isInteger(num) ? num.toString() : num.toFixed(2);
};

const isMobile = () => typeof window !== 'undefined' && window.innerWidth < 768;

const getHeroVideo = () => {
    if (isMobile()) {
        return 'video/hero_video_mobile.mp4';
    }
    return hero?.video || 'video/hero_video.mp4';
};

const getRoomImage = (room) => {
    if (isMobile()) {
        if (room.slug === 'single-room') return 'img/rooms/single-two-mobile.webp';
        if (room.slug === 'executive-suite') return 'img/rooms/executive-mobile.webp';
    }
    return room.featured_image;
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
        :hideBookingSection="true"
    >
        <div class="hero home-search full-height jarallax" :data-jarallax-video="`mp4:/assets/paradise/${getHeroVideo()}`" data-speed="0.2">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small class="slide-animated one">{{ hero?.subtitle || t('home.hero_small') }}</small>
                    <h3 class="slide-animated two" v-html="hero?.title || t('home.hero_title')"></h3>
                    <div class="row justify-content-center slide-animated three">
                        <div class="col-xl-12">
                            <form class="row g-0 booking_form" @submit.prevent="submitHeroBooking">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="hero_dates" :placeholder="t('home.check_in_out')" readonly>
                                        <i class="bi bi-calendar2"></i>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="qty-buttons">
                                        <label>{{ t('home.adults') }}</label>
                                        <input type="button" value="+" class="qtyplus" @click="heroAdults = Math.min(10, heroAdults + 1)">
                                        <input type="text" :value="heroAdults" class="qty form-control" readonly>
                                        <input type="button" value="-" class="qtyminus" @click="heroAdults = Math.max(1, heroAdults - 1)">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="qty-buttons">
                                        <label>{{ t('home.children') }}</label>
                                        <input type="button" value="+" class="qtyplus" @click="heroChildren = Math.min(10, heroChildren + 1)">
                                        <input type="text" :value="heroChildren" class="qty form-control" readonly>
                                        <input type="button" value="-" class="qtyminus" @click="heroChildren = Math.max(0, heroChildren - 1)">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <input type="submit" class="btn_search" :value="t('home.search')">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mouse_wp slide-animated four">
                    <a href="#first_section" class="btn_scrollto">
                        <div class="mouse"></div>
                    </a>
                </div>
            </div>
        </div>

        <div class="pattern_2">
            <div class="container margin_120_95" id="first_section">
                <div class="row justify-content-between flex-lg-row-reverse align-items-center">
                    <div class="col-lg-5">
                        <div class="parallax_wrapper">

                            <img :src="asset('img/about-1.webp')" :alt="about?.title || 'About Us'" class="img-fluid rounded-img">
                            <div data-cue="slideInUp" class="img_over">
                                <span>
                                    <img :src="asset('img/about-us-two.webp')" :alt="about?.title || 'About Us'" class="rounded-img">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="intro">
                            <div class="title">
                                <small>{{ about?.subtitle || t('home.about_small') }}</small>
                                <h2>{{ about?.title || t('home.about_title') }}</h2>
                            </div>
                            <div v-html="about?.content || ''"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pinned-image pinned-image--medium">
                <div class="pinned-image__container" id="section_video">
                    <!-- Desktop video (hidden on mobile) -->
                    <video autoplay loop muted playsinline id="video_home" class="d-none d-md-block">
                        <source :src="asset('video/swimming_pool_2.mp4')" type="video/mp4">
                        <source :src="asset('video/swimming_pool_2.webm')" type="video/webm">
                        <source :src="asset('video/swimming_pool_2.ogv')" type="video/ogg">
                    </video>
                    <!-- Mobile video (smaller file, shown only on mobile) -->
                    <video ref="mobileVideo" autoplay loop muted playsinline webkit-playsinline id="video_home_mobile" class="d-block d-md-none" :poster="asset('video/edited1-scaled.jpg')" style="width: 100%; height: 100%; object-fit: cover;">
                        <source :src="asset('video/swimming_pool_2.mp4')" type="video/mp4">
                        <source :src="asset('video/swimming_pool_2.webm')" type="video/webm">
                    </video>
                    <div class="pinned-image__container-overlay"></div>
                </div>
                <div class="pinned_over_content">
                    <div class="title white">
                        <small data-cue="slideInUp" data-delay="200">{{ videoParallax?.subtitle || '' }}</small>
                        <h2 data-cue="slideInUp" data-delay="300" v-html="videoParallax?.title || ''"></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container margin_120_95">
            <div class="title mb-3">
                <small data-cue="slideInUp">{{ t('home.rooms_small') }}</small>
                <h2 data-cue="slideInUp" data-delay="200">{{ t('home.rooms_title') }}</h2>
            </div>
            <div class="row justify-content-center" data-cues="slideInUp" data-delay="300">
                <div v-for="(room, index) in rooms.slice(0, 3)" :key="room.id" :class="index === 0 ? 'col-xl-6 col-lg-12 col-md-12 col-sm-12' : 'col-xl-3 col-lg-6 col-md-6 col-sm-6'">
                    <Link :href="`/rooms/${room.slug}`" class="box_cat_rooms">
                        <figure>
                            <div class="background-image" :style="{ backgroundImage: `url(${asset(getRoomImage(room))})` }"></div>
                            <div class="info">
                                <small>From €{{ formatPrice(room.price_per_night) }}/night</small>
                                <h3>{{ room.name }}</h3>
                                <span>Read more</span>
                            </div>
                        </figure>
                    </Link>
                </div>
            </div>
            <p class="text-end add_bottom_90"><Link href="/rooms" class="btn_1 outline mt-2">{{ t('home.view_all_rooms') }}</Link></p>

            <div class="title text-center mb-5">
                <small data-cue="slideInUp">{{ facilities?.subtitle || t('home.facilities_small') }}</small>
                <h2 data-cue="slideInUp" data-delay="100">{{ facilities?.title || t('home.facilities_title') }}</h2>
            </div>
            <div class="row mt-4">
                <div v-for="(facility, index) in facilities?.data || []" :key="index" class="col-xl-3 col-md-6">
                    <div class="box_facilities" :class="{ 'no-border': index === 0 }" data-cue="slideInUp">
                        <i :class="facility.icon"></i>
                        <h3>{{ facility.title }}</h3>
                        <p>{{ facility.description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="marquee">
            <div class="track">
                <div class="content">&nbsp;Relax Enjoy Luxury Holiday Travel Discover Experience Relax Enjoy Luxury Holiday Travel Discover Experience Relax Enjoy Luxury Holiday Travel Discover Experience Relax Enjoy Luxury Holiday Travel Discover Experience</div>
            </div>
        </div>

        <!-- Restaurant & Activities Section -->
        <div class="bg_white">
            <div class="container margin_120_95">
                <!-- Restaurant -->
                <div class="row justify-content-between d-flex align-items-center add_bottom_90">
                    <div class="col-lg-6">
                        <div class="pinned-image rounded_container pinned-image--small mb-4">
                            <div class="pinned-image__container">
                                <img :src="asset('img/restaurant/restaurant_hero.webp')" :alt="t('restaurant.title')">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="title">
                            <small>{{ t('home.facilities_small') }}</small>
                            <h3>{{ t('restaurant.title') }}</h3>
                            <p>{{ t('restaurant.description') }}</p>
                            <p><Link href="/tennis-restaurant" class="btn_1 mt-1 outline">{{ t('home.read_more') }}</Link></p>
                        </div>
                    </div>
                </div>
                <!-- Sport -->
                <div class="row justify-content-between d-flex align-items-center add_bottom_90">
                    <div class="col-lg-6 order-lg-2">
                        <div class="pinned-image rounded_container pinned-image--small mb-4">
                            <div class="pinned-image__container">
                                <img :src="asset('img/activities/teniski-teren-scaled.webp')" :alt="t('home.activities_sport')">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 order-lg-1">
                        <div class="title">
                            <small>{{ t('home.activities_subtitle') }}</small>
                            <h3>{{ t('home.activities_sport') }}</h3>
                            <p>{{ t('home.activities_sport_desc') }}</p>
                            <p><Link href="/activities" class="btn_1 mt-1 outline">{{ t('home.read_more') }}</Link></p>
                        </div>
                    </div>
                </div>
                <!-- SPA -->
                <div class="row justify-content-between d-flex align-items-center">
                    <div class="col-lg-6">
                        <div class="pinned-image rounded_container pinned-image--small mb-4">
                            <div class="pinned-image__container">
                                <img :src="asset('img/spa/DSC_4700-scaled.webp')" :alt="t('home.activities_spa')">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="title">
                            <small>{{ t('home.activities_subtitle') }}</small>
                            <h3>{{ t('home.activities_spa') }}</h3>
                            <p>{{ t('home.activities_spa_desc') }}</p>
                            <p><Link href="/activities" class="btn_1 mt-1 outline">{{ t('home.read_more') }}</Link></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Section - Hidden for now -->
        <div v-if="false" class="parallax_section_1 jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img kenburns-2" :src="`/assets/paradise/img/hero_home_1.jpg`" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="title white">
                                <small class="mb-1">Testimonials</small>
                                <h2>What Clients Says</h2>
                            </div>
                            <div class="carousel_testimonials owl-carousel owl-theme nav-dots-orizontal">
                                <div v-for="testimonial in testimonials" :key="testimonial.id">
                                    <div class="box_overlay">
                                        <div class="pic">
                                            <figure><img :src="asset(testimonial.photo)" alt="" class="img-circle"></figure>
                                            <h4>{{ testimonial.name }}<small>{{ testimonial.date }}</small></h4>
                                        </div>
                                        <div class="comment">"{{ testimonial.comment }}"</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg_white d-none">
            <div class="container margin_120_95">
                <div class="title mb-3">
                    <small data-cue="slideInUp">{{ t('home.news_small') }}</small>
                    <h2 data-cue="slideInUp" data-delay="200">{{ t('home.news_title') }}</h2>
                </div>
                <div class="row justify-content-center home">
                    <div v-for="post in news" :key="post.id" class="item col-xl-4 col-lg-6">
                        <Link :href="`/news/${post.slug}`" class="box_contents" data-cue="slideInUp" data-delay="300">
                            <figure><img :src="asset(post.featured_image)" alt="" class="img-fluid"><em>{{ post.published_at }}</em></figure>
                            <div class="wrapper">
                                <small>{{ post.category }}<span></span></small>
                                <h2>{{ post.title }}</h2>
                                <em>Read more</em>
                            </div>
                        </Link>
                    </div>
                </div>
                <p class="text-end"><Link href="/news" class="btn_1 outline mt-2" data-cue="slideInUp" data-delay="600">{{ t('home.view_all_news') }}</Link></p>
            </div>
        </div>

        <BookingSection :rooms="rooms" />
    </Layout>
</template>

