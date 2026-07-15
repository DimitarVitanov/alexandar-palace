<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    users: Array,
});

const page = usePage();
const currentUserId = page.props.auth?.user?.id;

const deleteForm = useForm({});
const destroy = (user) => {
    if (user.id === currentUserId) {
        alert('You cannot delete your own account.');
        return;
    }
    if (confirm('Are you sure you want to delete this user?')) {
        deleteForm.delete(`/admin/users/${user.id}`);
    }
};
</script>

<template>
    <AdminLayout>
        <template #title>Users</template>
        <template #actions>
            <Link 
                href="/admin/users/create" 
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-plus-lg"></i>
                Add User
            </Link>
        </template>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-if="!users?.length">
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-people text-4xl mb-2 block text-slate-300"></i>
                                No users found.
                            </td>
                        </tr>
                        <tr v-for="user in users" :key="user.id" class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center text-white font-medium">
                                        {{ user.name?.charAt(0)?.toUpperCase() || 'U' }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ user.name }}</div>
                                        <div v-if="user.id === currentUserId" class="text-xs text-amber-600">You</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ user.email }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="[
                                    'px-2.5 py-1 text-xs font-medium rounded-full',
                                    user.is_admin ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-600'
                                ]">
                                    {{ user.is_admin ? 'Admin' : 'User' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link 
                                        :href="`/admin/users/${user.id}/edit`" 
                                        class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </Link>
                                    <button 
                                        v-if="user.id !== currentUserId"
                                        @click="destroy(user)" 
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
