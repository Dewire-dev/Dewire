<script setup lang="ts">
import Item from '@/Interfaces/Item'
import ItemHeader from '@/Interfaces/ItemHeader'

const emit = defineEmits();

const props = defineProps({
    headers: {
        type: Array<ItemHeader>,
        default: [],
    },
    items: {
        type: Array<Array<Item>>,
        default: [],
    },
});

function findItemInItems (items: Array<Item>, headerValue: string): Item | undefined {
    return items.find((item) => {
        return item.value === headerValue
    })
}

function eventToEmit (items, eventName: string) {
    let idToEmit = null
    items.forEach((item: Item) => {
        if (item && item.eventToEmit && item.eventToEmit === eventName) {
            idToEmit = item.id;
            return;
        }
    })

    emit(eventName, idToEmit)
}
</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th v-for="header in headers" scope="col" class="px-6 py-3">
                        <div class="text-center">
                            {{ header.text }}
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="arrayItems in items"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                >
                    <td
                        v-for="header in headers" class="px-6 py-4 text-center"
                        :class="findItemInItems(arrayItems, header.value).bold ? 'font-black' : ''"
                    >
                        <template v-if="findItemInItems(arrayItems, header.value)">
                            <span @click="findItemInItems(arrayItems, header.value).clickable ? eventToEmit(arrayItems, findItemInItems(arrayItems, header.value).eventToEmit) : null">
                                {{ findItemInItems(arrayItems, header.value).text }}
                            </span>
                        </template>
                    </td>
                </tr>
                <slot name="customLine" />
            </tbody>
        </table>
    </div>
</template>
