<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useLocale } from '@/composables/useLocale';

const props = defineProps({
    amenities: Object,
    contact: Object,
    seo: Object,
});

const { locale, ml } = useLocale();

const isLoaded = ref(false);

onMounted(() => {
    setTimeout(() => {
        isLoaded.value = true;
    }, 100);
});

const asset = (path) => `/assets/paradise/${path}`;
</script>

<template>
    <Head>
        <title>{{ seo?.title }}</title>
        <meta name="description" :content="seo?.description">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    </Head>

    <div class="amenities-page" :class="{ 'loaded': isLoaded }">
        <!-- Hero Section with Video/Image -->
        <section class="hero-section">
            <div class="hero-bg">
                <img :src="asset('img/spa/DSC_4700-scaled.webp')" alt="Alexandar Palace">
            </div>
            <div class="hero-overlay"></div>
            <div class="hero-particles">
                <div class="particle p1"></div>
                <div class="particle p2"></div>
                <div class="particle p3"></div>
            </div>
            <div class="hero-content">
                <div class="hero-badge">
                    <span>★★★★★</span>
                </div>
                <div class="logo-wrapper">
                    <img :src="asset('img/logo.png')" alt="Alexandar Palace" class="hero-logo">
                </div>
                <div class="hero-divider">
                    <span></span>
                    <i class="bi bi-diamond-fill"></i>
                    <span></span>
                </div>
                <h1>{{ ml({ en: 'Welcome to Alexandar Palace', mk: 'Добредојдовте во Alexandar Palace', sr: 'Dobrodošli u Alexandar Palace', tr: 'Alexandar Palace\'e Hoş Geldiniz', sq: 'Mirë se vini në Alexandar Palace' }) }}</h1>
                <p class="hero-tagline">{{ ml({ en: 'Discover Our World-Class Amenities', mk: 'Откријте ги нашите врвни услови и содржини', sr: 'Otkrijte naše vrhunske sadržaje', tr: 'Dünya standartlarındaki olanaklarımızı keşfedin', sq: 'Zbuloni ambientet tona të klasit botëror' }) }}</p>
                <div class="scroll-indicator">
                    <i class="bi bi-chevron-down"></i>
                </div>
            </div>
        </section>

        <!-- Quick Services Bar -->
        <section class="quick-services">
            <div class="service-item">
                <i class="bi bi-wifi"></i>
                <span>{{ ml({ en: 'Free WiFi', mk: 'Бесплатен WiFi', sr: 'Besplatan WiFi', tr: 'Ücretsiz WiFi', sq: 'WiFi Falas' }) }}</span>
            </div>
            <div class="service-item">
                <i class="bi bi-p-circle-fill"></i>
                <span>{{ ml({ en: 'Free Parking', mk: 'Бесплатен Паркинг', sr: 'Besplatan Parking', tr: 'Ücretsiz Otopark', sq: 'Parking Falas' }) }}</span>
            </div>
            <div class="service-item">
                <i class="bi bi-clock-fill"></i>
                <span>{{ ml({ en: '24/7 Service', mk: 'Услуга 24/7', sr: 'Usluga 24/7', tr: '7/24 Hizmet', sq: 'Shërbim 24/7' }) }}</span>
            </div>
            <div class="service-item">
                <i class="bi bi-shield-check"></i>
                <span>{{ ml({ en: 'Secure', mk: 'Безбедност', sr: 'Bezbednost', tr: 'Güvenlik', sq: 'Siguri' }) }}</span>
            </div>
        </section>

        <!-- SPA & Wellness Section -->
        <section class="amenity-section spa-section">
            <div class="section-header">
                <span class="section-label">{{ ml({ en: 'Relax & Rejuvenate', mk: 'Релаксирајте и Подмладете се', sr: 'Opustite se i Podmladite', tr: 'Rahatlayın ve Kendinizi Yenileyin', sq: 'Relaksohuni dhe Rinovohuni' }) }}</span>
                <h2>{{ ml({ en: 'SPA & Wellness', mk: 'СПА и Велнес', sr: 'SPA i Wellness', tr: 'SPA ve Wellness', sq: 'SPA dhe Wellness' }) }}</h2>
            </div>
            <div class="image-showcase">
                <div class="main-image">
                    <img :src="asset('img/spa/DSC_4700-scaled.webp')" alt="SPA">
                </div>
                <div class="side-images">
                    <img :src="asset('img/spa/26991eb2-5b77-4586-8283-1e6d42e61df8-scaled.webp')" alt="Hammam">
                    <img :src="asset('img/spa/4c57de08-be2f-4d4b-984f-3dda85a7b5ae-scaled.webp')" alt="Massage">
                </div>
            </div>
            <div class="features-grid">
                <div class="feature">
                    <i class="bi bi-water"></i>
                    <span>{{ ml({ en: 'Indoor Pool', mk: 'Затворен Базен', sr: 'Zatvoreni Bazen', tr: 'Kapalı Havuz', sq: 'Pishinë e Mbyllur' }) }}</span>
                </div>
                <div class="feature">
                    <i class="bi bi-thermometer-sun"></i>
                    <span>{{ ml({ en: 'Sauna & Hammam', mk: 'Сауна и Хамам', sr: 'Sauna i Hamam', tr: 'Sauna ve Hamam', sq: 'Sauna dhe Hamam' }) }}</span>
                </div>
                <div class="feature">
                    <i class="bi bi-hand-index-thumb"></i>
                    <span>{{ ml({ en: 'Massages', mk: 'Масажи', sr: 'Masaže', tr: 'Masajlar', sq: 'Masazhe' }) }}</span>
                </div>
                <div class="feature">
                    <i class="bi bi-flower1"></i>
                    <span>{{ ml({ en: 'Treatments', mk: 'Третмани', sr: 'Tretmani', tr: 'Bakımlar', sq: 'Trajtime' }) }}</span>
                </div>
            </div>
            <div class="hours-badge">
                <i class="bi bi-clock"></i>
                <span>{{ ml({ en: '06:00 - 22:00 Daily', mk: '06:00 - 22:00 Секој Ден', sr: '06:00 - 22:00 Svakog Dana', tr: 'Her Gün 06:00 - 22:00', sq: '06:00 - 22:00 Çdo Ditë' }) }}</span>
            </div>
        </section>

        <!-- Sport & Recreation Section -->
        <section class="amenity-section sport-section">
            <div class="section-header light">
                <span class="section-label">{{ ml({ en: 'Stay Active', mk: 'Останете Активни', sr: 'Ostanite Aktivni', tr: 'Aktif Kalın', sq: 'Qëndroni Aktivë' }) }}</span>
                <h2>{{ ml({ en: 'Sport & Recreation', mk: 'Спорт и Рекреација', sr: 'Sport i Rekreacija', tr: 'Spor ve Rekreasyon', sq: 'Sport dhe Argëtim' }) }}</h2>
            </div>
            <div class="image-grid-3">
                <div class="grid-item large">
                    <img :src="asset('img/activities/teniski-teren-scaled.webp')" alt="Tennis Courts">
                    <div class="grid-label">{{ ml({ en: 'Tennis Courts', mk: 'Тениски Терени', sr: 'Teniski Tereni', tr: 'Tenis Kortları', sq: 'Fusha Tenisi' }) }}</div>
                </div>
                <div class="grid-item">
                    <img :src="asset('img/activities/kosarkarski-teren-scaled.webp')" alt="Basketball">
                    <div class="grid-label">{{ ml({ en: 'Basketball', mk: 'Кошарка', sr: 'Košarka', tr: 'Basketbol', sq: 'Basketboll' }) }}</div>
                </div>
                <div class="grid-item">
                    <img :src="asset('img/activities/Fitness3-440x550.webp')" alt="Fitness">
                    <div class="grid-label">{{ ml({ en: 'Fitness Center', mk: 'Фитнес Центар', sr: 'Fitnes Centar', tr: 'Fitness Merkezi', sq: 'Qendër Fitnesi' }) }}</div>
                </div>
            </div>
            <div class="features-list">
                <div class="feature-row">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ ml({ en: '4 Professional Tennis Courts', mk: '4 Професионални Тениски Терени', sr: '4 Profesionalna Teniska Terena', tr: '4 Profesyonel Tenis Kortu', sq: '4 Fusha Profesionale Tenisi' }) }}</span>
                </div>
                <div class="feature-row">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ ml({ en: '2 Basketball Courts', mk: '2 Кошаркарски Терени', sr: '2 Košarkaška Terena', tr: '2 Basketbol Sahası', sq: '2 Fusha Basketbolli' }) }}</span>
                </div>
                <div class="feature-row">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ ml({ en: 'Football Pitch', mk: 'Фудбалско Игралиште', sr: 'Fudbalsko Igralište', tr: 'Futbol Sahası', sq: 'Fushë Futbolli' }) }}</span>
                </div>
                <div class="feature-row">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ ml({ en: 'Modern Fitness Center', mk: 'Модерен Фитнес Центар', sr: 'Moderan Fitnes Centar', tr: 'Modern Fitness Merkezi', sq: 'Qendër Moderne Fitnesi' }) }}</span>
                </div>
                <div class="feature-row">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ ml({ en: 'Personal Trainers Available', mk: 'Достапни Лични Тренери', sr: 'Dostupni Lični Treneri', tr: 'Kişisel Antrenörler Mevcuttur', sq: 'Trajnerë Personalë në Dispozicion' }) }}</span>
                </div>
            </div>
            <div class="hours-badge dark">
                <i class="bi bi-clock"></i>
                <span>{{ ml({ en: '08:00 - 22:00 Daily', mk: '08:00 - 22:00 Секој Ден', sr: '08:00 - 22:00 Svakog Dana', tr: 'Her Gün 08:00 - 22:00', sq: '08:00 - 22:00 Çdo Ditë' }) }}</span>
            </div>
        </section>

        <!-- Restaurant Section -->
        <section class="amenity-section restaurant-section">
            <div class="section-header">
                <span class="section-label">{{ ml({ en: 'Culinary Excellence', mk: 'Кулинарска Извонредност', sr: 'Kulinarska Izvrsnost', tr: 'Mutfak Mükemmelliği', sq: 'Përsosmëri Kulinare' }) }}</span>
                <h2>{{ ml({ en: 'Dining & Restaurants', mk: 'Ресторани и Храна', sr: 'Restorani i Hrana', tr: 'Yemek ve Restoranlar', sq: 'Restorante dhe Ushqim' }) }}</h2>
            </div>
            <div class="restaurant-showcase">
                <div class="restaurant-card">
                    <img :src="asset('img/restaurant/restaurant_hero.webp')" alt="Main Restaurant">
                    <div class="restaurant-info">
                        <h3>{{ ml({ en: 'Main Restaurant', mk: 'Главен Ресторан', sr: 'Glavni Restoran', tr: 'Ana Restoran', sq: 'Restoranti Kryesor' }) }}</h3>
                        <p>{{ ml({ en: 'International & Local Cuisine', mk: 'Интернационална и Локална Кујна', sr: 'Internacionalna i Lokalna Kuhinja', tr: 'Uluslararası ve Yerel Mutfak', sq: 'Kuzhinë Ndërkombëtare dhe Vendase' }) }}</p>
                        <span class="time">07:00 - 23:00</span>
                    </div>
                </div>
                <div class="restaurant-card">
                    <img :src="asset('img/tennis-restaurant/5C8B3760-FC2B-4EAD-B731-9663CD55A9D9-2048x2048.webp')" alt="Tennis Restaurant">
                    <div class="restaurant-info">
                        <h3>{{ ml({ en: 'Tennis Restaurant', mk: 'Тениски Ресторан', sr: 'Teniski Restoran', tr: 'Tenis Restoranı', sq: 'Restoranti i Tenisit' }) }}</h3>
                        <p>{{ ml({ en: 'Casual Dining & Drinks', mk: 'Опуштена Кујна и Пијалаци', sr: 'Opušteno Fine Dining i Pića', tr: 'Rahat Yemek ve İçecekler', sq: 'Ushqim Casual dhe Pije' }) }}</p>
                        <span class="time">10:00 - 22:00</span>
                    </div>
                </div>
            </div>
            <div class="food-gallery">
                <img :src="asset('img/tennis-restaurant/slatko-1-400x340.webp')" alt="Food">
                <img :src="asset('img/tennis-restaurant/slatko-2-400x340.webp')" alt="Food">
                <img :src="asset('img/tennis-restaurant/slatko-3-400x340.webp')" alt="Food">
                <img :src="asset('img/tennis-restaurant/slatko-4-400x340.webp')" alt="Food">
            </div>
            <div class="features-grid">
                <div class="feature">
                    <i class="bi bi-sunrise"></i>
                    <span>{{ ml({ en: 'Breakfast Buffet', mk: 'Шведска Маса за Појадок', sr: 'Švedski Sto za Doručak', tr: 'Açık Büfe Kahvaltı', sq: 'Bufe Mëngjesi' }) }}</span>
                </div>
                <div class="feature">
                    <i class="bi bi-cup-straw"></i>
                    <span>{{ ml({ en: 'Pool Bar', mk: 'Бар до Базен', sr: 'Bar kod Bazena', tr: 'Havuz Barı', sq: 'Bar pranë Pishinës' }) }}</span>
                </div>
                <div class="feature">
                    <i class="bi bi-bell"></i>
                    <span>{{ ml({ en: 'Room Service 24h', mk: 'Рум Сервис 24ч', sr: 'Rum Servis 24h', tr: '24 Saat Oda Servisi', sq: 'Shërbim në Dhomë 24 orë' }) }}</span>
                </div>
                <div class="feature">
                    <i class="bi bi-cup-hot"></i>
                    <span>{{ ml({ en: 'Lobby Lounge', mk: 'Лоби Бар', sr: 'Lobi Bar', tr: 'Lobi Barı', sq: 'Sallon i Lobit' }) }}</span>
                </div>
            </div>
        </section>

        <!-- Rooms Section -->
        <section class="amenity-section rooms-section">
            <div class="section-header light">
                <span class="section-label">{{ ml({ en: 'Luxurious Comfort', mk: 'Луксузна Удобност', sr: 'Luksuzna Udobnost', tr: 'Lüks Konfor', sq: 'Rehati Luksoze' }) }}</span>
                <h2>{{ ml({ en: 'Rooms & Suites', mk: 'Соби и Апартмани', sr: 'Sobe i Apartmani', tr: 'Odalar ve Süitler', sq: 'Dhoma dhe Suita' }) }}</h2>
            </div>
            <div class="rooms-showcase">
                <div class="room-card">
                    <img :src="asset('img/rooms/single-room.webp')" alt="Single Room">
                    <div class="room-info">
                        <h3>{{ ml({ en: 'Single Room', mk: 'Еднокреветна Соба', sr: 'Jednokrevetna Soba', tr: 'Tek Kişilik Oda', sq: 'Dhomë Teke' }) }}</h3>
                    </div>
                </div>
                <div class="room-card">
                    <img :src="asset('img/rooms/executive.webp')" alt="Executive Suite">
                    <div class="room-info">
                        <h3>{{ ml({ en: 'Executive Suite', mk: 'Извршен Апартман', sr: 'Izvršni Apartman', tr: 'Executive Süit', sq: 'Suitë Ekzekutive' }) }}</h3>
                    </div>
                </div>
                <div class="room-card">
                    <img :src="asset('img/rooms/presidental.webp')" alt="Presidential Suite">
                    <div class="room-info">
                        <h3>{{ ml({ en: 'Presidential Suite', mk: 'Претседателски Апартман', sr: 'Predsednički Apartman', tr: 'Prezidential Süit', sq: 'Suitë Presidenciale' }) }}</h3>
                    </div>
                </div>
            </div>
            <div class="room-amenities">
                <div class="amenity-item">
                    <i class="bi bi-wifi"></i>
                    <span>{{ ml({ en: 'Free WiFi', mk: 'Бесплатен WiFi', sr: 'Besplatan WiFi', tr: 'Ücretsiz WiFi', sq: 'WiFi Falas' }) }}</span>
                </div>
                <div class="amenity-item">
                    <i class="bi bi-tv"></i>
                    <span>{{ ml({ en: 'Smart TV', mk: 'Паметен Телевизор', sr: 'Smart TV', tr: 'Akıllı TV', sq: 'TV Smart' }) }}</span>
                </div>
                <div class="amenity-item">
                    <i class="bi bi-snow"></i>
                    <span>{{ ml({ en: 'Air Conditioning', mk: 'Клима Уред', sr: 'Klima Uređaj', tr: 'Klima', sq: 'Kondicioner' }) }}</span>
                </div>
                <div class="amenity-item">
                    <i class="bi bi-safe"></i>
                    <span>{{ ml({ en: 'Safe Box', mk: 'Сеф', sr: 'Sef', tr: 'Kasa', sq: 'Kasafortë' }) }}</span>
                </div>
                <div class="amenity-item">
                    <i class="bi bi-cup-straw"></i>
                    <span>{{ ml({ en: 'Mini Bar', mk: 'Мини Бар', sr: 'Mini Bar', tr: 'Mini Bar', sq: 'Mini Bar' }) }}</span>
                </div>
                <div class="amenity-item">
                    <i class="bi bi-moon-stars"></i>
                    <span>{{ ml({ en: 'Premium Bedding', mk: 'Премиум Постелнина', sr: 'Premium Posteljina', tr: 'Premium Yatak Takımı', sq: 'Çarçafë Premium' }) }}</span>
                </div>
            </div>
        </section>

        <!-- Events Section -->
        <section class="amenity-section events-section">
            <div class="section-header">
                <span class="section-label">{{ ml({ en: 'Celebrate With Us', mk: 'Прославете со Нас', sr: 'Proslavite sa Nama', tr: 'Bizimle Kutlayın', sq: 'Festojani me Ne' }) }}</span>
                <h2>{{ ml({ en: 'Events & Conferences', mk: 'Настани и Конференции', sr: 'Događaji i Konferencije', tr: 'Etkinlikler ve Konferanslar', sq: 'Evente dhe Konferenca' }) }}</h2>
            </div>
            <div class="events-info">
                <div class="event-feature">
                    <div class="event-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h3>{{ ml({ en: 'Congress Center', mk: 'Конгресен Центар', sr: 'Kongresni Centar', tr: 'Kongre Merkezi', sq: 'Qendra e Kongreseve' }) }}</h3>
                    <p>{{ ml({ en: 'State-of-the-art facilities for conferences, seminars, and business meetings', mk: 'Врвни капацитети за конференции, семинари и деловни состаноци', sr: 'Vrhunski kapaciteti za konferencije, seminare i poslovne sastanke', tr: 'Konferanslar, seminerler ve iş toplantıları için son teknoloji tesisler', sq: 'Ambiente moderne për konferenca, seminare dhe takime biznesi' }) }}</p>
                </div>
                <div class="event-feature">
                    <div class="event-icon">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h3>{{ ml({ en: 'Celebrations', mk: 'Прослави', sr: 'Proslave', tr: 'Kutlamalar', sq: 'Festime' }) }}</h3>
                    <p>{{ ml({ en: 'Perfect venue for weddings, anniversaries, and special occasions', mk: 'Совршено место за свадби, годишнини и специјални прилики', sr: 'Savršeno mesto za venčanja, godišnjice i posebne prilike', tr: 'Düğünler, yıldönümleri ve özel günler için mükemmel mekan', sq: 'Vendi perfekt për dasma, përvjetorë dhe raste të veçanta' }) }}</p>
                </div>
            </div>
            <div class="event-services">
                <span><i class="bi bi-check"></i> {{ ml({ en: 'AV Equipment', mk: 'АВ Опрема', sr: 'AV Oprema', tr: 'Görsel-İşitsel Ekipman', sq: 'Pajisje AV' }) }}</span>
                <span><i class="bi bi-check"></i> {{ ml({ en: 'Catering', mk: 'Кетеринг', sr: 'Ketering', tr: 'Catering', sq: 'Katering' }) }}</span>
                <span><i class="bi bi-check"></i> {{ ml({ en: 'Event Planning', mk: 'Организација на Настани', sr: 'Organizacija Događaja', tr: 'Etkinlik Planlama', sq: 'Planifikim Eventesh' }) }}</span>
                <span><i class="bi bi-check"></i> {{ ml({ en: 'Accommodation', mk: 'Сместување', sr: 'Smeštaj', tr: 'Konaklama', sq: 'Akomodim' }) }}</span>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section">
            <div class="contact-header">
                <h2>{{ ml({ en: 'Need Assistance?', mk: 'Ви Треба Помош?', sr: 'Da li Vam je Potrebna Pomoć?', tr: 'Yardıma mı İhtiyacınız Var?', sq: 'Keni Nevojë për Ndihmë?' }) }}</h2>
                <p>{{ ml({ en: 'Our team is available 24/7 for your needs', mk: 'Нашиот тим е достапен 24/7 за вашите потреби', sr: 'Naš tim je dostupan 24/7 za vaše potrebe', tr: 'Ekibimiz ihtiyaçlarınız için 7/24 hizmetinizdedir', sq: 'Ekipa jonë është në dispozicion 24/7 për nevojat tuaja' }) }}</p>
            </div>
            <div class="contact-buttons">
                <a :href="`tel:${contact?.phone || '+389 2 3092 392'}`" class="contact-btn primary">
                    <i class="bi bi-telephone-fill"></i>
                    <div>
                        <span class="btn-label">{{ ml({ en: 'Call Reception', mk: 'Јавете се на Рецепција', sr: 'Pozovite Recepciju', tr: 'Resepsiyonu Arayın', sq: 'Telefononi Recepsionin' }) }}</span>
                        <span class="btn-value">{{ contact?.phone || '+389 2 3092 392' }}</span>
                    </div>
                </a>
                <a :href="`mailto:${contact?.email || 'info@alexandarpalace.com.mk'}`" class="contact-btn secondary">
                    <i class="bi bi-envelope-fill"></i>
                    <span>{{ ml({ en: 'Send Email', mk: 'Испратете Е-пошта', sr: 'Pošaljite Email', tr: 'E-posta Gönderin', sq: 'Dërgoni Email' }) }}</span>
                </a>
            </div>
            <div class="contact-details">
                <div class="detail">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>{{ contact?.address || 'Bul. Ilinden 101, 1000 Skopje' }}</span>
                </div>
                <div class="detail">
                    <i class="bi bi-globe"></i>
                    <span>{{ contact?.website || 'www.alexandarpalace.com.mk' }}</span>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="page-footer">
            <div class="footer-divider">
                <span></span>
                <i class="bi bi-star-fill"></i>
                <span></span>
            </div>
            <p>{{ ml({ en: 'Thank you for choosing', mk: 'Ви благодариме што го избравте', sr: 'Hvala vam što ste izabrali', tr: 'Seçtiğiniz için teşekkür ederiz', sq: 'Faleminderit që zgjodhët' }) }}</p>
            <h3>Alexandar Palace</h3>
            <small>{{ ml({ en: 'We wish you a pleasant stay', mk: 'Ви посакуваме пријатен престој', sr: 'Želimo vam prijatan boravak', tr: 'Keyifli bir konaklama dileriz', sq: 'Ju dëshirojmë një qëndrim të këndshëm' }) }}</small>
        </footer>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Cormorant+Garamond:wght@300;400;500;600&family=Inter:wght@300;400;500;600&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.amenities-page {
    font-family: 'Inter', sans-serif;
    color: #fff;
    background: #080808;
    opacity: 0;
    transition: opacity 0.8s ease;
}

