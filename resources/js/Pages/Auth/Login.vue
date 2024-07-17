<script>
export default {
  layout: AuthLayout,
};
</script>
<script setup>
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import AuthLayout from "../../layouts/AuthLayout.vue";
import axios from "axios";

const form = ref({});
const isLoading = ref(false);
const toast = useToast();

const login = async () => {
  isLoading.value = true;
  axios
    .post(route("auth.login.post"), form.value)
    .then((res) => {
      window.location.reload();
    })
    .catch((err) => {
      console.log(err);
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
            class="w-full"
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
            class="w-full"
            autocomplete="current-password"
          />
        </div>
        <Button
          :label="isLoading ? 'Loading...' : 'Login'"
          :disabled="isLoading"
          required
          type="submit"
          class="w-full mx-auto mt-3"
        ></Button>
      </div>
    </form>
  </div>
</template>
