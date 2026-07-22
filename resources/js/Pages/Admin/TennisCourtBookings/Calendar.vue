<script setup>
import { ref, computed } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    schedule: Object,
    courts: Array,
    selectedDate: String,
    bookings: Array,
});

const currentDate = ref(props.selectedDate);
const selectedCourt = ref('all');

const changeDate = (offset) => {
    const date = new Date(currentDate.value);
    date.setDate(date.getDate() + offset);
    currentDate.value = date.toISOString().split('T')[0];
    router.get('/admin/tennis-court-bookings/calendar', { date: currentDate.value }, { preserveState: true });
};

const goToDate = () => {
    router.get('/admin/tennis-court-bookings/calendar', { date: currentDate.value }, { preserveState: true });
};

const formatDate = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('en-GB', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
};

const filteredSchedule = computed(() => {
    if (selectedCourt.value === 'all') return props.schedule;
    return Object.fromEntries(
        Object.entries(props.schedule).filter(([key]) => key === selectedCourt.value)
    );
});

const getCourtIcon = (type) => {
    const icons = {
        tennis: '🎾',
        basketball: '🏀',
        football: '⚽',
    };
    return icons[type] || '🏟️';
};

const getCourtColor = (type) => {
    const colors = {
        tennis: 'from-green-500 to-green-600',
        basketball: 'from-orange-500 to-orange-600',
        football: 'from-emerald-500 to-emerald-600',
    };
    return colors[type] || 'from-gray-500 to-gray-600';
};

const getStatusColor = (status) => {
    const colors = {
        pending: 'bg-amber-100 border-amber-300 text-amber-800',
        confirmed: 'bg-green-100 border-green-300 text-green-800',
        completed: 'bg-slate-100 border-slate-300 text-slate-600',
    };
    return colors[status] || 'bg-gray-100 border-gray-300 text-gray-600';
};

const confirmBooking = (id) => {
    if (confirm('Confirm this booking?')) {
        router.post(`/admin/tennis-court-bookings/${id}/confirm`, {}, { preserveState: true });
    }
};

const cancelBooking = (id) => {
    if (confirm('Cancel this booking?')) {
        router.post(`/admin/tennis-court-bookings/${id}/cancel`, {}, { preserveState: true });
    }
};

const todayBookings = computed(() => {
    return props.bookings || [];
});

const pendingCount = computed(() => {
    return todayBookings.value.filter(b => b.status === 'pending').length;
});

const confirmedCount = computed(() => {
    return todayBookings.value.filter(b => b.status === 'confirmed').length;
});
</script>

