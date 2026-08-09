<script setup>
import { computed, onBeforeUnmount, onMounted } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { useLocale } from '@/composables/useLocale';

const props = defineProps({
    sections: { type: Array, default: () => [] },
    phone: { type: String, default: '' },
    seo: { type: Object, default: () => ({}) },
});

const page = usePage();
const { locale, ml } = useLocale();

const asset = (path) => `/assets/paradise/${path}`;

const demoSectionsData = {
    en: [
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
    ],
    mk: [
        {
            title: 'Предјадења',
            subtitle: 'Јадење по ваш избор од листата подолу',
            items: [
                { name: 'Мариниран Шкампи', description: 'Свежи шкампи, маслиново масло, сос од домати' },
                { name: 'Авокадо и Манго', description: 'Авокадо, манго, домати' },
                { name: 'Крем од Аспарагус', description: 'Аспарагус, компир, целер, кромид' },
            ],
        },
        {
            title: 'Главни јадења',
            subtitle: 'Јадење по ваш избор од листата подолу',
            items: [
                { name: 'Говедско Ребро', description: 'Ребро, рузмарин, црн пипер' },
                { name: 'Шрирача Говедско', description: 'Говедско месо, шрирача, кромид на пролет' },
                { name: 'Мек рак', description: 'Рак, компир, салата' },
                { name: 'Пилешко со Лук', description: 'Пилешко, чери домати, маслиново масло' },
                { name: 'Чили од Мисирка', description: 'Мисирка, оригано, доматна паста' },
            ],
        },
        {
            title: 'Десерти',
            subtitle: 'Јадење по ваш избор од листата подолу',
            items: [
                { name: 'Чоколадни Мафини', description: 'Чоколадо, јајца, ванила' },
                { name: 'Летни Бобинки', description: 'Малини, капини' },
                { name: 'Кокосова Торта', description: 'Боровинки, дробени бисквити' },
            ],
        },
        {
            title: 'Пијалаци',
            subtitle: 'Јадење по ваш избор од листата подолу',
            items: [
                { name: 'Чаша Црвено Вино', description: 'Вранец — Македонија' },
                { name: 'Чаша Бело Вино', description: 'Смедеревка — Македонија' },
                { name: 'Шише Пиво', description: 'Локално занаетчиско пиво' },
            ],
        },
    ],
    sr: [
        {
            title: 'Predjela',
            subtitle: 'Jelo po vašem izboru sa liste ispod',
            items: [
                { name: 'Marinirane Škampe', description: 'Sveže škampe, maslinovo ulje, sos od paradajza' },
                { name: 'Avokado i Mango', description: 'Avokado, mango, paradajz' },
                { name: 'Krem od Šparoge', description: 'Šparoga, krompir, celer, crni luk' },
            ],
        },
        {
            title: 'Glavna Jela',
            subtitle: 'Jelo po vašem izboru sa liste ispod',
            items: [
                { name: 'Goveđe Rebro', description: 'Rebro, ruzmarin, crni biber' },
                { name: 'Šriraća Govedina', description: 'Govedina, šriraća, mladi luk' },
                { name: 'Meka Rakovica', description: 'Rakovica, krompir, salata' },
                { name: 'Piletina sa Belim Lukom', description: 'Piletina, čeri paradajz, maslinovo ulje' },
                { name: 'Ćureći Čili', description: 'Ćuretina, origano, pasta od paradajza' },
            ],
        },
        {
            title: 'Deserti',
            subtitle: 'Jelo po vašem izboru sa liste ispod',
            items: [
                { name: 'Čokoladni Mafini', description: 'Čokolada, jaja, vanila' },
                { name: 'Letnje Bobičasto Voće', description: 'Maline, kupine' },
                { name: 'Kokosova Torta', description: 'Borovnice, mrvice keksa' },
            ],
        },
        {
            title: 'Pića',
            subtitle: 'Jelo po vašem izboru sa liste ispod',
            items: [
                { name: 'Čaša Crnog Vina', description: 'Vranac — Makedonija' },
                { name: 'Čaša Belog Vina', description: 'Smederevka — Makedonija' },
                { name: 'Flaša Piva', description: 'Lokalno zanatsko pivo' },
            ],
        },
    ],
    tr: [
        {
            title: 'Başlangıçlar',
            subtitle: 'Aşağıdaki listeden seçeceğiniz bir yemek',
            items: [
                { name: 'Marine Karides', description: 'Taze karides, zeytinyağı, domates sosu' },
                { name: 'Avokado ve Mango', description: 'Avokado, mango, domates' },
                { name: 'Kuşkonmaz Kreması', description: 'Kuşkonmaz, patates, kereviz, soğan' },
            ],
        },
        {
            title: 'Ana Yemekler',
            subtitle: 'Aşağıdaki listeden seçeceğiniz bir yemek',
            items: [
                { name: 'Prime Rib', description: 'Kaburga, biberiye, karabiber' },
                { name: 'Sriracha Biftek', description: 'Dana eti, sriracha, taze soğan' },
                { name: 'Yumuşak Kabuklu Yengeç', description: 'Yengeç, patates, salata' },
                { name: 'Sarımsaklı Tavuk', description: 'Tavuk, kiraz domates, zeytinyağı' },
                { name: 'Hindi Chili', description: 'Hindi eti, kekik, domates salçası' },
            ],
        },
        {
            title: 'Tatlılar',
            subtitle: 'Aşağıdaki listeden seçeceğiniz bir yemek',
            items: [
                { name: 'Çikolatalı Kek', description: 'Çikolata, yumurta, vanilya' },
                { name: 'Yaz Meyveleri', description: 'Ahududu, böğürtlen' },
                { name: 'Hindistan Cevizli Turta', description: 'Yaban mersini, bisküvi kırıntıları' },
            ],
        },
        {
            title: 'İçecekler',
            subtitle: 'Aşağıdaki listeden seçeceğiniz bir yemek',
            items: [
                { name: 'Bir Kadeh Kırmızı Şarap', description: 'Vranec — Makedonya' },
                { name: 'Bir Kadeh Beyaz Şarap', description: 'Smederevka — Makedonya' },
                { name: 'Şişe Bira', description: 'Yerel el yapımı bira' },
            ],
        },
    ],
    sq: [
        {
            title: 'Antipasta',
            subtitle: 'Një pjatë sipas zgjedhjes suaj nga lista më poshtë',
            items: [
                { name: 'Karkaleca të Marinuar', description: 'Karkaleca të freskët, vaj ulliri, salcë domatesh' },
                { name: 'Avokado dhe Mango', description: 'Avokado, mango, domate' },
                { name: 'Krem Sperzhelle', description: 'Sperzhelle, patate, selino, qepë' },
            ],
        },
        {
            title: 'Pjata Kryesore',
            subtitle: 'Një pjatë sipas zgjedhjes suaj nga lista më poshtë',
            items: [
                { name: 'Brinjë Viçi', description: 'Brinjë, trumzë, piper i zi' },
                { name: 'Viç me Sriracha', description: 'Mish viçi, sriracha, qepë e re' },
                { name: 'Gaforre e Butë', description: 'Gaforre, patate, sallatë' },
                { name: 'Pulë me Hudhër', description: 'Pulë, domate qershie, vaj ulliri' },
                { name: 'Chili Gjeldeti', description: 'Gjeldeti, borzilok origan, pastë domatesh' },
            ],
        },
        {
            title: 'Ëmbëlsira',
            subtitle: 'Një pjatë sipas zgjedhjes suaj nga lista më poshtë',
            items: [
                { name: 'Kek Çokollate', description: 'Çokollatë, vezë, vanilje' },
                { name: 'Fruta Vere', description: 'Mjedra, manaferra' },
                { name: 'Tortë Kokosi', description: 'Boronica, thërrime biskotash' },
            ],
        },
        {
            title: 'Pije',
            subtitle: 'Një pjatë sipas zgjedhjes suaj nga lista më poshtë',
            items: [
                { name: 'Gotë Verë të Kuqe', description: 'Vranec — Maqedoni' },
                { name: 'Gotë Verë të Bardhë', description: 'Smederevka — Maqedoni' },
                { name: 'Shishe Birrë', description: 'Birrë lokale artizanale' },
            ],
        },
    ],
};

