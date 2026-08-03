<script setup>
import { computed, onBeforeUnmount, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    sections: { type: Array, default: () => [] },
    phone: { type: String, default: '' },
    seo: { type: Object, default: () => ({}) },
});

const asset = (path) => `/assets/paradise/${path}`;

const demoSections = [
    {
        title: 'Starters',
        subtitle: 'A dish of your choice from the list below',
        items: [
            { name: 'Marinated Shrimp', description: 'Fresh Shrimp, Olive Oil, Tomato Sauce' },
            { name: 'Avocado & Mango', description: 'Avocado, Mango, Tomatoes' },
            { name: 'Cream of Asparagus', description: 'Asparagus, Potato, Celery, Onion' },
        ],
    },
    {
        title: 'Main Dishes',
        subtitle: 'A dish of your choice from the list below',
        items: [
            { name: 'Prime Rib', description: 'Rib, Rosemary, Black pepper' },
            { name: 'Sriracha Beef', description: 'Beef, Sriracha, Spring onion' },
            { name: 'Soft shell crab', description: 'Crab, Potato, Salad' },
            { name: 'Chicken with Garlic', description: 'Chicken, Cherry tomatoes, Olive oil' },
            { name: 'Turkey Chili', description: 'Turkey, Oregano, Tomato paste' },
        ],
    },
    {
        title: 'Desserts',
        subtitle: 'A dish of your choice from the list below',
        items: [
            { name: 'Chocolate Cupcakes', description: 'Chocolate, Eggs, Vanilla' },
            { name: 'Summer Berry', description: 'Raspberries, Blackberries' },
            { name: 'Coconut Tart', description: 'Blueberries, Graham cracker crumbs' },
        ],
    },
    {
        title: 'Drinks',
        subtitle: 'A dish of your choice from the list below',
        items: [
            { name: 'Glass Red Wine', description: 'Vranec — Macedonia' },
            { name: 'Glass White Wine', description: 'Smederevka — Macedonia' },
            { name: 'Bottle of Beer', description: 'Local craft beer' },
        ],
    },
];

const menuSections = computed(() => (props.sections.length ? props.sections : demoSections));

const formatPrice = (price) => (price ? `${Number(price).toFixed(0)} MKD` : '');

let styleLink = null;

const loadDayMenuScript = () => {
    if (!window.jQuery) return false;

    const script = document.createElement('script');
    script.src = asset('js/day_menu.js');
    script.dataset.dayMenu = 'true';
    document.body.appendChild(script);

    return true;
};

onMounted(() => {
    styleLink = document.createElement('link');
    styleLink.rel = 'stylesheet';
    styleLink.href = asset('css/day_menu.css');
    styleLink.dataset.dayMenu = 'true';
    document.head.appendChild(styleLink);

    // common_scripts.js (jQuery) is deferred, so wait for it before booting the parallax script
    if (!loadDayMenuScript()) {
        const timer = setInterval(() => {
            if (loadDayMenuScript()) clearInterval(timer);
        }, 100);
        setTimeout(() => clearInterval(timer), 5000);
    }
});

onBeforeUnmount(() => {
    styleLink?.remove();
    document.querySelectorAll('script[data-day-menu]').forEach((node) => node.remove());
});
</script>

<template>
    <Head>
        <title>{{ seo.title || 'Menu of the Day' }}</title>
        <meta name="robots" content="noindex, nofollow">
    </Head>

    <section class="menu-section">
        <div class="full-container">
            <div class="intro p-3">
                <img :src="asset('img/logo.png')" width="200" height="67" alt="Alexandar Palace" class="mb-3 day-menu-logo"><br>
                Menu of the Day
                <span>Fresh selections prepared by our chef every day</span>
            </div>
        </div>
    </section>

    <section v-for="section in menuSections" :key="section.title" class="menu-section">
        <div class="full-container">
            <div class="half-container"></div>

            <div class="half-container">
                <div class="txt_container">
                    <div class="m_title">
                        <h2>{{ section.title }}</h2>
                        <p>{{ section.subtitle || 'A dish of your choice from the list below' }}</p>
                    </div>
                    <ul>
                        <li v-for="item in section.items" :key="item.name">
                            <h3>{{ item.name }}<span v-if="item.price"> — {{ formatPrice(item.price) }}</span></h3>
                            <p>{{ item.description }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="menu-section">
        <div class="full-container">
            <div class="half-container"></div>

            <div class="half-container">
                <div class="txt_container">
                    <h3>Reserve a Table</h3>
                    <p>Join us for the menu of the day at Alexandar Palace. Our team will be glad to arrange your table.</p>
                    <p v-if="phone" class="phone_us">Call Us <a :href="`tel:${phone}`">{{ phone }}</a></p>
                </div>
            </div>
        </div>
    </section>

    <nav>
        <ul class="vertical-nav">
            <li><a href="#0" class="prev inactive">Next</a></li>
            <li><a href="#0" class="next">Prev</a></li>
        </ul>
    </nav>

    <nav>
        <ul class="top-nav">
            <li>
                <Link href="/restaurant" class="back"><i class="bi bi-arrow-90deg-left"></i></Link>
            </li>
        </ul>
    </nav>
</template>

<style>
.day-menu-logo { display: block; height: auto; margin-left: auto; margin-right: auto; max-width: 220px; width: 60%; }
</style>
