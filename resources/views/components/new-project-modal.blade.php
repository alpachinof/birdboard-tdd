<x-modal name="confirm-user-deletion" max-width="2xl" :show="true" focusable>
    <div x-data="newProject()" class="p-10 rounded-lg dark:text-white">
        <h1 class="font-normal mb-16 text-center text-2xl">Let's start something new</h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <label for="title" class="text-sm block mb-2">Title</label>

                        <input type="text" id="title" x-model="form.title"
                            class="border p-2 text-xs block w-full rounded dark:text-gray-800"
                            :class="errors.title ? 'border-red-400' : 'border-muted-light'">
                        <span class="text-xs italic text-red-400" x-show="errors.title" x-text="errors.title[0]"></span>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="text-sm block mb-2">Description</label>

                        <textarea type="text" id="description" rows="7" x-model="form.description"
                            class="border border-muted-light p-2 text-xs block w-full rounded dark:text-gray-800"></textarea>
                        <span class="text-xs italic text-red-400" x-show="errors.description"
                            x-text="errors.description[0]"></span>

                    </div>
                </div>

                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <label class="text-sm block mb-2">Need Some Tasks?</label>
                        <template x-for="task in form.tasks">
                            <input type="text" x-model="task.body"
                                class="border border-muted-light mb-2 p-2 text-xs block w-full rounded dark:text-gray-800">
                        </template>
                    </div>

                    <button type="button" @click.prevent="addTask" class="inline-flex items-center text-xs">

                        <span>Add new task field</span>
                    </button>
                </div>
            </div>

            <footer class="flex justify-end">
                <x-secondary-button class="mr-4" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <button class="button">Create Project</button>
            </footer>
        </form>
    </div>
</x-modal>

<script>
    function newProject() {
        return {
            form: {
                title: '',
                description: '',
                tasks: [{
                    body: 'fdfd'
                }],
            },
            errors: [],
            addTask() {
                this.form.tasks.push({
                    body: ''
                })
            },
            submit() {
                axios.post('/projects', this.form)
                    .then(response => {
                        location = response.data.message;
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    });
            }
        }
    }
</script>
