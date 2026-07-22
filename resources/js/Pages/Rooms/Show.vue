<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';

const { t } = useI18n();
const page = usePage();

onMounted(() => {
    // Wait for DOM to be fully ready then initialize carousel
    setTimeout(() => {
        if (typeof $ !== 'undefined' && typeof $.fn.owlCarousel !== 'undefined') {
            const $carousel = $('.carousel_item_centered');
            // Destroy any existing instance
            if ($carousel.hasClass('owl-loaded')) {
                $carousel.trigger('destroy.owl.carousel');
                $carousel.removeClass('owl-loaded owl-drag');
                $carousel.find('.owl-stage-outer').children().unwrap();
                $carousel.find('.owl-stage').children().unwrap();
            }
            // Initialize fresh
            $carousel.owlCarousel({    
                loop:true,
                margin:5,
                nav:true,
                dots:false,
                center:true,
                navText: ["<i class='bi bi-arrow-left-short'></i>","<i class='bi bi-arrow-right-short'></i>"],
                responsive:{
                    0:{ items:1 },
                    600:{ items:2 },
                    1000:{ items:2 }
                }
            });
        }
    }, 500);
});

const props = defineProps({
    room: Object,
    relatedRooms: Array,
    seo: Object,
});

const asset = (path) => `/assets/paradise/${path}`;

const bookingHref = () => {
    const query = new URLSearchParams(page.url.split('?')[1] || '');
    query.set('room', props.room.slug);
    return `/booking?${query.toString()}`;
};

const amenityIcons = {
    'wifi': { icon: 'icon-hotel-wifi', label: { en: 'Wi-Fi Internet', mk: 'Wi-Fi Интернет' } },
    'lan': { icon: 'icon-hotel-wifi', label: { en: 'LAN Connection', mk: 'LAN Конекција' } },
    'parking': { icon: 'icon-hotel-parking', label: { en: 'Free Parking', mk: 'Бесплатен Паркинг' } },
    'smart-tv': { icon: 'icon-hotel-tv', label: { en: 'Smart TV', mk: 'Smart TV' } },
    'mini-bar': { icon: 'icon-hotel-bottle', label: { en: 'Mini Bar', mk: 'Мини Бар' } },
    'telephone': { icon: 'icon-hotel-reception', label: { en: 'Telephone', mk: 'Телефон' } },
    'spa': { icon: 'icon-spa-candles', label: { en: 'Spa Access', mk: 'Пристап до Спа' } },
    'pool': { icon: 'icon-hotel-swimming_pool', label: { en: 'Swimming Pool', mk: 'Базен' } },
    'laundry': { icon: 'icon-hotel-loundry', label: { en: 'Laundry Service', mk: 'Перење' } },
    'fitness': { icon: 'icon-hotel-gym', label: { en: 'Fitness Center', mk: 'Фитнес Центар' } },
    'turkish-bath': { icon: 'icon-hotel-bath', label: { en: 'Turkish Bath', mk: 'Турско Бањо' } },
    'swedish-sauna': { icon: 'icon-hotel-bath', label: { en: 'Swedish Sauna', mk: 'Шведска Сауна' } },
    'infrared-sauna': { icon: 'icon-hotel-bath', label: { en: 'Infrared Sauna', mk: 'Инфрацрвена Сауна' } },
    'steam-room': { icon: 'icon-hotel-shower', label: { en: 'Steam Room', mk: 'Парна Соба' } },
    'massage': { icon: 'icon-spa-cartified_massagist', label: { en: 'Massage Services', mk: 'Масажа' } },
    'dry-cleaning': { icon: 'icon-hotel-loundry', label: { en: 'Dry Cleaning', mk: 'Хемиско Чистење' } },
    'jacuzzi': { icon: 'icon-hotel-bath', label: { en: 'Jacuzzi', mk: 'Џакузи' } },
    'vip-service': { icon: 'icon-hotel-room_service', label: { en: 'VIP Service', mk: 'ВИП Услуга' } },
    'airport-transfer': { icon: 'icon-hotel-car', label: { en: 'Airport Transfer', mk: 'Аеродромски Трансфер' } },
    'private-dining': { icon: 'icon-hotel-restaurant', label: { en: 'Private Dining', mk: 'Приватна Трпезарија' } },
};

