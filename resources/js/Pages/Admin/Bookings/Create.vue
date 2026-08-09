<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    rooms: Array,
});

const form = useForm({
    room_id: '',
    rooms_count: 1,
    name: '',
    email: '',
    phone: '',
    passport_id: '',
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
        form.total_price = (price * nights.value * Math.max(1, Number(form.rooms_count) || 1)).toFixed(2);
    }
};

const availability = ref({ checked: false, checking: false, available: false, availableRooms: 0, message: '' });

const checkAvailability = async () => {
    if (!form.room_id || !form.check_in || !form.check_out || nights.value < 1) {
        availability.value = { checked: false, checking: false, available: false, availableRooms: 0, message: '' };
        return;
    }

    availability.value.checking = true;

    try {
        const rooms = Math.max(1, Number(form.rooms_count) || 1);
        const response = await fetch(`/api/rooms/${form.room_id}/availability?check_in=${form.check_in}&check_out=${form.check_out}&rooms_count=${rooms}`);
        const data = await response.json();

        availability.value = {
            checked: true,
            checking: false,
            available: !!data.available,
            availableRooms: data.available_rooms ?? 0,
            message: data.message || '',
        };
    } catch (error) {
        availability.value = { checked: true, checking: false, available: false, availableRooms: 0, message: 'Could not check availability.' };
    }
};

watch([() => form.room_id, () => form.check_in, () => form.check_out, () => form.rooms_count], checkAvailability);

const blockedByAvailability = computed(() => availability.value.checked && !availability.value.available);

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
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Number of rooms *</label>
                        <input v-model.number="form.rooms_count" @change="calculateTotal" type="number" min="1" max="100" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" required>
                        <p v-if="form.errors.rooms_count" class="text-red-500 text-sm mt-1">{{ form.errors.rooms_count }}</p>
                    </div>
                </div>
                <div v-if="nights > 0" class="mt-4 p-3 bg-amber-50 rounded-lg">
                    <span class="text-amber-700 font-medium">{{ nights }} night(s)</span>
                </div>

                <div v-if="availability.checking" class="mt-4 flex items-center gap-2 rounded-lg bg-slate-50 border border-slate-200 px-3 py-2 text-sm text-slate-600">
                    <i class="bi bi-hourglass-split"></i> Checking availability...
                </div>
                <div v-else-if="availability.checked && availability.available" class="mt-4 flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 px-3 py-2 text-sm text-green-700">
                    <i class="bi bi-check-circle"></i>
                    {{ availability.availableRooms }} room(s) of this type available for these dates.
                </div>
                <div v-else-if="availability.checked" class="mt-4 flex items-center gap-2 rounded-lg bg-red-50 border border-red-200 px-3 py-2 text-sm text-red-700">
                    <i class="bi bi-x-circle"></i>
                    <span v-if="availability.availableRooms > 0">
                        Only {{ availability.availableRooms }} room(s) available for these dates — you requested {{ form.rooms_count }}.
                    </span>
                    <span v-else>No rooms of this type are available for these dates.</span>
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
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Passport / ID number</label>
                        <input v-model="form.passport_id" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <p v-if="form.errors.passport_id" class="text-red-500 text-sm mt-1">{{ form.errors.passport_id }}</p>
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
                <button type="submit" :disabled="form.processing || availability.checking || blockedByAvailability" class="px-6 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="bi bi-check-lg mr-2"></i> Create Booking
                </button>
            </div>
        </form>
    </AdminLayout>
</template>