const menuSections = computed(() => (props.sections.length ? props.sections : (demoSectionsData[locale.value] || demoSectionsData.en)));

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
        <title>{{ seo.title || ml({ en: 'Menu of the Day', mk: 'Мени на Денот', sr: 'Meni Dana', tr: 'Günün Menüsü', sq: 'Menyja e Ditës' }) }}</title>
        <meta name="robots" content="noindex, nofollow">
    </Head>

    <section class="menu-section">
        <div class="full-container">
            <div class="intro p-3">
                <img :src="asset('img/logo.png')" width="200" height="67" alt="Alexandar Palace" class="mb-3 day-menu-logo"><br>
                {{ ml({ en: 'Menu of the Day', mk: 'Мени на Денот', sr: 'Meni Dana', tr: 'Günün Menüsü', sq: 'Menyja e Ditës' }) }}
                <span>{{ ml({ en: 'Fresh selections prepared by our chef every day', mk: 'Свежи јадења подготвени од нашиот шеф секој ден', sr: 'Sveži izbori koje naš šef priprema svaki dan', tr: 'Şefimiz tarafından her gün hazırlanan taze seçimler', sq: 'Përzgjedhje të freskëta të përgatitura nga shefi ynë çdo ditë' }) }}</span>
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
                        <p>{{ section.subtitle || ml({ en: 'A dish of your choice from the list below', mk: 'Јадење по ваш избор од листата подолу', sr: 'Jelo po vašem izboru sa liste ispod', tr: 'Aşağıdaki listeden seçeceğiniz bir yemek', sq: 'Një pjatë sipas zgjedhjes suaj nga lista më poshtë' }) }}</p>
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
                    <h3>{{ ml({ en: 'Reserve a Table', mk: 'Резервирајте Маса', sr: 'Rezervišite Sto', tr: 'Masa Rezervasyonu', sq: 'Rezervoni një Tavolinë' }) }}</h3>
                    <p>{{ ml({ en: 'Join us for the menu of the day at Alexandar Palace. Our team will be glad to arrange your table.', mk: 'Придружете ни се за менито на денот во Александар Палас. Нашиот тим со задоволство ќе ви ја резервира масата.', sr: 'Pridružite nam se za meni dana u Aleksandar Palasu. Naš tim će rado rezervisati vaš sto.', tr: 'Alexandar Palace\'da günün menüsü için bize katılın. Ekibimiz masanızı ayarlamaktan mutluluk duyacaktır.', sq: 'Bashkohuni me ne për menynë e ditës në Alexandar Palace. Ekipi ynë do të jetë i lumtur t\'ju rezervojë tavolinën.' }) }}</p>
                    <p v-if="phone" class="phone_us">{{ ml({ en: 'Call Us', mk: 'Јавете ни се', sr: 'Pozovite Nas', tr: 'Bizi Arayın', sq: 'Na Telefononi' }) }} <a :href="`tel:${phone}`">{{ phone }}</a></p>
                </div>
            </div>
        </div>
    </section>

    <nav>
        <ul class="vertical-nav">
            <li><a href="#0" class="prev inactive">{{ ml({ en: 'Next', mk: 'Следно', sr: 'Sledeće', tr: 'Sonraki', sq: 'Tjetër' }) }}</a></li>
            <li><a href="#0" class="next">{{ ml({ en: 'Prev', mk: 'Претходно', sr: 'Prethodno', tr: 'Önceki', sq: 'Pararendës' }) }}</a></li>
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
