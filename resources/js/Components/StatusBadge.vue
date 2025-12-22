<script setup>
import { computed } from "vue";

const props = defineProps({
    status: {
        type: String,
        required: true,
    },
});

const config = {
    requested: {
        label: "Requested",
        classes: "bg-yellow-100 text-yellow-700 border-yellow-200",
    },
    approved: {
        label: "Approved",
        classes: "bg-green-100 text-green-700 border-green-200",
    },
    canceled: {
        label: "Cancelled",
        classes: "bg-red-100 text-red-700 border-red-200",
    },
};

const current = computed(
    () =>
        config[props.status.toLowerCase()] || {
            label: props.status,
            classes: "bg-gray-100 text-gray-700 border-gray-200",
        }
);
</script>

<template>
    <span
        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border"
        :class="current.classes"
    >
        {{ current.label }}
    </span>
</template>
