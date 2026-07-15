<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layout.vue';

const props = defineProps({
    courts: Object,
});

const deleteForm = useForm({});
const destroy = (item) => {
    if (confirm('Are you sure you want to delete this tennis court?')) {
        deleteForm.delete(`/admin/tennis/courts/${item.id}`);
    }
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'EUR' }).format(amount || 0);
};

const getName = (item) => {
    return typeof item.name === 'object' ? item.name.en : item.name;
};

const surfaceColors = {
    hard: 'bg-blue-100 text-blue-700',
    clay: 'bg-orange-100 text-orange-700',
    grass: 'bg-green-100 text-green-700',
    carpet: 'bg-purple-100 text-purple-700',
};
</script>

<template>
    <AdminLayout>
        <template #title>Tennis Courts</template>
        <template #actions>
            <Link href="/admin/tennis/bookings" class="btn-secondary mr-2">
                <i class="bi bi-calendar-check mr-2"></i> View Bookings
            </Link>
            <Link href="/admin/tennis/courts/create" class="btn-primary">
                <i class="bi bi-plus-lg mr-2"></i> Add Court
            </Link>
        </template>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Court</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Surface</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Price/Hour</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Bookings</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!courts?.data?.length">
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-dribbble text-4xl mb-2 block text-slate-300"></i>
                                No tennis courts found.
                            </td>
                        </tr>
                        <tr v-for="item in courts.data" :key="item.id" class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center text-white">
                                        <i class="bi bi-dribbble text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ getName(item) }}</div>
                                        <div class="text-sm text-slate-500">
                                            <i v-if="item.has_lighting" class="bi bi-lightbulb text-amber-500 mr-1"></i>
                                            {{ item.has_lighting ? 'With lighting' : 'No lighting' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="['px-2.5 py-1 text-xs font-medium rounded-full capitalize', surfaceColors[item.surface_type] || 'bg-slate-100 text-slate-600']">
                                    {{ item.surface_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-slate-600">
                                <span :class="['px-2.5 py-1 text-xs font-medium rounded-full', item.is_indoor ? 'bg-slate-100 text-slate-700' : 'bg-sky-100 text-sky-700']">
                                    {{ item.is_indoor ? 'Indoor' : 'Outdoor' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="font-medium text-slate-800">{{ formatCurrency(item.price_per_hour) }}</div>
                                <div v-if="item.price_per_hour_peak" class="text-sm text-amber-600">Peak: {{ formatCurrency(item.price_per_hour_peak) }}</div>
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
                                    <Link :href="`/admin/tennis/courts/${item.id}/edit`" class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
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

