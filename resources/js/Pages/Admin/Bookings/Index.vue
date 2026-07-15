<script setup>
import { Link, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    bookings: Object,
    rooms: Array,
    stats: Object,
    filters: Object,
});

const search = ref(props.filters?.search || '');
const status = ref(props.filters?.status || '');
const paymentStatus = ref(props.filters?.payment_status || '');
const roomId = ref(props.filters?.room_id || '');
const dateFrom = ref(props.filters?.date_from || '');
const dateTo = ref(props.filters?.date_to || '');

const applyFilters = () => {
    router.get('/admin/bookings', {
        search: search.value || undefined,
        status: status.value || undefined,
        payment_status: paymentStatus.value || undefined,
        room_id: roomId.value || undefined,
        date_from: dateFrom.value || undefined,
        date_to: dateTo.value || undefined,
    }, { preserveState: true });
};

const clearFilters = () => {
    search.value = '';
    status.value = '';
    paymentStatus.value = '';
    roomId.value = '';
    dateFrom.value = '';
    dateTo.value = '';
    router.get('/admin/bookings');
};

let searchTimeout;
watch(search, () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(applyFilters, 300);
});

const deleteForm = useForm({});
const destroy = (item) => {
    if (confirm('Are you sure you want to delete this booking?')) {
        deleteForm.delete(`/admin/bookings/${item.id}`);
    }
};

const confirmBooking = (item) => {
    if (confirm('Confirm this booking?')) {
        router.post(`/admin/bookings/${item.id}/confirm`);
    }
};

const cancelBooking = (item) => {
    const reason = prompt('Cancellation reason (optional):');
    if (reason !== null) {
        router.post(`/admin/bookings/${item.id}/cancel`, { cancellation_reason: reason });
    }
};

const checkInGuest = (item) => {
    router.post(`/admin/bookings/${item.id}/check-in`);
};

const checkOutGuest = (item) => {
    router.post(`/admin/bookings/${item.id}/check-out`);
};

const formatDate = (date) => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'EUR' }).format(amount || 0);
};

const statusColors = {
    pending: 'bg-amber-100 text-amber-700',
    confirmed: 'bg-green-100 text-green-700',
    cancelled: 'bg-red-100 text-red-700',
    checked_in: 'bg-blue-100 text-blue-700',
    checked_out: 'bg-slate-100 text-slate-700',
    no_show: 'bg-gray-100 text-gray-700',
};

const paymentColors = {
    unpaid: 'bg-red-100 text-red-700',
    partial: 'bg-amber-100 text-amber-700',
    paid: 'bg-green-100 text-green-700',
    refunded: 'bg-blue-100 text-blue-700',
};

const getRoomName = (room) => {
    if (!room) return 'N/A';
    return typeof room.name === 'object' ? room.name.en : room.name;
};
</script>

