<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    pages: Array,
});

const deleteForm = useForm({});
const destroy = (page) => {
    if (confirm('Are you sure you want to delete this page?')) {
        deleteForm.delete(`/admin/pages/${page.slug}`);
    }
};
</script>

<template>
    <AdminLayout>
        <template #title>Pages</template>
        <template #actions>
            <Link 
                href="/admin/pages/create" 
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-plus-lg"></i>
                Add Page
            </Link>
        </template>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Page</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Sections</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!pages?.length">
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-file-text text-4xl mb-2 block text-slate-300"></i>
                                No pages found. Create your first page.
                            </td>
                        </tr>
                        <tr v-for="page in pages" :key="page.id" class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                                        <i class="bi bi-file-text"></i>
                                    </div>
                                    <div class="font-medium text-slate-800">{{ page.title?.en || page.title }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-sm bg-slate-100 px-2 py-1 rounded text-slate-600">/{{ page.slug }}</code>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded-full">
                                    {{ page.sections_count || 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="[
                                    'px-2.5 py-1 text-xs font-medium rounded-full',
                                    page.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'
                                ]">
                                    {{ page.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link 
                                        :href="`/admin/pages/${page.slug}/edit`" 
                                        class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button 
                                        @click="destroy(page)" 
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
