<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    translation: Object,
    otherTranslation: Object,
});

const form = useForm({
    value: props.translation.value,
    other_value: props.otherTranslation?.value || '',
});

const submit = () => {
    form.put(`/admin/translations/${props.translation.id}`);
};

const otherLocale = props.translation.locale === 'en' ? 'mk' : 'en';
const otherLocaleName = otherLocale === 'en' ? 'English' : 'Macedonian';
const currentLocaleName = props.translation.locale === 'en' ? 'English' : 'Macedonian';
</script>

<template>
    <AdminLayout>
        <template #title>Edit Translation</template>

        <div class="max-w-4xl">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <div class="flex items-center gap-4 mb-6">
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-slate-100 text-slate-700">
                        {{ translation.group }}
                    </span>
                    <span class="font-mono text-slate-600">{{ translation.key }}</span>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Current locale -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                            <span :class="[
                                'px-2 py-0.5 text-xs font-bold rounded',
                                translation.locale === 'en' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700'
                            ]">
                                {{ translation.locale.toUpperCase() }}
                            </span>
                            {{ currentLocaleName }}
                        </label>
                        <textarea 
                            v-model="form.value" 
                            rows="3"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            :class="{ 'border-red-500': form.errors.value }"
                        ></textarea>
                        <p v-if="form.errors.value" class="mt-1 text-sm text-red-500">{{ form.errors.value }}</p>
                    </div>

                    <!-- Other locale -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                            <span :class="[
                                'px-2 py-0.5 text-xs font-bold rounded',
                                otherLocale === 'en' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700'
                            ]">
                                {{ otherLocale.toUpperCase() }}
                            </span>
                            {{ otherLocaleName }}
                            <span v-if="!otherTranslation" class="text-xs text-amber-600">(will be created)</span>
                        </label>
                        <textarea 
                            v-model="form.other_value" 
                            rows="3"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Leave empty to skip..."
                        ></textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-slate-200">
                        <button 
                            type="submit" 
                            class="px-6 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
                            :disabled="form.processing"
                        >
                            <i class="bi bi-check-lg"></i>
                            Save Changes
                        </button>
                        <Link 
                            href="/admin/translations" 
                            class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors"
                        >
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
