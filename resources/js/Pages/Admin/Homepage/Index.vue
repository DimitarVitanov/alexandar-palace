<script setup>
import { ref, reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';
import BilingualInput from '@/Components/Admin/BilingualInput.vue';

const props = defineProps({
    homepage: Object,
    sections: Object,
    sectionTypes: Object,
});

const activeTab = ref('hero');

const tabs = [
    { key: 'hero', label: 'Hero Section', icon: 'bi-image' },
    { key: 'about', label: 'About Us', icon: 'bi-info-circle' },
    { key: 'video_parallax', label: 'Video Section', icon: 'bi-play-circle' },
    { key: 'facilities', label: 'Facilities', icon: 'bi-grid' },
    { key: 'local_amenities', label: 'Local Amenities', icon: 'bi-geo-alt' },
    { key: 'booking', label: 'Booking Section', icon: 'bi-calendar' },
];

const form = useForm({
    sections: {
        hero: {
            key: 'hero',
            title: props.sections?.hero?.title || { en: '', mk: '' },
            subtitle: props.sections?.hero?.subtitle || { en: '', mk: '' },
            video: props.sections?.hero?.video || '',
            is_active: props.sections?.hero?.is_active ?? true,
        },
        about: {
            key: 'about',
            title: props.sections?.about?.title || { en: '', mk: '' },
            subtitle: props.sections?.about?.subtitle || { en: '', mk: '' },
            content: props.sections?.about?.content || { en: '', mk: '' },
            image: props.sections?.about?.image || '',
            data: props.sections?.about?.data || { image_secondary: '' },
            is_active: props.sections?.about?.is_active ?? true,
        },
        video_parallax: {
            key: 'video_parallax',
            title: props.sections?.video_parallax?.title || { en: '', mk: '' },
            subtitle: props.sections?.video_parallax?.subtitle || { en: '', mk: '' },
            video: props.sections?.video_parallax?.video || '',
            is_active: props.sections?.video_parallax?.is_active ?? true,
        },
        facilities: {
            key: 'facilities',
            title: props.sections?.facilities?.title || { en: '', mk: '' },
            subtitle: props.sections?.facilities?.subtitle || { en: '', mk: '' },
            data: props.sections?.facilities?.data || [],
            is_active: props.sections?.facilities?.is_active ?? true,
        },
        local_amenities: {
            key: 'local_amenities',
            title: props.sections?.local_amenities?.title || { en: '', mk: '' },
            subtitle: props.sections?.local_amenities?.subtitle || { en: '', mk: '' },
            data: props.sections?.local_amenities?.data || [],
            is_active: props.sections?.local_amenities?.is_active ?? true,
        },
        booking: {
            key: 'booking',
            title: props.sections?.booking?.title || { en: '', mk: '' },
            subtitle: props.sections?.booking?.subtitle || { en: '', mk: '' },
            content: props.sections?.booking?.content || { en: '', mk: '' },
            is_active: props.sections?.booking?.is_active ?? true,
        },
    },
});

const submit = () => {
    form.put('/admin/homepage');
};

const addFacility = () => {
    if (!Array.isArray(form.sections.facilities.data)) {
        form.sections.facilities.data = [];
    }
    form.sections.facilities.data.push({
        icon: 'customicon-wifi',
        title: { en: '', mk: '' },
        description: { en: '', mk: '' },
    });
};

const removeFacility = (index) => {
    form.sections.facilities.data.splice(index, 1);
};

const addAmenity = () => {
    if (!Array.isArray(form.sections.local_amenities.data)) {
        form.sections.local_amenities.data = [];
    }
    form.sections.local_amenities.data.push({
        title: { en: '', mk: '' },
        description: { en: '', mk: '' },
        image: '',
    });
};

const removeAmenity = (index) => {
    form.sections.local_amenities.data.splice(index, 1);
};

const facilityIcons = [
    'customicon-private-parking',
    'customicon-wifi',
    'customicon-cocktail',
    'customicon-swimming-pool',
    'customicon-air-conditioner',
    'customicon-room-service',
    'customicon-spa',
    'customicon-gym',
];
</script>

<template>
    <AdminLayout>
        <template #title>Homepage Management</template>
        <template #actions>
            <button 
                @click="submit" 
                :disabled="form.processing"
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
            >
                <i class="bi bi-check-lg"></i>
                Save Changes
            </button>
        </template>

        <div class="flex gap-6">
            <!-- Tabs Sidebar -->
            <div class="w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-4 border-b border-slate-200">
                        <h3 class="font-semibold text-slate-800">Sections</h3>
                    </div>
                    <nav class="p-2">
                        <button
                            v-for="tab in tabs"
                            :key="tab.key"
                            @click="activeTab = tab.key"
                            :class="[
                                'w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-left transition-colors',
                                activeTab === tab.key 
                                    ? 'bg-amber-50 text-amber-700' 
                                    : 'text-slate-600 hover:bg-slate-50'
                            ]"
                        >
                            <i :class="['bi', tab.icon]"></i>
                            <span class="font-medium">{{ tab.label }}</span>
                            <span 
                                v-if="form.sections[tab.key]?.is_active === false"
                                class="ml-auto text-xs bg-slate-200 text-slate-600 px-1.5 py-0.5 rounded"
                            >
                                Hidden
                            </span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-1">
                <form @submit.prevent="submit">
                    <!-- Hero Section -->
                    <div v-show="activeTab === 'hero'" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-slate-800">Hero Section</h2>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" v-model="form.sections.hero.is_active" class="rounded">
                                <span class="text-sm text-slate-600">Active</span>
                            </label>
                        </div>
                        
                        <BilingualInput v-model="form.sections.hero.subtitle" label="Subtitle (Small Text)" />
                        <BilingualInput v-model="form.sections.hero.title" label="Main Title" type="textarea" />
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Background Video Path</label>
                            <input 
                                type="text" 
                                v-model="form.sections.hero.video" 
                                class="w-full border border-slate-300 rounded-lg px-3 py-2"
                                placeholder="e.g., video/hero_video.mp4"
                            >
                            <p class="text-xs text-slate-500 mt-1">Path relative to /assets/paradise/</p>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div v-show="activeTab === 'about'" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-slate-800">About Us Section</h2>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" v-model="form.sections.about.is_active" class="rounded">
                                <span class="text-sm text-slate-600">Active</span>
                            </label>
                        </div>
                        
                        <BilingualInput v-model="form.sections.about.subtitle" label="Subtitle" />
                        <BilingualInput v-model="form.sections.about.title" label="Title" />
                        <BilingualInput v-model="form.sections.about.content" label="Content" type="textarea" />
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Main Image</label>
                                <input 
                                    type="text" 
                                    v-model="form.sections.about.image" 
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2"
                                    placeholder="e.g., img/about-us.webp"
                                >
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Secondary Image</label>
                                <input 
                                    type="text" 
                                    v-model="form.sections.about.data.image_secondary" 
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2"
                                    placeholder="e.g., img/about-us-two.webp"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Video Parallax Section -->
                    <div v-show="activeTab === 'video_parallax'" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-slate-800">Video Parallax Section</h2>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" v-model="form.sections.video_parallax.is_active" class="rounded">
                                <span class="text-sm text-slate-600">Active</span>
                            </label>
                        </div>
                        
                        <BilingualInput v-model="form.sections.video_parallax.subtitle" label="Subtitle" />
                        <BilingualInput v-model="form.sections.video_parallax.title" label="Title" type="textarea" />
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Video Path</label>
                            <input 
                                type="text" 
                                v-model="form.sections.video_parallax.video" 
                                class="w-full border border-slate-300 rounded-lg px-3 py-2"
                                placeholder="e.g., video/swimming_pool_2.mp4"
                            >
                        </div>
                    </div>

                    <!-- Facilities Section -->
                    <div v-show="activeTab === 'facilities'" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-slate-800">Facilities Section</h2>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" v-model="form.sections.facilities.is_active" class="rounded">
                                <span class="text-sm text-slate-600">Active</span>
                            </label>
                        </div>
                        
                        <BilingualInput v-model="form.sections.facilities.subtitle" label="Subtitle" />
                        <BilingualInput v-model="form.sections.facilities.title" label="Title" />
                        
                        <div class="border-t border-slate-200 pt-4 mt-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-medium text-slate-700">Facility Items</h3>
                                <button 
                                    type="button"
                                    @click="addFacility"
                                    class="text-sm text-amber-600 hover:text-amber-700 flex items-center gap-1"
                                >
                                    <i class="bi bi-plus-circle"></i> Add Facility
                                </button>
                            </div>
                            
                            <div v-for="(facility, index) in form.sections.facilities.data" :key="index" class="border border-slate-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-medium text-slate-600">Facility {{ index + 1 }}</span>
                                    <button type="button" @click="removeFacility(index)" class="text-red-500 hover:text-red-600">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium mb-1">Icon</label>
                                    <select v-model="facility.icon" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                                        <option v-for="icon in facilityIcons" :key="icon" :value="icon">{{ icon }}</option>
                                    </select>
                                </div>
                                <BilingualInput v-model="facility.title" label="Title" />
                                <BilingualInput v-model="facility.description" label="Description" type="textarea" />
                            </div>
                        </div>
                    </div>

                    <!-- Local Amenities Section -->
                    <div v-show="activeTab === 'local_amenities'" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-slate-800">Local Amenities Section</h2>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" v-model="form.sections.local_amenities.is_active" class="rounded">
                                <span class="text-sm text-slate-600">Active</span>
                            </label>
                        </div>
                        
                        <BilingualInput v-model="form.sections.local_amenities.subtitle" label="Subtitle" />
                        <BilingualInput v-model="form.sections.local_amenities.title" label="Title" />
                        
                        <div class="border-t border-slate-200 pt-4 mt-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-medium text-slate-700">Amenity Items</h3>
                                <button 
                                    type="button"
                                    @click="addAmenity"
                                    class="text-sm text-amber-600 hover:text-amber-700 flex items-center gap-1"
                                >
                                    <i class="bi bi-plus-circle"></i> Add Amenity
                                </button>
                            </div>
                            
                            <div v-for="(amenity, index) in form.sections.local_amenities.data" :key="index" class="border border-slate-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-medium text-slate-600">Amenity {{ index + 1 }}</span>
                                    <button type="button" @click="removeAmenity(index)" class="text-red-500 hover:text-red-600">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium mb-1">Image Path</label>
                                    <input type="text" v-model="amenity.image" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="e.g., img/local_amenities_1.jpg">
                                </div>
                                <BilingualInput v-model="amenity.title" label="Title" />
                                <BilingualInput v-model="amenity.description" label="Description" type="textarea" />
                            </div>
                        </div>
                    </div>

                    <!-- Booking Section -->
                    <div v-show="activeTab === 'booking'" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-slate-800">Booking Section</h2>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" v-model="form.sections.booking.is_active" class="rounded">
                                <span class="text-sm text-slate-600">Active</span>
                            </label>
                        </div>
                        
                        <BilingualInput v-model="form.sections.booking.subtitle" label="Subtitle" />
                        <BilingualInput v-model="form.sections.booking.title" label="Title" />
                        <BilingualInput v-model="form.sections.booking.content" label="Content" type="textarea" />
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
