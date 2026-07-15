<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen flex" style="font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;">
        <!-- Left Panel - Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);">
            <!-- Decorative background pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-20 left-20 w-64 h-64 rounded-full" style="background: radial-gradient(circle, #f59e0b, transparent);"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 rounded-full" style="background: radial-gradient(circle, #f59e0b, transparent);"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 rounded-full" style="background: radial-gradient(circle, #f59e0b, transparent);"></div>
            </div>

            <!-- Grid lines -->
            <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(#f59e0b 1px, transparent 1px), linear-gradient(90deg, #f59e0b 1px, transparent 1px); background-size: 60px 60px;"></div>

            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                <!-- Logo top -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="bi bi-building text-white text-lg"></i>
                    </div>
                    <div>
                        <div class="text-white font-bold text-lg leading-tight">Alexandar Palace</div>
                        <div class="text-xs" style="color: #f59e0b;">Admin Portal</div>
                    </div>
                </div>

                <!-- Center content -->
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium mb-6" style="background: rgba(245,158,11,0.15); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3);">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        Secure Management System
                    </div>
                    <h1 class="text-4xl font-bold text-white leading-tight mb-4">
                        Welcome to your<br>
                        <span style="color: #f59e0b;">Control Center</span>
                    </h1>
                    <p class="text-slate-400 text-lg leading-relaxed">
                        Manage rooms, bookings, content, and operations from one powerful dashboard.
                    </p>

                    <!-- Feature list -->
                    <div class="mt-8 space-y-3">
                        <div v-for="feature in ['Full content management', 'Real-time booking control', 'Multi-language support', 'Analytics & reporting']" :key="feature" class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0" style="background: rgba(245,158,11,0.2);">
                                <i class="bi bi-check text-xs" style="color: #f59e0b;"></i>
                            </div>
                            <span class="text-slate-300 text-sm">{{ feature }}</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom -->
                <div class="text-slate-600 text-sm">
                    © {{ new Date().getFullYear() }} Alexandar Palace. All rights reserved.
                </div>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8" style="background: #f8fafc;">
            <div class="w-full max-w-md">
                <!-- Mobile logo -->
                <div class="flex items-center gap-3 mb-8 lg:hidden">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="bi bi-building text-white text-lg"></i>
                    </div>
                    <div class="font-bold text-lg text-slate-800">Alexandar Palace</div>
                </div>

                <!-- Form card -->
                <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-slate-900">Sign in</h2>
                        <p class="text-slate-500 mt-1">Enter your credentials to access the admin panel</p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-5">
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="bi bi-envelope text-slate-400"></i>
                                </div>
                                <input 
                                    type="email" 
                                    v-model="form.email" 
                                    class="w-full pl-10 pr-4 py-3 border rounded-xl text-slate-800 placeholder-slate-400 transition-all outline-none"
                                    :class="form.errors.email ? 'border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-200' : 'border-slate-200 bg-slate-50 focus:border-amber-500 focus:ring-2 focus:ring-amber-100 focus:bg-white'"
                                    placeholder="admin@alexandarpalace.com"
                                    required
                                    autocomplete="email"
                                >
                            </div>
                            <p v-if="form.errors.email" class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="bi bi-lock text-slate-400"></i>
                                </div>
                                <input 
                                    :type="showPassword ? 'text' : 'password'" 
                                    v-model="form.password" 
                                    class="w-full pl-10 pr-12 py-3 border rounded-xl text-slate-800 placeholder-slate-400 transition-all outline-none"
                                    :class="form.errors.password ? 'border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-200' : 'border-slate-200 bg-slate-50 focus:border-amber-500 focus:ring-2 focus:ring-amber-100 focus:bg-white'"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="current-password"
                                >
                                <button 
                                    type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
                                >
                                    <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember me -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    v-model="form.remember" 
                                    class="w-4 h-4 rounded border-slate-300 text-amber-500 focus:ring-amber-400"
                                >
                                <span class="text-sm text-slate-600">Keep me signed in</span>
                            </label>
                        </div>

                        <!-- Submit -->
                        <button 
                            type="submit" 
                            :disabled="form.processing"
                            class="w-full py-3 px-4 rounded-xl font-semibold text-white transition-all flex items-center justify-center gap-2 mt-2"
                            style="background: linear-gradient(135deg, #f59e0b, #d97706);"
                            :style="form.processing ? 'opacity: 0.7; cursor: not-allowed;' : 'opacity: 1;'"
                        >
                            <svg v-if="form.processing" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            <i v-else class="bi bi-box-arrow-in-right"></i>
                            {{ form.processing ? 'Signing in...' : 'Sign in to Dashboard' }}
                        </button>
                    </form>
                </div>

                <!-- Back to site -->
                <div class="text-center mt-6">
                    <a href="/" class="text-sm text-slate-500 hover:text-slate-700 transition-colors inline-flex items-center gap-1.5">
                        <i class="bi bi-arrow-left text-xs"></i>
                        Back to website
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
