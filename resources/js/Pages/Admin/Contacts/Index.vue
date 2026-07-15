<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    contacts: Object,
});

const deleteForm = useForm({});
const destroy = (item) => {
    if (confirm('Are you sure you want to delete this message?')) {
        deleteForm.delete(`/admin/contacts/${item.id}`);
    }
};

const formatDate = (date) => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
};
</script>

<template>
    <AdminLayout>
        <template #title>Contact Messages</template>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">From</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!contacts?.data?.length">
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-envelope text-4xl mb-2 block text-slate-300"></i>
                                No messages found.
                            </td>
                        </tr>
                        <tr 
                            v-for="item in contacts.data" 
                            :key="item.id" 
                            :class="[
                                'hover:bg-slate-50 transition-colors',
                                !item.is_read ? 'bg-amber-50/50' : ''
                            ]"
                        >
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-500 font-medium">
                                            {{ item.name?.charAt(0)?.toUpperCase() || 'U' }}
                                        </div>
                                        <span v-if="!item.is_read" class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-amber-500 rounded-full border-2 border-white"></span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ item.name }}</div>
                                        <div class="text-sm text-slate-500">{{ item.email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div :class="['text-slate-800', !item.is_read ? 'font-medium' : '']">
                                    {{ item.subject || 'No subject' }}
                                </div>
                                <div class="text-sm text-slate-500 truncate max-w-xs">
                                    {{ item.message?.substring(0, 60) }}{{ item.message?.length > 60 ? '...' : '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ formatDate(item.created_at) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="[
                                    'px-2.5 py-1 text-xs font-medium rounded-full',
                                    item.is_read ? 'bg-slate-100 text-slate-600' : 'bg-amber-100 text-amber-700'
                                ]">
                                    {{ item.is_read ? 'Read' : 'Unread' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link 
                                        :href="`/admin/contacts/${item.id}`" 
                                        class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="View"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </Link>
                                    <button 
                                        @click="destroy(item)" 
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
        </div>
    </AdminLayout>
</template>
