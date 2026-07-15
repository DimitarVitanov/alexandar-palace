<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    testimonial: { type: Object, default: null },
});

const isEdit = !!props.testimonial;

const form = useForm({
    name: props.testimonial?.name || '',
    location: props.testimonial?.location || '',
    photo: props.testimonial?.photo || '',
    comment: props.testimonial?.comment || '',
    rating: props.testimonial?.rating || 5,
    date: props.testimonial?.date?.split('T')[0] || new Date().toISOString().split('T')[0],
    is_active: props.testimonial?.is_active ?? true,
});

const submit = () => {
    if (isEdit) {
        form.put(`/admin/testimonials/${props.testimonial.id}`);
    } else {
        form.post('/admin/testimonials');
    }
};
</script>

<template>
    <AdminLayout>
        <template #title>{{ isEdit ? 'Edit Testimonial' : 'Add Testimonial' }}</template>
        <template #actions>
            <Link href="/admin/testimonials" class="inline-flex items-center px-4 py-2 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-300 hover:bg-slate-50 transition-colors mr-3">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </Link>
            <button 
                @click="submit" 
                :disabled="form.processing"
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-check-lg"></i>
                {{ isEdit ? 'Update' : 'Add Testimonial' }}
            </button>
        </template>

        <div class="max-w-3xl">
            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Guest Photo -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Guest Photo</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Photo Path</label>
                            <input 
                                type="text" 
                                v-model="form.photo" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="img/testimonials/guest.jpg"
                            >
                        </div>

                        <div v-if="form.photo" class="w-24 h-24 mx-auto bg-slate-100 rounded-full overflow-hidden">
                            <img 
                                :src="`/assets/paradise/${form.photo}`" 
                                :alt="form.name"
                                class="w-full h-full object-cover"
                                @error="$event.target.style.display='none'"
                            >
                        </div>
                        <div v-else class="w-24 h-24 mx-auto bg-slate-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-person text-4xl text-slate-300"></i>
                        </div>
                    </div>

                    <!-- Guest Details -->
                    <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Guest Information</h3>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Name *</label>
                                <input 
                                    type="text" 
                                    v-model="form.name" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    placeholder="John Smith"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Location</label>
                                <input 
                                    type="text" 
                                    v-model="form.location" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    placeholder="London, UK"
                                >
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Rating</label>
                                <div class="flex items-center gap-1">
                                    <button 
                                        v-for="star in 5" 
                                        :key="star"
                                        type="button"
                                        @click="form.rating = star"
                                        class="text-2xl transition-colors"
                                    >
                                        <i :class="['bi', star <= form.rating ? 'bi-star-fill text-amber-400' : 'bi-star text-slate-300']"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Date</label>
                                <input 
                                    type="date" 
                                    v-model="form.date" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comment -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Testimonial</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Comment *</label>
                        <textarea 
                            v-model="form.comment" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            rows="4"
                            placeholder="What did the guest say about their experience?"
                            required
                        ></textarea>
                    </div>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input 
                            type="checkbox" 
                            v-model="form.is_active" 
                            class="w-4 h-4 text-amber-600 border-slate-300 rounded focus:ring-amber-500"
                        >
                        <span class="text-sm text-slate-700">Show on website</span>
                    </label>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
