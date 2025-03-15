<script setup>
import AppLayout from "@/layouts/AppLayout.vue";
import Card from "@/components/CardDashboard.vue";
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
  layout: AppLayout,
});
defineProps({
  total: Object,
});

const { props } = usePage();

const role = computed(() => props.role);
</script>
<template>
  <h1 class="text-2xl md:text-4xl mb-4 font-bold text-slate-800">Dashboard Page</h1>
  <div
    v-if="role === 'admin'"
    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-slate-800"
  >
    <Card title="Total Pengguna" :total="total.users" icon="pi-users" />
    <Card title="Total Data Siswa" :total="total.students" icon="pi-user" />
    <Card title="Total Data Guru" :total="total.teachers" icon="pi-id-card" />
    <Card title="Total Data Kelas" :total="total.class" icon="pi-check" />
    <Card title="Total Data Mapel" :total="total.subjects" icon="pi-objects-column" />
    <Card title="Total Data Nilai" :total="total.exams" icon="pi-sitemap" />
  </div>
  <div
    v-if="role === 'teacher'"
    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-slate-800"
  >
    <Card title="Total Data Siswa" :total="total.students" icon="pi-user" />
    <Card title="Total Data Kelas" :total="total.class" icon="pi-check" />
    <Card title="Total Data Nilai" :total="total.exams" icon="pi-sitemap" />
  </div>
  <div
    v-else-if="role === 'student'"
    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-slate-800"
  >
    <Card title="Total Data Mapel" :total="total.subjects" icon="pi-objects-column" />
  </div>
</template>
