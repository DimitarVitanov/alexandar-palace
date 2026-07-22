<script setup>
import { ref, computed, onMounted, nextTick } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const props = defineProps({
    rooms: {
        type: Array,
        default: () => []
    }
});

const locale = computed(() => page.props.locale || 'en');

const selectedRoom = ref('');
const adults = ref(1);
const children = ref(0);
const checkIn = ref('');
const checkOut = ref('');

const incrementAdults = () => { if (adults.value < 10) adults.value++; };
const decrementAdults = () => { if (adults.value > 1) adults.value--; };
const incrementChildren = () => { if (children.value < 10) children.value++; };
const decrementChildren = () => { if (children.value > 0) children.value--; };

const bookNow = () => {
    const params = new URLSearchParams();
    if (selectedRoom.value) params.set('room', selectedRoom.value);
    if (checkIn.value) params.set('check_in', checkIn.value);
    if (checkOut.value) params.set('check_out', checkOut.value);
    params.set('adults', adults.value);
    params.set('children', children.value);
    window.location.href = `/booking?${params.toString()}`;
};

onMounted(() => {
    nextTick(() => {
        // Initialize easepick inline calendar
        if (typeof window.easepick !== 'undefined') {
            const element = document.getElementById('booking_section_calendar');
            if (element) {
                const picker = new window.easepick.create({
                    element: element,
                    css: ['/assets/paradise/css/daterangepicker_v2.css'],
                    lang: locale.value === 'mk' ? 'mk-MK' : 'en-EN',
                    format: 'DD/MM/YYYY',
                    calendars: 2,
                    grid: 2,
                    zIndex: 10,
                    inline: true,
                    plugins: ['RangePlugin', 'LockPlugin'],
                    RangePlugin: {
                        tooltipNumber(num) {
                            return num - 1;
                        },
                        locale: {
                            one: locale.value === 'mk' ? 'ноќ' : 'night',
                            other: locale.value === 'mk' ? 'ноќи' : 'nights',
                        },
                    },
                    LockPlugin: {
                        minDate: new Date(),
                        minDays: 1,
                    },
                    setup(picker) {
                        picker.on('select', (e) => {
                            if (e.detail.start) {
                                checkIn.value = e.detail.start.format('YYYY-MM-DD');
                            }
                            if (e.detail.end) {
                                checkOut.value = e.detail.end.format('YYYY-MM-DD');
                            }
                        });
                    }
                });
            }
        }
    });
});
</script>

<template>
    <div class="booking_section pattern_2">
        <div class="container margin_120_95">
            <div class="row justify-content-between">
                <div class="col-xl-5">
                    <div data-cue="slideInUp">
                        <div class="title">
                            <small>Alexandar Palace</small>
                            <h2>{{ locale === 'mk' ? 'Проверете Достапност' : 'Check Availability' }}</h2>
                        </div>
                        <p>{{ locale === 'mk' 
                            ? 'Резервирајте го вашиот престој во Хотел Александар Палас. Уживајте во луксузно сместување во срцето на Скопје.' 
                            : 'Book your stay at Alexandar Palace Hotel. Enjoy luxurious accommodation in the heart of Skopje.' 
                        }}</p>
                        <p class="phone_element no_borders">
                            <a href="tel:+38923092392">
                                <i class="bi bi-telephone"></i>
                                <span>
                                    <em>{{ locale === 'mk' ? 'Информации и резервации' : 'Info and Bookings' }}</em>
                                    +389 2 3092 392
                                </span>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div data-cue="slideInUp" data-delay="200">
                        <div class="booking_wrapper">
                            <div class="col-12">
                                <input type="text" id="booking_section_calendar" name="date_booking" style="position: absolute; opacity: 0; pointer-events: none;">
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                    <label class="qty-label">{{ locale === 'mk' ? 'Соба' : 'Room' }}</label>
                                    <div class="custom_select">
                                        <select v-model="selectedRoom" class="wide">
                                            <option value="">{{ locale === 'mk' ? 'Изберете Соба' : 'Select Room' }}</option>
                                            <option v-for="room in rooms" :key="room.slug" :value="room.slug">
                                                {{ room.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-8">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                                            <label class="qty-label">{{ locale === 'mk' ? 'Возрасни' : 'Adults' }}</label>
                                            <div class="qty-buttons mb-3 version_2">
                                                <input type="button" value="+" class="qtyplus" @click="incrementAdults">
                                                <input type="text" :value="adults" class="qty form-control" readonly>
                                                <input type="button" value="-" class="qtyminus" @click="decrementAdults">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label class="qty-label">{{ locale === 'mk' ? 'Деца' : 'Children' }}</label>
                                            <div class="qty-buttons mb-3 version_2">
                                                <input type="button" value="+" class="qtyplus" @click="incrementChildren">
                                                <input type="text" :value="children" class="qty form-control" readonly>
                                                <input type="button" value="-" class="qtyminus" @click="decrementChildren">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-end mt-4">
                            <a href="#" class="btn_1 outline" @click.prevent="bookNow">
                                {{ locale === 'mk' ? 'Резервирај' : 'Book Now' }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.qty-label {
    display: block;
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>
