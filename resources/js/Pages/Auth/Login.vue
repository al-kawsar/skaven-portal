<script setup>
import AuthLayout from "../../layouts/AuthLayout.vue";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import { router } from "@inertiajs/vue3";
import axios from "axios";

defineOptions({ layout: AuthLayout });

const form = ref({});
const isLoading = ref(false);
const toast = useToast();

const login = async () => {
  isLoading.value = true;
  axios
    .post(route("auth.login.post"), form.value)
    .then((res) => {
      router.get(route("app.dashboard"));
    })
    .catch((err) => {
      toast.add({
        severity: "error",
        summary: "Gagal",
        detail: err.response.data.message,
        life: 5000,
      });
    })
    .finally(() => {
      isLoading.value = false;
    });
};
</script>

<template>
  <div class="card">
    <h2 class="font-bold text-3xl mb-6">Login</h2>

    <form @submit.prevent="login" class="flex flex-col md:flex-row">
      <div class="w-full flex flex-col justify-center gap-6">
        <div class="flex flex-col gap-2">
          <label for="email" class="font-semibold">Email</label>
          <InputText
            id="email"
            autofocus
            required
            v-model="form.email"
            type="email"
            class="focus:border-blue-600"
            autocomplete="email"
          />
        </div>
        <div class="flex flex-col gap-2">
          <label for="password" class="font-semibold">Password</label>
          <InputText
            id="password"
            v-model="form.password"
            required
            type="password"
            class="focus:border-blue-600"
            autocomplete="current-password"
          />
        </div>
        <Button
          label="Login"
          severity="info"
          :disabled="isLoading"
          :loading="isLoading"
          required
          type="submit"
          class="w-full mx-auto mt-3"
        ></Button>
      </div>
    </form>
  </div>
</template>
