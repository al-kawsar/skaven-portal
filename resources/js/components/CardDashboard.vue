<script setup>
import uniqolor from "uniqolor";
import { ref } from "vue";

const props = defineProps({
  title: String,
  total: Number | String,
  icon: String,
});

const randColor = ref("");
randColor.value = uniqolor.random();
</script>
<template>
  <div class="bg-white border shadow w-full rounded mb-0 p-6">
    <div class="flex justify-between gap-6">
      <div>
        <span class="block text-xl font-bold mb-3">{{ title }}</span>
        <div :style="`color: ${randColor.color}`" class="font-bold text-xl">
          {{ total }}
        </div>
      </div>
      <div
        :style="`background-color: ${randColor.color}`"
        class="flex w-[2.5rem] h-[2.5rem] items-center justify-center rounded contrast-[2] brightness-[0.87]"
      >
        <i :class="icon" class="pi text-white text-xl"></i>
      </div>
    </div>
  </div>
</template>
