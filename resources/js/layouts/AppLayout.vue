<script setup>
import Sidebar from "../components/Sidebar.vue";
import Header from "../components/Header.vue";
import { ref, watch } from "vue";
import Toast from "primevue/toast";
import Breadcrumb from "primevue/breadcrumb";
import { usePage } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

const home = ref({
  icon: "pi pi-home",
  route: "/dashboard",
});

const page = usePage();

const generateBreadcrumbItems = (url) => {
  // Pisahkan path dari query string
  const path = url.split("?")[0] || "";

  // Pisahkan segmen dari path
  const segments = path
    .split("/")
    .filter((segment) => segment && segment !== "dashboard");

  // Membentuk breadcrumb items
  let accumulatedPath = "";
  return segments.map((segment) => {
    accumulatedPath += `/${segment}`;
    return {
      label: segment.charAt(0).toUpperCase() + segment.slice(1), // Mengubah huruf pertama menjadi kapital
      route: accumulatedPath,
    };
  });
};
// Membentuk items secara dinamis berdasarkan rute saat ini
const items = ref(generateBreadcrumbItems(page.url));

watch(
  () => page.url,
  (newUrl) => {
    items.value = generateBreadcrumbItems(newUrl);
  }
);
</script>

<template>
  <Toast />
  <div class="flex h-screen overflow-hidden font-inter bg-white">
    <Sidebar />
    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
      <!-- <Header /> -->
      <main>
        <div
          class="px-4 bg-slate-100 sm:px-6 lg:px-12 pb-6 pt-3 h-full w-full mx-auto min-h-[100vh]"
        >
          <Breadcrumb
            :home="home"
            :model="items"
            class="mx-0 text-slate-800 px-0 bg-transparent rounded"
          >
            <template #item="{ item, props }">
              <Link v-if="item.route" :href="item.route" custom class="!text-slate-800">
                <span :class="[item.icon, 'text-color']" />
                <span class="text-reset font-semibold">{{ item.label }}</span>
              </Link>
              <span v-else>
                <span :class="[item.icon, 'text-color']" />
                <span class="!font-semibold text-slate-800">{{ item.label }}</span>
              </span>
            </template>
          </Breadcrumb>
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>
