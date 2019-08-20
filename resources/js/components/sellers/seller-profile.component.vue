<template>
    <section v-if="!!seller">
        <h1>Perfil do vendedor</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link to="/">Sellers</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Perfil
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-12 col-lg">
                <h2 class="mb-0">
                    {{seller.name}} <i class="fa fa-pencil" id="btn-edit-seller" v-on:click="editSeller()" aria-hidden="true"></i>
                </h2>
                <p>{{seller.email}}</p>
            </div>

            <div class="col-12 col-lg-auto text-right">
                <p><strong>Comissão</strong> {{seller.commission}}</p>
            </div>
        </div>

        <order-list v-bind:seller_id="seller.id"></order-list>
        <seller-edit-modal ref="dialog"></seller-edit-modal>
    </section>
</template>

<script>
	import {SellerRepository} from './seller.repository';
	import Swal from 'sweetalert2';

	const repository = new SellerRepository;

	export default {
		created() {
            this.findOne (this.$route.params.id);
        },
		data() {
			return  {
				title: '',
				seller: null
			}
		},
		methods: {
			reload () {
				if (this.seller) {
					this.findOne(this.seller.id);
                }
            },
			findOne (seller_id) {

				if (!seller_id) {
					this.backToList();
					return;
                }

                repository
                    .findOne(seller_id)
                    .then(
                    	(seller) => {
                    		this.seller = seller;
                        },
                    	(args) => {
                    		let message = 'Ops! Ocorreu um erro inesperado';
							if (args.response && args.response.data && args.response.data.error) {
								message = args.response.data.error
                            }

                    		this.showMessage('', message).then(() => {
                    			this.backToList();
                            });
                        },
                    );
            },
            showMessage (title, message, type = 'info') {
				return Swal.fire(title, message, type)
            },
            backToList () {
				this.$router.push('/');
            },
			editSeller () {
				this.$refs.dialog.show(this.seller);
			}
        }
	}
</script>

<style>
    #btn-edit-seller{
        cursor:pointer;
        color: #3b3b3b;
    }
    #btn-edit-seller:hover{
        color: black;
    }
</style>