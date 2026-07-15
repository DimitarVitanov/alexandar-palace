<script setup>
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';

const props = defineProps({
    items: Object,
    seo: Object,
});

const { t } = useI18n();
const asset = (path) => `/assets/paradise/${path}`;
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
                <h3 class="mb-3">{{ category }}</h3>
                <div class="row">
                    <div v-for="item in categoryItems" :key="item.id" class="col-md-4 col-sm-6 mb-4">
                        <a :href="asset(item.image)" class="img_container">
                            <img :src="asset(item.image)" :alt="item.title" class="img-fluid rounded">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
