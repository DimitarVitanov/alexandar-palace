<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Starters
        $starters = MenuCategory::create([
            'name' => ['en' => 'Starters', 'mk' => 'Предјадења'],
            'slug' => 'starters',
            'banner_title' => ['en' => 'Mix Starters Menu $18 only', 'mk' => 'Микс Предјадења Мени само $18'],
            'banner_subtitle' => ['en' => 'Starters Special Offer', 'mk' => 'Специјална Понуда за Предјадења'],
            'banner_description' => ['en' => 'Hamburgher, Chips, Mix Sausages, Beer, Muffin', 'mk' => 'Хамбургер, Чипс, Микс Колбаси, Пиво, Мафин'],
            'banner_image' => 'img/restaurant/banner_bg_2.jpg',
            'sort_order' => 1,
        ]);

        $starterItems = [
            ['name' => ['en' => 'Soft shell crab', 'mk' => 'Мек рак'], 'description' => ['en' => 'Chicken, Potato, Salad', 'mk' => 'Пилешко, Компир, Салата'], 'price' => 14, 'image' => 'img/restaurant/1.jpg', 'large_image' => 'img/restaurant/large/1.jpg'],
            ['name' => ['en' => 'Marinated Grilled Shrimp', 'mk' => 'Маринирани Скари'], 'description' => ['en' => 'Fresh Shrimp, Olive Oil, Tomato Sauce', 'mk' => 'Свежи Скари, Маслиново Масло, Доматен Сос'], 'price' => 11, 'image' => 'img/restaurant/2.jpg', 'large_image' => 'img/restaurant/large/2.jpg'],
            ['name' => ['en' => 'Avocado & Mango Salsa', 'mk' => 'Авокадо и Манго Салса'], 'description' => ['en' => 'Avocado, Mango, Tomatoes', 'mk' => 'Авокадо, Манго, Домати'], 'price' => 16, 'image' => 'img/restaurant/3.jpg', 'large_image' => 'img/restaurant/large/3.jpg'],
            ['name' => ['en' => 'Baked Potato Skins', 'mk' => 'Печени Компири'], 'description' => ['en' => 'Potatoes, Oil, Garlic', 'mk' => 'Компири, Масло, Лук'], 'price' => 10, 'image' => 'img/restaurant/4.jpg', 'large_image' => 'img/restaurant/large/4.jpg'],
            ['name' => ['en' => 'Braised Pork Chops', 'mk' => 'Динстани Свински Котлети'], 'description' => ['en' => 'Pork chops, Olive oil, Garlic', 'mk' => 'Свински котлети, Маслиново масло, Лук'], 'price' => 12, 'image' => 'img/restaurant/5.jpg', 'large_image' => 'img/restaurant/large/5.jpg'],
            ['name' => ['en' => 'Cream of Asparagus', 'mk' => 'Крем од Аспарагус'], 'description' => ['en' => 'Asparagus, Potato, Celery, Onion', 'mk' => 'Аспарагус, Компир, Целер, Кромид'], 'price' => 14, 'image' => 'img/restaurant/6.jpg', 'large_image' => 'img/restaurant/large/6.jpg'],
        ];

        foreach ($starterItems as $i => $item) {
            MenuItem::create(array_merge($item, ['menu_category_id' => $starters->id, 'sort_order' => $i + 1]));
        }

        // Main Dishes
        $mains = MenuCategory::create([
            'name' => ['en' => 'Main Dishes', 'mk' => 'Главни Јадења'],
            'slug' => 'main-dishes',
            'banner_title' => ['en' => 'Burger Menu $14 only', 'mk' => 'Бургер Мени само $14'],
            'banner_subtitle' => ['en' => 'Special Offer', 'mk' => 'Специјална Понуда'],
            'banner_description' => ['en' => 'Hamburgher, Chips, Mix Sausages, Beer, Muffin', 'mk' => 'Хамбургер, Чипс, Микс Колбаси, Пиво, Мафин'],
            'banner_image' => 'img/restaurant/banner_bg.jpg',
            'sort_order' => 2,
        ]);

        $mainItems = [
            ['name' => ['en' => 'Prime Rib', 'mk' => 'Прајм Ребро'], 'description' => ['en' => 'Rib, Rosemary, Black pepper', 'mk' => 'Ребро, Рузмарин, Црн пипер'], 'price' => 18, 'image' => 'img/restaurant/7.jpg', 'large_image' => 'img/restaurant/large/7.jpg'],
            ['name' => ['en' => 'Coconut Fried Chicken', 'mk' => 'Кокосово Пржено Пиле'], 'description' => ['en' => '8 chicken pieces, Coconut milk', 'mk' => '8 парчиња пиле, Кокосово млеко'], 'price' => 14, 'image' => 'img/restaurant/8.jpg', 'large_image' => 'img/restaurant/large/8.jpg'],
            ['name' => ['en' => 'Sriracha Beef Skewers', 'mk' => 'Срирача Говедски Ражњићи'], 'description' => ['en' => 'Beef, Garlic, Sesame oil', 'mk' => 'Говедско, Лук, Сусамово масло'], 'price' => 12, 'image' => 'img/restaurant/9.jpg', 'large_image' => 'img/restaurant/large/9.jpg'],
            ['name' => ['en' => 'Chicken with Garlic', 'mk' => 'Пиле со Лук'], 'description' => ['en' => 'Chicken, Cherry tomatoes, Olive oil', 'mk' => 'Пиле, Цреша домати, Маслиново масло'], 'price' => 10, 'image' => 'img/restaurant/10.jpg', 'large_image' => 'img/restaurant/large/10.jpg'],
            ['name' => ['en' => 'Grilled Salmon', 'mk' => 'Грилован Лосос'], 'description' => ['en' => 'Salmon, Lemon, Herbs', 'mk' => 'Лосос, Лимон, Зачини'], 'price' => 14, 'image' => 'img/restaurant/11.jpg', 'large_image' => 'img/restaurant/large/11.jpg'],
            ['name' => ['en' => 'Terrific Turkey Chili', 'mk' => 'Одличен Мисиркин Чили'], 'description' => ['en' => 'Turkey, Oregano, Tomato paste', 'mk' => 'Мисирка, Оригано, Доматен пире'], 'price' => 18, 'image' => 'img/restaurant/1.jpg', 'large_image' => 'img/restaurant/large/1.jpg'],
        ];

        foreach ($mainItems as $i => $item) {
            MenuItem::create(array_merge($item, ['menu_category_id' => $mains->id, 'sort_order' => $i + 1]));
        }

        // Desserts
        $desserts = MenuCategory::create([
            'name' => ['en' => 'Desserts', 'mk' => 'Десерти'],
            'slug' => 'desserts',
            'banner_title' => ['en' => 'Mix Cakes $12 only', 'mk' => 'Микс Торти само $12'],
            'banner_subtitle' => ['en' => 'Desserts Special Offer', 'mk' => 'Специјална Понуда за Десерти'],
            'banner_description' => ['en' => 'Cheese cake, Muffin, Sweet bread', 'mk' => 'Чизкејк, Мафин, Слатко Леб'],
            'banner_image' => 'img/restaurant/banner_bg_3.jpg',
            'sort_order' => 3,
        ]);

        $dessertItems = [
            ['name' => ['en' => 'Summer Berry', 'mk' => 'Летни Бобинки'], 'description' => ['en' => 'Raspberries, Blackberries', 'mk' => 'Малини, Капини'], 'price' => 8, 'image' => 'img/restaurant/3.jpg', 'large_image' => 'img/restaurant/large/3.jpg'],
            ['name' => ['en' => 'Coconut Tart', 'mk' => 'Кокосова Тарта'], 'description' => ['en' => 'Blueberries, Graham cracker crumbs', 'mk' => 'Боровинки, Грахам крекер трошки'], 'price' => 10, 'image' => 'img/restaurant/4.jpg', 'large_image' => 'img/restaurant/large/4.jpg'],
            ['name' => ['en' => 'Pumpkin Cookies', 'mk' => 'Тиквени Колачиња'], 'description' => ['en' => 'Pumpkin, Sugar, Butter', 'mk' => 'Тиква, Шеќер, Путер'], 'price' => 11, 'image' => 'img/restaurant/5.jpg', 'large_image' => 'img/restaurant/large/5.jpg'],
            ['name' => ['en' => 'Cookies Cream Cheese', 'mk' => 'Колачиња со Крем Сирење'], 'description' => ['en' => 'Sugar, Butter, Eggs', 'mk' => 'Шеќер, Путер, Јајца'], 'price' => 14, 'image' => 'img/restaurant/6.jpg', 'large_image' => 'img/restaurant/large/6.jpg'],
            ['name' => ['en' => 'Chocolate Cupcakes', 'mk' => 'Чоколадни Капкејкс'], 'description' => ['en' => 'Chocolate, Eggs, Vanilla', 'mk' => 'Чоколадо, Јајца, Ванила'], 'price' => 14, 'image' => 'img/restaurant/8.jpg', 'large_image' => 'img/restaurant/large/8.jpg'],
            ['name' => ['en' => 'Tiramisu', 'mk' => 'Тирамису'], 'description' => ['en' => 'Mascarpone, Coffee, Cocoa', 'mk' => 'Маскарпоне, Кафе, Какао'], 'price' => 14, 'image' => 'img/restaurant/9.jpg', 'large_image' => 'img/restaurant/large/9.jpg'],
        ];

        foreach ($dessertItems as $i => $item) {
            MenuItem::create(array_merge($item, ['menu_category_id' => $desserts->id, 'sort_order' => $i + 1]));
        }
    }
}
