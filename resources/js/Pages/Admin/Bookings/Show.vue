<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    booking: Object,
});

const statusForm = useForm({ status: props.booking.status });
const updateStatus = () => statusForm.put(`/admin/bookings/${props.booking.id}`);
</script>

<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold mb-6">Booking Details</h1>
        <div class="bg-white p-6 rounded shadow max-w-2xl space-y-3">
            <p><strong>Name:</strong> {{ booking.name }}</p>
            <p><strong>Email:</strong> {{ booking.email }}</p>
            <p><strong>Phone:</strong> {{ booking.phone }}</p>
            <p><strong>Room:</strong> {{ booking.room?.name }}</p>
            <p><strong>Check In:</strong> {{ booking.check_in }}</p>
            <p><strong>Check Out:</strong> {{ booking.check_out }}</p>
            <p><strong>Adults:</strong> {{ booking.adults }}</p>
            <p><strong>Children:</strong> {{ booking.children }}</p>
            <p><strong>Notes:</strong> {{ booking.notes }}</p>
            <div class="flex items-center gap-2">
                <strong>Status:</strong>
                <select v-model="statusForm.status" @change="updateStatus" class="border rounded px-2 py-1">
                    <option>pending</option>
                    <option>confirmed</option>
                    <option>cancelled</option>
                </select>
            </div>
            <p class="pt-4"><Link href="/admin/bookings" class="text-blue-600 hover:underline">Back to Bookings</Link></p>
        </div>
    </AdminLayout>
</template>
