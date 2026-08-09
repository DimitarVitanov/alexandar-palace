<script setup>
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';
import Layout from '@/Components/Frontend/Layout.vue';
import { useLocale } from '@/composables/useLocale';

const props = defineProps({
    page: Object,
    sections: Object,
    testimonials: Array,
    settings: Object,
    seo: Object,
});

const { t } = useI18n();
const { locale, ml } = useLocale();

const asset = (path) => `/assets/paradise/${path}`;

// Section helpers with fallbacks
const hero = props.sections?.hero;
const history = props.sections?.history;
const amenities = props.sections?.local_amenities;
const facilities = props.sections?.facilities;
const faq = props.sections?.faq;

// Parse JSON data arrays
const amenitiesDefaultData = {
    en: [
        {
            title: 'Local Restaurants',
            description: 'Discover the authentic flavors of Skopje, from traditional Macedonian taverns to modern fine dining. Enjoy local specialties such as tavče gravče, grilled meats, fresh salads, and homemade desserts in welcoming restaurants throughout the city.',
            links: [
                { name: 'Skopski Merak', url: 'https://www.google.com/maps/dir/?api=1&destination=Restaurant%20Skopski%20Merak%2CDebarca%20St%2051%2C%201000%2C%20Skopje%201000%2C%20North%20Macedonia' },
                { name: 'Pelister', url: 'https://www.google.com/maps/dir/?api=1&destination=Pelister%2CBoulevard%20Macedonia%2C%20Skopje%201000%2C%20North%20Macedonia' },
                { name: 'Vodenica Mulino', url: 'https://www.google.com/maps/dir/?api=1&destination=Vodenica%20Mulino%2CMitropolit%20Teodosij%20Gologanov%2069%2C%20Skopje%201000%2C%20North%20Macedonia' },
            ]
        },
        {
            title: 'Nature',
            description: 'Escape into nature just minutes from the city center. Visit the breathtaking Matka Canyon Skopje, where you can enjoy hiking, kayaking, boat tours, and spectacular limestone cliffs. For panoramic views over the city, take a walk or cable car up Mount Vodno and experience one of Skopje\'s most beautiful landscapes.',
        },
        {
            title: 'Art & Culture',
            description: 'Skopje blends centuries of history with contemporary creativity. Wander through the historic Old Bazaar, visit the Museum of Contemporary Art Skopje, explore Kale Fortress, and admire the city\'s museums, galleries, and monuments. From Ottoman architecture to modern exhibitions, Skopje offers a rich cultural experience for every visitor.',
            links: [
                { name: 'Museum of Contemporary Art', url: 'https://www.google.com/maps/dir/?api=1&destination=Museum%20of%20Contemporary%20Art%20Skopje%2CSamoilova%2017%2C%20Skopje%201000%2C%20North%20Macedonia' },
            ]
        },
    ],
    mk: [
        {
            title: 'Локални Ресторани',
            description: 'Откријте ги автентичните вкусови на Скопје, од традиционални македонски кафeани до модерни ресторани за фино вечерање. Уживајте во локални специјалитети како тавче гравче, скара, свежи салати и домашни десерти во гостопримливи ресторани низ целиот град.',
            links: [
                { name: 'Skopski Merak', url: 'https://www.google.com/maps/dir/?api=1&destination=Restaurant%20Skopski%20Merak%2CDebarca%20St%2051%2C%201000%2C%20Skopje%201000%2C%20North%20Macedonia' },
                { name: 'Pelister', url: 'https://www.google.com/maps/dir/?api=1&destination=Pelister%2CBoulevard%20Macedonia%2C%20Skopje%201000%2C%20North%20Macedonia' },
                { name: 'Vodenica Mulino', url: 'https://www.google.com/maps/dir/?api=1&destination=Vodenica%20Mulino%2CMitropolit%20Teodosij%20Gologanov%2069%2C%20Skopje%201000%2C%20North%20Macedonia' },
            ]
        },
        {
            title: 'Природа',
            description: 'Побегнете во природата само неколку минути од центарот на градот. Посетете го прекрасниот кањон Матка во Скопје, каде можете да уживате во пешачење, кајак, бродски тури и импресивни варовнички карпи. За панорамски поглед на градот, прошетајте се или качете се со жичница на планината Водно и доживејте еден од најубавите пејзажи во Скопје.',
        },
        {
            title: 'Уметност и Култура',
            description: 'Скопје ги спојува вековите историја со современата креативност. Прошетајте низ историската Стара чаршија, посетете го Музејот на современа уметност Скопје, истражете ја тврдината Кале и восхитете се на музеите, галериите и споменициte на градот. Од отоманска архитектура до модерни изложби, Скопје нуди богато културно искуство за секој посетител.',
            links: [
                { name: 'Museum of Contemporary Art', url: 'https://www.google.com/maps/dir/?api=1&destination=Museum%20of%20Contemporary%20Art%20Skopje%2CSamoilova%2017%2C%20Skopje%201000%2C%20North%20Macedonia' },
            ]
        },
    ],
    sr: [
        {
            title: 'Lokalni Restorani',
            description: 'Otkrijte autentične ukuse Skoplja, od tradicionalnih makedonskih kafana do modernih restorana sa finom kuhinjom. Uživajte u lokalnim specijalitetima kao što su tavče gravče, roštilj, sveže salate i domaći deserti u gostoljubivim restoranima širom grada.',
            links: [
                { name: 'Skopski Merak', url: 'https://www.google.com/maps/dir/?api=1&destination=Restaurant%20Skopski%20Merak%2CDebarca%20St%2051%2C%201000%2C%20Skopje%201000%2C%20North%20Macedonia' },
                { name: 'Pelister', url: 'https://www.google.com/maps/dir/?api=1&destination=Pelister%2CBoulevard%20Macedonia%2C%20Skopje%201000%2C%20North%20Macedonia' },
                { name: 'Vodenica Mulino', url: 'https://www.google.com/maps/dir/?api=1&destination=Vodenica%20Mulino%2CMitropolit%20Teodosij%20Gologanov%2069%2C%20Skopje%201000%2C%20North%20Macedonia' },
            ]
        },
        {
            title: 'Priroda',
            description: 'Pobegnite u prirodu samo nekoliko minuta od centra grada. Posetite prelepi kanjon Matka u Skoplju, gde možete uživati u planinarenju, kajaku, brodskim turama i impresivnim krečnjačkim liticama. Za panoramski pogled na grad, prošetajte ili se popnite žičarom na planinu Vodno i doživite jedan od najlepših pejzaža Skoplja.',
        },
        {
            title: 'Umetnost i Kultura',
            description: 'Skoplje spaja vekovnu istoriju sa savremenom kreativnošću. Prošetajte kroz istorijsku Staru čaršiju, posetite Muzej savremene umetnosti Skoplje, istražite tvrđavu Kale i divite se muzejima, galerijama i spomenicima grada. Od otomanske arhitekture do modernih izložbi, Skoplje nudi bogato kulturno iskustvo za svakog posetioca.',
            links: [
                { name: 'Museum of Contemporary Art', url: 'https://www.google.com/maps/dir/?api=1&destination=Museum%20of%20Contemporary%20Art%20Skopje%2CSamoilova%2017%2C%20Skopje%201000%2C%20North%20Macedonia' },
            ]
        },
    ],
    tr: [
        {
            title: 'Yerel Restoranlar',
            description: 'Geleneksel Makedon meyhanelerinden modern şık restoranlara kadar Üsküp\'ün otantik lezzetlerini keşfedin. Şehir genelindeki misafirperver restoranlarda tavče gravče, ızgara etler, taze salatalar ve ev yapımı tatlılar gibi yöresel lezzetlerin tadını çıkarın.',
            links: [
                { name: 'Skopski Merak', url: 'https://www.google.com/maps/dir/?api=1&destination=Restaurant%20Skopski%20Merak%2CDebarca%20St%2051%2C%201000%2C%20Skopje%201000%2C%20North%20Macedonia' },
                { name: 'Pelister', url: 'https://www.google.com/maps/dir/?api=1&destination=Pelister%2CBoulevard%20Macedonia%2C%20Skopje%201000%2C%20North%20Macedonia' },
                { name: 'Vodenica Mulino', url: 'https://www.google.com/maps/dir/?api=1&destination=Vodenica%20Mulino%2CMitropolit%20Teodosij%20Gologanov%2069%2C%20Skopje%201000%2C%20North%20Macedonia' },
            ]
        },
        {
            title: 'Doğa',
            description: 'Şehir merkezinden sadece birkaç dakika uzaklıkta doğaya kaçış yapın. Yürüyüş, kano ve tekne turlarının yanı sıra etkileyici kireçtaşı kayalıklarıyla nefes kesici Matka Kanyonu\'nu ziyaret edin. Şehrin panoramik manzarası için Vodno Dağı\'na yürüyün veya teleferikle çıkın ve Üsküp\'ün en güzel manzaralarından birini yaşayın.',
        },
        {
            title: 'Sanat ve Kültür',
            description: 'Üsküp, asırlık tarihi çağdaş yaratıcılıkla harmanlıyor. Tarihi Eski Çarşı\'da gezinin, Üsküp Çağdaş Sanatlar Müzesi\'ni ziyaret edin, Kale Kalesi\'ni keşfedin ve şehrin müzelerine, galerilerine ve anıtlarına hayran kalın. Osmanlı mimarisinden modern sergilere kadar Üsküp, her ziyaretçiye zengin bir kültürel deneyim sunar.',
            links: [
                { name: 'Museum of Contemporary Art', url: 'https://www.google.com/maps/dir/?api=1&destination=Museum%20of%20Contemporary%20Art%20Skopje%2CSamoilova%2017%2C%20Skopje%201000%2C%20North%20Macedonia' },
            ]
        },
    ],
    sq: [
        {
            title: 'Restorante Lokale',
            description: 'Zbuloni shijet autentike të Shkupit, nga tavernat tradicionale maqedonase deri te restorantet moderne elegante. Shijoni specialitete lokale si tavče gravče, mish në skarë, sallata të freskëta dhe ëmbëlsira shtëpiake në restorante mikpritëse në të gjithë qytetin.',
            links: [
                { name: 'Skopski Merak', url: 'https://www.google.com/maps/dir/?api=1&destination=Restaurant%20Skopski%20Merak%2CDebarca%20St%2051%2C%201000%2C%20Skopje%201000%2C%20North%20Macedonia' },
                { name: 'Pelister', url: 'https://www.google.com/maps/dir/?api=1&destination=Pelister%2CBoulevard%20Macedonia%2C%20Skopje%201000%2C%20North%20Macedonia' },
                { name: 'Vodenica Mulino', url: 'https://www.google.com/maps/dir/?api=1&destination=Vodenica%20Mulino%2CMitropolit%20Teodosij%20Gologanov%2069%2C%20Skopje%201000%2C%20North%20Macedonia' },
            ]
        },
        {
            title: 'Natyra',
            description: 'Shpëtoni në natyrë vetëm disa minuta larg qendrës së qytetit. Vizitoni kanionin mahnitës Matka të Shkupit, ku mund të shijoni ecje në natyrë, kajak, ture me varkë dhe shkëmbinj gëlqerorë spektakolarë. Për pamje panoramike mbi qytet, ecni ose merrni teleferikun në malin Vodno dhe përjetoni një nga peizazhet më të bukura të Shkupit.',
        },
        {
            title: 'Arti dhe Kultura',
            description: 'Shkupi bashkon shekuj histori me krijimtarinë bashkëkohore. Bredhni nëpër Çarshinë e Vjetër historike, vizitoni Muzeun e Artit Bashkëkohor të Shkupit, eksploroni Kalanë Kale dhe admironi muzetë, galeritë dhe monumentet e qytetit. Nga arkitektura osmane deri te ekspozitat moderne, Shkupi ofron një përvojë të pasur kulturore për çdo vizitor.',
            links: [
                { name: 'Museum of Contemporary Art', url: 'https://www.google.com/maps/dir/?api=1&destination=Museum%20of%20Contemporary%20Art%20Skopje%2CSamoilova%2017%2C%20Skopje%201000%2C%20North%20Macedonia' },
            ]
        },
    ],
};
const amenitiesList = computed(() => amenities?.data?.items || amenitiesDefaultData[locale.value] || amenitiesDefaultData.en);

