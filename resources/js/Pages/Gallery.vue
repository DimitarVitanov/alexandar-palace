<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { usePage } from '@inertiajs/vue3';
import Layout from '@/Components/Frontend/Layout.vue';

const props = defineProps({
    items: Object,
    seo: Object,
});

const { t } = useI18n();
const page = usePage();
const locale = computed(() => page.props.locale || 'en');
const asset = (path) => `/assets/paradise/${path}`;

// Gallery categories are stored in the database as plain (English) strings,
// so we translate the known ones here for display when the locale is 'mk'.
const categoryLabels = {
    Hotel: { en: 'Hotel', mk: 'Хотел', sr: 'Hotel', tr: 'Otel', sq: 'Hotel' },
    Restaurant: { en: 'Restaurant', mk: 'Ресторан', sr: 'Restoran', tr: 'Restoran', sq: 'Restorant' },
    Rooms: { en: 'Rooms', mk: 'Соби', sr: 'Sobe', tr: 'Odalar', sq: 'Dhoma' },
    Spa: { en: 'Spa', mk: 'Спа', sr: 'Spa', tr: 'Spa', sq: 'Spa' },
    Pool: { en: 'Pool', mk: 'Базен', sr: 'Bazen', tr: 'Havuz', sq: 'Pishinë' },
    Events: { en: 'Events', mk: 'Настани', sr: 'Dešavanja', tr: 'Etkinlikler', sq: 'Ngjarje' },
    Congress: { en: 'Congress', mk: 'Конгресен Центар', sr: 'Kongresni Centar', tr: 'Kongre Merkezi', sq: 'Qendra e Kongreseve' },
    Exterior: { en: 'Exterior', mk: 'Надворешност', sr: 'Eksterijer', tr: 'Dış Mekan', sq: 'Jashtë' },
    Interior: { en: 'Interior', mk: 'Ентериер', sr: 'Enterijer', tr: 'İç Mekan', sq: 'Brenda' },
};

const categoryLabel = (category) => categoryLabels[category]?.[locale.value] || category;

// item.title/description may come from the backend as either a plain string
// or a { en, mk } localized object (GalleryItem casts them to array/JSON).
const localizedText = (value) => {
    if (value && typeof value === 'object') {
        return value[locale.value] || value.en || Object.values(value)[0] || '';
    }
    return value || '';
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
        <div class="hero medium-height jarallax">
            <img class="jarallax-img" :src="`/assets/paradise/img/hero_home_1.jpg`" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="title white">
                        <h1>{{ t('nav.gallery') }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="container margin_120_95">
            <div v-for="(categoryItems, category) in items" :key="category" class="mb-5">
                <h3 class="mb-3">{{ categoryLabel(category) }}</h3>
                <div class="row">
                    <div v-for="item in categoryItems" :key="item.id" class="col-md-4 col-sm-6 mb-4">
                        <a :href="asset(item.image)" class="img_container">
                            <img :src="asset(item.image)" :alt="localizedText(item.title) || categoryLabel(category)" class="img-fluid rounded">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
