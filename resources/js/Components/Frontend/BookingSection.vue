<script setup>
import { ref, computed, onMounted, nextTick, watch } from 'vue';
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

const roomSelect = ref(null);

const incrementAdults = () => { if (adults.value < 10) adults.value++; };
const decrementAdults = () => { if (adults.value > 1) adults.value--; };
const incrementChildren = () => { if (children.value < 10) children.value++; };
const decrementChildren = () => { if (children.value > 0) children.value--; };

const onRoomChange = (e) => {
    selectedRoom.value = e.target.value;
    bookingError.value = '';
    checkAvailability();
};

const bookingError = ref('');

// Availability checking
const availabilityStatus = ref({ available: true, message: '', checking: false });

const selectedRoomObj = computed(() => {
    return props.rooms.find(r => r.slug === selectedRoom.value);
});

// Available rooms based on selected dates
const availableRooms = ref([]);
const loadingRooms = ref(false);

const fetchAvailableRooms = async () => {
    if (!checkIn.value || !checkOut.value) {
        // No dates selected, show all rooms
        availableRooms.value = props.rooms;
        return;
    }
    
    loadingRooms.value = true;
    
    try {
        // Check availability for each room
        const roomsWithAvailability = await Promise.all(
            props.rooms.map(async (room) => {
                try {
                    const response = await fetch(`/api/rooms/${room.id}/availability?check_in=${checkIn.value}&check_out=${checkOut.value}`);
                    const data = await response.json();
                    return { ...room, isAvailable: data.available };
                } catch {
                    return { ...room, isAvailable: false };
                }
            })
        );
        
        availableRooms.value = roomsWithAvailability.filter(r => r.isAvailable);
        
        // If selected room is no longer available, clear selection
        if (selectedRoom.value && !availableRooms.value.find(r => r.slug === selectedRoom.value)) {
            selectedRoom.value = '';
            availabilityStatus.value = { available: false, message: '', checking: false };
        }
        
        // Update niceSelect dropdown
        updateNiceSelect();
    } catch (error) {
        availableRooms.value = props.rooms;
    }
    
    loadingRooms.value = false;
};

const updateNiceSelect = () => {
    nextTick(() => {
        if (roomSelect.value && typeof $ !== 'undefined') {
            $(roomSelect.value).niceSelect('update');
        }
    });
};

const checkAvailability = async () => {
    if (!selectedRoom.value || !checkIn.value || !checkOut.value) {
        availabilityStatus.value = { available: true, message: '', checking: false };
        return;
    }
    
    const room = selectedRoomObj.value;
    if (!room) return;
    
    availabilityStatus.value.checking = true;
    
    try {
        const response = await fetch(`/api/rooms/${room.id}/availability?check_in=${checkIn.value}&check_out=${checkOut.value}`);
        const data = await response.json();
        availabilityStatus.value = { ...data, checking: false };
    } catch (error) {
        availabilityStatus.value = { available: false, message: 'Error checking availability', checking: false };
    }
};

// Watch for date changes - fetch available rooms
watch([checkIn, checkOut], () => {
    fetchAvailableRooms();
    checkAvailability();
});

// Initialize available rooms
availableRooms.value = props.rooms;

const roomNotAvailable = computed(() => !availabilityStatus.value.available && !availabilityStatus.value.checking);
const isChecking = computed(() => availabilityStatus.value.checking);

