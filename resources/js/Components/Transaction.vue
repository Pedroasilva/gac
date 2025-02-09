<script>
import Receipt from '@/Pages/Partials/Receipt.vue';

export default {
    name: 'Transaction',
    components: {
        Receipt
    },
    props: {
        transaction: {
            type: Object,
            required: true
        }
    }
}
</script>

<template>
    <div
        class="bg-gray-200 p-2 mb-2 rounded-lg flex flex-col md:flex-row justify-between items-start md:items-center hover:bg-gray-300">
        <div class="mb-2 md:mb-0">
            <p class="text-xs text-gray-600">{{ transaction.created_at }}</p>
            <p :class="{ 'text-red-600': transaction.transaction_type === 'out', 'text-green-600': transaction.transaction_type === 'in', 'line-through': transaction.reversed }" class="text-xl">
                {{ transaction.amount }} -
                {{ transaction.description }}
            </p>
        </div>
        <div class="flex space-x-2">
            <Receipt :group="transaction.transaction_group" />
            <button class="bg-red-600 text-white text-sm px-2 py-1 rounded-lg hover:bg-red-800 transition duration-300"
                @click="handleReverse(group)">
                <i class="fa-solid fa-rotate-left"></i>
                Reverse
            </button>
        </div>
    </div>
</template>
