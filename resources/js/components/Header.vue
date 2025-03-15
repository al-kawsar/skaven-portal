<script setup>
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();

const user = computed(() => page.props.user);

const listNavbar = ref(false);
</script>
<template>
  <div class="min-h-[56px] shadow-slate-800 shadow bg-white">
    <div class="flex justify-end px-12 items-center h-full">
      <div
        @click="listNavbar = !listNavbar"
        class="relative w-10 cursor-pointer h-10 rounded-full bg-slate-700"
      >
        <ul
          v-if="listNavbar"
          class="absolute flex duration-100 gap-1 flex-col text-sm w-36 top-12 bg-slate-700 rounded-md right-0 text-white"
        >
          <li class="hover:bg-slate-600 bg-slate-700 p-2 duration-200 rounded-lg">
            Profile
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
