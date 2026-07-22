<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    translations: Object,
    groups: Array,
    filters: Object,
});

const search = ref(props.filters?.search || '');
const group = ref(props.filters?.group || '');
const locale = ref(props.filters?.locale || '');

const applyFilters = () => {
    router.get('/admin/translations', {
        search: search.value || undefined,
        group: group.value || undefined,
        locale: locale.value || undefined,
    }, { preserveState: true });
};

const syncTranslations = () => {
    if (confirm('This will import any missing default translations. Existing translations will not be overwritten. Continue?')) {
        router.post('/admin/translations/sync');
    }
};

const deleteTranslation = (translation) => {
    if (confirm(`Delete translation "${translation.group}.${translation.key}" in both languages?`)) {
        router.delete(`/admin/translations/${translation.id}`);
    }
};

const groupLabels = {
    nav: 'Navigation',
    footer: 'Footer',
    home: 'Homepage',
    contact: 'Contact Page',
    restaurant: 'Restaurant',
    about: 'About Page',
    admin: 'Admin Panel',
};
</script>

<template>
    <AdminLayout>
        <template #title>Translations</template>
        <template #actions>
            <button 
                @click="syncTranslations" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 mr-2"
            >
                <i class="bi bi-arrow-repeat"></i>
                Sync Defaults
            </button>
            <Link 
                href="/admin/translations/create" 
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-plus-lg"></i>
                Add Translation
            </Link>
        </template>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Search</label>
                    <input 
                        v-model="search" 
                        type="text" 
                        placeholder="Search key or value..."
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        @keyup.enter="applyFilters"
                    >
                </div>
                <div class="w-48">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Group</label>
                    <select 
                        v-model="group" 
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        @change="applyFilters"
                    >
                        <option value="">All Groups</option>
                        <option v-for="g in groups" :key="g" :value="g">{{ groupLabels[g] || g }}</option>
                    </select>
                </div>
                <div class="w-32">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Language</label>
                    <select 
                        v-model="locale" 
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        @change="applyFilters"
                    >
                        <option value="">All</option>
                        <option value="en">English</option>
                        <option value="mk">Macedonian</option>
                    </select>
                </div>
                <button 
                    @click="applyFilters" 
                    class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors"
                >
                    <i class="bi bi-search me-1"></i> Filter
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Group</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Key</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-20">Lang</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Value</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!translations.data?.length">
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-translate text-4xl mb-2 block text-slate-300"></i>
                                No translations found. Click "Sync Defaults" to import default translations.
                            </td>
                        </tr>
                        <tr v-for="translation in translations.data" :key="translation.id" class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700">
                                    {{ groupLabels[translation.group] || translation.group }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono text-sm text-slate-600">
                                {{ translation.key }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="[
                                    'px-2 py-0.5 text-xs font-bold rounded',
                                    translation.locale === 'en' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700'
                                ]">
                                    {{ translation.locale.toUpperCase() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-800 max-w-md truncate">
                                {{ translation.value }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link 
                                        :href="`/admin/translations/${translation.id}/edit`" 
                                        class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button 
                                        @click="deleteTranslation(translation)" 
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

            <!-- Pagination -->
            <div v-if="translations.last_page > 1" class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
                <p class="text-sm text-slate-500">
                    Showing {{ translations.from }} to {{ translations.to }} of {{ translations.total }} translations
                </p>
                <div class="flex gap-1">
                    <Link 
                        v-for="link in translations.links" 
                        :key="link.label"
                        :href="link.url || '#'"
                        :class="[
                            'px-3 py-1 text-sm rounded',
                            link.active ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200',
                            !link.url ? 'opacity-50 cursor-not-allowed' : ''
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
