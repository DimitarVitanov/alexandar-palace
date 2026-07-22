<script setup>
import { ref } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    subscribers: Object,
    filters: Object,
    stats: Object,
});

const search = ref(props.filters?.search || '');
const status = ref(props.filters?.status || '');

const applyFilters = () => {
    router.get('/admin/newsletter', {
        search: search.value || undefined,
        status: status.value || undefined,
    }, { preserveState: true });
};

const deleteForm = useForm({});
const destroy = (subscriber) => {
    if (confirm('Are you sure you want to delete this subscriber?')) {
        deleteForm.delete(`/admin/newsletter/${subscriber.id}`);
    }
};

const toggleStatus = (subscriber) => {
    router.post(`/admin/newsletter/${subscriber.id}/toggle`);
};

const formatDate = (date) => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <AdminLayout>
        <template #title>Newsletter Subscribers</template>
        <template #actions>
            <a 
                href="/admin/newsletter/export" 
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-download"></i>
                Export CSV
            </a>
        </template>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-people text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Total Subscribers</p>
                        <p class="text-2xl font-bold text-slate-800">{{ stats.total }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Active</p>
                        <p class="text-2xl font-bold text-green-600">{{ stats.active }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-x-circle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Unsubscribed</p>
                        <p class="text-2xl font-bold text-red-600">{{ stats.inactive }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Search</label>
                    <input 
                        v-model="search" 
                        type="text" 
                        placeholder="Search by email..."
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        @keyup.enter="applyFilters"
                    >
                </div>
                <div class="w-40">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select 
                        v-model="status" 
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        @change="applyFilters"
                    >
                        <option value="">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Unsubscribed</option>
                    </select>
                </div>
                <button 
                    @click="applyFilters" 
                    class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors"
                >
                    <i class="bi bi-search me-1"></i> Filter
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Subscribed</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!subscribers.data?.length">
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-envelope text-4xl mb-2 block text-slate-300"></i>
                                No subscribers found.
                            </td>
                        </tr>
                        <tr v-for="subscriber in subscribers.data" :key="subscriber.id" class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center text-amber-600 font-semibold">
                                        {{ subscriber.email.charAt(0).toUpperCase() }}
                                    </div>
                                    <span class="font-medium text-slate-800">{{ subscriber.email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="[
                                    'px-2.5 py-1 text-xs font-medium rounded-full',
                                    subscriber.is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
                                ]">
                                    {{ subscriber.is_active ? 'Active' : 'Unsubscribed' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-sm">
                                {{ formatDate(subscriber.subscribed_at || subscriber.created_at) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        @click="toggleStatus(subscriber)" 
                                        :class="[
                                            'p-2 rounded-lg transition-colors',
                                            subscriber.is_active 
                                                ? 'text-orange-500 hover:text-orange-700 hover:bg-orange-50' 
                                                : 'text-green-500 hover:text-green-700 hover:bg-green-50'
                                        ]"
                                        :title="subscriber.is_active ? 'Unsubscribe' : 'Reactivate'"
                                    >
                                        <i :class="subscriber.is_active ? 'bi bi-pause-circle' : 'bi bi-play-circle'"></i>
                                    </button>
                                    <button 
                                        @click="destroy(subscriber)" 
                                        class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Delete"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="subscribers.last_page > 1" class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
                <p class="text-sm text-slate-500">
                    Showing {{ subscribers.from }} to {{ subscribers.to }} of {{ subscribers.total }} subscribers
                </p>
                <div class="flex gap-1">
                    <Link 
                        v-for="link in subscribers.links" 
                        :key="link.label"
                        :href="link.url || '#'"
                        :class="[
                            'px-3 py-1 text-sm rounded',
                            link.active ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200',
                            !link.url ? 'opacity-50 cursor-not-allowed' : ''
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
