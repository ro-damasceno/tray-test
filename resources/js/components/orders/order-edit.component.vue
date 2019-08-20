<template>
    <section>
        <div class="modal fade" id="edit-order-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" v-if="!!order">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ order.id ? 'Atualizar cadastro' : 'Novo cadastro'}}
                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form v-on:submit="save($event)">
                            <div class="form-group">
                                <label for="name">Total</label>
                                <input
                                    class="form-control"
                                    v-bind:class="{'is-invalid': !!errors.total}"
                                    v-on:input="errors.total = null"
                                    v-on:keyup="moneyMask($event)"
                                    v-model="total"
                                    type="text"
                                    name="name"
                                    id="name"
                                    required="required"
                                    placeholder="R$ 99,99"
                                />
                                <div class="invalid-feedback" v-if="errors.total">
                                    <ul>
                                        <li v-for="error of errors.total">{{error}}</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex mt-4">
                                <button type="button" class="btn btn-danger" v-on:click="remove()" v-if="order.id">Deletar</button>
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
	import {OrderRepository} from "./order.repository";
	import {OrderModel} from "./order.model";

	const repository = new OrderRepository();

	export default {
		data() {
			return  {
				request: null,
				oldValues: null,
				order: null,
				total: null,
				errors: {
					total: null
				}
			}
		},
        props: ['seller_id'],
		methods: {
			moneyMask ($event) {
				$event.target.value = this.moneyFormat($event.target.value);
            },
			moneyFormat (n) {
				let value = +(n || '').replace(/\D/g, '') || 0;
				return (value > 0 ? value/100 : 0).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'})
            },
			computed () {
				this.resetErrors();
			},
			showMessage (title, message, type = 'info') {
				return Swal.fire(title, message, type)
			},
			show (order) {

				this.resetErrors();
				this.order = order instanceof OrderModel ? order : new OrderModel();
                this.total = this.moneyFormat(this.order.total);

				$('#edit-order-modal').modal('show');
			},
			close (saved) {

				$('#edit-order-modal').modal('hide');
				this.$emit('closed', {changed: saved});
			},
			resetErrors () {
				this.errors = {
					email: null
				};
			},
			save (evt) {

				if (this.request) {
					return;
				}

				let value = +this.total.toString().replace(/\D/g, '') || 0;
				if (value > 0) {
					value /= 100;
                }

				this.order.total     = value;
				this.order.seller_id = this.seller_id;

				evt.preventDefault();
				this.request = repository
					.save(this.order)
					.then(
						() => {
							let action = (this.order.id ? 'atualizado': 'adicionado');
							this.showMessage('', 'Pedido '+action+' com sucesso!', 'success').then(() => {
								this.close(true);
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
				if (this.order.id) {

					if (this.request) {
						return;
					}

					Swal
						.fire({
							text: 'Tem certeza que deseja remover este pedido?',
							type: 'question',
							showCancelButton: true,
							showConfirmButton: true,
							cancelButtonText: 'Não',
							confirmButtonText: 'Sim'
						})
						.then((data) => {
							if (data.value === true) {

								this.request = repository
									.delete(this.order.id)
									.then(
										() => {
											this.showMessage('', 'Pedido removido com sucesso!', 'success').then(() => {
												this.close(true);
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