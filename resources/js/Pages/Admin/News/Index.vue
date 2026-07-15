<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    news: Array,
});

const deleteForm = useForm({});
const destroy = (item) => {
    if (confirm('Are you sure you want to delete this article?')) {
        deleteForm.delete(`/admin/news/${item.id}`);
    }
};

const formatDate = (date) => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
};
</script>

<template>
    <AdminLayout>
        <template #title>News & Events</template>
        <template #actions>
            <Link 
                href="/admin/news/create" 
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-plus-lg"></i>
                Add Article
            </Link>
        </template>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Article</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Published</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!news?.length">
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-newspaper text-4xl mb-2 block text-slate-300"></i>
                                No articles found. Create your first article.
                            </td>
                        </tr>
                        <tr v-for="item in news" :key="item.id" class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-12 bg-slate-200 rounded-lg overflow-hidden flex-shrink-0">
                                        <img 
                                            v-if="item.featured_image" 
                                            :src="`/assets/paradise/${item.featured_image}`" 
                                            :alt="item.title"
                                            class="w-full h-full object-cover"
                                        >
                                        <div v-else class="w-full h-full flex items-center justify-center text-slate-400">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ item.title }}</div>
                                        <div class="text-sm text-slate-500">{{ item.slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">
                                    {{ item.category || 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ formatDate(item.published_at) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="[
                                    'px-2.5 py-1 text-xs font-medium rounded-full',
                                    item.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'
                                ]">
                                    {{ item.is_active ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link 
                                        :href="`/admin/news/${item.id}/edit`" 
                                        class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil"></i>
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
