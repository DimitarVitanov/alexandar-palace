<script setup>
import { onMounted, onUnmounted, computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import Header from './Header.vue';
import Footer from './Footer.vue';
import { initParadise } from '@/init-paradise';

const props = defineProps({
    title: { type: String, default: '' },
    description: { type: String, default: '' },
    keywords: { type: String, default: '' },
    image: { type: String, default: '' },
    canonical: { type: String, default: '' },
    alternateUrls: { type: Object, default: () => ({}) },
    noIndex: { type: Boolean, default: false },
    ogType: { type: String, default: 'website' },
    schema: { type: [Object, Array], default: null },
    breadcrumbs: { type: Array, default: () => [] },
    author: { type: String, default: '' },
    publishedTime: { type: String, default: '' },
    modifiedTime: { type: String, default: '' },
    section: { type: String, default: '' },
    tags: { type: Array, default: () => [] },
});

const page = usePage();
const siteName = computed(() => page.props.seo?.site_name || 'Alexandar Palace');
const defaultImage = computed(() => page.props.seo?.default_image || '/assets/paradise/img/hero_home_1.jpg');
const locale = computed(() => page.props.locale || 'en');

let schemaScript = null;

onMounted(() => {
    initParadise();
    
    // Inject schema.org JSON-LD manually to avoid re-render loops
    if (props.schema) {
        schemaScript = document.createElement('script');
        schemaScript.type = 'application/ld+json';
        schemaScript.textContent = JSON.stringify(Array.isArray(props.schema) ? props.schema : [props.schema]);
        document.head.appendChild(schemaScript);
    }
});

onUnmounted(() => {
    if (schemaScript && schemaScript.parentNode) {
        schemaScript.parentNode.removeChild(schemaScript);
    }
    
    // Reset hero animation for next page
    const hero = document.querySelector('.animate_hero');
    if (hero) {
        hero.classList.remove('is-transitioned');
    }
    
    // Clean up jarallax instances
    if (typeof window.jarallax !== 'undefined') {
        document.querySelectorAll('[data-jarallax], [data-jarallax-video]').forEach((el) => {
            if (el._jarallax) {
                el._jarallax.destroy();
            }
        });
    }
    
    // Clean up ScrollTrigger instances
    if (typeof window.ScrollTrigger !== 'undefined') {
        window.ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
    }
});
</script>

<template>
    <Head>
        <title>{{ title }}</title>
        
        <!-- Primary Meta Tags -->
        <meta v-if="description" name="description" :content="description">
        <meta v-if="keywords" name="keywords" :content="keywords">
        <meta v-if="author" name="author" :content="author">
        <meta v-if="noIndex" name="robots" content="noindex, nofollow">
        <meta v-else name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
        <link v-if="canonical" rel="canonical" :href="canonical">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" :content="ogType">
        <meta property="og:site_name" :content="siteName">
        <meta property="og:title" :content="title">
        <meta v-if="description" property="og:description" :content="description">
        <meta property="og:image" :content="image || defaultImage">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta v-if="canonical" property="og:url" :content="canonical">
        <meta property="og:locale" :content="locale === 'mk' ? 'mk_MK' : 'en_US'">
        <meta v-if="locale === 'en'" property="og:locale:alternate" content="mk_MK">
        <meta v-if="locale === 'mk'" property="og:locale:alternate" content="en_US">
        
        <!-- Article specific (for news/blog) -->
        <meta v-if="publishedTime" property="article:published_time" :content="publishedTime">
        <meta v-if="modifiedTime" property="article:modified_time" :content="modifiedTime">
        <meta v-if="section" property="article:section" :content="section">
        <meta v-for="tag in tags" :key="tag" property="article:tag" :content="tag">
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" :content="title">
        <meta v-if="description" name="twitter:description" :content="description">
        <meta name="twitter:image" :content="image || defaultImage">
        
        <!-- Alternate Languages -->
        <link v-for="(url, loc) in alternateUrls" :key="loc" rel="alternate" :hreflang="loc" :href="url">
        <link v-if="Object.keys(alternateUrls).length > 0" rel="alternate" hreflang="x-default" :href="alternateUrls.en || canonical">
        
        <!-- Additional SEO -->
        <meta name="format-detection" content="telephone=no">
        <meta name="theme-color" content="#1a1a1a">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        
        <!-- Geo Tags -->
        <meta name="geo.region" content="MK">
        <meta name="geo.placename" content="Skopje">
    </Head>

    <div class="layer"></div>

    <Header />

    <main>
        <slot />
    </main>

    <Footer />
</template>