.amenities-page.loaded {
    opacity: 1;
}

/* Hero Section */
.hero-section {
    position: relative;
    height: 70vh;
    min-height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    inset: 0;
}

.hero-bg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    animation: subtle-zoom 20s ease-in-out infinite alternate;
}

@keyframes subtle-zoom {
    0% { transform: scale(1); }
    100% { transform: scale(1.05); }
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 50%, rgba(8,8,8,1) 100%);
}

.hero-particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: #c9a227;
    border-radius: 50%;
    opacity: 0.6;
    animation: float-up 8s ease-in-out infinite;
}

.particle.p1 {
    left: 20%;
    bottom: -10px;
    animation-delay: 0s;
}

.particle.p2 {
    left: 50%;
    bottom: -10px;
    animation-delay: 2s;
}

.particle.p3 {
    left: 80%;
    bottom: -10px;
    animation-delay: 4s;
}

@keyframes float-up {
    0% { transform: translateY(0) scale(1); opacity: 0; }
    10% { opacity: 0.6; }
    90% { opacity: 0.6; }
    100% { transform: translateY(-70vh) scale(0.5); opacity: 0; }
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 20px;
}

.hero-badge {
    margin-bottom: 20px;
}

.hero-badge span {
    display: inline-block;
    color: #c9a227;
    font-size: 0.9rem;
    letter-spacing: 4px;
    text-shadow: 0 0 20px rgba(201, 162, 39, 0.5);
}

