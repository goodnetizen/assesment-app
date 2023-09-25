<script setup>
import Pagination from '@/Components/Pagination.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import Datepicker from 'vuejs3-datepicker'

const props = defineProps(['list','merchants','outlets','filters','paymentStatus']);
let search = ref(props?.filters.search);
let merchant = ref('');
let outlet = ref('');
let paymentStatus = ref('');

const picked = ref('');

// watch(search, debounce(function (value) {
//     router.get('/transaction', { search: value }, {
//         preserveState: true,
//         replace: true,
//     });
// }, 300));
watch([search, merchant, outlet, paymentStatus, picked], ([valueSearch, valueMerchant, valueOutlet, valuePaymentStatus, valuePicked]) => {
    if (valuePicked) valuePicked = new Date(valuePicked).toISOString().split('T')[0];
    router.get('/transaction', { search: valueSearch, merchant: valueMerchant, outlet: valueOutlet, paymentStatus: valuePaymentStatus, date: valuePicked}, {
        preserveState: true,
        replace: true
    });
});
</script>

<template>
    <div class="p-3 bg-white flex">
        <div class="relative mt-1">
            <label for="table-search" class="text-sm">Search</label>
            <input v-model="search" type="text" id="table-search" class="block p-2 pl-3 text-sm text-gray-900 border border-gray-300 rounded-lg w-40 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search for items">
        </div>
        <div class="relative mt-1 ml-3">
            <label for="filter-merchant" class="text-sm">Merchant</label>
            <select v-model="merchant" id="filter-merchant" class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg w-40 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Filter by Merchant">
                <option v-for="opt in props.merchants" :key="opt.id" :value="opt.id">
                    {{ opt.name }}
                </option>
            </select>
        </div>
        <div class="relative mt-1 ml-3">
            <label for="filter-outlet" class="text-sm">Outlet</label>
            <select v-model="outlet" id="filter-outlet" class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg w-40 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Filter by Outlet">
                <option v-for="opt in props.outlets" :key="opt.id" :value="opt.id">
                    {{ opt.name }}
                </option>
            </select>
        </div>
        <div class="relative mt-1 ml-3">
            <label for="filter-outlet" class="text-sm">Payment Status</label>
            <select v-model="paymentStatus" id="filter-payment" class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg w-40 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Filter by Payment Status">
                <option v-for="sts in props.paymentStatus" :key="sts" :value="sts">
                    {{ sts }}
                </option>
            </select>
        </div>
        <div class="relative mt-1 ml-3">
            <label for="filter-date" class="text-sm">Date</label>
            <div class="relative max-w-sm">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                <!-- <datepicker id="filter-date"  placeholder="Select date"></datepicker> -->
                <datepicker class="z-10" v-model="picked"></datepicker>
            </div>
        </div>
        <div class="relative mt-1 ml-3 flex flex-col items-end justify-end">
            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Export</button>
        </div>
    </div>
    <div class="relative h-128 overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <template v-for="(val, col) in props.list.data[0]">
                        <th scope="col" class="px-6 py-3">{{ col }}</th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <template v-for="(data, index) in props?.list.data">
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <template v-for="(row, key) in data">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ row }}</td>
                        </template>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
    <Pagination :pagination="props?.list" />
</template>

<script>
export default {
  components: {
    Pagination,
    Datepicker
  },
}
</script>