<template>
    <div class="container-fluid">

         <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Menus</h1>
            <b-button v-b-modal.category-modal size="sm" variant="primary" class="d-none btn-primary d-sm-inline-block shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New Menu Category</b-button>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Menu Categories</h6>
            </div>
            <div class="card-body">
                <b-alert v-model="formStatus" v-bind:variant="formStatus ? 'success' : 'danger'" dismissible>
                     {{ formStatus ? successMessage : validationMassage }}
                </b-alert>

                <b-table id="categories-table"  striped responsive="sm" :fields="tableFields" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" sort-icon-left :items="categories" :per-page="perPage" :current-page="currentPage">
                    <template v-slot:cell(actions)="row">

                        <b-button size="sm" class="mr-2" variant="primary" pill v-bind:href="'/admin/categories/'+row.item.id+'/menus'" >Menus</b-button>
                        <b-button size="sm" class="mr-2" variant="info" pill @click="showModal(row.item.category, row.item.description , row.item.id)">Edit</b-button>
                        <b-button size="sm" class="mr-2" variant="warning" pill @click="removeCategory(row.item.id)">Delete</b-button>
                    </template>
                </b-table>

            </div>
            <div class="card-footer text-muted">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="rows"
                    :per-page="perPage"
                    aria-controls="categories-table"
                    ></b-pagination>
            </div>
        </div>

        <b-modal id="category-modal"  ref="modal" title="Menu Category Form"
            @show="resetModal"
            @ok="handleOk"
            >
            <form ref="category-form" @submit.stop.prevent="handleSubmit">
                <b-form-group :state="categoryState" label="Category" label-for="category-input"  invalid-feedback="Category is required">
                    <b-form-input id="category-input" v-model="category" :state="categoryState" required></b-form-input>
                </b-form-group>
                <b-form-group :state="descriptionState" label="Description" label-for="description-input">
                    <b-form-input id="description-input" v-model="description" placeholder="Category description" :state="descriptionState"></b-form-input>
                </b-form-group>
            </form>
        </b-modal>

    </div>


</template>

<script>
    export default {
        data() {
            return {
                category: '',
                categoryState: null,
                description: '',
                descriptionState: null,
                formStatus: false,
                successMessage: "",
                validationMassage: "",
                formState: "Add",
                categories: [],
                perPage: 10,
                currentPage: 1,
                tableFields: [
                        { key: 'category', sortable: true },
                        { key: 'description', sortable: true },
                        { key: 'actions', sortable: false },
                ],
                sortBy: 'category',
                sortDesc: false,
                categoryId: null,
            }
        },
        methods: {
            checkFormValidity() {

                const valid = this.$refs['category-form'].checkValidity()

                this.categoryState = this.category ? true : false;
                this.descriptionState = true;

                return valid;
            },
            resetModal() {
                this.category = ''
                this.categoryState = null
                this.description = ''
                this.descriptionState = null
                this.formStatus = false
                this.successMessage = []
                this.validationMassage = []
                this.categoryId = null;
                this.formState = "Add";
            },
             handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.handleSubmit()
            },
            handleSubmit() {
                // Exit when the form isn't valid
                if (!this.checkFormValidity()) {
                return
                }

                if (this.formState == 'Add') {
                    axios.post('/admin/categories', {
                        category: this.category,
                        description: this.description
                    })
                    .then((response) => {
                        this.formStatus = true;
                        this.successMessage= 'Successfully added new menu category :'+ this.category;
                    })
                    .catch((err) => {
                        this.formStatus = false;
                        this.validationMassage = err.response.data;
                    });
                }else{

                    axios({
                        method: 'put',
                        url: '/admin/categories/'+this.categoryId,
                        data: {
                            category: this.category,
                            description: this.description
                        }
                    })
                    .then((response) => {
                        this.formStatus = true;
                        this.successMessage= 'Successfully updated menu category :'+ this.category;
                    })
                    .catch((err) => {
                        this.formStatus = false;
                        this.validationMassage = err.response.data;
                    });
                }


                // Hide the modal manually
                this.$nextTick(() => {
                    this.fetchCategories();
                    this.$refs.modal.hide();
                })
            },

            fetchCategories(){
                axios({
                    method: 'get',
                    url: '/admin/categories/list',
                    })
                    .then((response) => {
                        this.categories = response.data;

                    });
            },

            showModal(category, description, id) {
                this.$refs['modal'].show()
                this.category = category;
                this.description = description;
                this.categoryId = id;
                this.formState = "Edit";

            },

            removeCategory(id){

                this.$bvModal.msgBoxConfirm('Are you sure you want to delete this menu category?')
                .then(value => {
                    if(value == true){
                        axios({
                            method: 'delete',
                            url: '/admin/categories/'+id,
                        })
                        .then((response) => {
                            this.formStatus = true;
                            this.successMessage= 'Successfully deleted menu category';
                            this.fetchCategories();
                        });


                    }
                })
                .catch(error => {
                   console.log(error);

                })
            }
        },
         mounted() {
            this.fetchCategories();
         },
        computed: {
            rows() {
                return this.categories.length
            }
        }
    }
</script>