.logo-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 25px;
}

.hero-logo {
    height: 80px;
    width: auto;
    filter: drop-shadow(0 4px 20px rgba(0,0,0,0.5));
}

.hero-divider {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-bottom: 25px;
}

.hero-divider span {
    width: 80px;
    height: 1px;
    background: linear-gradient(90deg, transparent, #c9a227, transparent);
}

.hero-divider i {
    color: #c9a227;
    font-size: 0.5rem;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.5; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.3); }
}

.hero-content h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 15px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.8);
    letter-spacing: 1px;
    color: #fff;
}

.hero-tagline {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem;
    color: #fff;
    letter-spacing: 4px;
    text-transform: uppercase;
    font-weight: 500;
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}

.scroll-indicator {
    margin-top: 40px;
    animation: bounce 2s ease-in-out infinite;
}

.scroll-indicator i {
    font-size: 1.5rem;
    color: #c9a227;
    opacity: 0.7;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(10px); }
}

/* Quick Services */
.quick-services {
    display: flex;
    justify-content: space-around;
    background: linear-gradient(135deg, #c9a227 0%, #a68520 100%);
    padding: 18px 10px;
    box-shadow: 0 4px 30px rgba(201, 162, 39, 0.3);
}

.service-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.service-item i {
    font-size: 1.2rem;
    color: #fff;
}

.service-item span {
    font-size: 0.7rem;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Section Styles */
.amenity-section {
    padding: 60px 20px;
    position: relative;
}

.amenity-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(201, 162, 39, 0.5), transparent);
}

