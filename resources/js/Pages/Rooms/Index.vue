<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';

const props = defineProps({
    rooms: Array,
    searchParams: Object,
    seo: Object,
    featuredImage: String,
});

const { t } = useI18n();
const page = usePage();
const locale = page.props.locale;
const asset = (path) => `/assets/paradise/${path}`;

const formatPrice = (price) => {
    const num = Number(price);
    return Number.isInteger(num) ? num.toString() : num.toFixed(2);
};

const availabilityQuery = () => {
    if (!props.searchParams?.has_searched) {
        return '';
    }

    const query = new URLSearchParams({
        adults: props.searchParams.adults,
        children: props.searchParams.children,
    });

    if (props.searchParams.check_in && props.searchParams.check_out) {
        query.set('check_in', props.searchParams.check_in);
        query.set('check_out', props.searchParams.check_out);
    }

    return query.toString();
};

const bookingHref = (room) => {
    const query = availabilityQuery();
    return `/booking?room=${encodeURIComponent(room.slug)}${query ? `&${query}` : ''}`;
};

const roomHref = (room) => {
    const query = availabilityQuery();
    return `/rooms/${room.slug}${query ? `?${query}` : ''}`;
};

const getAmenityIcon = (amenity) => {
    const icons = {
        'wifi': 'icon-hotel-wifi',
        'smart-tv': 'icon-hotel-tv',
        'mini-bar': 'icon-hotel-bottle',
        'spa': 'icon-spa-candles',
        'pool': 'icon-hotel-swimming_pool',
        'fitness': 'icon-hotel-gym',
    };
    return icons[amenity] || 'bi bi-check-circle';
};

const getAmenityLabel = (amenity) => {
    const labels = {
        'wifi': locale === 'mk' ? 'Wi-Fi' : 'Free Wifi',
        'smart-tv': locale === 'mk' ? 'Smart TV' : 'Smart TV',
        'mini-bar': locale === 'mk' ? 'Мини Бар' : 'Mini Bar',
        'spa': locale === 'mk' ? 'Спа' : 'Spa Access',
        'pool': locale === 'mk' ? 'Базен' : 'Pool',
        'fitness': locale === 'mk' ? 'Фитнес' : 'Fitness',
    };
    return labels[amenity] || amenity;
};

