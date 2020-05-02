<template>
    <modal name="new-project" classes="card p-10" height="auto">
        <h1 class="text-center text-2xl">Let's Start Something New!</h1>
        <form @submit.prevent="submit">
            <div class="mt-16 flex justify-between space-x-4">
                <div class="flex-1">
                    <div>
                        <label class="block text-sm" for="title">Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="form-input"
                            :class="errors.title ? 'border-red-600' : ''"
                            v-model="form.title"
                        />
                        <div v-if="errors.title">
                            <span
                                v-for="error in errors.title"
                                class="text-xs text-red-600 italic"
                                v-text="error"
                            />
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm" for="description"
                            >Description</label
                        >
                        <textarea
                            class="form-input"
                            name="description"
                            placeholder="title"
                            rows="7"
                            v-model="form.description"
                            :class="errors.description ? 'border-red-600' : ''"
                        ></textarea>
                        <div v-if="errors.description">
                            <span
                                v-for="error in errors.description"
                                class="text-xs text-red-600 italic"
                                v-text="error"
                            />
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div>
                        <label class="block text-sm">Need Some Tasks?</label>
                        <input
                            v-for="task in form.tasks"
                            v-model="task.body"
                            class="form-input mt-2"
                            type="text"
                            placeholder="task 1"
                        />
                    </div>
                    <button
                        class="mt-4 inline-flex items-center text-xs"
                        type="button"
                        @click="addTask"
                    >
                        <svg
                            class="stroke-current"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M12 9V12M12 12V15M12 12H15M12 12H9M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        <span class="ml-2">Add New Task Field</span>
                    </button>
                </div>
            </div>
            <footer class="mt-4 flex justify-end space-x-4">
                <button
                    type="button"
                    class="button is-outline"
                    @click="$modal.hide('new-project')"
                >
                    Cancel
                </button>
                <button class="button">
                    Create Project
                </button>
            </footer>
        </form>
    </modal>
</template>

<script>
export default {
    name: "NewProjectModal",
    data() {
        return {
            form: {
                title: "",
                description: "",
                tasks: [{ body: "" }]
            },
            errors: {}
        };
    },
    methods: {
        addTask() {
            this.form.tasks.push({ body: "" });
        },
        async submit() {
            try {
                location = (await axios.post("/projects", this.form)).data
                    .message;
            } catch (error) {
                this.errors = error.response.data.errors;
            }
        }
    }
};
</script>
