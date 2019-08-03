<template>
  <b-container fluid>
    <!-- User Interface controls -->
    <b-row>
        <b-col md="12" class="my-1">
            <b-form-group label-cols-sm="2" label="Create Task" class="mb-0">
                <b-input-group>
                <b-form-input v-model="newTask" placeholder="Create a new task"></b-form-input>
                <b-input-group-append>
                    <b-button :disabled="!newTask" @click="addTask()" variant="primary"
                           plain>Create a new task</b-button>
                </b-input-group-append>
                </b-input-group>
            </b-form-group>
        </b-col>

        <b-col md="6" class="my-1">
            <b-form-group label-cols-sm="3" label="Filter" class="mb-0">
                <b-input-group>
                <b-form-input v-model="filter" placeholder="Type to Search"></b-form-input>
                <b-input-group-append>
                    <b-button :disabled="!filter" @click="filter = ''" variant="dark">Clear</b-button>
                </b-input-group-append>
                </b-input-group>
            </b-form-group>
        </b-col>

        <b-col md="6" class="my-1">
            <b-form-group label-cols-sm="3" label="Sort" class="mb-0">
                <b-input-group>
                <b-form-select v-model="sortBy" :options="sortOptions">
                    <option slot="first" :value="null">-- none --</option>
                </b-form-select>
                <b-form-select v-model="sortDesc" :disabled="!sortBy" slot="append">
                    <option :value="false">Asc</option> <option :value="true">Desc</option>
                </b-form-select>
                </b-input-group>
            </b-form-group>
        </b-col>
    </b-row>

    <!-- Main table element -->
    <b-table
      show-empty
      stacked="md"
      :items="tasks"
      :fields="fields"
      :filter="filter"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      :sort-direction="sortDirection"
      @filtered="onFiltered"
    >

        <template slot="operations" slot-scope="row">
            <b-button size="sm" @click="markTaskDone(row.item.id)" class="mr-1" variant="success" v-if="!row.item.finished_at" plain>
                Done
            </b-button>
            <b-button size="sm" @click="markTaskUndone(row.item.id)" class="mr-1" variant="warning" v-if="row.item.finished_at" plain>
                Undone
            </b-button>
            <b-button size="sm" @click="deleteTask(row.item.id)" class="mr-1" variant="danger">
                Delete
            </b-button>
        </template>
    </b-table>
  </b-container>
</template>

<script>
  export default {
    data() {
      return {
        newTask: '',
        tasks: [],
        fields: [
          { key: 'name', label: 'Task Name', sortable: true, sortDirection: 'desc', class: 'text-center' },
          { key: 'created_at', label: 'Created time', sortable: true, class: 'text-center' },
          { key: 'updated_at', label: 'Updated time', sortable: true, class: 'text-center' },
          { key: 'operations', label: 'Operations' }
        ],
        totalRows: 1,
        sortBy: null,
        sortDesc: false,
        sortDirection: 'asc',
        filter: null
      }
    },
    mounted() {
        this.getTasks();
        // Set the initial number of tasks
        this.totalRows = this.tasks.length
    },
    computed: {
      sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
          })
      }
    },
    methods: {
        getTasks() {
            axios.get('/tasks/index')
                .then(response => {
                    this.tasks = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        addTask() {
            axios.post('/tasks/store', {name: this.newTask})
                .then(response => {
                    this.tasks = response.data;
                    this.newTask = '';
                })
                .catch(error => {
                    console.log(error);
                });
        },
        deleteTask(id) {
            axios.delete('/tasks/delete/' + id)
                .then(response => {
                    this.tasks = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        markTaskDone(id) {
            axios.put('/tasks/mark/' + id + '/done/')
                .then(response => {
                    this.tasks = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        markTaskUndone(id) {
            axios.put('/tasks/mark/' + id + '/undone/')
                .then(response => {
                    this.tasks = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
        }
    }
  }
</script>