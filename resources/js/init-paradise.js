import { nextTick } from 'vue';

let initTimeout = null;
let isInitializing = false;

function initHeroAnimation() {
    // Trigger hero content animation (show the text)
    const hero = document.querySelector('.animate_hero');
    if (hero) {
        // Small delay to ensure smooth transition
        setTimeout(() => {
            hero.classList.add('is-transitioned');
        }, 100);
    }
}

function initDataBackgrounds() {
    document.querySelectorAll('.background-image[data-background]').forEach((el) => {
        el.style.backgroundImage = el.getAttribute('data-background');
    });
}

function initOpacityMasks() {
    document.querySelectorAll('.opacity-mask[data-opacity-mask]').forEach((el) => {
        el.style.backgroundColor = el.getAttribute('data-opacity-mask');
    });
}

function initJarallax() {
    if (typeof window.jarallax === 'undefined') return;

    const els = document.querySelectorAll('[data-jarallax], [data-jarallax-video]');
    if (els.length > 0) {
        window.jarallax(els, { speed: 0.2 });
    }
}

function initPinnedImages() {
    if (typeof window.gsap === 'undefined' || typeof window.ScrollTrigger === 'undefined') {
        return;
    }

    window.gsap.registerPlugin(window.ScrollTrigger);

    // Remove stale triggers so they don't duplicate on Inertia navigation.
    window.ScrollTrigger.getAll().forEach((trigger) => trigger.kill());

    document.querySelectorAll('.pinned-image').forEach((pinnedImage) => {
        const container = pinnedImage.querySelector('.pinned-image__container');
        if (!container) return;

        const overlay = container.querySelector('.pinned-image__container-overlay');
        const content = pinnedImage.querySelector('.pinned_over_content');

        const tl = window.gsap.timeline({ paused: true });
        tl.to(container, { scale: 1.05 }, 0);
        if (content) tl.from(content, { autoAlpha: 0 }, 0);
        if (overlay) tl.from(overlay, { autoAlpha: 0 }, 0);

        window.ScrollTrigger.create({
            animation: tl,
            trigger: pinnedImage,
            start: 'top center',
            markers: false,
            pin: false,
            scrub: false,
        });
    });
}

function initVideoOnScroll() {
    const videoSection = document.getElementById('section_video');
    if (!videoSection) return;

    // Get only the visible video (desktop or mobile based on display)
    const getVisibleVideo = () => {
        const videos = videoSection.querySelectorAll('video');
        for (const video of videos) {
            if (window.getComputedStyle(video).display !== 'none') {
                return video;
            }
        }
        return null;
    };

    function isScrolledIntoView(elem) {
        const rect = elem.getBoundingClientRect();
        return rect.bottom > 0 && rect.top < window.innerHeight;
    }

    // Initialize all videos
    videoSection.querySelectorAll('video').forEach((video) => {
        video.setAttribute('webkit-playsinline', '');
        video.setAttribute('playsinline', '');
        video.setAttribute('muted', 'muted');
        video.muted = true;
        video.load();
    });

    if (window._paradiseVideoScroll) {
        window.removeEventListener('scroll', window._paradiseVideoScroll);
    }

    const scrollHandler = () => {
        const video = getVisibleVideo();
        if (!video) return;
        
        if (isScrolledIntoView(video)) {
            video.play().catch(() => {});
        } else {
            video.pause();
        }
    };

    window._paradiseVideoScroll = scrollHandler;
    window.addEventListener('scroll', scrollHandler, { passive: true });
    
    // Initial check after a short delay
    setTimeout(scrollHandler, 100);
}

function initQtyButtons() {
    document.querySelectorAll('.qtyplus').forEach((btn) => {
        btn.onclick = function (e) {
            e.preventDefault();
            const fieldName = this.getAttribute('name');
            const input = document.querySelector('input[type="text"][name="' + fieldName + '"]');
            if (input) {
                let val = parseInt(input.value) || 0;
                input.value = val + 1;
            }
        };
    });

    document.querySelectorAll('.qtyminus').forEach((btn) => {
        btn.onclick = function (e) {
            e.preventDefault();
            const fieldName = this.getAttribute('name');
            const input = document.querySelector('input[type="text"][name="' + fieldName + '"]');
            if (input) {
                let val = parseInt(input.value) || 0;
                if (val > 0) {
                    input.value = val - 1;
                }
            }
        };
    });
}

