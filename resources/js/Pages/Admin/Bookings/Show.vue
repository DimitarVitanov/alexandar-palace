<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    booking: Object,
});

const statusForm = useForm({ status: props.booking.status });
const updateStatus = () => statusForm.put(`/admin/bookings/${props.booking.id}`);

const formatDate = (date) => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('en-GB', { 
        day: '2-digit', 
        month: 'short', 
        year: 'numeric' 
    });
};

const getRoomName = (room) => {
    if (!room) return 'N/A';
    return typeof room.name === 'object' ? (room.name.en || room.name.mk) : room.name;
};
</script>

<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold mb-6">Booking Details</h1>
        <div class="bg-white p-6 rounded shadow max-w-2xl space-y-3">
            <p><strong>Reference:</strong> <span class="text-amber-600 font-mono">{{ booking.booking_reference }}</span></p>
            <p><strong>Name:</strong> {{ booking.name }} {{ booking.last_name }}</p>
            <p><strong>Email:</strong> {{ booking.email }}</p>
            <p><strong>Phone:</strong> {{ booking.phone }}</p>
            <p><strong>Room:</strong> {{ getRoomName(booking.room) }}</p>
            <p v-if="booking.room_unit"><strong>Room Number:</strong> <span class="text-amber-600 font-semibold">{{ booking.room_unit.unit_code }}</span></p>
            <p v-else-if="booking.status === 'pending'" class="text-slate-400 text-sm italic">Room unit will be assigned when booking is confirmed</p>
            <p><strong>Check In:</strong> {{ formatDate(booking.check_in) }}</p>
            <p><strong>Check Out:</strong> {{ formatDate(booking.check_out) }}</p>
            <p><strong>Adults:</strong> {{ booking.adults }}</p>
            <p><strong>Children:</strong> {{ booking.children }}</p>
            <p><strong>Special Requests:</strong> {{ booking.special_requests || booking.notes || '-' }}</p>
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
