<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import {computed, nextTick, ref} from "vue";
import Modal from "@/Components/Modal.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useToast } from "@/Composables/useToast.js";
import { useConfirm } from "@/Composables/useConfirm.js";

const page = usePage();
const {toasts, addToast} = useToast();
const {show: confirm} =  useConfirm()

const nameInput = ref(null);

const clients = computed(() => page.props.clients);

const showCreateClientForm = ref(false);

const createClientForm = useForm({
  name: '',
});

const deleteClientForm = useForm({})

const createClient = () => {
  createClientForm.post(route('clients.store'), {
	preserveScroll: true,
	onSuccess: () => {
	  closeCreateClientModal()
	  addToast('Client created successfully!')
	},
	onError: () => nameInput.value.focus(),
	onFinish: () => createClientForm.reset(),
  });
}

const showCreateClientModal = () => {
  showCreateClientForm.value = true
  nextTick(() => nameInput.value.focus());
}

const closeCreateClientModal = () => {
  showCreateClientForm.value = false;
  createClientForm.reset();
}

const deleteClient = async (clientId) => {
  const result = await confirm('Are you sure?', 'It will remove the client from the database. Are you sure to remove?')

  if(result) {
	deleteClientForm.delete(route('clients.destroy', {client: clientId}), {
	  onSuccess: () => {
		addToast('Client removed successfully!')
	  },
	  onError: () => {
		addToast('Unable to remove client', 'error')
	  },
	})
  }
}
</script>

<template>
    <Head title="Clients" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clients
            </h2>
        </template>

		<Modal :show="showCreateClientForm" @close="closeCreateClientModal">
		  <div class="p-6">
			<h2 class="text-lg font-medium text-gray-900">Create Client</h2>
			<form @submit.prevent="createClient">
			  <div class="mt-6">
				<div class="mt-6">
				  <InputLabel for="name" value="Name" class="sr-only" />

				  <TextInput
					  id="name"
					  ref="nameInput"
					  v-model="createClientForm.name"
					  type="text"
					  class="mt-1 block w-full"
					  placeholder="Name"
				  />

				  <InputError :message="createClientForm.errors.name" class="mt-2" />
				</div>

				<div class="mt-6 flex justify-end">
				  <SecondaryButton @click="closeCreateClientModal"> Cancel </SecondaryButton>

				  <PrimaryButton
					  type="submit"
					  class="ml-3"
					  :class="{ 'opacity-25': createClientForm.processing }"
					  :disabled="createClientForm.processing"
				  >
					Create Client
				  </PrimaryButton>
				</div>
			  </div>
			</form>
		  </div>
		</Modal>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1
                            class="text-base font-semibold leading-6 text-gray-900"
                        >
                            Clients
                        </h1>
                        <p class="mt-2 text-sm text-gray-700">
                            A list of all the clients
                        </p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <button
                            type="button"
                            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        	@click="showCreateClientModal"
						>
                            Add client
                        </button>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div
                            class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                        >
                            <div
                                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-t-lg"
                            >
                                <table
                                    class="min-w-full divide-y divide-gray-300"
                                >
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                Name
                                            </th>
                                            <th
                                                scope="col"
                                                class="relative py-3.5 pl-3 pr-4 sm:pr-6"
                                            >
                                                <span class="sr-only"
                                                    >Actions</span
                                                >
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="divide-y divide-gray-200 bg-white"
                                    >
                                        <tr
                                            v-for="client in clients.data"
                                            :key="client.id"
                                        >
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                {{ client.name }}
                                            </td>
                                            <td
                                                class="relative flex justify-end gap-x-3 whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                                            >
                                                <a
                                                    :href="route('clients.show', {client: client.id})"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                    >View<span class="sr-only"
                                                        >,
                                                        {{ client.name }}</span
                                                    ></a
                                                >
												<a
													href="#"
													@click.prevent="deleteClient(client.id)"
													class="text-red-600 hover:text-indigo-900"
												>Delete<span class="sr-only"
												>,
														  {{ client.name }}</span
												></a
												>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <pagination :data="clients" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