function initDatepicker() {
    // Wait for easepick to be available
    if (typeof window.easepick === 'undefined') {
        // Retry after a short delay if easepick isn't loaded yet
        setTimeout(initDatepicker, 100);
        return;
    }

    // Hero search datepicker
    const datesInput = document.getElementById('dates');
    if (datesInput) {
        // Destroy existing picker if any
        if (datesInput._easepick) {
            datesInput._easepick.destroy();
            datesInput._easepick = null;
        }
        
        const picker = new window.easepick.create({
            element: datesInput,
            css: ['/assets/paradise/css/daterangepicker_v2.css'],
            lang: 'en-EN',
            format: "MM/DD/YYYY",
            calendars: 2,
            grid: 2,
            zIndex: 99999,
            plugins: ['LockPlugin', 'RangePlugin'],
            RangePlugin: {
                tooltipNumber(num) { return num - 1; },
                locale: { one: 'night', other: 'nights' },
            },
            LockPlugin: {
                minDate: new Date(),
                minDays: 1,
                inseparable: false,
            },
        });
        datesInput._easepick = picker;
    }

    // Booking section inline calendar
    const bookingDates = document.getElementById('booking_dates');
    if (bookingDates) {
        // Destroy existing picker if any
        if (bookingDates._easepick) {
            bookingDates._easepick.destroy();
            bookingDates._easepick = null;
        }
        
        const picker = new window.easepick.create({
            element: bookingDates,
            inline: true,
            css: ['/assets/paradise/css/daterangepicker_v2.css'],
            lang: 'en-EN',
            format: "DD/MM/YYYY",
            calendars: 2,
            grid: 2,
            zIndex: 10,
            plugins: ['LockPlugin', 'RangePlugin'],
            RangePlugin: {
                tooltipNumber(num) { return num - 1; },
                locale: { one: 'night', other: 'nights' },
            },
            LockPlugin: {
                minDate: new Date(),
                minDays: 1,
                inseparable: false,
            },
        });
        
        bookingDates._easepick = picker;
    }
}

function initStickySidebar() {
    if (typeof $ === 'undefined' || typeof $.fn.theiaStickySidebar === 'undefined') return;
    
    $('.fixed_title').theiaStickySidebar({
        minWidth: 992,
        additionalMarginTop: 80,
    });
}

function initOwlCarousel() {
    if (typeof $ === 'undefined' || typeof $.fn.owlCarousel === 'undefined') return;
    
    // Destroy existing instances first
    $('.carousel_testimonials').trigger('destroy.owl.carousel');
    $('.carousel_item_centered').trigger('destroy.owl.carousel');
    
    // Testimonials carousel
    $('.carousel_testimonials').owlCarousel({
        items: 1,
        loop: true,
        autoplay: false,
        animateIn: 'flipInX',
        margin: 40,
        stagePadding: 30,
        smartSpeed: 300,
        autoHeight: true,
        dots: true,
        responsiveClass: true,
        responsive: {
            600: { items: 1 },
            1000: { items: 1, nav: false }
        }
    });
    
    // Room gallery carousel (centered items with ken burns effect)
    $('.carousel_item_centered').owlCarousel({
        center: true,
        items: 2,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            1000: { items: 3 }
        }
    });
}

function initHeadroom() {
    if (typeof window.Headroom === 'undefined') return;
    
    const header = document.querySelector('header.reveal_header');
    if (!header || header._headroom) return;
    
    const headroom = new window.Headroom(header, {
        offset: 50,
        tolerance: 5,
        classes: {
            initial: 'animated',
            pinned: 'slideDown',
            unpinned: 'slideUp'
        }
    });
    headroom.init();
    header._headroom = headroom;
}

function initScrollCue() {
    if (typeof window.scrollCue === 'undefined') return;
    
    // Only init once, then update on navigation
    if (!window._scrollCueInitialized) {
        window.scrollCue.init({ percentage: 0.85 });
        window._scrollCueInitialized = true;
    } else {
        window.scrollCue.update();
    }
}

function initNiceSelect() {
    if (typeof $ === 'undefined' || typeof $.fn.niceSelect === 'undefined') return;
    $('.custom_select select').niceSelect();
}

function initProgressWrap() {
    const progressPath = document.querySelector('.progress-wrap path');
    if (!progressPath || window._progressWrapInitialized) return;
    
    const pathLength = progressPath.getTotalLength();
    progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
    progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
    progressPath.style.strokeDashoffset = pathLength;
    progressPath.getBoundingClientRect();
    progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
    
    const updateProgress = () => {
        const scroll = window.scrollY;
        const height = document.documentElement.scrollHeight - window.innerHeight;
        const progress = pathLength - (scroll * pathLength / height);
        progressPath.style.strokeDashoffset = progress;
    };
    
    updateProgress();
    window.addEventListener('scroll', updateProgress);
    
    const offset = 50;
    window.addEventListener('scroll', () => {
        if (window.scrollY > offset) {
            document.querySelector('.progress-wrap')?.classList.add('active-progress');
        } else {
            document.querySelector('.progress-wrap')?.classList.remove('active-progress');
        }
    });
    
    document.querySelector('.progress-wrap')?.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    window._progressWrapInitialized = true;
}

export function initParadise() {
    // Debounce and prevent concurrent runs
    if (initTimeout) {
        clearTimeout(initTimeout);
    }
    
    initTimeout = setTimeout(() => {
        if (isInitializing) return;
        isInitializing = true;
        
        nextTick(() => {
            initHeroAnimation();
            initDataBackgrounds();
            initOpacityMasks();
            initJarallax();
            initPinnedImages();
            initVideoOnScroll();
            initQtyButtons();
            initDatepicker();
            initStickySidebar();
            initOwlCarousel();
            initHeadroom();
            initScrollCue();
            initNiceSelect();
            initProgressWrap();
            
            isInitializing = false;
        });
    }, 150); // Increased delay to ensure DOM is ready after Inertia navigation
}
