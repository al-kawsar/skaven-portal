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

const isLoading = ref(false);

const form = ref({
  old_password: "",
  password: "",
  password_confirm: "",
});

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
        <h1 class="text-3xl font-bold">Ganti Password</h1>
        <div class="text-sm">
          Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap
          aman.
        </div>
      </div>

      <form method="post" @submit.prevent="">
        <div class="flex flex-col gap-3">
          <div>
            <label for="op" class="block font-bold mb-1"
              >Kata sandi saat ini <span class="text-red-600">*</span></label
            >
            <InputText
              id="op"
              v-model.trim="form.old_password"
              required="true"
              class="focus:border-blue-600"
              fluid
            />
          </div>
          <div>
            <label for="ps" class="block font-bold mb-1"
              >Password <span class="text-red-600">*</span></label
            >
            <InputText
              id="ps"
              v-model.trim="form.password"
              required="true"
              class="focus:border-blue-600"
              fluid
            />
          </div>
          <div>
            <label for="cf" class="block font-bold mb-1"
              >Konfirmasi Password <span class="text-red-600">*</span></label
            >
            <InputText
              id="cf"
              v-model.trim="form.password_confirm"
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
