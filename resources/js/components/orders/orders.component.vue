<template>
    <section>
        <div class="d-flex align-items-center mb-3">
            <h3 class="flex-fill mb-0">Pedidos</h3>

            <button class="btn btn-success" v-on:click="newOrder()">Novo Pedido</button>
        </div>

        <div class="table-responsive" v-if="!!paginator">
            <table class="table table-striped" >
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Total</th>
                        <th>Comissão</th>
                        <th>Data</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="order of paginator.content()">
                        <td>{{order.id}}</td>
                        <td>{{order.totalFormatted}}</td>
                        <td>{{order.commissionFormatted}}</td>
                        <td>{{order.created_at | moment("DD/MM/YYYY HH:mm:ss")}}</td>
                        <td>
                            <i class="fa fa-pencil btn-edit" aria-hidden="true" v-on:click="editOrder(order)"></i>
                        </td>
                    </tr>
                </tbody>
            </table>

            <paginator-component v-on:paging="onPaging" v-bind:paginator="paginator && paginator.total > 0"></paginator-component>
        </div>

        <order-edit-modal v-on:closed="onCloseDialog" ref="dialog" v-bind:seller_id="seller_id"></order-edit-modal>
    </section>
</template>

<script>
	import {OrderRepository} from "./order.repository";

	const repository = new OrderRepository();

	export default {
		created() {
			this.page = this.$route.query.page || 1;
			this.find();
		},
        props: ['seller_id'],
		data() {
			return  {
				page: 1,
				per_page: 20,
                sort: 'created_at',
                sort_direction: 'desc',
				paginator: null
			}
		},
		methods: {
			onCloseDialog (data) {
				if (data && data.changed) {
					this.onPaging(1);

					console.log(this.$parent);
					if (this.$parent && typeof this.$parent.reload === 'function') {
						this.$parent.reload.call(this.$parent);
                    }
                }
            },
			onPaging(page) {
				this.page = page;
				this.find();

				this.updateRoute();
			},
			onSubmit ($event) {
				$event.preventDefault();
				this.page = 1;
				this.find();

				this.updateRoute();
			},
			find () {
				repository
					.read({
						seller_id: this.seller_id,
						page: this.page,
						per_page: this.per_page,
						sort: this.sort,
						sort_direction: this.sort_direction
					})
					.then((paginator) => {
						this.paginator = paginator;
					});
			},
            editOrder (order) {
				this.$refs.dialog.show(order);
            },
			newOrder () {
				this.$refs.dialog.show();
			},
			updateRoute () {
				let queries = {
					page: this.page
				};

				if (this.q) {
					queries.q = this.q;
				}
				this.$router.push({
					query: queries
				});
			}
		}
	}
</script>
<style>
    .btn-edit {
        color: #3c3c3c;
        cursor:pointer;
    }
    .btn-edit:hover {
        color: #2d2d2d;
    }
</style>