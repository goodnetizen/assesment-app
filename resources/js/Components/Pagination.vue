<script setup>
import Pagination from '@/Components/Pagination.vue';

const props = defineProps(['pagination']);
</script>

<template>
    <nav class="flex items-center justify-between py-4" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500 pl-3">Showing <span class="font-semibold text-gray-900">{{ (props?.pagination.from ?? 0) + '-' + (props?.pagination.to ?? 0) }}</span> of <span class="font-semibold text-gray-900">{{ props?.pagination.total }}</span></span>
        <ul v-if="props?.pagination.links.length > 3" class="inline-flex -space-x-px text-sm h-8 px-3">
            <template v-for="(link, p) in props?.pagination.links" :key="p">
                <li v-if="link.url === null">
                    <a :href="link.url" class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700" v-html="link.label"></a>
                </li>
                <li v-else>
                    <a :href="link.url" class="flex items-center justify-center px-3 h-8 leading-tight border border-gray-300" :class="{ 'bg-blue-700 text-white': link.active, 'text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700': !link.active }" v-html="link.label"></a>
                </li>
            </template>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: {
            pagination: Array
        },
    }
</script>