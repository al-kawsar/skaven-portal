<script setup>
import Toast from "primevue/toast";
</script>
<template>
  <Toast />
  <div
    class="w-screen overflow-x-hidden h-screen bg-slate-50 flex justify-center overflow-y-hidden"
  >
    <div class="py-16 px-12 md:w-1/3 gap-12 flex flex-col justify-center bg-white">
      <h2 class="font-bold text-3xl">Login</h2>
      <slot />
    </div>
  </div>
</template>
