<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';
import Layout from '@/Components/Frontend/Layout.vue';

const props = defineProps({
    page: Object,
    sections: Object,
    testimonials: Array,
    settings: Object,
    seo: Object,
});

const { t } = useI18n();
const page = usePage();
const locale = computed(() => page.props.locale || 'en');

const asset = (path) => `/assets/paradise/${path}`;

// Section helpers with fallbacks
const hero = props.sections?.hero;
const history = props.sections?.history;
const amenities = props.sections?.local_amenities;
const facilities = props.sections?.facilities;
const faq = props.sections?.faq;

// Parse JSON data arrays
const amenitiesList = amenities?.data?.items || [
    { 
        title: 'Local Restaurants', 
        description: 'Discover the authentic flavors of Skopje, from traditional Macedonian taverns to modern fine dining. Enjoy local specialties such as tavče gravče, grilled meats, fresh salads, and homemade desserts in welcoming restaurants throughout the city.',
        links: [
            { name: 'Skopski Merak', url: 'https://www.google.com/maps/dir/?api=1&destination=Restaurant%20Skopski%20Merak%2CDebarca%20St%2051%2C%201000%2C%20Skopje%201000%2C%20North%20Macedonia' },
            { name: 'Pelister', url: 'https://www.google.com/maps/dir/?api=1&destination=Pelister%2CBoulevard%20Macedonia%2C%20Skopje%201000%2C%20North%20Macedonia' },
            { name: 'Vodenica Mulino', url: 'https://www.google.com/maps/dir/?api=1&destination=Vodenica%20Mulino%2CMitropolit%20Teodosij%20Gologanov%2069%2C%20Skopje%201000%2C%20North%20Macedonia' },
        ]
    },
    { 
        title: 'Nature', 
        description: 'Escape into nature just minutes from the city center. Visit the breathtaking Matka Canyon Skopje, where you can enjoy hiking, kayaking, boat tours, and spectacular limestone cliffs. For panoramic views over the city, take a walk or cable car up Mount Vodno and experience one of Skopje\'s most beautiful landscapes.',
    },
    { 
        title: 'Art & Culture', 
        description: 'Skopje blends centuries of history with contemporary creativity. Wander through the historic Old Bazaar, visit the Museum of Contemporary Art Skopje, explore Kale Fortress, and admire the city\'s museums, galleries, and monuments. From Ottoman architecture to modern exhibitions, Skopje offers a rich cultural experience for every visitor.',
        links: [
            { name: 'Museum of Contemporary Art', url: 'https://www.google.com/maps/dir/?api=1&destination=Museum%20of%20Contemporary%20Art%20Skopje%2CSamoilova%2017%2C%20Skopje%201000%2C%20North%20Macedonia' },
        ]
    },
];

const facilitiesData = {
    en: [
        { icon: 'customicon-private-parking', title: 'Private Parking', description: 'Complimentary private parking is available for all hotel guests, ensuring a convenient and secure stay.' },
        { icon: 'customicon-wifi', title: 'High Speed Wifi', description: 'Stay connected with complimentary high-speed WiFi available throughout the hotel and in all rooms.' },
        { icon: 'customicon-cocktail', title: 'Bar & Restaurant', description: 'Enjoy exquisite dining at our restaurant and unwind at our bar with a selection of fine wines and cocktails.' },
        { icon: 'customicon-swimming-pool', title: 'Swimming Pool', description: 'Relax and refresh in our indoor swimming pool, perfect for a rejuvenating swim any time of year.' },
    ],
    mk: [
        { icon: 'customicon-private-parking', title: 'Приватен Паркинг', description: 'Бесплатен приватен паркинг е достапен за сите гости на хотелот.' },
        { icon: 'customicon-wifi', title: 'Брз WiFi', description: 'Останете поврзани со бесплатен брз WiFi достапен низ целиот хотел.' },
        { icon: 'customicon-cocktail', title: 'Бар и Ресторан', description: 'Уживајте во извонредна храна во нашиот ресторан и опуштете се во нашиот бар.' },
        { icon: 'customicon-swimming-pool', title: 'Базен', description: 'Релаксирајте и освежете се во нашиот затворен базен.' },
    ]
};
const facilitiesList = computed(() => facilities?.data?.items || facilitiesData[locale.value] || facilitiesData.en);