const facilitiesData = {
    en: [
        { icon: 'customicon-private-parking', title: 'Private Parking', description: 'Complimentary private parking is available for all hotel guests, ensuring a convenient and secure stay.' },
        { icon: 'customicon-wifi', title: 'High Speed Wifi', description: 'Stay connected with complimentary high-speed WiFi available throughout the hotel and in all rooms.' },
        { icon: 'customicon-cocktail', title: 'Bar & Restaurant', description: 'Enjoy exquisite dining at our restaurant and unwind at our bar with a selection of fine wines and cocktails.' },
        { icon: 'customicon-swimming-pool', title: 'Swimming Pool', description: 'Relax and refresh in our indoor swimming pool, perfect for a rejuvenating swim any time of year.' },
    ],
    mk: [
        { icon: 'customicon-private-parking', title: 'Приватен Паркинг', description: 'Бесплатен приватен паркинг е достапен за сите гости на хотелот.' },
        { icon: 'customicon-wifi', title: 'Брз WiFi', description: 'Останете поврзани со бесплатен брз WiFi достапен низ целиот хотел.' },
        { icon: 'customicon-cocktail', title: 'Бар и Ресторан', description: 'Уживајте во извонредна храна во нашиот ресторан и опуштете се во нашиот бар.' },
        { icon: 'customicon-swimming-pool', title: 'Базен', description: 'Релаксирајте и освежете се во нашиот затворен базен.' },
    ],
    sr: [
        { icon: 'customicon-private-parking', title: 'Privatni Parking', description: 'Besplatan privatni parking je dostupan svim gostima hotela, obezbeđujući udoban i bezbedan boravak.' },
        { icon: 'customicon-wifi', title: 'Brz WiFi', description: 'Ostanite povezani sa besplatnim brzim WiFi-jem dostupnim u celom hotelu i u svim sobama.' },
        { icon: 'customicon-cocktail', title: 'Bar i Restoran', description: 'Uživajte u izvrsnoj hrani u našem restoranu i opustite se u našem baru uz izbor finih vina i koktela.' },
        { icon: 'customicon-swimming-pool', title: 'Bazen', description: 'Opustite se i osvežite u našem zatvorenom bazenu, savršenom za okrepljujuće plivanje u bilo koje doba godine.' },
    ],
    tr: [
        { icon: 'customicon-private-parking', title: 'Özel Otopark', description: 'Tüm otel misafirlerimiz için ücretsiz özel otopark hizmeti sunulmaktadır, konforlu ve güvenli bir konaklama sağlar.' },
        { icon: 'customicon-wifi', title: 'Yüksek Hızlı Wifi', description: 'Otelin her yerinde ve tüm odalarda ücretsiz yüksek hızlı WiFi ile bağlantıda kalın.' },
        { icon: 'customicon-cocktail', title: 'Bar ve Restoran', description: 'Restoranımızda enfes yemeklerin tadını çıkarın ve barımızda seçkin şarap ve kokteyllerle rahatlayın.' },
        { icon: 'customicon-swimming-pool', title: 'Yüzme Havuzu', description: 'Kapalı yüzme havuzumuzda dinlenin ve tazelenin, yılın her döneminde canlandırıcı bir yüzme için idealdir.' },
    ],
    sq: [
        { icon: 'customicon-private-parking', title: 'Parking Privat', description: 'Parkingu privat falas është i disponueshëm për të gjithë mysafirët e hotelit, duke siguruar një qëndrim të rehatshëm dhe të sigurt.' },
        { icon: 'customicon-wifi', title: 'Wifi me Shpejtësi të Lartë', description: 'Qëndroni të lidhur me Wifi falas me shpejtësi të lartë të disponueshëm në të gjithë hotelin dhe në të gjitha dhomat.' },
        { icon: 'customicon-cocktail', title: 'Bar dhe Restorant', description: 'Shijoni ushqime të shkëlqyera në restorantin tonë dhe relaksohuni në barin tonë me një përzgjedhje verërash dhe koktejesh të shkëlqyera.' },
        { icon: 'customicon-swimming-pool', title: 'Pishinë', description: 'Relaksohuni dhe freskohuni në pishinën tonë të mbyllur, ideale për një not rigjenerues në çdo kohë të vitit.' },
    ],
};
const facilitiesList = computed(() => facilities?.data?.items || facilitiesData[locale.value] || facilitiesData.en);