.section-header {
    text-align: center;
    margin-bottom: 35px;
}

.section-header.light {
    color: #fff;
}

.section-label {
    display: block;
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.85rem;
    color: #c9a227;
    text-transform: uppercase;
    letter-spacing: 4px;
    margin-bottom: 10px;
    font-weight: 500;
}

.section-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 600;
    letter-spacing: 1px;
    color: #fff;
}

/* SPA Section */
.spa-section {
    background: linear-gradient(180deg, #0a0a0a 0%, #1a1a1a 100%);
}

.image-showcase {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 10px;
    margin-bottom: 25px;
}

.main-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 12px;
}

.side-images {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.side-images img {
    width: 100%;
    height: calc(125px - 5px);
    object-fit: cover;
    border-radius: 12px;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 25px;
}

.feature {
    background: linear-gradient(145deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.02) 100%);
    border: 1px solid rgba(201,162,39,0.2);
    border-radius: 14px;
    padding: 18px 10px;
    text-align: center;
    transition: all 0.4s ease;
}

.feature:hover {
    transform: translateY(-3px);
    border-color: rgba(201,162,39,0.4);
    box-shadow: 0 10px 30px rgba(201, 162, 39, 0.1);
}

.feature i {
    font-size: 1.4rem;
    color: #c9a227;
    display: block;
    margin-bottom: 10px;
}