const faqData = {
    en: [
        { question: 'Cancellation Policy', answer: 'Free cancellation is available up to 48 hours before check-in. Cancellations made within 48 hours of arrival may be subject to a charge equivalent to one night\'s stay. No-shows will be charged the full reservation amount.' },
        { question: 'Payment Methods', answer: 'We accept all major credit cards (Visa, MasterCard, American Express), bank transfers, and cash payments. A valid credit card is required at check-in for incidentals. Full payment can be made upon arrival or departure.' },
        { question: 'Check In / Out Times', answer: 'Check-in time is from 14:00 (2:00 PM). Check-out time is until 11:00 (11:00 AM). Early check-in and late check-out may be available upon request, subject to availability and additional charges.' },
        { question: 'Accessibility', answer: 'Our hotel is fully accessible for guests with disabilities. We offer accessible rooms, ramps, elevators, and accessible parking spaces. Please contact us in advance to arrange any special requirements.' },
    ],
    mk: [
        { question: 'Политика за Откажување', answer: 'Бесплатно откажување е достапно до 48 часа пред пријавување. Откажувањата направени во рок од 48 часа од пристигнувањето може да бидат наплатени еквивалентно на една ноќевање.' },
        { question: 'Начини на Плаќање', answer: 'Прифаќаме сите главни кредитни картички (Visa, MasterCard, American Express), банкарски трансфери и готовински плаќања. Валидна кредитна картичка е потребна при пријавување.' },
        { question: 'Време на Пријавување / Одјавување', answer: 'Времето за пријавување е од 14:00 часот. Времето за одјавување е до 11:00 часот. Рано пријавување и доцно одјавување може да бидат достапни на барање.' },
        { question: 'Пристапност', answer: 'Нашиот хотел е целосно пристапен за гости со попреченост. Нудиме пристапни соби, рампи, лифтови и пристапни паркинг места. Контактирајте нè однапред за посебни барања.' },
    ]
};
const faqList = computed(() => faq?.data?.items || faqData[locale.value] || faqData.en);

const amenitiesImages = amenities?.data?.images || ['img/about/restaurants.webp', 'img/about/nature.webp', 'img/about/culture.webp'];

// Vue-controlled accordion state
import { ref } from 'vue';
const openFaqIndex = ref(null);

const toggleFaq = (index) => {
    openFaqIndex.value = openFaqIndex.value === index ? null : index;
};
</script>

