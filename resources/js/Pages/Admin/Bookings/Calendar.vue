<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    bookings: Array,
    rooms: Array,
});

const currentDate = ref(new Date());
const selectedRoom = ref('');

const currentMonth = computed(() => currentDate.value.getMonth());
const currentYear = computed(() => currentDate.value.getFullYear());

const monthName = computed(() => {
    return currentDate.value.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
});

const daysInMonth = computed(() => {
    return new Date(currentYear.value, currentMonth.value + 1, 0).getDate();
});

const firstDayOfMonth = computed(() => {
    return new Date(currentYear.value, currentMonth.value, 1).getDay();
});

const calendarDays = computed(() => {
    const days = [];
    const totalSlots = firstDayOfMonth.value + daysInMonth.value;
    const rows = Math.ceil(totalSlots / 7);
    
    for (let i = 0; i < rows * 7; i++) {
        const dayNum = i - firstDayOfMonth.value + 1;
        if (dayNum > 0 && dayNum <= daysInMonth.value) {
            days.push({
                day: dayNum,
                date: new Date(currentYear.value, currentMonth.value, dayNum),
                isToday: isToday(dayNum),
            });
        } else {
            days.push(null);
        }
    }
    return days;
});

const isToday = (day) => {
    const today = new Date();
    return day === today.getDate() && 
           currentMonth.value === today.getMonth() && 
           currentYear.value === today.getFullYear();
};

const filteredBookings = computed(() => {
    if (!selectedRoom.value) return props.bookings;
    return props.bookings.filter(b => b.room_id == selectedRoom.value);
});

const getBookingsForDay = (date) => {
    if (!date) return [];
    const dateStr = formatDateStr(date);
    return filteredBookings.value.filter(booking => {
        const checkIn = booking.check_in;
        const checkOut = booking.check_out;
        return dateStr >= checkIn && dateStr < checkOut;
    });
};

const formatDateStr = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
};

const prevMonth = () => {
    currentDate.value = new Date(currentYear.value, currentMonth.value - 1, 1);
};

const nextMonth = () => {
    currentDate.value = new Date(currentYear.value, currentMonth.value + 1, 1);
};

const goToToday = () => {
    currentDate.value = new Date();
};

const statusColors = {
    pending: 'bg-amber-500',
    confirmed: 'bg-green-500',
    checked_in: 'bg-blue-500',
};

const getRoomName = (room) => {
    if (!room) return 'N/A';
    return typeof room.name === 'object' ? room.name.en : room.name;
};
</script>

<template>
    <AdminLayout>
        <template #title>Booking Calendar</template>
        <template #actions>
            <Link href="/admin/bookings" class="btn-secondary mr-2">
                <i class="bi bi-list-ul mr-2"></i> List View
            </Link>
            <Link href="/admin/bookings/create" class="btn-primary">
                <i class="bi bi-plus-lg mr-2"></i> New Booking
            </Link>
        </template>

        <!-- Calendar Controls -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <button @click="prevMonth" class="p-2 hover:bg-slate-100 rounded-lg transition-colors">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-slate-800 min-w-[200px] text-center">{{ monthName }}</h2>
                    <button @click="nextMonth" class="p-2 hover:bg-slate-100 rounded-lg transition-colors">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                    <button @click="goToToday" class="ml-2 px-3 py-1.5 text-sm bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition-colors">
                        Today
                    </button>
                </div>
                <div class="flex items-center gap-4">
                    <select v-model="selectedRoom" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="">All Rooms</option>
                        <option v-for="room in rooms" :key="room.id" :value="room.id">{{ getRoomName(room) }}</option>
                    </select>
                    <div class="flex items-center gap-3 text-sm">
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-amber-500"></span> Pending</span>
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-green-500"></span> Confirmed</span>
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Checked In</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Day Headers -->
            <div class="grid grid-cols-7 bg-slate-50 border-b border-slate-200">
                <div v-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']" :key="day" 
                     class="px-2 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    {{ day }}
                </div>
            </div>

            <!-- Calendar Days -->
            <div class="grid grid-cols-7">
                <div v-for="(dayObj, index) in calendarDays" :key="index" 
                     :class="[
                         'min-h-[120px] border-b border-r border-slate-100 p-1',
                         dayObj ? 'bg-white' : 'bg-slate-50',
                         dayObj?.isToday ? 'bg-amber-50' : ''
                     ]">
                    <template v-if="dayObj">
                        <div class="flex items-center justify-between mb-1">
                            <span :class="[
                                'text-sm font-medium px-1.5 py-0.5 rounded',
                                dayObj.isToday ? 'bg-amber-500 text-white' : 'text-slate-600'
                            ]">
                                {{ dayObj.day }}
                            </span>
                        </div>
                        <div class="space-y-1">
                            <Link v-for="booking in getBookingsForDay(dayObj.date).slice(0, 3)" 
                                  :key="booking.id"
                                  :href="`/admin/bookings/${booking.id}`"
                                  :class="[
                                      'block px-1.5 py-0.5 text-xs text-white rounded truncate hover:opacity-80 transition-opacity',
                                      statusColors[booking.status] || 'bg-slate-500'
                                  ]"
                                  :title="`${booking.name} - ${getRoomName(booking.room)}`">
                                {{ booking.name?.split(' ')[0] }}
                            </Link>
                            <div v-if="getBookingsForDay(dayObj.date).length > 3" 
                                 class="text-xs text-slate-500 px-1">
                                +{{ getBookingsForDay(dayObj.date).length - 3 }} more
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Upcoming Bookings List -->
        <div class="mt-6 bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">This Month's Bookings</h3>
            <div class="space-y-2">
                <div v-if="!filteredBookings.length" class="text-slate-500 text-center py-4">
                    No bookings for this period.
                </div>
                <Link v-for="booking in filteredBookings.slice(0, 10)" :key="booking.id"
                      :href="`/admin/bookings/${booking.id}`"
                      class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 transition-colors border border-slate-100">
                    <div class="flex items-center gap-3">
                        <span :class="['w-2 h-8 rounded-full', statusColors[booking.status] || 'bg-slate-300']"></span>
                        <div>
                            <div class="font-medium text-slate-800">{{ booking.name }}</div>
                            <div class="text-sm text-slate-500">
                                {{ getRoomName(booking.room) }}
                                <span v-if="booking.room_unit" class="text-amber-600 font-medium ml-1">({{ booking.room_unit.unit_code }})</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right text-sm">
                        <div class="text-slate-800">{{ booking.check_in?.split('T')[0] }}</div>
                        <div class="text-slate-500">to {{ booking.check_out?.split('T')[0] }}</div>
                    </div>
                </Link>
            </div>
        </div>
    </AdminLayout>
</template>