<template>
    <AdminLayout title="Court Bookings Calendar">
        <div class="min-h-screen bg-slate-50 p-6">
            <!-- Header -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Court Schedule</h1>
                    <p class="text-slate-500">Visual overview of all court bookings</p>
                </div>
                <div class="flex items-center gap-3">
                    <Link href="/admin/tennis-court-bookings" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50 transition-colors">
                        <i class="bi bi-list-ul mr-2"></i> List View
                    </Link>
                </div>
            </div>

            <!-- Date Navigation & Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
                <!-- Date Picker -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                    <div class="flex items-center gap-4">
                        <button @click="changeDate(-1)" class="p-2 hover:bg-slate-100 rounded-lg transition-colors">
                            <i class="bi bi-chevron-left text-xl"></i>
                        </button>
                        <div class="flex-1 text-center">
                            <input 
                                type="date" 
                                v-model="currentDate" 
                                @change="goToDate"
                                class="text-lg font-semibold text-slate-800 border-0 bg-transparent text-center cursor-pointer focus:outline-none"
                            >
                            <p class="text-slate-500 text-sm">{{ formatDate(currentDate) }}</p>
                        </div>
                        <button @click="changeDate(1)" class="p-2 hover:bg-slate-100 rounded-lg transition-colors">
                            <i class="bi bi-chevron-right text-xl"></i>
                        </button>
                        <button 
                            @click="currentDate = new Date().toISOString().split('T')[0]; goToDate()"
                            class="px-3 py-1.5 text-sm bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition-colors"
                        >
                            Today
                        </button>
                    </div>
                </div>

                <!-- Stats -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center text-white text-xl">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-amber-700">{{ pendingCount }}</p>
                        <p class="text-amber-600 text-sm font-medium">Pending</p>
                    </div>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center text-white text-xl">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-700">{{ confirmedCount }}</p>
                        <p class="text-green-600 text-sm font-medium">Confirmed</p>
                    </div>
                </div>
            </div>

            <!-- Court Filter -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-slate-600 font-medium">Filter by court:</span>
                    <button 
                        @click="selectedCourt = 'all'"
                        :class="[
                            'px-4 py-2 rounded-lg font-medium transition-colors',
                            selectedCourt === 'all' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
                        ]"
                    >
                        All Courts
                    </button>
                    <button 
                        v-for="(data, key) in schedule" 
                        :key="key"
                        @click="selectedCourt = key"
                        :class="[
                            'px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2',
                            selectedCourt === key ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
                        ]"
                    >
                        <span>{{ getCourtIcon(data.court.court_type) }}</span>
                        {{ data.court.name || data.court.display_name }}
                    </button>
                </div>
            </div>

            <!-- Court Schedule Grid -->
            <div class="space-y-6">
                <div v-for="(data, key) in filteredSchedule" :key="key" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <!-- Court Header with Illustration -->
                    <div :class="['bg-gradient-to-r p-4 text-white', getCourtColor(data.court.court_type)]">
                        <div class="flex items-center gap-4">
                            <!-- Court Illustration -->
                            <div class="w-20 h-20 bg-white/20 rounded-xl flex items-center justify-center text-4xl backdrop-blur-sm">
                                {{ getCourtIcon(data.court.court_type) }}
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold">{{ data.court.name || data.court.display_name }}</h3>
                                <p class="text-white/80">
                                    {{ data.court.slot_duration }} min slots • Max {{ data.court.max_players }} players
                                    <span v-if="data.court.price_per_slot"> • €{{ data.court.price_per_slot }}/slot</span>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold">{{ Object.values(data.slots).filter(s => s).length }}</p>
                                <p class="text-white/80 text-sm">bookings today</p>
                            </div>
                        </div>
                    </div>

                    <!-- Time Slots Grid -->
                    <div class="p-4">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-3">
                            <div 
                                v-for="(booking, time) in data.slots" 
                                :key="time"
                                :class="[
                                    'rounded-xl p-3 border-2 transition-all',
                                    booking ? getStatusColor(booking.status) : 'bg-slate-50 border-slate-200 border-dashed'
                                ]"
                            >
                                <div class="text-center mb-2">
                                    <span class="text-lg font-bold">{{ time }}</span>
                                </div>
                                
                                <template v-if="booking">
                                    <div class="text-center">
                                        <p class="font-semibold text-sm truncate">{{ booking.name }}</p>
                                        <p class="text-xs opacity-75">{{ booking.players }} players</p>
                                        <span :class="[
                                            'inline-block mt-2 px-2 py-0.5 rounded-full text-xs font-bold uppercase',
                                            booking.status === 'pending' ? 'bg-amber-200 text-amber-800' : 'bg-green-200 text-green-800'
                                        ]">
                                            {{ booking.status }}
                                        </span>
                                    </div>
                                    
                                    <!-- Quick Actions -->
                                    <div class="flex justify-center gap-1 mt-2">
                                        <Link 
                                            :href="`/admin/tennis-court-bookings/${booking.id}`"
                                            class="p-1.5 bg-white rounded-lg hover:bg-slate-100 transition-colors"
                                            title="View Details"
                                        >
                                            <i class="bi bi-eye text-slate-600"></i>
                                        </Link>
                                        <button 
                                            v-if="booking.status === 'pending'"
                                            @click="confirmBooking(booking.id)"
                                            class="p-1.5 bg-white rounded-lg hover:bg-green-100 transition-colors"
                                            title="Confirm"
                                        >
                                            <i class="bi bi-check-lg text-green-600"></i>
                                        </button>
                                        <button 
                                            v-if="booking.status === 'pending'"
                                            @click="cancelBooking(booking.id)"
                                            class="p-1.5 bg-white rounded-lg hover:bg-red-100 transition-colors"
                                            title="Cancel"
                                        >
                                            <i class="bi bi-x-lg text-red-600"></i>
                                        </button>
                                    </div>
                                </template>
                                
                                <template v-else>
                                    <div class="text-center text-slate-400">
                                        <i class="bi bi-calendar-check text-2xl"></i>
                                        <p class="text-xs mt-1">Available</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Bookings Summary -->
            <div v-if="todayBookings.length > 0" class="mt-6 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-4 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-800">Today's Bookings Summary</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Time</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Court</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Contact</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Players</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="booking in todayBookings" :key="booking.id" class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-medium">
                                    {{ booking.start_time?.substring(0, 5) }} - {{ booking.end_time?.substring(0, 5) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1">
                                        {{ getCourtIcon(booking.court_type) }}
                                        {{ booking.court_type }} #{{ booking.court_number || 1 }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-medium">{{ booking.name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500">
                                    {{ booking.email }}<br>
                                    {{ booking.phone }}
                                </td>
                                <td class="px-4 py-3">{{ booking.players }}</td>
                                <td class="px-4 py-3">
                                    <span :class="[
                                        'px-2 py-1 rounded-full text-xs font-bold uppercase',
                                        booking.status === 'pending' ? 'bg-amber-100 text-amber-700' : 
                                        booking.status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'
                                    ]">
                                        {{ booking.status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1">
                                        <Link 
                                            :href="`/admin/tennis-court-bookings/${booking.id}`"
                                            class="p-1.5 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <button 
                                            v-if="booking.status === 'pending'"
                                            @click="confirmBooking(booking.id)"
                                            class="p-1.5 text-green-500 hover:text-green-700 hover:bg-green-50 rounded"
                                        >
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                        <button 
                                            v-if="booking.status === 'pending'"
                                            @click="cancelBooking(booking.id)"
                                            class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded"
                                        >
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="Object.keys(schedule).length === 0" class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                <div class="text-6xl mb-4">🏟️</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">No Courts Configured</h3>
                <p class="text-slate-500 mb-4">Set up your courts and time slots to start accepting bookings.</p>
                <Link href="/admin/tennis/courts" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition-colors">
                    <i class="bi bi-gear"></i> Configure Courts
                </Link>
            </div>
        </div>
    </AdminLayout>
</template>