<template>
    <Layout
        :title="seo?.title || 'About Us'"
        :description="seo?.description"
        :keywords="seo?.keywords"
        :image="seo?.image"
        :canonical="seo?.canonical"
        :schema="seo?.schema"
        :alternateUrls="seo?.alternateUrls"
    >
        <!-- Hero Section -->
        <div class="hero small-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img about-hero-img" :src="hero?.image ? asset(hero.image) : asset('img/about-us-modified.webp')" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small class="slide-animated one">{{ hero?.subtitle || 'Luxury Hotel Experience' }}</small>
                    <h1 class="slide-animated two">{{ hero?.title || 'About Alexandar Palace' }}</h1>
                </div>
            </div>
        </div>

        <!-- Our History Section -->
        <div class="container margin_120_95">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-5">
                    <div class="parallax_wrapper inverted">
                        <img :src="history?.data?.image1 ? asset(history.data.image1) : asset('img/about-1.webp')" alt="" class="img-fluid rounded-img history-img">
                        <div data-cue="slideInUp" class="img_over">
                            <span data-jarallax-element="-30">
                                <img :src="history?.data?.image2 ? asset(history.data.image2) : asset('img/about-us-two.webp')" alt="" class="rounded-img">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="intro">
                        <div class="title">
                            <small>{{ history?.subtitle || 'Alexandar Palace Hotel' }}</small>
                            <h2>{{ history?.title || 'Our History' }}</h2>
                        </div>
                        <div v-if="history?.content" v-html="history.content"></div>
                        <template v-else>
                            <p class="lead">The hotel Aleksandar Palace, leading hotel in Macedonia, is located on the right bank of the river Vardar next to the city park, only 3 km away from the town center and just next to the most important administrative, cultural and historical buildings.</p>
                           <!-- <p><em>Maria...the Owner</em></p> -->
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Local Amenities Section -->
        <div class="bg_white">
            <div class="container margin_120_95">
                <div class="row justify-content-between">
                    <div class="col-lg-5 fixed_title">
                        <div class="title">
                            <small>{{ amenities?.subtitle || 'Alexandar Palace Hotel' }}</small>
                            <h2>{{ amenities?.title || 'Local Amenities' }}</h2>
                            <p v-if="amenities?.content" v-html="amenities.content"></p>
                            <p v-else>{{ t('about.local_amenities_text') }}</p>
                        </div>
                        <div class="list_ok">
                            <ul>
                                <li v-for="(item, index) in amenitiesList" :key="index" data-cue="slideInUp" :data-delay="200 + (index * 100)">
                                    <h5>{{ item.title }}</h5>
                                    <p>{{ item.description }}</p>
                                    <p v-if="item.links && item.links.length" class="mt-2">
                                        <template v-for="(link, linkIndex) in item.links" :key="linkIndex">
                                            <a :href="link.url" target="_blank" rel="noopener" class="animated_link me-3"><strong>{{ link.name }} <i class="bi bi-geo-alt"></i></strong></a>
                                        </template>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div v-for="(img, index) in amenitiesImages" :key="index" data-cue="fadeIn" data-delay="500">
                            <figure><img :src="asset(img)" alt="" class="img-fluid rounded-img"></figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Section (hidden) -->
        <div class="parallax_section_1 jarallax d-none" data-jarallax data-speed="0.2">
            <img class="jarallax-img" :src="asset('img/hero_home_1.jpg')" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="title white">
                                <small class="mb-1">Testimonials</small>
                                <h2>What Clients Says</h2>
                            </div>
                            <div class="carousel_testimonials owl-carousel owl-theme nav-dots-orizontal">
                                <div v-for="(testimonial, index) in (testimonials || [])" :key="index">
                                    <div class="box_overlay">
                                        <div class="pic">
                                            <figure><img :src="asset('img/testimonial_1.jpg')" alt="" class="img-circle"></figure>
                                            <h4>{{ testimonial.name }}<small>{{ testimonial.date }}</small></h4>
                                        </div>
                                        <div class="comment">"{{ testimonial.content }}"</div>
                                    </div>
                                </div>
                                <!-- Default testimonials if none provided -->
                                <div v-if="!testimonials || testimonials.length === 0">
                                    <div class="box_overlay">
                                        <div class="pic">
                                            <figure><img :src="asset('img/testimonial_1.jpg')" alt="" class="img-circle"></figure>
                                            <h4>Roberta<small>12 Oct</small></h4>
                                        </div>
                                        <div class="comment">"Mea ad postea meliore fuisset. Timeam repudiare id eum, ex paulo dictas elaboraret sed, mel cu unum nostrud."</div>
                                    </div>
                                </div>
                                <div v-if="!testimonials || testimonials.length === 0">
                                    <div class="box_overlay">
                                        <div class="pic">
                                            <figure><img :src="asset('img/testimonial_1.jpg')" alt="" class="img-circle"></figure>
                                            <h4>John<small>2 Nov</small></h4>
                                        </div>
                                        <div class="comment">"Mea ad postea meliore fuisset. Timeam repudiare id eum, ex paulo dictas elaboraret sed, mel cu unum nostrud."</div>
                                    </div>
                                </div>
                                <div v-if="!testimonials || testimonials.length === 0">
                                    <div class="box_overlay">
                                        <div class="pic">
                                            <figure><img :src="asset('img/testimonial_1.jpg')" alt="" class="img-circle"></figure>
                                            <h4>Sarah<small>3 Dec</small></h4>
                                        </div>
                                        <div class="comment">"Mea ad postea meliore fuisset. Timeam repudiare id eum, ex paulo dictas elaboraret sed, mel cu unum nostrud."</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Facilities Section -->
        <div class="container margin_120_95">
            <div class="title text-center mb-5">
                <small data-cue="slideInUp">{{ facilities?.subtitle || 'Alexandar Palace Hotel' }}</small>
                <h2 data-cue="slideInUp" data-delay="100">{{ facilities?.title || 'Main Facilities' }}</h2>
            </div>
            <div class="row mt-4">
                <div v-for="(facility, index) in facilitiesList" :key="index" class="col-lg-3 col-md-6">
                    <div class="box_facilities" :class="{ 'no-border': index === 0 }" data-cue="slideInUp">
                        <i :class="facility.icon"></i>
                        <h3>{{ facility.title }}</h3>
                        <p>{{ facility.description }}</p>
                    </div>
                </div>
            </div>

            <hr class="more_margin">

            <!-- FAQ Section -->
            <div class="row justify-content-between margin_60_0">
                <div class="col-lg-4">
                    <div class="title">
                        <small>{{ faq?.subtitle || (locale === 'mk' ? 'Александар Палас Хотел' : 'Alexandar Palace Hotel FAQ') }}</small>
                        <h3>{{ faq?.title || (locale === 'mk' ? 'Често Поставувани Прашања' : 'Frequently Asked Questions') }}</h3>
                    </div>
                    <p v-if="faq?.content" v-html="faq.content"></p>
                    <p v-else>{{ locale === 'mk' ? 'Не го најдовте вашето прашање? Контактирајте нè.' : "Can't find your question in the list? Let us know your questions." }}</p>
                    <p><Link href="/contacts" class="animated_link"><strong>{{ locale === 'mk' ? 'Контактирајте нè' : 'Contact Us' }} <i class="bi bi-arrow-right"></i></strong></Link></p>
                </div>
                <div class="col-lg-7">
                    <div class="mb-5 accordion about-faq-accordion">
                        <div v-for="(item, index) in faqList" :key="index" class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <a href="#" @click.prevent="toggleFaq(index)" :class="{ 'collapsed': openFaqIndex !== index }">
                                        <i class="indicator bi-plus-lg"></i>{{ item.question }}
                                    </a>
                                </h5>
                            </div>
                            <Transition name="faq-slide">
                                <div v-show="openFaqIndex === index" class="faq-content">
                                    <div class="card-body">
                                        <p>{{ item.answer }}</p>
                                    </div>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.about-hero-img {
    object-position: 80% 80% !important;
}

