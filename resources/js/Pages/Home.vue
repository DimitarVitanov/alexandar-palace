<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';

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

const asset = (path) => `/assets/paradise/${path}`;

const formatPrice = (price) => {
    const num = Number(price);
    return Number.isInteger(num) ? num.toString() : num.toFixed(2);
};

const isMobile = () => typeof window !== 'undefined' && window.innerWidth < 768;

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
    >
        <div class="hero home-search full-height jarallax" :data-jarallax-video="`mp4:/assets/paradise/${hero?.video || 'video/hero_video.mp4'}`" data-speed="0.2">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small class="slide-animated one">{{ hero?.subtitle || t('home.hero_small') }}</small>
                    <h3 class="slide-animated two" v-html="hero?.title || t('home.hero_title')"></h3>
                    <div class="row justify-content-center slide-animated three">
                        <div class="col-xl-10">
                            <form class="row g-0 booking_form" method="GET" action="/rooms">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="dates" id="dates" :placeholder="t('home.check_in_out')" readonly>
                                        <i class="bi bi-calendar2"></i>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 pe-lg-0 pe-sm-1">
                                    <div class="qty-buttons">
                                        <label>{{ t('home.adults') }}</label>
                                        <input type="button" value="+" class="qtyplus" name="adults">
                                        <input type="text" name="adults" id="adults" value="1" class="qty form-control" readonly>
                                        <input type="button" value="-" class="qtyminus" name="adults">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 ps-lg-0 ps-sm-1">
                                    <div class="qty-buttons">
                                        <label>{{ t('home.children') }}</label>
                                        <input type="button" value="+" class="qtyplus" name="children">
                                        <input type="text" name="children" id="children" value="0" class="qty form-control" readonly>
                                        <input type="button" value="-" class="qtyminus" name="children">
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
                    <video loop muted playsinline id="video_home" class="d-none d-md-block">
                        <source :src="asset('video/swimming_pool_2.mp4')" type="video/mp4">
                        <source :src="asset('video/swimming_pool_2.webm')" type="video/webm">
                        <source :src="asset('video/swimming_pool_2.ogv')" type="video/ogg">
                    </video>
                    <!-- Mobile video (smaller file, shown only on mobile) -->
                    <video loop muted playsinline id="video_home_mobile" class="d-block d-md-none">
                        <source :src="asset('video/swimming_pool_2.webm')" type="video/webm">
                        <source :src="asset('video/swimming_pool_2.mp4')" type="video/mp4">
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

        <div class="bg_white">
            <div class="container margin_120_95">
                <div v-for="(amenity, index) in localAmenities?.data || []" :key="index" class="row justify-content-between d-flex align-items-center" :class="{ 'add_bottom_90': index === 0 }">
                    <div class="col-lg-6" :class="{ 'order-lg-2': index % 2 === 1 }">
                        <div class="pinned-image rounded_container pinned-image--small mb-4">
                            <div class="pinned-image__container">
                                <img :src="asset(amenity.image)" :alt="amenity.title">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5" :class="{ 'order-lg-1': index % 2 === 1 }">
                        <div class="title">
                            <small>{{ localAmenities?.subtitle }}</small>
                            <h3>{{ amenity.title }}</h3>
                            <p>{{ amenity.description }}</p>
                            <p><Link href="/about" class="btn_1 mt-1 outline">Read more</Link></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="parallax_section_1 jarallax" data-jarallax data-speed="0.2">
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

        <div class="bg_white">
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

        <div class="container margin_120_95" id="booking_section">
            <div class="row justify-content-between">
                <div class="col-xl-4">
                    <div data-cue="slideInUp">
                        <div class="title">
                            <small>{{ booking?.subtitle || t('home.booking_small') }}</small>
                            <h2>{{ booking?.title || t('home.booking_title') }}</h2>
                        </div>
                        <p v-if="booking?.content" v-html="booking.content"></p>
                        <p v-else>Mea nibh meis philosophia eu. Duis legimus efficiantur ea sea. Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
                        <p class="phone_element no_borders"><a :href="`tel:${settings?.phone?.value || '+389 2 123 4567'}`"><i class="bi bi-telephone"></i><span><em>{{ t('home.booking_info') }}</em>{{ settings?.phone?.value || '+389 2 123 4567' }}</span></a></p>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div data-cue="slideInUp" data-delay="200">
                        <form @submit.prevent="bookingForm.post('/bookings')">
                            <div class="booking_wrapper pb-4">
                                <div class="col-12">
                                    <input type="hidden" id="booking_dates" name="date_booking" v-model="bookingForm.date_booking">
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
                                    <div class="col-lg-3">
                                        <div class="qty-buttons version_2">
                                            <input type="text" v-model="bookingForm.adults" class="qty form-control" placeholder="Adults">
                                            <input type="button" value="-" class="qtyminus" @click="bookingForm.adults > 1 ? bookingForm.adults-- : null">
                                            <input type="button" value="+" class="qtyplus" @click="bookingForm.adults++">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="qty-buttons version_2">
                                            <input type="text" v-model="bookingForm.children" class="qty form-control" placeholder="Childs">
                                            <input type="button" value="-" class="qtyminus" @click="bookingForm.children > 0 ? bookingForm.children-- : null">
                                            <input type="button" value="+" class="qtyplus" @click="bookingForm.children++">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-end mt-4"><button type="submit" class="btn_1 outline" :disabled="bookingForm.processing">Book Now</button></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
