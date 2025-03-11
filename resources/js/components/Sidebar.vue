<script setup>
import Menu from "primevue/menu";
import { computed, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";

const { props } = usePage();

const sidebar_menus = computed(() => props.sidebar_menus);
onMounted(() => {
  // Gunakan MutationObserver untuk mengawasi perubahan DOM
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.type === "attributes" && mutation.attributeName === "class") {
        const target = mutation.target;
        if (target.classList.contains("p-focus")) {
          target.classList.remove("p-focus");
        }
      }
    });
  });

  const items = document.querySelectorAll(".p-menu-item");
  items.forEach((item) => {
    observer.observe(item, { attributes: true });
  });
});
</script>

<template>
  <div class="flex justify-center">
    <Menu
      :model="sidebar_menus"
      class="bg-slate-800 hover:scrollbar-thumb-sky-800 min-h-screen scrollbar scrollbar-thumb-slate-800 scrollbar-track-slate-500 overflow-y-auto rounded-none border-none px-2 hidden md:block md:w-50 lg:w-60 xl:w-72"
    >
      <template #item="{ item, props }">
        <Link v-ripple :href="item.url" v-bind="props.action">
          <span :class="item.icon" class="text-slate-200" />
          <span
            :class="[
              'text-slate-200 ml-2',
              { 'text-red-600': $page.url.startsWith(item.url) },
            ]"
            >{{ item.label }}</span
          >
        </Link>
      </template>
    </Menu>
  </div>
</template>
<style>
/* Hilangkan style fokus */
.p-menu-item-content:focus,
.p-menu-item-content:hover {
  background-color: rgb(15, 23, 42) !important;
}
</style>
