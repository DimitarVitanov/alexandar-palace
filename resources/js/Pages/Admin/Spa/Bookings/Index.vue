<script setup>
import { Link, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import AdminLayout from '../../Layout.vue';

const props = defineProps({
    bookings: Object,
    services: Array,
    stats: Object,
    filters: Object,
});

const search = ref(props.filters?.search || '');
const status = ref(props.filters?.status || '');
const serviceId = ref(props.filters?.service_id || '');
const date = ref(props.filters?.date || '');

const applyFilters = () => {
    router.get('/admin/spa/bookings', {
        search: search.value || undefined,
        status: status.value || undefined,
        service_id: serviceId.value || undefined,
        date: date.value || undefined,
    }, { preserveState: true });
};

const clearFilters = () => {
    search.value = '';
    status.value = '';
    serviceId.value = '';
    date.value = '';
    router.get('/admin/spa/bookings');
};

let searchTimeout;
watch(search, () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(applyFilters, 300);
});

const deleteForm = useForm({});
const destroy = (item) => {
    if (confirm('Are you sure you want to delete this booking?')) {
        deleteForm.delete(`/admin/spa/bookings/${item.id}`);
    }
};

const confirmBooking = (item) => {
    if (confirm('Confirm this booking?')) {
        router.post(`/admin/spa/bookings/${item.id}/confirm`);
    }
};

const cancelBooking = (item) => {
    const reason = prompt('Cancellation reason (optional):');
    if (reason !== null) {
        router.post(`/admin/spa/bookings/${item.id}/cancel`, { cancellation_reason: reason });
    }
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
    completed: 'bg-blue-100 text-blue-700',
    no_show: 'bg-gray-100 text-gray-700',
};

const getServiceName = (service) => {
    if (!service) return 'N/A';
    return typeof service.name === 'object' ? service.name.en : service.name;
};
</script>

<template>
    <AdminLayout>
        <template #title>Spa Bookings</template>
        <template #actions>
            <Link href="/admin/spa/bookings/calendar" class="btn-secondary mr-2">
                <i class="bi bi-calendar3 mr-2"></i> Calendar
            </Link>
            <Link href="/admin/spa/services" class="btn-secondary mr-2">
                <i class="bi bi-flower1 mr-2"></i> Services
            </Link>
            <Link href="/admin/spa/bookings/create" class="btn-primary">
                <i class="bi bi-plus-lg mr-2"></i> New Booking
            </Link>
        </template>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-flower1 text-purple-600"></i>
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
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <input v-model="search" type="text" placeholder="Search..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>
                <div>
                    <select v-model="status" @change="applyFilters" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div>
                    <select v-model="serviceId" @change="applyFilters" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
                        <option value="">All Services</option>
                        <option v-for="service in services" :key="service.id" :value="service.id">{{ getServiceName(service) }}</option>
                    </select>
                </div>
                <div>
                    <input v-model="date" @change="applyFilters" type="date" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
                </div>
                <div>
                    <button @click="clearFilters" class="w-full px-3 py-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg border border-slate-300">
                        <i class="bi bi-x-lg mr-2"></i> Clear
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
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Reference</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Guest</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Service</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Date & Time</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Price</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!bookings?.data?.length">
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-flower1 text-4xl mb-2 block text-slate-300"></i>
                                No spa bookings found.
                            </td>
                        </tr>
                        <tr v-for="item in bookings.data" :key="item.id" class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3">
                                <span class="font-mono text-sm text-purple-600 font-medium">{{ item.booking_reference }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800 text-sm">{{ item.name }}</div>
                                <div class="text-xs text-slate-500">{{ item.email }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600 text-sm">
                                {{ getServiceName(item.spa_service) }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-slate-800">{{ formatDate(item.booking_date) }}</div>
                                <div class="text-xs text-slate-500">{{ item.start_time }} - {{ item.end_time }}</div>
                            </td>
                            <td class="px-4 py-3 text-right text-sm font-medium text-slate-800">
                                {{ formatCurrency(item.total_price) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span :class="['px-2 py-1 text-xs font-medium rounded-full', statusColors[item.status]]">
                                    {{ item.status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button v-if="item.status === 'pending'" @click="confirmBooking(item)" class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg" title="Confirm">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                    <Link :href="`/admin/spa/bookings/${item.id}`" class="p-1.5 text-slate-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg" title="View">
                                        <i class="bi bi-eye"></i>
                                    </Link>
                                    <button v-if="item.status !== 'cancelled'" @click="cancelBooking(item)" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg" title="Cancel">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                    <button @click="destroy(item)" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