.feature span {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.8);
}

.hours-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(201,162,39,0.2);
    border: 1px solid #c9a227;
    border-radius: 25px;
    padding: 10px 20px;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    width: fit-content;
}

.hours-badge i {
    color: #c9a227;
}

.hours-badge span {
    font-size: 0.85rem;
    color: #fff;
}

.hours-badge.dark {
    background: rgba(0,0,0,0.1);
    border-color: #c9a227;
}

.hours-badge.dark span {
    color: #fff;
}

/* Sport Section */
.sport-section {
    background: #111;
    color: #fff;
}

.sport-section .section-label {
    color: #c9a227;
}

.image-grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    gap: 10px;
    margin-bottom: 25px;
}

.grid-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
}

.grid-item.large {
    grid-column: 1 / -1;
}

.grid-item img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.grid-item.large img {
    height: 200px;
}

.grid-label {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: #fff;
    padding: 30px 15px 15px;
    font-size: 0.85rem;
    font-weight: 500;
}

.features-list {
    margin-bottom: 20px;
}

.feature-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.feature-row:last-child {
    border-bottom: none;
}

.feature-row i {
    color: #c9a227;
    font-size: 1.1rem;
}

.feature-row span {
    font-size: 0.9rem;
}

/* Restaurant Section */
.restaurant-section {
    background: linear-gradient(180deg, #1a1a1a 0%, #0a0a0a 100%);
}

.restaurant-showcase {
    display: grid;
    gap: 15px;
    margin-bottom: 20px;
}

.restaurant-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
}

