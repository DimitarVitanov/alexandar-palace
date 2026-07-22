<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    groups: Array,
});

const form = useForm({
    group: '',
    key: '',
    value_en: '',
    value_mk: '',
});

const submit = () => {
    form.post('/admin/translations');
};
</script>

<template>
    <AdminLayout>
        <template #title>Add Translation</template>

        <div class="max-w-4xl">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Group</label>
                            <input 
                                v-model="form.group" 
                                type="text"
                                list="groups"
                                placeholder="e.g., nav, footer, home"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                :class="{ 'border-red-500': form.errors.group }"
                            >
                            <datalist id="groups">
                                <option v-for="g in groups" :key="g" :value="g">{{ g }}</option>
                            </datalist>
                            <p v-if="form.errors.group" class="mt-1 text-sm text-red-500">{{ form.errors.group }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Key</label>
                            <input 
                                v-model="form.key" 
                                type="text"
                                placeholder="e.g., hero_title, submit_button"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                :class="{ 'border-red-500': form.errors.key }"
                            >
                            <p v-if="form.errors.key" class="mt-1 text-sm text-red-500">{{ form.errors.key }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                            <span class="px-2 py-0.5 text-xs font-bold rounded bg-blue-100 text-blue-700">EN</span>
                            English
                        </label>
                        <textarea 
                            v-model="form.value_en" 
                            rows="3"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            :class="{ 'border-red-500': form.errors.value_en }"
                        ></textarea>
                        <p v-if="form.errors.value_en" class="mt-1 text-sm text-red-500">{{ form.errors.value_en }}</p>
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                            <span class="px-2 py-0.5 text-xs font-bold rounded bg-red-100 text-red-700">MK</span>
                            Macedonian
                        </label>
                        <textarea 
                            v-model="form.value_mk" 
                            rows="3"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            :class="{ 'border-red-500': form.errors.value_mk }"
                        ></textarea>
                        <p v-if="form.errors.value_mk" class="mt-1 text-sm text-red-500">{{ form.errors.value_mk }}</p>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-slate-200">
                        <button 
                            type="submit" 
                            class="px-6 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
                            :disabled="form.processing"
                        >
                            <i class="bi bi-plus-lg"></i>
                            Create Translation
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