<template>
    <AdminLayout>
        <template #title>Room Bookings</template>
        <template #actions>
            <Link href="/admin/bookings/calendar" class="btn-secondary mr-2">
                <i class="bi bi-calendar3 mr-2"></i> Calendar View
            </Link>
            <Link href="/admin/bookings/create" class="btn-primary">
                <i class="bi bi-plus-lg mr-2"></i> New Booking
            </Link>
        </template>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-calendar-check text-slate-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-slate-800">{{ stats?.total || 0 }}</div>
                        <div class="text-xs text-slate-500">Total</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-clock text-amber-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-amber-600">{{ stats?.pending || 0 }}</div>
                        <div class="text-xs text-slate-500">Pending</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-600">{{ stats?.confirmed || 0 }}</div>
                        <div class="text-xs text-slate-500">Confirmed</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-arrow-right-circle text-blue-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-blue-600">{{ stats?.upcoming || 0 }}</div>
                        <div class="text-xs text-slate-500">Upcoming</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-person-check text-purple-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">{{ stats?.current_guests || 0 }}</div>
                        <div class="text-xs text-slate-500">In-House</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-currency-euro text-emerald-600"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-emerald-600">{{ formatCurrency(stats?.total_revenue) }}</div>
                        <div class="text-xs text-slate-500">Revenue</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                <div>
                    <input 
                        v-model="search" 
                        type="text" 
                        placeholder="Search name, email, ref..." 
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    >
                </div>
                <div>
                    <select v-model="status" @change="applyFilters" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="checked_in">Checked In</option>
                        <option value="checked_out">Checked Out</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="no_show">No Show</option>
                    </select>
                </div>
                <div>
                    <select v-model="paymentStatus" @change="applyFilters" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="">All Payments</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="partial">Partial</option>
                        <option value="paid">Paid</option>
                        <option value="refunded">Refunded</option>
                    </select>
                </div>
                <div>
                    <select v-model="roomId" @change="applyFilters" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="">All Rooms</option>
                        <option v-for="room in rooms" :key="room.id" :value="room.id">{{ getRoomName(room) }}</option>
                    </select>
                </div>
                <div>
                    <input v-model="dateFrom" @change="applyFilters" type="date" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="From">
                </div>
                <div class="flex gap-2">
                    <input v-model="dateTo" @change="applyFilters" type="date" class="flex-1 px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="To">
                    <button @click="clearFilters" class="px-3 py-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg" title="Clear filters">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Reference</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Guest</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Room</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Dates</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Guests</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Payment</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!bookings?.data?.length">
                            <td colspan="9" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-calendar-check text-4xl mb-2 block text-slate-300"></i>
                                No bookings found.
                            </td>
                        </tr>
                        <tr v-for="item in bookings.data" :key="item.id" class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3">
                                <span class="font-mono text-sm text-amber-600 font-medium">{{ item.booking_reference || '-' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-amber-100 rounded-full flex items-center justify-center text-amber-600 font-medium text-sm">
                                        {{ item.name?.charAt(0)?.toUpperCase() || 'G' }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800 text-sm">{{ item.name || 'Guest' }}</div>
                                        <div class="text-xs text-slate-500">{{ item.email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-600 text-sm">
                                {{ getRoomName(item.room) }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm">
                                    <div class="text-slate-800">{{ formatDate(item.check_in) }}</div>
                                    <div class="text-slate-500 text-xs">to {{ formatDate(item.check_out) }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center text-slate-600 text-sm">
                                <span class="flex items-center justify-center gap-1">
                                    <i class="bi bi-people text-xs"></i>
                                    {{ item.adults || 0 }} + {{ item.children || 0 }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right text-sm font-medium text-slate-800">
                                {{ formatCurrency(item.total_price) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span :class="['px-2 py-1 text-xs font-medium rounded-full', statusColors[item.status] || 'bg-slate-100 text-slate-600']">
                                    {{ item.status?.replace('_', ' ') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span :class="['px-2 py-1 text-xs font-medium rounded-full', paymentColors[item.payment_status] || 'bg-slate-100 text-slate-600']">
                                    {{ item.payment_status || 'unpaid' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button v-if="item.status === 'pending'" @click="confirmBooking(item)" class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Confirm">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                    <button v-if="item.status === 'confirmed'" @click="checkInGuest(item)" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Check In">
                                        <i class="bi bi-box-arrow-in-right"></i>
                                    </button>
                                    <button v-if="item.status === 'checked_in'" @click="checkOutGuest(item)" class="p-1.5 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Check Out">
                                        <i class="bi bi-box-arrow-right"></i>
                                    </button>
                                    <Link :href="`/admin/bookings/${item.id}`" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="View">
                                        <i class="bi bi-eye"></i>
                                    </Link>
                                    <button v-if="!['cancelled', 'checked_out'].includes(item.status)" @click="cancelBooking(item)" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Cancel">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                    <button @click="destroy(item)" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="bookings?.links?.length > 3" class="px-4 py-3 border-t border-slate-200 flex items-center justify-between">
                <div class="text-sm text-slate-500">
                    Showing {{ bookings.from }} to {{ bookings.to }} of {{ bookings.total }} results
                </div>
                <div class="flex gap-1">
                    <template v-for="link in bookings.links" :key="link.label">
                        <Link 
                            v-if="link.url" 
                            :href="link.url" 
                            :class="['px-3 py-1 text-sm rounded', link.active ? 'bg-amber-500 text-white' : 'text-slate-600 hover:bg-slate-100']"
                            v-html="link.label"
                        />
                        <span v-else class="px-3 py-1 text-sm text-slate-400" v-html="link.label" />
                    </template>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

