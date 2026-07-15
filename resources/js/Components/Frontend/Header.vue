<script setup>
import { ref } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t, locale } = useI18n();
const page = usePage();
const menuOpen = ref(false);
const activeItem = ref(null);

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
    // Start closing menu animation (slides up)
    closeMenu();
    
    // Fade out content while menu is sliding
    document.querySelector('main')?.classList.add('page-transitioning');
    
    // Wait for menu slide animation (600ms from CSS), then navigate
    setTimeout(() => {
        router.visit(href, {
            preserveScroll: false,
            onFinish: () => {
                document.querySelector('main')?.classList.remove('page-transitioning');
            }
        });
    }, 500); // Slightly less than 600ms so navigation starts as menu finishes
};

const setLocale = (lang) => {
    locale.value = lang;
    window.location.href = `/locale/${lang}`;
};

const asset = (path) => `/assets/paradise/${path}`;

const navItems = [
    { label: t('nav.home'), href: '/', image: 'img/490891522_9769845339721129_8431070351770986907_n.jpg' },
    { label: t('nav.rooms'), href: '/rooms', image: 'img/490891522_9769845339721129_8431070351770986907_n.jpg' },
    { label: t('nav.about'), href: '/about', image: 'img/490891522_9769845339721129_8431070351770986907_n.jpg' },
    { label: t('nav.news'), href: '/news', image: 'img/490891522_9769845339721129_8431070351770986907_n.jpg' },
    { label: t('nav.contact'), href: '/contacts', image: 'img/490891522_9769845339721129_8431070351770986907_n.jpg' },
];
</script>

<template>
    <header class="reveal_header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-6">
                    <Link href="/" class="logo_normal">
                        <img :src="`/assets/paradise/img/logo.png`" width="135" height="45" alt="Alexandar Palace">
                    </Link>
                    <Link href="/" class="logo_sticky">
                        <img :src="`/assets/paradise/img/logo_sticky.png`" width="135" height="45" alt="Alexandar Palace">
                    </Link>
                </div>
                <div class="col-6">
                    <nav>
                        <ul>
                            <li><a href="#booking_section" class="btn_1">{{ t('nav.book_now') }}</a></li>
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
                                        <p>Baker Street 567<br>London UK</p>
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
                                                <li><a href="tel://61280932400">+ 61 23 8093 3400</a></li>
                                                <li><a href="mailto:info@alexandarpalace.com">info@alexandarpalace.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="social">
                                            <ul>
                                                <li><a href="#0"><i class="bi bi-instagram"></i></a></li>
                                                <li><a href="#0"><i class="bi bi-whatsapp"></i></a></li>
                                                <li><a href="#0"><i class="bi bi-facebook"></i></a></li>
                                                <li><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
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

<style scoped>
.panel_menu.active {
    visibility: visible;
    opacity: 1;
}
</style>
