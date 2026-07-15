<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    rooms: Array,
});

const form = useForm({
    room_id: '',
    name: '',
    email: '',
    phone: '',
    check_in: '',
    check_out: '',
    adults: 1,
    children: 0,
    total_price: '',
    deposit_amount: '',
    notes: '',
    special_requests: '',
    status: 'pending',
    payment_status: 'unpaid',
    payment_method: '',
});

const selectedRoom = computed(() => {
    return props.rooms?.find(r => r.id == form.room_id);
});

const nights = computed(() => {
    if (!form.check_in || !form.check_out) return 0;
    const start = new Date(form.check_in);
    const end = new Date(form.check_out);
    return Math.ceil((end - start) / (1000 * 60 * 60 * 24));
});

const calculateTotal = () => {
    if (selectedRoom.value && nights.value > 0) {
        const price = selectedRoom.value.discounted_price || selectedRoom.value.price_per_night;
        form.total_price = (price * nights.value).toFixed(2);
    }
};

const submit = () => {
    form.post('/admin/bookings');
};

const getRoomName = (room) => {
    return typeof room.name === 'object' ? room.name.en : room.name;
};
</script>

<template>
    <AdminLayout>
        <template #title>Create Booking</template>
        <template #actions>
            <Link href="/admin/bookings" class="btn-secondary">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </Link>
        </template>

        <form @submit.prevent="submit" class="max-w-4xl">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Room Selection</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Room *</label>
                        <select v-model="form.room_id" @change="calculateTotal" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" required>
                            <option value="">Select a room</option>
                            <option v-for="room in rooms" :key="room.id" :value="room.id">
                                {{ getRoomName(room) }} - €{{ room.price_per_night }}/night ({{ room.total_units || 1 }} units)
                            </option>
                        </select>
                        <p v-if="form.errors.room_id" class="text-red-500 text-sm mt-1">{{ form.errors.room_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Check-in *</label>
                        <input v-model="form.check_in" @change="calculateTotal" type="date" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" required>
                        <p v-if="form.errors.check_in" class="text-red-500 text-sm mt-1">{{ form.errors.check_in }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Check-out *</label>
                        <input v-model="form.check_out" @change="calculateTotal" type="date" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" required>
                        <p v-if="form.errors.check_out" class="text-red-500 text-sm mt-1">{{ form.errors.check_out }}</p>
                    </div>
                </div>
                <div v-if="nights > 0" class="mt-4 p-3 bg-amber-50 rounded-lg">
                    <span class="text-amber-700 font-medium">{{ nights }} night(s)</span>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Guest Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Full Name *</label>
                        <input v-model="form.name" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" required>
                        <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email *</label>
                        <input v-model="form.email" type="email" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" required>
                        <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
                        <input v-model="form.phone" type="tel" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Adults *</label>
                            <input v-model="form.adults" type="number" min="1" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Children</label>
                            <input v-model="form.children" type="number" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Payment & Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Total Price (€)</label>
                        <input v-model="form.total_price" type="number" step="0.01" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deposit Amount (€)</label>
                        <input v-model="form.deposit_amount" type="number" step="0.01" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select v-model="form.status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Payment Status</label>
                        <select v-model="form.payment_status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="unpaid">Unpaid</option>
                            <option value="partial">Partial</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Payment Method</label>
                        <select v-model="form.payment_method" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Not specified</option>
                            <option value="cash">Cash</option>
                            <option value="card">Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="online">Online Payment</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Additional Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Notes</label>
                        <textarea v-model="form.notes" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Special Requests</label>
                        <textarea v-model="form.special_requests" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <Link href="/admin/bookings" class="px-4 py-2 text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                    Cancel
                </Link>
                <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors disabled:opacity-50">
                    <i class="bi bi-check-lg mr-2"></i> Create Booking
                </button>
            </div>
        </form>
    </AdminLayout>
</template>

