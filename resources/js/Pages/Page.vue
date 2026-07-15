<script setup>
import Layout from '@/Components/Frontend/Layout.vue';

const props = defineProps({
    page: Object,
    sections: Object,
    seo: Object,
});

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
            <img class="jarallax-img" :src="asset('img/hero_home_1.jpg')" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="title white">
                        <small>{{ page.title }}</small>
                        <h1>{{ page.title }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="container margin_120_95">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="intro">
                        <div v-html="page.content"></div>
                    </div>
                </div>
            </div>
            <div v-if="sections" class="row mt-5">
                <div v-for="section in sections" :key="section.id" class="col-lg-12 mb-4">
                    <div v-if="section.image" class="mb-3">
                        <img :src="asset(section.image)" class="img-fluid rounded" :alt="section.title">
                    </div>
                    <h3>{{ section.title }}</h3>
                    <div v-html="section.content"></div>
                </div>
            </div>
        </div>
    </Layout>
</template>