const getShortDescription = (room) => {
    if (room.short_description) {
        const desc = typeof room.short_description === 'object' 
            ? (room.short_description[locale] || room.short_description['en']) 
            : room.short_description;
        return desc;
    }
    return '';
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
            <img class="jarallax-img" :src="asset(featuredImage || 'img/hero_home_1.jpg')" alt="Rooms & Suites">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small class="slide-animated one">{{ locale === 'mk' ? 'Луксузно Хотелско Искуство' : 'Luxury Hotel Experience' }}</small>
                    <h1 class="slide-animated two">{{ t('home.rooms_title') }}</h1>
                </div>
            </div>
        </div>

        <!-- Rooms List -->
        <div class="container margin_120_95 pb-0" id="first_section">
            <!-- Search Results Header -->
            <div v-if="searchParams?.has_searched" class="search-results-header mb-5">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h3 v-if="rooms.length > 0">
                            {{ locale === 'mk' ? 'Достапни соби' : 'Available Rooms' }} 
                            <span class="text-muted">({{ rooms.length }} {{ locale === 'mk' ? 'од' : 'of' }} {{ searchParams.total_rooms }})</span>
                        </h3>
                        <p class="text-muted mb-0">
                            {{ locale === 'mk' ? 'За' : 'For' }} {{ searchParams.adults }} {{ locale === 'mk' ? 'возрасни' : 'adults' }}
                            <span v-if="searchParams.children > 0">, {{ searchParams.children }} {{ locale === 'mk' ? 'деца' : 'children' }}</span>
                        </p>
                    </div>
                    <button @click="resetSearch" class="btn_1 outline">
                        {{ locale === 'mk' ? 'Прикажи ги сите' : 'Show All' }}
                    </button>
                </div>
            </div>

            <!-- No Results Message -->
            <div v-if="searchParams?.has_searched && rooms.length === 0" class="no-results text-center py-5">
                <i class="bi bi-search" style="font-size: 48px; color: #ccc;"></i>
                <h3 class="mt-3">{{ locale === 'mk' ? 'Нема достапни соби' : 'No Rooms Available' }}</h3>
                <p class="text-muted">
                    {{ locale === 'mk' ? 'Нема соби за' : 'No rooms available for' }} {{ searchParams.adults + searchParams.children }} {{ locale === 'mk' ? 'гости' : 'guests' }}.
                    {{ locale === 'mk' ? 'Обидете се со помалку гости.' : 'Try with fewer guests.' }}
                </p>
                <button @click="resetSearch" class="btn_1 mt-3">
                    {{ locale === 'mk' ? 'Прикажи ги сите соби' : 'Show All Rooms' }}
                </button>
            </div>

            <div 
                v-for="(room, index) in rooms" 
                :key="room.id" 
                class="row_list_version_1"
            >
                <div class="pinned-image rounded_container pinned-image--medium">
                    <div class="pinned-image__container">
                        <img :src="asset(room.featured_image)" :alt="room.name">
                    </div>
                </div>
                
                <div class="row" :class="index % 2 === 0 ? 'justify-content-start' : 'justify-content-end'">
                    <div class="col-lg-8">
                        <div class="box_item_info" :class="{ 'float-lg-end': index % 2 !== 0 }" data-jarallax-element="-30">
                            <small>{{ locale === 'mk' ? 'Од' : 'From' }} €{{ formatPrice(room.price_per_night) }}/{{ locale === 'mk' ? 'ноќ' : 'night' }}</small>
                            <h2>{{ room.name }}</h2>
                            <p>{{ getShortDescription(room) }}</p>
                            
                            <div class="facilities clearfix" v-if="room.amenities && room.amenities.length > 0">
                                <ul>
                                    <li v-for="amenity in room.amenities.slice(0, 3)" :key="amenity">
                                        <i :class="getAmenityIcon(amenity)"></i> {{ getAmenityLabel(amenity) }}
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="box_item_footer d-flex align-items-center justify-content-between">
                                <a :href="bookingHref(room)" class="btn_4 learn-more">
                                    <span class="circle">
                                        <span class="icon arrow"></span>
                                    </span>
                                    <span class="button-text">{{ locale === 'mk' ? 'Резервирај' : 'Book Now' }}</span>
                                </a>
                                <Link :href="roomHref(room)" class="animated_link">
                                    <strong>{{ locale === 'mk' ? 'Прочитај повеќе' : 'Read more' }}</strong>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.search_bar_wrapper {
    margin-top: 30px;
}
.search_bar {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 5px;
    padding: 15px 20px;
    max-width: 900px;
    margin: 0 auto;
}
.search_bar .form-group {
    position: relative;
    margin: 0;
}
.search_bar .form-group input {
    border: none;
    background: transparent;
    padding-right: 40px;
    height: 50px;
}
.search_bar .form-group i {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
}
.qty-wrapper {
    padding: 0 15px;
    width: 100%;
}
.qty-wrapper label {
    margin-right: 10px;
    color: #333;
    font-weight: 500;
    white-space: nowrap;
}
.qty-buttons {
    display: flex;
    align-items: center;
    gap: 5px;
}
.qty-buttons button,
.qty-buttons .qty-btn {
    width: 32px;
    height: 32px;
    border: 1px solid #ddd;
    background: #f5f5f5;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    line-height: 32px;
    color: #333;
    transition: all 0.2s;
    display: inline-block;
    text-align: center;
    user-select: none;
}
.qty-buttons button:hover,
.qty-buttons .qty-btn:hover {
    background: #c9a961;
    border-color: #c9a961;
    color: #fff;
}
/* Hide number input spinners */
.qty-input[type="number"]::-webkit-inner-spin-button,
.qty-input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.qty-input[type="number"] {
    -moz-appearance: textfield;
}
.qty-input {
    width: 40px;
    text-align: center;
    border: none;
    background: transparent;
    font-weight: 600;
    font-size: 16px;
}
.search_bar .btn_1 {
    margin: 0;
    height: 50px;
    line-height: 50px;
    padding: 0 30px;
}
.search-btn {
    cursor: pointer;
    z-index: 10;
    position: relative;
}

@media (max-width: 991px) {
    .search_bar .row > div {
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
    }
    .search_bar .row > div:last-child {
        border-bottom: none;
    }
    .qty-wrapper {
        justify-content: space-between;
    }
}

/* Search Results Header */
.search-results-header {
    padding: 20px 30px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #c9a961;
}
.search-results-header h3 {
    margin-bottom: 5px;
    font-size: 1.5rem;
}
.search-results-header h3 .text-muted {
    font-size: 1rem;
    font-weight: 400;
}

/* No Results */
.no-results {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 60px 30px;
}
</style>
