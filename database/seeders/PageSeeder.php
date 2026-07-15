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
                'content' => ['en' => '<p class="lead">Vivamus volutpat eros pulvinar velit laoreet, sit amet egestas erat dignissim.</p><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p><p><em>Maria...the Owner</em></p>', 'mk' => '<p class="lead">Вивамус волупат ерос пулвинар велит лаорет, сит амет егестас ерат дигнисим.</p><p>Сед ут перспициатис унде омнис исте натус еррор сит волуптатем акцусантиум долоремкуе лаудантиум, тотам рем апериам, еакуе ипса куае аб ило инвенторе веритатис ет куаси архитекто беатае витae дикта сунт експликабо.</p><p><em>Марија...сопственикот</em></p>'],
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
                    ['icon' => 'customicon-private-parking', 'title' => ['en' => 'Private Parking', 'mk' => 'Приватен паркинг'], 'description' => ['en' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.', 'mk' => 'Ут еним ад минима вениам, квис нострум ексерцитатионем улам корпорис сусципит лабориосам.']],
                    ['icon' => 'customicon-wifi', 'title' => ['en' => 'High Speed Wifi', 'mk' => 'Wifi голема брзина'], 'description' => ['en' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium.', 'mk' => 'Ат веро еос ет акцусамус ет иусто одио дигнисимос дуцимус кви бландитиис праесентиум.']],
                    ['icon' => 'customicon-cocktail', 'title' => ['en' => 'Bar & Restaurant', 'mk' => 'Бар и Ресторан'], 'description' => ['en' => 'Similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.', 'mk' => 'Симилике сунт ин цулпа кви официа десерунт молитија аними, ид ест лаборум ет долорум фуга.']],
                    ['icon' => 'customicon-swimming-pool', 'title' => ['en' => 'Swimming Pool', 'mk' => 'Базен'], 'description' => ['en' => 'Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.', 'mk' => 'Нам либеро темпоре, кум солута нобис ест елигенди оптио кумкуе нихил импедит кво минус.']],
                ],
            ],
            [
                'key' => 'local_amenities',
                'type' => 'local_amenities',
                'title' => ['en' => 'Local Amenities', 'mk' => 'Локални удобности'],
                'data' => [
                    ['title' => ['en' => 'Restaurants', 'mk' => 'Ресторани'], 'image' => 'img/local_amenities_1.jpg', 'description' => ['en' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.', 'mk' => 'Сед ут перспициатис унде омнис исте натус еррор сит волуптатем акцусантиум долоремкуе лаудантиум.']],
                    ['title' => ['en' => 'Art & Culture', 'mk' => 'Уметност и култура'], 'image' => 'img/local_amenities_3.jpg', 'description' => ['en' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.', 'mk' => 'Сед ут перспициатис унде омнис исте натус еррор сит волуптатем акцусантиум долоремкуе лаудантиум.']],
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
