<script setup>
import { computed } from 'vue';

const props = defineProps({
    days: { type: Array, default: () => [] },
    startMonth: { type: String, required: true },
    months: { type: Number, default: 3 },
    selectedFrom: { type: String, default: '' },
    selectedTo: { type: String, default: '' },
    locale: { type: String, default: 'en' },
});

const emit = defineEmits(['select-date', 'shift-months']);

const dayIndex = computed(() => {
    const map = {};
    props.days.forEach((day) => { map[day.date] = day; });
    return map;
});

const ml = (map) => map[props.locale] ?? map.en;

const dateLocales = { en: 'en-GB', mk: 'mk-MK', sr: 'sr-RS', tr: 'tr-TR', sq: 'sq-AL' };

const weekdayLabels = computed(() => ml({
    en: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    mk: ['Пон', 'Вто', 'Сре', 'Чет', 'Пет', 'Саб', 'Нед'],
    sr: ['Pon', 'Uto', 'Sre', 'Čet', 'Pet', 'Sub', 'Ned'],
    tr: ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'],
    sq: ['Hën', 'Mar', 'Mër', 'Enj', 'Pre', 'Sht', 'Die'],
}));

const toKey = (date) => {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, '0');
    const d = String(date.getDate()).padStart(2, '0');
    return `${y}-${m}-${d}`;
};

const monthGrids = computed(() => {
    const [year, month] = props.startMonth.split('-').map(Number);
    const grids = [];

    for (let offset = 0; offset < props.months; offset += 1) {
        const first = new Date(year, month - 1 + offset, 1);
        const label = first.toLocaleDateString(dateLocales[props.locale] ?? 'en-GB', {
            month: 'long',
            year: 'numeric',
        });

        // Monday based leading blanks
        const leading = (first.getDay() + 6) % 7;
        const daysInMonth = new Date(first.getFullYear(), first.getMonth() + 1, 0).getDate();
        const cells = [];

        for (let i = 0; i < leading; i += 1) {
            cells.push(null);
        }

        for (let d = 1; d <= daysInMonth; d += 1) {
            const date = new Date(first.getFullYear(), first.getMonth(), d);
            const key = toKey(date);
            cells.push({
                key,
                day: d,
                info: dayIndex.value[key] || null,
            });
        }

        grids.push({ label, cells, key: `${first.getFullYear()}-${first.getMonth() + 1}` });
    }

    return grids;
});

const todayKey = toKey(new Date());

const statusClass = (cell) => {
    if (!cell?.info) return 'is-unknown';
    return `is-${cell.info.status}`;
};

const isSelected = (key) => key === props.selectedFrom || key === props.selectedTo;

const inRange = (key) => props.selectedFrom && props.selectedTo
    && key > props.selectedFrom && key < props.selectedTo;

const titleFor = (cell) => {
    if (!cell?.info) return '';
    const info = cell.info;
    return ml({
        en: `Available: ${info.available} of ${info.capacity}`,
        mk: `Достапни: ${info.available} / ${info.capacity}`,
        sr: `Dostupno: ${info.available} od ${info.capacity}`,
        tr: `Müsait: ${info.available} / ${info.capacity}`,
        sq: `Në dispozicion: ${info.available} nga ${info.capacity}`,
    });
};
</script>

