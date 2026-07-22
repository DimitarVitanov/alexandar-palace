<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import Layout from '../Layout.vue';

const props = defineProps({
    room: Object,
    unit: Object,
});

const form = useForm({
    unit_code: props.unit?.unit_code || '',
    floor: props.unit?.floor || '',
    notes: props.unit?.notes || '',
    is_active: props.unit?.is_active ?? true,
    available_from: '',
    available_to: '',
});

const submit = () => {
    if (props.unit) {
        form.put(`/admin/room-units/${props.unit.id}`);
    } else {
        form.post(`/admin/rooms/${props.room.id}/units`);
    }
};
</script>

<template>
    <Layout :title="unit ? 'Edit Room Unit' : 'Add Room Unit'">
        <div class="max-w-2xl">
            <div class="mb-6">
                <Link href="/admin/room-units" class="text-amber-600 hover:text-amber-800">
                    <i class="bi bi-arrow-left me-1"></i> Back to Room Units
                </Link>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h1 class="text-xl font-bold text-slate-800 mb-2">
                    {{ unit ? 'Edit Room Unit' : 'Add Room Unit' }}
                </h1>
                <p class="text-slate-600 mb-6">Room Type: <strong>{{ room.name }}</strong></p>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Unit Code *</label>
                        <input 
                            v-model="form.unit_code" 
                            type="text" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500"
                            placeholder="e.g., A7, 101, B12"
                            required
                        >
                        <p class="text-xs text-slate-500 mt-1">Unique identifier for this physical room</p>
                        <div v-if="form.errors.unit_code" class="text-red-600 text-sm mt-1">{{ form.errors.unit_code }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Floor</label>
                        <input 
                            v-model="form.floor" 
                            type="text" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500"
                            placeholder="e.g., 1, 2, Ground"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Internal Notes</label>
                        <textarea 
                            v-model="form.notes" 
                            rows="3"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500"
                            placeholder="Any internal notes about this room..."
                        ></textarea>
                    </div>

                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" v-model="form.is_active" class="rounded">
                            <span class="text-sm text-slate-700">Active (available for booking)</span>
                        </label>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button 
                            type="submit" 
                            class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'Saving...' : (unit ? 'Update Unit' : 'Create Unit') }}
                        </button>
                        <Link href="/admin/room-units" class="px-6 py-2 border border-slate-300 rounded-lg hover:bg-slate-50">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>
