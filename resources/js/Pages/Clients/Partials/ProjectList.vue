<script setup>
import { computed, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useConfirm } from "@/Composables/useConfirm.js";
import { useToast } from "@/Composables/useToast.js";
import EditProjectModal from "@/Pages/Clients/Partials/EditProjectModal.vue";

const page = usePage();
const client = computed(() => page.props.client);
const projects = computed(() => page.props.client.projects);
const { show: confirm } = useConfirm();
const { toasts, addToast } = useToast();

const editProject = ref();

const deleteForm = useForm({});

const deleteProject = async (project) => {
    const result = await confirm(
        "Are you sure to delete?",
        "It will remove projects and its related data permanently."
    );

    if (!result) {
        return;
    }

    await deleteForm.delete(
        `/clients/${client.value.id}/projects/${project.id}`,
        {
            preserveScroll: true,
            onSuccess: () => {
                addToast("Project deleted!");
            },
            onError: (error) => {
                console.log(error);
                addToast("Unable to delete project", "error");
            },
            onFinish: () => {},
        }
    );
};
</script>

<template>
    <div>
        <p
            v-if="projects.length <= 0"
            class="text-center text-gray-500 mt-6 rounded-md border border-gray-100 p-6"
        >
            No projects available. Create one to manage project.
        </p>
        <div v-if="projects.length > 0">
            <EditProjectModal v-model="editProject" />

            <ul class="divide-y divide-gray-100">
                <li
                    v-for="project in projects"
                    :key="project.id"
                    class="flex justify-between py-2"
                >
                    <div>
                        {{ project.name }}
                    </div>
                    <div class="flex gap-x-2">
                        <SecondaryButton @click="editProject = project"
                            >Edit</SecondaryButton
                        >
                        <SecondaryButton @click="deleteProject(project)"
                            >Delete</SecondaryButton
                        >
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