<template>
    <div class="avail-calendars">
        <div class="avail-header">
            <button type="button" class="avail-nav" @click="emit('shift-months', -1)">
                <i class="bi bi-chevron-left"></i>
            </button>
            <div class="avail-legend">
                <span><i class="dot is-open"></i>{{ ml({ en: 'Available', mk: 'Слободно', sr: 'Slobodno', tr: 'Müsait', sq: 'Në dispozicion' }) }}</span>
                <span><i class="dot is-high"></i>{{ ml({ en: 'Half full', mk: 'Полу-полно', sr: 'Poluprazno', tr: 'Yarı dolu', sq: 'Gjysmë e plotë' }) }}</span>
                <span><i class="dot is-full"></i>{{ ml({ en: 'Full', mk: 'Полно', sr: 'Puno', tr: 'Dolu', sq: 'E plotë' }) }}</span>
                <span><i class="dot is-closed"></i>{{ ml({ en: 'Closed', mk: 'Затворено', sr: 'Zatvoreno', tr: 'Kapalı', sq: 'Mbyllur' }) }}</span>
            </div>
            <button type="button" class="avail-nav" @click="emit('shift-months', 1)">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

        <div class="avail-grid">
            <div v-for="grid in monthGrids" :key="grid.key" class="avail-month">
                <h5>{{ grid.label }}</h5>
                <div class="avail-weekdays">
                    <span v-for="label in weekdayLabels" :key="label">{{ label }}</span>
                </div>
                <div class="avail-days">
                    <template v-for="(cell, index) in grid.cells">
                        <span v-if="!cell" :key="`blank-${index}`" class="avail-day is-blank"></span>
                        <button
                            v-else
                            :key="cell.key"
                            type="button"
                            class="avail-day"
                            :class="[statusClass(cell), {
                                'is-today': cell.key === todayKey,
                                'is-selected': isSelected(cell.key),
                                'in-range': inRange(cell.key),
                                'is-past': cell.key < todayKey,
                            }]"
                            :title="titleFor(cell)"
                            @click="emit('select-date', cell)"
                        >
                            <span class="avail-day-number">{{ cell.day }}</span>
                            <small v-if="cell.info && cell.info.capacity > 0" class="avail-day-count">{{ cell.info.available }}</small>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.avail-calendars { width: 100%; }
.avail-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; margin-bottom: 14px; }
.avail-nav { background: #fff; border: 1px solid #ddd; border-radius: 50%; height: 34px; width: 34px; }
.avail-nav:hover { background: #f5f2ec; }
.avail-legend { display: flex; flex-wrap: wrap; font-size: .75rem; gap: 14px; }
.avail-legend span { align-items: center; display: inline-flex; gap: 6px; }
.dot { border-radius: 50%; display: inline-block; height: 12px; width: 12px; }
.dot.is-open { border: 2px solid #1f9d55; }
.dot.is-high { border: 2px solid #e0a800; }
.dot.is-full { border: 2px solid #d64545; }
.dot.is-closed { background: #e5e5e5; border: 2px solid #bdbdbd; }
.avail-grid { display: grid; gap: 18px; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
.avail-month { background: #fff; border: 1px solid #ece7de; padding: 12px; }
.avail-month h5 { font-size: .95rem; margin-bottom: 10px; text-align: center; text-transform: capitalize; }
.avail-weekdays { display: grid; grid-template-columns: repeat(7, 1fr); font-size: .65rem; color: #999; text-align: center; margin-bottom: 4px; }
.avail-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
.avail-day { align-items: center; background: transparent; border: 2px solid transparent; border-radius: 50%; display: flex; flex-direction: column; font-size: .8rem; justify-content: center; aspect-ratio: 1; line-height: 1; padding: 0; }
.avail-day.is-blank { border: none; }
.avail-day-count { font-size: .55rem; opacity: .7; }
.avail-day.is-open { border-color: #1f9d55; color: #14532d; }
.avail-day.is-high { border-color: #e0a800; color: #7a5b00; background: rgba(224, 168, 0, .1); }
.avail-day.is-full { border-color: #d64545; color: #8a1f1f; background: rgba(214, 69, 69, .12); }
.avail-day.is-closed { border-color: #e0e0e0; color: #bbb; }
.avail-day.is-unknown { color: #bbb; }
.avail-day.is-today { font-weight: 700; text-decoration: underline; }
.avail-day.is-selected { background: #8f7952; border-color: #8f7952; color: #fff; }
.avail-day.in-range { background: rgba(143, 121, 82, .18); }
.avail-day.is-past { opacity: .35; }
.avail-day:hover:not(.is-past) { transform: scale(1.06); }
</style>
