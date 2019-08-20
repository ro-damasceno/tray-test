<template>
    <section>
        <div class="modal fade" id="edit-seller-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" v-if="!!seller">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ seller.id ? 'Atualizar cadastro' : 'Novo cadastro'}}
                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="edit-seller-form" v-on:submit="save($event)">
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input
                                    class="form-control"
                                    v-bind:class="{'is-invalid': !!errors.name}"
                                    v-on:input="errors.name = null"
                                    v-model="seller.name"
                                    type="text"
                                    name="name"
                                    id="name"
                                    required="required"
                                />
                                <div class="invalid-feedback" v-if="errors.name">
                                    <ul>
                                        <li v-for="error of errors.name">{{error}}</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input
                                    class="form-control"
                                    v-bind:class="{'is-invalid': !!errors.email}"
                                    v-on:input="errors.email = null"
                                    v-model="seller.email"
                                    type="email"
                                    name="email"
                                    id="email"
                                    required="required"
                                />
                                <div class="invalid-feedback" v-if="errors.email">
                                    <ul>
                                        <li v-for="error of errors.email">{{error}}</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex mt-4">
                                <button type="button" class="btn btn-danger" v-on:click="remove()" v-if="seller.id">Deletar</button>
                                <button type="submit" class="btn btn-primary ml-auto" ref="btnSubmit">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
	import Swal from 'sweetalert2';
	import {SellerRepository} from './seller.repository';
	import {SellerModel} from "./seller.model";

	const repository = new SellerRepository;

	export default {
		data() {
			return  {
				request: null,
				oldValues: null,
                seller: null,
                errors: {
					email: null,
                    name: null
                }
			}
		},
		methods: {
			computed () {
				this.resetErrors();

				$('#edit-seller-modal').modal('hide.bs.modal', function(){
					this.seller.fill(this.oldValues);
                });
            },
			showMessage (title, message, type = 'info') {
				return Swal.fire(title, message, type)
			},
			show (seller) {
                this.seller    = seller instanceof SellerModel ? seller : new SellerModel();
                this.oldValues = this.seller.all();

				$('#edit-seller-modal').modal('show');
			},
			close () {
				$('#edit-seller-modal').modal('hide');
			},
            resetErrors () {
				this.errors = {
					email: null,
					name: null
				};
            },
			save (evt) {

				if (this.request) {
					return;
                }

				evt.preventDefault();
				this.request = repository
                    .save(this.seller)
					.then(
						() => {
							let action = (this.seller.id ? 'atualizado': 'adicionado');
							this.showMessage('', 'Vendedor '+action+' com sucesso!', 'success').then(() => {
								this.oldValues = this.seller.all();
								this.close();
							});
						},
						(args) => {
							let message = 'Ops! Ocorreu um erro inesperado';
							if (args.response && args.response.data) {
								if (args.response.data.error) {
									message = args.response.data.error
                                }
								if (args.response.data.fails) {
                                    this.errors = args.response.data.fails;
								}
							}

							this.showMessage('', message);
						},
					)
                    .finally(() => {
						this.request = null;
                    })
            },
			remove () {
				if (this.seller.id) {

					if (this.request) {
						return;
					}

					Swal
                        .fire({
                            text: 'Tem certeza que deseja remover este vendedor?',
                            type: 'question',
                            showCancelButton: true,
                            showConfirmButton: true,
                            cancelButtonText: 'Não',
                            confirmButtonText: 'Sim'
                        })
                        .then((data) => {
						    if (data.value === true) {

								this.request = repository
									.delete(this.seller.id)
									.then(
										() => {
											this.showMessage('', 'Vendedor removido com sucesso!', 'success').then(() => {
												this.close();
												this.$router.push('/');
											});
										},
										(args) => {
											let message = 'Ops! Ocorreu um erro inesperado';
											if (args.response && args.response.data && args.response.data.error) {
												message = args.response.data.error
											}
											this.showMessage('', message);
										},
									)
									.finally(() => {
										this.request = null;
									})
                            }
                        });
                }
            }
		}
	}
</script>