const faqData = {
    en: [
        { question: 'Cancellation Policy', answer: 'Free cancellation is available up to 48 hours before check-in. Cancellations made within 48 hours of arrival may be subject to a charge equivalent to one night\'s stay. No-shows will be charged the full reservation amount.' },
        { question: 'Payment Methods', answer: 'We accept all major credit cards (Visa, MasterCard, American Express), bank transfers, and cash payments. A valid credit card is required at check-in for incidentals. Full payment can be made upon arrival or departure.' },
        { question: 'Check In / Out Times', answer: 'Check-in time is from 14:00 (2:00 PM). Check-out time is until 11:00 (11:00 AM). Early check-in and late check-out may be available upon request, subject to availability and additional charges.' },
        { question: 'Accessibility', answer: 'Our hotel is fully accessible for guests with disabilities. We offer accessible rooms, ramps, elevators, and accessible parking spaces. Please contact us in advance to arrange any special requirements.' },
    ],
    mk: [
        { question: 'Политика за Откажување', answer: 'Бесплатно откажување е достапно до 48 часа пред пријавување. Откажувањата направени во рок од 48 часа од пристигнувањето може да бидат наплатени еквивалентно на една ноќевање.' },
        { question: 'Начини на Плаќање', answer: 'Прифаќаме сите главни кредитни картички (Visa, MasterCard, American Express), банкарски трансфери и готовински плаќања. Валидна кредитна картичка е потребна при пријавување.' },
        { question: 'Време на Пријавување / Одјавување', answer: 'Времето за пријавување е од 14:00 часот. Времето за одјавување е до 11:00 часот. Рано пријавување и доцно одјавување може да бидат достапни на барање.' },
        { question: 'Пристапност', answer: 'Нашиот хотел е целосно пристапен за гости со попреченост. Нудиме пристапни соби, рампи, лифтови и пристапни паркинг места. Контактирајте нè однапред за посебни барања.' },
    ],
    sr: [
        { question: 'Politika Otkazivanja', answer: 'Besplatno otkazivanje je moguće do 48 sati pre prijave. Otkazivanja izvršena u roku od 48 sati pre dolaska mogu biti naplaćena u iznosu jedne noćenja. Nedolazak bez otkazivanja naplaćuje se u punom iznosu rezervacije.' },
        { question: 'Načini Plaćanja', answer: 'Prihvatamo sve glavne kreditne kartice (Visa, MasterCard, American Express), bankovne transfere i gotovinska plaćanja. Važeća kreditna kartica je potrebna prilikom prijave za dodatne troškove. Puno plaćanje se može izvršiti po dolasku ili odlasku.' },
        { question: 'Vreme Prijave / Odjave', answer: 'Prijava je moguća od 14:00 časova. Odjava je do 11:00 časova. Ranija prijava i kasnija odjava mogu biti dostupne na zahtev, u zavisnosti od raspoloživosti i uz dodatnu naplatu.' },
        { question: 'Pristupačnost', answer: 'Naš hotel je u potpunosti pristupačan gostima sa invaliditetom. Nudimo pristupačne sobe, rampe, liftove i pristupačna parking mesta. Kontaktirajte nas unapred kako biste dogovorili posebne zahteve.' },
    ],
    tr: [
        { question: 'İptal Politikası', answer: 'Giriş yapmadan 48 saat öncesine kadar ücretsiz iptal mümkündür. Varıştan 48 saat içinde yapılan iptallerde bir gecelik konaklama ücreti tahsil edilebilir. Gelmeyen misafirlerden rezervasyonun tam tutarı tahsil edilir.' },
        { question: 'Ödeme Yöntemleri', answer: 'Tüm büyük kredi kartlarını (Visa, MasterCard, American Express), banka havalelerini ve nakit ödemeleri kabul ediyoruz. Giriş sırasında ek masraflar için geçerli bir kredi kartı gereklidir. Tam ödeme varışta veya ayrılışta yapılabilir.' },
        { question: 'Giriş / Çıkış Saatleri', answer: 'Giriş saati 14:00\'ten itibarendir. Çıkış saati 11:00\'e kadardır. Erken giriş ve geç çıkış, müsaitlik durumuna ve ek ücrete tabi olarak talep üzerine sağlanabilir.' },
        { question: 'Erişilebilirlik', answer: 'Otelimiz engelli misafirler için tamamen erişilebilirdir. Erişilebilir odalar, rampalar, asansörler ve erişilebilir otopark alanları sunuyoruz. Özel gereksinimlerinizi düzenlemek için lütfen önceden bizimle iletişime geçin.' },
    ],
    sq: [
        { question: 'Politika e Anulimit', answer: 'Anulimi falas është i mundur deri në 48 orë para check-in. Anulimet e bëra brenda 48 orëve nga mbërritja mund t\'i nënshtrohen një pagese ekuivalente me një natë qëndrimi. Mospërdorimi pa anulim do të faturohet me shumën e plotë të rezervimit.' },
        { question: 'Mënyrat e Pagesës', answer: 'Pranojmë të gjitha kartat kryesore të kreditit (Visa, MasterCard, American Express), transfertat bankare dhe pagesat në para të gatshme. Një kartë krediti e vlefshme kërkohet gjatë check-in për shpenzime shtesë. Pagesa e plotë mund të bëhet në mbërritje ose nisje.' },
        { question: 'Orari i Check-in / Check-out', answer: 'Check-in është nga ora 14:00. Check-out është deri në orën 11:00. Check-in i hershëm dhe check-out i vonuar mund të jenë të disponueshëm sipas kërkesës, në varësi të disponueshmërisë dhe pagesave shtesë.' },
        { question: 'Aksesueshmëria', answer: 'Hoteli ynë është plotësisht i aksesueshëm për mysafirët me aftësi të kufizuara. Ofrojmë dhoma të aksesueshme, rampa, ashensorë dhe vende parkimi të aksesueshme. Ju lutemi na kontaktoni paraprakisht për të organizuar çdo kërkesë të veçantë.' },
    ],
};
const faqList = computed(() => faq?.data?.items || faqData[locale.value] || faqData.en);

