<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    testimonials: Array,
});

const deleteForm = useForm({});
const destroy = (item) => {
    if (confirm('Are you sure you want to delete this testimonial?')) {
        deleteForm.delete(`/admin/testimonials/${item.id}`);
    }
};
</script>

<template>
    <AdminLayout>
        <template #title>Testimonials</template>
        <template #actions>
            <Link 
                href="/admin/testimonials/create" 
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-plus-lg"></i>
                Add Testimonial
            </Link>
        </template>

        <!-- Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-if="!testimonials?.length" class="col-span-full bg-white rounded-xl shadow-sm border border-slate-200 py-12 text-center text-slate-500">
                <i class="bi bi-chat-quote text-4xl mb-2 block text-slate-300"></i>
                No testimonials found. Add your first testimonial.
            </div>
            
            <div 
                v-for="item in testimonials" 
                :key="item.id" 
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 relative"
            >
                <!-- Status Badge -->
                <span 
                    v-if="!item.is_active"
                    class="absolute top-4 right-4 px-2 py-0.5 text-xs bg-slate-100 text-slate-600 rounded"
                >
                    Hidden
                </span>
                
                <!-- Rating -->
                <div class="flex gap-0.5 mb-4">
                    <i 
                        v-for="n in 5" 
                        :key="n" 
                        :class="[
                            'bi',
                            n <= (item.rating || 5) ? 'bi-star-fill text-amber-400' : 'bi-star text-slate-300'
                        ]"
                    ></i>
                </div>
                
                <!-- Quote -->
                <p class="text-slate-600 mb-4 line-clamp-3">
                    "{{ item.content?.en || item.content || 'No content' }}"
                </p>
                
                <!-- Author -->
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-500 font-medium">
                        {{ item.name?.charAt(0)?.toUpperCase() || 'A' }}
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-slate-800">{{ item.name }}</div>
                        <div class="text-sm text-slate-500">{{ item.location || 'Guest' }}</div>
                    </div>
                    <div class="flex gap-1">
                        <Link 
                            :href="`/admin/testimonials/${item.id}/edit`" 
                            class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                            title="Edit"
                        >
                            <i class="bi bi-pencil"></i>
                        </Link>
                        <button 
                            @click="destroy(item)" 
                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                            title="Delete"
                        >
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
