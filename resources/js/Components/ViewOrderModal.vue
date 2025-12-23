<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import StatusBadge from "@/Components/StatusBadge.vue";
import OpenLinkLogo from "@/Components/OpenLinkLogo.vue";

const props = defineProps({
    order: Object,
});

const showModal = ref(false);
</script>

<template>
    <section class="w-5 h-5">
        <button
            @click="showModal = true"
            class="text-blue-600 hover:text-blue-900 transition font-medium text-sm"
        >
            <OpenLinkLogo class="w-5 h-5 text-blue-200" />
        </button>

        <Modal :show="showModal" @close="showModal = false">
            <div class="p-6">
                <div
                    class="flex justify-between items-center border-b pb-4 mb-4"
                >
                    <h2 class="text-lg font-bold text-gray-900">
                        Travel Order #{{ order.id }}
                    </h2>
                    <StatusBadge :status="order.status" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p
                            class="text-xs font-semibold uppercase text-gray-500"
                        >
                            Requester
                        </p>
                        <p class="text-sm text-gray-900">
                            {{ order.requester_name }}
                        </p>
                    </div>
                    <div>
                        <p
                            class="text-xs font-semibold uppercase text-gray-500"
                        >
                            Destination
                        </p>
                        <p class="text-sm text-gray-900">
                            {{ order.destination }}
                        </p>
                    </div>
                    <div>
                        <p
                            class="text-xs font-semibold uppercase text-gray-500"
                        >
                            Departure
                        </p>
                        <p class="text-sm text-gray-900">
                            {{ order.departure_date }}
                        </p>
                    </div>
                    <div>
                        <p
                            class="text-xs font-semibold uppercase text-gray-500"
                        >
                            Return
                        </p>
                        <p class="text-sm text-gray-900">
                            {{ order.return_date }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <SecondaryButton @click="showModal = false"
                        >Close</SecondaryButton
                    >
                </div>
            </div>
        </Modal>
    </section>
</template>
