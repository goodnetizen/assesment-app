<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TransactionReport from '@/Components/TransactionReport.vue';

const props = defineProps(['transactionList','merchantList','outletList','paymentStatus','filters']);
</script>

<template>
    <AppLayout title="Transactions">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transaction Reports
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <TransactionReport :list="props?.transactionList" :merchants="props?.merchantList" :outlets="props?.outletList" :paymentStatus="props?.paymentStatus" :filters="props?.filters" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>