<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    contacts: Object,
    filters: Object,
    emailRecipients: String,
});

const search = ref(props.filters?.search || '');
const showSettings = ref(false);

const recipientsForm = useForm({
    emails: props.emailRecipients,
});

const applyFilters = () => {
    router.get('/admin/congress-contacts', {
        search: search.value || undefined,
    }, { preserveState: true });
};

const deleteContact = (contact) => {
    if (confirm('Delete this contact request?')) {
        router.delete(`/admin/congress-contacts/${contact.id}`);
    }
};

const saveRecipients = () => {
    recipientsForm.post('/admin/congress-contacts/recipients', {
        onSuccess: () => {
            showSettings.value = false;
        }
    });
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <AdminLayout>
        <template #title>Congress Center Contacts</template>
        <template #actions>
            <button 
                @click="showSettings = !showSettings" 
                class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-gear"></i>
                Email Settings
            </button>
        </template>

        <!-- Email Settings Panel -->
        <div v-if="showSettings" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">
                <i class="bi bi-envelope-at me-2"></i>
                Email Recipients
            </h3>
            <p class="text-sm text-slate-500 mb-4">
                Enter email addresses (comma-separated) that should receive congress center contact requests.
            </p>
            <form @submit.prevent="saveRecipients" class="flex gap-4">
                <input 
                    v-model="recipientsForm.emails" 
                    type="text" 
                    placeholder="email1@example.com, email2@example.com"
                    class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                >
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors"
                    :disabled="recipientsForm.processing"
                >
                    Save
                </button>
            </form>
        </div>

        <!-- Search -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
            <div class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Search</label>
                    <input 
                        v-model="search" 
                        type="text" 
                        placeholder="Search by name, email, or subject..."
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        @keyup.enter="applyFilters"
                    >
                </div>
                <button 
                    @click="applyFilters" 
                    class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors"
                >
                    <i class="bi bi-search me-1"></i> Search
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-12"></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!contacts.data?.length">
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-inbox text-4xl mb-2 block text-slate-300"></i>
                                No contact requests yet.
                            </td>
                        </tr>
                        <tr 
                            v-for="contact in contacts.data" 
                            :key="contact.id" 
                            class="hover:bg-slate-50 transition-colors"
                            :class="{ 'bg-amber-50': !contact.is_read }"
                        >
                            <td class="px-6 py-4">
                                <span v-if="!contact.is_read" class="w-2 h-2 bg-amber-500 rounded-full inline-block" title="Unread"></span>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ contact.name }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <a :href="'mailto:' + contact.email" class="hover:text-amber-600">{{ contact.email }}</a>
                            </td>
                            <td class="px-6 py-4 text-slate-600 max-w-xs truncate">
                                {{ contact.subject }}
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-sm">
                                {{ formatDate(contact.created_at) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link 
                                        :href="`/admin/congress-contacts/${contact.id}`" 
                                        class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="View"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </Link>
                                    <button 
                                        @click="deleteContact(contact)" 
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
            <div v-if="contacts.last_page > 1" class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
                <p class="text-sm text-slate-500">
                    Showing {{ contacts.from }} to {{ contacts.to }} of {{ contacts.total }} contacts
                </p>
                <div class="flex gap-1">
                    <Link 
                        v-for="link in contacts.links" 
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
