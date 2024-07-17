<script setup>
import Sidebar from "@/components/Sidebar.vue";
</script>

<template>
  <div class="flex h-screen overflow-hidden font-cs">
    <Sidebar />
    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
      <main>
        <div
          class="px-4 sm:px-6 lg:px-12 pt-8 pb-6 bg-slate-100 w-full mx-auto min-h-[calc(100vh-64px)]"
        >
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>