.restaurant-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.restaurant-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.9));
    padding: 40px 15px 15px;
}

.restaurant-info h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    margin-bottom: 3px;
    color: #fff;
}

.restaurant-info p {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 5px;
    font-weight: 400;
}

.restaurant-info .time {
    font-size: 0.75rem;
    color: #c9a227;
}

.food-gallery {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    margin-bottom: 25px;
}

.food-gallery img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

/* Rooms Section */
.rooms-section {
    background: #111;
    color: #fff;
}

.rooms-showcase {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 25px;
}

.room-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
}

.room-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.room-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    padding: 30px 10px 10px;
    text-align: center;
}

.room-info h3 {
    font-family: 'Playfair Display', serif;
    font-size: 0.8rem;
    color: #fff;
}

.room-amenities {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.amenity-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    padding: 15px 10px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(201,162,39,0.2);
    border-radius: 10px;
}

.amenity-item i {
    font-size: 1.2rem;
    color: #c9a227;
}

.amenity-item span {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.8);
    text-align: center;
}

/* Events Section */
.events-section {
    background: linear-gradient(180deg, #0a0a0a 0%, #1a1a1a 100%);
}

.events-info {
    display: grid;
    gap: 20px;
    margin-bottom: 25px;
}

.event-feature {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(201,162,39,0.2);
    border-radius: 12px;
    padding: 25px 20px;
    text-align: center;
}

.event-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #c9a227 0%, #a68520 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
}

