<script setup>
import { Link } from '@inertiajs/vue3';
import Layout from '../Layout.vue';

defineProps({
    rooms: Array,
});
</script>

<template>
    <Layout title="Room Units">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Room Units Management</h1>
            <p class="text-slate-600 mt-1">Manage individual physical rooms and their availability</p>
        </div>

        <div v-for="room in rooms" :key="room.id" class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6">
            <div class="p-4 border-b border-slate-200 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">{{ room.name }}</h2>
                    <p class="text-sm text-slate-500">{{ room.units?.length || 0 }} units configured</p>
                </div>
                <Link :href="`/admin/rooms/${room.id}/units/create`" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 text-sm">
                    <i class="bi bi-plus-lg me-1"></i> Add Unit
                </Link>
            </div>
            
            <div v-if="room.units && room.units.length > 0" class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Unit Code</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Floor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Availability Periods</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Bookings</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr v-for="unit in room.units" :key="unit.id">
                            <td class="px-4 py-3">
                                <span class="font-mono font-semibold text-slate-800">{{ unit.unit_code }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ unit.floor || '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-slate-600">{{ unit.availabilities_count }} periods</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-slate-600">{{ unit.bookings_count }} bookings</span>
                            </td>
                            <td class="px-4 py-3">
                                <span v-if="unit.is_active" class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                                <span v-else class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded-full">Inactive</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <Link :href="`/admin/room-units/${unit.id}/availability`" class="text-blue-600 hover:text-blue-800 mr-3" title="Manage Availability">
                                    <i class="bi bi-calendar3"></i>
                                </Link>
                                <Link :href="`/admin/room-units/${unit.id}/edit`" class="text-amber-600 hover:text-amber-800 mr-3" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="p-8 text-center text-slate-500">
                <i class="bi bi-door-open text-4xl mb-2"></i>
                <p>No units configured for this room type yet.</p>
                <p class="text-sm mt-1">Add units to enable individual room availability tracking.</p>
            </div>
        </div>
    </Layout>
</template>
