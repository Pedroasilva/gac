<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    group: {
        type: String,
        required: true
    }
});

const showReceipt = ref(false);
const transaction = ref(null);

const show = () => {
    showReceipt.value = true;
    getReceipt();
};

const getReceipt = () => {
    axios.get('/receipt?group=' + props.group)
        .then(response => {
            console.log(response.data); // A resposta JSON
            transaction.value = response.data;
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(value);
};

const closeModal = () => {
    showReceipt.value = false;
};
</script>

<template>
    <section class="space-y-6">
        <PrimaryButton @click="show">
            <i class="fa-solid fa-receipt mr-1"></i>
            Receipt
        </PrimaryButton>

        <Modal :show="showReceipt" @close="closeModal">
            <div class="bg-gray-100 p-6">
                <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6" v-if="transaction">
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold">Receipt</h1>
                        <p class="text-sm text-gray-500">Transaction ID: #{{ transaction.id }}</p>
                        <p class="text-sm text-gray-500">Date: {{ transaction.date }}</p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">Merchant</h2>
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <p class="text-lg">{{ transaction.merchant }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <h2 class="text-lg font-semibold">Amount</h2>
                            <p class="text-xl">{{ formatCurrency(transaction.amount) }}</p>
                        </div>
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <h2 class="text-lg font-semibold">Payment Method</h2>
                            <p class="text-xl">{{ transaction.paymentMethod }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">Details</h2>
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <p class="text-lg">{{ transaction.details }}</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-500">Thank you for your purchase!</p>
                        <p class="text-sm text-gray-500">Please keep this receipt for your records.</p>
                    </div>
                </div>
                <div class="flex justify-center mt-6">
                    <SecondaryButton @click="closeModal">
                        Close
                    </SecondaryButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
