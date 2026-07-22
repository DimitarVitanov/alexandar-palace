<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    rooms: Array,
});

const deleteForm = useForm({});
const destroy = (room) => {
    if (confirm('Are you sure you want to delete this room?')) {
        deleteForm.delete(`/admin/rooms/${room.slug}`);
    }
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'EUR' }).format(price);
};
</script>

<template>
    <AdminLayout>
        <template #title>Rooms</template>
        <template #actions>
            <Link 
                href="/admin/rooms/create" 
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-plus-lg"></i>
                Add Room
            </Link>
        </template>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Room</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Capacity</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Featured</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!rooms?.length">
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-door-open text-4xl mb-2 block text-slate-300"></i>
                                No rooms found. Create your first room.
                            </td>
                        </tr>
                        <tr v-for="room in rooms" :key="room.id" class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-12 bg-slate-200 rounded-lg overflow-hidden flex-shrink-0">
                                        <img 
                                            v-if="room.featured_image" 
                                            :src="`/assets/paradise/${room.featured_image}`" 
                                            :alt="room.name"
                                            class="w-full h-full object-cover"
                                        >
                                        <div v-else class="w-full h-full flex items-center justify-center text-slate-400">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ room.name }}</div>
                                        <div class="text-sm text-slate-500">{{ room.slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-800">{{ formatPrice(room.price_per_night) }}</span>
                                <span class="text-sm text-slate-500">/night</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 text-sm font-semibold bg-blue-100 text-blue-700 rounded-full">
                                    {{ room.quantity || 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <span class="flex items-center gap-1">
                                    <i class="bi bi-people"></i>
                                    {{ room.max_guests || '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span v-if="room.is_featured" class="text-amber-500">
                                    <i class="bi bi-star-fill"></i>
                                </span>
                                <span v-else class="text-slate-300">
                                    <i class="bi bi-star"></i>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="[
                                    'px-2.5 py-1 text-xs font-medium rounded-full',
                                    room.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'
                                ]">
                                    {{ room.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link 
                                        :href="`/admin/rooms/${room.slug}/edit`" 
                                        class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button 
                                        @click="destroy(room)" 
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
        </div>
    </AdminLayout>
</template>