.history-img {
    max-width: 600px;
}

/* Fix mobile overflow */
@media (max-width: 991px) {
    :deep(.parallax_wrapper) {
        overflow: hidden;
    }
    
    :deep(.img_over) {
        position: relative;
        margin-top: -50px;
    }
}

@media (max-width: 767px) {
    :deep(.parallax_wrapper),
    :deep(.parallax_wrapper.inverted) {
        max-width: 100%;
        overflow: hidden;
    }
    
    :deep(.img_over) {
        position: relative;
        margin-top: 0;
        padding: 15px;
    }
    
    :deep(.img_over span) {
        position: relative;
        left: 0;
        right: 0;
    }
    
    .history-img {
        max-width: 100%;
    }
}

/* Vue-controlled FAQ accordion styles */
.about-faq-accordion .card-body {
    padding: 15px 20px;
}

.about-faq-accordion .card-body p {
    margin: 0;
    color: #555;
    line-height: 1.7;
}

.about-faq-accordion .faq-content {
    display: block;
}

.about-faq-accordion .card-header a:not(.collapsed) i.indicator {
    transform: rotate(45deg);
}

/* FAQ slide transition */
.faq-slide-enter-active,
.faq-slide-leave-active {
    transition: all 0.5s ease;
    overflow: hidden;
}

.faq-slide-enter-from,
.faq-slide-leave-to {
    opacity: 0;
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
}

.faq-slide-enter-to,
.faq-slide-leave-from {
    opacity: 1;
    max-height: 500px;
}
</style>
