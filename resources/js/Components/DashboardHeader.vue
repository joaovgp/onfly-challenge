<script setup>
import CreateOrderModal from "@/Components/CreateOrderModal.vue";
import FindOrderById from "@/Components/FindOrderById.vue";

defineProps({
    isDetailedView: Boolean,
});

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <div>
        <div v-if="isDetailedView" class="p-6 flex justify-between items-center">
            <h3 class="text-lg font-medium">Travel Request Details</h3>
            <button @click="goBack" class="text-gray-600 underline">
                Back to list
            </button>
        </div>
        <div v-else class="p-6 flex justify-between items-center border-b">
            <h3 class="text-lg font-medium">My Travel Requests</h3>
            <div class="flex space-x-4">
                <FindOrderById />
                <CreateOrderModal />
            </div>
        </div>
    </div>
</template>