const amenitiesImages = amenities?.data?.images || ['img/about/restaurants.webp', 'img/about/nature.webp', 'img/about/culture.webp'];

// Vue-controlled accordion state
import { ref } from 'vue';
const openFaqIndex = ref(null);

const toggleFaq = (index) => {
    openFaqIndex.value = openFaqIndex.value === index ? null : index;
};
</script>

<template>
    <Layout
        :title="seo?.title || 'About Us'"
        :description="seo?.description"
        :keywords="seo?.keywords"
        :image="seo?.image"
        :canonical="seo?.canonical"
        :schema="seo?.schema"
        :alternateUrls="seo?.alternateUrls"
    >
        <!-- Hero Section -->
        <div class="hero small-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img about-hero-img" :src="hero?.image ? asset(hero.image) : asset('img/about-us-modified.webp')" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small class="slide-animated one">{{ hero?.subtitle || ml({ en: 'Luxury Hotel Experience', mk: 'Луксузно Хотелско Искуство', sr: 'Luksuzno Hotelsko Iskustvo', tr: 'Lüks Otel Deneyimi', sq: 'Përvojë Hoteliere Luksoze' }) }}</small>
                    <h1 class="slide-animated two">{{ hero?.title || ml({ en: 'About Alexandar Palace', mk: 'За Александар Палас', sr: 'O Alexandar Palace', tr: 'Alexandar Palace Hakkında', sq: 'Rreth Alexandar Palace' }) }}</h1>
                </div>
            </div>
        </div>

        <!-- Our History Section -->
        <div class="container margin_120_95">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-5">
                    <div class="parallax_wrapper inverted">
                        <img :src="history?.data?.image1 ? asset(history.data.image1) : asset('img/about-1.webp')" alt="" class="img-fluid rounded-img history-img">
                        <div data-cue="slideInUp" class="img_over">
                            <span data-jarallax-element="-30">
                                <img :src="history?.data?.image2 ? asset(history.data.image2) : asset('img/about-us-two.webp')" alt="" class="rounded-img">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="intro">
                        <div class="title">
                            <small>{{ history?.subtitle || ml({ en: 'Alexandar Palace Hotel', mk: 'Хотел Александар Палас', sr: 'Hotel Alexandar Palace', tr: 'Alexandar Palace Otel', sq: 'Hoteli Alexandar Palace' }) }}</small>
                            <h2>{{ history?.title || ml({ en: 'Our History', mk: 'Нашата Историја', sr: 'Naša Istorija', tr: 'Tarihimiz', sq: 'Historia Jonë' }) }}</h2>
                        </div>
                        <div v-if="history?.content" v-html="history.content"></div>
                        <template v-else>
                            <p v-if="locale === 'mk'" class="lead">Хотелот Александар Палас, водечки хотел во Македонија, се наоѓа на десниот брег на реката Вардар веднаш до градскиот парк, само 3 км од центарот на градот и во непосредна близина на најважните административни, културни и историски објекти.</p>
                            <p v-else-if="locale === 'sr'" class="lead">Hotel Aleksandar Palas, vodeći hotel u Makedoniji, nalazi se na desnoj obali reke Vardar odmah pored gradskog parka, samo 3 km od centra grada i u neposrednoj blizini najvažnijih administrativnih, kulturnih i istorijskih objekata.</p>
                            <p v-else-if="locale === 'tr'" class="lead">Makedonya'nın önde gelen oteli Aleksandar Palace, Vardar Nehri'nin sağ kıyısında, şehir parkının hemen yanında, şehir merkezine sadece 3 km uzaklıkta ve en önemli idari, kültürel ve tarihi binaların hemen yakınında yer almaktadır.</p>
                            <p v-else-if="locale === 'sq'" class="lead">Hoteli Aleksandar Palace, hoteli kryesor në Maqedoni, ndodhet në bregun e djathtë të lumit Vardar menjëherë pranë parkut të qytetit, vetëm 3 km larg qendrës së qytetit dhe në afërsi të drejtpërdrejtë të objekteve më të rëndësishme administrative, kulturore dhe historike.</p>
                            <p v-else class="lead">The hotel Aleksandar Palace, leading hotel in Macedonia, is located on the right bank of the river Vardar next to the city park, only 3 km away from the town center and just next to the most important administrative, cultural and historical buildings.</p>
                           <!-- <p><em>Maria...the Owner</em></p> -->
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Local Amenities Section -->
        <div class="bg_white">
            <div class="container margin_120_95">
                <div class="row justify-content-between">
                    <div class="col-lg-5 fixed_title">
                        <div class="title">
                            <small>{{ amenities?.subtitle || ml({ en: 'Alexandar Palace Hotel', mk: 'Хотел Александар Палас', sr: 'Hotel Alexandar Palace', tr: 'Alexandar Palace Otel', sq: 'Hoteli Alexandar Palace' }) }}</small>
                            <h2>{{ amenities?.title || ml({ en: 'Local Amenities', mk: 'Локални Погодности', sr: 'Lokalne Pogodnosti', tr: 'Yerel Olanaklar', sq: 'Lehtësi Lokale' }) }}</h2>
                            <p v-if="amenities?.content" v-html="amenities.content"></p>
                            <p v-else>{{ t('about.local_amenities_text') }}</p>
                        </div>
                        <div class="list_ok">
                            <ul>
                                <li v-for="(item, index) in amenitiesList" :key="index" data-cue="slideInUp" :data-delay="200 + (index * 100)">
                                    <h5>{{ item.title }}</h5>
                                    <p>{{ item.description }}</p>
                                    <p v-if="item.links && item.links.length" class="mt-2">
                                        <template v-for="(link, linkIndex) in item.links" :key="linkIndex">
                                            <a :href="link.url" target="_blank" rel="noopener" class="animated_link me-3"><strong>{{ link.name }} <i class="bi bi-geo-alt"></i></strong></a>
                                        </template>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div v-for="(img, index) in amenitiesImages" :key="index" data-cue="fadeIn" data-delay="500">
                            <figure><img :src="asset(img)" alt="" class="img-fluid rounded-img"></figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Section (hidden) -->
        <div class="parallax_section_1 jarallax d-none" data-jarallax data-speed="0.2">
            <img class="jarallax-img" :src="asset('img/hero_home_1.jpg')" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="title white">
                                <small class="mb-1">Testimonials</small>
                                <h2>What Clients Says</h2>
                            </div>
                            <div class="carousel_testimonials owl-carousel owl-theme nav-dots-orizontal">
                                <div v-for="(testimonial, index) in (testimonials || [])" :key="index">
                                    <div class="box_overlay">
                                        <div class="pic">
                                            <figure><img :src="asset('img/testimonial_1.jpg')" alt="" class="img-circle"></figure>
                                            <h4>{{ testimonial.name }}<small>{{ testimonial.date }}</small></h4>
                                        </div>
                                        <div class="comment">"{{ testimonial.content }}"</div>
                                    </div>
                                </div>
                                <!-- Default testimonials if none provided -->
                                <div v-if="!testimonials || testimonials.length === 0">
                                    <div class="box_overlay">
                                        <div class="pic">
                                            <figure><img :src="asset('img/testimonial_1.jpg')" alt="" class="img-circle"></figure>
                                            <h4>Roberta<small>12 Oct</small></h4>
                                        </div>
                                        <div class="comment">"Mea ad postea meliore fuisset. Timeam repudiare id eum, ex paulo dictas elaboraret sed, mel cu unum nostrud."</div>
                                    </div>
                                </div>
                                <div v-if="!testimonials || testimonials.length === 0">
                                    <div class="box_overlay">
                                        <div class="pic">
                                            <figure><img :src="asset('img/testimonial_1.jpg')" alt="" class="img-circle"></figure>
                                            <h4>John<small>2 Nov</small></h4>
                                        </div>
                                        <div class="comment">"Mea ad postea meliore fuisset. Timeam repudiare id eum, ex paulo dictas elaboraret sed, mel cu unum nostrud."</div>
                                    </div>
                                </div>
                                <div v-if="!testimonials || testimonials.length === 0">
                                    <div class="box_overlay">
                                        <div class="pic">
                                            <figure><img :src="asset('img/testimonial_1.jpg')" alt="" class="img-circle"></figure>
                                            <h4>Sarah<small>3 Dec</small></h4>
                                        </div>
                                        <div class="comment">"Mea ad postea meliore fuisset. Timeam repudiare id eum, ex paulo dictas elaboraret sed, mel cu unum nostrud."</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Facilities Section -->
        <div class="container margin_120_95">
            <div class="title text-center mb-5">
                <small data-cue="slideInUp">{{ facilities?.subtitle || ml({ en: 'Alexandar Palace Hotel', mk: 'Хотел Александар Палас', sr: 'Hotel Alexandar Palace', tr: 'Alexandar Palace Otel', sq: 'Hoteli Alexandar Palace' }) }}</small>
                <h2 data-cue="slideInUp" data-delay="100">{{ facilities?.title || ml({ en: 'Main Facilities', mk: 'Главни Капацитети', sr: 'Glavni Sadržaji', tr: 'Ana Olanaklar', sq: 'Lehtësitë Kryesore' }) }}</h2>
            </div>
            <div class="row mt-4">
                <div v-for="(facility, index) in facilitiesList" :key="index" class="col-lg-3 col-md-6">
                    <div class="box_facilities" :class="{ 'no-border': index === 0 }" data-cue="slideInUp">
                        <i :class="facility.icon"></i>
                        <h3>{{ facility.title }}</h3>
                        <p>{{ facility.description }}</p>
                    </div>
                </div>
            </div>

            <hr class="more_margin">

            <!-- FAQ Section -->
            <div class="row justify-content-between margin_60_0">
                <div class="col-lg-4">
                    <div class="title">
                        <small>{{ faq?.subtitle || ml({ en: 'Alexandar Palace Hotel FAQ', mk: 'Александар Палас Хотел', sr: 'Alexandar Palace Hotel FAQ', tr: 'Alexandar Palace Otel SSS', sq: 'Pyetjet e Shpeshta të Hotelit Alexandar Palace' }) }}</small>
                        <h3>{{ faq?.title || ml({ en: 'Frequently Asked Questions', mk: 'Често Поставувани Прашања', sr: 'Često Postavljana Pitanja', tr: 'Sıkça Sorulan Sorular', sq: 'Pyetjet e Bëra Shpesh' }) }}</h3>
                    </div>
                    <p v-if="faq?.content" v-html="faq.content"></p>
                    <p v-else>{{ ml({ en: "Can't find your question in the list? Let us know your questions.", mk: 'Не го најдовте вашето прашање? Контактирајте нè.', sr: 'Ne pronalazite svoje pitanje na listi? Javite nam vaša pitanja.', tr: 'Sorunuzu listede bulamadınız mı? Sorularınızı bize iletin.', sq: 'Nuk e gjetët pyetjen tuaj në listë? Na tregoni pyetjet tuaja.' }) }}</p>
                    <p><Link href="/contacts" class="animated_link"><strong>{{ ml({ en: 'Contact Us', mk: 'Контактирајте нè', sr: 'Kontaktirajte Nas', tr: 'Bizimle İletişime Geçin', sq: 'Na Kontaktoni' }) }} <i class="bi bi-arrow-right"></i></strong></Link></p>
                </div>
                <div class="col-lg-7">
                    <div class="mb-5 accordion about-faq-accordion">
                        <div v-for="(item, index) in faqList" :key="index" class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <a href="#" @click.prevent="toggleFaq(index)" :class="{ 'collapsed': openFaqIndex !== index }">
                                        <i class="indicator bi-plus-lg"></i>{{ item.question }}
                                    </a>
                                </h5>
                            </div>
                            <Transition name="faq-slide">
                                <div v-show="openFaqIndex === index" class="faq-content">
                                    <div class="card-body">
                                        <p>{{ item.answer }}</p>
                                    </div>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.about-hero-img {
    object-position: 80% 80% !important;
}