.event-icon i {
    font-size: 1.5rem;
    color: #fff;
}

.event-feature h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    margin-bottom: 8px;
    color: #fff;
}

.event-feature p {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.9);
    line-height: 1.5;
    font-weight: 400;
}

.event-services {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

.event-services span {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.8);
}

.event-services i {
    color: #c9a227;
}

/* Contact Section */
.contact-section {
    background: linear-gradient(135deg, #c9a227 0%, #a68520 100%);
    padding: 50px 20px;
    text-align: center;
}

.contact-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    color: #fff;
    margin-bottom: 8px;
}

.contact-header p {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 25px;
}

.contact-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 25px;
}

.contact-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 15px 20px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.contact-btn.primary {
    background: #fff;
    color: #1a1a1a;
}

.contact-btn.primary i {
    font-size: 1.3rem;
    color: #c9a227;
}

.contact-btn.primary .btn-label {
    display: block;
    font-size: 0.75rem;
    color: #666;
}

.contact-btn.primary .btn-value {
    display: block;
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a1a;
}

.contact-btn.secondary {
    background: rgba(255,255,255,0.2);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.3);
}

.contact-btn.secondary i {
    font-size: 1.2rem;
}

.contact-details {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.detail {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.9);
}

.detail i {
    color: #fff;
}

