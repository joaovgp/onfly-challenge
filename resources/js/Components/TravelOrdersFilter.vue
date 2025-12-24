<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Checkbox from "@/Components/Checkbox.vue";

const destination = ref("");
const status = ref([]);
const departure_date = ref("");
const return_date = ref("");

const emit = defineEmits(["filter", "clear"]);

const filter = () => {
    const filter = {};
    if (destination.value) {
        filter.destination = destination.value;
    }
    if (status.value.length) {
        filter.status = status.value;
    }
    if (departure_date.value) {
        filter.departure_date = departure_date.value;
    }
    if (return_date.value) {
        filter.return_date = return_date.value;
    }
    emit("filter", filter);
};

const clearFilters = () => {
    destination.value = "";
    status.value = [];
    departure_date.value = "";
    return_date.value = "";
    emit("clear");
};
</script>

<template>
    <div class="w-1/4 p-4 border-r">
        <h4 class="text-lg font-medium mb-4">Filters</h4>
        <div class="mb-4">
            <label for="destination" class="block text-sm font-medium text-gray-700">Destination</label>
            <input
                type="text"
                id="destination"
                v-model="destination"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            />
        </div>
        <div class="mb-4">
            <label for="departure_date" class="block text-sm font-medium text-gray-700">Departure Date</label>
            <input
                type="date"
                id="departure_date"
                v-model="departure_date"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            />
        </div>
        <div class="mb-4">
            <label for="return_date" class="block text-sm font-medium text-gray-700">Return Date</label>
            <input
                type="date"
                id="return_date"
                v-model="return_date"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <div class="mt-2 space-y-2">
                <div class="flex items-center">
                    <Checkbox id="status_requested" value="REQUESTED" v-model:checked="status" />
                    <label for="status_requested" class="ml-2 text-sm text-gray-600">Requested</label>
                </div>
                <div class="flex items-center">
                    <Checkbox id="status_approved" value="APPROVED" v-model:checked="status" />
                    <label for="status_approved" class="ml-2 text-sm text-gray-600">Approved</label>
                </div>
                <div class="flex items-center">
                    <Checkbox id="status_canceled" value="CANCELED" v-model:checked="status" />
                    <label for="status_canceled" class="ml-2 text-sm text-gray-600">Canceled</label>
                </div>
            </div>
        </div>
        <div class="flex space-x-2 gap-2">
            <SecondaryButton @click="clearFilters">Clear Filters</SecondaryButton>
            <PrimaryButton @click="filter">Filter</PrimaryButton>
        </div>
    </div>
</template>

