<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t, locale } = useI18n();
const page = usePage();
const menuOpen = ref(false);
const activeItem = ref(null);
const isNavigating = ref(false);

const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
    document.body.classList.toggle('no_scroll', menuOpen.value);
    document.querySelector('header')?.classList.toggle('header_color', menuOpen.value);
};

const closeMenu = () => {
    menuOpen.value = false;
    document.body.classList.remove('no_scroll');
    document.querySelector('header')?.classList.remove('header_color');
};

const navigateTo = (href) => {
    if (isNavigating.value) return;
    isNavigating.value = true;
    
    // Close menu with animation
    closeMenu();
    
    // Wait for menu close animation (600ms from CSS), then navigate
    setTimeout(() => {
        window.location.href = href;
    }, 600);
};

const setLocale = (lang) => {
    locale.value = lang;
    window.location.href = `/locale/${lang}`;
};

const asset = (path) => `/assets/paradise/${path}`;

const navItems = computed(() => [
    { label: t('nav.home'), href: '/', image: 'img/490891522_9769845339721129_8431070351770986907_n.jpg' },
    { label: t('nav.about'), href: '/about', image: 'img/490891522_9769845339721129_8431070351770986907_n.jpg' },
    { label: t('nav.rooms'), href: '/rooms', image: 'img/490891522_9769845339721129_8431070351770986907_n.jpg' },
    { label: t('nav.restaurant'), href: '/restaurant', image: 'img/restaurant/slides/slide_1.jpg' },
    { label: t('nav.tennis_restaurant'), href: '/tennis-restaurant', image: 'img/tennis-restaurant/tennis-restaurant-hero.jpg' },
    { label: t('nav.congress'), href: '/congress-center', image: 'img/congress/Kongresnasala1-400x300.jpg' },
    { label: t('nav.celebrations'), href: '/celebrations', image: 'img/celebrations/svadba-1-400x340.jpg' },
    { label: t('nav.activities'), href: '/activities', image: 'img/activities/teniszaweb.webp' },
    // { label: t('nav.news'), href: '/news', image: 'img/490891522_9769845339721129_8431070351770986907_n.jpg' },
    { label: t('nav.contact'), href: '/contacts', image: 'img/490891522_9769845339721129_8431070351770986907_n.jpg' },
]);
</script>

<template>
    <header class="reveal_header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-6">
                    <Link href="/" class="logo_normal">
                        <img :src="asset('img/logo.png')" width="135" height="45" alt="Alexandar Palace">
                    </Link>
                    <Link href="/" class="logo_sticky">
                        <img :src="asset('img/logo_sticky.png')" width="135" height="45" alt="Alexandar Palace">
                    </Link>
                </div>
                <div class="col-6">
                    <nav>
                        <ul>
                            <li><Link href="/booking" class="btn_1">{{ t('nav.book_now') }}</Link></li>
                            <li>
                                <a href="#0" class="menu_open" @click.prevent="toggleMenu">
                                    <div class="hamburger hamburger--spin" :class="{ 'is-active': menuOpen }">
                                        <div class="hamburger-box">
                                            <div class="hamburger-inner"></div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="panel_menu" :class="{ active: menuOpen }">
        <div class="panel__content">
            <div class="panel__content_wrapper">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-lg-5">
                            <nav class="wrapper_menu" :class="{ hover: activeItem !== null }">
                                <ul>
                                    <li v-for="item in navItems" :key="item.href">
                                        <div class="container-item" :class="{ active: activeItem === item.href }" @mouseenter="activeItem = item.href" @mouseleave="activeItem = null">
                                            <a href="#" class="link" @click.prevent="navigateTo(item.href)">{{ item.label }}</a>
                                            <div class="image">
                                                <img :src="asset(item.image)" :alt="item.label">
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-lg-6 d-flex align-items-end">
                            <div class="menu_panel_details">
                                <div class="row justify-content-between">
                                    <div class="col-lg-6 mb-lg-0 mb-4">
                                        <h5>Address</h5>
                                        <p>Blvd. 8th September No. 15<br>Skopje, Macedonia</p>
                                        <div class="styled-select lang-selector">
                                            <select :value="locale" @change="setLocale($event.target.value)">
                                                <option value="en">English</option>
                                                <option value="mk">Macedonian</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 mb-lg-0 mb-4">
                                        <h5>Contacts</h5>
                                        <div class="contacts">
                                            <ul>
                                                <li><a href="tel://38923092392">+389 (2) 3092 392</a></li>
                                                <li><a href="mailto:info@aleksandarpalace.com.mk">info@aleksandarpalace.com.mk</a></li>
                                                <li><a href="mailto:sales@aleksandarpalace.com.mk">sales@aleksandarpalace.com.mk</a></li>
                                                <li><a href="mailto:spa@aleksandarpalace.com.mk">spa@aleksandarpalace.com.mk</a></li>
                                            </ul>
                                        </div>
                                        <div class="social">
                                            <ul>
                                                <li><a href="https://www.instagram.com/hotelaleksandarpalace/"><i class="bi bi-instagram"></i></a></li>
                                                <li class="d-none"><a href="#0"><i class="bi bi-whatsapp"></i></a></li>
                                                <li><a href="https://www.facebook.com/hotelaleksandarpalace"><i class="bi bi-facebook"></i></a></li>
                                                <li class="d-none"><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
                                            </ul>
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
</template>

