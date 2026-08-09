<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Console\Command;

/**
 * One-off data fix: replaces the Lorem Ipsum placeholder text that was left in the
 * Home page's "about" content and "facilities" item descriptions (in both en/mk)
 * with real copy. Safe to run multiple times (idempotent) and safe to run on
 * production, since it only updates the two specific PageSection rows by key and
 * does not create or delete any pages/sections.
 */
class FixHomeLoremIpsumContent extends Command
{
    protected $signature = 'content:fix-home-placeholders';

    protected $description = 'Replace Lorem Ipsum placeholder text in the Home page "about" and "facilities" sections with real content';

    public function handle(): int
    {
        $home = Page::where('slug', 'home')->first();

        if (! $home) {
            $this->error('Home page not found. Nothing to fix.');
            return self::FAILURE;
        }

        $about = PageSection::where('page_id', $home->id)->where('key', 'about')->first();

        if ($about) {
            $about->content = [
                'en' => '<p class="lead">At Alexandar Palace, every stay is thoughtfully tailored to your needs, blending refined comfort with genuine Macedonian hospitality.</p><p>From our elegantly appointed rooms to our dedicated concierge service, we take pride in creating a warm, personal experience for every guest, whether you are here for business, leisure, or a special celebration.</p><p><em>Aleksandar Palace...</em></p>',
                'mk' => '<p class="lead">Во Александар Палас, секој престој е внимателно прилагоден на вашите потреби, спојувајќи софистициран комфор со вистинско македонско гостопримство.</p><p>Од нашите елегантно уредени соби до нашата посветена служба за гости, се гордееме што создаваме топло, лично искуство за секој гостин, без разлика дали сте тука деловно, за одмор или посебна прослава.</p><p><em>Александар Палас...</em></p>',
            ];
            $about->save();
            $this->info('Fixed "about" section content.');
        } else {
            $this->warn('"about" section not found, skipped.');
        }

        $facilities = PageSection::where('page_id', $home->id)->where('key', 'facilities')->first();

        if ($facilities) {
            $facilities->data = [
                ['icon' => 'customicon-private-parking', 'title' => ['en' => 'Private Parking', 'mk' => 'Приватен паркинг'], 'description' => ['en' => 'Complimentary private parking is available for all hotel guests, ensuring a convenient and secure stay.', 'mk' => 'Бесплатен приватен паркинг е достапен за сите гости на хотелот, за удобен и безбеден престој.']],
                ['icon' => 'customicon-wifi', 'title' => ['en' => 'High Speed Wifi', 'mk' => 'Wifi голема брзина'], 'description' => ['en' => 'Stay connected with complimentary high-speed WiFi available throughout the hotel and in all rooms.', 'mk' => 'Останете поврзани со бесплатен брз WiFi достапен низ целиот хотел и во сите соби.']],
                ['icon' => 'customicon-cocktail', 'title' => ['en' => 'Bar & Restaurant', 'mk' => 'Бар и Ресторан'], 'description' => ['en' => 'Enjoy exquisite dining at our restaurant and unwind at our bar with a selection of fine wines and cocktails.', 'mk' => 'Уживајте во извонредна храна во нашиот ресторан и опуштете се во нашиот бар со избор на фини вина и коктели.']],
                ['icon' => 'customicon-swimming-pool', 'title' => ['en' => 'Swimming Pool', 'mk' => 'Базен'], 'description' => ['en' => 'Relax and refresh in our indoor swimming pool, perfect for a rejuvenating swim any time of year.', 'mk' => 'Релаксирајте и освежете се во нашиот затворен базен, совршен за пливање во секое време од годината.']],
            ];
            $facilities->save();
            $this->info('Fixed "facilities" section descriptions.');
        } else {
            $this->warn('"facilities" section not found, skipped.');
        }

        $this->info('Done.');
        return self::SUCCESS;
    }
}
