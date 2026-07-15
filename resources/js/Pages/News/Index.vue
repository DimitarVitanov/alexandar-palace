<script setup>
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Components/Frontend/Layout.vue';

const props = defineProps({
    news: Object,
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
            <img class="jarallax-img" :src="asset('img/hero_home_1.jpg')" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="title white">
                        <h1>{{ t('home.news_title') }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="container margin_120_95">
            <div class="row justify-content-center home">
                <div v-for="post in news.data" :key="post.id" class="item col-xl-4 col-lg-6">
                    <Link :href="`/news/${post.slug}`" class="box_contents">
                        <figure><img :src="asset(post.featured_image)" alt="" class="img-fluid"><em>{{ post.published_at }}</em></figure>
                        <div class="wrapper">
                            <small>{{ post.category }}<span></span></small>
                            <h2>{{ post.title }}</h2>
                            <em>Read more</em>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </Layout>
</template>