.history-img {
    max-width: 600px;
}

/* Fix mobile overflow */
@media (max-width: 991px) {
    :deep(.parallax_wrapper) {
        overflow: hidden;
    }
    
    :deep(.img_over) {
        position: relative;
        margin-top: -50px;
    }
}

@media (max-width: 767px) {
    :deep(.parallax_wrapper),
    :deep(.parallax_wrapper.inverted) {
        max-width: 100%;
        overflow: hidden;
    }
    
    :deep(.img_over) {
        position: relative;
        margin-top: 0;
        padding: 15px;
    }
    
    :deep(.img_over span) {
        position: relative;
        left: 0;
        right: 0;
    }
    
    .history-img {
        max-width: 100%;
    }
}

/* Vue-controlled FAQ accordion styles */
.about-faq-accordion .card-body {
    padding: 15px 20px;
}

.about-faq-accordion .card-body p {
    margin: 0;
    color: #555;
    line-height: 1.7;
}

.about-faq-accordion .faq-content {
    display: block;
}

.about-faq-accordion .card-header a:not(.collapsed) i.indicator {
    transform: rotate(45deg);
}

/* FAQ slide transition */
.faq-slide-enter-active,
.faq-slide-leave-active {
    transition: all 0.5s ease;
    overflow: hidden;
}

.faq-slide-enter-from,
.faq-slide-leave-to {
    opacity: 0;
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
}

.faq-slide-enter-to,
.faq-slide-leave-from {
    opacity: 1;
    max-height: 500px;
}
</style>
