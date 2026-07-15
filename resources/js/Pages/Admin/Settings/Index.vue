<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';
import BilingualInput from '@/Components/Admin/BilingualInput.vue';

const props = defineProps({
    settings: Object,
});

const form = useForm({
    settings: Object.fromEntries(
        Object.values(props.settings || {}).flat().map(s => [s.key, s.value])
    ),
});

const submit = () => {
    form.put('/admin/settings');
};

const groupIcons = {
    general: 'bi-gear',
    contact: 'bi-envelope',
    social: 'bi-share',
    seo: 'bi-search',
    hotel: 'bi-building',
    analytics: 'bi-graph-up',
    notifications: 'bi-bell',
};

const activeGroup = ref(Object.keys(props.settings || {})[0] || 'general');
</script>

<template>
    <AdminLayout>
        <template #title>Settings</template>
        <template #actions>
            <button 
                @click="submit" 
                :disabled="form.processing"
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-check-lg"></i>
                Save Settings
            </button>
        </template>

        <div class="flex gap-6">
            <!-- Settings Navigation -->
            <div class="w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-4 border-b border-slate-200">
                        <h3 class="font-semibold text-slate-800">Categories</h3>
                    </div>
                    <nav class="p-2">
                        <button
                            v-for="(group, groupName) in settings"
                            :key="groupName"
                            @click="activeGroup = groupName"
                            :class="[
                                'w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-left transition-colors capitalize',
                                activeGroup === groupName 
                                    ? 'bg-amber-50 text-amber-700' 
                                    : 'text-slate-600 hover:bg-slate-50'
                            ]"
                        >
                            <i :class="['bi', groupIcons[groupName] || 'bi-folder']"></i>
                            <span class="font-medium">{{ groupName }}</span>
                            <span class="ml-auto text-xs bg-slate-200 text-slate-600 px-1.5 py-0.5 rounded">
                                {{ group.length }}
                            </span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Settings Form -->
            <div class="flex-1">
                <form @submit.prevent="submit">
                    <div v-for="(group, groupName) in settings" :key="groupName" v-show="activeGroup === groupName">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h2 class="text-lg font-semibold text-slate-800 mb-6 capitalize flex items-center gap-2">
                                <i :class="['bi', groupIcons[groupName] || 'bi-folder', 'text-amber-500']"></i>
                                {{ groupName }} Settings
                            </h2>
                            
                            <div class="space-y-6">
                                <div v-for="setting in group" :key="setting.key">
                                    <template v-if="setting.type === 'bilingual'">
                                        <BilingualInput 
                                            v-model="form.settings[setting.key]" 
                                            :label="typeof setting.label === 'object' ? setting.label.en : setting.label" 
                                        />
                                    </template>
                                    <template v-else>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">
                                            {{ typeof setting.label === 'object' ? setting.label.en : setting.label }}
                                        </label>
                                        <input 
                                            v-if="setting.type === 'text' || setting.type === 'email' || setting.type === 'url'" 
                                            :type="setting.type" 
                                            v-model="form.settings[setting.key]" 
                                            class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                        >
                                        <textarea 
                                            v-else-if="setting.type === 'textarea'" 
                                            v-model="form.settings[setting.key]" 
                                            class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500" 
                                            rows="3"
                                        ></textarea>
                                        <p v-if="setting.description" class="text-xs text-slate-500 mt-1">{{ setting.description }}</p>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
