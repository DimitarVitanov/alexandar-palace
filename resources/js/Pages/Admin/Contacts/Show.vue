<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    contact: Object,
});
</script>

<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold mb-6">Contact Request</h1>
        <div class="bg-white p-6 rounded shadow max-w-2xl space-y-3">
            <p><strong>Name:</strong> {{ contact.name }}</p>
            <p><strong>Email:</strong> {{ contact.email }}</p>
            <p><strong>Phone:</strong> {{ contact.phone }}</p>
            <p><strong>Subject:</strong> {{ contact.subject }}</p>
            <p><strong>Message:</strong></p>
            <p class="whitespace-pre-wrap">{{ contact.message }}</p>
            <p class="pt-4"><Link href="/admin/contacts" class="text-blue-600 hover:underline">Back to Contacts</Link></p>
        </div>
    </AdminLayout>
</template>
