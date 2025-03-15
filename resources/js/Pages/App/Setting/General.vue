<script setup>
import AppLayout from "@/layouts/AppLayout.vue";
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Menu from "primevue/menu";

import axios from "axios";

defineOptions({ layout: AppLayout });

const toast = useToast();
const { props } = usePage();

const role = computed(() => props.role);
const user = computed(() => props.user);

const isLoading = ref(false);

const handleUpdateProfile = () => {};

const items = ref([
  {
    label: "Pengaturan Akun",
    url: route("settings.account"),
  },
  {
    label: "Keamanan",
    url: route("settings.security"),
  },
]);
</script>
<template>
  <div class="flex gap-12 card bg-white shadow px-6 py-8 border">
    <div class="card">
      <ul class="flex flex-col gap-4">
        <Link class="font-semibold" v-for="item in items" :href="item.url">{{
          item.label
        }}</Link>
      </ul>
    </div>
    <div class="col-span-2 bg-white flex-1">
      <div class="mb-6 flex flex-col gap-2">
        <h1 class="text-3xl font-bold">Informasi Profil</h1>
        <div class="text-sm">Perbarui informasi profil Anda, dan pengaturan lainnya.</div>
      </div>

      <form method="post" @submit.prevent="">
        <div class="flex flex-col gap-3">
          <div>
            <label for="nama" class="block font-bold mb-1"
              >Nama <span class="text-red-600">*</span></label
            >
            <InputText
              id="nama"
              v-model.trim="user.name"
              required="true"
              class="focus:border-blue-600"
              fluid
            />
          </div>
          <div>
            <label for="email" class="block font-bold mb-1"
              >Email <span class="text-red-600">*</span></label
            >
            <InputText
              id="email"
              v-model.trim="user.email"
              type="email"
              required="true"
              class="focus:border-blue-600"
              fluid
            />
          </div>
          <Button
            class="ms-auto my-2 mt-4"
            label="Simpan"
            type="submit"
            severity="info"
            :loading="isLoading"
          />
        </div>
      </form>
    </div>
  </div>
</template>
