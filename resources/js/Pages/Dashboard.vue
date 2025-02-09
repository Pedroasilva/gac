<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Transaction from '@/Components/Transaction.vue';
import TransferForm from './Partials/TransferForm.vue';

defineProps({
    bankAccount: {
        type: Object,
        required: true,
    },
});

</script>

<template>

    <Head title="Account" />
    <AuthenticatedLayout>

        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-2 mt-3">
            <div class="text-center">
                <p class="text-base">
                    Agency: {{ bankAccount.agency }}
                    Account Number: {{ bankAccount.account_number }}
                </p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 mt-3">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold">Total Balance</h1>
                <p class="text-4xl text-green-600 font-semibold mt-2">$ {{ bankAccount.balance }}</p>
            </div>

            <div class="flex justify-center space-x-6 mb-8">

                <TransferForm class="max-w-xl" />

                <button class="bg-green-600 text-white px-6 py-3 rounded-lg transition duration-300">
                    <i class="fa-solid fa-landmark"></i>
                    Deposit
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-200 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold">Income</h2>
                    <p class="text-2xl text-green-600 mt-2">$ {{ bankAccount.income }}</p>
                </div>
                <div class="bg-gray-200 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold">Expenses</h2>
                    <p class="text-2xl text-red-600 mt-2">$ {{ bankAccount.expenses }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Transactions</h2>
                <Transaction v-for="transaction in bankAccount.transactions" :key="transaction.id"
                    :date="transaction.created_at" :description="transaction.description" :amount="transaction.amount"
                    :type="transaction.transaction_type" />
            </div>

            <button v-if="bankAccount.transactions.length > 0"
                class="w-full bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-300">Load
                more</button>
            <p v-else class="text-center text-gray-500">No transactions found</p>
        </div>

    </AuthenticatedLayout>
</template>
