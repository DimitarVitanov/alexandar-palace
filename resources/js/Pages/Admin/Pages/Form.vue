<script setup>
import { ref, watch } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';
import BilingualInput from '@/Components/Admin/BilingualInput.vue';

const props = defineProps({
    page: { type: Object, default: null },
});

const isEdit = !!props.page;
const activeTab = ref('content');

const tabs = [
    { key: 'content', label: 'Content', icon: 'bi-file-text' },
    { key: 'seo', label: 'SEO Settings', icon: 'bi-search' },
];

const form = useForm({
    slug: props.page?.slug || '',
    title: props.page?.title || { en: '', mk: '' },
    content: props.page?.content || { en: '', mk: '' },
    meta_title: props.page?.meta_title || { en: '', mk: '' },
    meta_description: props.page?.meta_description || { en: '', mk: '' },
    featured_image: props.page?.featured_image || '',
    is_active: props.page?.is_active ?? true,
});

const generateSlug = () => {
    if (!isEdit && form.title.en) {
        form.slug = form.title.en
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
    }
};

watch(() => form.title.en, generateSlug);

const submit = () => {
    if (isEdit) {
        form.put(`/admin/pages/${props.page.slug}`);
    } else {
        form.post('/admin/pages');
    }
};
</script>

<template>
    <AdminLayout>
        <template #title>{{ isEdit ? 'Edit Page' : 'Create Page' }}</template>
        <template #actions>
            <Link href="/admin/pages" class="inline-flex items-center px-4 py-2 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-300 hover:bg-slate-50 transition-colors mr-3">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </Link>
            <button 
                @click="submit" 
                :disabled="form.processing"
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-check-lg"></i>
                {{ isEdit ? 'Update Page' : 'Create Page' }}
            </button>
        </template>

        <div class="flex gap-6">
            <!-- Tabs Sidebar -->
            <div class="w-56 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    <nav class="p-2">
                        <button
                            v-for="tab in tabs"
                            :key="tab.key"
                            @click="activeTab = tab.key"
                            :class="[
                                'w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-left transition-colors',
                                activeTab === tab.key 
                                    ? 'bg-amber-50 text-amber-700' 
                                    : 'text-slate-600 hover:bg-slate-50'
                            ]"
                        >
                            <i :class="['bi', tab.icon]"></i>
                            <span class="font-medium">{{ tab.label }}</span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-1 max-w-3xl">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Content Tab -->
                    <div v-show="activeTab === 'content'" class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Page Information</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">URL Slug *</label>
                                <input 
                                    type="text" 
                                    v-model="form.slug" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" 
                                    required 
                                    :disabled="isEdit"
                                    placeholder="page-url"
                                >
                                <p class="text-xs text-slate-500 mt-1">URL: /{{ form.slug || 'slug' }}</p>
                            </div>

                            <BilingualInput v-model="form.title" label="Page Title" required />
                            <BilingualInput v-model="form.content" label="Page Content" type="textarea" />
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Settings</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Featured Image</label>
                                <input 
                                    type="text" 
                                    v-model="form.featured_image" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    placeholder="img/pages/about.jpg"
                                >
                                <p class="text-xs text-slate-500 mt-1">Path relative to /assets/paradise/</p>
                            </div>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    v-model="form.is_active" 
                                    class="w-4 h-4 text-amber-600 border-slate-300 rounded focus:ring-amber-500"
                                >
                                <span class="text-sm text-slate-700">Page is active (visible on website)</span>
                            </label>
                        </div>
                    </div>

                    <!-- SEO Tab -->
                    <div v-show="activeTab === 'seo'" class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">SEO Settings</h3>
                            <p class="text-sm text-slate-500 mb-4">Optimize this page for search engines</p>
                            
                            <BilingualInput v-model="form.meta_title" label="Meta Title" />
                            <p class="text-xs text-slate-500 -mt-2 mb-4">Recommended: 50-60 characters</p>
                            
                            <BilingualInput v-model="form.meta_description" label="Meta Description" type="textarea" />
                            <p class="text-xs text-slate-500 -mt-2 mb-4">Recommended: 150-160 characters</p>
                        </div>

                        <div class="bg-amber-50 rounded-xl border border-amber-200 p-6">
                            <div class="flex items-start gap-3">
                                <i class="bi bi-lightbulb text-amber-600 text-xl"></i>
                                <div>
                                    <h4 class="font-medium text-amber-800 mb-1">SEO Tips</h4>
                                    <ul class="text-sm text-amber-700 space-y-1">
                                        <li>• Include your main keyword in the title</li>
                                        <li>• Write a compelling description that encourages clicks</li>
                                        <li>• Keep titles under 60 characters for best display</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
