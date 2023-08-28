<template>
    <Dropdown classMenuItems=" w-[180px] top-[58px] ">
        <div class="flex items-center">
            <div class="flex-1 ltr:mr-[10px] rtl:ml-[10px]">
                <div class="lg:h-8 lg:w-8 h-7 w-7 rounded-full">
                    <img
                        :src="profileImg"
                        alt=""
                        class="block w-full h-full object-cover rounded-full"
                    />
                </div>
            </div>
            <div
                class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap"
            >
        <span
            class="overflow-hidden text-ellipsis whitespace-nowrap w-[85px] block"
        >Albert Flores</span
        >
                <span class="text-base inline-block ltr:ml-[10px] rtl:mr-[10px]"
                ><Icon icon="heroicons-outline:chevron-down"></Icon
                ></span>
            </div>
        </div>
        <template #menus>
            <MenuItem v-for="(item, i) in ProfileMenu" :key="i" v-slot="{ active }">
                <div
                    :class="`${
            active
              ? 'bg-slate-100 dark:bg-slate-700 dark:bg-opacity-70 text-slate-900 dark:text-slate-300'
              : 'text-slate-600 dark:text-slate-300'
          } `"
                    class="inline-flex items-center space-x-2 rtl:space-x-reverse w-full px-4 py-2 first:rounded-t last:rounded-b font-normal cursor-pointer"
                    type="button"
                    @click="item.link()"
                >
                    <div class="flex-none text-lg">
                        <Icon :icon="item.icon"/>
                    </div>
                    <div class="flex-1 text-sm">
                        {{ item.label }}
                    </div>
                </div>
            </MenuItem>
        </template>
    </Dropdown>
</template>
<script setup>
import {MenuItem} from "@headlessui/vue";
import Dropdown from "@/Components/Dropdown/index.vue";
import Icon from "@/Components/Icon/index.vue";
import profileImg from "@/assets/images/all-img/user.png";
import {useI18n} from 'vue-i18n'
import {computed} from "vue";
import { router } from '@inertiajs/vue3'

const ProfileMenu = computed(() => [
    {
        label: useI18n().t('dashboard.profile'),
        icon: "heroicons-outline:user",
        link: () => {
            router.get("/dashboard");
        },
    },
    {
        label: useI18n().t('auth.logout'),
        icon: "heroicons-outline:login",
        link: () => {
            router.post(route('logout'))
            localStorage.removeItem("activeUser");
        },
    },
])

</script>
<style lang=""></style>
