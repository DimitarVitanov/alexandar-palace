<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    items: Array,
});

const deleteForm = useForm({});
const destroy = (item) => {
    if (confirm('Are you sure you want to delete this image?')) {
        deleteForm.delete(`/admin/gallery/${item.id}`);
    }
};
</script>

<template>
    <AdminLayout>
        <template #title>Gallery</template>
        <template #actions>
            <Link 
                href="/admin/gallery/create" 
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-plus-lg"></i>
                Add Image
            </Link>
        </template>

        <!-- Grid View -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div v-if="!items?.length" class="py-12 text-center text-slate-500">
                <i class="bi bi-images text-4xl mb-2 block text-slate-300"></i>
                No images found. Add your first image.
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                <div 
                    v-for="item in items" 
                    :key="item.id" 
                    class="group relative aspect-square bg-slate-100 rounded-lg overflow-hidden"
                >
                    <img 
                        :src="`/assets/paradise/${item.image}`" 
                        :alt="item.title" 
                        class="w-full h-full object-cover"
                    >
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                        <div class="text-white text-sm font-medium text-center px-2">
                            {{ item.title || 'Untitled' }}
                        </div>
                        <span class="px-2 py-0.5 text-xs bg-white/20 text-white rounded">
                            {{ item.category || 'Uncategorized' }}
                        </span>
                        <div class="flex gap-2 mt-2">
                            <Link 
                                :href="`/admin/gallery/${item.id}/edit`" 
                                class="p-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors"
                                title="Edit"
                            >
                                <i class="bi bi-pencil text-white"></i>
                            </Link>
                            <button 
                                @click="destroy(item)" 
                                class="p-2 bg-white/20 hover:bg-red-500/80 rounded-lg transition-colors"
                                title="Delete"
                            >
                                <i class="bi bi-trash text-white"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <span 
                        v-if="!item.is_active"
                        class="absolute top-2 right-2 px-2 py-0.5 text-xs bg-slate-800/80 text-white rounded"
                    >
                        Hidden
                    </span>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