/* Footer */
.page-footer {
    background: linear-gradient(180deg, #0a0a0a 0%, #050505 100%);
    padding: 50px 20px;
    text-align: center;
    position: relative;
}

.page-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(201, 162, 39, 0.4), transparent);
}

.footer-divider {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 25px;
}

.footer-divider span {
    width: 50px;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(201,162,39,0.5), transparent);
}

.footer-divider i {
    color: #c9a227;
    font-size: 0.5rem;
    animation: twinkle 2s ease-in-out infinite;
}

@keyframes twinkle {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 1; }
}

.page-footer p {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1rem;
    color: rgba(255,255,255,0.5);
    margin-bottom: 8px;
    letter-spacing: 2px;
}

.page-footer h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    color: #fff;
    margin-bottom: 10px;
    letter-spacing: 2px;
}

.page-footer small {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.4);
    font-style: italic;
}

/* Responsive */
@media (max-width: 480px) {
    .hero-section {
        height: 65vh;
        min-height: 450px;
    }
    
    .hero-content h1 {
        font-size: 2rem;
    }
    
    .hero-tagline {
        font-size: 0.9rem;
        letter-spacing: 3px;
    }
    
    .hero-logo {
        height: 65px;
    }
    
    .image-showcase {
        grid-template-columns: 1fr;
    }
    
    .side-images {
        flex-direction: row;
    }
    
    .side-images img {
        height: 100px;
    }
    
    .features-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .food-gallery {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .rooms-showcase {
        grid-template-columns: 1fr;
    }
    
    .room-card img {
        height: 200px;
    }
    
    .room-amenities {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .section-header h2 {
        font-size: 1.7rem;
    }
}

@media (min-width: 768px) {
    .amenities-page {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .hero-section {
        height: 50vh;
    }
    
    .restaurant-showcase {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
