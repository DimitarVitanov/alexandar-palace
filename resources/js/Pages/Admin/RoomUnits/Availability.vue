<script setup>
import { ref } from 'vue';
import { useForm, Link, router } from '@inertiajs/vue3';
import Layout from '../Layout.vue';

const props = defineProps({
    unit: Object,
});

const showAddForm = ref(false);

const form = useForm({
    available_from: '',
    available_to: '',
    status: 'available',
    notes: '',
});

const editingId = ref(null);
const editForm = useForm({
    available_from: '',
    available_to: '',
    status: 'available',
    notes: '',
});

const submit = () => {
    form.post(`/admin/room-units/${props.unit.id}/availability`, {
        onSuccess: () => {
            form.reset();
            showAddForm.value = false;
        },
    });
};

const startEdit = (availability) => {
    editingId.value = availability.id;
    editForm.available_from = availability.available_from.split('T')[0];
    editForm.available_to = availability.available_to.split('T')[0];
    editForm.status = availability.status;
    editForm.notes = availability.notes || '';
};

const cancelEdit = () => {
    editingId.value = null;
    editForm.reset();
};

const updateAvailability = (id) => {
    editForm.put(`/admin/room-unit-availability/${id}`, {
        onSuccess: () => {
            editingId.value = null;
        },
    });
};

const deleteAvailability = (id) => {
    if (confirm('Are you sure you want to delete this availability period?')) {
        router.delete(`/admin/room-unit-availability/${id}`);
    }
};

const statusColors = {
    available: 'bg-green-100 text-green-800',
    blocked: 'bg-red-100 text-red-800',
    maintenance: 'bg-yellow-100 text-yellow-800',
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
};
</script>

<template>
    <Layout :title="`Availability - ${unit.unit_code}`">
        <div class="max-w-4xl">
            <div class="mb-6">
                <Link href="/admin/room-units" class="text-amber-600 hover:text-amber-800">
                    <i class="bi bi-arrow-left me-1"></i> Back to Room Units
                </Link>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-xl font-bold text-slate-800">
                            {{ unit.room.name }} - {{ unit.unit_code }}
                        </h1>
                        <p class="text-slate-600 mt-1">Manage availability periods for this room unit</p>
                    </div>
                    <button 
                        @click="showAddForm = !showAddForm"
                        class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 text-sm"
                    >
                        <i class="bi bi-plus-lg me-1"></i> Add Period
                    </button>
                </div>

                <!-- Add Form -->
                <div v-if="showAddForm" class="mt-6 p-4 bg-slate-50 rounded-lg border border-slate-200">
                    <h3 class="font-medium text-slate-800 mb-4">Add Availability Period</h3>
                    <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">From Date *</label>
                            <input v-model="form.available_from" type="date" required class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">To Date *</label>
                            <input v-model="form.available_to" type="date" required class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status *</label>
                            <select v-model="form.status" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                                <option value="available">Available</option>
                                <option value="blocked">Blocked</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Notes</label>
                            <input v-model="form.notes" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Optional notes">
                        </div>
                        <div class="md:col-span-2 flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700" :disabled="form.processing">
                                {{ form.processing ? 'Adding...' : 'Add Period' }}
                            </button>
                            <button type="button" @click="showAddForm = false" class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Availability List -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div v-if="unit.availabilities && unit.availabilities.length > 0" class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Period</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Notes</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <tr v-for="availability in unit.availabilities" :key="availability.id">
                                <template v-if="editingId === availability.id">
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            <input v-model="editForm.available_from" type="date" class="px-2 py-1 border rounded text-sm">
                                            <span class="text-slate-400">to</span>
                                            <input v-model="editForm.available_to" type="date" class="px-2 py-1 border rounded text-sm">
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <select v-model="editForm.status" class="px-2 py-1 border rounded text-sm">
                                            <option value="available">Available</option>
                                            <option value="blocked">Blocked</option>
                                            <option value="maintenance">Maintenance</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        <input v-model="editForm.notes" type="text" class="w-full px-2 py-1 border rounded text-sm">
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button @click="updateAvailability(availability.id)" class="text-green-600 hover:text-green-800 mr-2" :disabled="editForm.processing">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                        <button @click="cancelEdit" class="text-slate-600 hover:text-slate-800">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </td>
                                </template>
                                <template v-else>
                                    <td class="px-4 py-3">
                                        <span class="font-medium">{{ formatDate(availability.available_from) }}</span>
                                        <span class="text-slate-400 mx-2">to</span>
                                        <span class="font-medium">{{ formatDate(availability.available_to) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span :class="['px-2 py-1 text-xs font-medium rounded-full', statusColors[availability.status]]">
                                            {{ availability.status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 text-sm">{{ availability.notes || '-' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <button @click="startEdit(availability)" class="text-amber-600 hover:text-amber-800 mr-3">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button @click="deleteAvailability(availability.id)" class="text-red-600 hover:text-red-800">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="p-8 text-center text-slate-500">
                    <i class="bi bi-calendar-x text-4xl mb-2"></i>
                    <p>No availability periods configured.</p>
                    <p class="text-sm mt-1">Add periods to make this room available for booking.</p>
                </div>
            </div>
        </div>
    </Layout>
</template>
