<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';
import BilingualInput from '@/Components/Admin/BilingualInput.vue';

const props = defineProps({
    item: { type: Object, default: null },
    categories: { type: Array, default: () => ['Rooms', 'Restaurant', 'Spa', 'Pool', 'Exterior', 'Events'] },
});

const isEdit = !!props.item;

const form = useForm({
    category: props.item?.category || '',
    image: props.item?.image || '',
    title: props.item?.title || { en: '', mk: '' },
    description: props.item?.description || { en: '', mk: '' },
    sort_order: props.item?.sort_order || 0,
    is_active: props.item?.is_active ?? true,
});

const submit = () => {
    if (isEdit) {
        form.put(`/admin/gallery/${props.item.id}`);
    } else {
        form.post('/admin/gallery');
    }
};
</script>

<template>
    <AdminLayout>
        <template #title>{{ isEdit ? 'Edit Gallery Item' : 'Add Gallery Item' }}</template>
        <template #actions>
            <Link href="/admin/gallery" class="inline-flex items-center px-4 py-2 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-300 hover:bg-slate-50 transition-colors mr-3">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </Link>
            <button 
                @click="submit" 
                :disabled="form.processing"
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-check-lg"></i>
                {{ isEdit ? 'Update Item' : 'Add Item' }}
            </button>
        </template>

        <div class="max-w-3xl">
            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Image Preview -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Image</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Image Path *</label>
                            <input 
                                type="text" 
                                v-model="form.image" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="img/gallery/photo.jpg"
                                required
                            >
                            <p class="text-xs text-slate-500 mt-1">Path relative to /assets/paradise/</p>
                        </div>

                        <div v-if="form.image" class="aspect-video bg-slate-100 rounded-lg overflow-hidden">
                            <img 
                                :src="`/assets/paradise/${form.image}`" 
                                :alt="form.title?.en || 'Gallery image'"
                                class="w-full h-full object-cover"
                                @error="$event.target.style.display='none'"
                            >
                        </div>
                        <div v-else class="aspect-video bg-slate-50 rounded-lg border-2 border-dashed border-slate-200 flex items-center justify-center">
                            <div class="text-center text-slate-400">
                                <i class="bi bi-image text-4xl mb-2 block"></i>
                                <span class="text-sm">Enter image path to preview</span>
                            </div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Details</h3>
                        
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

                        <BilingualInput v-model="form.title" label="Title (Optional)" />
                        <BilingualInput v-model="form.description" label="Description (Optional)" />

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Sort Order</label>
                                <input 
                                    type="number" 
                                    v-model="form.sort_order" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                >
                            </div>
                            <div class="flex items-end pb-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        v-model="form.is_active" 
                                        class="w-4 h-4 text-amber-600 border-slate-300 rounded focus:ring-amber-500"
                                    >
                                    <span class="text-sm text-slate-700">Active</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
