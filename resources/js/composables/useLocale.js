import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

/**
 * Shared helper for components that need locale-aware fallback text
 * (used when content isn't driven by vue-i18n `t()` keys or CMS-managed
 * `PageSection` content). Supports all site locales: en, mk, sr, tr, sq.
 *
 * Usage:
 *   const { locale, ml } = useLocale();
 *   ...
 *   {{ ml({ en: 'Our History', mk: 'Нашата Историја', sr: 'Наша Историја', tr: 'Tarihimiz', sq: 'Historia Jonë' }) }}
 */
export function useLocale() {
    const page = usePage();
    const locale = computed(() => page.props.locale || 'en');

    const ml = (map) => {
        if (!map) return '';
        return map[locale.value] ?? map.en ?? Object.values(map)[0] ?? '';
    };

    return { locale, ml };
}
