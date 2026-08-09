<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $home = Page::create([
            'slug' => 'home',
            'title' => ['en' => 'Home', 'mk' => 'Дома'],
            'meta_title' => ['en' => 'Alexandar Palace - Luxury Hotel', 'mk' => 'Александар Палас - Луксузен Хотел'],
            'meta_description' => ['en' => 'A unique luxury hotel experience.', 'mk' => 'Уникатно луксузно хотелско искуство.'],
            'template' => 'home',
        ]);

        $home->sections()->createMany([
            [
                'key' => 'hero',
                'type' => 'hero',
                'title' => ['en' => 'A unique Experience<br>where to stay', 'mk' => 'Уникатно искуство<br>за одмор'],
                'subtitle' => ['en' => 'Luxury Hotel Experience', 'mk' => 'Луксузно Хотелско Искуство'],
                'data' => ['video' => 'video/sunset'],
            ],
            [
                'key' => 'about',
                'type' => 'about',
                'title' => ['en' => 'Tailored services and the experience of unique holidays', 'mk' => 'Прилагодени услуги и искуство на единствен одмор'],
                'subtitle' => ['en' => 'About us', 'mk' => 'За нас'],
                'content' => ['en' => '<p class="lead">At Alexandar Palace, every stay is thoughtfully tailored to your needs, blending refined comfort with genuine Macedonian hospitality.</p><p>From our elegantly appointed rooms to our dedicated concierge service, we take pride in creating a warm, personal experience for every guest, whether you are here for business, leisure, or a special celebration.</p><p><em>Aleksandar Palace...</em></p>', 'mk' => '<p class="lead">Во Александар Палас, секој престој е внимателно прилагоден на вашите потреби, спојувајќи софистициран комфор со вистинско македонско гостопримство.</p><p>Од нашите елегантно уредени соби до нашата посветена служба за гости, се гордееме што создаваме топло, лично искуство за секој гостин, без разлика дали сте тука деловно, за одмор или посебна прослава.</p><p><em>Александар Палас...</em></p>'],
                'image' => 'img/home_2.jpg',
                'data' => ['image_secondary' => 'img/home_1.jpg'],
            ],
            [
                'key' => 'video_parallax',
                'type' => 'video_parallax',
                'title' => ['en' => 'Enjoy in a very<br> Immersive Relax', 'mk' => 'Уживајте во многу<br>имерсивна релаксација'],
                'subtitle' => ['en' => 'Luxury Hotel Experience', 'mk' => 'Луксузно Хотелско Искуство'],
                'data' => ['video' => 'video/swimming_pool_2'],
            ],
            [
                'key' => 'facilities',
                'type' => 'facilities',
                'title' => ['en' => 'Main Facilities', 'mk' => 'Главни Содржини'],
                'subtitle' => ['en' => 'Alexandar Palace', 'mk' => 'Александар Палас'],
                'data' => [
                    ['icon' => 'customicon-private-parking', 'title' => ['en' => 'Private Parking', 'mk' => 'Приватен паркинг'], 'description' => ['en' => 'Complimentary private parking is available for all hotel guests, ensuring a convenient and secure stay.', 'mk' => 'Бесплатен приватен паркинг е достапен за сите гости на хотелот, за удобен и безбеден престој.']],
                    ['icon' => 'customicon-wifi', 'title' => ['en' => 'High Speed Wifi', 'mk' => 'Wifi голема брзина'], 'description' => ['en' => 'Stay connected with complimentary high-speed WiFi available throughout the hotel and in all rooms.', 'mk' => 'Останете поврзани со бесплатен брз WiFi достапен низ целиот хотел и во сите соби.']],
                    ['icon' => 'customicon-cocktail', 'title' => ['en' => 'Bar & Restaurant', 'mk' => 'Бар и Ресторан'], 'description' => ['en' => 'Enjoy exquisite dining at our restaurant and unwind at our bar with a selection of fine wines and cocktails.', 'mk' => 'Уживајте во извонредна храна во нашиот ресторан и опуштете се во нашиот бар со избор на фини вина и коктели.']],
                    ['icon' => 'customicon-swimming-pool', 'title' => ['en' => 'Swimming Pool', 'mk' => 'Базен'], 'description' => ['en' => 'Relax and refresh in our indoor swimming pool, perfect for a rejuvenating swim any time of year.', 'mk' => 'Релаксирајте и освежете се во нашиот затворен базен, совршен за пливање во секое време од годината.']],
                ],
            ],
            [
                'key' => 'local_amenities',
                'type' => 'local_amenities',
                'title' => ['en' => 'Local Amenities', 'mk' => 'Локални удобности'],
                'data' => [
                    ['title' => ['en' => 'Restaurant', 'mk' => 'Ресторан'], 'image' => 'img/restaurant/restaurant_hero.webp', 'link' => '/restaurant', 'description' => ['en' => 'Experience culinary excellence at our award-winning restaurant. Our talented chefs craft each dish with passion, using locally sourced ingredients and traditional Macedonian recipes.', 'mk' => 'Доживејте кулинарска извонредност во нашиот награден ресторан. Нашите талентирани готвачи го подготвуваат секое јадење со страст, користејќи локално набавени состојки и традиционални македонски рецепти.']],
                    ['title' => ['en' => 'Art & Culture', 'mk' => 'Уметност и култура'], 'image' => 'img/local_amenities_3.jpg', 'link' => '/about', 'description' => ['en' => 'Discover the rich cultural heritage of Skopje. From ancient fortresses to modern art galleries, experience the vibrant arts scene and historical landmarks just minutes from our hotel.', 'mk' => 'Откријте го богатото културно наследство на Скопје. Од древни тврдини до модерни уметнички галерии, доживејте ја живописната уметничка сцена и историските знаменитости на само неколку минути од нашиот хотел.']],
                ],
            ],
            [
                'key' => 'booking',
                'type' => 'booking',
                'title' => ['en' => 'Check Availability', 'mk' => 'Проверете достапност'],
                'subtitle' => ['en' => 'Alexandar Palace', 'mk' => 'Александар Палас'],
                'content' => ['en' => '<p>Mea nibh meis philosophia eu. Duis legimus efficiantur ea sea.</p>', 'mk' => '<p>Меа нибх меис философија еу. Дуис легимус еффициантура еа сеа.</p>'],
            ],
        ]);

        Page::create([
            'slug' => 'about',
            'title' => ['en' => 'About Us', 'mk' => 'За Нас'],
            'meta_title' => ['en' => 'About Us - Alexandar Palace', 'mk' => 'За Нас - Александар Палас'],
            'meta_description' => ['en' => 'Learn more about Alexandar Palace.', 'mk' => 'Дознајте повеќе за Александар Палас.'],
        ]);

        Page::create([
            'slug' => 'restaurant',
            'title' => ['en' => 'Restaurant', 'mk' => 'Ресторан'],
            'meta_title' => ['en' => 'Restaurant - Alexandar Palace', 'mk' => 'Ресторан - Александар Палас'],
            'meta_description' => ['en' => 'Fine dining at Alexandar Palace.', 'mk' => 'Врвна гастрономија во Александар Палас.'],
        ]);

        Page::create([
            'slug' => 'contacts',
            'title' => ['en' => 'Contacts', 'mk' => 'Контакт'],
            'meta_title' => ['en' => 'Contact Us - Alexandar Palace', 'mk' => 'Контакт - Александар Палас'],
            'meta_description' => ['en' => 'Get in touch with Alexandar Palace.', 'mk' => 'Стапете во контакт со Александар Палас.'],
        ]);
    }
}
