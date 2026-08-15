<script setup>
import { usePage } from '@inertiajs/vue3';
import Layout from '@/Components/Frontend/Layout.vue';
import { useLocale } from '@/composables/useLocale';

const props = defineProps({
    page: Object,
    sections: Object,
    menuCategories: Array,
    seo: Object,
});

const { locale, ml } = useLocale();

const img = (path) => `/assets/paradise/${path}`;

const getLocalized = (obj, field) => {
    if (!obj || !obj[field]) return '';
    const value = obj[field];
    if (typeof value === 'object') {
        return value[locale.value] || value['en'] || '';
    }
    return value;
};
</script>

<template>
    <Layout
        :title="seo?.title || ml({ en: 'Restaurant À La Carte', mk: 'Ресторан À La Carte', sr: 'Restoran À La Carte', tr: 'À La Carte Restoran', sq: 'Restorant À La Carte' })"
        :description="seo?.description"
        :keywords="seo?.keywords"
        :image="seo?.image"
        :canonical="seo?.canonical"
        :schema="seo?.schema"
        :alternateUrls="seo?.alternateUrls"
    >
        <!-- Hero Section -->
        <div class="hero small-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img" :src="img('img/restaurant/restaurant_hero.webp')" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small class="slide-animated one">Alexandar Palace Hotel</small>
                    <h1 class="slide-animated two">{{ ml({ en: 'Restaurant À La Carte', mk: 'Ресторан À La Carte', sr: 'Restoran À La Carte', tr: 'À La Carte Restoran', sq: 'Restorant À La Carte' }) }}</h1>
                </div>
            </div>
        </div>

        <!-- Restaurant Intro -->
        <div class="container margin_120_95" id="first_section">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-5">
                    <div class="intro">
                        <div class="title">
                            <small>Alexandar Palace Hotel</small>
                            <h2>{{ ml({ en: 'À La Carte', mk: 'À La Carte', sr: 'À La Carte', tr: 'À La Carte', sq: 'À La Carte' }) }}</h2>
                        </div>
                        <p class="lead">{{ ml({ en: 'Experience culinary excellence at our award-winning restaurant, where traditional Macedonian flavors meet contemporary cuisine.', mk: 'Доживејте кулинарска извонредност во нашиот награден ресторан, каде традиционалните македонски вкусови се среќаваат со современата кујна.', sr: 'Doživite kulinarsku izvrsnost u našem nagrađivanom restoranu, gde se tradicionalni makedonski ukusi susreću sa savremenom kuhinjom.', tr: 'Geleneksel Makedon lezzetlerinin çağdaş mutfakla buluştuğu ödüllü restoranımızda mutfak mükemmelliğini yaşayın.', sq: 'Përjetoni përsosmërinë kulinare në restorantin tonë të vlerësuar, ku shijet tradicionale maqedonase takohen me kuzhinën bashkëkohore.' }) }}</p>
                        <p>{{ ml({ en: 'Our talented chefs craft each dish with passion, using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re enjoying a leisurely breakfast, a business lunch, or an intimate dinner, our restaurant offers an unforgettable dining experience.', mk: 'Нашите талентирани готвачи со страст го подготвуваат секое јадење, користејќи локално набавени состојки и рецепти пренесувани низ генерации. Без разлика дали уживате во опуштен појадок, деловен ручек или интимна вечера, нашиот ресторан нуди незаборавно кулинарско искуство.', sr: 'Naši talentovani kuvari sa strašću pripremaju svako jelo, koristeći lokalno nabavljene sastojke i recepte koji se prenose kroz generacije. Bilo da uživate u opuštenom doručku, poslovnom ručku ili intimnoj večeri, naš restoran nudi nezaboravno kulinarsko iskustvo.', tr: 'Yetenekli şeflerimiz, yerel olarak temin edilen malzemeler ve nesillerden nesillere aktarılan tarifler kullanarak her yemeği tutkuyla hazırlar. İster keyifli bir kahvaltının, ister iş yemeğinin, isterse samimi bir akşam yemeğinin tadını çıkarın, restoranımız unutulmaz bir yemek deneyimi sunar.', sq: 'Kuzhinierët tanë të talentuar përgatisin çdo pjatë me pasion, duke përdorur përbërës vendas dhe receta të trashëguara nga breza në breza. Qoftë duke shijuar një mëngjes të qetë, një drekë pune apo një darkë intime, restoranti ynë ofron një përvojë kulinare të paharrueshme.' }) }}</p>
                        <p><em>{{ ml({ en: 'Enjoy...the Chef', mk: 'Уживајте...со Шефот', sr: 'Uživajte...sa Šefom', tr: 'Afiyet olsun...Şef ile', sq: 'Shijoni...me Shefin' }) }}</em></p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div>
                        <ul class="list-unstyled mb-4">
                            <li class="d-flex justify-content-between mb-2 text-end">
                                <strong>{{ ml({ en: 'Breakfast', mk: 'Појадок', sr: 'Doručak', tr: 'Kahvaltı', sq: 'Mëngjesi' }) }}</strong> <span>06:30 – 10:00</span>
                            </li>
                        </ul>
                        <p>{{ ml({ en: 'The kitchen is open until 23:00.', mk: 'Кујната работи до 23:00ч.', sr: 'Kuhinja radi do 23:00č.', tr: 'Mutfak 23:00\'a kadar açıktır.', sq: 'Kuzhina punon deri në orën 23:00.' }) }}</p>
                        <div class="phone_element">
                            <i class="bi bi-telephone"></i>
                            <div class="phone_numbers">
                                <em>{{ ml({ en: 'Reservations', mk: 'Резервации', sr: 'Rezervacije', tr: 'Rezervasyonlar', sq: 'Rezervime' }) }}</em>
                                <a href="tel:+38923092156">+389 2 3092-156</a>
                                <a href="tel:+38923092167">+389 2 3092-167</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restaurant Menu -->
        <div class="pattern_3">
            <div class="container margin_120_95">
                <div class="title text-center mb-5">
                    <small data-cue="slideInUp">Alexandar Palace Hotel</small>
                    <h2 data-cue="slideInUp" data-delay="100">{{ ml({ en: 'À La Carte Menu', mk: 'Мени À La Carte', sr: 'Meni À La Carte', tr: 'À La Carte Menü', sq: 'Menyja À La Carte' }) }}</h2>
                </div>
                
                <div class="tabs_menu" data-cue="slideInUp" data-delay="200">
                    <ul class="nav nav-tabs" role="tablist">
                        <li v-for="(category, index) in menuCategories" :key="category.id" class="nav-item">
                            <a :id="`tab-${category.slug}`" :href="`#pane-${category.slug}`" class="nav-link" :class="{ active: index === 0 }" data-bs-toggle="tab" role="tab">
                                {{ getLocalized(category, 'name') }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content add_bottom_25" role="tablist">
                        <div v-for="(category, catIndex) in menuCategories" :key="category.id" :id="`pane-${category.slug}`" class="card tab-pane fade" :class="{ 'show active': catIndex === 0 }" role="tabpanel" :aria-labelledby="`tab-${category.slug}`">
                            <div class="card-header" role="tab" :id="`heading-${category.slug}`">
                                <h5>
                                    <a class="collapsed" data-bs-toggle="collapse" :href="`#collapse-${category.slug}`" :aria-expanded="catIndex === 0" :aria-controls="`collapse-${category.slug}`">
                                        {{ getLocalized(category, 'name') }}
                                    </a>
                                </h5>
                            </div>
                            <div :id="`collapse-${category.slug}`" class="collapse show" role="tabpanel" :aria-labelledby="`heading-${category.slug}`">
                                <div class="card-body">
                                    <div v-if="category.banner_image" class="banner background-image" :data-background="`url(${img(category.banner_image)})`">
                                        <div class="wrapper d-flex align-items-center justify-content-between opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
                                            <div>
                                                <small>{{ getLocalized(category, 'banner_subtitle') }}</small>
                                                <h3>{{ getLocalized(category, 'banner_title') }}</h3>
                                                <p>{{ getLocalized(category, 'banner_description') }}</p>
                                            </div>
                                            <figure class="d-none d-lg-block"><img :src="img('img/restaurant/banner.svg')" alt="" width="200" height="200" class="img-fluid"></figure>
                                        </div>
                                    </div>
                                    <div class="row magnific-gallery add_top_30">
                                        <div v-for="item in category.active_items" :key="item.id" class="col-lg-6">
                                            <div class="menu_item">
                                                <figure v-if="item.image">
                                                    <a :href="img(item.large_image || item.image)" :title="getLocalized(item, 'name')" :data-fslightbox="`gallery_${category.slug}`" data-type="image">
                                                        <img :src="img(item.image)" :alt="getLocalized(item, 'name')">
                                                    </a>
                                                </figure>
                                                <div class="menu_title">
                                                    <h3>{{ getLocalized(item, 'name') }}</h3><em>${{ item.price }}</em>
                                                </div>
                                                <p>{{ getLocalized(item, 'description') }}</p>
                                            </div>
                                        </div>
                                    </div>
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
.phone_element {
    display: flex;
    align-items: center;
    gap: 10px;
    color: inherit;
}

.phone_element i {
    font-size: 24px;
}

.phone_numbers {
    display: flex;
    flex-direction: column;
}

.phone_numbers a {
    color: inherit;
    text-decoration: none;
}

.phone_element em {
    font-size: 12px;
    opacity: 0.7;
}

/* Force collapse to show on desktop - matching original template */
@media (min-width: 991px) {
    :deep(.tabs_menu .tab-content .card .card-header) {
        display: none;
    }
    :deep(.tabs_menu .tab-content .card .collapse) {
        display: block !important;
    }
}
</style>
