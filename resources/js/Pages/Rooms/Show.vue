<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';
import { useLocale } from '@/composables/useLocale';

const { t } = useI18n();
const page = usePage();
const { ml } = useLocale();

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
    'wifi': { icon: 'icon-hotel-wifi', label: { en: 'Wi-Fi Internet', mk: 'Wi-Fi Интернет', sr: 'Wi-Fi Internet', tr: 'Wi-Fi İnternet', sq: 'Internet Wi-Fi' } },
    'lan': { icon: 'icon-hotel-wifi', label: { en: 'LAN Connection', mk: 'LAN Конекција', sr: 'LAN Konekcija', tr: 'LAN Bağlantısı', sq: 'Lidhje LAN' } },
    'parking': { icon: 'icon-hotel-parking', label: { en: 'Free Parking', mk: 'Бесплатен Паркинг', sr: 'Besplatan Parking', tr: 'Ücretsiz Otopark', sq: 'Parking Falas' } },
    'smart-tv': { icon: 'icon-hotel-tv', label: { en: 'Smart TV', mk: 'Smart TV', sr: 'Smart TV', tr: 'Akıllı TV', sq: 'TV Smart' } },
    'mini-bar': { icon: 'icon-hotel-bottle', label: { en: 'Mini Bar', mk: 'Мини Бар', sr: 'Mini Bar', tr: 'Mini Bar', sq: 'Mini Bar' } },
    'telephone': { icon: 'icon-hotel-reception', label: { en: 'Telephone', mk: 'Телефон', sr: 'Telefon', tr: 'Telefon', sq: 'Telefon' } },
    'spa': { icon: 'icon-spa-candles', label: { en: 'Spa Access', mk: 'Пристап до Спа', sr: 'Pristup Spa Centru', tr: 'Spa Erişimi', sq: 'Qasje në Spa' } },
    'pool': { icon: 'icon-hotel-swimming_pool', label: { en: 'Swimming Pool', mk: 'Базен', sr: 'Bazen', tr: 'Yüzme Havuzu', sq: 'Pishinë' } },
    'laundry': { icon: 'icon-hotel-loundry', label: { en: 'Laundry Service', mk: 'Перење', sr: 'Usluga Pranja Veša', tr: 'Çamaşır Hizmeti', sq: 'Shërbim Larje Rrobash' } },
    'fitness': { icon: 'icon-hotel-gym', label: { en: 'Fitness Center', mk: 'Фитнес Центар', sr: 'Fitnes Centar', tr: 'Fitness Merkezi', sq: 'Qendër Fitnesi' } },
    'turkish-bath': { icon: 'icon-hotel-bath', label: { en: 'Turkish Bath', mk: 'Турско Бањо', sr: 'Tursko Kupatilo', tr: 'Türk Hamamı', sq: 'Banjë Turke' } },
    'swedish-sauna': { icon: 'icon-hotel-bath', label: { en: 'Swedish Sauna', mk: 'Шведска Сауна', sr: 'Švedska Sauna', tr: 'İsveç Saunası', sq: 'Saunë Suedeze' } },
    'infrared-sauna': { icon: 'icon-hotel-bath', label: { en: 'Infrared Sauna', mk: 'Инфрацрвена Сауна', sr: 'Infracrvena Sauna', tr: 'Kızılötesi Sauna', sq: 'Saunë Infra të Kuqe' } },
    'steam-room': { icon: 'icon-hotel-shower', label: { en: 'Steam Room', mk: 'Парна Соба', sr: 'Parno Kupatilo', tr: 'Buhar Odası', sq: 'Dhomë Avulli' } },
    'massage': { icon: 'icon-spa-cartified_massagist', label: { en: 'Massage Services', mk: 'Масажа', sr: 'Usluge Masaže', tr: 'Masaj Hizmetleri', sq: 'Shërbime Masazhi' } },
    'dry-cleaning': { icon: 'icon-hotel-loundry', label: { en: 'Dry Cleaning', mk: 'Хемиско Чистење', sr: 'Hemijsko Čišćenje', tr: 'Kuru Temizleme', sq: 'Pastrim Kimik' } },
    'jacuzzi': { icon: 'icon-hotel-bath', label: { en: 'Jacuzzi', mk: 'Џакузи', sr: 'Džakuzi', tr: 'Jakuzi', sq: 'Jakuzi' } },
    'vip-service': { icon: 'icon-hotel-room_service', label: { en: 'VIP Service', mk: 'ВИП Услуга', sr: 'VIP Usluga', tr: 'VIP Hizmet', sq: 'Shërbim VIP' } },
    'airport-transfer': { icon: 'icon-hotel-car', label: { en: 'Airport Transfer', mk: 'Аеродромски Трансфер', sr: 'Transfer sa Aerodroma', tr: 'Havalimanı Transferi', sq: 'Transferi nga Aeroporti' } },
    'private-dining': { icon: 'icon-hotel-restaurant', label: { en: 'Private Dining', mk: 'Приватна Трпезарија', sr: 'Privatna Trpezarija', tr: 'Özel Yemek', sq: 'Darkim Privat' } },
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
                            <small class="slide-animated one">{{ room.bed_type || ml({ en: 'Luxury', mk: 'Луксузно', sr: 'Luksuzno', tr: 'Lüks', sq: 'Luksoze' }) }} {{ room.view_type ? '• ' + room.view_type : '' }}</small>
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
                                <li><strong>{{ ml({ en: 'Price', mk: 'Цена', sr: 'Cena', tr: 'Fiyat', sq: 'Çmimi' }) }}:</strong> €{{ room.price_per_night }} / {{ ml({ en: 'night', mk: 'ноќ', sr: 'noć', tr: 'gece', sq: 'natë' }) }}</li>
                                <li><strong>{{ ml({ en: 'Guests', mk: 'Гости', sr: 'Gosti', tr: 'Misafirler', sq: 'Mysafirë' }) }}:</strong> {{ room.max_guests }}</li>
                                <li><strong>{{ ml({ en: 'Bedrooms', mk: 'Спални', sr: 'Spavaće Sobe', tr: 'Yatak Odası', sq: 'Dhoma Gjumi' }) }}:</strong> {{ room.bedrooms }}</li>
                                <li><strong>{{ ml({ en: 'Bathrooms', mk: 'Бањи', sr: 'Kupatila', tr: 'Banyo', sq: 'Banjo' }) }}:</strong> {{ room.bathrooms }}</li>
                                <li v-if="room.square_meters"><strong>{{ ml({ en: 'Size', mk: 'Површина', sr: 'Veličina', tr: 'Boyut', sq: 'Madhësia' }) }}:</strong> {{ room.square_meters }} m²</li>
                                <li v-if="room.bed_type"><strong>{{ ml({ en: 'Bed', mk: 'Кревет', sr: 'Krevet', tr: 'Yatak', sq: 'Shtrat' }) }}:</strong> {{ room.bed_type }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="room_facilities_list">
                            <h5 class="mb-3">{{ ml({ en: 'Amenities', mk: 'Удобности', sr: 'Sadržaji', tr: 'Olanaklar', sq: 'Pajisje' }) }}</h5>
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
                        {{ ml({ en: 'FullScreen Gallery', mk: 'Целосна Галерија', sr: 'Puni Ekran Galerije', tr: 'Tam Ekran Galeri', sq: 'Galeri Ekran i Plotë' }) }}
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
                                <small>{{ ml({ en: 'Book Now', mk: 'Резервирајте Сега', sr: 'Rezerviši Sada', tr: 'Hemen Rezervasyon Yap', sq: 'Rezervo Tani' }) }}</small>
                                <h2>{{ room.name }}</h2>
                                <p>{{ ml({ en: 'From', mk: 'Од', sr: 'Od', tr: 'Başlangıç', sq: 'Nga' }) }} €{{ room.price_per_night }} / {{ ml({ en: 'night', mk: 'ноќ', sr: 'noć', tr: 'gece', sq: 'natë' }) }}</p>
                            </div>
                            <a :href="bookingHref()" class="btn_1">{{ ml({ en: 'Book This Room', mk: 'Резервирај', sr: 'Rezerviši Ovu Sobu', tr: 'Bu Odayı Rezerve Et', sq: 'Rezervo Këtë Dhomë' }) }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Rooms Section -->
        <div class="container margin_120_95" v-if="relatedRooms && relatedRooms.length > 0">
            <div class="title text-center mb-5">
                <small data-cue="slideInUp">{{ ml({ en: 'More Options', mk: 'Повеќе Опции', sr: 'Više Opcija', tr: 'Diğer Seçenekler', sq: 'Më Shumë Opsione' }) }}</small>
                <h2 data-cue="slideInUp" data-delay="100">{{ ml({ en: 'Other Rooms & Suites', mk: 'Други Соби и Апартмани', sr: 'Druge Sobe i Apartmani', tr: 'Diğer Oda ve Süitler', sq: 'Dhoma dhe Suita të Tjera' }) }}</h2>
            </div>
            <div class="row">
                <div v-for="related in relatedRooms.slice(0, 3)" :key="related.id" class="col-lg-4 col-md-6" data-cue="slideInUp">
                    <Link :href="`/rooms/${related.slug}`" class="box_cat_rooms">
                        <figure>
                            <div class="background-image" :style="{ backgroundImage: `url(${asset(related.featured_image)})` }"></div>
                            <div class="info">
                                <small>{{ ml({ en: 'From', mk: 'Од', sr: 'Od', tr: 'Başlangıç', sq: 'Nga' }) }} €{{ related.price_per_night }}/{{ ml({ en: 'night', mk: 'ноќ', sr: 'noć', tr: 'gece', sq: 'natë' }) }}</small>
                                <h3>{{ related.name }}</h3>
                                <span>{{ ml({ en: 'Read more', mk: 'Прочитај повеќе', sr: 'Pročitaj više', tr: 'Devamını oku', sq: 'Lexo më shumë' }) }}</span>
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
