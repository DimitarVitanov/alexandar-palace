<script setup>
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import Layout from '../Layout.vue';

const props = defineProps({
    template: Object,
});

const form = useForm({
    name: props.template.name,
    subject: props.template.subject || { en: '', mk: '' },
    body: props.template.body || { en: '', mk: '' },
    is_active: props.template.is_active,
    recipient_emails: props.template.recipient_emails || [''],
});

const addRecipient = () => {
    form.recipient_emails.push('');
};

const removeRecipient = (index) => {
    form.recipient_emails.splice(index, 1);
};

const activeTab = ref('en');
const previewLocale = ref('en');
const preview = ref(null);

const submit = () => {
    form.put(`/admin/email-templates/${props.template.id}`);
};

const loadPreview = async () => {
    try {
        const response = await fetch(`/admin/email-templates/${props.template.id}/preview?locale=${previewLocale.value}`);
        preview.value = await response.json();
    } catch (e) {
        console.error('Preview failed', e);
    }
};
</script>

<template>
    <Layout title="Edit Email Template">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Edit Email Template</h1>
                    <p class="text-slate-500">{{ template.name }}</p>
                </div>
                <Link href="/admin/email-templates" class="text-slate-600 hover:text-slate-800">
                    <i class="bi bi-arrow-left"></i> Back to Templates
                </Link>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <form @submit.prevent="submit" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Template Name</label>
                            <input v-model="form.name" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                        </div>

                        <div class="mb-4">
                            <div class="flex gap-2 mb-2">
                                <button type="button" @click="activeTab = 'en'" :class="activeTab === 'en' ? 'bg-amber-600 text-white' : 'bg-slate-100'" class="px-3 py-1 rounded text-sm">
                                    English
                                </button>
                                <button type="button" @click="activeTab = 'mk'" :class="activeTab === 'mk' ? 'bg-amber-600 text-white' : 'bg-slate-100'" class="px-3 py-1 rounded text-sm">
                                    Macedonian
                                </button>
                            </div>

                            <div v-show="activeTab === 'en'">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Subject (English)</label>
                                    <input v-model="form.subject.en" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Body (English)</label>
                                    <textarea v-model="form.body.en" rows="12" class="w-full border border-slate-300 rounded-lg px-3 py-2 font-mono text-sm"></textarea>
                                </div>
                            </div>

                            <div v-show="activeTab === 'mk'">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Subject (Macedonian)</label>
                                    <input v-model="form.subject.mk" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Body (Macedonian)</label>
                                    <textarea v-model="form.body.mk" rows="12" class="w-full border border-slate-300 rounded-lg px-3 py-2 font-mono text-sm"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center gap-2">
                                <input v-model="form.is_active" type="checkbox" class="rounded" />
                                <span class="text-sm">Active</span>
                            </label>
                        </div>

                        <!-- Recipient Emails Section -->
                        <div class="mb-6 p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="flex justify-between items-center mb-3">
                                <label class="block text-sm font-medium text-slate-700">
                                    <i class="bi bi-envelope me-1"></i>
                                    Recipient Email Addresses
                                </label>
                                <button type="button" @click="addRecipient" class="text-sm text-amber-600 hover:text-amber-700">
                                    <i class="bi bi-plus-circle me-1"></i> Add Email
                                </button>
                            </div>
                            <p class="text-xs text-slate-500 mb-3">
                                These email addresses will receive notifications for this template type (e.g., booking confirmations, contact form submissions).
                            </p>
                            <div v-for="(email, index) in form.recipient_emails" :key="index" class="flex gap-2 mb-2">
                                <input 
                                    v-model="form.recipient_emails[index]" 
                                    type="email" 
                                    placeholder="email@example.com"
                                    class="flex-1 border border-slate-300 rounded-lg px-3 py-2 text-sm" 
                                />
                                <button 
                                    v-if="form.recipient_emails.length > 1"
                                    type="button" 
                                    @click="removeRecipient(index)" 
                                    class="px-3 py-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <div v-if="form.errors.recipient_emails" class="text-red-500 text-xs mt-1">
                                {{ form.errors.recipient_emails }}
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <Link href="/admin/email-templates" class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50">
                                Cancel
                            </Link>
                            <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 disabled:opacity-50">
                                {{ form.processing ? 'Saving...' : 'Save Template' }}
                            </button>
                        </div>
                    </form>
                </div>

                <div>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-4">
                        <h3 class="font-medium text-slate-800 mb-3">Available Variables</h3>
                        <div class="space-y-1">
                            <code v-for="variable in template.available_variables" :key="variable" class="block text-xs bg-slate-100 px-2 py-1 rounded">
                                {{ '{{' + variable + '}}' }}
                            </code>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                        <h3 class="font-medium text-slate-800 mb-3">Preview</h3>
                        <div class="flex gap-2 mb-3">
                            <select v-model="previewLocale" class="text-sm border border-slate-300 rounded px-2 py-1">
                                <option value="en">English</option>
                                <option value="mk">Macedonian</option>
                            </select>
                            <button @click="loadPreview" type="button" class="text-sm bg-slate-100 hover:bg-slate-200 px-3 py-1 rounded">
                                Load Preview
                            </button>
                        </div>
                        <div v-if="preview" class="text-sm">
                            <div class="font-medium text-slate-700 mb-2">Subject:</div>
                            <div class="bg-slate-50 p-2 rounded mb-3">{{ preview.subject }}</div>
                            <div class="font-medium text-slate-700 mb-2">Body:</div>
                            <pre class="bg-slate-50 p-2 rounded whitespace-pre-wrap text-xs">{{ preview.body }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