const getAmenityIcon = (amenity) => amenityIcons[amenity]?.icon || 'bi bi-check-circle';
const getAmenityLabel = (amenity, locale) => amenityIcons[amenity]?.label?.[locale] || amenity;

const galleryImages = props.room.gallery_images || [];
const lightboxOpen = ref(false);
const currentImageIndex = ref(0);

const openLightbox = (index) => {
    currentImageIndex.value = index;
    lightboxOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeLightbox = () => {
    lightboxOpen.value = false;
    document.body.style.overflow = '';
};

const nextImage = () => {
    currentImageIndex.value = (currentImageIndex.value + 1) % galleryImages.length;
};

const prevImage = () => {
    currentImageIndex.value = (currentImageIndex.value - 1 + galleryImages.length) % galleryImages.length;
};

onMounted(() => {
    document.addEventListener('keydown', (e) => {
        if (!lightboxOpen.value) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
    });
});
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
        <!-- Hero Section -->
        <div class="hero full-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img kenburns" :src="asset(room.featured_image)" :alt="room.name">
            <div class="wrapper opacity-mask d-flex align-items-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <small class="slide-animated one">{{ room.bed_type || 'Luxury' }} {{ room.view_type ? '• ' + room.view_type : '' }}</small>
                            <h1 class="slide-animated two">{{ room.name }}</h1>
                            <p class="slide-animated three">{{ room.short_description }}</p>
                        </div>
                    </div>
                </div>
                <div class="mouse_wp slide-animated four">
                    <a href="#first_section" class="btn_explore">
                        <div class="mouse"></div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Room Details Section -->
        <div class="bg_white" id="first_section">
            <div class="container margin_120_95">
                <div class="row justify-content-between">
                    <div class="col-lg-5">
                        <div class="title">
                            <small>{{ t('home.rooms_small') }}</small>
                            <h2>{{ room.name }}</h2>
                        </div>
                        <div v-html="room.description"></div>
                        <div class="room_info_box mt-4">
                            <ul>
                                <li><strong>{{ $page.props.locale === 'mk' ? 'Цена' : 'Price' }}:</strong> €{{ room.price_per_night }} / {{ $page.props.locale === 'mk' ? 'ноќ' : 'night' }}</li>
                                <li><strong>{{ $page.props.locale === 'mk' ? 'Гости' : 'Guests' }}:</strong> {{ room.max_guests }}</li>
                                <li><strong>{{ $page.props.locale === 'mk' ? 'Спални' : 'Bedrooms' }}:</strong> {{ room.bedrooms }}</li>
                                <li><strong>{{ $page.props.locale === 'mk' ? 'Бањи' : 'Bathrooms' }}:</strong> {{ room.bathrooms }}</li>
                                <li v-if="room.square_meters"><strong>{{ $page.props.locale === 'mk' ? 'Површина' : 'Size' }}:</strong> {{ room.square_meters }} m²</li>
                                <li v-if="room.bed_type"><strong>{{ $page.props.locale === 'mk' ? 'Кревет' : 'Bed' }}:</strong> {{ room.bed_type }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="room_facilities_list">
                            <h5 class="mb-3">{{ $page.props.locale === 'mk' ? 'Удобности' : 'Amenities' }}</h5>
                            <ul data-cues="slideInLeft">
                                <li v-for="amenity in room.amenities" :key="amenity">
                                    <i :class="getAmenityIcon(amenity)"></i> {{ getAmenityLabel(amenity, $page.props.locale) }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Carousel Section -->
        <div class="bg_white add_bottom_120" v-if="galleryImages.length > 0">
            <div class="container-fluid p-lg-0">
                <div data-cues="zoomIn">
                    <div class="owl-carousel owl-theme carousel_item_centered kenburns rounded-img">
                        <div class="item" v-for="(image, index) in galleryImages" :key="index">
                            <img :src="asset(image)" :alt="`${room.name} - Image ${index + 1}`">
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a class="btn_1 outline" href="#" @click.prevent="openLightbox(0)">
                        {{ $page.props.locale === 'mk' ? 'Целосна Галерија' : 'FullScreen Gallery' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Booking CTA Section -->
        <div class="call_section jarallax" data-jarallax data-speed="0.2" id="booking_section">
            <img class="jarallax-img" :src="asset(room.featured_image)" :alt="room.name">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center" data-opacity-mask="rgba(0, 0, 0, 0.6)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="title white">
                                <small>{{ $page.props.locale === 'mk' ? 'Резервирајте Сега' : 'Book Now' }}</small>
                                <h2>{{ room.name }}</h2>
                                <p>{{ $page.props.locale === 'mk' ? 'Од' : 'From' }} €{{ room.price_per_night }} / {{ $page.props.locale === 'mk' ? 'ноќ' : 'night' }}</p>
                            </div>
                            <a :href="bookingHref()" class="btn_1">{{ $page.props.locale === 'mk' ? 'Резервирај' : 'Book This Room' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Rooms Section -->
        <div class="container margin_120_95" v-if="relatedRooms && relatedRooms.length > 0">
            <div class="title text-center mb-5">
                <small data-cue="slideInUp">{{ $page.props.locale === 'mk' ? 'Повеќе Опции' : 'More Options' }}</small>
                <h2 data-cue="slideInUp" data-delay="100">{{ $page.props.locale === 'mk' ? 'Други Соби и Апартмани' : 'Other Rooms & Suites' }}</h2>
            </div>
            <div class="row">
                <div v-for="related in relatedRooms.slice(0, 3)" :key="related.id" class="col-lg-4 col-md-6" data-cue="slideInUp">
                    <Link :href="`/rooms/${related.slug}`" class="box_cat_rooms">
                        <figure>
                            <div class="background-image" :style="{ backgroundImage: `url(${asset(related.featured_image)})` }"></div>
                            <div class="info">
                                <small>{{ $page.props.locale === 'mk' ? 'Од' : 'From' }} €{{ related.price_per_night }}/{{ $page.props.locale === 'mk' ? 'ноќ' : 'night' }}</small>
                                <h3>{{ related.name }}</h3>
                                <span>{{ $page.props.locale === 'mk' ? 'Прочитај повеќе' : 'Read more' }}</span>
                            </div>
                        </figure>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Lightbox -->
        <Teleport to="body">
            <div v-if="lightboxOpen" class="lightbox-overlay" @click.self="closeLightbox">
                <button class="lightbox-close" @click="closeLightbox">&times;</button>
                <button class="lightbox-prev" @click="prevImage">&#10094;</button>
                <img :src="asset(galleryImages[currentImageIndex])" :alt="`${room.name} - Image ${currentImageIndex + 1}`" class="lightbox-image">
                <button class="lightbox-next" @click="nextImage">&#10095;</button>
                <div class="lightbox-counter">{{ currentImageIndex + 1 }} / {{ galleryImages.length }}</div>
            </div>
        </Teleport>
    </Layout>
</template>

<style scoped>
.room_info_box ul {
    list-style: none;
    padding: 0;
}
.room_info_box ul li {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}
.room_facilities_list ul {
    list-style: none;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}
.room_facilities_list ul li {
    padding: 8px 0;
}
.room_facilities_list ul li i {
    margin-right: 10px;
    color: #c9a961;
}

/* Lightbox styles */
.lightbox-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}
.lightbox-image {
    max-width: 90%;
    max-height: 90vh;
    object-fit: contain;
}
.lightbox-close {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 40px;
    color: white;
    background: none;
    border: none;
    cursor: pointer;
    z-index: 10000;
}
.lightbox-prev, .lightbox-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 30px;
    color: white;
    background: rgba(0,0,0,0.5);
    border: none;
    padding: 20px 15px;
    cursor: pointer;
}
.lightbox-prev { left: 20px; }
.lightbox-next { right: 20px; }
.lightbox-counter {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 16px;
}

.call_section {
    min-height: 400px;
}

.call_section .title.white small,
.call_section .title.white h2,
.call_section .title.white p {
    color: #fff !important;
}
</style>
