<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layout.vue';

const form = useForm({
    name: { en: '', mk: '' },
    description: { en: '', mk: '' },
    surface_type: 'hard',
    is_indoor: false,
    has_lighting: true,
    price_per_hour: '',
    price_per_hour_peak: '',
    featured_image: '',
    is_active: true,
    sort_order: 0,
});

const surfaceTypes = [
    { value: 'hard', label: 'Hard Court' },
    { value: 'clay', label: 'Clay Court' },
    { value: 'grass', label: 'Grass Court' },
    { value: 'carpet', label: 'Carpet Court' },
];

const submit = () => {
    form.post('/admin/tennis/courts');
};
</script>

<template>
    <AdminLayout>
        <template #title>Create Tennis Court</template>
        <template #actions>
            <Link href="/admin/tennis/courts" class="btn-secondary">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </Link>
        </template>

        <form @submit.prevent="submit" class="max-w-4xl">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Court Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Name (English) *</label>
                        <input v-model="form.name.en" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        <p v-if="form.errors['name.en']" class="text-red-500 text-sm mt-1">{{ form.errors['name.en'] }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Name (Macedonian)</label>
                        <input v-model="form.name.mk" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Description (English)</label>
                        <textarea v-model="form.description.en" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Description (Macedonian)</label>
                        <textarea v-model="form.description.mk" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Court Specifications</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Surface Type *</label>
                        <select v-model="form.surface_type" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                            <option v-for="surface in surfaceTypes" :key="surface.value" :value="surface.value">{{ surface.label }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Price per Hour (€) *</label>
                        <input v-model="form.price_per_hour" type="number" step="0.01" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Peak Hour Price (€)</label>
                        <input v-model="form.price_per_hour_peak" type="number" step="0.01" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Settings</h3>
                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input v-model="form.is_active" type="checkbox" class="w-4 h-4 text-green-600 border-slate-300 rounded focus:ring-green-500">
                        <span class="text-sm text-slate-700">Active</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input v-model="form.is_indoor" type="checkbox" class="w-4 h-4 text-green-600 border-slate-300 rounded focus:ring-green-500">
                        <span class="text-sm text-slate-700">Indoor Court</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input v-model="form.has_lighting" type="checkbox" class="w-4 h-4 text-green-600 border-slate-300 rounded focus:ring-green-500">
                        <span class="text-sm text-slate-700">Has Lighting</span>
                    </label>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Sort Order</label>
                    <input v-model="form.sort_order" type="number" class="w-32 px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <Link href="/admin/tennis/courts" class="px-4 py-2 text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                    Cancel
                </Link>
                <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors disabled:opacity-50">
                    <i class="bi bi-check-lg mr-2"></i> Create Court
                </button>
            </div>
        </form>
    </AdminLayout>
</template>

