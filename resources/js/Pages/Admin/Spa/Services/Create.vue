<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layout.vue';

const form = useForm({
    name: { en: '', mk: '' },
    description: { en: '', mk: '' },
    duration_minutes: 60,
    price: '',
    discounted_price: '',
    category: 'massage',
    featured_image: '',
    max_guests: 1,
    is_active: true,
    is_featured: false,
    sort_order: 0,
});

const categories = [
    { value: 'massage', label: 'Massage' },
    { value: 'facial', label: 'Facial' },
    { value: 'body', label: 'Body Treatment' },
    { value: 'wellness', label: 'Wellness' },
    { value: 'beauty', label: 'Beauty' },
];

const submit = () => {
    form.post('/admin/spa/services');
};
</script>

<template>
    <AdminLayout>
        <template #title>Create Spa Service</template>
        <template #actions>
            <Link href="/admin/spa/services" class="btn-secondary">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </Link>
        </template>

        <form @submit.prevent="submit" class="max-w-4xl">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Service Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Name (English) *</label>
                        <input v-model="form.name.en" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                        <p v-if="form.errors['name.en']" class="text-red-500 text-sm mt-1">{{ form.errors['name.en'] }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Name (Macedonian)</label>
                        <input v-model="form.name.mk" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Description (English)</label>
                        <textarea v-model="form.description.en" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Description (Macedonian)</label>
                        <textarea v-model="form.description.mk" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Pricing & Duration</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Category *</label>
                        <select v-model="form.category" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                            <option v-for="cat in categories" :key="cat.value" :value="cat.value">{{ cat.label }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Duration (minutes) *</label>
                        <input v-model="form.duration_minutes" type="number" min="15" step="15" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Max Guests *</label>
                        <input v-model="form.max_guests" type="number" min="1" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Price (€) *</label>
                        <input v-model="form.price" type="number" step="0.01" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Discounted Price (€)</label>
                        <input v-model="form.discounted_price" type="number" step="0.01" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Sort Order</label>
                        <input v-model="form.sort_order" type="number" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Settings</h3>
                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input v-model="form.is_active" type="checkbox" class="w-4 h-4 text-purple-600 border-slate-300 rounded focus:ring-purple-500">
                        <span class="text-sm text-slate-700">Active</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input v-model="form.is_featured" type="checkbox" class="w-4 h-4 text-purple-600 border-slate-300 rounded focus:ring-purple-500">
                        <span class="text-sm text-slate-700">Featured</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <Link href="/admin/spa/services" class="px-4 py-2 text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                    Cancel
                </Link>
                <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors disabled:opacity-50">
                    <i class="bi bi-check-lg mr-2"></i> Create Service
                </button>
            </div>
        </form>
    </AdminLayout>
</template>

