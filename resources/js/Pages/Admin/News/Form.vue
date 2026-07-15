<script setup>
import { ref, watch } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';
import BilingualInput from '@/Components/Admin/BilingualInput.vue';

const props = defineProps({
    news: { type: Object, default: null },
    categories: { type: Array, default: () => ['News', 'Events', 'Promotions', 'Announcements'] },
});

const isEdit = !!props.news;

const form = useForm({
    slug: props.news?.slug || '',
    title: props.news?.title || { en: '', mk: '' },
    excerpt: props.news?.excerpt || { en: '', mk: '' },
    content: props.news?.content || { en: '', mk: '' },
    category: props.news?.category || '',
    featured_image: props.news?.featured_image || '',
    published_at: props.news?.published_at?.split('T')[0] || new Date().toISOString().split('T')[0],
    is_active: props.news?.is_active ?? true,
    is_featured: props.news?.is_featured ?? false,
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
        form.put(`/admin/news/${props.news.id}`);
    } else {
        form.post('/admin/news');
    }
};
</script>

<template>
    <AdminLayout>
        <template #title>{{ isEdit ? 'Edit Article' : 'Create Article' }}</template>
        <template #actions>
            <Link href="/admin/news" class="inline-flex items-center px-4 py-2 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-300 hover:bg-slate-50 transition-colors mr-3">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </Link>
            <button 
                @click="submit" 
                :disabled="form.processing"
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-check-lg"></i>
                {{ isEdit ? 'Update Article' : 'Publish Article' }}
            </button>
        </template>

        <div class="max-w-4xl">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Main Content -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Article Content</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">URL Slug *</label>
                        <input 
                            type="text" 
                            v-model="form.slug" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" 
                            required 
                            :disabled="isEdit"
                            placeholder="article-title"
                        >
                        <p class="text-xs text-slate-500 mt-1">URL: /news/{{ form.slug || 'slug' }}</p>
                    </div>

                    <BilingualInput v-model="form.title" label="Title" required />
                    <BilingualInput v-model="form.excerpt" label="Excerpt / Summary" />
                    <BilingualInput v-model="form.content" label="Full Content" type="textarea" />
                </div>

                <!-- Publishing Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Publishing</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                            <select 
                                v-model="form.category" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            >
                                <option value="">Select category...</option>
                                <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Publish Date</label>
                            <input 
                                type="date" 
                                v-model="form.published_at" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            >
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    v-model="form.is_active" 
                                    class="w-4 h-4 text-amber-600 border-slate-300 rounded focus:ring-amber-500"
                                >
                                <span class="text-sm text-slate-700">Published</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    v-model="form.is_featured" 
                                    class="w-4 h-4 text-amber-600 border-slate-300 rounded focus:ring-amber-500"
                                >
                                <span class="text-sm text-slate-700">Featured article</span>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Featured Image</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Image Path</label>
                            <input 
                                type="text" 
                                v-model="form.featured_image" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="img/news/article.jpg"
                            >
                            <p class="text-xs text-slate-500 mt-1">Path relative to /assets/paradise/</p>
                        </div>

                        <div v-if="form.featured_image" class="mt-4">
                            <div class="w-full h-40 bg-slate-100 rounded-lg overflow-hidden">
                                <img 
                                    :src="`/assets/paradise/${form.featured_image}`" 
                                    :alt="form.title.en"
                                    class="w-full h-full object-cover"
                                    @error="$event.target.style.display='none'"
                                >
                            </div>
                        </div>
                        <div v-else class="mt-4 w-full h-40 bg-slate-50 rounded-lg border-2 border-dashed border-slate-200 flex items-center justify-center">
                            <div class="text-center text-slate-400">
                                <i class="bi bi-image text-3xl mb-2 block"></i>
                                <span class="text-sm">No image selected</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