const bookNow = () => {
    console.log('bookNow called', { room: selectedRoom.value, checkIn: checkIn.value, checkOut: checkOut.value });
    
    // Validate required fields
    if (!selectedRoom.value) {
        bookingError.value = locale.value === 'mk' ? 'Ве молиме изберете соба' : 'Please select a room';
        console.log('Error: no room selected');
        return;
    }
    if (!checkIn.value || !checkOut.value) {
        bookingError.value = locale.value === 'mk' ? 'Ве молиме изберете датуми' : 'Please select check-in and check-out dates';
        console.log('Error: no dates selected');
        return;
    }
    
    bookingError.value = '';
    const params = new URLSearchParams();
    params.set('room', selectedRoom.value);
    params.set('check_in', checkIn.value);
    params.set('check_out', checkOut.value);
    params.set('adults', adults.value);
    params.set('children', children.value);
    const url = `/booking?${params.toString()}`;
    console.log('Navigating to:', url);
    window.location.href = url;
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
        
        // Sync niceSelect with Vue - listen for changes on the native select
        if (roomSelect.value && typeof $ !== 'undefined') {
            $(roomSelect.value).on('change', function() {
                selectedRoom.value = this.value;
                bookingError.value = '';
            });
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
                                        <select ref="roomSelect" v-model="selectedRoom" class="wide" @change="onRoomChange">
                                            <option value="">{{ loadingRooms 
                                                ? (locale === 'mk' ? 'Вчитување...' : 'Loading...') 
                                                : (availableRooms.length === 0 && checkIn && checkOut
                                                    ? (locale === 'mk' ? 'Нема достапни соби' : 'No rooms available')
                                                    : (locale === 'mk' ? 'Изберете Соба' : 'Select Room')) 
                                            }}</option>
                                            <option v-for="room in availableRooms" :key="room.slug" :value="room.slug">
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
                        <!-- No rooms available for dates -->
                        <div v-if="availableRooms.length === 0 && checkIn && checkOut && !loadingRooms" class="alert alert-warning mt-3 text-center">
                            <i class="bi bi-calendar-x me-2"></i>
                            {{ locale === 'mk' 
                                ? 'Нема достапни соби за избраните датуми. Ве молиме изберете други датуми.'
                                : 'No rooms available for selected dates. Please choose different dates.' }}
                        </div>
                        <!-- Availability Status -->
                        <div v-else-if="roomNotAvailable" class="alert alert-danger mt-3 text-center">
                            <i class="bi bi-x-circle me-2"></i>
                            {{ locale === 'mk' 
                                ? 'Избраната соба не е достапна за овие датуми. Ве молиме изберете други датуми или друга соба.'
                                : 'The selected room is not available for these dates. Please choose different dates or another room.' }}
                        </div>
                        <div v-else-if="isChecking" class="alert alert-info mt-3 text-center">
                            <i class="bi bi-hourglass-split me-2"></i>
                            {{ locale === 'mk' ? 'Проверка на достапност...' : 'Checking availability...' }}
                        </div>
                        <div v-else-if="bookingError" class="alert alert-warning mt-3 text-center">
                            {{ bookingError }}
                        </div>
                        <p class="text-end mt-4">
                            <button type="button" class="btn_1 outline" @click="bookNow" :disabled="roomNotAvailable || isChecking || loadingRooms || (availableRooms.length === 0 && checkIn && checkOut)" :class="{ 'disabled': roomNotAvailable || isChecking || loadingRooms || (availableRooms.length === 0 && checkIn && checkOut) }">
                                {{ loadingRooms ? (locale === 'mk' ? 'Вчитување...' : 'Loading...') : (locale === 'mk' ? 'Резервирај' : 'Book Now') }}
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Global styles for niceSelect dropdown - must not be scoped */
.booking_section {
    position: relative;
    z-index: 999 !important;
}

.booking_section .booking_wrapper {
    overflow: visible !important;
}

.booking_section .nice-select {
    z-index: 9999 !important;
}

.booking_section .nice-select .list {
    z-index: 99999 !important;
    position: absolute !important;
}

.booking_section .nice-select.open .list {
    z-index: 99999 !important;
}

.booking_section .row {
    overflow: visible !important;
}

.booking_section .custom_select {
    position: relative;
    z-index: 9999 !important;
}

footer {
    z-index: 1 !important;
}
</style>

<style scoped>
.booking_section {
    position: relative;
    z-index: 999;
    overflow: visible !important;
}

.booking_wrapper {
    overflow: visible !important;
}

.qty-label {
    display: block;
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

:deep(.custom_select) {
    position: relative;
    z-index: 1000;
}

:deep(.nice-select) {
    z-index: 1000;
}

:deep(.nice-select.open) {
    z-index: 1001;
}

:deep(.nice-select.open .list) {
    z-index: 1002;
}

.booking_wrapper {
    position: relative;
    z-index: 100;
}

.btn_1.disabled,
.btn_1:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 14px;
}

.alert-danger {
    background-color: #fee2e2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

.alert-info {
    background-color: #e0f2fe;
    border: 1px solid #bae6fd;
    color: #075985;
}

.alert-warning {
    background-color: #fef3c7;
    border: 1px solid #fde68a;
    color: #92400e;
}
</style>
