<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    user: { type: Object, default: null },
});

const isEdit = !!props.user;

const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    password: '',
    is_admin: props.user?.is_admin ?? false,
});

const submit = () => {
    if (isEdit) {
        form.put(`/admin/users/${props.user.id}`);
    } else {
        form.post('/admin/users');
    }
};
</script>

<template>
    <AdminLayout>
        <template #title>{{ isEdit ? 'Edit User' : 'Create User' }}</template>
        <template #actions>
            <Link href="/admin/users" class="inline-flex items-center px-4 py-2 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-300 hover:bg-slate-50 transition-colors mr-3">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </Link>
            <button 
                @click="submit" 
                :disabled="form.processing"
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-check-lg"></i>
                {{ isEdit ? 'Update User' : 'Create User' }}
            </button>
        </template>

        <div class="max-w-2xl">
            <form @submit.prevent="submit" class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">User Information</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Full Name *</label>
                        <input 
                            type="text" 
                            v-model="form.name" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" 
                            required
                            placeholder="John Smith"
                        >
                        <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email Address *</label>
                        <input 
                            type="email" 
                            v-model="form.email" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" 
                            required
                            placeholder="john@example.com"
                        >
                        <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Password {{ isEdit ? '(leave blank to keep current)' : '*' }}
                        </label>
                        <input 
                            type="password" 
                            v-model="form.password" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" 
                            :required="!isEdit"
                            placeholder="••••••••"
                        >
                        <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</p>
                        <p class="text-xs text-slate-500 mt-1">Minimum 8 characters</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Permissions</h3>
                    
                    <label class="flex items-center gap-3 p-4 rounded-lg border-2 cursor-pointer transition-all" :class="form.is_admin ? 'border-amber-500 bg-amber-50' : 'border-slate-200 hover:border-slate-300'">
                        <input 
                            type="checkbox" 
                            v-model="form.is_admin" 
                            class="w-5 h-5 text-amber-600 border-slate-300 rounded focus:ring-amber-500"
                        >
                        <div>
                            <span class="font-medium text-slate-800">Administrator</span>
                            <p class="text-sm text-slate-500">Can access admin panel and manage all content</p>
                        </div>
                    </label>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
