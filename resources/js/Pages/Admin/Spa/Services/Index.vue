<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layout.vue';

const props = defineProps({
    services: Object,
});

const deleteForm = useForm({});
const destroy = (item) => {
    if (confirm('Are you sure you want to delete this spa service?')) {
        deleteForm.delete(`/admin/spa/services/${item.id}`);
    }
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'EUR' }).format(amount || 0);
};

const getName = (item) => {
    return typeof item.name === 'object' ? item.name.en : item.name;
};

const categoryColors = {
    massage: 'bg-purple-100 text-purple-700',
    facial: 'bg-pink-100 text-pink-700',
    body: 'bg-blue-100 text-blue-700',
    wellness: 'bg-green-100 text-green-700',
    beauty: 'bg-amber-100 text-amber-700',
};
</script>

<template>
    <AdminLayout>
        <template #title>Spa Services</template>
        <template #actions>
            <Link href="/admin/spa/bookings" class="btn-secondary mr-2">
                <i class="bi bi-calendar-check mr-2"></i> View Bookings
            </Link>
            <Link href="/admin/spa/services/create" class="btn-primary">
                <i class="bi bi-plus-lg mr-2"></i> Add Service
            </Link>
        </template>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Bookings</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!services?.data?.length">
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-flower1 text-4xl mb-2 block text-slate-300"></i>
                                No spa services found.
                            </td>
                        </tr>
                        <tr v-for="item in services.data" :key="item.id" class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center text-white">
                                        <i class="bi bi-flower1 text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ getName(item) }}</div>
                                        <div class="text-sm text-slate-500">Max {{ item.max_guests }} guest(s)</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="['px-2.5 py-1 text-xs font-medium rounded-full capitalize', categoryColors[item.category] || 'bg-slate-100 text-slate-600']">
                                    {{ item.category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-slate-600">
                                {{ item.duration_minutes }} min
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="font-medium text-slate-800">{{ formatCurrency(item.price) }}</div>
                                <div v-if="item.discounted_price" class="text-sm text-green-600">{{ formatCurrency(item.discounted_price) }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-sm font-medium rounded-full">
                                    {{ item.bookings_count || 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="['px-2.5 py-1 text-xs font-medium rounded-full', item.is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700']">
                                    {{ item.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="`/admin/spa/services/${item.id}/edit`" class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button @click="destroy(item)" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
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

