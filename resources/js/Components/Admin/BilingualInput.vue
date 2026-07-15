<script setup>
const props = defineProps({
    modelValue: Object,
    label: String,
    name: String,
    type: { type: String, default: 'text' },
    required: { type: Boolean, default: false },
    placeholder: { type: String, default: '' },
});

const emit = defineEmits(['update:modelValue']);

const update = (locale, value) => {
    emit('update:modelValue', { ...props.modelValue, [locale]: value });
};
</script>

<template>
    <div class="mb-4">
        <label class="block text-sm font-medium text-slate-700 mb-2">{{ label }}</label>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="flex items-center gap-1.5 mb-1">
                    <span class="w-5 h-4 rounded-sm bg-blue-600 flex items-center justify-center">
                        <span class="text-[8px] text-white font-bold">EN</span>
                    </span>
                    <span class="text-xs text-slate-500">English</span>
                </div>
                <input
                    v-if="type === 'text'"
                    type="text"
                    :value="modelValue?.en || ''"
                    @input="update('en', $event.target.value)"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                    :required="required"
                    :placeholder="placeholder"
                />
                <textarea
                    v-else
                    :value="modelValue?.en || ''"
                    @input="update('en', $event.target.value)"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                    rows="4"
                    :required="required"
                    :placeholder="placeholder"
                ></textarea>
            </div>
            <div>
                <div class="flex items-center gap-1.5 mb-1">
                    <span class="w-5 h-4 rounded-sm bg-red-600 flex items-center justify-center">
                        <span class="text-[8px] text-white font-bold">MK</span>
                    </span>
                    <span class="text-xs text-slate-500">Macedonian</span>
                </div>
                <input
                    v-if="type === 'text'"
                    type="text"
                    :value="modelValue?.mk || ''"
                    @input="update('mk', $event.target.value)"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                    :required="required"
                    :placeholder="placeholder"
                />
                <textarea
                    v-else
                    :value="modelValue?.mk || ''"
                    @input="update('mk', $event.target.value)"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                    rows="4"
                    :required="required"
                    :placeholder="placeholder"
                ></textarea>
            </div>
        </div>
    </div>
</template>
