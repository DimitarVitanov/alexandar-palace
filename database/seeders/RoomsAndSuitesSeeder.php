<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomsAndSuitesSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing rooms
        Room::truncate();

        $rooms = [
            // ROOMS
            [
                'slug' => 'single-room',
                'name' => [
                    'en' => 'Single Room',
                    'mk' => 'Еднокреветна Соба',
                ],
                'description' => [
                    'en' => '<p>Experience comfort and elegance in our thoughtfully designed Single Room at Alexandar Palace Hotel. Perfect for solo travelers and business guests, this cozy retreat offers everything you need for a relaxing stay in the heart of Skopje.</p>
                    <p>The room features a comfortable single bed with premium linens, a modern en-suite bathroom, and a work desk ideal for business travelers. Enjoy stunning views of the city or the serene hotel gardens while you unwind after a day of exploring Macedonia\'s capital.</p>
                    <p>Our Single Rooms are equipped with high-speed Wi-Fi, a Smart TV with international channels, a mini bar, and climate control for your comfort. The elegant décor combines contemporary style with warm Macedonian hospitality.</p>',
                    'mk' => '<p>Доживејте удобност и елеганција во нашата внимателно дизајнирана Еднокреветна Соба во хотелот Александар Палас. Совршена за самостојни патници и деловни гости, оваа пријатна соба нуди сè што ви е потребно за релаксирачки престој во срцето на Скопје.</p>
                    <p>Собата располага со удобен еднокреветен кревет со премиум постелнина, модерно приватно бањо и работна маса идеална за деловни патници. Уживајте во прекрасни погледи кон градот или мирните хотелски градини додека се одморате по ден исполнет со истражување на главниот град на Македонија.</p>
                    <p>Нашите Еднокреветни Соби се опремени со брз Wi-Fi, Smart TV со меѓународни канали, мини бар и климатизација за ваша удобност. Елегантниот декор комбинира современ стил со топло македонско гостопримство.</p>',
                ],
                'short_description' => [
                    'en' => 'Cozy single room perfect for solo travelers, featuring modern amenities and elegant comfort in the heart of Skopje.',
                    'mk' => 'Пријатна еднокреветна соба совршена за самостојни патници, со модерни удобности и елегантна удобност во срцето на Скопје.',
                ],
                'amenities' => ['wifi', 'lan', 'parking', 'smart-tv', 'mini-bar', 'telephone', 'spa', 'pool', 'laundry'],
                'price_per_night' => 80.00,
                'max_guests' => 1,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'square_meters' => 22,
                'featured_image' => 'img/rooms/single/1.webp',
                'gallery_images' => [
                    'img/rooms/single/1.webp',
                    'img/rooms/single/2.webp',
                    'img/rooms/single/3.webp',
                    'img/rooms/single/4.webp',
                    'img/rooms/single/5.webp',
                    'img/rooms/single/6.webp',
                    'img/rooms/single/7.webp',
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'total_units' => 15,
                'bed_type' => 'Single',
                'view_type' => 'City/Garden',
                'meta_title' => [
                    'en' => 'Single Room | Alexandar Palace Hotel Skopje - Comfortable Solo Stay',
                    'mk' => 'Еднокреветна Соба | Хотел Александар Палас Скопје - Удобен Престој',
                ],
                'meta_description' => [
                    'en' => 'Book a comfortable Single Room at Alexandar Palace Hotel in Skopje. Perfect for solo travelers with Wi-Fi, Smart TV, mini bar, spa & pool access. From €80/night.',
                    'mk' => 'Резервирајте удобна Еднокреветна Соба во хотелот Александар Палас во Скопје. Совршена за самостојни патници со Wi-Fi, Smart TV, мини бар, спа и базен. Од €80/ноќ.',
                ],
            ],
            [
                'slug' => 'double-room',
                'name' => [
                    'en' => 'Double Room',
                    'mk' => 'Двокреветна Соба',
                ],
                'description' => [
                    'en' => '<p>Discover the perfect blend of comfort and sophistication in our spacious Double Room at Alexandar Palace Hotel. Ideal for couples or guests who appreciate extra space, this elegantly appointed room offers a luxurious retreat in Macedonia\'s premier hotel.</p>
                    <p>The room features a plush double bed with premium bedding, an elegant en-suite bathroom with rain shower, and a comfortable seating area. Large windows flood the space with natural light and offer beautiful views of Skopje or our manicured gardens.</p>
                    <p>Enjoy comprehensive amenities including high-speed Wi-Fi, Smart TV, mini bar, and complimentary access to our world-class spa facilities featuring Turkish bath, Swedish sauna, infrared sauna, steam room, and professional massage services. Our fitness center and swimming pool are also at your disposal.</p>',
                    'mk' => '<p>Откријте ја совршената комбинација на удобност и софистицираност во нашата простора Двокреветна Соба во хотелот Александар Палас. Идеална за парови или гости кои ценат дополнителен простор, оваа елегантно уредена соба нуди луксузно засолниште во премиер хотелот на Македонија.</p>
                    <p>Собата располага со мек двокреветен кревет со премиум постелнина, елегантно приватно бањо со туш со дожд, и удобна зона за седење. Големите прозорци го исполнуваат просторот со природна светлина и нудат прекрасни погледи кон Скопје или нашите уредени градини.</p>
                    <p>Уживајте во сеопфатни удобности вклучувајќи брз Wi-Fi, Smart TV, мини бар, и бесплатен пристап до нашите светски познати спа објекти со турско бањо, шведска сауна, инфрацрвена сауна, парна соба и професионални масажи. Нашиот фитнес центар и базен исто така се на ваше располагање.</p>',
                ],
                'short_description' => [
                    'en' => 'Spacious double room for couples, featuring premium amenities and full spa access including Turkish bath and sauna.',
                    'mk' => 'Простора двокреветна соба за парови, со премиум удобности и целосен пристап до спа вклучувајќи турско бањо и сауна.',
                ],
                'amenities' => ['wifi', 'lan', 'parking', 'smart-tv', 'mini-bar', 'telephone', 'spa', 'pool', 'laundry', 'fitness', 'turkish-bath', 'swedish-sauna', 'infrared-sauna', 'steam-room', 'massage', 'dry-cleaning'],
                'price_per_night' => 100.00,
                'max_guests' => 2,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'square_meters' => 28,
                'featured_image' => 'img/rooms/double/1.webp',
                'gallery_images' => [
                    'img/rooms/double/1.webp',
                    'img/rooms/double/2.webp',
                    'img/rooms/double/3.webp',
                    'img/rooms/double/4.webp',
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'total_units' => 25,
                'bed_type' => 'Double',
                'view_type' => 'City/Garden',
                'meta_title' => [
                    'en' => 'Double Room | Alexandar Palace Hotel Skopje - Luxury Couples Accommodation',
                    'mk' => 'Двокреветна Соба | Хотел Александар Палас Скопје - Луксузно Сместување за Парови',
                ],
                'meta_description' => [
                    'en' => 'Book a luxurious Double Room at Alexandar Palace Hotel Skopje. Ideal for couples with spa access, Turkish bath, sauna, pool & fitness. From €100/night.',
                    'mk' => 'Резервирајте луксузна Двокреветна Соба во хотелот Александар Палас Скопје. Идеална за парови со спа, турско бањо, сауна, базен и фитнес. Од €100/ноќ.',
                ],
            ],
            [
                'slug' => 'twin-room',
                'name' => [
                    'en' => 'Twin Room',
                    'mk' => 'Соба со Две Одделни Кревети',
                ],
                'description' => [
                    'en' => '<p>Our Twin Room at Alexandar Palace Hotel offers the perfect accommodation for friends traveling together or colleagues on a business trip. Featuring two comfortable single beds, this thoughtfully designed room provides both privacy and shared comfort.</p>
                    <p>Each bed is dressed in premium linens, ensuring a restful night\'s sleep. The modern en-suite bathroom, spacious wardrobe, and dedicated work area make this room ideal for both leisure and business travelers.</p>
                    <p>Guests enjoy full access to our exceptional amenities including the spa center with Turkish bath, Swedish and infrared saunas, steam room, and massage services. The fitness center and swimming pool complete your wellness experience at Alexandar Palace.</p>',
                    'mk' => '<p>Нашата Соба со Две Одделни Кревети во хотелот Александар Палас нуди совршено сместување за пријатели кои патуваат заедно или колеги на деловно патување. Со два удобни еднокреветни кревети, оваа внимателно дизајнирана соба обезбедува и приватност и заедничка удобност.</p>
                    <p>Секој кревет е облечен во премиум постелнина, обезбедувајќи одморен ноќен сон. Модерното приватно бањо, просторниот гардеробер и посветената работна зона ја прават оваа соба идеална и за туристички и за деловни патници.</p>
                    <p>Гостите уживаат целосен пристап до нашите исклучителни удобности вклучувајќи спа центар со турско бањо, шведска и инфрацрвена сауна, парна соба и услуги за масажа. Фитнес центарот и базенот го комплетираат вашето велнес искуство во Александар Палас.</p>',
                ],
                'short_description' => [
                    'en' => 'Comfortable twin room with two single beds, perfect for friends or colleagues with full spa and wellness access.',
                    'mk' => 'Удобна соба со две одделни кревети, совршена за пријатели или колеги со целосен пристап до спа и велнес.',
                ],
                'amenities' => ['wifi', 'lan', 'parking', 'smart-tv', 'mini-bar', 'telephone', 'spa', 'pool', 'laundry', 'fitness', 'turkish-bath', 'swedish-sauna', 'infrared-sauna', 'steam-room', 'massage'],
                'price_per_night' => 100.00,
                'max_guests' => 2,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'square_meters' => 28,
                'featured_image' => 'img/rooms/twin/1.webp',
                'gallery_images' => [
                    'img/rooms/twin/1.webp',
                    'img/rooms/twin/2.webp',
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'total_units' => 10,
                'bed_type' => 'Twin',
                'view_type' => 'City/Garden',
                'meta_title' => [
                    'en' => 'Twin Room | Alexandar Palace Hotel Skopje - Perfect for Friends & Colleagues',
                    'mk' => 'Соба со Две Кревети | Хотел Александар Палас Скопје - Совршена за Пријатели',
                ],
                'meta_description' => [
                    'en' => 'Book a Twin Room at Alexandar Palace Hotel Skopje. Two single beds, ideal for friends or business travelers. Spa, sauna & pool access. From €100/night.',
                    'mk' => 'Резервирајте Соба со Две Кревети во хотелот Александар Палас Скопје. Два еднокреветни кревети, идеална за пријатели или деловни патници. Од €100/ноќ.',
                ],
            ],

            // SUITES
            [
                'slug' => 'junior-suite',
                'name' => [
                    'en' => 'Junior Suite',
                    'mk' => 'Јуниор Апартман',
                ],
                'description' => [
                    'en' => '<p>Step into refined luxury with our Junior Suite at Alexandar Palace Hotel. This generously proportioned accommodation offers the perfect balance of living and sleeping space, making it ideal for extended stays or guests who appreciate extra room to relax.</p>
                    <p>The suite features a comfortable king-size bed, a separate sitting area with plush seating, and an elegant bathroom with premium amenities. Floor-to-ceiling windows provide abundant natural light and showcase beautiful views of Skopje\'s skyline or our peaceful gardens.</p>
                    <p>Indulge in our comprehensive amenities including complimentary spa access with Turkish bath, Swedish sauna, infrared sauna, steam room, and professional massage treatments. The fitness center, swimming pool, and dry cleaning services ensure your stay is both comfortable and convenient.</p>',
                    'mk' => '<p>Влезете во рафинирана луксузност со нашиот Јуниор Апартман во хотелот Александар Палас. Ова великодушно пропорционирано сместување нуди совршен баланс на дневен и простор за спиење, правејќи го идеален за подолги престои или гости кои ценат дополнителен простор за релаксација.</p>
                    <p>Апартманот располага со удобен кинг-сајз кревет, одделна зона за седење со мека гарнитура, и елегантно бањо со премиум удобности. Прозорци од под до таван обезбедуваат изобилна природна светлина и прикажуваат прекрасни погледи кон хоризонтот на Скопје или нашите мирни градини.</p>
                    <p>Препуштете се на нашите сеопфатни удобности вклучувајќи бесплатен пристап до спа со турско бањо, шведска сауна, инфрацрвена сауна, парна соба и професионални третмани за масажа. Фитнес центарот, базенот и услугите за хемиско чистење обезбедуваат вашиот престој да биде и удобен и практичен.</p>',
                ],
                'short_description' => [
                    'en' => 'Spacious junior suite with separate living area, king bed, and full spa access for an elevated hotel experience.',
                    'mk' => 'Простран јуниор апартман со одделна дневна соба, кинг кревет и целосен пристап до спа за возвишено хотелско искуство.',
                ],
                'amenities' => ['wifi', 'lan', 'parking', 'smart-tv', 'mini-bar', 'telephone', 'spa', 'pool', 'laundry', 'fitness', 'turkish-bath', 'swedish-sauna', 'infrared-sauna', 'steam-room', 'massage', 'dry-cleaning'],
                'price_per_night' => 130.00,
                'max_guests' => 2,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'square_meters' => 40,
                'featured_image' => 'img/suites/junior/1.webp',
                'gallery_images' => [
                    'img/suites/junior/1.webp',
                    'img/suites/junior/2.webp',
                    'img/suites/junior/3.webp',
                    'img/suites/junior/4.webp',
                    'img/suites/junior/5.webp',
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4,
                'total_units' => 8,
                'bed_type' => 'King',
                'view_type' => 'City View',
                'meta_title' => [
                    'en' => 'Junior Suite | Alexandar Palace Hotel Skopje - Luxury Suite Accommodation',
                    'mk' => 'Јуниор Апартман | Хотел Александар Палас Скопје - Луксузно Сместување',
                ],
                'meta_description' => [
                    'en' => 'Book a Junior Suite at Alexandar Palace Hotel Skopje. Spacious suite with living area, king bed, spa, Turkish bath & sauna. From €130/night.',
                    'mk' => 'Резервирајте Јуниор Апартман во хотелот Александар Палас Скопје. Простран апартман со дневна соба, кинг кревет, спа и сауна. Од €130/ноќ.',
                ],
            ],
            [
                'slug' => 'executive-suite',
                'name' => [
                    'en' => 'Executive Suite',
                    'mk' => 'Извршен Апартман',
                ],
                'description' => [
                    'en' => '<p>Experience unparalleled luxury in our Executive Suite at Alexandar Palace Hotel. Designed for discerning travelers who demand the finest, this expansive suite offers a sophisticated living environment with premium amenities throughout.</p>
                    <p>The suite boasts a luxurious bedroom with a king-size bed, a separate spacious living room perfect for entertaining or relaxation, and an opulent bathroom featuring a soaking tub and walk-in rain shower. Premium furnishings and elegant décor create an atmosphere of refined comfort.</p>
                    <p>Executive Suite guests enjoy priority access to all hotel facilities including our award-winning spa with Turkish bath, multiple saunas, steam room, and exclusive massage treatments. Complimentary dry cleaning, fitness center access, and swimming pool privileges complete the executive experience.</p>',
                    'mk' => '<p>Доживејте неспоредлива луксузност во нашиот Извршен Апартман во хотелот Александар Палас. Дизајниран за проникливи патници кои бараат најдобро, овој експанзивен апартман нуди софистицирана животна средина со премиум удобности насекаде.</p>
                    <p>Апартманот се пофали со луксузна спална соба со кинг-сајз кревет, одделна простора дневна соба совршена за забава или релаксација, и раскошно бањо со када за потопување и туш со дожд. Премиум мебел и елегантен декор создаваат атмосфера на рафинирана удобност.</p>
                    <p>Гостите на Извршниот Апартман уживаат приоритетен пристап до сите хотелски објекти вклучувајќи нашиот наградуван спа со турско бањо, повеќе сауни, парна соба и ексклузивни третмани за масажа. Бесплатно хемиско чистење, пристап до фитнес центар и привилегии за базен го комплетираат извршното искуство.</p>',
                ],
                'short_description' => [
                    'en' => 'Luxurious executive suite with separate living room, premium amenities, and priority spa access for the discerning traveler.',
                    'mk' => 'Луксузен извршен апартман со одделна дневна соба, премиум удобности и приоритетен пристап до спа за проникливиот патник.',
                ],
                'amenities' => ['wifi', 'lan', 'parking', 'smart-tv', 'mini-bar', 'telephone', 'spa', 'pool', 'laundry', 'fitness', 'turkish-bath', 'swedish-sauna', 'infrared-sauna', 'steam-room', 'massage', 'dry-cleaning'],
                'price_per_night' => 160.00,
                'max_guests' => 3,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'square_meters' => 55,
                'featured_image' => 'img/suites/executive/1.webp',
                'gallery_images' => [
                    'img/suites/executive/1.webp',
                    'img/suites/executive/2.webp',
                    'img/suites/executive/3.webp',
                    'img/suites/executive/4.webp',
                    'img/suites/executive/5.webp',
                    'img/suites/executive/6.webp',
                    'img/suites/executive/7.webp',
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 5,
                'total_units' => 5,
                'bed_type' => 'King',
                'view_type' => 'City Panorama',
                'meta_title' => [
                    'en' => 'Executive Suite | Alexandar Palace Hotel Skopje - Premium Luxury Accommodation',
                    'mk' => 'Извршен Апартман | Хотел Александар Палас Скопје - Премиум Луксузно Сместување',
                ],
                'meta_description' => [
                    'en' => 'Book an Executive Suite at Alexandar Palace Hotel Skopje. Premium suite with living room, spa priority, Turkish bath & sauna. From €160/night.',
                    'mk' => 'Резервирајте Извршен Апартман во хотелот Александар Палас Скопје. Премиум апартман со дневна соба, приоритет за спа и сауна. Од €160/ноќ.',
                ],
            ],
            [
                'slug' => 'presidential-suite',
                'name' => [
                    'en' => 'Presidential Suite',
                    'mk' => 'Претседателски Апартман',
                ],
                'description' => [
                    'en' => '<p>Welcome to the pinnacle of luxury at Alexandar Palace Hotel – our magnificent Presidential Suite. This extraordinary accommodation represents the finest hospitality Macedonia has to offer, providing an unmatched experience for our most distinguished guests.</p>
                    <p>Spanning an impressive floor area, the Presidential Suite features a grand master bedroom with a premium king-size bed, an elegant living room for entertaining, a private dining area, and a luxurious marble bathroom with jacuzzi tub and separate rain shower. Every detail has been carefully curated to exceed expectations.</p>
                    <p>As our most prestigious accommodation, Presidential Suite guests receive VIP treatment including dedicated concierge service, complimentary premium spa treatments, exclusive access to all wellness facilities, priority reservations at our restaurants, and complimentary airport transfers. Experience the ultimate in Macedonian hospitality.</p>',
                    'mk' => '<p>Добредојдовте на врвот на луксузот во хотелот Александар Палас – нашиот величествен Претседателски Апартман. Ова извонредно сместување го претставува најдоброто гостопримство што Македонија може да го понуди, обезбедувајќи неспоредливо искуство за нашите најистакнати гости.</p>
                    <p>Со импресивна површина, Претседателскиот Апартман располага со голема главна спална соба со премиум кинг-сајз кревет, елегантна дневна соба за забава, приватна трпезарија, и луксузно мермерно бањо со џакузи када и одделен туш со дожд. Секој детал е внимателно курирано за да ги надмине очекувањата.</p>
                    <p>Како нашето најпрестижно сместување, гостите на Претседателскиот Апартман добиваат ВИП третман вклучувајќи посветена конциерж услуга, бесплатни премиум спа третмани, ексклузивен пристап до сите велнес објекти, приоритетни резервации во нашите ресторани, и бесплатни аеродромски трансфери. Доживејте го ултимативното македонско гостопримство.</p>',
                ],
                'short_description' => [
                    'en' => 'The ultimate luxury experience with VIP service, private dining, jacuzzi, and exclusive amenities for distinguished guests.',
                    'mk' => 'Ултимативно луксузно искуство со ВИП услуга, приватна трпезарија, џакузи и ексклузивни удобности за истакнати гости.',
                ],
                'amenities' => ['wifi', 'lan', 'parking', 'smart-tv', 'mini-bar', 'telephone', 'spa', 'pool', 'laundry', 'fitness', 'turkish-bath', 'swedish-sauna', 'infrared-sauna', 'steam-room', 'massage', 'dry-cleaning', 'jacuzzi', 'vip-service', 'airport-transfer', 'private-dining'],
                'price_per_night' => 300.00,
                'max_guests' => 4,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'square_meters' => 120,
                'featured_image' => 'img/suites/presidential/1.webp',
                'gallery_images' => [
                    'img/suites/presidential/1.webp',
                    'img/suites/presidential/2.webp',
                    'img/suites/presidential/3.webp',
                    'img/suites/presidential/4.webp',
                    'img/suites/presidential/5.webp',
                    'img/suites/presidential/6.webp',
                    'img/suites/presidential/7.webp',
                    'img/suites/presidential/8.webp',
                    'img/suites/presidential/9.webp',
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 6,
                'total_units' => 2,
                'bed_type' => 'King',
                'view_type' => 'Panoramic City View',
                'meta_title' => [
                    'en' => 'Presidential Suite | Alexandar Palace Hotel Skopje - Ultimate Luxury Experience',
                    'mk' => 'Претседателски Апартман | Хотел Александар Палас Скопје - Ултимативно Луксузно Искуство',
                ],
                'meta_description' => [
                    'en' => 'Book the Presidential Suite at Alexandar Palace Hotel Skopje. Ultimate luxury with VIP service, jacuzzi, private dining & airport transfer. From €300/night.',
                    'mk' => 'Резервирајте Претседателски Апартман во хотелот Александар Палас Скопје. Ултимативен луксуз со ВИП услуга, џакузи и аеродромски трансфер. Од €300/ноќ.',
                ],
            ],
        ];

        foreach ($rooms as $roomData) {
            Room::create($roomData);
        }

        $this->command->info('✓ Created 6 rooms and suites with SEO-optimized content and WebP images');
    }
}
