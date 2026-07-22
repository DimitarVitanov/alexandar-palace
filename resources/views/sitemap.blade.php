<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
    
    {{-- Homepage --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en') }}" />
        <xhtml:link rel="alternate" hreflang="mk" href="{{ url('/mk') }}" />
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('/') }}" />
        <lastmod>{{ now()->toW3cString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Static Pages --}}
    <url>
        <loc>{{ url('/about') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/rooms') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <url>
        <loc>{{ url('/restaurant') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/congress') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ url('/celebrations') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ url('/activities') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ url('/gallery') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>

    <url>
        <loc>{{ url('/news') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ url('/contacts') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    <url>
        <loc>{{ url('/booking') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    {{-- Dynamic Pages --}}
    @foreach($pages as $page)
    @if(!in_array($page->slug, ['home', 'about', 'rooms', 'restaurant', 'congress', 'celebrations', 'activities', 'gallery', 'news', 'contacts']))
    <url>
        <loc>{{ url('/' . $page->slug) }}</loc>
        <lastmod>{{ $page->updated_at->toW3cString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endif
    @endforeach

    {{-- Rooms --}}
    @foreach($rooms as $room)
    <url>
        <loc>{{ url('/rooms/' . $room->slug) }}</loc>
        <lastmod>{{ $room->updated_at->toW3cString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- News Articles --}}
    @foreach($news as $article)
    <url>
        <loc>{{ url('/news/' . $article->slug) }}</loc>
        <lastmod>{{ $article->updated_at->toW3cString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach

</urlset>
