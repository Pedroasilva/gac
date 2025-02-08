<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Transaction from '@/Components/Transaction.vue';
</script>

<template>

    <Head title="Account" />
    <AuthenticatedLayout>

        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 mt-3">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">Total Balance</h1>
                <p class="text-4xl text-green-600 font-semibold mt-2">$ 2,562.50</p>
            </div>

            <div class="flex justify-center space-x-6 mb-8">
                <button class="bg-orange-600 text-white px-6 py-3 rounded-lg transition duration-300">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                    Transfer
                </button>
                <button class="bg-green-600 text-white px-6 py-3 rounded-lg transition duration-300">
                    <i class="fa-solid fa-landmark"></i>
                    Deposit
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-200 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold">Income</h2>
                    <p class="text-2xl text-green-600 mt-2">$ 552.95</p>
                </div>
                <div class="bg-gray-200 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold">Expenses</h2>
                    <p class="text-2xl text-red-600 mt-2">$ 86.45</p>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Transactions</h2>
                <Transaction date="2021-10-01 12:45:23" description="Transfer to client" amount="$ 500.00" type="out" />
                <Transaction date="2021-10-01 12:45:23" description="Received from client" amount="$ 23.00" type="in" />
                <Transaction date="2021-10-01 12:45:23" description="Deposit" amount="$ 500.00" type="in" />
                <Transaction date="2021-10-01 12:45:23" description="Deposit" amount="$ 50.00" type="in" />
                <Transaction date="2021-10-01 12:45:23" description="Deposit" amount="$ 121.00" type="in" />
                <Transaction date="2021-10-01 12:45:23" description="Deposit" amount="$ 35.00" type="in" />
                <Transaction date="2021-10-01 12:45:23" description="Deposit" amount="$ 87.00" type="in" />
                <Transaction date="2021-10-01 12:45:23" description="Deposit" amount="$ 15,550.00" type="in" />
            </div>

            <button
                class="w-full bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-300">Load
                more</button>
        </div>

    </AuthenticatedLayout>
</template>
