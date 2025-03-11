<script setup>
import Toast from "primevue/toast";
</script>
<template>
  <Toast />
  <div
    class="w-screen overflow-x-hidden h-screen bg-slate-100 flex justify-center items-center overflow-y-hidden"
  >
    <div
      class="w-full sm:w-[80%] shadow border p-4 md:p-8 md:w-1/2 lg:w-1/3 gap-12 flex flex-col justify-center bg-white"
    >
      <slot />
    </div>
  </div>
</template>
