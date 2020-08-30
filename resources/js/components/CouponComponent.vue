<template>
    <div class="container-fluid">

         <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Coupons</h1>
            <b-button v-b-modal.coupon-modal size="sm" variant="primary" class="d-none btn-primary d-sm-inline-block shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New Coupons</b-button>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Coupons</h6>
            </div>
            <div class="card-body">
                <b-alert v-model="formStatus" v-bind:variant="formStatus ? 'success' : 'danger'" dismissible>
                    {{ formStatus ? successMessage : validationMassage }}
                </b-alert>

                <b-table id="coupons-table"  striped responsive="sm" :fields="tableFields" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" sort-icon-left :items="coupons" :per-page="perPage" :current-page="currentPage">
                    <template v-slot:cell(actions)="row">
                        <b-button size="sm" class="mr-2" variant="info" pill @click="showModal(row.item.code, row.item.percent , row.item.id)">Edit</b-button>
                        <b-button size="sm" class="mr-2" variant="warning" pill @click="removeCoupon(row.item.id)">Delete</b-button>
                    </template>
                </b-table>

            </div>
            <div class="card-footer text-muted">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="rows"
                    :per-page="perPage"
                    aria-controls="coupons-table"
                    ></b-pagination>
            </div>
        </div>

        <b-modal id="coupon-modal"  ref="modal" title="Coupon Form"
            @show="resetModal"
            @ok="handleOk"
            >
            <form ref="coupon-form" @submit.stop.prevent="handleSubmit">
                <b-form-group :state="couponState" label="Coupon Code" label-for="coupon-input"  invalid-feedback="Coupon is required">
                    <b-form-input id="coupon-input" v-model="coupon" :state="couponState" required></b-form-input>
                </b-form-group>
                <b-form-group :state="percentState" label="Percent" label-for="percent-input" invalid-feedback="Percent is required">
                    <b-form-input id="percent-input" v-model="percent" placeholder="Coupon percent" type="number" min="0.00" :state="percentState" required></b-form-input>
                </b-form-group>
            </form>
        </b-modal>

    </div>


</template>

<script>
    export default {
        data() {
            return {
                coupon: '',
                couponState: null,
                percent: '',
                percentState: null,
                formStatus: false,
                successMessage: "",
                validationMassage:"",
                formState: "Add",

                coupons: [],
                perPage: 10,
                currentPage: 1,
                tableFields: [
                        { key: 'code', sortable: true },
                        { key: 'percent', sortable: true },
                        { key: 'actions', sortable: false },
                ],
                sortBy: 'code',
                sortDesc: false,
                couponId: null,
            }
        },
        methods: {
            checkFormValidity() {

                const valid = this.$refs['coupon-form'].checkValidity()

                this.couponState = this.coupon ? true : false;
                this.percentState = this.percent ? true : false;

                return valid;
            },
            resetModal() {
                this.coupon = ''
                this.couponState = null
                this.percent = ''
                this.percentState = null
                this.formStatus = false
                this.successMessage = []
                this.validationMassage = ""
                this.couponId = null;
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
                    axios.post('/admin/coupons', {
                        code: this.coupon,
                        percent: this.percent
                    })
                    .then((response) => {
                        this.formStatus = true;
                        this.successMessage= 'Successfully added new Coupon :'+ this.coupon;
                    })
                    .catch((err) => {
                        this.formStatus = false;
                        this.validationMassage = err.response.data;
                    });
                }else{

                    axios({
                        method: 'put',
                        url: '/admin/coupons/'+this.couponId,
                        data: {
                            code: this.coupon,
                            percent: this.percent
                        }
                    })
                    .then((response) => {
                        this.formStatus = true;
                        this.successMessage= 'Successfully updated coupon :'+ this.coupon;
                    })
                    .catch((err) => {
                        this.formStatus = false;
                        this.validationMassage = err.response.data;
                    });
                }


                // Hide the modal manually
                this.$nextTick(() => {
                    this.fetchCoupons();
                    this.$refs.modal.hide();
                })
            },

            fetchCoupons(){
                axios({
                    method: 'get',
                    url: '/admin/coupons/list',
                    })
                    .then((response) => {
                        this.coupons = response.data;

                    });
            },

            showModal(coupon, percent, id) {
                this.$refs['modal'].show()
                this.coupon = coupon;
                this.percent = percent;
                this.couponId = id;
                this.formState = "Edit";

            },

            removeCoupon(id){

                this.$bvModal.msgBoxConfirm('Are you sure you want to delete this coupon?')
                .then(value => {
                    if(value == true){
                        axios({
                            method: 'delete',
                            url: '/admin/coupons/'+id,
                        })
                        .then((response) => {
                            this.formStatus = true;
                            this.successMessage= 'Successfully deleted coupon';
                            this.fetchCoupons();
                        });


                    }
                })
                .catch(error => {
                    this.formStatus = false;
                    this.validationMassage = "Something went wrong";
                   console.log(error);

                })
            }
        },
         mounted() {
            this.fetchCoupons();
         },
        computed: {
            rows() {
                return this.coupons.length
            }
        }
    }
</script>
