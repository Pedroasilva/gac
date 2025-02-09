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
const response = ref(null);

const show = () => {
    showReceipt.value = true;
    response.value = null;
    getReceipt();
};

const getReceipt = () => {
    axios.get('/receipt?group=' + props.group)
        .then(jsonResponse => {
            response.value = jsonResponse.data;
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
                <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6" v-if="response">
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold">Receipt</h1>
                        <p class="text-sm text-gray-500">Transaction ID: #{{ response.transactions.transaction_group }}</p>
                        <p class="text-sm text-gray-500">Date: {{ response.transactions.created_at }}</p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">Wallet Code</h2>
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <p class="text-lg">{{ response.bankAccount.wallet_code }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <h2 class="text-lg font-semibold">Amount</h2>
                            <p class="text-xl">{{ formatCurrency(response.transactions.amount) }}</p>
                        </div>
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <h2 class="text-lg font-semibold">Type</h2>
                            <p class="text-xl">{{ response.transactions.transaction_type === 'in' ? 'Income' : 'Expense' }}</p>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold mb-2">Description</h2>
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <p class="text-lg">{{ response.transactions.description }}</p>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center">
                    <p class="text-sm text-gray-500">Loading...</p>
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
