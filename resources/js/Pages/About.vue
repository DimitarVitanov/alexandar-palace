<script setup>
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';

const props = defineProps({
    page: Object,
    sections: Object,
    testimonials: Array,
    settings: Object,
    seo: Object,
});

const { t } = useI18n();

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

const facilitiesList = facilities?.data?.items || [
    { icon: 'customicon-private-parking', title: 'Private Parking', description: 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.' },
    { icon: 'customicon-wifi', title: 'High Speed Wifi', description: 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium.' },
    { icon: 'customicon-cocktail', title: 'Bar & Restaurant', description: 'Similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.' },
    { icon: 'customicon-swimming-pool', title: 'Swimming Pool', description: 'Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.' },
];

const faqList = faq?.data?.items || [
    { question: 'Cancellation', answer: 'Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.' },
    { question: 'Payments', answer: 'Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.' },
    { question: 'Check In / Out Rules', answer: 'Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.' },
    { question: 'Disable Access', answer: 'Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.' },
];

const amenitiesImages = amenities?.data?.images || ['img/about/restaurants.webp', 'img/about/nature.webp', 'img/about/culture.webp'];
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
            <img class="jarallax-img about-hero-img" :src="hero?.image ? asset(hero.image) : asset('img/about-us.webp')" alt="">
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

        <!-- Testimonials Section -->
        <div class="parallax_section_1 jarallax" data-jarallax data-speed="0.2">
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
                        <small>{{ faq?.subtitle || 'Alexandar Palace Hotel Faq' }}</small>
                        <h3>{{ faq?.title || 'Frequently Questions' }}</h3>
                    </div>
                    <p v-if="faq?.content" v-html="faq.content"></p>
                    <p v-else>Can't find your question in the list? Let us know your questions.</p>
                    <p><Link href="/contacts" class="animated_link"><strong>Contact Us <i class="bi bi-arrow-right"></i></strong></Link></p>
                </div>
                <div class="col-lg-7">
                    <div role="tablist" class="mb-5 accordion" id="faq">
                        <div v-for="(item, index) in faqList" :key="index" class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-bs-toggle="collapse" :href="`#collapse_${index}`" aria-expanded="false">
                                        <i class="indicator bi-plus-lg"></i>{{ item.question }}
                                    </a>
                                </h5>
                            </div>
                            <div :id="`collapse_${index}`" class="collapse" role="tabpanel" data-bs-parent="#faq">
                                <div class="card-body">
                                    <p v-html="item.answer"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.about-hero-img {
    object-position: center bottom;
}

.history-img {
    max-width: 600px;
}
</style>
