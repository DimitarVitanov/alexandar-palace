<script setup>
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    contact: Object,
});

const deleteContact = () => {
    if (confirm('Delete this contact request?')) {
        router.delete(`/admin/celebration-contacts/${props.contact.id}`);
    }
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const eventTypeLabels = {
    wedding: 'Wedding',
    anniversary: 'Anniversary',
    birthday: 'Birthday Party',
    corporate: 'Corporate Event',
    other: 'Other',
};
</script>

<template>
    <AdminLayout>
        <template #title>Celebration Inquiry</template>
        <template #actions>
            <Link 
                href="/admin/celebration-contacts" 
                class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-arrow-left"></i>
                Back to List
            </Link>
        </template>

        <div class="max-w-3xl">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-800">
                                {{ eventTypeLabels[contact.event_type] || contact.event_type || 'Event Inquiry' }}
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">{{ formatDate(contact.created_at) }}</p>
                        </div>
                        <button 
                            @click="deleteContact" 
                            class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors flex items-center gap-2"
                        >
                            <i class="bi bi-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="px-6 py-4 border-b border-slate-200">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Name</label>
                            <p class="text-slate-800 font-medium mt-1">{{ contact.name }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Email</label>
                            <p class="mt-1">
                                <a :href="'mailto:' + contact.email" class="text-amber-600 hover:text-amber-700">
                                    {{ contact.email }}
                                </a>
                            </p>
                        </div>
                        <div v-if="contact.phone">
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Phone</label>
                            <p class="text-slate-800 mt-1">{{ contact.phone }}</p>
                        </div>
                        <div v-if="contact.event_type">
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Event Type</label>
                            <p class="mt-1">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">
                                    {{ eventTypeLabels[contact.event_type] || contact.event_type }}
                                </span>
                            </p>
                        </div>
                        <div v-if="contact.event_date">
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Event Date</label>
                            <p class="text-slate-800 mt-1">{{ new Date(contact.event_date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</p>
                        </div>
                        <div v-if="contact.guests">
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Number of Guests</label>
                            <p class="text-slate-800 mt-1">{{ contact.guests }}</p>
                        </div>
                    </div>
                </div>

                <!-- Message -->
                <div class="px-6 py-6">
                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wider block mb-3">Message</label>
                    <div class="bg-slate-50 rounded-lg p-4 text-slate-700 whitespace-pre-wrap leading-relaxed">
                        {{ contact.message }}
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                    <a 
                        :href="'mailto:' + contact.email + '?subject=Re: Your Celebration Inquiry at Aleksandar Palace'"
                        class="px-6 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors inline-flex items-center gap-2"
                    >
                        <i class="bi bi-reply"></i>
                        Reply via Email
                    </a>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
