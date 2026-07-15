<script setup>
import { Link } from '@inertiajs/vue3';
import Layout from '@/Components/Frontend/Layout.vue';

const props = defineProps({
    news: Object,
    related: Array,
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
        :ogType="seo.ogType"
        :publishedTime="seo.publishedTime"
        :modifiedTime="seo.modifiedTime"
        :section="seo.section"
        :tags="seo.tags"
    >
        <div class="hero medium-height jarallax">
            <img class="jarallax-img" :src="asset(news.featured_image)" :alt="news.title">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="title white">
                        <small>{{ news.category }}</small>
                        <h1>{{ news.title }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="container margin_120_95">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="intro">
                        <div v-html="news.content"></div>
                    </div>
                </div>
            </div>

            <div v-if="related.length" class="row mt-5">
                <div class="col-12">
                    <h3>Related News</h3>
                </div>
                <div v-for="post in related" :key="post.id" class="item col-xl-4 col-lg-6">
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
