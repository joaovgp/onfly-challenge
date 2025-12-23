<script setup>
import { usePage } from "@inertiajs/vue3";

const { user } = usePage().props.auth;

const props = defineProps({
    order: Object,
});

const emit = defineEmits(["approve", "cancel"]);
</script>

<template>
    <section v-if="user.is_admin && order.status === 'REQUESTED'" class="flex gap-2 items-center">
        <button
            @click.prevent="emit('approve', order)"
            title="Approve request"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6 text-green-600"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
            </svg>
        </button>

        <button @click.prevent="emit('cancel', order)" title="Cancel request">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6 text-red-600"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
            </svg>
        </button>
    </section>
</template>
