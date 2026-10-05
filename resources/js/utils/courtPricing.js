// Mirrors CourtSetting::calculatePrice() on the server, which stays the source of truth.

export const toMinutes = (time) => {
    const [hours, minutes] = time.split(':').map(Number);
    return hours * 60 + minutes;
};

export const toTime = (minutes) =>
    `${String(Math.floor(minutes / 60)).padStart(2, '0')}:${String(minutes % 60).padStart(2, '0')}`;

export const getPriceOption = (court, key = null) => {
    const options = court?.price_options || [];
    if (!options.length) {
        return court?.price_per_slot == null
            ? null
            : { key: 'standard', units: 1, bands: [{ until: null, price: Number(court.price_per_slot) }] };
    }
    return options.find((option) => option.key === key) || (key ? null : options[0]);
};

/**
 * Rates are per hour and change at each band's "until" time, so a booking that
 * crosses a boundary is charged per band (14:00-16:00 = 1h at 400 + 1h at 500).
 */
export const calculatePrice = (option, start, end) => {
    if (!option || !start || !end) return null;

    let from = toMinutes(start);
    const to = toMinutes(end);
    if (to <= from) return null;

    const lines = [];
    let total = 0;

    for (const band of option.bands) {
        const bandEnd = band.until ? toMinutes(band.until) : 24 * 60;
        const segmentEnd = Math.min(to, bandEnd);

        if (segmentEnd > from) {
            const amount = Math.round(((segmentEnd - from) / 60) * band.price * 100) / 100;
            lines.push({ from: toTime(from), to: toTime(segmentEnd), rate: Number(band.price), amount });
            total += amount;
            from = segmentEnd;
        }
        if (from >= to) break;
    }

    return { total: Math.round(total * 100) / 100, lines };
};
