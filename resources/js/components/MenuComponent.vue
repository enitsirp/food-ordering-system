<template>
    <div class="container-fluid">

         <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Menus</h1>
            <b-button v-b-modal.menu-modal size="sm" variant="primary" class="d-none btn-primary d-sm-inline-block shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New Menu</b-button>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ menuName }}</h6>
            </div>
            <div class="card-body">
                <b-alert v-model="formStatus" v-bind:variant="formStatus ? 'success' : 'danger'" dismissible>
                    {{ formStatus ? successMessage : validationMassage }}
                </b-alert>

                <b-table id="menus-table"  striped responsive="sm" :fields="tableFields" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" sort-icon-left :items="menuItems" :per-page="perPage" :current-page="currentPage">
                    <template v-slot:cell(actions)="row">
                        <b-button size="sm" class="mr-2" variant="info" pill @click="showModal(row.item.menu, row.item.price, row.item.tax , row.item.id)">Edit</b-button>
                        <b-button size="sm" class="mr-2" variant="warning" pill @click="removeCategory(row.item.id)">Delete</b-button>
                    </template>
                </b-table>

            </div>
            <div class="card-footer text-muted">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="rows"
                    :per-page="perPage"
                    aria-controls="menus-table"
                    ></b-pagination>
            </div>
        </div>

        <b-modal id="menu-modal"  ref="modal" title="Menu Form"
            @show="resetModal"
            @ok="handleOk"
            >
            <form ref="menu-form" @submit.stop.prevent="handleSubmit">
                <b-form-group :state="menuState" label="Menu" label-for="menu-input"  invalid-feedback="Menu is required">
                    <b-form-input id="menu-input" v-model="menu" :state="menuState" required></b-form-input>
                </b-form-group>
                <b-form-group :state="priceState"  label="Price" label-for="price-input" invalid-feedback="Price is required">
                    <b-form-input id="price-input" type="number" min="0.00" v-model="price" placeholder="Menu price" :state="priceState" required></b-form-input>
                </b-form-group>
                <b-form-group :state="taxState" label="Tax"  label-for="tax-input" invalid-feedback="Tax is required">
                    <b-form-input id="tax-input" v-model="tax" placeholder="Menu tax"  type="number" min="0.00" :state="taxState" required></b-form-input>
                </b-form-group>
            </form>
        </b-modal>

    </div>


</template>

<script>
    export default {
        props: ['menus', 'category'],
        data() {
            return {
                menu: '',
                menuState: null,
                price: 0.00,
                priceState: null,
                tax: 0.00,
                taxState: null,
                formStatus: false,
                successMessage: "",
                validationMassage: "",
                formState: "Add",

                menuItems: this.menus,
                perPage: 10,
                currentPage: 1,
                tableFields: [
                        { key: 'menu', sortable: true },
                        { key: 'price', sortable: true },
                        { key: 'tax', sortable: true },
                        { key: 'actions', sortable: false },
                ],
                sortBy: 'menu',
                sortDesc: false,
                menuId: null,
                menuName: this.category.category
            }
        },
        methods: {
            checkFormValidity() {

                const valid = this.$refs['menu-form'].checkValidity()

                this.menuState = this.menu ? true : false;
                this.priceState = this.price ? true : false;
                this.taxState = this.tax ? true : false;

                return valid;
            },
            resetModal() {
                this.menu = ''
                this.menuState = null
                this.price = 0.00
                this.priceState = null
                this.tax = 0.00
                this.taxState = null
                this.formStatus = false
                this.successMessage = []
                this.validationMassage = []
                this.menuId = null;
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
                    axios.post('/admin/categories/'+this.category.id+'/menus/', {
                        menu: this.menu,
                        price: this.price,
                        tax: this.tax
                    })
                    .then((response) => {
                        this.formStatus = true;
                        this.successMessage= 'Successfully added new menu :'+ this.menu;
                    })
                    .catch((err) => {
                        this.formStatus = false;
                        this.validationMassage = err.response.data;
                    });
                }else{

                    axios({
                        method: 'put',
                         url: '/admin/categories/'+this.category.id+'/menus/'+this.menuId,
                        data: {
                            menu: this.menu,
                            price: this.price,
                            tax: this.tax
                        }
                    })
                    .then((response) => {
                        this.formStatus = true;
                        this.successMessage= 'Successfully updated menu :'+ this.menu;
                    })
                    .catch((err) => {
                        this.formStatus = false;
                        this.validationMassage = err.response.data;
                    });
                }


                // Hide the modal manually
                this.$nextTick(() => {
                    this.fetchMenus();
                    this.$refs.modal.hide();
                })
            },

            fetchMenus(){
                axios({
                    method: 'get',
                    url: '/admin/categories/'+this.category.id+'/menus/list',
                    })
                    .then((response) => {
                        this.menuItems = response.data;

                    });
            },

            showModal(menu, price, tax, id) {
                this.$refs['modal'].show()
                this.menu = menu;
                this.tax = tax;
                this.price = price;
                this.menuId = id;
                this.formState = "Edit";

            },

            removeCategory(id){

                this.$bvModal.msgBoxConfirm('Are you sure you want to delete this menu?')
                .then(value => {
                    if(value == true){
                        axios({
                            method: 'delete',
                            url: '/admin/categories/'+this.category.id+'/menus/'+id,
                        })
                        .then((response) => {
                            this.formStatus = true;
                            this.successMessage= 'Successfully deleted menu';
                            this.fetchMenus();
                        });


                    }
                })
                .catch(error => {
                   console.log(error);

                })
            }
        },
         mounted() {
            this.fetchMenus();
         },
        computed: {
            rows() {
                return this.menuItems.length
            }
        }
    }
</script>
