<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import UpdateClientForm from "@/Pages/Clients/Partials/UpdateClientForm.vue";

defineProps({
  client: {
	type: Object,
  },
});
</script>

<template>
  <Head title="Manage Client" />

  <AuthenticatedLayout>
	<template #header>
	  <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Client</h2>
	</template>

	<div class="py-12">
	  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
		<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
		  <UpdateClientForm
			  class="max-w-xl"
		  />
<!--		  <UpdateProfileInformationForm-->
<!--			  :must-verify-email="mustVerifyEmail"-->
<!--			  :status="status"-->
<!--			  class="max-w-xl"-->
<!--		  />-->
		</div>
	  </div>
	</div>
  </AuthenticatedLayout>
</template>
