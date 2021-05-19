<template>
    <div class="flex items-center justify-center h-screen overflow-hidden">
        <div class="border-2 rounded-lg border-gray-400 w-2/4">
            <div class="p-8">
                <h1 class="font-semibold text-2xl">Gestor de Tareas</h1>
                <hr />
                <div class="mt-8">
                    <form class="w-full" @submit.prevent>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
                                <input
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name" type="text" placeholder="Nueva Tarea" v-model="newTask.name" />
                            </div>
                            <div class="w-full md:w-7/12 px-3 text-center">
                                <div v-if="categories.length">
                                    <div class="mt-2">
                                        <label class="inline-flex items-center ml-4" v-for="category in categories">
                                            <input type="checkbox" v-model="newTask.categories" :value="category.id" />
                                            <span class="ml-2">{{category.name}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div v-else>
                                    <span>Cargando..</span>
                                </div>
                            </div>
                            <div class="w-full md:w-2/12 px-3">
                                <button
                                    class="bg-blue-400 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                                    @click="saveTask()">
                                    Añadir
                                </button>
                            </div>
                        </div>

                        <table class="min-w-max w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Tarea</th>
                                    <th class="py-3 px-6 text-left">Categorias</th>
                                    <th class="py-3 px-6 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light" v-if="tasks.length">
                                <tr class="border-b border-gray-200 bg-gray-50 hover:bg-gray-100"
                                v-for="task in tasks">
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{task.name}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <span v-for="category in task.categories" class="mx-2 bg-green-400 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded">{{category.name}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                                @click="deleteTask(task.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tasks: [],
                categories: [],
                newTask: {
                    name: '',
                    categories: []
                },
            }
        },
        created() {
            // Get tasks from Backend
            axios.get('/tasks').then(res => {
                this.tasks = res.data;
            })

            // Get categories from Backend
            axios.get('/categories').then(res => {
                this.categories = res.data;
            })
        },
        methods: {
            toggleSelectedCategory(category) {
                if (!this.checkedCategories.includes(category)) {
                    this.checkedCategories.push(category);
                } else {
                    this.checkedCategories.pop(category);
                }
            },
            saveTask() {
                axios.post('/tasks', this.newTask)
                    .then((res) => {
                        this.tasks.push(res.data.data);
                    })
            },
            deleteTask(id) {
                axios.delete(`/tasks/${id}`)
                    .then((res) => {
                        if (res.data.status === 200){
                            this.tasks.pop(res.data);
                        } 
                    })
            }
        }
    };

</script>
