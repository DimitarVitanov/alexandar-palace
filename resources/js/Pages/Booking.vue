<script setup>
import { computed, ref, watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Layout from '@/Components/Frontend/Layout.vue';
import { useLocale } from '@/composables/useLocale';

const props = defineProps({
    rooms: Array,
    selectedRoomId: Number,
    bookingDefaults: { type: Object, default: () => ({}) },
    seo: Object,
});

const page = usePage();
const { locale, ml } = useLocale();

const asset = (path) => `/assets/paradise/${path}`;

// Translations
const t = computed(() => ({
    hotelName: ml({ en: 'Alexandar Palace Hotel', mk: 'Александар Палас Хотел', sr: 'Hotel Alexandar Palace', tr: 'Alexandar Palace Otel', sq: 'Hoteli Alexandar Palace' }),
    requestReservation: ml({ en: 'Request a Reservation', mk: 'Барање за резервација', sr: 'Zahtev za rezervaciju', tr: 'Rezervasyon Talebi', sq: 'Kërkesë për Rezervim' }),
    heroSubtitle: ml({ en: 'We will review your request and reply as soon as possible.', mk: 'Ќе го разгледаме вашето барање и ќе одговориме што е можно поскоро.', sr: 'Razmotrićemo vaš zahtev i odgovoriti u najkraćem mogućem roku.', tr: 'Talebinizi inceleyip en kısa sürede yanıt vereceğiz.', sq: 'Do ta shqyrtojmë kërkesën tuaj dhe do të përgjigjemi sa më shpejt të jetë e mundur.' }),
    yourStay: ml({ en: 'Your stay', mk: 'Вашиот престој', sr: 'Vaš boravak', tr: 'Konaklamanız', sq: 'Qëndrimi juaj' }),
    fromPerNight: ml({ en: 'From', mk: 'Од', sr: 'Od', tr: 'Başlangıç', sq: 'Nga' }),
    perNight: ml({ en: 'per night', mk: 'по ноќ', sr: 'po noći', tr: 'gecelik', sq: 'për natë' }),
    nights: ml({ en: 'Nights', mk: 'Ноќевања', sr: 'Noćenja', tr: 'Geceler', sq: 'Netë' }),
    ratePerNight: ml({ en: 'Rate per night', mk: 'Цена по ноќ', sr: 'Cena po noći', tr: 'Gecelik ücret', sq: 'Çmimi për natë' }),
    estimatedTotal: ml({ en: 'Estimated total', mk: 'Проценет вкупен износ', sr: 'Procenjeni ukupan iznos', tr: 'Tahmini toplam', sq: 'Totali i vlerësuar' }),
    reservationNote: ml({ en: 'Your reservation is not confirmed until you receive a confirmation email from our team.', mk: 'Вашата резервација не е потврдена додека не добиете потврда по е-пошта од нашиот тим.', sr: 'Vaša rezervacija nije potvrđena dok ne dobijete potvrdu putem e-pošte od našeg tima.', tr: 'Ekibimizden bir onay e-postası alana kadar rezervasyonunuz onaylanmış sayılmaz.', sq: 'Rezervimi juaj nuk konfirmohet derisa të merrni një email konfirmimi nga ekipi ynë.' }),
    reservationDetails: ml({ en: 'Reservation details', mk: 'Детали за резервација', sr: 'Detalji rezervacije', tr: 'Rezervasyon detayları', sq: 'Detajet e rezervimit' }),
    planYourStay: ml({ en: 'Plan your stay', mk: 'Планирајте го вашиот престој', sr: 'Isplanirajte svoj boravak', tr: 'Konaklamanızı planlayın', sq: 'Planifikoni qëndrimin tuaj' }),
    roomOrSuite: ml({ en: 'Room or Suite', mk: 'Соба или апартман', sr: 'Soba ili apartman', tr: 'Oda veya Süit', sq: 'Dhomë ose Suitë' }),
    selectRoom: ml({ en: 'Select a room or suite', mk: 'Изберете соба или апартман', sr: 'Izaberite sobu ili apartman', tr: 'Bir oda veya süit seçin', sq: 'Zgjidhni një dhomë ose suitë' }),
    checkIn: ml({ en: 'Check-in', mk: 'Пријавување', sr: 'Prijava', tr: 'Giriş', sq: 'Check-in' }),
    checkOut: ml({ en: 'Check-out', mk: 'Одjавување', sr: 'Odjava', tr: 'Çıkış', sq: 'Check-out' }),
    adults: ml({ en: 'Adults', mk: 'Возрасни', sr: 'Odrasli', tr: 'Yetişkinler', sq: 'Të rritur' }),
    children: ml({ en: 'Children', mk: 'Деца', sr: 'Deca', tr: 'Çocuklar', sq: 'Fëmijë' }),
    firstName: ml({ en: 'First name', mk: 'Име', sr: 'Ime', tr: 'Ad', sq: 'Emri' }),
    lastName: ml({ en: 'Last name', mk: 'Презиме', sr: 'Prezime', tr: 'Soyad', sq: 'Mbiemri' }),
    email: ml({ en: 'Email address', mk: 'Е-пошта', sr: 'E-adresa', tr: 'E-posta adresi', sq: 'Adresa e emailit' }),
    phone: ml({ en: 'Phone number', mk: 'Телефон', sr: 'Broj telefona', tr: 'Telefon numarası', sq: 'Numri i telefonit' }),
    passportId: ml({ en: 'Passport / ID number', mk: 'Пасош / број на лична карта', sr: 'Pasoš / broj lične karte', tr: 'Pasaport / Kimlik numarası', sq: 'Pasaportë / Numri i letërnjoftimit' }),
    specialRequests: ml({ en: 'Special requests', mk: 'Посебни барања', sr: 'Posebni zahtevi', tr: 'Özel istekler', sq: 'Kërkesa të veçanta' }),
    optional: ml({ en: 'optional', mk: 'опционално', sr: 'opciono', tr: 'isteğe bağlı', sq: 'opsionale' }),
    specialRequestsPlaceholder: ml({ en: 'Arrival time, accessibility requirements, or other requests', mk: 'Време на пристигнување, потреби за пристапност или други барања', sr: 'Vreme dolaska, zahtevi za pristupačnost ili druge napomene', tr: 'Varış saati, erişilebilirlik gereksinimleri veya diğer istekler', sq: 'Ora e mbërritjes, kërkesat për aksesueshmëri ose kërkesa të tjera' }),
    sendRequest: ml({ en: 'Send Reservation Request', mk: 'Испрати барање за резервација', sr: 'Pošalji zahtev za rezervaciju', tr: 'Rezervasyon Talebi Gönder', sq: 'Dërgo Kërkesën për Rezervim' }),
    sendingRequest: ml({ en: 'Sending request…', mk: 'Се испраќа барање...', sr: 'Slanje zahteva...', tr: 'Talep gönderiliyor...', sq: 'Duke dërguar kërkesën...' }),
    backToRooms: ml({ en: 'Back to Rooms', mk: 'Назад кон соби', sr: 'Nazad na sobe', tr: 'Odalara Dön', sq: 'Kthehu te Dhomat' }),
    requestOnItsWay: ml({ en: 'Your request is on its way', mk: 'Вашето барање е на пат', sr: 'Vaš zahtev je poslat', tr: 'Talebiniz iletiliyor', sq: 'Kërkesa juaj është duke u dërguar' }),
    teamWillReview: ml({ en: 'Our reservations team will review the details and contact you as soon as possible.', mk: 'Нашиот тим за резервации ќе ги разгледа деталите и ќе ве контактира што е можно поскоро.', sr: 'Naš tim za rezervacije će pregledati detalje i kontaktirati vas u najkraćem roku.', tr: 'Rezervasyon ekibimiz detayları inceleyip en kısa sürede sizinle iletişime geçecektir.', sq: 'Ekipi ynë i rezervimeve do t\'i shqyrtojë detajet dhe do t\'ju kontaktojë sa më shpejt të jetë e mundur.' }),
    exploreRooms: ml({ en: 'Explore Rooms & Suites', mk: 'Разгледајте соби и апартмани', sr: 'Istražite sobe i apartmane', tr: 'Odaları ve Süitleri Keşfedin', sq: 'Eksploroni Dhomat dhe Suitat' }),
    checkingAvailability: ml({ en: 'Checking availability...', mk: 'Проверка на достапност...', sr: 'Proverava se dostupnost...', tr: 'Müsaitlik kontrol ediliyor...', sq: 'Duke kontrolluar disponueshmërinë...' }),
    notAvailable: ml({ en: 'The selected room is not available for these dates. Please choose different dates or another room.', mk: 'Избраната соба не е достапна за овие датуми. Ве молиме изберете други датуми или друга соба.', sr: 'Izabrana soba nije dostupna za ove datume. Molimo izaberite druge datume ili drugu sobu.', tr: 'Seçilen oda bu tarihler için uygun değil. Lütfen başka tarihler veya başka bir oda seçin.', sq: 'Dhoma e zgjedhur nuk është e disponueshme për këto data. Ju lutemi zgjidhni data të tjera ose një dhomë tjetër.' }),
    roomsCount: ml({ en: 'Number of rooms', mk: 'Број на соби', sr: 'Broj soba', tr: 'Oda sayısı', sq: 'Numri i dhomave' }),
    totalRooms: ml({ en: 'Rooms', mk: 'Соби', sr: 'Sobe', tr: 'Odalar', sq: 'Dhomat' }),
}));

const form = useForm({
    room_id: props.selectedRoomId || '',
    rooms_count: 1,
    name: '',
    last_name: '',
    email: '',
    phone: '',
    passport_id: '',
    check_in: props.bookingDefaults.check_in || '',
    check_out: props.bookingDefaults.check_out || '',
    adults: props.bookingDefaults.adults || 1,
    children: props.bookingDefaults.children || 0,
    special_requests: '',
});

const selectedRoom = computed(() => props.rooms.find((room) => room.id === Number(form.room_id)));

const maxGuests = computed(() => (selectedRoom.value?.max_guests || 10) * Math.max(1, form.rooms_count || 1));

const totalGuests = computed(() => (form.adults || 0) + (form.children || 0));

const guestsExceedMax = computed(() => selectedRoom.value && totalGuests.value > maxGuests.value);

// Availability checking
const availabilityStatus = ref({ available: true, message: '', checking: false });

const checkAvailability = async () => {
    if (!form.room_id || !form.check_in || !form.check_out) {
        availabilityStatus.value = { available: true, message: '', checking: false };
        return;
    }
    
    availabilityStatus.value.checking = true;
    
    const startTime = Date.now();
    const minDisplayTime = 1000; // Show checking state for at least 1 second
    
    try {
        const response = await fetch(`/api/rooms/${form.room_id}/availability?check_in=${form.check_in}&check_out=${form.check_out}&rooms_count=${form.rooms_count || 1}`);
        const data = await response.json();
        
        // Ensure minimum display time
        const elapsed = Date.now() - startTime;
        if (elapsed < minDisplayTime) {
            await new Promise(resolve => setTimeout(resolve, minDisplayTime - elapsed));
        }
        
        availabilityStatus.value = { ...data, checking: false };
    } catch (error) {
        const elapsed = Date.now() - startTime;
        if (elapsed < minDisplayTime) {
            await new Promise(resolve => setTimeout(resolve, minDisplayTime - elapsed));
        }
        availabilityStatus.value = { available: false, message: ml({ en: 'Error checking availability', mk: 'Грешка при проверка на достапност', sr: 'Greška prilikom provere dostupnosti', tr: 'Müsaitlik kontrol edilirken hata oluştu', sq: 'Gabim gjatë kontrollimit të disponueshmërisë' }), checking: false };
    }
};

// Watch for changes in room or dates
watch([() => form.room_id, () => form.check_in, () => form.check_out, () => form.rooms_count], () => {
    checkAvailability();
}, { immediate: true });

const roomNotAvailable = computed(() => !availabilityStatus.value.available && !availabilityStatus.value.checking);

const nights = computed(() => {
    if (!form.check_in || !form.check_out) return 0;

    const checkIn = new Date(`${form.check_in}T00:00:00`);
    const checkOut = new Date(`${form.check_out}T00:00:00`);
    const difference = Math.round((checkOut - checkIn) / 86400000);

    return difference > 0 ? difference : 0;
});

const totalPrice = computed(() => {
    if (!selectedRoom.value || !nights.value) return 0;
    return Number(selectedRoom.value.discounted_price || selectedRoom.value.price_per_night)
        * nights.value
        * Math.max(1, form.rooms_count || 1);
});

const formatPrice = (price) => Number(price).toFixed(2);

const submit = () => {
    form.post('/bookings', { preserveScroll: true });
};
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
        <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img" :src="asset(selectedRoom?.featured_image || 'img/about-us-modified.webp')" :alt="ml({ en: 'Reservation', mk: 'Резервација', sr: 'Rezervacija', tr: 'Rezervasyon', sq: 'Rezervim' })">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.55)">
                <div class="container">
                    <small class="slide-animated one">{{ t.hotelName }}</small>
                    <h1 class="slide-animated two">{{ t.requestReservation }}</h1>
                    <p class="slide-animated three">{{ t.heroSubtitle }}</p>
                </div>
            </div>
        </div>

        <div class="container margin_120_95">
            <div v-if="$page.props.flash?.success" class="booking-success">
                <div class="success-envelope" aria-hidden="true">
                    <div class="envelope-flap"></div>
                    <div class="envelope-letter">
                        <span>A</span>
                    </div>
                </div>
                <small>{{ t.hotelName }}</small>
                <h2>{{ t.requestOnItsWay }}</h2>
                <p>{{ $page.props.flash.success }}</p>
                <p>{{ t.teamWillReview }}</p>
                <Link href="/rooms" class="btn_1 outline mt-3">{{ t.exploreRooms }}</Link>
            </div>
            <div v-else class="row justify-content-between">
                <div class="col-lg-4 order-lg-2 mb-5 mb-lg-0">
                    <div class="booking-summary">
                        <h3>{{ t.yourStay }}</h3>
                        <div v-if="selectedRoom" class="selected-room">
                            <img :src="asset(selectedRoom.featured_image)" :alt="selectedRoom.name">
                            <h4>{{ selectedRoom.name }}</h4>
                            <p>{{ t.fromPerNight }} €{{ formatPrice(selectedRoom.discounted_price || selectedRoom.price_per_night) }} {{ t.perNight }}</p>
                        </div>
                        <div v-if="selectedRoom && nights > 0" class="price-breakdown">
                            <div><span>{{ t.totalRooms }}</span><strong>{{ form.rooms_count }}</strong></div>
                            <div><span>{{ t.nights }}</span><strong>{{ nights }}</strong></div>
                            <div><span>{{ t.ratePerNight }}</span><strong>€{{ formatPrice(selectedRoom.discounted_price || selectedRoom.price_per_night) }}</strong></div>
                            <div class="total"><span>{{ t.estimatedTotal }}</span><strong>€{{ formatPrice(totalPrice) }}</strong></div>
                        </div>
                        <p class="mb-0">{{ t.reservationNote }}</p>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="title mb-4">
                        <small>{{ t.reservationDetails }}</small>
                        <h2>{{ t.planYourStay }}</h2>
                    </div>

                    <form @submit.prevent="submit" novalidate>
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="room_id" class="form-label">{{ t.roomOrSuite }}</label>
                                <select id="room_id" v-model="form.room_id" class="form-select" required>
                                    <option value="" disabled>{{ t.selectRoom }}</option>
                                    <option v-for="room in rooms" :key="room.id" :value="room.id">{{ room.name }} — {{ t.fromPerNight }} €{{ room.price_per_night }}/{{ ml({ en: 'night', mk: 'ноќ', sr: 'noć', tr: 'gece', sq: 'natë' }) }}</option>
                                </select>
                                <div v-if="form.errors.room_id" class="field-error">{{ form.errors.room_id }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="check_in" class="form-label">{{ t.checkIn }}</label>
                                <input id="check_in" v-model="form.check_in" type="date" class="form-control" :min="new Date().toISOString().split('T')[0]" required>
                                <div v-if="form.errors.check_in" class="field-error">{{ form.errors.check_in }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="check_out" class="form-label">{{ t.checkOut }}</label>
                                <input id="check_out" v-model="form.check_out" type="date" class="form-control" :min="form.check_in || new Date().toISOString().split('T')[0]" required>
                                <div v-if="form.errors.check_out" class="field-error">{{ form.errors.check_out }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="rooms_count" class="form-label">{{ t.roomsCount }}</label>
                                <input id="rooms_count" v-model.number="form.rooms_count" type="number" min="1" max="100" class="form-control" required>
                                <div v-if="form.errors.rooms_count" class="field-error">{{ form.errors.rooms_count }}</div>
                            </div>
                            <!-- Availability Warning -->
                            <div v-if="roomNotAvailable" class="col-12 mb-4">
                                <div class="alert alert-danger">
                                    <i class="bi bi-x-circle me-2"></i>
                                    {{ t.notAvailable }}
                                </div>
                            </div>
                            <div v-else-if="availabilityStatus.checking" class="col-12 mb-4">
                                <div class="alert alert-info">
                                    <i class="bi bi-hourglass-split me-2"></i>
                                    {{ t.checkingAvailability }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="adults" class="form-label">{{ t.adults }}</label>
                                <input id="adults" v-model.number="form.adults" type="number" min="1" :max="maxGuests" class="form-control" :class="{ 'is-invalid': guestsExceedMax }" required>
                                <div v-if="form.errors.adults" class="field-error">{{ form.errors.adults }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="children" class="form-label">{{ t.children }}</label>
                                <input id="children" v-model.number="form.children" type="number" min="0" :max="maxGuests - 1" class="form-control" :class="{ 'is-invalid': guestsExceedMax }" required>
                                <div v-if="form.errors.children" class="field-error">{{ form.errors.children }}</div>
                            </div>
                            <div v-if="guestsExceedMax" class="col-12 mb-4">
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    {{ ml({
                                        en: `The selected room can accommodate a maximum of ${maxGuests} guests. You have selected ${totalGuests} guests.`,
                                        mk: `Избраната соба може да прими максимум ${maxGuests} гости. Моментално имате избрано ${totalGuests} гости.`,
                                        sr: `Izabrana soba može da primi maksimalno ${maxGuests} gostiju. Trenutno ste izabrali ${totalGuests} gostiju.`,
                                        tr: `Seçilen oda en fazla ${maxGuests} misafir alabilir. Şu anda ${totalGuests} misafir seçtiniz.`,
                                        sq: `Dhoma e zgjedhur mund të akomodojë maksimumi ${maxGuests} mysafirë. Aktualisht keni zgjedhur ${totalGuests} mysafirë.`,
                                    }) }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">{{ t.firstName }}</label>
                                <input id="name" v-model="form.name" type="text" autocomplete="given-name" class="form-control" required>
                                <div v-if="form.errors.name" class="field-error">{{ form.errors.name }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="last_name" class="form-label">{{ t.lastName }}</label>
                                <input id="last_name" v-model="form.last_name" type="text" autocomplete="family-name" class="form-control" required>
                                <div v-if="form.errors.last_name" class="field-error">{{ form.errors.last_name }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">{{ t.email }}</label>
                                <input id="email" v-model="form.email" type="email" autocomplete="email" class="form-control" required>
                                <div v-if="form.errors.email" class="field-error">{{ form.errors.email }}</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="phone" class="form-label">{{ t.phone }}</label>
                                <input id="phone" v-model="form.phone" type="tel" autocomplete="tel" class="form-control" required>
                                <div v-if="form.errors.phone" class="field-error">{{ form.errors.phone }}</div>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="passport_id" class="form-label">{{ t.passportId }}</label>
                                <input id="passport_id" v-model="form.passport_id" type="text" autocomplete="off" class="form-control" required>
                                <div v-if="form.errors.passport_id" class="field-error">{{ form.errors.passport_id }}</div>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="special_requests" class="form-label">{{ t.specialRequests }} <span class="text-muted">({{ t.optional }})</span></label>
                                <textarea id="special_requests" v-model="form.special_requests" class="form-control" rows="4" :placeholder="t.specialRequestsPlaceholder"></textarea>
                                <div v-if="form.errors.special_requests" class="field-error">{{ form.errors.special_requests }}</div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-3 align-items-center">
                            <button type="submit" class="btn_1" :disabled="form.processing || guestsExceedMax || roomNotAvailable || availabilityStatus.checking">
                                {{ form.processing ? t.sendingRequest : t.sendRequest }}
                            </button>
                            <Link href="/rooms" class="animated_link"><strong>{{ t.backToRooms }}</strong></Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.booking-summary { background: #f5f2ec; padding: 32px; }
.booking-summary h3 { margin-bottom: 24px; }
.selected-room { border-bottom: 1px solid #d8d1c5; margin-bottom: 24px; padding-bottom: 20px; }
.selected-room img { width: 100%; height: 180px; object-fit: cover; margin-bottom: 16px; }
.selected-room h4 { margin-bottom: 5px; }
.selected-room p { margin: 0; color: #8f7952; }
.price-breakdown { border-bottom: 1px solid #d8d1c5; margin-bottom: 24px; padding-bottom: 18px; }
.price-breakdown > div { display: flex; justify-content: space-between; margin-bottom: 10px; }
.price-breakdown .total { border-top: 1px solid #d8d1c5; color: #4b514d; font-size: 1.1rem; margin-top: 14px; padding-top: 14px; }
.form-label { display: block; font-weight: 600; margin-bottom: 8px; }
.form-control, .form-select { border: 1px solid #dedede; border-radius: 0; min-height: 52px; }
textarea.form-control { min-height: auto; }
.field-error { color: #b42318; font-size: .875rem; margin-top: 6px; }
.booking-success { margin: 0 auto; max-width: 620px; padding: 40px 20px; text-align: center; }
.booking-success small { color: #626262; font-size: .75rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; }
.booking-success h2 { font-size: clamp(2rem, 5vw, 3.25rem); margin: 18px 0; }
.booking-success p { color: #5c5c5c; font-size: 1.05rem; margin: 0 auto 10px; max-width: 520px; }
.success-envelope { height: 160px; margin: 0 auto 34px; perspective: 800px; position: relative; width: 230px; }
.success-envelope::before { background: #393939; bottom: 0; content: ''; height: 120px; left: 0; position: absolute; right: 0; }
.success-envelope::after { border-color: transparent transparent #555; border-style: solid; border-width: 0 115px 70px; bottom: 0; content: ''; height: 0; left: 0; position: absolute; width: 0; }
.envelope-flap { border-color: #454545 transparent transparent; border-style: solid; border-width: 72px 115px 0; height: 0; left: 0; position: absolute; top: 40px; transform-origin: top; transform: rotateX(0); width: 0; z-index: 3; animation: envelope-open .8s cubic-bezier(.2,.8,.2,1) .2s both; }
.envelope-letter { align-items: center; background: #fff; box-shadow: 0 10px 20px rgba(0,0,0,.12); display: flex; height: 120px; justify-content: center; left: 15px; position: absolute; top: 28px; transform: translateY(0); width: 200px; z-index: 2; animation: letter-rise .9s cubic-bezier(.2,.8,.2,1) .5s both; }
.envelope-letter span { border: 1px solid #424242; border-radius: 50%; color: #424242; font-family: Georgia, serif; font-size: 2rem; height: 54px; line-height: 52px; width: 54px; }
@keyframes envelope-open { to { opacity: 0; transform: rotateX(-180deg); } }
@keyframes letter-rise { to { transform: translateY(-38px); } }
@media (prefers-reduced-motion: reduce) { .envelope-flap, .envelope-letter { animation: none; } }

/* Disabled button styles */
.btn_1:disabled,
.btn_1[disabled] {
    opacity: 0.5 !important;
    cursor: not-allowed !important;
    pointer-events: none !important;
    background-color: #999 !important;
}
</style>
