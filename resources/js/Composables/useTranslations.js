
import { usePage } from '@inertiajs/vue3';

export function useTranslations() {
    const page = usePage();

    /**
     * Translates a given object based on current locale.
     * @param {Object|string} obj - The object to translate (e.g. {pl: "...", en: "..."})
     * @returns {string} - The translated string
     */
    const translate = (obj) => {
        if (!obj) return '';
        if (typeof obj === 'string') return obj;

        const locale = page.props.locale || 'pl'; // Default to PL

        // Try the exact locale
        if (obj[locale]) return obj[locale];

        // Fallback to PL
        if (obj['pl']) return obj['pl'];

        // Fallback to EN
        if (obj['en']) return obj['en'];

        // Fallback to first available key
        const keys = Object.keys(obj);
        if (keys.length > 0) return obj[keys[0]];

        return String(obj);
    };

    return { translate, t: translate };
}
