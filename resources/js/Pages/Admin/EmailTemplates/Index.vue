<script setup>
import { Link } from '@inertiajs/vue3';
import Layout from '../Layout.vue';

defineProps({
    templates: Array,
});
</script>

<template>
    <Layout title="Email Templates">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Email Templates</h1>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-slate-500 border-b">
                            <th class="p-4">Template</th>
                            <th class="p-4">Key</th>
                            <th class="p-4">Recipients</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="template in templates" :key="template.id" class="border-b last:border-0 hover:bg-slate-50">
                            <td class="p-4">
                                <div class="font-medium text-slate-800">{{ template.name }}</div>
                                <div class="text-sm text-slate-500">{{ template.description }}</div>
                            </td>
                            <td class="p-4">
                                <code class="text-xs bg-slate-100 px-2 py-1 rounded">{{ template.key }}</code>
                            </td>
                            <td class="p-4">
                                <div v-if="template.recipient_emails?.length" class="space-y-1">
                                    <span v-for="email in template.recipient_emails" :key="email" class="block text-xs text-slate-600">
                                        <i class="bi bi-envelope me-1"></i>{{ email }}
                                    </span>
                                </div>
                                <span v-else class="text-xs text-slate-400 italic">No recipients set</span>
                            </td>
                            <td class="p-4">
                                <span :class="template.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 py-0.5 rounded text-xs">
                                    {{ template.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <Link :href="`/admin/email-templates/${template.id}/edit`" class="text-blue-600 hover:text-blue-800">
                                    <i class="bi bi-pencil"></i> Edit
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                <h3 class="font-medium text-amber-800 mb-2">Available Variables</h3>
                <p class="text-sm text-amber-700">
                    Use <code class="bg-amber-100 px-1 rounded">{{ '{{variable_name}}' }}</code> syntax in your templates. 
                    Each template shows its available variables in the edit form.
                </p>
            </div>
        </div>
    </Layout>
</template>
