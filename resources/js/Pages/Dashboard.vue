<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePoll } from '@inertiajs/vue3';
import Transaction from '@/Components/Transaction.vue';
import TransferForm from './Partials/TransferForm.vue';
import DepositForm from './Partials/DepositForm.vue';

// usePoll(2000);

const props = defineProps({
    bankAccount: {
        type: Object,
        required: true,
    },
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(value);
};

</script>

<template>

    <Head title="Account" />
    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-2 mt-3">
            <div class="text-center">
                <p class="text-base">
                    Wallet Code: {{ bankAccount.wallet_code }}
                </p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 mt-3">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-bold">Total Balance</h1>
                <p :class="{'text-green-600': bankAccount.balance >= 0, 'text-red-600': bankAccount.balance < 0}" class="text-4xl font-semibold mt-2">{{ formatCurrency(bankAccount.balance) }}</p>
            </div>

            <div class="flex justify-center space-x-6 mb-8">
                <TransferForm class="max-w-xl" />
                <DepositForm class="max-w-xl" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div class="bg-gray-200 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold">Income</h2>
                    <p class="text-2xl text-green-600 mt-2">{{ formatCurrency(bankAccount.income) }}</p>
                </div>
                <div class="bg-gray-200 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold">Expenses</h2>
                    <p class="text-2xl text-red-600 mt-2">{{ formatCurrency(bankAccount.expenses) }}</p>
                </div>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-4">Transactions</h2>
                <Transaction v-for="transaction in bankAccount.transactions" :transaction/>
            </div>

            <p v-if="bankAccount.transactions.length === 0" class="text-center text-gray-500">No transactions found
            </p>
        </div>
    </AuthenticatedLayout>
</template>
